<?php
require_once 'config.php';
header('Content-Type: application/json'); // Ensure JSON response

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get JSON data from the request body
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['username'], $data['Organisation_name'], $data['email'], $data['password'])) {
        echo json_encode(["success" => false, "message" => "All fields are required."]);
        exit();
    }

    $username = trim($data['username']);
    $Organisationname = trim($data['Organisation_name']);
    $email = trim($data['email']);
    $password = password_hash($data['password'], PASSWORD_DEFAULT);

    try {
        // Ensure email exists and is verified before inserting
        $stmt = $pdo->prepare("INSERT INTO users (username, organisation_name, email, password)
            SELECT ?, ?, ev.email, ? FROM email_verification ev WHERE ev.verified = 1 AND ev.email = ?");
        
        $stmt->execute([$username, $Organisationname, $password, $email]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(["success" => true, "message" => "Registration successful!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Email not verified or already registered."]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
    }

}
?>
