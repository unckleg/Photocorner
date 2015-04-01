<?php

/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
class Follow extends Eloquent {

    /**
     * @var string
     */
    protected $table = 'follow';

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
    public function followingUser()
    {
        return $this->belongsTo('User', 'follow_id');
    }

    /**
     * @return mixed
     */
    public function images()
    {
        return $this->hasMany('Images', 'user_id', 'follow_id');
    }
}