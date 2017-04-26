<?php

namespace MailAppBundle\Serializer;

use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use MailAppBundle\Entity\SubscriberGroup;
use MailAppBundle\Repository\SubscriberGroupRepository;
use MailAppBundle\Repository\SubscriberRepository;

class SubscriberGroupHandler implements EventSubscriberInterface
{
    /** @var SubscriberRepository */
    private $subscriberRepository;

    public function __construct(SubscriberRepository $subscriberRepository)
    {
        $this->subscriberRepository = $subscriberRepository;
    }

    public static function getSubscribedEvents()
    {
        return [
            [
                'event' => 'serializer.post_serialize',
                'method' => 'myOnPostSerializeMethod',
                'class' => SubscriberGroup::class
            ]
        ];
    }

    public function myOnPostSerializeMethod(ObjectEvent $event)
    {
        /** @var SubscriberGroup $group */
        $group = $event->getObject();
        $visitor = $event->getVisitor();

        $visitor->addData('subscriber', $this->subscriberRepository->getActiveSubscriberCountByGroup($group));
        $visitor->addData('unsubscriber', $this->subscriberRepository->getUnActiveSubscriberCountByGroup($group));
    }
}
