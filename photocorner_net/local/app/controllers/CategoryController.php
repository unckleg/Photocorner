<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
use Fotokutak\Repository\CategoryRepositoryInterface;
use Fotokutak\Repository\ImagesRepositoryInterfaceInterface;

class CategoryController extends BaseController {

    /**
     * @var Fotokutak\Repository\CategoryRepository
     */
    private $category;

    public function __construct(CategoryRepositoryInterface $category, ImagesRepositoryInterfaceInterface $images)
    {
        $this->images = $images;
        $this->category = $category;
    }

    /**
     * Display images posted in particular category,
     * check if category exits or not if not then redirect to to gallery
     *
     * @param $category
     * @return mixed
     */
    public function getIndex($category)
    {
        $category = $this->category->getBySlug($category);

        if ( ! $category)
        {
            return Redirect::to('gallery');
        }

        $images = $this->images->getLatest($category->slug, Input::get('timeframe'));
        $title = t('Browsing') . ' ' . ucfirst($category->name) . ' ' . t('Category');

        return View::make('category/index', compact('images', 'title'));
    }

    /**
     * Generate RSS feed of each category
     *
     * @param $category
     * @return mixed
     */
    public function getRss($category)
    {
        $category = $this->category->getBySlug($category);

        if ( ! $category)
        {
            App::abort(404);
        }

        return $this->category->getRss($category);

    }
}