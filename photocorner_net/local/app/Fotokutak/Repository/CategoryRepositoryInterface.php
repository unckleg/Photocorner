<?php
/**
 * @author Djordje Stojiljkovic & Nikola Stojic <djordjewebdizajn@gmail.com>
 */
namespace Fotokutak\Repository;

use Fotokutak\Repository\ImagesRepository;

interface CategoryRepositoryInterface {

    /**
     * @param $slug
     * @return mixed
     */
    public function getBySlug($slug);
}