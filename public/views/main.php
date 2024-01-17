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
        <div class="posts-container">
            <?php
            if (isset($posts)) {
                foreach ($posts as $post) {
                    if ($post->getVisibility() == 'public') {
                        echo '<div class="post-card">';
                        echo '<h2>' . $post->getTitle() . '</h2>';
                        echo '<p>' . $post->getContent() . '</p>';
                        echo '</div>';
                    }
                }
            }
            ?>
        </div>
    </main>
</body>
</html>