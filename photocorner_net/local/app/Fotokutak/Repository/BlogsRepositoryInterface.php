<?php
/**
 * @author Djordje Stojiljkovic & Nikola Stojic <djordjewebdizajn@gmail.com>
 */
namespace Fotokutak\Repository;


interface BlogsRepositoryInterface {

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id);

    /**
     * @param null $paginate
     * @return mixed
     */
    public function getLatestBlogs($paginate = null);

}