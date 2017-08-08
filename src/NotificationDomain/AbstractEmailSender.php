<?php

namespace NotificationDomain;

use NotificationDomain\Model\Notification;

interface AbstractEmailSender
{
    public function sendNotification(Notification $notification, $address);
}
