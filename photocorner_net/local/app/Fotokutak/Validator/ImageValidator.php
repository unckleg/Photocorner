<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
namespace Fotokutak\Validator;

use Images;

class ImageValidator extends Validator {


    protected $updateRules = [
        'title'    => ['required', 'max:200'],
        'category' => ['required'],
        'tags'     => ['required']
    ];

    protected $imageRules = [
        'files'       => ['required', 'image'],
        'photo.title' => ['required', 'max:200'],
    ];

    protected $favoriteRules = [
        'id' => ['required', 'integer']
    ];

    public function __construct(Images $model)
    {
        $this->model = $model;
    }

}