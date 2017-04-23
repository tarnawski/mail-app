<?php

namespace MailAppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;

class User extends BaseUser
{
    const ROLE_API = 'ROLE_API';

    public static $ROLES = array(
        self::ROLE_API => self::ROLE_API
    );

    /** @var integer */
    protected $id;

    /** @var  ArrayCollection|SubscriberGroup[] */
    private $subscriberGroups;

    public function __construct()
    {
        parent::__construct();
        $this->groups = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getSubscriberGroups()
    {
        return $this->subscriberGroups;
    }

    /**
     * @param SubscriberGroup $subscriberGroup
     */
    public function addSubscriberGroup(SubscriberGroup $subscriberGroup)
    {
        if (!$this->subscriberGroups->contains($subscriberGroup)) {
            $subscriberGroup->setUser($this);
            $this->subscriberGroups[] = $subscriberGroup;
        }
    }

    /**
     * @param SubscriberGroup $subscriberGroup
     */
    public function removeSubscriberGroup(SubscriberGroup $subscriberGroup)
    {
        $this->groups->removeElement($subscriberGroup);
    }
}
