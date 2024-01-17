<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../repository/PostRepository.php';
require_once __DIR__ . '/../repository/CommentRepository.php';

class PostController extends AppController
{
    private $postRepository;
    private $commentRepository;

    public function __construct()
    {
        parent::__construct();
        $this->postRepository = new PostRepository();
        $this->commentRepository = new CommentRepository();
    }

    public function main()
    {
        $latestPosts = $this->postRepository->getLatestPosts();
        $relatedComments = $this->commentRepository->getRelatedComments($latestPosts);
        return $this->render('main', ['posts' => $latestPosts, 'comments' => $relatedComments]);
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
        $time = date('Y-m-d H:i:s'); // Ustaw datę i czas na bieżące

        // Walidacja danych


        $newPost = new Post(null, $_SESSION['user_ID'], $title, $content, $groupId, $visibility, $time);
        $this->postRepository->addPost($newPost);

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/post/index");
    }
}