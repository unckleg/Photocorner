<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ImageInfo extends Eloquent {

    use SoftDeletingTrait;
    /**
     * @var string
     */
    protected $table = 'image_info';
    /**
     * @var array
     */
    protected $fillable = ['camera', 'lens', 'focal_length', 'shutter_speed', 'aperture', 'is_adult', 'iso', 'taken_at', 'latitude', 'longitude'];

    /**
     * @return array
     */
    public function getDates()
    {
        return ['created_at', 'updated_at', 'deleted_at', 'taken_at'];
    }

    /**
     * @return mixed
     */
    public function image()
    {
        return $this->belongsTo('Images');
    }
}