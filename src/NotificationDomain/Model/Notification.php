<?php

namespace NotificationDomain\Model;

class Notification
{
    /** @var string */
    private $title;

    /** @var string */
    private $content;

    /**
     * Notification constructor.
     * @param string $title
     * @param string $content
     */
    public function __construct($title, $content)
    {
        $this->title = $title;
        $this->content = $content;
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
}
