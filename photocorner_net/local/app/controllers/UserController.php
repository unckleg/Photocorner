<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
use Fotokutak\Repository\FollowRepositoryInterface;
use Fotokutak\Repository\ImagesRepositoryInterfaceInterface;
use Fotokutak\Repository\UsersRepositoryInterface;
use Fotokutak\Validator\UserValidator;

class UserController extends BaseController {

    /**
     * @param UsersRepositoryInterface           $user
     * @param ImagesRepositoryInterfaceInterface $images
     * @param FollowRepositoryInterface          $follow
     * @param UserValidator                      $validator
     */
    public function __construct(UsersRepositoryInterface $user, ImagesRepositoryInterfaceInterface $images, FollowRepositoryInterface $follow, UserValidator $validator)
    {
        $this->user = $user;
        $this->images = $images;
        $this->follow = $follow;
        $this->validator = $validator;
    }

    /**
     * @param $user
     * @return mixed
     */
    public function getUser($user)
    {
        $user = $this->user->getByUsername($user);

        if ( ! $user)
        {
            return Redirect::to('gallery');
        }

        // Get all images of user
        $images = $this->user->getUsersImages($user);

        // Get most used tags from helper function
        $mostUsedTags = mostTags($images->lists('tags'));
        $title = ucfirst($user->fullname);

        return View::make('user/index', compact('user', 'title', 'images', 'mostUsedTags'));
    }


    /**
     * @param $user
     * @return mixed
     */
    public function getFavorites($user)
    {
        $user = $this->user->getByUsername($user);

        if ( ! $user)
        {
            return Redirect::route('home');
        }

        $images = $this->user->getUsersFavorites($user);

        $mostUsedTags = mostTags($user->images()->lists('tags'));
        $title = $user->fullname;

        return View::make('user/favorites', compact('user', 'images', 'title', 'mostUsedTags'));

    }

    /**
     * @param $username
     * @return mixed
     */
    public function getFollowers($username)
    {
        $user = $this->user->getUsersFollowers($username);

        if ( ! $user)
        {
            return Redirect::route('home');
        }

        $mostUsedTags = mostTags($user->images()->lists('tags'));
        $title = $user->fullname;

        return View::make('user/followers', compact('user', 'title', 'mostUsedTags'));
    }

    /**
     * @param $username
     * @return mixed
     */
    public function getFollowing($username)
    {
        $user = $this->user->getUsersFollowing($username);

        if ( ! $user)
        {
            return Redirect::route('home');
        }

        if ($user->id != Auth::user()->id)
        {
            return Redirect::route('home');
        }

        $mostUsedTags = mostTags($user->images()->lists('tags'));
        $title = $user->fullname;

        return View::make('user/following', compact('user', 'title', 'mostUsedTags'));
    }

    /**
     * @param $user
     * @return mixed
     */
    public function getRss($user)
    {
        return $this->user->getUsersRss($user);
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        $users = $this->user->getTrendingUsers();
        $title = t('Users');

        return View::make('user/users', compact('users', 'title'));
    }

    /**
     * @return mixed
     */
    public function getNotifications()
    {
        $notifications = $this->user->notifications(Auth::user()->id);
        $title = t('Notifications');

        return View::make('user/notifications', compact('notifications', 'title'));
    }


    /**
     * @return mixed
     */
    public function getFeeds()
    {
        if (Auth::check() == false)
        {
            return Redirect::route('home');
        }

        $images = $this->user->getFeedForUser();
        $title = t('Feeds');

        return View::make('gallery/index', compact('images', 'title'));
    }

    /**
     * @return string
     */
    public function follow()
    {
        if (Auth::check() == false)
        {
            return t('Login');
        }

        if ( ! Request::ajax())
        {
            return t('can\'t follow');
        }

        return $this->follow->follow(Input::get('id'));
    }


    /**
     * @return mixed
     */
    public function getSettings()
    {
        $user = Auth::user()->find(Auth::user()->id);
        $title = t('Settings');

        return View::make('user/settings', compact('user', 'title'));
    }

    /**
     * @return mixed
     */
    public function postUpdateAvatar()
    {
        if ( ! $this->validator->validAvatarUpdate(Input::all()))
        {
            return Redirect::back()->withErrors($this->validator->errors());
        }

        $imageName = $this->dirName();
        $file = Image::open(Input::file('avatar'))->cropResize(400, 400)->save('avatar/' . $imageName . '.jpg', 'jpg', 90);
        $update = Auth::user();
        $update->avatar = $imageName;
        $update->save();

        return Redirect::back()->with('flashSuccess', t('Your avatar is now updated'));
    }

    /**
     * @return string
     */
    private function dirName()
    {
        $str = str_random(9);
        if (file_exists(public_path() . '/avatar/' . $str))
        {
            $str = $this->dirName();
        }

        return $str;
    }

    /**
     * @return mixed
     */
    public function postUpdateProfile()
    {
        if ( ! $this->validator->validUpdate(Input::all()))
        {
            return Redirect::back()->withErrors($this->validator->errors())->withInput(Input::all());
        }

        if (countryIsoCodeMatch(Input::get('country')) == false)
        {
            return Redirect::back()->with('flashError', t('Invalid country'))->withInput(Input::all());
        }

        $this->user->updateProfile(Input::all());

        return Redirect::back()->with('flashSuccess', t('Your profile is updated'));
    }

    /**
     * @return mixed
     */
    public function postChangePassword()
    {
        if ( ! $this->validator->validPasswordUpdate(Input::all()))
        {
            return Redirect::back()->withErrors($this->validator->errors());
        }

        if ( ! $this->user->updatePassword(Input::all()))
        {
            return Redirect::back()->with('flashError', t('Old password is not valid'));
        }

        return Redirect::back()->with('flashSuccess', t('Your password is updated'));
    }

    /**
     * @return mixed
     */
    public function postMailSettings()
    {
        $this->user->updateMail(Input::all());

        return Redirect::back()->with('flashSuccess', t('Your mail settings are now update'));
    }
}