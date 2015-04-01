<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Reply extends Eloquent {

    use SoftDeletingTrait;

    protected $table = 'reply';
    protected $softDelete = true;

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function image()
    {
        return $this->belongsTo('Images', 'image_id');
    }

    public function comment()
    {
        return $this->belongsTo('Comment');
    }
}