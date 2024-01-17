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
        // Tutaj możesz umieścić kod do pobrania i wyświetlenia listy postów
        $latestPosts = $this->postRepository->getLatestPosts();

        // Pobierz komentarze powiązane z postami
        $relatedComments = $this->commentRepository->getRelatedComments($latestPosts);

        return $this->render('main', ['posts' => $latestPosts, 'comments' => $relatedComments]);
    }

    public function addPost()
    {
        if (!$this->isPost()) {
            return $this->render('addPost');
        }

        // Pobierz dane z formularza
        $title = $_POST['title'];
        $content = $_POST['content'];
        $groupId = $_POST['group_id']; // Ustaw to zgodnie z formularzem
        $visibility = $_POST['visibility']; // Ustaw to zgodnie z formularzem
        $time = date('Y-m-d H:i:s'); // Ustaw datę i czas na bieżące

        // Walidacja danych (możesz dodać odpowiednie warunki)

        // Utwórz obiekt posta
        $newPost = new Post(null, $_SESSION['user_ID'], $title, $content, $groupId, $visibility, $time);

        // Dodaj post do bazy danych
        $this->postRepository->addPost($newPost);

        // Przekieruj na stronę z listą postów
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/post/index");
    }

    // Inne metody związane z zarządzaniem postami (edycja, usuwanie itp.) można dodać w tym miejscu
}
