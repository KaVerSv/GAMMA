<?php

class Post
{
    private $id;
    private $user_id;
    private $title;
    private $content;
    private $photos;
    private $group_id;
    private $visibility;
    private $time;
    private $author_name;
    private $author_surname;
    private $author_photo;
    private $comments;

    public function __construct($id, $user_id, $title, $content, $group_id, $visibility, $time, $author_name, $author_surname, $author_photo)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->title = $title;
        $this->content = $content;
        $this->group_id = $group_id;
        $this->visibility = $visibility;
        $this->time = $time;
        $this->author_name = $author_name;
        $this->author_surname = $author_surname;
        $this->author_photo = $author_photo;
    }


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setPhotos($photos)
    {
        $this->photos = $photos;
    }

    public function getPhotos()
    {
        return $this->photos;
    }

    public function getGroupId()
    {
        return $this->group_id;
    }

    public function setGroupId($group_id)
    {
        $this->group_id = $group_id;
    }

    public function getVisibility()
    {
        return $this->visibility;
    }

    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function setTime($time)
    {
        $this->time = $time;
    }

    public function getAuthorName()
    {
        return $this->author_name;
    }

    public function setAuthorName($author_name)
    {
        $this->author_name = $author_name;
    }

    public function getAuthorSurname()
    {
        return $this->author_surname;
    }

    public function setAuthorSurname($author_surname)
    {
        $this->author_surname = $author_surname;
    }

    public function getAuthorPhoto()
    {
        return $this->author_photo;
    }

    public function setAuthorPhoto($author_photo)
    {
        $this->author_photo = $author_photo;
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    public function getGalleryPhotos()
{
    $photos = array();

    foreach ($this->photos as $photo) {
        $photos[] = "../../public/img/" . $photo;
    }

    return $photos;
}
}