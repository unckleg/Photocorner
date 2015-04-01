<?php

/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
class LoginController extends BaseController {

    /**
     * POST Login by both email and username
     * save client IP in database if not confirmed then logout
     *
     * @return mixed
     */
    public function postLogin()
    {
        // Check if input type is email or not
        if (filter_var(Input::get('username'), FILTER_VALIDATE_EMAIL))
        {
            $input = [
                'email'    => Input::get('username'),
                'password' => Input::get('password')
            ];

            $validator = [
                'email'    => ['required'],
                'password' => ['required']
            ];
        } else
        {
            $input = [
                'username' => Input::get('username'),
                'password' => Input::get('password')
            ];

            $validator = [
                'username' => ['required'],
                'password' => ['required']
            ];
        }
        $validator = Validator::make($input, $validator);
        if ($validator->fails())
        {
            return Redirect::route('login')->withErrors($validator);
        }
        $remember = Input::get('remember-me');
        if ( ! empty($remember))
        {
            if (Auth::attempt($input, true))
            {
                if (Auth::user()->confirmed != 1)
                {
                    Auth::logout();

                    return Redirect::route('login')->with('flashError', t('Email activation is required'));
                }
                $user = Auth::user();
                $user->ip_address = Request::getClientIp();
                $user->save();

                return Redirect::route('gallery')->with('flashSuccess', t('You are now logged in'));
            }
        }
        if (Auth::attempt($input))
        {
            $user = Auth::user();
            if (Auth::user()->confirmed != 1)
            {
                Auth::logout();

                return Redirect::route('login')->with('flashError', t('Email activation is required'));
            }
            $user->ip_address = Request::getClientIp();
            $user->save();

            return Redirect::route('gallery')->with('flashSuccess', t('You are now logged in'));
        }

        return Redirect::route('login')->with('flashError', t('Your username/password combination was incorrect'));
    }

    /**
     * Make view of login
     *
     * @return mixed
     */
    public function getLogin()
    {
        $title = t('Login');

        return View::make('login/index', compact('title'));
    }

    /**
     * Logout from site
     *
     * @return mixed
     */
    public function getLogout()
    {
        Auth::logout();

        return Redirect::route('home');
    }

    /**
     * Login by facebook, check if only email address in database
     * then save users facebook is to database for future user.
     * If both not exits starts session and redirect to registration page
     *
     * @return mixed
     */
    public function loginWithFacebook()
    {
        $code = Input::get('code');
        $fb = OAuth::consumer('Facebook');
        if ( ! empty($code))
        {
            $token = $fb->requestAccessToken($code);
            $facebook = json_decode($fb->request('/me'), true);
            if (isset($facebook['id']) && isset($facebook['email']))
            {
                $user = User::where('fbid', '=', $facebook['id'])->first();
                if ($user)
                {
                    if ($user['fbid'] == $facebook['id'])
                    {
                        Auth::loginUsingId($user->id);
                        $user = Auth::user();
                        $user->ip_address = Request::getClientIp();
                        $user->save();

                        return Redirect::route('gallery')->with('flashSuccess', t('You are now logged in'));
                    }
                }
                $user = User::where('email', '=', $facebook['email'])->first();
                if ($user)
                {
                    if ($user->email == $facebook['email'])
                    {
                        Auth::loginUsingId($user->id);
                        $user->fbid = $facebook['id'];
                        $user->ip_address = Request::getClientIp();
                        $user->save();

                        return Redirect::route('gallery')->with('flashSuccess', t('You are now logged in'));
                    }
                }
            } else
            {
                return Redirect::to('login')->with('flashError', t('Please try again'));
            }
            Session::put('facebookDetails', $facebook);

            return Redirect::to('registration/facebook');

        } else
        {
            $url = $fb->getAuthorizationUri();

            return Redirect::to((string) $url);
        }

    }


    public function loginWithGoogle()
    {
        $code = Input::get('code');
        $googleService = OAuth::consumer('Google');
        if ( ! empty($code))
        {
            $token = $googleService->requestAccessToken($code);
            $google = json_decode($googleService->request('https://www.googleapis.com/oauth2/v1/userinfo'), true);
            if (isset($google['id']) && isset($google['email']))
            {
                $user = User::where('gid', '=', $google['id'])->first();
                if ($user)
                {
                    if ($user['gid'] == $google['id'])
                    {
                        Auth::loginUsingId($user->id);
                        $user = Auth::user();
                        $user->ip_address = Request::getClientIp();
                        $user->save();

                        return Redirect::route('gallery')->with('flashSuccess', t('You are now logged in'));
                    }
                }
                $user = User::where('email', '=', $google['email'])->first();
                if ($user)
                {
                    if ($user->email == $google['email'])
                    {
                        Auth::loginUsingId($user->id);
                        $user->gid = $google['id'];
                        $user->ip_address = Request::getClientIp();
                        $user->save();

                        return Redirect::route('gallery')->with('flashSuccess', t('You are now logged in'));
                    }
                }
            } else
            {
                return Redirect::to('login')->with('flashError', t('Please try again'));
            }
            Session::put('googleDetails', $google);

            return Redirect::to('registration/google');
        } else
        {
            $url = $googleService->getAuthorizationUri();

            return Redirect::to((string) $url);
        }
    }
}