<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
namespace Fotokutak\Repository\Eloquent;

use Fotokutak\Notifier\ReplyNotifer;
use Fotokutak\Repository\ReplyRepositoryInterface;
use Auth;
use Comment;
use Images;
use Reply;

class ReplyRepository extends AbstractRepository implements ReplyRepositoryInterface {

    /**
     * @param ReplyNotifer $notifications
     * @param Reply        $model
     * @param Comment      $comment
     * @param Images       $images
     * @internal param Reply $reply
     */
    public function __construct(ReplyNotifer $notifications, Reply $model, Comment $comment, Images $images)
    {
        $this->notification = $notifications;
        $this->model = $model;
        $this->comment = $comment;
        $this->images = $images;
    }

    /**
     * @param $input
     * @return mixed|void
     */
    public function createReply($input)
    {
        $comment = $this->comment->where('id', '=', $input['reply_msgid'])->first();
        if ( ! $comment)
        {
            return 'Not allowed';
        }
        if ( ! $this->images->where('id', '=', $comment->image_id)->first())
        {
            return 'Not allowed';
        }

        $reply = $this->getNew();
        $reply->user_id = Auth::user()->id;
        $reply->image_id = $comment->image_id;
        $reply->comment_id = $comment->id;
        $reply->reply = $input['textcontent'];
        $reply->save();

        if ($reply->comment->user->id != Auth::user()->id)
        {
            $this->notification->replyNotice($reply->comment->user, Auth::user(), $comment->image, $input['textcontent'], true);
        }

        $noticeSentToUsers = [];
        foreach ($reply->where('comment_id', '=', $input['reply_msgid'])->get() as $replier)
        {
            if ($replier->user_id != Auth::user()->id AND $replier->user_id != $comment->user_id && ! in_array($replier->user_id, $noticeSentToUsers))
            {
                $this->notification->replyNotice($replier->user, Auth::user(), $comment->image, $input['textcontent']);
                $noticeSentToUsers[] = $replier->user_id;
            }
        }

        return $reply;
    }

    /**
     * @param $input
     * @return bool
     */
    public function deleteReply($input)
    {
        $reply = $this->model->whereId($input)->first();
        if ( ! $reply)
        {
            return false;
        }
        if ($reply->user_id == Auth::user()->id || $reply->comment->user->id == Auth::user()->id || $reply->image->user->id == Auth::user()->id)
        {
            $reply->delete();

            return true;
        }
    }
}