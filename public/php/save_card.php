<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

try {
    $stmt = $pdo->prepare("INSERT INTO business_cards 
        (user_id, name, title, company, email, phone, address, website, color)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
        name = VALUES(name),
        title = VALUES(title),
        company = VALUES(company),
        email = VALUES(email),
        phone = VALUES(phone),
        address = VALUES(address),
        website = VALUES(website),
        color = VALUES(color)");

    $stmt->execute([
        $_SESSION['user_id'],
        $data['name'],
        $data['title'],
        $data['company'],
        $data['email'],
        $data['phone'],
        $data['address'],
        $data['website'],
        $data['color']
    ]);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>