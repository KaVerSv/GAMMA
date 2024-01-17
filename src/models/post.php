<?php

class Post
{
    private $id;
    private $user_id;
    private $title;
    private $content;
    private $group_id;
    private $visibility;
    private $time;

    public function __construct($id, $user_id, $title, $content, $group_id, $visibility, $time)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->title = $title;
        $this->content = $content;
        $this->group_id = $group_id;
        $this->visibility = $visibility;
        $this->time = $time;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getGroupId()
    {
        return $this->group_id;
    }

    public function getVisibility()
    {
        return $this->visibility;
    }

    public function getTime()
    {
        return $this->time;
    }
}