<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $Organisationname=trim($_POST['Organisation_name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, organisation_name, email, password) SELECT ?, ?, ev.email, ? FROM email_verification ev WHERE ev.verified = 1 AND ev.email = ?;");
        $stmt->execute([$username, $Organisationname, $password,$email]);
        header("Location: ../login.html");
        exit();
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>