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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../public/js/gallery.js"></script>
    <link rel="stylesheet" type="text/css" href="../../public/css/gallery-style.css">
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
        <form action="search" method="GET" id="search">
            <input type="text" name="query" placeholder="Szukaj w...">
            <button type="submit">Szukaj</button>
        </form>
    </div>
</nav>
    <main>
        <div>
            <?php foreach ($posts as $post):?>
                <div class="post-thread">
                    <div class="post">
                        <a class="post-border-link" id="main-border"></a>
                            <div class="post-heading">
                                <div class="post-voting">
                                    <button type="button">
                                        <span aria-hidden="true">&#9650;</span>
                                        <span class="sr-only">Vote up</span> 
                                    </button>
                                    <a href="#" class="comment-author"> <?= $post->getTitle() ?></a>
                                </div>
                                <div class="post-info">
                                    <div class="author-photo">
                                        <img src="../../public/img/<?=$post->getAuthorPhoto()?>">
                                    </div>
                                    <div class="info">
                                        <p class="m-0"> <?=$post->getAuthorName().' '.$post->getAuthorSurname() ?> points &bull;</p>
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
                                <button type="button">Flag</button>

                                <div class="post-body">
                                    <!-- ... inne elementy ... -->

                                    <div id="comment-form-container-<?= $post->getId(); ?>" style="display: none;">
                                        <form action="main/addComment" method="POST">
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
                                            <button type="button">
                                                <span aria-hidden="true">&#9650;</span>
                                                <span class="sr-only">Vote up</span>
                                            </button>
                                        </div>
                                        <div class="comment-info">
                                            <div class="author-photo">
                                                <img src="../../public/img/<?=$comment->getAuthorPhoto()?>">
                                            </div>
                                            <div class="info">
                                                <p class="m-0"> <?=$comment->getAuthorName().' '.$comment->getAuthorSurname() ?> points &bull;</p>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="comment-body">
                                        <p><?= $comment->getContent()?></p>
                                        <button type="button">Flag</button>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" id = "load-more">Load more replies</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <script>
        function toggleCommentForm(postId) {
            var commentForm = document.getElementById('comment-form-container-' + postId);
            commentForm.style.display = commentForm.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</body>
</html>