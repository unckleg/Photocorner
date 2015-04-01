<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */

namespace Controllers\Admin\Blogs;

use Auth;
use Blogs;
use File;
use Input;
use Redirect;
use Str;
use Validator;
use View;

class BlogsController extends \BaseController {

    public function getBlogs()
    {
        $blogs = Blogs::orderBy('created_at', 'asc')->paginate(50);

        return View::make('admin/blogs/blogs')
            ->with('blogs', $blogs);
    }

    public function getCreate()
    {
        return View::make('admin/blogs/create');
    }

    public function getEdit($id)
    {
        $blog = Blogs::where('id', '=', $id)->first();
        if ( ! $blog)
        {
            return Redirect::to('admin')->with('flashError', 'No such blog exist');
        }

        return View::make('admin/blogs/edit')->with('blog', $blog);
    }

    public function postCreate()
    {
        $v = [
            'title'       => ['required'],
            'description' => ['required'],
        ];
        $v = Validator::make(Input::all(), $v);
        if ($v->fails())
        {
            return Redirect::to('admin/blog/create')->withErrors($v)->withInput();
        }
        $blog = new Blogs();
        $slug = Str::slug(Input::get('title'));
        if ( ! $slug)
        {
            $slug = Str::random(7);
        }
        $blog->user_id = Auth::user()->id;
        $blog->title = Input::get("title");
        $blog->description = Input::get('description');
        $blog->slug = $slug;
        $blog->save();

        return Redirect::to('admin/blogs')->with('flashSuccess', 'New Blog is created');
    }

    public function postEdit($id)
    {
        if (Input::get('delete'))
        {
            $blog = Blogs::where('id', '=', $id)->first();
            $blog->delete();

            return Redirect::to('admin')->with('flashSuccess', 'Blog is deleted');
        }
        $v = [
            'title'       => ['required'],
            'description' => ['required'],
        ];
        $v = Validator::make(Input::all(), $v);
        if ($v->fails())
        {
            return Redirect::back()->withErrors($v)->withInput();
        }
        $blog = Blogs::where('id', '=', $id)->first();
        $slug = Str::slug(Input::get('title'));
        if ( ! $slug)
        {
            $slug = Str::random(7);
        }
        $blog->user_id = Auth::user()->id;
        $blog->title = Input::get("title");
        $blog->description = Input::get('description');
        $blog->slug = $slug;
        $blog->save();

        return Redirect::back()->with('flashSuccess', 'Blog is now update');
    }
}