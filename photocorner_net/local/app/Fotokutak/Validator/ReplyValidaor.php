<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */

namespace Fotokutak\Validator;

use Reply;

class ReplyValidator extends Validator {

    protected $replyRules = [
        'reply_msgid' => ['required'],
        'textcontent' => ['required']
    ];

    public function __construct(Reply $model)
    {
        $this->model = $model;
    }
}