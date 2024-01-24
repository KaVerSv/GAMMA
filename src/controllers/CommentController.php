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
        register_shutdown_function(array($this, 'handleShutdown'));
    }

    public function handleShutdown()
    {
        $this->like_comments();
        $this->report_comments();
    }

    public function addComment()
    {
        // if (!$this->isPost()) {
        //     // Zabezpieczenie przed próbą dostępu bezpośredniego do akcji
        //     header('Location: ' . $_SERVER['HTTP_REFERER']);
        //     exit();
        // }
        $currentPageUrl = $_POST['current_page_url'] ?? 'index';
        $postId = $_POST['post_id'];
        $userID = $_SESSION['user_ID'];
        $commentContent = $_POST['comment_content'];

        $this->commentRepository->addComment($postId, $userID, $commentContent);

        header('Location: ' . $currentPageUrl);
        exit();
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

        $this->commentRepository->addReports($reported_comments, $user_id);
    }

    public function likeComment(){
        if (isset($_POST['commentID'])) {
            $_SESSION["liked_comments"][] = $_POST['commentID'];
            echo 'Polubiono comment';
        } else {
            echo 'Błąd: Brak przekazanego ID commenta.';
        }
    }

    public function reportComment(){
        if (isset($_POST['commentID'])) {
            $_SESSION["reported_comments"][] = $_POST['commentID'];
            echo 'Report comment';
        } else {
            echo 'Błąd: Brak przekazanego ID commenta.';
        }
    }
}