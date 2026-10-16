<?php
include './config.php';
$admin = new Admin();
if (isset($_SESSION['c_id'])) {
    $cId = $_SESSION["c_id"];
    $customerProfile = $admin->ret("SELECT * FROM `customer` WHERE `c_id`='$cId'");
    $profile = $customerProfile->fetch(PDO::FETCH_ASSOC);
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
    <style>
        body {
            background-color: #f8f9fa;
        }

        .service-card {
            border-radius: 10px;
            transition: transform 0.3s;
        }

        .service-card:hover {
            transform: scale(1.05);
        }

        .service-icon {
            font-size: 40px;
            color: #ff6600;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <?php

    include './includes/header.php';

    ?>
    <!-- Header end -->


    <div class="text-center py-4 pb-0">
        <h1>Emergency Roadside Assistance</h1>
        <p class="pb-">Reliable & Quick Help When You Need It Most</p>
    </div>

    <div class="container my-3">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div class="p-2 px-3 rounded shadow-sm"
                style="background-color: #fff3cd; border-left: 5px solid #ffd70d; color:#000000;">
                <strong>Note:</strong> Booking on Sunday is not available.
            </div>
            <form method="GET" class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center gap-2">
                <label for="sp_id" class="form-label text-white m-0 bg-danger px-3 py-2 rounded text-nowrap text-center">Select Service Provider</label>
                <select name="sp_id" id="sp_id" class="form-select" style="height: 48px; width: auto; min-width: 200px;"
                    onchange="this.form.submit()">
                    <option hidden>Select Garage</option>
                    <?php
                    $getServiceProvider = $admin->ret("SELECT * FROM `s_provider`");
                    if ($getServiceProvider->rowCount() > 0) {
                        $selectedSpId = isset($_GET['sp_id']) ? $_GET['sp_id'] : '';
                        while ($serviceProvider = $getServiceProvider->fetch(PDO::FETCH_ASSOC)) {
                            $selected = ($serviceProvider['sp_id'] == $selectedSpId) ? 'selected' : '';
                            ?>
                            <option value="<?php echo $serviceProvider['sp_id'] ?>" <?php echo $selected; ?>>
                                <?php echo $serviceProvider['sp_name'] ?>
                            </option>
                            <?php
                        }
                    } else {
                        echo "<option disabled>No service providers available</option>";
                    }
                    ?>
                </select>
            </form>
        </div>
    </div>
    <div class="container my-5">

        <div class="row g-4">
            <?php
            if (isset($_GET['sp_id'])) {
                $sp_id = $_GET['sp_id'];
                $getEservices = $admin->ret("SELECT * FROM `emergency_services` inner join `s_provider` on s_provider.sp_id=emergency_services.sp_id where emergency_services.sp_id='$sp_id' and  `es_status`='Available'");
            } else {
                $getEservices = $admin->ret("SELECT * FROM `emergency_services` inner join `s_provider` on s_provider.sp_id=emergency_services.sp_id where `es_status`='Available'");
            }


            $count = $getEservices->rowCount();
            if ($count > 0) {
                while ($eservice = $getEservices->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <div class="col-md-4">
                        <div class="card service-card p-3 text-center shadow-sm">

                            <img src="./admin/controllers/<?php echo $eservice['es_picture']; ?>"
                                class="img-fluid w-25 d-block mx-auto" alt="Spark Plug">
                            <h5><?php echo $eservice['es_title']; ?></h5>
                            <div class="d-flex justify-content-center align-items-center text-center text-dark">
                                <small class="fa fa-map-marker-alt text-primary me-2"></small>
                                <small><?php echo $eservice['sp_address']; ?></small>
                            </div>
                            <p class="m-0"><?php echo $eservice['es_description']; ?></p>
                            <h6>Base Price: ₹<?php echo $eservice['es_price'] ?></h6>
                            <?php
                            $dayOfWeek = date('w'); // 0 (for Sunday) through 6 (for Saturday)
                            // $dayOfWeek = 0; // Uncomment this to force Sunday for testing
                    
                            if ($dayOfWeek >= 1 && $dayOfWeek <= 6) {
                                ?>
                                <a href="./e-service-book.php?es_id=<?php echo $eservice['es_id']; ?>">Book Now</a>
                                <?php
                            } else {
                                ?>
                                <span style="color: grey; cursor: not-allowed;" title="Booking not available on Sunday">Book
                                    Now</span>
                                <div
                                    style="margin-top: 10px; padding: 10px; background-color: #ffe0e0; border: 1px solid #ffcccc; color: #990000;">
                                    <strong>Note:</strong> Booking on Sunday is not available.
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                <?php }
            } else { ?>
                <div class="col col-lg-12 pt-5">
                    <div class="d-flex justify-content-center">
                        No products found!
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="text-center mt-5">
            <h2>Need a Ride? Book a Cab Now!</h2>
            <p>Get quick and reliable cab service to your destination.</p>
            <?php if (isset($_SESSION['c_id'])): ?>
                <a href="cab-booking.php" class="btn btn-primary px-4 py-2">Book a Cab</a>
            <?php else: ?>
                <a href="signin.php" class="btn btn-danger px-4 py-2">Login to Book</a>
            <?php endif; ?>
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