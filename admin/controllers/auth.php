<?php
include '../../config.php';
$admin = new Admin();
if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Secure query using prepared statements
    $stmt = $admin->ret("SELECT * FROM `s_provider` WHERE `sp_email` = :email AND `sp_password` = :password", [
        'email' => $email,
        'password' => $password
    ]);

    $profile = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($profile) {
        $_SESSION['sp_id'] = $profile["sp_id"];
        echo "<script>alert('Login successful');window.location='../index.php';</script>";
    } else {
        echo "<script>alert('Invalid credential');window.location='../login.php';</script>";
    }
} else if (isset($_POST['update'])) {
    $spId = $_SESSION['sp_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $cpassword = $_POST['cpassword'];
    $npassword = $_POST['npassword'];
    $profile = "uploads/" . basename($_FILES['profile']['name']);
    move_uploaded_file($_FILES['profile']['tmp_name'], $profile);
    $qr = "uploads/" . basename($_FILES['qr']['name']);
    move_uploaded_file($_FILES['qr']['tmp_name'], $qr);
    if ($npassword == $cpassword) {
        if ($profile == "uploads/") {
            if ($qr == "uploads/") {
                $update = $admin->cud("UPDATE `s_provider` SET `sp_name`='$name',`sp_email`='$email',`sp_phone`='$phone',`sp_password`='$cpassword',`sp_address`='$address' WHERE `sp_id`='$spId'", "updated");
            } else {
                $update = $admin->cud("UPDATE `s_provider` SET `sp_name`='$name',`sp_email`='$email',`sp_phone`='$phone',`sp_password`='$cpassword',`sp_address`='$address',`sp_qrcode`='$qr' WHERE `sp_id`='$spId'", "updated");
            }
        } else {
            if ($qr == "uploads/") {
                $update = $admin->cud("UPDATE `s_provider` SET `sp_name`='$name',`sp_email`='$email',`sp_phone`='$phone',`sp_password`='$cpassword',`sp_address`='$address',`sp_profile_picture`='$profile' WHERE `sp_id`='$spId'", "updated");
            } else {
                $update = $admin->cud("UPDATE `s_provider` SET `sp_name`='$name',`sp_email`='$email',`sp_phone`='$phone',`sp_password`='$cpassword',`sp_address`='$address',`sp_profile_picture`='$profile',`sp_qrcode`='$qr' WHERE `sp_id`='$spId'", "updated");
            }
        }
        echo "<script>alert('Profile updated successfully');window.location='../settings.php';</script>";
    } else {
        echo "<script>alert('Password is not matching!');window.location='../settings.php';</script>";
    }
} else if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action == 'logout') {
        session_destroy();
        unset($_SESSION['sp_id']);
        echo "<script>alert('Logged out!');window.location='../login.php';</script>";
    }
} else {
    echo "<script>window.location='../login.php';</script>";

}

?>