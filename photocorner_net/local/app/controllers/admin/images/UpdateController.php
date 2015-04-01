<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */

namespace Controllers\Admin\Images;

use Cache;
use Carbon\Carbon;
use Category;
use File;
use Images;
use Input;
use Redirect;
use Request;
use Str;
use View;

class UpdateController extends \BaseController {

    public function postApprove()
    {
        $image = Images::whereId(Input::get('id'))->first();
        if ( ! $image)
        {
            return 'Error';
        }
        $image->approved_at = Carbon::now();
        $image->save();

        return 'Approved';
    }

    public function postDisapprove()
    {
        $image = Images::whereId(Input::get('id'))->first();
        if ( ! $image)
        {
            return 'Error';
        }

        File::delete('uploads/' . $image->image_name . '.' . $image->type);
        $image->delete();
        $image->comments()->delete();
        $image->favorite()->delete();
        Cache::forget('moreFromSite');

        return 'Removed';

    }


    public function postEdit($id)
    {
        $image = Images::where('id', '=', $id)->first();
        Cache::forget('featuredImage');
        Cache::forget('moreFromSite');
        if (Input::get('delete'))
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

            return Redirect::to('admin')->with('flashSuccess', 'Image is now deleted permanently');
        }
        if (Category::where('id', '=', Input::get('category'))->count() != 1)
        {
            return Redirect::back()->with('flashError', t('Invalid category'));
        }

        $slug = @Str::slug(Input::get('title'));
        if ( ! $slug)
        {
            $slug = Str::random(9);
        }
        $image->title = Input::get('title');
        $image->slug = $slug;
        $image->image_description = Input::get('description');
        $image->category_id = Input::get('category');
        $image->tags = Input::get('tags');

        if (Input::get('featured'))
        {
            $image->featured_at = Carbon::now();
        } else
        {
            $image->featured_at = null;
        }

        $image->save();

        return Redirect::back()->with('flashSuccess', 'Image is now updated');
    }
}