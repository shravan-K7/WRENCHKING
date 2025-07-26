<?php
include "../config.php";
$admin = new Admin();
if (isset($_SESSION['sp_id'])) {
    $aid = $_SESSION['sp_id'];
    $adminProfile = $admin->ret("SELECT * FROM `s_provider` WHERE `sp_id`='$aid'");
    $profile = $adminProfile->fetch(PDO::FETCH_ASSOC);
    $sid = $_GET['s_id'];
    $getServices = $admin->ret("SELECT * FROM `services` WHERE `s_id`='$sid'");
    $service = $getServices->fetch(PDO::FETCH_ASSOC);

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
                                    <img src="./controllers/<?php echo $service['s_image']; ?>" alt="image"
                                        style="width:100px;float:right" />
                                    <h4 class="card-title">Update Service</h4>
                                    <p class="card-description"> Fill the form to Update Service </p>

                                    <form action="./controllers/process-update-services.php" method="post"
                                        enctype="multipart/form-data">

                                        <!-- Hidden input field for product ID -->
                                        <input type="hidden" name="s_id" value="<?php echo $service['s_id']; ?>">

                                        <div class="row">
                                            <div class="form-group col-lg-4">
                                                <label for="exampleInputUsername1">Name</label>
                                                <input required type="text" class="form-control text-white" name="name"
                                                    id="exampleInputUsername1"
                                                    value="<?php echo $service['s_title']; ?>"
                                                    placeholder="Product name">
                                            </div>
                                            <div class="form-group  col-lg-2">
                                                <label for="exampleInputUsername1">Picture</label>
                                                <input type="file" class="form-control text-white"
                                                    id="exampleInputUsername1" name="picture">
                                            </div>
                                            <div class="form-group  col-lg-3">
                                                <label for="exampleInputUsername1">Price</label>
                                                <input required type="number" class="form-control text-white"
                                                    name="price" value="<?php echo $service['s_price']; ?>"
                                                    placeholder="Service Price">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Description</label>
                                            <textarea required class="form-control text-white" name="description"
                                                rows="2"><?php echo $service['s_description']; ?></textarea>
                                        </div>

                                        <button type="submit" name="update" class="btn btn-primary mr-2">Update</button>
                                        <button type="reset" class="btn btn-dark">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <?php include './includes/footer.php'; ?>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
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