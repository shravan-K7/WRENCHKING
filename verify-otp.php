<?php
// session_start();
include './config.php';
$admin = new Admin();

if (!isset($_SESSION['pending_email'])) {
    echo "Session expired. Please register again.";
    exit;
}

$email = $_SESSION['pending_email'];
if (isset($_POST['verify'])) {
    $enteredOtp = $_POST['otp'];

    // Fetch OTP from pending_customers
    $stmt = $admin->ret("SELECT * FROM pending_customers WHERE email = '$email'");
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row['otp'] === $enteredOtp) {
            // OTP matched, insert into customer table
            $name = $row['name'];
            $phone = $row['phone'];
            $password = $row['password'];
            $sp_id = $row['sp_id'];

            $admin->cud("INSERT INTO customer (c_name, c_email, c_phone, c_password, c_status, sp_id) 
                         VALUES ('$name', '$email', '$phone', '$password', 'Active', '$sp_id')", "insert");

            // Delete from pending_customers
            $admin->cud("DELETE FROM pending_customers WHERE email = '$email'", "delete");

            unset($_SESSION['email']);
            echo "<script>alert('Registration complete! You can now log in.'); window.location='signin.php';</script>";
            exit;
        } else {
            echo "<script>alert('❌ Invalid OTP. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('❌ Email not found in pending list.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Verify OTP - WrenchKing</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #f5f5f5;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .card {
        animation: fadeInUp 0.8s ease;
        border-radius: 15px;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    @keyframes fadeInUp {
        from {
            transform: translateY(30px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    </style>
</head>

<body>

    <div class="card p-4 w-100" style="max-width: 400px;">
        <h2 class="text-center mb-4 text-danger">Verify OTP</h2>
        <form method="POST">
            <div class="mb-3">
                <input type="text" name="otp" class="form-control form-control-lg" placeholder="Enter OTP" required>
            </div>
            <div class="d-grid">
                <button type="submit" name="verify" class="btn btn-danger btn-lg">Verify</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>