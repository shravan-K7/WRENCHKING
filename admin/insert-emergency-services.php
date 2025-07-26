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



                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Insert Emergency Service</h4>
                                    <p class="card-description"> Fill the form to insert new Emergency Service </p>
                                    <form class="forms-sample" action="./controllers/emergency-service.php"
                                        method="post" enctype="multipart/form-data">

                                        <div class="row">
                                            <!-- Service Provider ID
                                            <div class="form-group col-lg-2">
                                                <label for="spid">SP_ID</label>
                                                <input required type="number" class="form-control text-white"
                                                    name="spid" id="spid" placeholder="Service Provider ID">
                                            </div> -->

                                            <div class="form-group col-lg-4">
                                                <label for="name">Name</label>
                                                <input required type="text" class="form-control text-white" name="name"
                                                    id="name" placeholder="Service name">
                                            </div>

                                            <div class="form-group col-lg-4">
                                                <label for="picture">Picture</label>
                                                <input required type="file" class="form-control text-white" id="picture"
                                                    name="picture">
                                            </div>
                                            <div class="form-group  col-lg-3">
                                                <label for="exampleInputUsername1">Base Price</label>
                                                <input required type="number" class="form-control text-white"
                                                    id="exampleInputUsername1" name="price" placeholder="Service Price">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Description</label>
                                            <textarea required class="form-control text-white" id="exampleInputEmail1"
                                                name="description" placeholder="enter product desciprion"
                                                rows="2"></textarea>
                                        </div>

                                        <button type="submit" name="insert" class="btn btn-primary mr-2">Submit</button>
                                        <button type="reset" class="btn btn-dark">Cancel</button>
                                    </form>
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