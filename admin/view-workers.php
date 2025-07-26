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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['make_available'])) {
    $w_id = $_POST['w_id'];
    $admin->cud("UPDATE workers SET w_status = 'available' WHERE w_id = '$w_id'", "updated");
    echo "<script>window.location='view-workers.php';</script>";
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
                                        <h4 class="card-title">Workers</h4>
                                        <a class="btn btn-primary" href="./insert-worker.php">Add new</a>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Worker Name</th>
                                                    <th>Phone</th>
                                                    <th>Added On</th>
                                                    <th>Actions</th>
                                                    <th>Status</th> <!-- Status now placed last -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $getWorkers = $admin->ret("SELECT * FROM `workers` WHERE `sp_id`='$aid'");
                                                $count = $getWorkers->rowCount();
                                                $sno = 1;
                                                if ($count > 0) {
                                                    while ($workers = $getWorkers->fetch(PDO::FETCH_ASSOC)) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $sno++; ?></td>
                                                            <td><?php echo $workers['w_name']; ?></td>
                                                            <td><?php echo $workers['w_phone']; ?></td>
                                                            <td><?php echo $workers['added_date']; ?></td>
                                                            <td class="p-0">
                                                                <a href="./update-workers.php?w_id=<?php echo $workers['w_id']; ?>"
                                                                    class="btn btn-primary">Update</a>
                                                                <a href="controllers/process-update-workers.php?delete=1&w_id=<?php echo $workers['w_id']; ?>"
                                                                    onclick="return confirm('Are you sure you want to delete this worker?');"
                                                                    class="btn btn-danger">Remove</a>
                                                            </td>
                                                            <td>
                                                                <?php if ($workers['w_status'] === 'assigned'): ?>
                                                                    <span class="badge badge-warning">Assigned</span><br>
                                                                    <form method="POST" style="display:inline;">
                                                                        <input type="hidden" name="w_id"
                                                                            value="<?php echo $workers['w_id']; ?>">
                                                                        <button type="submit" name="make_available"
                                                                            class="btn btn-sm btn-success mt-1"
                                                                            onclick="return confirm('Are you sure you want to mark this worker as available?');">
                                                                            Make Available
                                                                        </button>
                                                                    </form>
                                                                <?php else: ?>
                                                                    <span class="badge badge-success">Available</span>
                                                                <?php endif; ?>
                                                            </td>


                                                        </tr>
                                                    <?php }
                                                } else { ?>
                                                    <tr>
                                                        <td colspan="6" align="center">No workers found!</td>
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
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>

    <?php include './includes/footer.php'; ?>

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