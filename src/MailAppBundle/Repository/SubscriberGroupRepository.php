<?php

namespace MailAppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use MailAppBundle\Entity\User;

class SubscriberGroupRepository extends EntityRepository
{
    public function getGroupCountByUser(User $user)
    {
        $result = $this->createQueryBuilder('subscriber_group')
            ->select('count(subscriber_group)')
            ->join('subscriber_group.user', 'user')
            ->andWhere('user = :user')
            ->setParameter('user', $user)
            ->getQuery()->getSingleScalarResult();

        return $result;
    }
}