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

    public function getActiveSubscriberCountByUser(User $user)
    {
        $result = $this->createQueryBuilder('subscriber')
            ->select('count(subscriber)')
            ->join('subscriber.subscriberGroup', 'subscriber_group')
            ->join('subscriber_group.user', 'user')
            ->andWhere('user = :user')
            ->andWhere('subscriber.active = true')
            ->setParameter('user', $user)
            ->getQuery()->getSingleScalarResult();

        return $result;
    }

    public function getUnActiveSubscriberCountByUser(User $user)
    {
        $result = $this->createQueryBuilder('subscriber')
            ->select('count(subscriber)')
            ->join('subscriber.subscriberGroup', 'subscriber_group')
            ->join('subscriber_group.user', 'user')
            ->andWhere('user = :user')
            ->andWhere('subscriber.active = false')
            ->setParameter('user', $user)
            ->getQuery()->getSingleScalarResult();

        return $result;
    }
}