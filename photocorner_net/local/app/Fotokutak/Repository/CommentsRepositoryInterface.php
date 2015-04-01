<?php
/**
 * @author Djordje Stojiljkovic & Nikola Stojic <djordjewebdizajn@gmail.com>
 */
namespace Fotokutak\Repository;

use Auth;

interface CommentsRepositoryInterface {

    /**
     * @param $id
     * @param $input
     * @return mixed
     */
    public function create($id, $input);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);

}