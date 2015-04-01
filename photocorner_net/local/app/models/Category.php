<?php

/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
class Category extends Eloquent {

    protected $table = 'categories';

    public function images()
    {
        return $this->hasMany('Images', 'category_id');
    }
}