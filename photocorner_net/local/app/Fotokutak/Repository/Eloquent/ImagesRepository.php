<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
namespace Fotokutak\Repository\Eloquent;

use Fotokutak\Notifier\ImageNotifer;
use Fotokutak\Repository\FavoriteRepositoryInterface;
use Fotokutak\Repository\ImagesRepositoryInterfaceInterface;
use Auth;
use Cache;
use Carbon\Carbon;
use Category;
use DB;
use File;
use Images;
use Str;

class ImagesRepository implements ImagesRepositoryInterfaceInterface {

    /**
     * @param Images                      $images
     * @param ImageNotifer                $notice
     * @param Category                    $category
     * @param FavoriteRepositoryInterface $favorite
     */
    public function __construct(Images $images, ImageNotifer $notice, Category $category, FavoriteRepositoryInterface $favorite)
    {
        $this->model = $images;
        $this->category = $category;
        $this->notification = $notice;
        $this->favorite = $favorite;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->posts()->where('id', $id)->with('user', 'comments', 'comments.reply', 'favorite', 'info')->first();
    }

    /**
     * @param null $category
     * @param null $timeframe
     * @return Post
     */
    private function posts($category = null, $timeframe = null)
    {
        $posts = $this->model->approved();

        if ($category)
        {
            $cat = $this->category->whereSlug($category)->first();
            if ($cat)
            {
                $posts = $posts->whereCategoryId($cat->id);
            }

        }
        if ($this->resolveTime($timeframe))
        {
            $posts = $posts->whereBetween('approved_at', $this->resolveTime($timeframe));
        }

        return $posts;
    }

    /**
     * @param $time
     * @return string
     */
    private function resolveTime($time)
    {
        $final = null;
        switch ($time)
        {
            case "today":
                $final = Carbon::now()->subHours(24)->toDateTimeString();
                break;
            case "week":
                $final = Carbon::now()->subDays(7)->toDateTimeString();
                break;
            case "month":
                $final = Carbon::now()->subDays(30)->toDateTimeString();
                break;
            case "year":
                $final = Carbon::now()->subDays(365)->toDateTimeString();
                break;
            default:
                $final = null;
        }
        if ( ! $final)
        {
            $time = null;
        } else
        {
            $time = [$final, Carbon::now()->toDateTimeString()];
        }

        return $time;
    }

    /**
     * @param null $category
     * @param null $timeframe
     * @param null $limit
     * @return mixed
     */
    public function getLatest($category = null, $timeframe = null, $limit = null)
    {
        $image = $this->posts($category, $timeframe)->orderBy('approved_at', 'desc')->with('user', 'comments', 'favorite');
        if ( ! $limit)
        {
            return $image->paginate(perPage());
        }
        if ($limit)
        {
            return $image->take($limit)->get();
        }
    }

    /**
     * @param null $category
     * @param null $timeframe
     * @param null $limit
     * @return mixed
     */
    public function getFeatured($category = null, $timeframe = null, $limit = null)
    {
        $image = $this->posts($category, $timeframe)->whereNotNull('featured_at')->orderBy('featured_at', 'dec')->with('user', 'comments', 'favorite');
        if ( ! $limit)
        {
            return $image->paginate(perPage());
        }
        if ($limit)
        {
            return $image->take($limit)->get();
        }
    }

    /**
     * @param array $input
     * @param       $id
     * @return mixed
     */
    public function update(array $input, $id)
    {
        $parts = explode(',', $input['tags'], siteSettings('tagsLimit'));
        $tags = implode(',', array_map('strtolower', $parts));
        $slug = @Str::slug($input['title']);
        if ( ! $slug)
        {
            $slug = Str::random(8);
        }
        $image = $this->model->where('id', '=', $id)->first();
        $image->title = $input['title'];
        $image->slug = $slug;
        $image->image_description = $input['description'];
        $image->category_id = $input['category'];
        $image->tags = $tags;
        $image->save();

        return $image;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $image = $this->model->where('id', '=', $id)->first();
        if ( ! $image)
        {
            return false;
        }
        if ($image->user->id == Auth::user()->id)
        {
            File::delete('uploads/' . $image->image_name . '.' . $image->type);
            $image->favorite()->delete();
            $comments = $image->comments()->get();
            foreach ($comments as $comment)
            {
                $comment->reply()->delete();
                $comment->delete();
            }
            $image->info()->delete();
            $image->delete();
            Cache::forget('moreFromSite');

            return true;
        }
    }

    /**
     * @param      $tag
     * @param null $limit
     * @return mixed
     */
    public function getByTags($tag, $limit = null)
    {
        $images = $this->posts()->where('tags', 'LIKE', '%' . $tag . '%')->orderBy('approved_at', 'desc')->with('user');
        if ( ! $limit)
        {
            return $images->paginate(perPage());
        }

        return $images->get();
    }

    /**
     * @param $image
     * @return mixed
     */
    public function incrementViews($image)
    {
        $image->views = $image->views + 1;
        $image->save();

        return $image;
    }

