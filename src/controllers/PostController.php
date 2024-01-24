<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../repository/PostRepository.php';

class PostController extends AppController
{
    private $postRepository;

    public function __construct()
    {
        parent::__construct();
        $this->postRepository = new PostRepository();
        register_shutdown_function(array($this, 'handleShutdown'));
    }

    public function handleShutdown()
    {
        // Ta funkcja zostanie wywołana na zakończenie sesji
        $this->like_posts();
        $this->report_posts();
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

    public function like_posts()
    {
        $liked_posts = $_SESSION['liked_posts'];
        $user_id = $_SESSION['user_ID'];

        $this->postRepository->addLikes($liked_posts, $user_id);
    }

    public function report_posts()
    {
        $reported_posts = $_SESSION['reported_posts'];
        $user_id = $_SESSION['user_ID'];
        $this->postRepository->addReports($reported_posts, $user_id);
    }

    public function likePost(){
        if (isset($_POST['postID'])) {
            $_SESSION["liked_posts"][] = $_POST['postID'];
            echo 'Polubiono post o ID ' . $postID;
        } else {
            echo 'Błąd: Brak przekazanego ID posta.';
        }
        error_log($_POST['postID']);
    }

    public function reportPost(){
        if (isset($_POST['postID'])) {
            $_SESSION["reported_posts"][] = $_POST['postID'];
            echo 'Report post o ID ' . $postID;
        } else {
            echo 'Błąd: Brak przekazanego ID posta.';
        }
        error_log($_POST['postID']);
    }
}