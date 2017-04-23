<?php

namespace MailAppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Subscriber
{
    /** @var integer */
    private $id;

    /** @var string */
    private $email;

    /** @var boolean */
    private $active;

    /** @var \DateTime */
    private $createdAt;

    /** @var SubscriberGroup */
    private $subscriberGroup;

    /** @var ArrayCollection | Attribute[] */
    private $attributes;

    public function __construct()
    {
        $this->attributes = new ArrayCollection();
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return SubscriberGroup
     */
    public function getSubscriberGroup()
    {
        return $this->subscriberGroup;
    }

    /**
     * @param SubscriberGroup $subscriberGroup
     */
    public function setSubscriberGroup(SubscriberGroup $subscriberGroup)
    {
        $this->subscriberGroup = $subscriberGroup;
    }

    /**
     * @return ArrayCollection
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param Attribute $attribute
     */
    public function addAttribute(Attribute $attribute)
    {
        if (!$this->attributes->contains($attribute)) {
            $attribute->setSubscriber($this);
            $this->attributes[] = $attribute;
        }
    }

    /**
     * @param Attribute $attribute
     */
    public function removeAttribute(Attribute $attribute)
    {
        $this->attributes->removeElement($attribute);
    }
}
