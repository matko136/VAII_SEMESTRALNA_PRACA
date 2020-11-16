<?php
if (isset($_POST['Prihlasenie'])) {
    session_start();
    $_SESSION['user'] = $_POST['log'];
} elseif (isset($_POST['Registracia'])) {
    try {
        $db = new PDO('mysql:dbname=cinema;host=localhost', 'root', 'dtb456');
        $sql = 'INSERT INTO user() VALUES (?, ?, ?, ?, ?)';
        $db->prepare($sql)->execute($_POST['name'], $_POST['surename'], $_POST['log'], $_POST['passwd']);
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
}

