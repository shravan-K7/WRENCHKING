<?php
include './config.php';
$admin = new Admin();

if (!isset($_GET['c_id']) || !isset($_GET['grand_total'])) {
    echo "<script>alert('Invalid request!'); window.location='./checkout.php';</script>";
    exit;
}

$cId = $_GET['c_id'];
$grandTotal = $_GET['grand_total'];

// Get the first service provider from the cart
$getFirstSP = $admin->ret("SELECT product.sp_id FROM cart 
    INNER JOIN product ON product.p_id = cart.p_id 
    WHERE cart.c_id = '$cId' LIMIT 1");

if ($getFirstSP->rowCount() > 0) {
    $firstSP = $getFirstSP->fetch(PDO::FETCH_ASSOC);
    $serviceProvider = $firstSP['sp_id'];

    // Fetch provider profile
    $serviceProviderProfile = $admin->ret("SELECT * FROM `s_provider` WHERE `sp_id`='$serviceProvider'");
    if ($serviceProviderProfile->rowCount() > 0) {
        $profile = $serviceProviderProfile->fetch(PDO::FETCH_ASSOC);
    } else {
        echo '<script>alert("Service Provider details not found."); window.location="./checkout.php";</script>';
        exit;
    }
} else {
    echo '<script>alert("No service provider found in your cart."); window.location="./checkout.php";</script>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>WrenchKing</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link rel="icon" href="favicon_io/favicon.ico">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@600;700&family=Ubuntu:wght@400;500&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="styles.css"> <!-- Link to CSS file -->

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <?php include './includes/header.php'; ?>

    <div class="container">
        <h2 class="text-center bg-primary text-white rounded-3 p-3">Transaction Mode</h2>

        <div class="row mt-4 justify-content-center">
            <div class="col-md-6 text-center">
                <h5>Scan QR Code to Pay</h5>
                <?php if (!empty($profile['sp_qrcode']) && $profile['sp_qrcode'] != "uploads/") { ?>
                <img style="width: 250px; border-radius:4%;"
                    src="./admin/controllers/<?php echo $profile['sp_qrcode']; ?>" alt="QR Code">
                <?php } else { ?>
                <p class="text-muted">No QR code available.</p>
                <?php } ?>
            </div>
        </div>

        <div class="row mt-3 justify-content-center">
            <div class="col-md-6">
                <label for="tid" class="form-label">Transaction ID</label>
                <input type="text" id="tid" name="tid" class="form-control" maxlength="12"
                    placeholder="Enter UPI transaction ID here" required>
            </div>
        </div>

        <div class="row mt-4 justify-content-center">
            <div class="col-md-6 text-center">
                <h4>Total Amount: ₹<?php echo $grandTotal; ?></h4>
                <button class="btn btn-success w-100 py-3 m-2 rounded-3" type="submit">Confirm Payment</button>
            </div>
        </div>
    </div>

    <?php include './includes/footer.php'; ?>
</body>

</html>