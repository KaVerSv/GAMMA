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

    // Getter i Setter dla $id
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    // Getter i Setter dla $user_id
    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    // Getter i Setter dla $author_name
    public function getAuthorName() {
        return $this->author_name;
    }

    public function setAuthorName($author_name) {
        $this->author_name = $author_name;
    }

    // Getter i Setter dla $author_surname
    public function getAuthorSurname() {
        return $this->author_surname;
    }

    public function setAuthorSurname($author_surname) {
        $this->author_surname = $author_surname;
    }

    // Getter i Setter dla $author_photo
    public function getAuthorPhoto() {
        return $this->author_photo;
    }

    public function setAuthorPhoto($author_photo) {
        $this->author_photo = $author_photo;
    }

    // Getter i Setter dla $content
    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }
}
