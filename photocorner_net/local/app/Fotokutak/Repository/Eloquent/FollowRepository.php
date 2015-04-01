<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
namespace Fotokutak\Repository\Eloquent;

use Fotokutak\Notifier\FollowNotifier;
use Fotokutak\Repository\FollowRepositoryInterface;
use Fotokutak\Repository\UsersRepositoryInterface;
use Auth;
use DB;
use File;
use Follow;
use Request;
use User;

class FollowRepository extends AbstractRepository implements FollowRepositoryInterface {

    /**
     * @param FollowNotifier           $notice
     * @param Follow                   $model
     * @param UsersRepositoryInterface $user
     */
    public function __construct(FollowNotifier $notice, Follow $model, UsersRepositoryInterface $user)
    {
        $this->model = $model;
        $this->notifications = $notice;
        $this->user = $user;
    }

    /**
     * @param $id
     * @return string
     */
    public function follow($id)
    {
        if (Auth::user()->id == $id || ! $this->user->getById($id))
        {
            return t("Can't follow");
        }

        /**
         * Check if following,
         * If following then un-follow
         * else follow
         */
        $isFollowing = $this->model->where('user_id', '=', Auth::user()->id)->where('follow_id', '=', $id);
        if ($isFollowing->count() >= 1)
        {
            $isFollowing->delete();

            return t('Un-Followed');
        }
        $follow = $this->getNew();
        $follow->user_id = Auth::user()->id;
        $follow->follow_id = $id;
        $follow->save();
        // Send notice to user who is getting followed
        $this->notifications->follow(User::find($id), Auth::user());

        return t('Following');
    }
}