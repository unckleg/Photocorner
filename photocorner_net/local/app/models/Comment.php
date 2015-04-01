<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Comment extends Eloquent {

    use SoftDeletingTrait;
    protected $table = 'comments';
    protected $softDelete = true;

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function reply()
    {
        return $this->hasMany('Reply');
    }

    public function image()
    {
        return $this->belongsTo('Images', 'image_id');
    }
}