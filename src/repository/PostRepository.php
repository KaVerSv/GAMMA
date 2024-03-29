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

    public function addPost(Post $post, ?array $photos)
{
    $stmt = $this->database->connect()->prepare('
        INSERT INTO posts (user_id, title, content, group_id, visibility)
        VALUES (:user_id, :title, :content, :group_id, :visibility);
    ');

    $stmt->bindParam(':user_id', $post->getUserId(), PDO::PARAM_INT);
    $stmt->bindParam(':title', $post->getTitle(), PDO::PARAM_STR);
    $stmt->bindParam(':content', $post->getContent(), PDO::PARAM_STR);
    $stmt->bindParam(':group_id', $post->getGroupId(), PDO::PARAM_INT);
    $stmt->bindParam(':visibility', $post->getVisibility(), PDO::PARAM_STR);

    if (!$stmt->execute()) {
        throw new Exception('Error adding post.');
    }

    $pdo = $this->database->connect();

    $stmt = $pdo->prepare('SELECT id FROM posts ORDER BY id DESC LIMIT 1');
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && $photos !== null) {
        $postId = $result['id'];

        foreach ($photos as $photo) {
            $stmt = $pdo->prepare('
                INSERT INTO posts_images (post_id, image_path)
                VALUES (?, ?)
            ');

            $stmt->execute([
                $postId,
                $photo
            ]);
        }
    }
}


    public function getRelatedPhotos(int $postId){
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

    public function search(string $search){
        $stmt = $this->database->connect()->prepare('
            SELECT p.id, p.user_id, p.title, p.content, p.group_id, p.visibility, p.time, u.name, u.surname, u_p.image_path AS image 
            FROM posts p 
            JOIN users u ON p.user_id = u.id 
            JOIN user_profiles u_p ON u.id = u_p.id 
            WHERE p.title ILIKE ?
        ');
        
        $stmt->execute(["%$search%"]);
    
        $postsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $found_posts = [];
    
        foreach ($postsData as $postData) {
            $found_posts[] = new Post(
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
    
        foreach ($found_posts as $post) {
            $post->setComments(CommentRepository::getRelatedComments($post->getId()));
            $post->setPhotos($this->getRelatedPhotos($post->getId()));
        }
    
        return $found_posts;
    }

    public function getGroupPosts(int $group_id)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT p.id, p.user_id, p.title, p.content, p.group_id, p.visibility, p.time, u.name, u.surname, u_p.image_path AS image 
            FROM posts p 
            JOIN users u ON p.user_id = u.id 
            JOIN user_profiles u_p ON u.id = u_p.id 
            WHERE p.group_id = ?
            ORDER BY time DESC
            LIMIT 20
        ');
        $stmt->execute([$group_id]);

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

    public function getUserPosts(int $user_id)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT p.id, p.user_id, p.title, p.content, p.group_id, p.visibility, p.time, u.name, u.surname, u_p.image_path AS image 
            FROM posts p 
            JOIN users u ON p.user_id = u.id 
            JOIN user_profiles u_p ON u.id = u_p.id 
            WHERE p.user_id = ?
            ORDER BY time DESC
            LIMIT 20
        ');
        $stmt->execute([$user_id]);

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
    
    public function addReports(array $reported_posts, int $user_id)
    {
        foreach ($reported_posts as $post_id) {
            $stmt = $this->database->connect()->prepare('
                INSERT INTO reports (reporting_user_id, post_id)
                VALUES (?, ?)
            ');
        
            $stmt->execute([$user_id, $post_id]);
        }
    }

    public function addLikes(array $liked_posts, int $user_id)
    {
        foreach ($liked_posts as $post_id) {
            $stmt = $this->database->connect()->prepare('
                INSERT INTO likes (user_id, post_id)
                VALUES (?, ?)
            ');
        
            $stmt->execute([$user_id, $post_id]);
        }
    }

}