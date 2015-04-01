<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
use Fotokutak\Repository\CommentsRepositoryInterface;
use Fotokutak\Validator\CommentValidator;

class CommentController extends BaseController {

    public function __construct(CommentValidator $validator, CommentsRepositoryInterface $comments)
    {
        $this->validator = $validator;
        $this->comments = $comments;
    }

    public function postDeleteComment()
    {
        // If comment delete success then return success
        if ($this->comments->delete(Input::get('id')))
        {
            return 'success';
        }

        return 'failed';
    }

    public function postComment($id, $slug)
    {
        // If not a valid comment then return to image page with errors
        if ( ! $this->validator->validComment(Input::all()))
        {
            return Redirect::route('image', ['id' => $id, 'slug' => $slug])->withErrors($this->validator->errors());
        }

        // If commment creating is not success then return error
        if ( ! $this->comments->create($id, Input::all()))
        {
            return Redirect::to('gallery')->with('flashError', t('You are not allowed'));
        }

        return Redirect::route('image', ['id' => $id, 'slug' => $slug])->with('flashSuccess', t('Your comment is added'));
    }
}