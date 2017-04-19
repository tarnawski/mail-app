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

    /** @var  ArrayCollection|Subscriber[] */
    private $subscribers;

    public function __construct()
    {
        parent::__construct();
        $this->subscribers = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getSubscribers()
    {
        return $this->subscribers;
    }

    /**
     * @param Subscriber $subscriber
     */
    public function addSubscriber(Subscriber $subscriber)
    {
        if (!$this->subscribers->contains($subscriber)) {
            $subscriber->setUser($this);
            $this->subscribers[] = $subscriber;
        }
    }

    /**
     * @param Subscriber $subscriber
     */
    public function removeSubscriber(Subscriber $subscriber)
    {
        $this->subscribers->removeElement($subscriber);
    }
}
