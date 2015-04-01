<?php
/**
 * @author Djordje Stojiljkovic & Nikola Stojic <djordjewebdizajn@gmail.com>
 */
namespace Fotokutak\Repository;

use Auth;
use Cache;
use DB;
use File;
use Images;
use Str;

interface ImagesRepositoryInterfaceInterface {

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id);


    /**
     * @param null $category
     * @param null $timeframe
     * @param null $limit
     * @return mixed
     */
    public function getLatest($category = null, $timeframe = null, $limit = null);


    /**
     * @param null $category
     * @param null $timeframe
     * @param null $limit
     * @return mixed
     */
    public function getFeatured($category = null, $timeframe = null, $limit = null);


    /**
     * @param array $input
     * @param       $id
     * @return mixed
     */
    public function update(array $input, $id);


    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);


    /**
     * @param      $tag
     * @param null $limit
     * @return mixed
     */
    public function getByTags($tag, $limit = null);


    /**
     * @param $image
     * @return mixed
     */
    public function incrementViews($image);


    /**
     * @param null   $category
     * @param null   $timeframe
     * @param string $orderBy
     * @return mixed
     */
    public function mostCommented($category = null, $timeframe = null, $orderBy = 'desc');


    /**
     * @param null   $category
     * @param string $oderBy
     * @return mixed
     */
    public function popular($category = null, $timeframe = null, $oderBy = 'desc');


    /**
     * @param null   $category
     * @param null   $timeframe
     * @param string $oderBy
     * @return mixed
     */
    public function mostFavorited($category = null, $timeframe = null, $oderBy = 'desc');


    /**
     * @param null   $category
     * @param null   $timeframe
     * @param string $oderBy
     * @return mixed
     */
    public function mostDownloaded($category = null, $timeframe = null, $oderBy = 'desc');


    /**
     * @param null   $category
     * @param null   $timeframe
     * @param string $orderBy
     * @return mixed
     */
    public function mostViewed($category = null, $timeframe = null, $orderBy = 'desc');


    /**
     * @param      $input
     * @param null $category
     * @return mixed
     */
    public function search($input, $category = null);

    /**
     * @param Images $image
     * @return mixed
     */
    public function findNextImage(Images $image);


    /**
     * @param Images $image
     * @return mixed
     */
    public function findPreviousImage(Images $image);

    /**
     * @return mixed
     */
    public function postFavorite();

}