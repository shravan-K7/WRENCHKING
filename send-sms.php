<?php
require __DIR__ . '/vendor/autoload.php'; // Load Twilio SDK
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use Twilio\Rest\Client;

// Load Twilio credentials securely
$sid = $_ENV['AC01f79d6c6b959c8c61af79999aa1fabd'];
$token = $_ENV['6d9ab3fa36ba4209343853880525d878'];
$twilio_number = $_ENV['TWILIO_PHONE_NUMBER'];

$recipient_number = "+17067403899<?php
require __DIR__ . '/vendor/autoload.php'; ?>"; // Load Twilio SDK
// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// use Twilio\Rest\Client;
$conn = new mysqli("localhost", "root", "", "wrenchking"); // Update with your DB details

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$customer_id = $_SESSION['customer_id']; // Assuming customer ID is stored in session
$service_id = $_POST['service_id'];
$expected_date = $_POST['expected_date']; // If you're using expected car return date

// Fetch customer details
$customer_query = $conn->query("SELECT name, phone FROM customer WHERE id = '$customer_id'");
$customer = $customer_query->fetch_assoc();
$customer_name = $customer['name'];
$customer_phone = $customer['phone'];

// Insert booking into `service_booking` table
$sql = "INSERT INTO service_booking (customer_id, service_id, expected_date, status)
VALUES ('$customer_id', '$service_id', '$expected_date', 'Pending')";
if ($conn->query($sql) === TRUE) {

    // Send SMS Confirmation
    $sid = $_ENV['TWILIO_SID'];
    $token = $_ENV['TWILIO_AUTH_TOKEN'];
    $twilio_number = $_ENV['TWILIO_PHONE_NUMBER'];
    $client = new Client($sid, $token);

    $message = $client->messages->create(
        $customer_phone, // Customer's phone number from database
        [
            "from" => $twilio_number,
            "body" => "Hello $customer_name, your WrenchKing service booking (ID: $service_id) is confirmed! Expected completion:
$expected_date."
        ]
    );

    echo "Booking successful! SMS sent to " . $customer_phone;
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
"; // Replace with recipient's number

$client = new Client($sid, $token);
$message = $client->messages->create(
$recipient_number,
[
"from" => $twilio_number,
"body" => "Your WrenchKing booking is confirmed!"
]
);

echo "Message Sent: " . $message->sid;
?>