<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */

namespace Controllers\Admin\Images;

use Cache;
use File;
use Images;
use Input;
use Redirect;
use Request;
use Str;
use View;

class ImageController extends \BaseController {

    public function getImagesList()
    {
        $sortBy = Request::get('sortBy');
        $direction = Request::get('direction');
        if ($sortBy && $direction)
        {
            $images = Images::approved()->with('user', 'favorite')->orderBy($sortBy, $direction)->paginate(50);
        } else
        {
            $images = Images::approved()->with('user', 'favorite')->paginate(50);
        }

        $title = 'List of all images';

        return View::make('admin/images/index', compact('images', 'title'));
    }

    public function featuredImagesList()
    {
        $sortBy = Request::get('sortBy');
        $direction = Request::get('direction');
        if ($sortBy && $direction)
        {
            $images = Images::approved()->whereNotNull('featured_at')->orderBy($sortBy, $direction)->paginate(50);
        } else
        {
            $images = Images::approved()->whereNotNull('featured_at')->paginate(50);
        }

        $title = t('List of featured Images');

        return View::make('admin/images/index', compact('images', 'title'));
    }


    public function getEdit($id)
    {
        $image = Images::where('id', '=', $id)->with('favorite', 'user')->first();

        return View::make('admin/images/edit')->with('image', $image);
    }

    public function getImagesApproval()
    {
        $images = Images::whereNull('approved_at')->with('user', 'favorite')->paginate(50);
        $title = 'Images Required Approval';

        return View::make('admin/images/approve', compact('title', 'images'));
    }

}