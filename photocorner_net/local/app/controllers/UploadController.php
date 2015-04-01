<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
use Fotokutak\Validator\ImageValidator;
use Carbon\Carbon;

class UploadController extends BaseController {

    /**
     * @param ImageValidator $validator
     */
    public function __construct(ImageValidator $validator)
    {
        $this->validator = $validator;
    }


    /**
     * @return mixed
     */
    public function getIndex()
    {
        $title = t('Upload');
        $numberOfUploadByUser = Auth::user()->images()->where('created_at', '>=', Carbon::now()->subDays(1)->toDateTimeString())->count();
        $numberOfUploadByUser >= limitPerDay() ? $limitReached = true : $limitReached = false;

        return View::make('upload/index', compact('title', 'numberOfUploadByUser', 'limitReached'));
    }

    /**
     *
     */
    public function postUpload()
    {
        if ( ! $this->validator->validImage(Input::all()))
        {
            return 'failed';
        }

        $numberOfUploadByUser = Auth::user()->images()->where('created_at', '>=', Carbon::now()->subDays(1)->toDateTimeString())->count();
        if ((int) $numberOfUploadByUser >= (int) limitPerDay())
        {
            return 'failed';
        }

        $file = Input::file('files');
        $info = Input::get('photo');
        $fileSize = @$file->getSize();

        if ( ! $fileSize || ! $file->getMimeType())
        {
            return 'failed';
        }
        if ($fileSize >= ((int) siteSettings('maxImageSize') * 1000000))
        {
            return 'failed';
        }

        $imageName = $this->dirName();
        $mimetype = preg_replace('/image\//', '', $file->getMimeType());
        $file->move('uploads/', $imageName . '.' . $mimetype);

        $tags = $info['tags'];
        $parts = explode(',', $tags, siteSettings('tagsLimit'));
        $tags = implode(',', array_map('strtolower', $parts));

        $description = preg_replace('/\R\R+/u', "\n\n", trim($info['description']));
        $slug = @Str::slug($info['title']);
        if ( ! $slug)
        {
            $slug = str_random(9);
        }


        if (siteSettings('autoApprove') == 'leaveToUser')
        {
            $allowDownload = (int) Input::get('allowDownloadOriginal');
        } elseif (siteSettings('allowDownloadOriginal') == 0)
        {
            $allowDownload = 0;
        } else
        {
            $allowDownload = 1;
        }

        if ((int) siteSettings('autoApprove') == 0)
        {
            $approved_at = null;
        } else
        {
            $approved_at = Carbon::now();
        }

        $category = 1;
        if ($info['category'])
        {
            $category = Category::whereId($info['category'])->first();
            if ($category)
            {
                $category = $info['category'];
            } else
            {
                $category = 1;
            }
        }
        $adult = 0;
        if (isset($info['adult']))
        {
            $adult = (bool) $info['adult'];
        }
        sleep(1);
        $image = new Images();
        $image->user_id = Auth::user()->id;
        $image->image_name = $imageName;
        $image->title = $info['title'];
        $image->slug = $slug;
        $image->category_id = $category;
        $image->type = $mimetype;
        $image->tags = $tags;
        $image->image_description = $description;
        $image->allow_download = $allowDownload;
        $image->is_adult = $adult;
        $image->approved_at = $approved_at;
        $image->save();

        isset($info['exif']) ? $exif = $info['exif'] : $exif = null;

        $taken_at = null;
        if (isset($exif['taken']) && strlen($exif['taken'][0]) > 0)
        {
            $date = @explode('/', $exif['taken'][0]);
            $time = @explode(':', $exif['taken'][1]);
            $taken_at = @Carbon::create($date[0], $date[1], $date[2], $time[0], $time[1], 00)->toDateTimeString();
        }
        if (strlen(Input::get('photo.latitude')) > 0 && strlen(Input::get('photo.longitude')) > 0)
        {
            $latitude = doubleval(Input::get('photo.latitude'));
            $longitude = doubleval(Input::get('photo.longitude'));
        } else
        {
            $latitude = null;
            $longitude = null;
        }
        $exif = [
            'camera'        => (isset($exif['camera']) && strlen($exif['camera']) > 0 ? $exif['camera'] : null),
            'lens'          => (isset($exif['lens']) && strlen($exif['lens']) > 0 ? $exif['lens'] : null),
            'focal_length'  => (isset($exif['focalLength']) && strlen($exif['focalLength']) > 0 ? $exif['focalLength'] : null),
            'shutter_speed' => (isset($exif['shutterspeed']) && strlen($exif['shutterspeed']) > 0 ? $exif['shutterspeed'] : null),
            'aperture'      => (isset($exif['aperture']) && strlen($exif['aperture']) > 0 ? $exif['aperture'] : null),
            'iso'           => (isset($exif['iso']) && strlen($exif['iso']) > 0 ? $exif['iso'] : null),
            'taken_at'      => $taken_at,
            'latitude'      => $latitude,
            'longitude'     => $longitude,
        ];

        $info = new ImageInfo($exif);
        $image->info()->create($exif);

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