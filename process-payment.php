<?php
include './config.php';
$admin = new Admin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bookingId = $_POST['booking_id'];
    $transactionId = $_POST['transaction_id'];
    $amount = $_POST['amount'];

    // Fetch customer name
    $query = "SELECT c.c_name FROM service_booking sb
              JOIN customer c ON sb.c_id = c.c_id
              WHERE sb.sb_id = '$bookingId'";
    $result = $admin->ret($query);

    $customerName = ($result && $result->rowCount() > 0)
        ? $result->fetch(PDO::FETCH_ASSOC)['c_name']
        : 'unknown';

    // Default screenshot path is NULL
    $screenshotPath = null;

    // Check if a file was uploaded
    if (isset($_FILES['payment_screenshot']) && $_FILES['payment_screenshot']['error'] === UPLOAD_ERR_OK) {
        $paymentScreenshot = $_FILES['payment_screenshot'];

        // Create directory if not exists
        $uploadDir = 'admin/controllers/payment_screenshots/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Create sanitized file name
        $extension = pathinfo($paymentScreenshot['name'], PATHINFO_EXTENSION);
        $safeFileName = $transactionId . '_' . sanitizeFileName($customerName) . '.' . $extension;
        $uploadFile = $uploadDir . $safeFileName;

        // Move uploaded file
        if (move_uploaded_file($paymentScreenshot['tmp_name'], $uploadFile)) {
            $screenshotPath = $uploadFile;
        } else {
            echo "<script>
                alert('Error uploading screenshot. Please try again.');
                window.history.back();
            </script>";
            exit;
        }
    }

    // Insert into service_payments (screenshot path may be null)
    $screenshotColumn = $screenshotPath ? "'$screenshotPath'" : "NULL";
    $admin->cud("INSERT INTO service_payments (booking_id, amount, transaction_id, screenshot_path, status)
                 VALUES ('$bookingId', '$amount', '$transactionId', $screenshotColumn, 'Completed')", "insert");

    // Update pay_status to Paid
    $admin->cud("UPDATE service_booking SET pay_status = 'Paid', t_id = '$transactionId' , 
                 paid_at = NOW()  WHERE sb_id = '$bookingId'", "update");

    echo "<script>
        alert('Payment Successful');
        window.location.href = 'bookinghistory.php';
    </script>";
    exit;
}

// Helper function to sanitize file names
function sanitizeFileName($name)
{
    return preg_replace('/[^a-zA-Z0-9_]/', '', str_replace(' ', '_', $name));
}
?>