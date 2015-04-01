<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
namespace Fotokutak\Repository\Eloquent;

use Fotokutak\Notifier\ImageNotifer;
use Fotokutak\Repository\FavoriteRepositoryInterface;
use Auth;
use Favorite;
use Images;

class FavoriteRepository extends AbstractRepository implements FavoriteRepositoryInterface {

    /**
     * @param Favorite     $model
     * @param Images       $images
     * @param ImageNotifer $notifer
     */
    public function __construct(Favorite $model, Images $images, ImageNotifer $notifer)
    {
        $this->model = $model;
        $this->images = $images;
        $this->notification = $notifer;
    }

    /**
     * @param $id
     * @return string
     */
    public function favorite($id)
    {
        $favorite = $this->model->where('image_id', '=', $id)->where('user_id', '=', Auth::user()->id);
        if ($favorite->count() >= 1)
        {
            $favorite->delete();

            return t('Un-Favorited');
        }
        $favorite = $this->getNew();
        $favorite->user_id = Auth::user()->id;
        $favorite->image_id = $id;
        $favorite->save();
        $this->notification->favorite($this->model->where('image_id', $id)->first()->image, Auth::user());

        return t('Favorited');
    }
}