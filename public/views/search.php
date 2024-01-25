<!DOCTYPE html>
<html lang="pl-PL">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../../public/img/logo.png">
    <link rel="stylesheet" type="text/css" href="../../public/css/style80.css">
    <link rel="stylesheet" type="text/css" href="../../public/css/searchstyle.css">
    <title>Gamma</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../public/js/gallery.js"></script>
    <script src="../../public/js/like.js"></script>
    <script src="../../public/js/report.js"></script>
    <link rel="stylesheet" type="text/css" href="../../public/css/gallery-style.css">
    <script>
        function toggleCommentForm(postId) {
            var commentForm = document.getElementById('comment-form-container-' + postId);
            commentForm.style.display = commentForm.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</head>

<body>
    <header>
        <div>
            <a href="main">
                <img class="logo" src="../../public/img/logo.png" alt="Logo should be here">
            </a>
        </div>
        <div>
            <a href="user?user_id=<?= isset($_SESSION['user_ID']) ? $_SESSION['user_ID']: '' ?>">
                <img src="../../public/img/user.png" alt="user">
            </a>
            <a href="user?user_id=<?= isset($_SESSION['user_ID']) ? $_SESSION['user_ID']: '' ?>">
                <span id="logged_user"><?= isset($_SESSION['user_name']) ? $_SESSION['user_name'] . ' ' . $_SESSION['user_surname'] : '' ?></span>
            </a>
            <a href="logout"><img src="../../public/img/logout.png" alt="logout"></a>
        </div>
    </header>

    <nav>
        <div id="search-form-container">
            <form action="search" method="GET" id="search">
                <input type="text" name="query" placeholder="Szukaj w...">
                <button type="submit">Szukaj</button>
            </form>
        </div>
    </nav>

    <main>
        <h1>Użytkownicy</h1>
        <div class = "users">
            <?php foreach ($found_users as $user):?>
                <div class="user-info">
                    <div class="user-photo">
                        <a href="user?user_id=<?= $user->getId()?>">
                            <img src="../../public/img/<?=$user->getImagePath()?>">
                        </a>
                    </div>
                    <div class="info">
                        <a href="user?user_id=<?= $user->getId()?>">
                            <p class="m-0"> <?=$user->getName().' '.$user->getSurname() ?></p>
                        </a>
                        <p class="m-1"> <?= $user->getDescription() ?></p>
                    </div> 
                </div>
            <?php endforeach; ?>
        </div>
        <h1>Grupy</h1>
        <div class = "groups">   
            <?php foreach ($found_groups as $group):?>
                <div class="group-info">
                    <div class="group-photo">
                        <a href="group?group_id=<?= $group->getId()?>">
                            <img src="../../public/img/<?=$group->getImagePath()?>">
                        </a>
                    </div>
                    <div class="info">
                        <a href="group?group_id=<?= $group->getId()?>">
                            <p class="m-0"> <?=$group->getName() ?></p>
                        </a>
                        <p class="m-1"> <?= $group->getDescription() ?></p>
                    </div> 
                </div>
            <?php endforeach; ?>
        </div>
        <div>
            <h1>Posty</h1>
            <div>
            <?php foreach ($found_posts as $post):?>
                <div class="post-thread">
                    <div class="post">
                        <a class="post-border-link" id="main-border"></a>
                            <div class="post-heading">
                                <div class="post-voting">
                                    <button class="likePost" data-post-id="<?=$post->getID()?>">
                                        <span aria-hidden="true">&#9650;</span>
                                        <span class="sr-only">Vote up</span> 
                                    </button>
                                    <a href="#" class="comment-author"> <?= $post->getTitle() ?></a>
                                </div>
                                <div class="post-info">
                                    <div class="author-photo">
                                        <a href="user?user_id=<?= $post->getUserId()?>">
                                            <img src="../../public/img/<?=$post->getAuthorPhoto()?>">
                                        </a>
                                    </div>
                                    <div class="info">
                                        <p class="m-0"> 
                                            <a href="user?user_id=<?= $post->getUserId()?>">
                                                <?=$post->getAuthorName().' '.$post->getAuthorSurname()?>
                                            </a>
                                            points &bull;</p>
                                        <p class="m-1"> <?= $post->getTime() ?></p>
                                    </div> 
                                </div>
                            </div>
                            <div class="post-body">
                                <div id="gallery-container-<?= $post->getId(); ?>">
                                    <div class="image-wrapper active">
                                        <div>
                                            <button class="scroll-button scroll-button-left">&#9665;</button>
                                        </div>
                                        <img class="image" src="" alt="Image">
                                        <div>
                                            <button class="scroll-button scroll-button-right">&#9655;</button>
                                        </div>
                                    </div>
                                </div>
                                <p><?=$post->getContent()?></p>
                                <button type="button" onclick="toggleCommentForm(<?= $post->getId(); ?>)">Reply</button>
                                <button class="reportPost" data-post-id="<?=$post->getID()?>">Report</button>

                                <div class="post-body">

                                    <div id="comment-form-container-<?= $post->getId(); ?>" style="display: none;">
                                        <form action="addComment" method="POST">
                                            <input type="hidden" name="current_page_url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                                            <input type="hidden" name="user_id" value="<?= isset($_SESSION['user_ID']) ? $_SESSION['user_ID'] : ''; ?>">
                                            <input type="hidden" name="post_id" value="<?= $post->getId(); ?>">
                                            <textarea name="comment_content" placeholder="Your Comment" required></textarea>
                                            <button type="submit">Add Comment</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <script>
                                initializeGallery(<?= $post->getId(); ?>, <?= json_encode($post->getGalleryPhotos()); ?>);
                            </script>
                            <?php foreach ($post->getComments() as $comment):?>
                            <div class="replies">
                                <div class="comment">
                                    <a class="comment-border-link"></a>
                                    <div class="comment-heading">
                                        <div class="comment-voting">
                                            <button class="likeComment" data-comment-id="<?=$comment->getID()?>">
                                                <span aria-hidden="true">&#9650;</span>
                                                <span class="sr-only">Vote up</span>
                                            </button>
                                        </div>
                                        <div class="comment-info">
                                            <div class="author-photo">
                                                <a href="user?user_id=<?= $comment->getUserId()?>">
                                                    <img src="../../public/img/<?= $comment->getAuthorPhoto()?>">
                                                </a>
                                            </div>
                                            <div class="info">
                                                <a href="user?user_id=<?= $comment->getUserId()?>">
                                                    <p class="m-0"> <?= $comment->getAuthorName().' '.$comment->getAuthorSurname() ?>
                                                </a>
                                                points &bull;</p>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="comment-body">
                                        <p><?= $comment->getContent()?></p>
                                        <button class="reportComment" data-comment-id="<?=$comment->getID()?>">Report</button>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        </div>
        
    </main>
</body>
</html>

<?php
// // search.php

// // Połączenie z bazą danych - dostosuj dane dostępowe
// $host = "localhost";
// $dbname = "nazwa_bazy_danych";
// $username = "nazwa_uzytkownika";
// $password = "haslo";

// try {
//     $db = new PDO("pgsql:host=$host;dbname=$dbname;user=$username;password=$password");
// } catch (PDOException $e) {
//     die("Błąd połączenia z bazą danych: " . $e->getMessage());
// }

// // Funkcja do zabezpieczania danych przed atakami SQL Injection
// function secureInput($data) {
//     global $db;
//     return htmlspecialchars(strip_tags($data), ENT_QUOTES, 'UTF-8');
// }

// // Sprawdzenie, czy formularz został wysłany
// if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["query"])) {
//     // Oczyszczenie danych wejściowych
//     $searchQuery = secureInput($_GET["query"]);

//     // Zapytanie SQL - dostosuj do struktury Twojej bazy danych
//     $sql = "SELECT * FROM posts WHERE title LIKE :query OR content LIKE :query";

//     // Przygotowanie i wykonanie zapytania
//     $stmt = $db->prepare($sql);
//     $stmt->bindValue(':query', "%$searchQuery%", PDO::PARAM_STR);
//     $stmt->execute();

//     // Pobranie wyników zapytania
//     $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

//     // Wyświetlenie wyników
//     if ($results) {
//         foreach ($results as $post) {
//             echo "<h2>{$post['title']}</h2>";
//             echo "<p>{$post['content']}</p>";
//             // Dodaj inne informacje o poście według potrzeb
//         }
//     } else {
//         echo "Brak wyników dla zapytania: $searchQuery";
//     }
// }

// // Zamykanie połączenia z bazą danych
// $db = null;
?>
