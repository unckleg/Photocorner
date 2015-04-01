<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
namespace Fotokutak\Validator;

use Favorite;

class FavoriteValidator extends Validator {

    protected $favoriteRules = [
        'id' => ['required', 'integer']
    ];


    public function __construct(Favorite $model)
    {
        $this->model = $model;
    }

}