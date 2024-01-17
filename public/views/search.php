<?php
// search.php

// Połączenie z bazą danych - dostosuj dane dostępowe
$host = "localhost";
$dbname = "nazwa_bazy_danych";
$username = "nazwa_uzytkownika";
$password = "haslo";

try {
    $db = new PDO("pgsql:host=$host;dbname=$dbname;user=$username;password=$password");
} catch (PDOException $e) {
    die("Błąd połączenia z bazą danych: " . $e->getMessage());
}

// Funkcja do zabezpieczania danych przed atakami SQL Injection
function secureInput($data) {
    global $db;
    return htmlspecialchars(strip_tags($data), ENT_QUOTES, 'UTF-8');
}

// Sprawdzenie, czy formularz został wysłany
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["query"])) {
    // Oczyszczenie danych wejściowych
    $searchQuery = secureInput($_GET["query"]);

    // Zapytanie SQL - dostosuj do struktury Twojej bazy danych
    $sql = "SELECT * FROM posts WHERE title LIKE :query OR content LIKE :query";

    // Przygotowanie i wykonanie zapytania
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':query', "%$searchQuery%", PDO::PARAM_STR);
    $stmt->execute();

    // Pobranie wyników zapytania
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Wyświetlenie wyników
    if ($results) {
        foreach ($results as $post) {
            echo "<h2>{$post['title']}</h2>";
            echo "<p>{$post['content']}</p>";
            // Dodaj inne informacje o poście według potrzeb
        }
    } else {
        echo "Brak wyników dla zapytania: $searchQuery";
    }
}

// Zamykanie połączenia z bazą danych
$db = null;
?>
