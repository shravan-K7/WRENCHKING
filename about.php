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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <?php include './includes/header.php'; ?>

    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url(img/carousel-bg-1.jpg);">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center">
                <h1 class="display-3 text-white mb-3 animated slideInDown">About Us</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">About</li> -->
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Mission & Vision Section -->
    <div class="container my-5">
        <h2 class="text-center mb-4 fw-bold" style="color: #343a40;">Our Mission & Vision</h2>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row g-4">
                    <!-- Mission -->
                    <div class="col-md-6">
                        <div class="p-4 rounded-4 shadow"
                            style="background: linear-gradient(135deg, #fceabb 0%, #f8b500 100%); color: #212529;">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-bullseye fs-2 me-3 text-dark"></i>
                                <div>
                                    <h4 class="fw-semibold">Our Mission</h4>
                                    <p class="mb-0 fs-5">
                                        At WrenchKing, our mission is to simplify car maintenance and repair through
                                        smart technology and dependable service tailored to customers’ needs.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Vision -->
                    <div class="col-md-6">
                        <div class="p-4 rounded-4 shadow"
                            style="background: linear-gradient(135deg, #d9e7ff 0%, #a3c9ff 100%); color: #212529;">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-eye fs-2 me-3 text-dark"></i>
                                <div>
                                    <h4 class="fw-semibold">Our Vision</h4>
                                    <p class="mb-0 fs-5">
                                        Our vision is to be the go-to platform for every vehicle owner, offering
                                        seamless, smart, and trustworthy automotive care and solutions anytime,
                                        anywhere.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 pt-4" style="min-height: 400px;">
                    <div class="position-relative h-100 wow fadeIn" data-wow-delay="0.1s">
                        <img class="position-absolute img-fluid w-100 h-100" src="img/aboutt.jpg"
                            style="object-fit: cover;" alt="">
                        <div class="position-absolute top-0 end-0 mt-n4 me-n4 py-4 px-5"
                            style="background: rgba(0, 0, 0, .08);">
                            <h1 class="display-4 text-white mb-0">5 <span class="fs-4">Years</span></h1>
                            <h4 class="text-white">Experience</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <!-- <h6 class="text-primary text-uppercase">About</h6> -->
                    <h1 class="mb-4 mt-3"><span class="text-primary">WrenchKing</span> Is The Best Place For Your Auto
                        Care
                    </h1>
                    <p class="mb-4">Trusted garage service offering expert repairs, fast support, genuine parts, and
                        complete care to keep your vehicle running smoothly.
                    </p>
                    <div class="row g-4 mb-3 pb-3">
                        <div class="col-12 wow fadeIn" data-wow-delay="0.1s">
                            <div class="d-flex">
                                <div class="bg-light d-flex flex-shrink-0 align-items-center justify-content-center mt-1"
                                    style="width: 45px; height: 45px;">
                                    <span class="fw-bold text-secondary">01</span>
                                </div>
                                <div class="ps-3">
                                    <h6>Professional & Expert</h6>
                                    <span>Our trained technicians deliver reliable automotive solutions with precision,
                                        professionalism, and a focus on long-term vehicle performance.</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 wow fadeIn" data-wow-delay="0.3s">
                            <div class="d-flex">
                                <div class="bg-light d-flex flex-shrink-0 align-items-center justify-content-center mt-1"
                                    style="width: 45px; height: 45px;">
                                    <span class="fw-bold text-secondary">02</span>
                                </div>
                                <div class="ps-3">
                                    <h6>Quality Servicing Center</h6>
                                    <span>WrenchKing ensures top-notch car care with advanced tools, expert hands, and
                                        timely service for complete customer satisfaction.</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 wow fadeIn" data-wow-delay="0.5s">
                            <div class="d-flex">
                                <div class="bg-light d-flex flex-shrink-0 align-items-center justify-content-center mt-1"
                                    style="width: 45px; height: 45px;">
                                    <span class="fw-bold text-secondary">03</span>
                                </div>
                                <div class="ps-3">
                                    <h6>Trusted by Thousands</h6>
                                    <span>WrenchKing is the go-to choice for thousands of happy customers seeking
                                        dependable, efficient, and affordable auto services every day.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Service Start -->
    <div class="container-xxl py-5">
        <div class="container mt-4">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="d-flex py-5 px-4">
                        <i class="fa fa-certificate fa-3x text-primary flex-shrink-0"></i>
                        <div class="ps-4">
                            <h5 class="mb-3">Quality Servicing</h5>
                            <p>Reliable and efficient car servicing with top-grade tools, ensuring your vehicle gets the
                                care it deserves every time.</p>
                            <!-- <a class="text-secondary border-bottom" href="">Read More</a> -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="d-flex bg-light py-5 px-4">
                        <i class="fa fa-users-cog fa-3x text-primary flex-shrink-0"></i>
                        <div class="ps-4">
                            <h5 class="mb-3">Expert Workers</h5>
                            <p>Skilled and certified professionals delivering high-quality automotive services with
                                precision, experience, and attention to detail.</p>
                            <!-- <a class="text-secondary border-bottom" href="">Read More</a> -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="d-flex py-5 px-4">
                        <i class="fa fa-tools fa-3x text-primary flex-shrink-0"></i>
                        <div class="ps-4">
                            <h5 class="mb-3">Modern Equipment</h5>
                            <p>Consistent, high-standard servicing tailored to your car’s needs, boosting performance,
                                safety, and customer satisfaction every visit.</p>
                            <!-- <a class="text-secondary border-bottom" href="">Read More</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->

    <!-- Fact Start -->
    <div class="container-fluid fact bg-light my-5 py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6 col-lg-4 text-center wow fadeIn" data-wow-delay="0.1s">
                    <i class="fa fa-check fa-2x text-white mb-3"></i>
                    <h2 class="text-white mb-2" data-toggle="counter-up">5</h2>
                    <p class="text-white mb-0">Years Experience</p>
                </div>
                <?php
                // Get completed count from service_booking
                $query1 = "SELECT COUNT(*) AS completed_count_service FROM service_booking WHERE sb_status = 'Completed'";
                $result1 = mysqli_query($conn, $query1);
                $row1 = mysqli_fetch_assoc($result1);
                $completedService = $row1['completed_count_service'];

                // Get completed count from e_booking
                $query2 = "SELECT COUNT(*) AS completed_count_emergency FROM e_booking WHERE eb_status = 'Completed'";
                $result2 = mysqli_query($conn, $query2);
                $row2 = mysqli_fetch_assoc($result2);
                $completedEmergency = $row2['completed_count_emergency'];

                // Total completed projects
                $completedCount = $completedService + $completedEmergency;
                ?>
                <div class="col-md-6 col-lg-4 text-center wow fadeIn" data-wow-delay="0.7s">
                    <i class="fa fa-car fa-2x text-white mb-3"></i>
                    <h2 class="text-white mb-2" data-toggle="counter-up">
                        <?php echo $completedCount; ?>
                    </h2>
                    <p class="text-white mb-0">Completed Projects</p>
                </div>

                <?php // Query to get total customers
                $queryCustomers = "SELECT COUNT(*) AS total_customers FROM customer";
                $resultCustomers = mysqli_query($conn, $queryCustomers);
                $rowCustomers = mysqli_fetch_assoc($resultCustomers);
                $totalCustomers = $rowCustomers['total_customers']; ?>

                <div class="col-md-6 col-lg-4 text-center wow fadeIn" data-wow-delay="0.1s">
                    <i class="fa fa-users fa-2x text-white mb-3"></i>
                    <h2 class="text-white mb-2" data-toggle="counter-up">
                        <?php echo $totalCustomers; ?>
                    </h2>
                    <p class="text-white mb-0">Registered Customers</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Fact End -->

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