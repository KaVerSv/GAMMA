<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../repository/PostRepository.php';
require_once __DIR__ . '/../repository/CommentRepository.php';

class PostController extends AppController
{
    private $postRepository;

    public function __construct()
    {
        parent::__construct();
        $this->postRepository = new PostRepository();
    }

    public function main()
    {
        $latestPosts = $this->postRepository->getLatestPosts();
        return $this->render('main', ['posts' => $latestPosts]);
    }

    public function addPost()
    {
        if (!$this->isPost()) {
            return $this->render('addPost');
        }

        // dane z formularza
        $title = $_POST['title'];
        $content = $_POST['content'];
        $groupId = $_POST['group_id']; // Ustaw to zgodnie z formularzem
        $visibility = $_POST['visibility']; // Ustaw to zgodnie z formularzem

        // Walidacja danych


        $newPost = new Post(null, $_SESSION['user_ID'], $title, $content, $groupId, $visibility, $time);
        $this->postRepository->addPost($newPost);

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/post/index");
    }

    public function addComment()
    {
        if (!$this->isPost()) {
            // Zabezpieczenie przed próbą dostępu bezpośredniego do akcji
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }

        $postId = $_POST['post_id'];
        $authorName = $_SESSION['user_name'];
        $commentContent = $_POST['comment_content'];

        // Walidacja danych (jeśli potrzebna)

        $commentRepository = new CommentRepository();
        $commentRepository->addComment(new Comment(null, $_SESSION['user_ID'], $authorName, $_SESSION['user_surname'], $_SESSION['user_photo'], $commentContent), $postId);

        // Przekierowanie z powrotem na stronę posta po dodaniu komentarza
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/post/index");
    }
}