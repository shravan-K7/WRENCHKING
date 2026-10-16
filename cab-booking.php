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
    <link href="css/spare.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .company-card {
            transition: transform 0.3s;
        }

        .company-card:hover {
            transform: translateY(-5px);
        }

        .star-rating {
            color: gold;
        }

        .company-img {
            width: 100%;
            height: 150px;
            object-fit: contain;
            padding: 15px;
            background: #ffffff;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <?php
    include './includes/header.php';
    ?>
    <!-- Header end -->

    <div class="container mt-5">
        <h2 class="text-center mb-4">Top Cab Booking Services</h2>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">
            <div class="col">
                <div class="card company-card shadow-sm border-0 h-100">
                    <a href="https://www.olacabs.com/" target="_blank">
                        <img src="img/olacab.png" class="company-img" alt="Ola Cabs">
                    </a>
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <a href="https://www.olacabs.com/" class="text-decoration-none" target="_blank">Ola Cabs</a>
                        </h6>
                        <p class="card-text">India's leading ride-hailing service offering city, rental, and outstation
                            cabs.</p>
                        <div class="star-rating">★★★★★</div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card company-card shadow-sm border-0 h-100">
                    <a href="https://www.uber.com/" target="_blank">
                        <img src="img/UBER.jpg" class="company-img" alt="Uber">
                    </a>
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <a href="https://www.uber.com/" class="text-decoration-none" target="_blank">Uber</a>
                        </h6>
                        <p class="card-text">Global cab service with a variety of ride options, including UberGo, UberX,
                            and UberXL.</p>
                        <div class="star-rating">★★★★★</div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card company-card shadow-sm border-0 h-100">
                    <a href="https://www.rapido.bike/" target="_blank">
                        <img src="img/rapido.png" class="company-img" alt="Rapido">
                    </a>
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <a href="https://www.rapido.bike/" class="text-decoration-none" target="_blank">Rapido</a>
                        </h6>
                        <p class="card-text">Affordable bike-taxi and auto services available across multiple cities in
                            India.</p>
                        <div class="star-rating">★★★★☆</div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card company-card shadow-sm border-0 h-100">
                    <a href="https://www.savaari.com/" target="_blank">
                        <img src="img/savaari.png" class="company-img" alt="Savaari Car Rentals">
                    </a>
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <a href="https://www.savaari.com/" class="text-decoration-none" target="_blank">Savaari Car
                                Rentals</a>
                        </h6>
                        <p class="card-text">Best option for outstation and long-distance road trips with professional
                            drivers.</p>
                        <div class="star-rating">★★★★☆</div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card company-card shadow-sm border-0 h-100">
                    <a href="https://www.blablacar.in/" target="_blank">
                        <img src="img/BlaBlaCar-Logo.png" class="company-img" alt="BlaBlaCar">
                    </a>
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <a href="https://www.blablacar.in/" class="text-decoration-none"
                                target="_blank">BlaBlaCar</a>
                        </h6>
                        <p class="card-text">Carpooling platform for long-distance travel with shared rides at
                            affordable prices.</p>
                        <div class="star-rating">★★★★☆</div>
                    </div>
                </div>
            </div>
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