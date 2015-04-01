<?php
use Fotokutak\Validator\UserValidator;

class RemindersController extends Controller {

    public function __construct(UserValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Display the password reminder view.
     *
     * @return Response
     */
    public function getRemind()
    {
        return View::make('password.remind')->with('title', t('Password Reset'));
    }

    /**
     * Handle a POST request to remind a user of their password.
     *
     * @return Response
     */
    public function postRemind()
    {
        if ( ! $this->validator->validPasswordRest(Input::all()))
        {
            return Redirect::to('password/remind')->withErrors($this->validator->errors());
        }

        switch ($response = Password::remind(Input::only('email')))
        {
            case Password::INVALID_USER:
                return Redirect::back()->with('flashError', 'No user exists with this email address');

            case Password::REMINDER_SENT:
                return Redirect::back()->with('flashSuccess', 'Password Reset link is sent to your email');
        }
    }

    /**
     * Display the password reset view for the given token.
     *
     * @param  string $token
     * @return Response
     */
    public function getReset($token = null)
    {
        if (is_null($token))
        {
            App::abort(404);
        }

        return View::make('password.reset')->with('token', $token)->with('title', t('Password Reset'));
    }

    /**
     * Handle a POST request to reset a user's password.
     *
     * @return Response
     */
    public function postReset()
    {
        $credentials = Input::only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $response = Password::reset($credentials, function ($user, $password)
        {
            $user->password = Hash::make($password);

            $user->save();
        });

        switch ($response)
        {
            case Password::INVALID_PASSWORD:
            case Password::INVALID_TOKEN:
            case Password::INVALID_USER:
                return Redirect::back()->with('flashError', 'No user exists with this email address');

            case Password::PASSWORD_RESET:
                return Redirect::to('login')->with('flashSuccess', t('Your password is now resetted'));
        }
    }

}