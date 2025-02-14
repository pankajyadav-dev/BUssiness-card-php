<?php
header('Content-Type: application/json');

// Include PHPMailer
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Debugging: Log the raw input
$input = file_get_contents('php://input');
error_log("Raw input: " . $input);

// Decode the JSON input
$data = json_decode($input, true);

// Debugging: Log the decoded data
error_log("Decoded data: " . print_r($data, true));

// Check if email is present in the input
if (!isset($data['email'])) {
    echo json_encode(['message' => 'Email is required.']);
    exit;
}

$email = $data['email'];

// Generate a 6-digit OTP
$otp = rand(100000, 999999);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "business_card_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['message' => 'Database connection failed']));
}

// Insert user data into the database
$stmt = $conn->prepare("INSERT INTO email_verification (email, otp, verified) VALUES (?, ?, 0)");
$stmt->bind_param("ss", $email, $otp);

if ($stmt->execute()) {
    // Send OTP via email using PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP(); // Use SMTP
        $mail->Host = 'smtp.gmail.com'; // SMTP server (e.g., Gmail)
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'siri963690@gmail.com'; // Your Gmail address
        $mail->Password = 'npso otex mvuk cbhe'; // Your Gmail password or app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
        $mail->Port = 587; // TCP port to connect to

        // Recipients
        $mail->setFrom('siri963690@gmail.com', 'siri develop'); // Sender
        $mail->addAddress($email); // Recipient

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Your OTP for Verification';
        $mail->Body = "Your OTP for verification is: <b>$otp</b> don't share with anyone";

        $mail->send();
        echo json_encode([
            'message' => 'OTP sent to your email. Please check your inbox.',
            'otp' => $otp // Display OTP for testing purposes
        ]);
    } catch (Exception $e) {
        echo json_encode(['message' => 'Failed to send OTP. Error: ' . $mail->ErrorInfo]);
    }
} else {
    echo json_encode(['message' => 'Failed to sign up.']);
}

$stmt->close();
$conn->close();
?>