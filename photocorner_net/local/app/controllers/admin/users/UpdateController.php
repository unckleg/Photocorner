<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
namespace Controllers\Admin\Users;

use Carbon\Carbon;
use File;
use Hash;
use Input;
use Notification;
use Redirect;
use Request;
use User;
use Validator;
use View;

class UpdateController extends \BaseController {

    /**
     * Update and delete user
     *
     * @return mixed
     */
    public function updateUser()
    {
        $user = User::find(Input::get('userid'));
        if ( ! $user)
        {
            return Redirect::to('admin')->with('flashError', 'No user is associated with this id');
        }

        if (Input::get('delete'))
        {
            // Grab all the image of user
            $images = $user->images();
            foreach ($images as $image)
            {
                File::delete('uploads/' . $image->image_name . '.' . $image->type);
                // Remove all favorites from that image
                $image->favorite()->delete();
                // Remove all comment from that image
                $comments = $image->comments()->get();
                foreach ($comments as $comment)
                {
                    $comment->reply()->delete();
                    $comment->delete();
                }
                // Delete the image
                $image->delete();
            }
            // Delete all comments and reply of this user
            $comments = $user->comments()->get();
            foreach ($comments as $comment)
            {
                $comment->reply()->delete();
                $comment->delete();
            }
            // Delete all notification of this user
            Notification::where('from_id', '=', $user->id)->delete();
            Notification::where('user_id', '=', $user->id)->delete();
            // Delete all favorites of this user
            $user->favorites()->delete();
            // Delete all followers of this user
            $user->followers()->delete();
            // Delete all following of thi user
            $user->following()->delete();
            // Delete user itself
            $user->delete();

            return Redirect::to('admin/users')->with('flashSuccess', 'User is now deleted');
        }
        $user->fullname = Input::get('fullname');
        $user->email = Input::get('email');
        $user->about_me = Input::get('aboutme');
        $user->blogurl = Input::get('blogurl');
        if (strlen(Input::get('country')) == 0)
        {
            $user->country = null;
        } else
        {
            $user->country = Input::get('country');
        }
        if (Input::get('featured'))
        {
            $user->featured_at = Carbon::now();
        } else
        {
            $user->featured_at = null;
        }

        if (Input::get('confirmed') == '1')
        {
            $user->confirmed = '1';
        }

        // User Ban settings
        $user->permission = null;

        if (Input::get('permission'))
        {
            if (strlen(Input::get('permission')) > 0 && Input::get('permission') != 'user')
            {
                $user->permission = strtolower(Input::get('permission'));
            }
        }
        $user->fb_link = Input::get('fb_link');
        $user->tw_link = Input::get('tw_link');

        $user->save();

        return Redirect::back()->with('flashSuccess', 'User "' . $user->username . '" is updated');
    }


    /**
     * Add new user post request
     *
     * @return mixed
     */
    public function addUser()
    {
        $v = [
            'username' => ['required', 'unique:users', 'alpha_num'],
            'email'    => ['required', 'unique:users'],
            'fullname' => ['required'],
            'password' => ['required'],
        ];
        $v = Validator::make(Input::all(), $v);
        if ($v->fails())
        {
            return Redirect::to('admin/adduser')->withErrors($v);
        }
        $user = new User();
        $user->username = Input::get('username');
        $user->fullname = Input::get('fullname');
        $user->email = Input::get('email');
        $user->password = Hash::make(Input::get('password'));
        $user->confirmed = 1;
        $user->save();

        return Redirect::to('admin')->with('flashSuccess', 'New user is created');
    }

}