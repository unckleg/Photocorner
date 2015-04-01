<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
namespace Fotokutak\Notifier;

use Fotokutak\Mailers\UserMailer;
use User;

class FollowNotifier extends Notifier {

    public function __construct(UserMailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function follow(User $to, User $from)
    {
        $this->sendNew($to->id, $from->id, 'follow', null);

        $this->mailer->followMail($to, $from);
    }
}
