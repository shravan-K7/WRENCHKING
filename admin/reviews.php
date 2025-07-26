<?php
include "../config.php";
$admin = new Admin();
if (isset($_SESSION['sp_id'])) {
    $aid = $_SESSION['sp_id'];
    $adminProfile = $admin->ret("SELECT * FROM `s_provider` WHERE `sp_id`='$aid'");
    $profile = $adminProfile->fetch(PDO::FETCH_ASSOC);
    $branch = $profile['sp_id']; // get SP branch
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
        <!-- Side Bar Start -->
        <?php include './includes/sidebar.php'; ?>
        <!-- Side Bar End -->

        <div class="container-fluid page-body-wrapper">
            <!-- Header Start -->
            <?php include './includes/header.php'; ?>
            <!-- Header End -->

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row ">
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Reviews
                                        <!-- (Branch:
                                        <?php echo htmlspecialchars($branch); ?>) -->
                                    </h4>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <!-- <th>Branch</th> -->
                                                    <th>Subject</th>
                                                    <th>Message</th>
                                                    <th>Submitted At</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $getContacts = $admin->ret("SELECT * FROM `contact` WHERE `branch`='$branch' ORDER BY `created_at` DESC");
                                                $count = $getContacts->rowCount();
                                                $sno = 1;
                                                if ($count > 0) {
                                                    while ($contact = $getContacts->fetch(PDO::FETCH_ASSOC)) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $sno++; ?></td>
                                                            <td><?php echo htmlspecialchars($contact['name']); ?></td>
                                                            <td><?php echo htmlspecialchars($contact['email']); ?></td>
                                                            <!-- <td><?php echo htmlspecialchars($contact['branch']); ?></td> -->
                                                            <td><?php echo htmlspecialchars($contact['subject']); ?></td>
                                                            <td>
                                                                <textarea class="form-control" rows="3" readonly
                                                                    style="background-color: #000; color: #fff;"><?php echo htmlspecialchars($contact['message']); ?></textarea>
                                                            </td>


                                                            <td><?php echo htmlspecialchars($contact['created_at']); ?></td>
                                                        </tr>
                                                    <?php }
                                                } else { ?>
                                                    <tr>
                                                        <td colspan="7" align="center">No contact submissions found for your
                                                            branch!</td>
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