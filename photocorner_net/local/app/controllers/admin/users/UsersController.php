<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
namespace Controllers\Admin\Users;

use Hash;
use Input;
use Redirect;
use Request;
use User;
use Validator;
use View;

class UsersController extends \BaseController {

    public function getUsersList()
    {
        $sortBy = Request::get('sortBy');
        $direction = Request::get('direction');

        if ($this->sort($sortBy, $direction))
        {
            $users = User::orderBy($sortBy, $direction)->paginate(50);
        } else
        {
            $users = User::paginate(50);
        }

        $title = 'All Users';

        return View::make('admin/users/users', compact('users', 'title'));
    }

    public function getFeaturedUserList()
    {
        $sortBy = Request::get('sortBy');
        $direction = Request::get('direction');

        if ($this->sort($sortBy, $direction))
        {
            $users = User::withTrashed()->orderBy($sortBy, $direction)->whereNotNull('featured_at')->paginate(50);
        } else
        {
            $users = User::withTrashed()->whereNotNull('featured_at')->paginate(50);
        }

        $title = 'Featured Users';

        return View::make('admin/users/users', compact('users', 'title'));
    }

    public function getBannedUserList()
    {
        $sortBy = Request::get('sortBy');
        $direction = Request::get('direction');

        if ($this->sort($sortBy, $direction))
        {
            $users = User::withTrashed()->orderBy($sortBy, $direction)->where('permission', '=', 'ban')->paginate(50);
        } else
        {
            $users = User::withTrashed()->where('permission', '=', 'ban')->paginate(50);
        }

        $title = 'Banned Users';

        return View::make('admin/users/users', compact('users', 'title'));
    }

    public function getEditUser($user)
    {
        $user = User::where('username', '=', $user)->first();

        if ( ! $user)
        {
            return Redirect::to('admin')->with('flashError', 'User does not exist');
        }

        return View::make('admin/users/edit', compact('user'));
    }


    private function sort($sortBy, $direction)
    {
        $sortArray = ['username', 'fullname', 'created_at', 'updated_at'];
        $directionArray = ['asc', 'desc'];
        if (in_array($sortBy, $sortArray) && in_array($direction, $directionArray))
        {
            return true;
        }
    }

    public function getAddUser()
    {
        return View::make('admin/users/add');
    }

}