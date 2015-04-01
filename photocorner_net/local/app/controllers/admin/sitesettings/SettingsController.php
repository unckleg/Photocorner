<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
namespace Controllers\Admin\SiteSettings;

use App;
use Cache;
use DB;
use File;
use Redirect;
use View;

class SettingsController extends \BaseController {

    public function getSiteDetails()
    {
        $settings = DB::table('sitesettings')->get();

        return View::make('admin/sitesettings/sitedetails')
            ->with('settings', $settings);

    }

    public function getLimitSettings()
    {
        return View::make('admin/sitesettings/limit');
    }

    public function getSiteCategory()
    {
        return View::make('admin/sitesettings/category')
            ->with('title', 'Site Category');
    }

    public function getRemoveCache()
    {
        File::cleanDirectory(public_path() . '/cache');
        File::cleanDirectory(storage_path() . '/logs');
        File::cleanDirectory(storage_path() . '/cache');
        File::cleanDirectory(storage_path() . '/views');
        Cache::forget('siteName');
        Cache::forget('description');
        Cache::forget('favIcon');
        Cache::forget('faq');
        Cache::forget('privacy');
        Cache::forget('tos');
        Cache::forget('featuredImage');
        Cache::forget('featuredAuthor');

        return Redirect::to('admin')->with('flashSuccess', 'All cached files are deleted');
    }
}