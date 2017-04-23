<?php

namespace ApiBundle\Security\Authorization\Voter;

use MailAppBundle\Entity\Subscriber;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use MailAppBundle\Entity\User;

class SubscriberVoter extends Voter
{
    const ACCESS = 'access';

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, array(self::ACCESS))) {
            return false;
        }

        if (!$subject instanceof Subscriber) {
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

        /** @var Subscriber $subscriber */
        $subscriber = $subject;

        switch ($attribute) {
            case self::ACCESS:
                return $this->canAccess($subscriber, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canAccess(Subscriber $subscriber, User $user)
    {
        if ($user->hasRole('ROLE_ADMIN')) {
            return true;
        }
        if ($subscriber->getUser() == $user) {
            return true;
        }

        return false;
    }
}
