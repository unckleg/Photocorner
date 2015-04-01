<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
use Fotokutak\Repository\ImagesRepositoryInterfaceInterface;

class TagsController extends BaseController {

    /**
     * @param ImagesRepositoryInterfaceInterface $images
     */
    public function __construct(ImagesRepositoryInterfaceInterface $images)
    {
        $this->images = $images;
    }

    /**
     * @param $tag
     * @return mixed
     */
    public function getIndex($tag)
    {
        $images = $this->images->getByTags($tag);
        $title = t('Tagged with') . ' ' . ucfirst($tag);

        return View::make('gallery/index', compact('images', 'title'));
    }

    /**
     * @param $tag
     * @return mixed
     */
    public function getRss($tag)
    {

        $images = $this->images->getByTags($tag);
        $feed = Feed::make();
        $feed->title = siteSettings('siteName') . '/tag/' . $tag;
        $feed->description = siteSettings('siteName') . '/tag/' . $tag;
        $feed->link = URL::to('tag/' . $tag);
        $feed->lang = 'en';
        foreach ($images as $post)
        {
            // set item's title, author, url, pubdate and description
            $desc = '<a href="' . route('image', ['id' => $post->id, 'slug' => $post->slug]) . '"><img src="' . asset(cropResize('uploads/' . $post->image_name . '.' . $post->type)) . '" /></a><br/><br/>
                <h2><a href="' . route('image', ['id' => $post->id, 'slug' => $post->slug]) . '">' . e($post->title) . '</a>
                by
                <a href="' . route('user', ['username' => $post->user->username]) . '">' . ucfirst($post->user->fullname) . '</a>
                ( <a href="' . route('user', ['username' => $post->user->username]) . '">' . $post->user->username . '</a> )
                </h2>' . $post->image_description;
            $feed->add(ucfirst(e($post->title)), $post->user->fullname, route('image', ['id' => $post->id, 'slug' => $post->slug]), $post->created_at, $desc);
        }

        return $feed->render('atom');

    }

}