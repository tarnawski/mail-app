<?php

namespace MailAppBundle\Entity;

use FOS\OAuthServerBundle\Entity\AccessToken as BaseAccessToken;

class AccessToken extends BaseAccessToken
{
    protected $id;

    protected $client;

    protected $user;
}
