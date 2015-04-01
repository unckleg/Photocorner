<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
use Fotokutak\Repository\ImagesRepositoryInterfaceInterface;

class PopularController extends BaseController {

    /**
     * @param ImagesRepositoryInterfaceInterface $images
     */
    public function __construct(ImagesRepositoryInterfaceInterface $images)
    {
        $this->images = $images;
    }

    /**
     * Main gallery of site
     */
    public function getIndex()
    {
        $images = $this->images->getLatest(Input::get('category'), Input::get('timeframe'));
        $title = t('Latest Images');

        return View::make('popular/index', compact('images', 'title'));
    }

    /**
     * @return mixed
     */
    public function featured()
    {
        $images = $this->images->getFeatured(Input::get('category'), Input::get('timeframe'));
        $title = t('Featured Images');

        return View::make('popular/index', compact('images', 'title'));
    }

    /**
     * @return mixed
     */
    public function mostCommented()
    {
        $images = $this->images->mostCommented(Input::get('category'), Input::get('timeframe'));
        $title = t('Most Commented');

        return View::make('popular/index', compact('images', 'title'));
    }

    /**
     * @return mixed
     */
    public function mostFavorited()
    {
        $images = $this->images->mostFavorited(Input::get('category'), Input::get('timeframe'));
        $title = t('Most Favorites');

        return View::make('popular/index', compact('images', 'title'));
    }

    /**
     * @return mixed
     */
    public function mostDownloaded()
    {
        $images = $this->images->mostDownloaded(Input::get('category'), Input::get('timeframe'));
        $title = t('Popular');

        return View::make('popular/index', compact('images', 'title'));
    }

    /**
     * @return mixed
     */
    public function mostPopular()
    {
        $images = $this->images->popular(Input::get('category'), Input::get('timeframe'));
        $title = t('Popular');

        return View::make('popular/index', compact('images', 'title'));
    }

    /**
     * @return mixed
     */
    public function mostViewed()
    {
        $images = $this->images->mostViewed(Input::get('category'), Input::get('timeframe'));
        $title = t('Most Viewed');

        return View::make('popular/index', compact('images', 'title'));
    }

    /**
     * @param $tag
     * @return mixed
     */
    public function getByTags($tag)
    {
        $images = $this->images->getByTags($tag);
        $title = t('Tagged with') . ' ' . ucfirst($tag);

        return View::make('popular/index', compact('images', 'title'));
    }
}