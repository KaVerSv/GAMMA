<?php

class Group
{
    private $id;
    private $name;
    private $owner_id;
    private $owner_name;
    private $owner_surname;
    private $image_path;
    private $description;
    private $posts;

    public function __construct($id, $name, $owner_id, $owner_name, $owner_surname, $image_path, $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->owner_id = $owner_id;
        $this->owner_name = $owner_name;
        $this->owner_surname = $owner_surname;
        $this->image_path = $image_path;
        $this->description = $description;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getOwnerId()
    {
        return $this->owner_id;
    }

    public function getOwnerName()
    {
        return $this->owner_name;
    }

    public function getOwnerSurname()
    {
        return $this->owner_surname;
    }

    public function getImagePath()
    {
        return $this->image_path;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getPosts()
    {
        return $this->posts;
    }

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setOwnerId($owner_id)
    {
        $this->owner_id = $owner_id;
    }

    public function setOwnerName($owner_name)
    {
        $this->owner_name = $owner_name;
    }

    public function setOwnerSurname($owner_surname)
    {
        $this->owner_surname = $owner_surname;
    }

    public function setImagePath($image_path)
    {
        $this->image_path = $image_path;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setPosts($posts)
    {
        $this->posts = $posts;
    }
}