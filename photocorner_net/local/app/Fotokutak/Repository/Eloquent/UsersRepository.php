<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
namespace Fotokutak\Repository\Eloquent;

use Fotokutak\Mailers\UserMailer;
use Fotokutak\Repository\UsersRepositoryInterface;
use Auth;
use Carbon;
use Feed;
use Hash;
use Illuminate\Support\Facades\DB;
use Images;
use URL;
use User;

class UsersRepository extends AbstractRepository implements UsersRepositoryInterface {

    /**
     * @param UserMailer $mailer
     * @param User       $user
     * @param Images     $images
     */
    public function __construct(UserMailer $mailer, User $user, Images $images)
    {
        $this->model = $user;
        $this->mailer = $mailer;
        $this->images = $images;
    }

    /**
     * @param $id
     * @return bool
     */
    public function getById($id)
    {
        $user = $this->model->whereId($id)->first();
        if ( ! $user)
        {
            return false;
        }

        return $user;
    }

    /**
     * @param $username
     * @return bool
     */
    public function getByUsername($username)
    {
        $user = $this->model->where('username', $username)->with('followers.user')->first();
        if ( ! $user)
        {
            return false;
        }

        return $user;
    }

    /**
     * @return mixed
     */
    public function getAllUsers()
    {
        return $this->model->confirmed()->with('latestImages', 'comments')->paginate(perPage());
    }

    /**
     * @return mixed
     */
    public function getTrendingUsers()
    {
        return $this->model->confirmed()
            ->leftJoin('comments', 'comments.user_id', '=', 'users.id')
            ->leftJoin('images', 'images.user_id', '=', 'users.id')
            ->select('users.*', DB::raw('count(comments.user_id)*5 + count(images.user_id)*2 as popular'))
            ->groupBy('users.id')->with('images', 'latestImages', 'comments')->orderBy('popular', 'desc')
            ->paginate(perPage());
    }


    /**
     * @param User $user
     * @internal param $username
     * @return mixed
     */
    public function getUsersFavorites(User $user)
    {
        $images = $user->favorites()->lists('image_id');
        if ( ! $images)
        {
            $images = [null];
        }

        return $this->images->approved()->whereIn('id', $images)->orderBy('approved_at', 'desc')->paginate(perPage());
    }

    /**
     * @param $username
     * @return mixed
     */
    public function getUsersFollowers($username)
    {
        return $this->model->where('username', '=', $username)->with('followers')->first();
    }

