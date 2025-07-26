<?php
// session_start();
include '../config.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';
require '../PHPMailer/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;

$admin = new Admin();

// Handle login
if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $remember = isset($_POST["remember"]); // Checkbox for "Remember Me"

    $stmt = $admin->ret("SELECT * FROM `customer` WHERE `c_email` = :email AND `c_password` = :password", [
        'email' => $email,
        'password' => $password
    ]);

    $profile = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($profile) {
        $_SESSION['c_id'] = $profile["c_id"];

        if ($remember) {
            // Set cookie for 30 days
            setcookie('c_id', $profile["c_id"], time() + (86400 * 10), "/", "", false, true); // HttpOnly
        }

        echo "<script>alert('Login successful');window.location='../index.php';</script>";
    } else {
        echo "<script>alert('Invalid credential');window.location='../signin.php';</script>";
    }
}

// Handle registration with OTP
else if (isset($_POST["register"])) {
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["cpassword"];
    $sp_id = $_POST["sp_id"];

    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match!');window.location='../signup.php';</script>";
        exit();
    }

    $checkEmail = $admin->ret("SELECT * FROM `customer` WHERE `c_email`='$email'");
    if ($checkEmail->rowCount() > 0) {
        echo "<script>alert('Email already exists!');window.location='../signup.php';</script>";
    } else {
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $exists = $admin->ret("SELECT * FROM pending_customers WHERE email='$email'");
        if ($exists->rowCount() > 0) {
            $admin->cud("UPDATE pending_customers SET name='$name', phone='$phone', password='$password', otp='$otp', sp_id='$sp_id' WHERE email='$email'", "update");
        } else {
            $admin->cud("INSERT INTO pending_customers (email, name, phone, password, otp, sp_id) VALUES ('$email', '$name', '$phone', '$password', '$otp', '$sp_id')", "insert");
        }

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'knoxshraone@gmail.com';
            $mail->Password = 'sqgi spxk yiot nlrc'; // App password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('knoxshraone@gmail.com', 'WrenchKing');
            $mail->addAddress($email);
            $mail->Subject = 'Your WrenchKing OTP';
            $mail->Body = "Hello $name,\n\nYour OTP is: $otp\n\nPlease enter this to complete registration.";

            $mail->send();

            $_SESSION['pending_email'] = $email;
            echo "<script>alert('OTP sent to your email. Please verify.'); window.location='../verify-otp.php';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Mail Error: {$mail->ErrorInfo}'); window.location='../signup.php';</script>";
        }
    }
}

// Handle logout
else if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    setcookie("c_id", "", time() - 3600, "/"); // Remove cookie
    unset($_SESSION['c_id']);
    echo "<script>alert('Logged out!');window.location='../index.php';</script>";
}

// Default fallback
else {
    echo "<script>window.location='../index.php';</script>";
}
?>