    /**
     * @param null $category
     * @param null $timeframe
     * @param string $orderBy
     * @return mixed
     */
    public function mostCommented($category = null, $timeframe = null, $orderBy = 'desc')
    {
        $images = $this->posts($category, $timeframe)->with('user', 'comments', 'favorite')->approved()->join('comments', 'comments.image_id', '=', 'images.id')
            ->select('images.*', DB::raw('count(comments.image_id) as cmts'))
            ->groupBy('images.id')->with('user', 'comments', 'favorite')->orderBy('cmts', $orderBy)
            ->paginate(perPage());;

        return $images;
    }

    /**
     * @param null $category
     * @param null $timeframe
     * @param string $oderBy
     * @return mixed
     */
    public function popular($category = null, $timeframe = null, $oderBy = 'desc')
    {
        $images = $this->posts($category, $timeframe)
            ->leftJoin('comments', 'comments.image_id', '=', 'images.id')
            ->leftJoin('favorite', 'favorite.image_id', '=', 'images.id')
            ->select('images.*', DB::raw('count(comments.image_id)*5 + images.views as popular'))
            ->groupBy('images.id')->with('user', 'comments', 'favorite')->orderBy('popular', $oderBy)
            ->paginate(perPage());

        return $images;
    }

    /**
     * @param null $category
     * @param null $timeframe
     * @param string $oderBy
     * @return mixed
     */
    public function mostFavorited($category = null, $timeframe = null, $oderBy = 'desc')
    {
        $images = $this->posts($category, $timeframe)->join('favorite', 'favorite.image_id', '=', 'images.id')
            ->select('images.*', DB::raw('count(favorite.image_id) as favs'))
            ->groupBy('images.id')->with('user', 'comments', 'favorite')->orderBy('favs', $oderBy)
            ->paginate(perPage());

        return $images;
    }

    /**
     * @param null $category
     * @param null $timeframe
     * @param string $oderBy
     * @return mixed
     */
    public function mostDownloaded($category = null, $timeframe = null, $oderBy = 'desc')
    {
        $images = $this->posts($category, $timeframe)->orderBy('downloads', $oderBy)->with('user', 'comments', 'favorite')->paginate(perPage());

        return $images;
    }

    /**
     * @param null $category
     * @param null $timeframe
     * @param string $orderBy
     * @return mixed
     */
    public function mostViewed($category = null, $timeframe = null, $orderBy = 'desc')
    {
        $images = $this->posts($category, $timeframe)->orderBy('views', $orderBy)->with('user', 'comments', 'favorite')->paginate(perPage());

        return $images;
    }

    /**
     * @param $search
     * @param null $category
     * @param null $timeframe
     * @return mixed
     */
    public function search($search, $category = null, $timeframe = null)
    {
        $extends = explode(' ', $search);
        if ($category)
        {
            $categoryId = $this->category->whereSlug($category)->first();
        }
        $images = $this->posts($category, $timeframe)->where('title', 'LIKE', '%' . $search . '%')
            ->orWhere('tags', 'LIKE', '%' . $search . '%')
            ->whereNull('deleted_at')->whereNotNull('approved_at')->orderBy('approved_at', 'desc');

        foreach ($extends as $extend)
        {
            if (isset($categoryId))
            {
                $images->whereCategoryId($categoryId)->Where('tags', 'LIKE', '%' . $extend . '%')->whereNotNull('approved_at')->whereNull('deleted_at')
                    ->whereCategoryId($categoryId)->orWhere('title', 'LIKE', '%' . $search . '%')->whereNotNull('approved_at')->whereNull('deleted_at')
                    ->whereCategoryId($categoryId)->orWhere('image_description', 'LIKE', '%' . $search . '%')->whereNotNull('approved_at')->whereNull('deleted_at');
            } else
            {
                $images->orWhere('tags', 'LIKE', '%' . $extend . '%')->whereNotNull('approved_at')->whereNull('deleted_at')
                    ->orWhere('title', 'LIKE', '%' . $search . '%')->whereNotNull('approved_at')->whereNull('deleted_at')
                    ->orWhere('image_description', 'LIKE', '%' . $search . '%')->whereNotNull('approved_at')->whereNull('deleted_at');
            }
        }

        return $images = $images->with('user', 'comments', 'favorite')->whereNotNull('approved_at')->whereNull('deleted_at')->paginate(perPage());
    }

    /**
     * @param Images $image
     * @return mixed
     */
    public function findNextImage(Images $image)
    {
        $next = $this->posts()->where('approved_at', '>=', $image->approved_at)
            ->where('id', '<>', $image->id)
            ->orderBy('approved_at', 'asc')
            ->first(['id', 'slug', 'title']);

        return $next;
    }

    /**
     * @param Images $image
     * @return mixed
     */
    public function findPreviousImage(Images $image)
    {
        $prev = $this->posts()->where('approved_at', '<=', $image->approved_at)
            ->where('id', '<>', $image->id)
            ->orderBy('approved_at', 'desc')
            ->first(['id', 'slug', 'title']);

        return $prev;
    }

    /**
     * @return string
     */
    public function postFavorite()
    {
        if (Auth::check() == false)
        {
            return t('Login First');
        }


        if ( ! $this->validator->validFavorite(Input::all()))
        {
            return t('Not Allowed');
        }

        return $this->favorite->favorite(Input::get('id'));
    }
}