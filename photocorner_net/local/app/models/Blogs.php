<?php

/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
class Blogs extends Eloquent {

    protected $table = 'blogs';

    public function user()
    {
        return $this->belongsTo('User');
    }
}