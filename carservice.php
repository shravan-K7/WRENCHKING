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

</head>

<body>
    <!-- Header -->
    <?php

    include './includes/header.php';

    ?>
    <!-- Header end -->


    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-0 p-0">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Explore Our Services</h1>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Service Start -->
    <div class="service py-4">
        <div class="container">
            <div class="d-flex justify-content-end mb-3">
                <form method="GET" class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center gap-2 w-100 justify-content-sm-end">
                    <label for="sp_id" class="form-label text-white m-0 bg-danger px-3 py-2 rounded text-center text-nowrap">Select Service Provider</label>
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
            <br>

            <div class="row g-4 wow fadeInUp" data-wow-delay="0.3s">

                <?php if (empty($selectedSpId)) { ?>
                    <div class="col-12">
                        <div class="alert alert-warning text-center my-4" role="alert">
                            Please select a service provider!
                        </div>
                    </div>
                <?php } ?>

                <div class="col-lg-4">
                    <div class="nav w-100 nav-pills me-4">
                        <?php
                        if (!empty($selectedSpId)) {
                            $getServices = $admin->ret("SELECT * FROM `services` WHERE sp_id = '$selectedSpId'");
                            if ($getServices->rowCount() > 0) {
                                $first = true;
                                while ($service = $getServices->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <button
                                        class="nav-link w-100 d-flex align-items-center text-start p-4 mb-4 <?php echo $first ? 'active' : ''; ?>"
                                        data-bs-toggle="pill" data-bs-target="#tab-<?php echo $service['s_id'] ?>" type="button">
                                        <h4 class="m-0"><?php echo $service['s_title'] ?></h4>
                                    </button>
                                    <?php
                                    $first = false;
                                }
                            } else {
                                echo "<p>No services found for this provider!</p>";
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="tab-content w-100">
                        <?php
                        if (!empty($selectedSpId)) {
                            $getServices = $admin->ret("SELECT * FROM `services` WHERE sp_id = '$selectedSpId'");
                            if ($getServices->rowCount() > 0) {
                                $first = true;
                                while ($service = $getServices->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <div class="tab-pane fade <?php echo $first ? 'show active' : ''; ?>"
                                        id="tab-<?php echo $service['s_id'] ?>">
                                        <div class="row g-4">
                                            <div class="col-md-6" style="min-height: 350px;">
                                                <div class="position-relative h-100">
                                                    <img class="position-absolute img-fluid w-100 h-100"
                                                        src="./admin/controllers/<?php echo $service['s_image'] ?>"
                                                        style="object-fit:cover;" alt="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h3 class="mb-3"><?php echo $service['s_title'] ?></h3>
                                                <p class="mb-4"><?php echo $service['s_description'] ?></p>
                                                <h4>Base Price: ₹<?php echo $service['s_price'] ?></h4>

                                                <div class="mt-2 p-2 border-start border-4 border-warning rounded"
                                                    style="background-color: #fff3cd;">
                                                    <p class="mb-0 text-dark">
                                                        <strong>Note:</strong> Price may vary based on car condition.
                                                    </p>
                                                </div>

                                                <a href="./book-service.php?s_id=<?php echo $service['s_id'] ?>"
                                                    class="btn btn-primary py-3 px-5 mt-3">
                                                    Book <i class="fa fa-arrow-right ms-3"></i>
                                                </a>
                                            </div>



                                        </div>
                                    </div>
                                    <?php
                                    $first = false;
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Service End -->
    <br>

    <!-- Call To Action Start -->
    <?php
    $contactNumber = "";
    $contactName = "";

    $defaultSpId = 1;
    $activeSpId = !empty($selectedSpId) ? $selectedSpId : $defaultSpId;

    $getSp = $admin->ret("SELECT sp_name, sp_phone FROM `s_provider` WHERE sp_id = '$activeSpId'");
    if ($getSp->rowCount() > 0) {
        $sp = $getSp->fetch(PDO::FETCH_ASSOC);
        $contactNumber = $sp['sp_phone'];
        $contactName = $sp['sp_name'];
    }
    ?>

    <div class="bg-light py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8 col-md-6">
                    <h1 class="mb-4">Have Any Pre Booking Question?</h1>
                    <p class="mb-0">
                        If you have any questions about services offered by
                        ,
                        pricing, or the booking process, feel free to reach out. We're here to help you make informed
                        decisions
                        for your vehicle's care.
                    </p>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="bg-primary d-flex flex-column justify-content-center text-center h-100 p-4">
                        <h3 class="text-white mb-2">
                            <i class="fa fa-phone-alt me-3"></i><?php echo $contactNumber; ?>
                            <br>
                            <span class="small" style="font-size: 20px;"><?php echo $contactName; ?></span>

                        </h3>
                        <!-- <a href="contact.php" class="btn btn-secondary py-3 px-5">Contact Us</a> -->
                        <div class="btn btn-secondary py-3 px-5"> Contact Us</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call To Action End -->

    <!-- Footer Start -->
    <?php include './includes/footer.php'; ?>
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

    <!-- Bootstrap Bundle (Includes Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>



    <!-- Template Javascript -->
    <script src="js/main.js"></script>



</body>

</html>