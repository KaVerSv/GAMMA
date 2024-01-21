<?php

require_once 'CommentRepository.php';
require_once __DIR__.'/../../Database.php';
require_once __DIR__.'/../models/Post.php';

class PostRepository extends CommentRepository
{
    /*
    public function getPostById($postId): ?Post
    {
        $stmt = $this->database->connect()->prepare('SELECT * FROM posts WHERE id = :id');
        $stmt->bindParam(':id', $postId, PDO::PARAM_INT);
        $stmt->execute();

        $postData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$postData) {
            return null;
        }

        return new Post(
            $postData['id'],
            $postData['user_id'],
            $postData['title'],
            $postData['content'],
            $postData['group_id'],
            $postData['visibility'],
            $postData['time'],

        );
    }
    */

    public function addPost(Post $post)
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO posts (user_id, title, content, group_id, visibility, time)
            VALUES (:user_id, :title, :content, :group_id, :visibility, :time)
        ');

        $stmt->bindParam(':user_id', $post->getUserId(), PDO::PARAM_INT);
        $stmt->bindParam(':title', $post->getTitle(), PDO::PARAM_STR);
        $stmt->bindParam(':content', $post->getContent(), PDO::PARAM_STR);
        $stmt->bindParam(':group_id', $post->getGroupId(), PDO::PARAM_INT);
        $stmt->bindParam(':visibility', $post->getVisibility(), PDO::PARAM_STR);
        $stmt->bindParam(':time', $post->getTime(), PDO::PARAM_STR);

        if (!$stmt->execute()) {
            throw new Exception('Error adding post.');
        }
    }

    public function getRelatedPhotos(int $postId)
    {
        $stmt = $this->database->connect()->prepare("
            SELECT image_path FROM posts_images
            WHERE post_id = ?
        ");
        $stmt->execute([$postId]);

        $relatedPhotos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $photoPaths = array_column($relatedPhotos, 'image_path');

        return $photoPaths;
    }

    public function getLatestPosts(): array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT p.id, p.user_id, p.title, p.content, p.group_id, p.visibility, p.time, u.name, u.surname, u_p.image_path AS image 
            FROM posts p 
            JOIN users u ON p.user_id = u.id 
            JOIN user_profiles u_p ON u.id = u_p.id 
            ORDER BY time DESC
            LIMIT 20
        ');
        $stmt->execute();

        $postsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $latestPosts = [];

        foreach ($postsData as $postData) {
            $latestPosts[] = new Post(
                $postData['id'],
                $postData['user_id'],
                $postData['title'],
                $postData['content'],
                $postData['group_id'],
                $postData['visibility'],
                $postData['time'],
                $postData['name'],
                $postData['surname'],
                $postData['image']
            );
        }

        foreach ($latestPosts as $post) {
            $post->setComments(CommentRepository::getRelatedComments($post->getId()));
            $post->setPhotos($this->getRelatedPhotos($post->getId()));
        }

        return $latestPosts;
    }
    
    

}