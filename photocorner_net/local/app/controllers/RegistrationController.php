<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
use Fotokutak\Mailers\UserMailer as Mailer;
use Fotokutak\Repository\UsersRepositoryInterface;
use Fotokutak\Validator\UserValidator;

class RegistrationController extends BaseController {

    public function __construct(Mailer $mailer, UserValidator $validator, UsersRepositoryInterface $user)
    {
        $this->mailer = $mailer;
        $this->validator = $validator;
        $this->user = $user;
    }

    public function validateUser($username, $code)
    {
        if ( ! $this->user->activate($username, $code))
        {
            return Redirect::route('gallery')->with('flashError', t('You are not registered with us'));
        }

        return Redirect::route('gallery')->with('flashSuccess', t('Your account is now activated'));
    }

    public function getIndex()
    {
        $title = t('Registration');

        return View::make('registration/index', compact('title'));
    }

    public function postIndex()
    {
        if ( ! $this->validator->validRegistration(Input::all()))
        {
            return Redirect::to('registration')->withErrors($this->validator->errors());
        }

        if ( ! $this->user->createNew(Input::all()))
        {
            return Redirect::to('registration')->with('flashError', 'Please try again, enable to create user');
        }

        return Redirect::to('login')->with('flashSuccess', t('A confirmation email is sent to your mail'));
    }

    public function getFacebook()
    {
        if ( ! Session::get('facebookDetails'))
        {
            return Redirect::to('login')->with('flashError', t('Please try again'));
        }

        $title = t('Facebook Login');

        return View::make('registration/facebook', compact('title'));
    }

    public function postFacebook()
    {
        $session = Session::get('facebookDetails');
        if ( ! $session)
        {
            return Redirect::to('login');
        }

        if ( ! $this->validator->validFacebookRegistration(Input::all()))
        {
            return Redirect::to('registration/facebook')->withErrors($this->validator->errors());
        }


        if ($this->user->createFacebookUser(Input::all(), $session))
        {
            return Redirect::route('gallery')->with('flashSuccess', t('Congratulations your account is created and activated'));
        }

    }

    public function getGoogle()
    {
        if (Session::get('googleDetails'))
        {
            return View::make('registration/google')->with('title', t('Registration'));
        }

        return Redirect::to('login')->with('flashError', t('Please try again'));
    }

    public function postGoogle()
    {
        $session = Session::get('googleDetails');
        if ( ! $session)
        {
            return Redirect::to('login')->with('flashError', t('Please try again'));
        }


        if ( ! $this->validator->validGoogleRegistration(Input::all()))
        {
            return Redirect::to('registration/google')->withErrors($this->validator->errors());
        }


        if ($this->user->createGoogleUser(Input::all(), $session))
        {
            return Redirect::route('gallery')->with('flashSuccess', t('Congratulations your account is created and activated'));
        }

    }
}