<?php
include './config.php';
date_default_timezone_set('Asia/Kolkata');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $token = mysqli_real_escape_string($conn, $_POST['token']);
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        die("❌ Passwords do not match.");
    }

    // Match both email and token
    $query = "SELECT * FROM password_resets WHERE email='$email' AND token='$token' AND expires_at >= NOW()";
    $result = mysqli_query($conn, $query);

    if (!$result || mysqli_num_rows($result) === 0) {
        die("❌ Invalid or expired reset link.");
    }

    // No hashing for password (based on your previous request)
    $update = "UPDATE customer SET c_password='$newPassword' WHERE c_email='$email'";

    if (mysqli_query($conn, $update)) {
        mysqli_query($conn, "DELETE FROM password_resets WHERE email='$email'");
        echo "✅ Password updated successfully. <a href='signin.php'>Login now</a>";
    } else {
        echo "❌ Failed to update password: " . mysqli_error($conn);
    }
}