<?php

namespace NotificationDomain\Command;

class NotifyViaEmailCommand
{
    /** @var string */
    private $title;

    /** @var string */
    private $content;

    /** @var string */
    private $address;

    /**
     * NotifyViaEmailCommand constructor.
     * @param string $title
     * @param string $content
     * @param string $address
     */
    public function __construct($title, $content, $address)
    {
        $this->title = $title;
        $this->content = $content;
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }
}
