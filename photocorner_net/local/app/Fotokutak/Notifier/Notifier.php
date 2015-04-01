<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */
namespace Fotokutak\Notifier;

use Notification;

abstract class Notifier {

    public function sendNew($to, $from, $type, $on_id)
    {
        $this->notification = new Notification();
        $this->notification->user_id = $to;
        $this->notification->from_id = $from;
        $this->notification->type = $type;
        $this->notification->on_id = $on_id;
        $this->notification->save();
    }
}