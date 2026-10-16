<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success - WrenchKing</title>
    <link rel="icon" href="favicon_io/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 15px;
        }

        .success-card {
            max-width: 480px;
            width: 100%;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            text-align: center;
            padding: 40px 30px;
        }

        .icon-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #e8f5e9;
            color: #2e7d32;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin-bottom: 24px;
        }
    </style>
</head>

<body>
    <div class="success-card">
        <div class="icon-circle">
            <i class="bi bi-check-lg"></i>
        </div>
        <h2 class="fw-bold mb-2 text-dark">Thank You!</h2>
        <p class="text-muted mb-4">Your payment was completed successfully. Your order is now being processed.</p>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <a href="index.php" class="btn btn-primary px-4 py-2">Return to Homepage</a>
            <a href="order_history.php" class="btn btn-outline-secondary px-4 py-2">View Orders</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>