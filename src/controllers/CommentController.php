<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/comment.php';
require_once __DIR__ . '/../repository/CommentRepository.php';

class CommentController extends AppController
{
    private $commentRepository;

    public function __construct()
    {
        parent::__construct();
        $this->commentRepository = new CommentRepository();
    }

    public function addComment()
    {
        if (!$this->isPost()) {
            // Zabezpieczenie przed próbą dostępu bezpośredniego do akcji
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }

        $postId = $_POST['post_id'];
        $userID = $_SESSION['user_ID'];
        $commentContent = $_POST['comment_content'];

        $this->commentRepository->addComment($postId, $userID, $commentContent);

        $this->main();
    }

    public function like_comments()
    {
        $liked_comments = $_SESSION['liked_comments'];
        $user_id = $_SESSION['user_ID'];

        $this->commentRepository->addLikes($liked_comments, $user_id);
    }

    public function report_comments()
    {
        $reported_comments = $_SESSION['reported_comments'];
        $user_id = $_SESSION['user_ID'];

        $this->commentRepository->addReports($liked_comments, $user_id);
    }

}