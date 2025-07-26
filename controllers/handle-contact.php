<?php
include '../config.php';
$admin = new Admin();

if (isset($_POST['submit'])) {
    // Simple variable setup
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';
    $branch = $_POST['branch'] ?? '';
    $created_at = date('Y-m-d H:i:s');

    // Check if all fields are filled
    if ($name && $email && $subject && $message && $branch) {
        // Escape single quotes to prevent SQL errors
        $message = str_replace("'", "\'", $message);
        $subject = str_replace("'", "\'", $subject);

        // Store in database
        $sql = "INSERT INTO contact (name, email, subject, message, branch, created_at)
                VALUES ('$name', '$email', '$subject', '$message', '$branch', '$created_at')";

        $insert = $admin->cud($sql, "inserted");

        if ($insert) {
            echo "<script>alert('Message sent successfully!'); window.location.href='../contact.php';</script>";
        } else {
            echo "<script>alert('Failed to send message'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Please fill all fields'); window.history.back();</script>";
    }
}
?>