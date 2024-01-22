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
