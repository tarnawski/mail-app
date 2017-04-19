<?php

namespace MailAppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Subscriber
{
    /** @var integer */
    private $id;

    /** @var string */
    private $secret;

    /** @var \DateTime */
    private $createdAt;

    /** @var User */
    private $user;

    /** @var ArrayCollection | Attribute[] */
    private $attributes;

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
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * @param string $secret
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
    }

    /**
     * @return \DateTime
     */
    public function getCreateAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreateAt($createdAt)
    {
        $this->createdAt = $createdAt;
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