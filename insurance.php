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
    <link href="css/spare.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .company-card {
            transition: transform 0.3s;
        }

        .company-card:hover {
            transform: scale(1.05);
        }

        .star-rating {
            color: gold;
        }

        .company-img {
            width: 100%;
            height: 150px;
            object-fit: cover;
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
        <h2 class="text-center mb-4">Company Listings</h2>
        <div class="row row-cols-1 row-cols-md-4 g-4">
            <div class="col">
                <div class="card company-card shadow-sm border-0 h-100">
                    <a href="https://www.bajajallianz.com/motor-insurance/car-insurance-online/buy-online.html"
                        target="_blank">
                        <img src="img/Bajaj-Allianz.png" class="company-img" alt="Bajaj Allianz">
                    </a>
                    <div class="card-body text-center">
                        <h6 class="card-title"><a
                                href="https://www.bajajallianz.com/motor-insurance/car-insurance-online/buy-online.html"
                                class="text-decoration-none" target="_blank">Bajaj Allianz</a></h6>
                        <p class="card-text">Bajaj Allianz offers comprehensive and third-party car insurance with quick
                            claims, roadside assistance, and add-ons.</p>
                        <div class="star-rating">★★★★★</div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card company-card shadow-sm border-0 h-100">
                    <a href="https://www.icicilombard.com/motor-insurance/car-insurance" target="_blank">
                        <img src="img/icici.jpg" class="company-img" alt="ICICI Lombard">
                    </a>
                    <div class="card-body text-center">
                        <h6 class="card-title"><a href="https://www.icicilombard.com/motor-insurance/car-insurance"
                                class="text-decoration-none" target="_blank">ICICI Lombard</a></h6>
                        <p class="card-text">Offers comprehensive and third-party car insurance with cashless repairs,
                            add-ons, and instant claim settlement.</p>
                        <div class="star-rating">★★★★☆</div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card company-card shadow-sm border-0 h-100">
                    <a href="https://www.tataaig.com/motor-insurance/car-insurance" target="_blank">
                        <img src="img/tata-aig.png" class="company-img" alt="TATA AIG Insurance">
                    </a>
                    <div class="card-body text-center">
                        <h6 class="card-title"><a href="https://www.tataaig.com/motor-insurance/car-insurance"
                                class="text-decoration-none" target="_blank">TATA AIG Insurance</a></h6>
                        <p class="card-text">Provides extensive car insurance coverage with 24/7 assistance, quick
                            claims, and customizable add-on covers.</p>
                        <div class="star-rating">★★★★☆</div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card company-card shadow-sm border-0 h-100">
                    <a href="https://www.hdfcergo.com/campaigns/car-insurance-4" target="_blank">
                        <img src="img/hdfc-ergo.jpg" class="company-img" alt="HDFC ERGO">
                    </a>
                    <div class="card-body text-center">
                        <h6 class="card-title"><a href="https://www.hdfcergo.com/campaigns/car-insurance-4"
                                class="text-decoration-none" target="_blank">HDFC ERGO</a></h6>
                        <p class="card-text">Features hassle-free car insurance with cashless garages, overnight
                            repairs, and instant online policy issuance.</p>
                        <div class="star-rating">★★★★☆</div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card company-card shadow-sm border-0 h-100">
                    <a href="https://www.sbigeneral.in/motor-insurance/private-car-insurance" target="_blank">
                        <img src="img/sbigenerel.png" class="company-img" alt="SBI General">
                    </a>
                    <div class="card-body text-center">
                        <h6 class="card-title"><a href="https://www.sbigeneral.in/motor-insurance/private-car-insurance"
                                class="text-decoration-none" target="_blank">SBI General</a></h6>
                        <p class="card-text">Covers damages, third-party liability, and roadside assistance with easy
                            claim settlement for car insurance.</p>
                        <div class="star-rating">★★★★★</div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card company-card shadow-sm border-0 h-100">
                    <a href="https://www.magmainsurance.com/products/motor-insurance/private-car" target="_blank">
                        <img src="img/magma.png" class="company-img" alt="Magma HDI General Insurance">
                    </a>
                    <div class="card-body text-center">
                        <h6 class="card-title"><a
                                href="https://www.magmainsurance.com/products/motor-insurance/private-car"
                                class="text-decoration-none" target="_blank">Magma HDI General Insurance</a></h6>
                        <p class="card-text">Offers comprehensive and third-party car insurance with quick claims,
                            add-ons, and roadside assistance.</p>
                        <div class="star-rating">★★★★☆</div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card company-card shadow-sm border-0 h-100">
                    <a href="https://www.reliancegeneral.co.in/" target="_blank">
                        <img src="img/reliance-general-insurance.jpg" class="company-img"
                            alt="Reliance General Insurance">
                    </a>
                    <div class="card-body text-center">
                        <h6 class="card-title"><a href="https://www.reliancegeneral.co.in/" class="text-decoration-none"
                                target="_blank">Reliance General Insurance</a></h6>
                        <p class="card-text">Provides cashless car insurance with roadside assistance, add-ons, and
                            instant policy issuance online.</p>
                        <div class="star-rating">★★★★★</div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card company-card shadow-sm border-0 h-100">
                    <a href="https://www.universalsompo.com/" target="_blank">
                        <img src="img/Universal-Sompo.jpg" class="company-img" alt="Universal Sompo">
                    </a>
                    <div class="card-body text-center">
                        <h6 class="card-title"><a href="https://www.universalsompo.com/" class="text-decoration-none"
                                target="_blank">Universal Sompo</a></h6>
                        <p class="card-text">Hybrid car insurance solutions with own damage, third-party coverage, and
                            seamless claim settlement services.</p>
                        <div class="star-rating">★★★★★</div>
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
    <script src="js/sparpurchase.js"></script>
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