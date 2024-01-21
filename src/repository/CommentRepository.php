<?php

require_once __DIR__.'/../../Database.php';
require_once __DIR__.'/../models/Comment.php';

class CommentRepository extends Repository
{
    public function getRelatedComments(int $postId)
    {
        // Pobierz komentarze dla powiązanych postów
        $stmt = $this->database->connect()->prepare("
            SELECT c.id, c.user_id, c.content, u.name, u.surname, u_p.image_path FROM comments c 
            JOIN users u ON u.id = c.user_id 
            JOIN user_profiles u_p ON u.id = u_p.id
            WHERE c.post_id = ?
        ");
        $stmt->execute([$postId]);

        $commentsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $relatedComments = [];

        foreach ($commentsData as $commentData) {
            $relatedComments[] = new Comment(
                $commentData['id'],
                $commentData['user_id'],
                $commentData['name'],
                $commentData['surname'],
                $commentData['image_path'],
                $commentData['content']
            );
        }

        return $relatedComments;
    }

    /*
    public function addComment(Comment $comment, int $postId)
    {
        $stmt = $this->database->connect()->prepare("
            INSERT INTO comments (user_id, post_id, content) 
            VALUES (?, ?, ?)
        ");
        $stmt->execute([
            $comment->getUserId(),
            $postId,
            $comment->getContent()
        ]);
    }
    */

    public function addComment(int $postId, int $userID, String $commentContent)
    {
        $stmt = $this->database->connect()->prepare("
            INSERT INTO comments (user_id, post_id, content) 
            VALUES (?, ?, ?)
        ");
        $stmt->execute([
            $postId,
            $userID,
            $commentContent
        ]);
    }
}
?>
