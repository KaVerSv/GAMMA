<?php

class UserProfile
{
    private $id;
    private $name;
    private $surname;
    private $image_path;
    private $description;
    private $posts;

    public function __construct($id, $name, $surname, $image_path, $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
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

  public function getSurname()
  {
      return $this->surname;
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

  public function setSurname($surname)
  {
      $this->surname = $surname;
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