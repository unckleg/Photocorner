<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
use Fotokutak\Repository\BlogsRepositoryInterface;

class BlogsController extends BaseController {

    public function __construct(BlogsRepositoryInterface $blogs)
    {
        $this->blogs = $blogs;
    }

    public function getIndex()
    {
        $blogs = $this->blogs->getLatestBlogs(5);
        $title = t('All Blogs');

        return View::make('blogs/list', compact('title', 'blogs'));
    }

    public function getBlog($id, $slug)
    {
        $blog = $this->blogs->getById($id);

        if ( ! $blog)
        {
            return Redirect::route('hoe');
        }

        if (empty($slug) || $slug != $blog->slug)
        {
            return Redirect::route('blog', ['id' => $blog->id, 'slug' => $blog->slug]);
        }

        $title = $blog->title;

        return View::make('blogs/blog', compact('title', 'blog'));
    }
}