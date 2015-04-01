<?php
/**
 * @author Djordje Stojiljkovic & Nikola Stojic <djordjewebdizajn@gmail.com>
 */
namespace Fotokutak\Repository;

use Auth;
use DB;
use File;
use Request;

interface FollowRepositoryInterface {

    /**
     * @param $id
     * @return mixed
     */
    public function follow($id);
}