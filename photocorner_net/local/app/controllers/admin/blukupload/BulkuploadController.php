<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */

namespace Controllers\Admin\Bulkupload;

use Auth;
use Cache;
use Carbon\Carbon;
use Category;
use DB;
use File;
use Images;
use Input;
use Redirect;
use Request;
use Str;
use View;

class BulkuploadController extends \BaseController {

    /**
     * @return mixed
     */
    public function getBulkUpload()
    {
        return View::make('admin/bulkupload/index');
    }

    /**
     * @return array
     */
    public function postBulkUpload()
    {
        // check if category exits
        if (Category::where('id', '=', Input::get('category'))->count() != 1)
        {
            return $this->error(['error' => t('Invalid category')]);
        }

        $imageName = $this->dirName();
        $mimetype = Input::file('files')[0]->getMimeType();
        $mimetype = preg_replace('/image\//', '', $mimetype);
        $title = Input::file('files')[0]->getClientOriginalName();
        $title = str_replace(['.jpg', '.gif', '.png', '.jpeg', '.JPG', '.GIF', '.PNG', '.JPEG'], '', $title);
        $file = Input::file('files')[0]->move('uploads/', $imageName . '.' . $mimetype);
        $tags = Input::get('tags');
        $parts = explode(',', $tags, siteSettings('tagsLimit'));

        $tags = implode(',', array_map('strtolower', $parts));

        $slug = @Str::slug($title);
        if (strlen($slug) <= '1')
        {
            $slug = str_random(9);
        }
        $upload = new Images();
        $upload->user_id = Auth::user()->id;
        $upload->image_name = $imageName;
        $upload->title = $title;
        $upload->slug = $slug;
        $upload->category_id = Input::get('category');
        $upload->type = $mimetype;
        $upload->tags = $tags;
        $upload->allow_download = Input::get('allow_download');
        $upload->approved_at = Carbon::now();

        $upload->save();

        return $this->error(['success' => 'Uploaded', 'successSlug' => route('image', ['id' => $upload->id, 'slug' => $upload->slug]), 'successTitle' => ucfirst($upload->title), 'thumbnail' => asset(zoomCrop('uploads/' . $upload->image_name . '.' . $upload->type))]);
    }

    /**
     * @param $str
     * @return array
     */
    private function error($str)
    {
        return [
            'files' => [
                0 => $str
            ]
        ];
    }

    /**
     * @return string
     */
    private function dirName()
    {
        $str = str_random(9);
        if (file_exists(public_path() . '/uploads/' . $str))
        {
            $str = $this->dirName();
        }

        return $str;
    }
}