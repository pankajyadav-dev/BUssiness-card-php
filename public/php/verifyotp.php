
<?php
header('Content-Type: application/json');

// Debugging: Log the raw input
$input = file_get_contents('php://input');
error_log("Raw input: " . $input);

// Decode the JSON input
$data = json_decode($input, true);

// Debugging: Log the decoded data
error_log("Decoded data: " . print_r($data, true));

// Check if OTP is present in the input
if (!isset($data['otp'])) {
    echo json_encode(['message' => 'OTP is required.']);
    exit;
}

$otp = $data['otp'];
$email = $data['email'];
// Debugging: Log the OTP
error_log("OTP received: " . $otp);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "business_card_db";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['message' => 'Database connection failed']));
}

// Verify the OTP
$stmt = $conn->prepare("SELECT email FROM email_verification WHERE otp = ? AND verified = 0 and email = ?");
$stmt->bind_param("ss", $otp, $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Mark the email as verified
    $stmt = $conn->prepare("UPDATE email_verification SET verified = 1 WHERE otp = ? and email = ?");
    $stmt->bind_param("ss", $otp, $email);
    $stmt->execute();

    echo json_encode(['message' => 'Email verified successfully!']);
} else {
    echo json_encode(['message' => 'Invalid or expired OTP.']);
}

$stmt->close();
$conn->close();
?>