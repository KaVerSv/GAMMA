<!DOCTYPE html>
<html lang="pl-PL">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ta strona to będzie coś wspaniałego">
    <meta name="keywords" content="strona, wspaniała, niczym">
    <meta name="author" content="Piotr Żywczak">
    <link rel="icon" type="image/x-icon" href="../../public/img/logo.png">
    <link rel="stylesheet" type="text/css" href="../../public/css/style80.css">
    <?php if ($_SESSION['user_type'] != 'admin') : ?>
        <link rel="stylesheet" type="text/css" href="../../public/css/style100.css">
    <?php endif; ?>
    <title>Gamma</title>
</head>

<body>
    <header>
        <div>
            <img src="../../public/img/logo.png" alt="Logo should be here">
        </div>
        <div>
            <img src="../../public/img/user.png" alt="user">
            <span id="logged_user"><?= isset($_SESSION['user_name']) ? $_SESSION['user_name'] . ' ' . $_SESSION['user_surname'] : '' ?></span>
            <a href="logout"><img src="../../public/img/logout.png" alt="logout"></a>
        </div>
    </header>

<nav>
    <div id="search-form-container">
        <form action="search.php" method="GET" id="search-form">
            <input type="text" name="query" placeholder="Szukaj postów...">
            <button type="submit">Szukaj</button>
        </form>
    </div>
</nav>
    <main>
        <div>
            <?php
            if (isset($posts)) {
                foreach ($posts as $post) {
                    if ($post->getVisibility() == 'public') {
                        echo '<div class="comment-thread">';
                        echo '<div class="comment"' . $post->getId() . '>';
                        echo '<a class="comment-border-link" id="main-border">';
                        echo '</a>';
                        echo '<div class="comment-heading">';
                        echo '<div class="comment-voting">';
                        echo '<button type="button">';
                        echo '<span aria-hidden="true">&#9650;</span>';
                        echo '<span class="sr-only">Vote up</span>';
                        echo '</button>';
                        echo '</div>';
                        echo '<div class="comment-info">';
                        echo '<a href="#" class="comment-author">' . $post->getTitle() . '</a>';
                        echo '<p class="m-0">' . $post->points . ' points &bull; ' . $post->timestamp . '</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="comment-body">';
                        echo '<p>' . $post->getContent() . '</p>';
                        echo '<button type="button">Reply</button>';
                        echo '<button type="button">Flag</button>';
                        echo '</div>';
                        echo '<div class="replies">';
                        echo '<div class="comment" id="comment-' . $post->getId() . '-reply-1">';
                        echo '<a class="comment-border-link">';
                        echo '</a>';
                        echo '<div class="comment-heading">';
                        echo '<div class="comment-voting">';
                        echo '<button type="button">';
                        echo '<span aria-hidden="true">&#9650;</span>';
                        echo '<span class="sr-only">Vote up</span>';
                        echo '</button>';
                        echo '</div>';
                        echo '<div class="comment-info">';
                        echo '<a href="#" class="comment-author">ReplyAuthor1</a>';
                        echo '<p class="m-0">10 points &bull; 1 day ago</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="comment-body">';
                        echo '<p>This is a reply to the post.</p>';
                        echo '<button type="button">Flag</button>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="comment" id="comment-' . $post->getId() . '-reply-2">';
                        echo '<a class="comment-border-link">';
                        echo '</a>';
                        echo '<div class="comment-heading">';
                        echo '<div class="comment-voting">';
                        echo '<button type="button">';
                        echo '<span aria-hidden="true">&#9650;</span>';
                        echo '<span class="sr-only">Vote up</span>';
                        echo '</button>';
                        echo '</div>';
                        echo '<div class="comment-info">';
                        echo '<a href="#" class="comment-author">ReplyAuthor2</a>';
                        echo '<p class="m-0">8 points &bull; 2 days ago</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="comment-body">';
                        echo '<p>Another reply to the post.</p>';
                        echo '<button type="button">Flag</button>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '<button type="button" id = "load-more">Load more replies</button>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
            }
            ?>
        </div>



    </main>
</body>
</html>