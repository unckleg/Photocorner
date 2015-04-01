<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
namespace Fotokutak\Mailers;

use Illuminate\Support\Facades\Config;
use Mail;

abstract class Mailer {

    public function sendTo($user, $subject, $view, $data = [])
    {
        if (Config::get('mail.from.address'))
        {
            $email = $user->email;
            Mail::queue($view, $data, function ($message) use ($email, $subject)
            {
                $message->to($email)->subject($subject);
            });
        }
    }
}