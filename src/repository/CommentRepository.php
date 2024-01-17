<?php

require_once __DIR__.'/../../Database.php';
require_once __DIR__.'/../models/Comment.php';

class CommentRepository extends Repository
{
    public function getRelatedComments(array $posts): array
    {
        // Przygotuj tablicę id postów
        $postIds = array_map(function ($post) {
            return $post->getId();
        }, $posts);

        // Przygotuj warunki dla zapytania SQL
        $conditions = implode(',', array_fill(0, count($postIds), '?'));

        // Pobierz komentarze dla powiązanych postów
        $stmt = $this->database->connect()->prepare("
            SELECT * FROM comments
            WHERE post_id IN ($conditions)
        ");
        $stmt->execute($postIds);

        $commentsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $relatedComments = [];

        foreach ($commentsData as $commentData) {
            $relatedComments[] = new Comment(
                $commentData['id'],
                $commentData['user_id'],
                $commentData['post_id'],
                $commentData['content']
            );
        }

        return $relatedComments;
    }
}
?>
