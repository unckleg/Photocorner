<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Images extends Eloquent {

    use SoftDeletingTrait;
    /**
     * @var string
     */
    protected $table = 'images';
    /**
     * @var bool
     */
    protected $softDelete = true;

    /**
     * @return mixed
     */
    public static function scopeApproved()
    {
        return static::whereNotNull('approved_at');
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo('User');
    }

    /**
     * @return mixed
     */
    public function comments()
    {
        return $this->hasMany('Comment', 'image_id');
    }

    /**
     * @return mixed
     */
    public function favorite()
    {
        return $this->hasMany('Favorite', 'image_id');
    }

    /**
     * @return mixed
     */
    public function category()
    {
        return $this->belongsTo('Category', 'category_id');
    }

    /**
     * @return mixed
     */
    public function info()
    {
        return $this->hasOne('ImageInfo', 'image_id');
    }
}