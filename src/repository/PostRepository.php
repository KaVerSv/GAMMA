<?php

require_once __DIR__.'/../../Database.php';
require_once __DIR__.'/../models/Post.php';

class PostRepository extends Repository
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

    public function getLatestPosts(): array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM posts
            ORDER BY time DESC
            LIMIT 20
        ');
        $stmt->execute();

        $postsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $latestPosts = [];
        $userRepository = new UserRepository();

        foreach ($postsData as $postData) {
            $username = $userRepository->getUserById($postData['user_id']);

            $latestPosts[] = new Post(
                $postData['id'],
                $postData['user_id'],
                $postData['title'],
                $postData['content'],
                $postData['group_id'],
                $postData['visibility'],
                $postData['time'],
                $username
            );
        }

        return $latestPosts;
    }
}