    /**
     * @param $username
     * @return mixed
     */
    public function getUsersFollowing($username)
    {
        return $this->model->whereUsername($username)->with('following.followingUser')->first();
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function getUsersImages(User $user)
    {
        return $this->images->approved()->whereUserId($user->id)->with('comments', 'favorite', 'user', 'category')->orderBy('approved_at', 'desc')->paginate(perPage());
    }

    /**
     * @param array $input
     * @return bool
     */
    public function createNew(array $input)
    {
        $activationCode = sha1(str_random(11) . (time() * rand(2, 2000)));

        $this->model->username = $input['username'];
        $this->model->fullname = $input['fullname'];
        $this->model->gender = $input['gender'];
        $this->model->email = $input['email'];
        $this->model->password = Hash::make($input['password']);
        $this->model->confirmed = $activationCode;
        $this->model->save();

        $this->mailer->activation($this->model, $activationCode);

        return true;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function notifications($id)
    {
        $user = $this->model->whereId($id)->with('notifications')->first();
        $notices = $user->notifications()->orderBy('created_at', 'desc')->paginate(perPage());
        foreach ($notices as $notice)
        {
            if ( ! $notice->is_read)
            {
                $notice->is_read = 1;
                $notice->save();
            }


        }

        return $notices;
    }

    /**
     * @param $username
     * @param $activationCode
     * @return bool
     */
    public function activate($username, $activationCode)
    {
        $user = $this->model->where('username', '=', $username)->first();
        if ($user->confirmed === $activationCode)
        {
            $user->confirmed = 1;
            $user->save();

            return true;
        }

        return false;
    }

    /**
     * @param array $input
     * @param null  $session
     * @return mixed
     */
    public function createFacebookUser(array $input, $session = null)
    {
        if ( ! $session)
        {
            return;
        }
        $user = $this->getNew();
        $user->username = $input['username'];
        $user->password = Hash::make($input['password']);
        $user->fbid = $session['id'];
        $user->email = $session['email'];
        if (isset($session['gender']))
        {
            $user->gender = $session['gender'];
        }
        $user->fullname = $session['name'];
        $user->confirmed = 1;
        $user->save();
        Auth::loginUsingId($user->id);

        return $user;
    }

    /**
     * @param array $input
     * @param null  $session
     * @return mixed
     */
    public function createGoogleUser(array $input, $session = null)
    {
        if ( ! $session)
        {
            return;
        }
        $user = $this->getNew();
        $user->username = $input['username'];
        $user->password = Hash::make($input['password']);
        $user->gid = $session['id'];
        $user->email = $session['email'];
        if (isset($session['gender']))
        {
            $user->gender = $session['gender'];
        }
        $user->fullname = $session['name'];
        $user->confirmed = 1;
        $user->save();
        Auth::loginUsingId($user->id);

        return $user;
    }


    /**
     * @param $input
     * @return mixed
     */
    public function updateProfile($input)
    {
        $update = Auth::user();
        $update->fullname = $input['fullname'];
        $update->dob = $input['dob'];
        $update->gender = $input['gender'];
        $update->country = $input['country'];
        $update->about_me = isset($input['about_me']) ? $input['about_me'] : null;
        $update->blogurl = isset($input['blogurl']) ? $input['blogurl'] : null;
        $update->fb_link = isset($input['fb_link']) ? $input['fb_link'] : null;
        $update->tw_link = isset($input['tw_link']) ? $input['tw_link'] : null;
        $update->save();

        return $update;
    }

    /**
     * @param $input
     * @return bool
     */
    public function updateMail($input)
    {
        // TODO : improve this
        $user = Auth::user();
        if (isset($input['emailcomment']))
        {
            $user->email_comment = 1;
        } else
        {
            $user->email_comment = 0;
        }

        if (isset($input['emailreply']))
        {
            $user->email_reply = 1;
        } else
        {
            $user->email_reply = 0;
        }

        if (isset($input['emailfavorite']))
        {
            $user->email_favorite = 1;
        } else
        {
            $user->email_favorite = 0;
        }

        if (isset($input['emailfollow']))
        {
            $user->email_follow = 1;
        } else
        {
            $user->email_follow = 0;
        }

        $user->save();

        return true;
    }

    /**
     * @param $input
     * @return bool
     */
    public function updatePassword($input)
    {
        if (Hash::check($input['currentpassword'], Auth::user()->password))
        {
            $user = Auth::user();
            $user->password = Hash::make($input['password']);
            $user->save();

            return true;
        }

        return false;

    }

    /**
     * @return mixed
     */
    public function getFeedForUser()
    {
        $following = Auth::user()->following()->lists('follow_id');
        if ( ! $following)
        {
            $following = [null];
        }

        return $this->images->whereIn('user_id', $following)->orderBy('approved_at', 'desc')->paginate(perPage());
    }


    /**
     * @param $username
     * @return mixed
     */
    public function getUsersRss($username)
    {
        $user = User::where('username', '=', $username)->first();
        $images = Images::approved()->where('user_id', '=', $user->id)->orderBy('created_at', 'desc')->take(60)->get();

        $feed = Feed::make();
        $feed->title = siteSettings('siteName') . '/user/' . $user->username;
        $feed->description = siteSettings('siteName') . '/user/' . $user->username;
        $feed->link = URL::to('user/' . $user->username);
        $feed->lang = 'en';

        foreach ($images as $post)
        {
            $desc = '<a href="' . route('image', ['id' => $post->id, 'slug' => $post->slug]) . '"><img src="' . asset(cropResize('uploads/' . $post->image_name . '.' . $post->type)) . '" /></a><br/><br/>
                <h2><a href="' . route('image', ['id' => $post->id, 'slug' => $post->slug]) . '">' . $post->title . '</a>
                by
                <a href="' . route('user', ['username' => $post->user->username]) . '">' . ucfirst($user->fullname) . '</a>
                ( <a href="' . route('user', ['username' => $post->user->username]) . '">' . $user->username . '</a> )
                </h2>' . $post->image_description;
            $feed->add(ucfirst($post->title), $user->fullname, route('image', ['id' => $post->id, 'slug' => $post->slug]), $post->created_at, $desc);
        }

        return $feed->render('atom');
    }

}