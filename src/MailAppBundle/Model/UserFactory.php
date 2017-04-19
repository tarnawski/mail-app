<?php

namespace MailAppBundle\Model;

use MailAppBundle\Entity\User;

class UserFactory
{
    public function buildAfterRegistration($username, $email, $password)
    {
        $user = $this->createUser($username, $email);
        $user->setPlainPassword($password);

        return $user;
    }

    /**
     * @param string $username
     * @param string $email
     * @return User
     */
    private function createUser($username, $email)
    {
        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setRoles(['ROLE_API']);

        return $user;
    }
}
