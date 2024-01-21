<?php

require_once 'PostRepository.php';
require_once __DIR__.'/../../Database.php';
require_once __DIR__.'/../models/Group.php';

class GroupRepository extends PostRepository
{
    public function getGroupProfil(int $group_id){
        $stmt = $this->database->connect()->prepare('
        SELECT g.id, g.name, g.owner_id, g.image_path, g.description, g.visibility, u.name AS firstname, u.surname FROM groups g 
        JOIN users u ON u.id = g.owner_id WHERE g.id = ?');
        $stmt->execute([$group_id]);

        $groupData = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $group_profile = new Group(
            $groupData['id'],
            $groupData['name'],
            $groupData['owner_id'],
            $groupData['owner_name'],
            $groupData['owner_surname'],
            $groupData['image_path'],
            $groupData['description'],
        );

        $group_profile->setPosts($this->getGroupPosts($group_profile->getId()));

        return $group_profile;
    }
}