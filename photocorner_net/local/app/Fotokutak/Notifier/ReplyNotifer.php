<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
namespace Fotokutak\Notifier;

use Fotokutak\Mailers\ImageMailer;
use Images;
use User;

class ReplyNotifer extends Notifier {

    public function __construct(ImageMailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function replyNotice(User $to, User $from, Images $on, $reply, $sendEmail = false)
    {
        $this->sendNew($to->id, $from->id, 'reply', $on->id);
        if ($sendEmail === true)
        {
            $this->mailer->replyMail($to, $from, $on, $reply);
        }
    }
}