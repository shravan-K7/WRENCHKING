<?php
include "../config.php";
$admin = new Admin();
if (isset($_SESSION['sp_id'])) {
    $spid = $_SESSION['sp_id'];
    $adminProfile = $admin->ret("SELECT * FROM `s_provider` WHERE `sp_id`='$spid'");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <!-- <link rel="icon" href="http://localhost/admin/assets/images/favicon1.ico" type="image/x-icon"> -->

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
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card corona-gradient-card">
                                <div class="card-body py-0 px-0">
                                    <div class="row align-items-center">
                                        <div class="row w-100 g-2 gap-2 p-3 align-items-center">
                                            <div class="col-lg-1 px-3">
                                                <?php if ($profile['sp_profile_picture'] == "" || $profile['sp_profile_picture'] == "uploads/") { ?>
                                                    <img class="img-xl rounded-circle" src="assets/images/faces/face15.jpg"
                                                        alt="">
                                                <?php } else { ?>
                                                    <img style="width: 100%;border-radius:10%"
                                                        src="./controllers/<?php echo $profile['sp_profile_picture']; ?>"
                                                        alt="">
                                                <?php } ?>
                                            </div>
                                            <div class="col-lg-10 align-items-center flex-column px-4">
                                                <h3><?php echo $profile['sp_name']; ?></h3>
                                                <h6><?php echo $profile['sp_address']; ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">QR Code</h4>
                                    <?php if ($profile['sp_qrcode'] == "" || $profile['sp_qrcode'] == "uploads/") { ?>
                                        <div class="row d-flex justify-content-center align-items-center h-100">
                                            <p class="text-secondary">Upload qr code</p>
                                        </div>
                                    <?php } else { ?>
                                        <img style="width: 100%; border-radius:4%;"
                                            src="./controllers/<?php echo $profile['sp_qrcode']; ?>" alt=""> <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-row justify-content-between">
                                        <h4 class="card-title mb-1">Update profile</h4>
                                    </div>
                                    <form action="./controllers/auth.php" method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label class="form-label" for="name">Name</label>
                                                <input class="form-control text-white" type="text" name="name" id="name"
                                                    value="<?php echo $profile['sp_name']; ?>">
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="form-label" for="email">Email</label>
                                                <input class="form-control text-white" type="email" name="email"
                                                    id="email" value="<?php echo $profile['sp_email']; ?>">
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="form-label" for="phone">Phone</label>
                                                <input class="form-control text-white" type="tele" name="phone"
                                                    pattern="\d{10}" maxlength="10" minlength="10" id="phone"
                                                    value="<?php echo $profile['sp_phone']; ?>">
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="form-label" for="address">Address</label>
                                                <input class="form-control text-white" type="text" name="address"
                                                    id="address" value="<?php echo $profile['sp_address']; ?>">
                                            </div>

                                            <div class="col-lg-6">
                                                <label class="form-label" for="profile">Upload Picture</label>
                                                <input class="form-control text-white" type="file" name="profile"
                                                    id="profile" accept="image/*">
                                            </div>

                                            <div class="col-lg-6">
                                                <label class="form-label" for="qr">Upload QR Code</label>
                                                <input class="form-control text-white" type="file" name="qr" id="qr"
                                                    accept="image/*">
                                            </div>


                                            <div class="col-lg-6 mb-3">
                                                <label class="form-label" for="npassword">New Password</label>
                                                <div class="input-group position-relative">
                                                    <input class="form-control text-white" type="password"
                                                        name="npassword" id="npassword">
                                                    <span class="input-group-text bg-transparent border-start-0"
                                                        style="cursor: pointer;" id="toggleNPassword">
                                                        <i class="bi bi-eye-slash-fill text-white"></i>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                                <label class="form-label" for="cpassword">Confirm Password</label>
                                                <div class="input-group position-relative">
                                                    <input class="form-control text-white" type="password"
                                                        name="cpassword" id="cpassword">
                                                    <span class="input-group-text bg-transparent border-start-0"
                                                        style="cursor: pointer;" id="toggleCPassword">
                                                        <i class="bi bi-eye-slash-fill text-white"></i>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 mt-2 d-flex justify-content-end">
                                                <button type="submit" name="update"
                                                    class="bn btn-primary">Update</button>
                                            </div>
                                        </div>
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
    </div>
    </div>
    </div>
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="assets/vendors/chart.js/Chart.min.js"></script>
    <script src="assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <script src="assets/js/dashboard.js"></script>

    <!-- script for password eye button toggle -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function setupToggle(inputId, toggleId) {
                const input = document.getElementById(inputId);
                const toggle = document.getElementById(toggleId);
                const icon = toggle.querySelector("i");

                toggle.addEventListener("click", function () {
                    const isPassword = input.type === "password";
                    input.type = isPassword ? "text" : "password";
                    icon.classList.toggle("bi-eye-fill", isPassword);
                    icon.classList.toggle("bi-eye-slash-fill", !isPassword);
                });
            }

            setupToggle("npassword", "toggleNPassword");
            setupToggle("cpassword", "toggleCPassword");
        });
    </script>

    <!-- script for to only accept image format for updating qr and profile -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function validateImageInput(inputId) {
                const input = document.getElementById(inputId);

                input.addEventListener("change", function () {
                    const file = input.files[0];
                    if (file && !file.type.startsWith("image/")) {
                        alert("Only image files are allowed!");
                        input.value = ""; // Reset the file input
                    }
                });
            }

            validateImageInput("profile");
            validateImageInput("qr");
        });
        document.getElementById("yourFormId").addEventListener("submit", function (e) {
            const profile = document.getElementById("profile").files[0];
            const qr = document.getElementById("qr").files[0];

            if ((profile && !profile.type.startsWith("image/")) ||
                (qr && !qr.type.startsWith("image/"))) {
                alert("Please upload valid image files only.");
                e.preventDefault();
            }
        });
    </script>


</body>

</html>OMCont