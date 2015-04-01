<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
namespace Controllers\Admin\SiteSettings;

use App;
use Blogs;
use Cache;
use Category;
use DB;
use File;
use Images;
use Input;
use Redirect;
use Str;
use User;
use Validator;
use view;

class UpdateController extends \BaseController {

    /**
     * @return mixed
     */
    public function updateSettings()
    {
        DB::table('sitesettings')
            ->where('option', 'siteName')
            ->update(['value' => Input::get('sitename')]);
        DB::table('sitesettings')
            ->where('option', 'description')
            ->update(['value' => Input::get('description')]);
        DB::table('sitesettings')
            ->where('option', 'favIcon')
            ->update(['value' => Input::get('favicon')]);
        DB::table('sitesettings')
            ->where('option', 'privacy')
            ->update(['value' => Input::get('privacy')]);
        DB::table('sitesettings')
            ->where('option', 'faq')
            ->update(['value' => Input::get('faq')]);
        DB::table('sitesettings')
            ->where('option', 'tos')
            ->update(['value' => Input::get('tos')]);
        DB::table('sitesettings')
            ->where('option', 'about')
            ->update(['value' => Input::get('about')]);

        Cache::forget('siteName');
        Cache::forget('description');
        Cache::forget('favIcon');
        Cache::forget('faq');
        Cache::forget('privacy');
        Cache::forget('tos');
        Cache::forget('about');

        return Redirect::back()->with('flashSuccess', 'Site Details Updated');
    }

    /**
     * @return mixed
     */
    public function postLimitSettings()
    {
        DB::table('sitesettings')
            ->where('option', 'numberOfImagesInGallery')
            ->update(['value' => (int) Input::get('numberOfImages')]);
        DB::table('sitesettings')
            ->where('option', 'autoApprove')
            ->update(['value' => Input::get('autoApprove')]);
        DB::table('sitesettings')
            ->where('option', 'limitPerDay')
            ->update(['value' => (int) Input::get('limitPerDay')]);
        DB::table('sitesettings')
            ->where('option', 'tagsLimit')
            ->update(['value' => (int) Input::get('tagsLimit')]);
        DB::table('sitesettings')
            ->where('option', 'allowDownloadOriginal')
            ->update(['value' => Input::get('allowDownloadOriginal')]);
        DB::table('sitesettings')
            ->where('option', 'maxImageSize')
            ->update(['value' => Input::get('maxImageSize')]);
        Cache::forget('numberOfImagesInGallery');
        Cache::forget('autoApprove');
        Cache::forget('limitPerDay');
        Cache::forget('tagsLimit');
        Cache::forget('allowDownloadOriginal');
        Cache::forget('maxImageSize');

        return Redirect::back()->with('flashSuccess', 'Your limits are now updated');
    }

    /**
     * @return mixed
     */
    public function createSiteCategory()
    {
        $v = ['addnew' => ['required']];
        $v = Validator::make(Input::all(), $v);
        if ($v->fails())
        {
            return Redirect::to('admin/sitecategory')->with('flashError', 'Please provide some input');
        }
        $category = new Category();
        $category->name = ucfirst(Input::get('addnew'));
        $slug = Str::slug(Input::get('addnew'));
        if ( ! $slug)
        {
            $slug = Str::random(9);
        }
        $category->slug = $slug;
        $category->save();
        Cache::forget('categories');

        return Redirect::to('admin/sitecategory')->with('flashSuccess', 'New Category Is Added');
    }

    /**
     * @return mixed
     */
    public function updateSiteMap()
    {
        $sitemap = App::make("sitemap");
        $blogs = Blogs::orderBy('created_at', 'desc')->get();
        foreach ($blogs as $blog)
        {
            $sitemap->add(route('blog', ['id' => $blog->id, 'slug' => $blog->slug]), $blog->updated_at, '0.9');
        }
        $posts = Images::orderBy('created_at', 'desc')->get();
        foreach ($posts as $post)
        {
            $sitemap->add(route('image', ['id' => $post->id, 'slug' => $post->slug]), $post->approved_at, '0.9');
        }
        $users = User::orderBy('created_at', 'desc')->get();
        foreach ($users as $user)
        {
            $sitemap->add(route('user', ['username' => $user->username]), $user->created_at, '0.5');
        }
        $sitemap->store('xml', 'sitemap');

        return Redirect::to('admin')->with('flashSuccess', 'sitemap.xml is now updated');
    }

    /**
     *
     */
    public function reorderSiteCategory()
    {
        $tree = Input::get('tree');
        foreach ($tree as $k => $v)
        {
            if ($v["depth"] == -1)
            {
                continue;
            }
            if ($v["parent_id"] == "root")
            {
                $v["parent_id"] = 0;
            }

            $category = Category::where('id', '=', $v['item_id'])->first();
            $category->parent_id = $v['parent_id'];
            $category->depth = $v["depth"];
            $category->lft = $v["left"] - 1;
            $category->rgt = $v["right"] - 1;
            $category->save();
        }
        Cache::forget('categories');
    }

    /**
     * @return mixed
     */
    public function updateSiteCategory()
    {
        $v = [
            'id'   => ['required'],
            'slug' => ['required', 'alpha_dash'],
            'name' => ['required']
        ];
        $v = Validator::make(Input::all(), $v);
        if ($v->fails())
        {
            return Redirect::to('admin/sitecategory')->withErrors($v);
        }
        $id = Input::get('id');
        $category = Category::where('id', '=', $id)->with('images')->first();
        $delete = Input::get('delete');
        if ($delete)
        {
            if (Input::get('shiftCategory'))
            {
                foreach ($category->images as $image)
                {
                    $image->category_id = Input::get('shiftCategory');
                    $image->save();
                }
            }
            $category->delete();
            Cache::forget('categories');

            return Redirect::to('admin/sitecategory')->with('flashSuccess', 'Category is now deleted');
        }

        $category->slug = Input::get('slug');
        $category->name = Input::get('name');
        $category->save();
        Cache::forget('categories');

        return Redirect::to('admin/sitecategory')->with('flashSuccess', 'Category is now updated');

    }

    /**
     *
     */
    public function clearCache()
    {
        File::cleanDirectory(storage_path() . '/cache');
        File::cleanDirectory(storage_path() . '/views');
        File::cleanDirectory(storage_path() . '/logs');

        return Redirect::to('admin')->with('falshSuccess', t('Basic cache files are not cleared'));
    }
}