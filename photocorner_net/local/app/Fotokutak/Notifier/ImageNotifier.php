<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
namespace Fotokutak\Notifier;

use Fotokutak\Mailers\ImageMailer;
use Images;
use User;

class ImageNotifer extends Notifier {

    public function __construct(ImageMailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function comment(Images $image, User $from, $comment)
    {
        $this->sendNew($image->user_id, $from->id, 'comment', $image->id);

        $to = $image->user;
        $comment = $comment;
        $link = route('image', ['id' => $image->id, 'slug' => $image->slug]);

        $this->mailer->commentMail($to, $from, $comment, $link);
    }

    public function favorite(Images $image, User $from)
    {
        if ($image->user_id !== $from->id)
        {
            $this->sendNew($image->user_id, $from->id, 'like', $image->id);
        }

        $this->mailer->favoriteMail($image->user, $from, $image);
    }
}