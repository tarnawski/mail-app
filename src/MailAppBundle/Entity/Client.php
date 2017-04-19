<?php

namespace MailAppBundle\Entity;

use FOS\OAuthServerBundle\Entity\Client as BaseClient;

class Client extends BaseClient
{
    protected $id;

    public function __construct()
    {
        parent::__construct();
    }
}
