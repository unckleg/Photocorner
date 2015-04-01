<?php

use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\UserTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class User extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait, SoftDeletingTrait;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password'];
    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */

    protected $softDelete = true;

    /**
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    /**
     * @param string $value
     */
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    /**
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /**
     * @return mixed
     */
    public function scopeConfirmed()
    {
        return static::where('confirmed', 1);
    }

    /**
     * @return mixed
     */
    public function images()
    {
        return $this->hasMany('Images');
    }

    /**
     * @return mixed
     */
    public function latestImages()
    {
        return $this->hasMany('Images')->orderBy('approved_at', 'desc');
    }

    /**
     * @return mixed
     */
    public function comments()
    {
        return $this->hasMany('Comment');
    }

    /**
     * @return mixed
     */
    public function favorites()
    {
        return $this->hasMany('Favorite', 'user_id');
    }

    /**
     * @return mixed
     */
    public function followers()
    {
        return $this->hasMany('Follow', 'follow_id');
    }

    /**
     * @return mixed
     */
    public function following()
    {
        return $this->hasMany('Follow', 'user_id');
    }

    /**
     * @return mixed
     */
    public function notifications()
    {
        return $this->hasMany('Notification', 'user_id');
    }

}