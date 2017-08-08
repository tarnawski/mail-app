<?php

namespace NotificationDomain\Command;

use NotificationDomain\AbstractEmailSender;
use NotificationDomain\Model\Notification;

class NotifyViaEmailCommandHandler
{
    /** @var AbstractEmailSender */
    private $emailSender;

    public function __construct(AbstractEmailSender $emailSender)
    {
        $this->emailSender = $emailSender;
    }

    public function handle(NotifyViaEmailCommand $notifyViaEmailCommand)
    {
        $notification = new Notification(
            $notifyViaEmailCommand->getTitle(),
            $notifyViaEmailCommand->getContent()
        );

        $this->emailSender->sendNotification(
            $notification,
            $notifyViaEmailCommand->getAddress()
        );
    }
}
