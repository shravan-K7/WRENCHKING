<?php
include "../config.php";
$admin = new Admin();
if (isset($_SESSION['sp_id'])) {
    $aid = $_SESSION['sp_id'];
    $adminProfile = $admin->ret("SELECT * FROM `s_provider` WHERE `sp_id`='$aid'");
    $profile = $adminProfile->fetch(PDO::FETCH_ASSOC);
} else {
    echo "<script>window.location='./login.php';</script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Service Provider</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->

    <!-- Favicon -->
    <link rel="icon" href="favicon_io/favicon.ico">
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->

        <!-- Side Bar Start -->
        <?php include './includes/sidebar.php'; ?>
        <!-- Side Bar End -->

        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_navbar.html -->

            <!-- Header Start -->
            <?php include './includes/header.php'; ?>
            <!-- Header End -->

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row ">
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row d-flex justify-content-between align-items-center">
                                        <h4 class="card-title">Emergency Services</h4>
                                        <a class="btn btn-primary" href="./insert-emergency-services.php">Add new</a>

                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th> Service </th>
                                                    <th> Image </th>
                                                    <th> Description </th>
                                                    <th> Base Price </th>
                                                    <th> Created On </th>
                                                    <th> Status </th>
                                                    <th> Actions </th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <!-- edited -->
                                                <!-- <?php
                                                echo "<pre>";
                                                var_dump($aid);
                                                echo "</pre>";
                                                ?> -->
                                                <!-- edited -->

                                                <?php
                                                $getEmergencyServices = $admin->ret("SELECT * FROM `emergency_services` where `sp_id`='$aid'");
                                                $count = $getEmergencyServices->rowCount();
                                                if ($count > 0) {
                                                    while ($emergencyService = $getEmergencyServices->fetch(PDO::FETCH_ASSOC)) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $emergencyService['es_title']; ?></td>
                                                            <td>
                                                                <img style="border-radius: 0%;"
                                                                    src="./controllers/<?php echo $emergencyService['es_picture']; ?>"
                                                                    alt="service-image" />
                                                            </td>
                                                            <td>
                                                                <textarea readonly class="form-control bg-dark text-white"
                                                                    name=""
                                                                    id=""><?php echo $emergencyService['es_description']; ?></textarea>
                                                            </td>
                                                            <td> <?php echo $emergencyService['es_price']; ?></td>
                                                            <td> <?php echo $emergencyService['es_created_date']; ?></td>
                                                            <td>
                                                                <div class="badge badge-outline-success">
                                                                    <?php echo $emergencyService['es_status']; ?>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <a href="./update-emergency-service.php?es_id=<?php echo $emergencyService['es_id']; ?>"
                                                                    class="btn btn-primary">Update</a>

                                                            </td>
                                                        </tr>
                                                    <?php }
                                                } else { ?>
                                                    <tr>
                                                        <td colspan="7" align="center">no spare parts found!</td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include './includes/footer.php'; ?>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="assets/vendors/chart.js/Chart.min.js"></script>
    <script src="assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="assets/js/dashboard.js"></script>
    <!-- End custom js for this page -->
</body>

</html>