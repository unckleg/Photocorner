<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
namespace Fotokutak\Repository\Eloquent;

use Fotokutak\Notifier\ImageNotifer;
use Fotokutak\Repository\CommentsRepositoryInterface;
use Auth;
use Comment;
use Images;

class CommentsRepository extends AbstractRepository implements CommentsRepositoryInterface {

    /**
     * @param Comment      $comment
     * @param Images       $images
     * @param ImageNotifer $notifications
     */
    public function __construct(Comment $comment, Images $images, ImageNotifer $notifications)
    {
        $this->model = $comment;
        $this->images = $images;
        $this->notifications = $notifications;

    }

    /**
     * @param $id
     * @param $input
     * @return bool
     */
    public function create($id, $input)
    {
        $image = $this->images->approved()->where('id', '=', $id)->first();
        if ( ! $image)
        {
            return false;
        }
        $comment = $this->getNew();
        $comment->user_id = Auth::user()->id;
        $comment->image_id = $id;
        $comment->comment = $input['comment'];
        $comment->save();
        if (Auth::user()->id != $image->user_id)
        {
            $this->notifications->comment($image, Auth::user(), $input['comment']);
        }

        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $commentOwner = $this->model->where('id', '=', $id)->first();
        if ( ! $commentOwner)
        {
            return false;
        }
        if ($commentOwner->user_id == Auth::user()->id || Auth::user()->id == $commentOwner->image->user->id)
        {
            $commentOwner->delete();

            return true;
        }

        return false;
    }

}