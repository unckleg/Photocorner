<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */

namespace Fotokutak\Validator;

use User;

class UserValidator extends Validator {

    protected $registrationRules = [
        'username'              => ['required', 'min:3', 'max:20', 'alpha_num', 'Unique:users'],
        'fullname'              => ['required', 'min:3', 'max:80'],
        'gender'                => ['required', 'in:male,female'],
        'email'                 => ['required', 'between:3,64', 'email', 'unique:users'],
        'password'              => ['required', 'between:4,25', 'confirmed'],
        'password_confirmation' => ['required', 'between:4,25'],
        'g-recaptcha-response'  => ['required', 'captcha']
    ];

    protected $facebookRegistrationRules = [
        'username'              => ['required', 'min:3', 'max:20', 'alpha_num', 'unique:users'],
        'password'              => ['required', 'between:4,25', 'confirmed'],
        'password_confirmation' => ['required', 'between:4,25'],
    ];

    protected $googleRegistrationRules = [
        'username'              => ['required', 'min:3', 'max:20', 'alpha_num', 'unique:users'],
        'password'              => ['required', 'between:4,25', 'confirmed'],
        'password_confirmation' => ['required', 'between:4,25'],
    ];

    protected $updateRules = [
        'fullname' => ['required'],
        'gender'   => ['required', 'in:male,female'],
        'country'  => ['required', 'alpha_num'],
        'dob'      => ['date_format:Y-m-d'],
        'blogurl'  => ['url', 'min:3'],
        'fb_link'  => ['url'],
        'tw_link'  => ['url']
    ];

    protected $avatarUpdateRules = [
        'avatar' => ['required', 'image']
    ];

    protected $passwordRestRules = [
        'email'                => ['required', 'email'],
        'g-recaptcha-response' => ['required', 'captcha']
    ];

    protected $passwordUpdateRule = [
        'password'              => ['required', 'min:6', 'confirmed'],
        'currentpassword'       => ['required'],
        'password_confirmation' => ['required', 'between:4,25']
    ];

    public function __construct(User $model)
    {
        $this->model = $model;
    }
}