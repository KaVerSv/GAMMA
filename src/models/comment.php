<?php

class Comment
{
    private $id;
    private $user_id;
    private $author_name;
    private $author_surname;
    private $author_photo;
    private $content;

    public function __construct($id, $user_id, $author_name, $author_surname, $author_photo, $content)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->author_name = $author_name;
        $this->author_surname = $author_surname;
        $this->author_photo = $author_photo;
        $this->content = $content;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getAuthorName() {
        return $this->author_name;
    }

    public function setAuthorName($author_name) {
        $this->author_name = $author_name;
    }

    public function getAuthorSurname() {
        return $this->author_surname;
    }

    public function setAuthorSurname($author_surname) {
        $this->author_surname = $author_surname;
    }

    public function getAuthorPhoto() {
        return $this->author_photo;
    }

    public function setAuthorPhoto($author_photo) {
        $this->author_photo = $author_photo;
    }
}
?>
