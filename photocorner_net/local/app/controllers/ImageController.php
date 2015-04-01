<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
use Fotokutak\Repository\FavoriteRepositoryInterface;
use Fotokutak\Repository\ImagesRepositoryInterfaceInterface;
use Fotokutak\Validator\ImageValidator;

class ImageController extends BaseController {

    /**
     * @param ImagesRepositoryInterfaceInterface $image
     * @param ImageValidator                     $validator
     * @param FavoriteRepositoryInterface        $favorite
     */
    public function __construct(ImagesRepositoryInterfaceInterface $image, ImageValidator $validator, FavoriteRepositoryInterface $favorite)
    {
        $this->image = $image;
        $this->validator = $validator;
        $this->favorite = $favorite;
    }

    /**
     * Display all details of image with it's comments
     * and replies send it view file.
     *
     * @param      $id
     * @param null $slug
     * @return mixed
     */
    public function getIndex($id, $slug = null)
    {
        $image = $this->image->getById($id);

        if ( ! $image)
        {
            return Redirect::route('home');
        }


        if (empty($slug) || $slug != $image->slug)
        {
            return Redirect::route('image', ['id' => $image->id, 'slug' => $image->slug]);
        }

        if ($image->approved_at == null)
        {
            return Redirect::route('home');
        }

        Event::fire('image.views', $image);

        $comments = $image->comments()->with('user', 'reply')->orderBy('created_at', 'desc')->paginate(10);

        $previous = $this->image->findPreviousImage($image);
        $next = $this->image->findNextImage($image);
        $title = ucfirst($image->title);

        return View::make('image/index', compact('image', 'comments', 'previous', 'next', 'title'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        if ($this->image->delete($id))
        {
            return Redirect::route('gallery')->with('flashSuccess', t('Image is deleted permanently'));
        }

        return Redirect::route('gallery')->with('flashError', t('You are not allowed to download this image'));
    }

    /**
     * @param      $id
     * @param null $slug
     * @return mixed
     */
    public function getEdit($id, $slug = null)
    {
        $image = $this->image->getById($id);

        // If image does not exist then return to base url
        if ( ! $image || Auth::user()->id !== $image->user_id)
        {
            return Redirect::route('home');
        }

        // If image slug is empty or slug is not correct
        // Then redirect to image page with correct slug
        if (empty($slug) || $slug != $image->slug)
        {
            return Redirect::route('image', ['id' => $image->id, 'slug' => $image->slug]);
        }

        // If image is not approved then return to base url
        if ($image->approved_at == null)
        {
            return Redirect::route('home');
        }

        $title = ucfirst($image->title);

        return View::make('image/edit', compact('image', 'title'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function postEdit($id)
    {
        if ( ! $this->validator->validUpdate(Input::all()))
        {
            return Redirect::back()->withErrors($this->validator->errors());
        }

        if (Category::where('id', '=', Input::get('category'))->count() != 1)
        {
            return Redirect::back()->with('flashError', t('Invalid category'));
        }

        $image = $this->image->getById($id);
        // If image does not exist then return to base url
        if ( ! $image || Auth::user()->id !== $image->user_id)
        {
            return Redirect::route('home');
        }

        $data = [
            'title'       => Input::get('title'),
            'description' => Input::get('description'),
            'category'    => Input::get('category'),
            'tags'        => Input::get('tags')
        ];
        $image = $this->image->update($data, $id);

        return Redirect::route('image', ['id' => $image->id, 'slug' => $image->slug])->with('flashSuccess', t('Image is now updated'));
    }

    /**
     * @param        $id
     * @return mixed
     */
    public function download($id)
    {
        $id = Crypt::decrypt($id);
        $image = $this->image->getById($id);

        if ( ! $image)
        {
            return Redirect::to('gallery')->with('flashError', t('You are not allowed to download this image'));
        }
        if (siteSettings('allowDownloadOriginal') == 'leaveToUser' AND $image->allow_download != 1)
        {
            return Redirect::to('gallery')->with('flashError', t('You are not allowed to download this image'));
        }
        if (Auth::user()->id != $image->user_id)
        {
            $image->downloads = $image->downloads + 1;
            $image->save();
        }

        return Response::download('uploads/' . $image->image_name . '.' . $image->type, $image->slug . '.' . $image->type, ['content-type' => 'image/jpg']);
    }

    /**
     * @return string
     */
    public function postFavorite()
    {
        if (Auth::check() == false)
        {
            return 'Login First';
        }

        if ( ! $this->validator->validFavorite(Input::all()))
        {
            return t('Not Allowed');
        }

        return $this->favorite->favorite(Input::get('id'));
    }

    /**
     * @return mixed
     */
    public function search()
    {
        $search = Input::get('q');
        if (empty($search))
        {
            return Redirect::route('gallery');
        }

        $images = $this->image->search(Input::get('q'), Input::get('category'), Input::get('timeframe'));

        $title = t('Searching for') . ' "' . ucfirst($search) . '"';

        return View::make('gallery/index', compact('title', 'images'));
    }
}
