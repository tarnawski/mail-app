<?php

namespace MailAppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use MailAppBundle\Entity\User;

class SubscriberRepository extends EntityRepository
{
    public function getSubscriberByUser(User $user)
    {
        $result = $this->createQueryBuilder('subscriber')
            ->select('subscriber')
            ->join('subscriber.subscriberGroup', 'subscriber_group')
            ->join('subscriber_group.user', 'user')
            ->andWhere('user = :user')
            ->andWhere('subscriber.active = true')
            ->setParameter('user', $user)
            ->getQuery()->getResult();

        return $result;
    }
}