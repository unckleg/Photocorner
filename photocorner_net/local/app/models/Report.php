<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Report extends Basemodel {

    use SoftDeletingTrait;

    /**
     * @var array
     */
    public static $rules = [
        'report'               => 'required|min:10|max:200',
        'g-recaptcha-response' => ['required', 'captcha']
    ];
    /**
     * @var string
     */
    protected $table = 'report';
    /**
     * @var bool
     */
    protected $softDelete = true;

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo('User');
    }
}