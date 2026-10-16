<?php
include './config.php';
$admin = new Admin();
if (isset($_SESSION['c_id'])) {
    $cId = $_SESSION["c_id"];
    $customerProfile = $admin->ret("SELECT * FROM `customer` WHERE `c_id`='$cId'");

    if ($customerProfile->rowCount() > 0) {
        $profile = $customerProfile->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "No customer data found.";
        exit;
    }
} else {
    header("Location: signin.php"); // Redirect to login if session doesn't exist
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Account Dashboard - WrenchKing</title>
    <!-- Favicon -->
    <link rel="icon" href="favicon_io/favicon.ico">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@600;700&family=Ubuntu:wght@400;500&display=swap"
        rel="stylesheet">

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

    <!-- Header -->
    <?php
    include './includes/header.php';
    ?>
    <!-- Header end -->
    <br>
    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->
            <?php include './includes/sidebar_profile.php'; ?>

            <!-- Main Content -->
            <main class="col-md-9 col-lg-10">
                <div class="card shadow-sm border-0 mb-4 overflow-hidden">
                    <div class="bg-primary text-center p-4">
                        <h2 class="mb-1 text-white">
                            <?php echo htmlspecialchars($profile['c_name']); ?>
                        </h2>
                        <p class="mb-0 text-white-50">
                            <?php echo htmlspecialchars($profile['c_email']); ?>
                        </p>
                    </div>

                    <div class="card-body p-4">
                        <h3 class="card-title mb-2">Personal Info</h3>
                        <p class="text-muted mb-4">View and edit your personal info below.</p>

                        <div class="table-responsive">
                            <table class="table table-borderless align-middle mb-4">
                                <tbody>
                                    <tr>
                                        <td class="text-muted fw-bold" style="width: 140px;">Username:</td>
                                        <td><?php echo htmlspecialchars($profile['c_name']); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted fw-bold">Email:</td>
                                        <td><?php echo htmlspecialchars($profile['c_email']); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted fw-bold">Phone:</td>
                                        <td><?php echo htmlspecialchars($profile['c_phone']); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted fw-bold">Address:</td>
                                        <td><?php echo !empty($profile['c_address']) ? htmlspecialchars($profile['c_address']) : '<span class="text-muted">Not provided</span>'; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="update_profile.php" class="btn btn-danger px-4">Edit Profile</a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Footer Start -->
    <?php
    include './includes/footer.php';
    ?>
    <!-- Footer End -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>