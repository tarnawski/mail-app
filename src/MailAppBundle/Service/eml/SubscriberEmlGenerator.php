<?php

namespace MailAppBundle\Service\eml;

use MailAppBundle\Entity\Subscriber;

class SubscriberEmlGenerator
{
    /**
     * @param $subscribers
     *
     * @return string
     */
    public function generateEml($subscribers)
    {
        /** @var Subscriber $subscriber */
        foreach ($subscribers as $subscriber) {
            $emails[] = $subscriber->getEmail();
        }

        $message = \Swift_Message::newInstance();
        $message->getHeaders()->addTextHeader('X-Unsent', 1);

        $message->setSubject(null);
        $message->setTo(null);
        $message->setBcc($emails);
        $message->setBody(null, 'text/html');


        return $message->toString();
    }
}
