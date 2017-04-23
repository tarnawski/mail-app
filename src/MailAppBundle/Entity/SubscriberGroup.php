<?php

namespace MailAppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class SubscriberGroup
{
    /** @var integer */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $groupKey;

    /** @var User */
    private $user;

    /** @var ArrayCollection | Subscriber[] */
    private $subscribers;

    public function __construct()
    {
        $this->subscribers = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getGroupKey()
    {
        return $this->groupKey;
    }

    /**
     * @param string $groupKey
     */
    public function setGroupKey($groupKey)
    {
        $this->groupKey = $groupKey;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
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
    public function addAttribute(Subscriber $subscriber)
    {
        if (!$this->subscribers->contains($subscriber)) {
            $subscriber->setGroup($this);
            $this->subscribers[] = $subscriber;
        }
    }

    /**
     * @param Subscriber $subscriber
     */
    public function removeAttribute(Subscriber $subscriber)
    {
        $this->subscribers->removeElement($subscriber);
    }
}
