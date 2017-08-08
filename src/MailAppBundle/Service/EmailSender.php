<?php

namespace MailAppBundle\Service;

use NotificationDomain\AbstractEmailSender;
use NotificationDomain\Model\Notification;

class EmailSender implements AbstractEmailSender
{
    /** @var string */
    private $mailBoxAddress;

    /** @var \Swift_Mailer */
    private $mailer;

    public function __construct($mailBoxAddress, \Swift_Mailer $mailer)
    {
        $this->mailBoxAddress = $mailBoxAddress;
        $this->mailer = $mailer;
    }

    public function sendNotification(Notification $notification, $address)
    {
        $message = new \Swift_Message();
        $message->setSubject($notification->getTitle());
        $message->setFrom($this->mailBoxAddress);
        $message->setTo($address);
        $message->setBody($notification->getContent());

        $this->mailer->send($message);
    }
}