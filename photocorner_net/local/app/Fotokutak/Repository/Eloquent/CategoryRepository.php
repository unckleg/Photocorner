<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
namespace Fotokutak\Repository\Eloquent;

use Fotokutak\Repository\CategoryRepositoryInterface;
use Fotokutak\Repository\ImagesRepository;
use Fotokutak\Repository\ImagesRepositoryInterfaceInterface;
use Category;
use Illuminate\Support\Facades\URL;
use Roumen\Feed\Facades\Feed;

class CategoryRepository implements CategoryRepositoryInterface {

    /**
     * @var \Category
     */
    protected $model;

    public function  __construct(Category $model, ImagesRepositoryInterfaceInterface $images)
    {

        $this->model = $model;
        $this->images = $images;
    }

    public function getBySlug($slug)
    {
        $category = $this->model->whereSlug($slug)->first();
        if ( ! $category)
        {
            return false;
        }

        return $category;
    }

    public function getRss(Category $category)
    {
        $images = $this->images->getLatest($category->slug, 60);
        $feed = Feed::make();
        $feed->title = siteSettings('siteName') . '/category/' . $category->name;
        $feed->description = siteSettings('siteName') . '/category/' . $category->name;
        $feed->link = URL::to('category/' . $category->slug);
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