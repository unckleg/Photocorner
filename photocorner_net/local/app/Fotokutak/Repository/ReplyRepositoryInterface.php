<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
namespace Fotokutak\Repository;

use Auth;

interface ReplyRepositoryInterface {

    /**
     * @param $input
     * @return mixed
     */
    public function createReply($input);

    /**
     * @param $input
     * @return mixed
     */
    public function deleteReply($input);
}