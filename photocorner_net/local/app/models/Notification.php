<?php

/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
class Notification extends Eloquent {

    protected $table = 'notification';

    public function user()
    {
        return $this->belongsTo('User', 'from_id')->withTrashed();
    }

    public function image()
    {
        return $this->belongsTo('Images', 'on_id')->withTrashed();
    }
}