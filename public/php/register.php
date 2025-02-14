<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $Organisationname=trim($_POST['Organisation_name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username,Organisation_name, email, password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $Organisationname, $email, $password]);
        header("Location: ../login.html");
        exit();
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>