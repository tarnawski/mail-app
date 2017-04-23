<?php

namespace ApiBundle\Security\Authorization\Voter;

use MailAppBundle\Entity\SubscriberGroup;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use MailAppBundle\Entity\User;

class SubscriberGroupVoter extends Voter
{
    const ACCESS = 'access';

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, array(self::ACCESS))) {
            return false;
        }

        if (!$subject instanceof SubscriberGroup) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        if (!$user instanceof User) {
            return false;
        }

        /** @var SubscriberGroup $subscriberGroup */
        $subscriberGroup = $subject;

        switch ($attribute) {
            case self::ACCESS:
                return $this->canAccess($subscriberGroup, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canAccess(SubscriberGroup $subscriberGroup, User $user)
    {
        if ($user->hasRole('ROLE_ADMIN')) {
            return true;
        }
        if ($subscriberGroup->getUser() == $user) {
            return true;
        }

        return false;
    }
}
