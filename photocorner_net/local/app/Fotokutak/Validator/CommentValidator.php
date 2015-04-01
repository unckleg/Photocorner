<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */

namespace Fotokutak\Validator;

use Comment;

class CommentValidator extends Validator {

    protected $commentRules = [
        'comment' => ['required', 'min:2']
    ];

    public function __construct(Comment $model)
    {
        $this->model = $model;
    }
}