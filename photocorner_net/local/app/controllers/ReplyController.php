<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
use Fotokutak\Repository\ReplyRepositoryInterface;
use Fotokutak\Validator\ReplyValidator;

class ReplyController extends BaseController {

    /**
     * @param ReplyRepositoryInterface $reply
     * @param ReplyValidator           $validator
     */
    public function __construct(ReplyRepositoryInterface $reply, ReplyValidator $validator)
    {
        $this->validator = $validator;
        $this->reply = $reply;
    }

    /**
     * @return string
     */
    public function postDeleteReply()
    {
        if (Auth::check() == false)
        {
            return t('Login first');
        }

        if ($this->reply->deleteReply(Input::get('id')))
        {
            return 'success';
        }

        return 'false';
    }

    /**
     * @return string
     */
    public function postReply()
    {
        if (Auth::check() == false)
        {
            return t('Login first');
        }

        if ( ! $this->validator->validReply(Input::all()))
        {
            return t('Not allowed');
        }

        $reply = $this->reply->createReply(Input::all());

        return Response::json([
            'fullname'       => e(Auth::user()->fullname),
            'profile_link'   => Auth::user()->username,
            'profile_avatar' => getAvatar(Auth::user(), 64),
            'description'    => e($reply->reply),
            'time'           => $reply->created_at->diffForHumans(),
            'comment_id'     => $reply->comment_id,
            'reply'          => e($reply->reply),
        ]);
    }
}