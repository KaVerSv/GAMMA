<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../repository/PostRepository.php';

class PostController extends AppController
{
    private $postRepository;
    const MAX_FILE_SIZE = 1024 * 1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../../public/img/';

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
        if (!isset($_SESSION['user_ID'])) {
            header('Location: /login');
            exit();
        }
        $latestPosts = $this->postRepository->getLatestPosts();
        return $this->render('main', ['posts' => $latestPosts]);
    }

    public function addPost()
    {
        if (!isset($_SESSION['user_ID'])) {
            header('Location: /login');
            exit();
        }
    
        if (!$this->isPost()) {
            return $this->render('addPost');
        }
    
        // Dane z formularza
        $currentPageUrl = $_POST['current_page_url'] ?? 'index';
        $userID = $_SESSION['user_ID'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $groupId = $_POST['group_id'];
        $visibility = 'public';
    
        // Obsługa przesyłania plików multiple
        $photos = $this->handleMultipleFileUpload();
        
        $newPost = new Post(null, $userID, $title, $content, $groupId, $visibility, null, null, null, null);
        $this->postRepository->addPost($newPost, $photos);
    
        header('Location: ' . $currentPageUrl);
        exit();
    }
    
    public function handleMultipleFileUpload(){
        $uploadedPhotos = [];
    
        // Check if the 'photos' key is set in $_FILES and if it's an array
        if (isset($_FILES['photos']) && is_array($_FILES['photos']['name'])) {
            $fileCount = count($_FILES['photos']['name']);
    
            for ($i = 0; $i < $fileCount; $i++) {
                $fileType = $_FILES['photos']['type'][$i];
                $fileTmpName = $_FILES['photos']['tmp_name'][$i];
    
                // Sprawdź czy typ pliku jest obsługiwany
                if (!in_array($fileType, self::SUPPORTED_TYPES)) {
                    continue; // Pomijaj pliki o nieobsługiwanym formacie
                }
    
                // Ustaw ścieżkę do zapisu pliku
                $uploadPath = __DIR__ . self::UPLOAD_DIRECTORY;
                $photo = $_FILES['photos']['name'][$i];
    
                // Przesuń plik do docelowego katalogu
                move_uploaded_file($fileTmpName, $uploadPath . $photo);
    
                // Dodaj ścieżkę pliku do tablicy
                $uploadedPhotos[] = $photo;
            }
        }
    
        return $uploadedPhotos;
    }

    public function like_posts()
    {
        if (!isset($_SESSION['user_ID'])) {
            header('Location: /login');
            exit();
        }
        $liked_posts = $_SESSION['liked_posts'];
        $user_id = $_SESSION['user_ID'];

        $this->postRepository->addLikes($liked_posts, $user_id);
    }

    public function report_posts()
    {
        if (!isset($_SESSION['user_ID'])) {
            header('Location: /login');
            exit();
        }
        $reported_posts = $_SESSION['reported_posts'];
        $user_id = $_SESSION['user_ID'];
        $this->postRepository->addReports($reported_posts, $user_id);
    }

    public function likePost(){
        if (!isset($_SESSION['user_ID'])) {
            header('Location: /login');
            exit();
        }
        if (isset($_POST['postID'])) {
            $_SESSION["liked_posts"][] = $_POST['postID'];
            echo 'Polubiono post o ID ' . $postID;
        } else {
            echo 'Błąd: Brak przekazanego ID posta.';
        }
        error_log($_POST['postID']);
    }

    public function reportPost(){
        if (!isset($_SESSION['user_ID'])) {
            header('Location: /login');
            exit();
        }
        if (isset($_POST['postID'])) {
            $_SESSION["reported_posts"][] = $_POST['postID'];
            echo 'Report post o ID ' . $postID;
        } else {
            echo 'Błąd: Brak przekazanego ID posta.';
        }
        error_log($_POST['postID']);
    }
}