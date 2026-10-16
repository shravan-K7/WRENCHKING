<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/PHPMailer.php';
require './PHPMailer/SMTP.php';
require './PHPMailer/Exception.php';
include './config.php'; // DB connection
date_default_timezone_set('Asia/Kolkata');

$message = ""; // Message to show alert

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Check if email exists
    $check = mysqli_query($conn, "SELECT * FROM customer WHERE c_email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $token = bin2hex(random_bytes(50));
        $expires = date("Y-m-d H:i:s", strtotime("+5 minutes")); // Expire in 5 minutes

        // Clean previous tokens and insert new
        mysqli_query($conn, "DELETE FROM password_resets WHERE email='$email'");
        mysqli_query($conn, "INSERT INTO password_resets(email, token, expires_at) VALUES('$email', '$token', '$expires')");

        $reset_link = "http://localhost/wrenchking/reset-password.php?token=$token&email=$email";

        // Send Email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USERNAME;
            $mail->Password = SMTP_PASSWORD;
            $mail->SMTPSecure = SMTP_SECURE;
            $mail->Port = SMTP_PORT;

            $mail->setFrom(SMTP_FROM_EMAIL, 'WrenchKing Support');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'WrenchKing Password Reset';
            $mail->Body = "
                <h2>Password Reset Request</h2>
                <p>Click the link below to reset your password:</p>
                <a href='$reset_link'>$reset_link</a>
                <p><small>This link will expire in 5 minutes.</small></p>
            ";

            $mail->send();
            $message = "<div class='alert alert-success'>✅ Reset link sent to your email.</div>";
        } catch (Exception $e) {
            $message = "<div class='alert alert-danger'>❌ Email sending failed: {$mail->ErrorInfo}</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'>❌ Entered email is not registered.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
</head>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">

    <div class="container p-4 bg-white rounded-4 shadow-sm" style="max-width: 400px;">
        <h2 class="text-center mb-4">Reset Password</h2>

        <?php if (!empty($message))
            echo $message; ?>

        <form action="" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email address</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter email address"
                    required>
            </div>
            <button class="btn btn-danger w-100" type="submit">🔑 Reset password</button>
        </form>

        <div class="text-center mt-4 small">
            Not registered yet? <a href="signup.php" class="text-decoration-none text-primary">Register now</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>