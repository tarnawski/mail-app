<?php

namespace MailAppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use MailAppBundle\Entity\SubscriberGroup;
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

    public function getActiveSubscriberCountByGroup(SubscriberGroup $group)
    {
        $result = $this->createQueryBuilder('subscriber')
            ->select('count(subscriber)')
            ->join('subscriber.subscriberGroup', 'subscriber_group')
            ->andWhere('subscriber_group = :subscriber_group')
            ->andWhere('subscriber.active = true')
            ->setParameter('subscriber_group', $group)
            ->getQuery()->getSingleScalarResult();

        return $result;
    }

    public function getUnActiveSubscriberCountByGroup(SubscriberGroup $group)
    {
        $result = $this->createQueryBuilder('subscriber')
            ->select('count(subscriber)')
            ->join('subscriber.subscriberGroup', 'subscriber_group')
            ->andWhere('subscriber_group = :subscriber_group')
            ->andWhere('subscriber.active = false')
            ->setParameter('subscriber_group', $group)
            ->getQuery()->getSingleScalarResult();

        return $result;
    }
}