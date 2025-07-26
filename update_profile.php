<?php
include './config.php';
$admin = new Admin();
if (isset($_SESSION['c_id'])) {
    $cId = $_SESSION["c_id"];
    $customerProfile = $admin->ret("SELECT * FROM `customer` WHERE `c_id`='$cId'");

    if ($customerProfile->rowCount() > 0) {
        $profile = $customerProfile->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "No customer data found.";
        exit;
    }
} else {
    header("Location: signin.php"); // Redirect to login if session doesn't exist
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!-- <title>WrenchKing</title> -->
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Account Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
    <style>
        .hover-effect:hover {
            background-color: #d32f2f;
            color: white !important;
        }

        .spinner {
            width: 20px;
            height: 20px;
            border: 3px solid #ccc;
            border-top-color: #333;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>

    <!-- Header -->
    <?php
    include './includes/header.php';
    ?>
    <!-- Header end -->
    <br>
    <div class="container mt-4">

        <h4 class="text-center">Update Your Personal Details</h4>
        <form method="POST" action="./controllers/process_update_profile.php">
            <div class="row mb-3">
                <!-- Name -->
                <div class="col-md-6">
                    <label class="m-0" for="c_name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="c_name" name="c_name"
                        value="<?php echo htmlspecialchars($profile['c_name']); ?>" required>
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <label class="m-0" for="c_email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="c_email" name="c_email"
                        value="<?php echo htmlspecialchars($profile['c_email']); ?>" required>
                </div>

                <!-- Phone -->
                <div class="col-md-6 mt-2">
                    <label class="m-1" for="c_phone" class="form-label">Phone</label>
                    <input type="tel" class="form-control" id="c_phone" name="c_phone"
                        value="<?php echo htmlspecialchars($profile['c_phone']); ?>" required pattern="[0-9]{10}"
                        maxlength="10">
                </div>

                <!-- Address -->
                <div class="col-md-6 mt-2">
                    <label class="m-1" for="c_address" class="form-label">Address</label>
                    <textarea class="form-control" id="c_address" name="c_address" rows="3"
                        required><?php echo htmlspecialchars($profile['c_address']); ?></textarea>
                </div>


            </div>


            <!-- Submit -->
            <div class="text-end">
                <button type="reset" class="btn btn-secondary">Reset</button>
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </div>
        </form>

        <hr>
    </div>


    <!-- Footer Start -->
    <?php
    include './includes/footer.php';
    ?>
    <!-- Footer End -->

    <!-- JavaScript Libraries -->>
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

    <!-- Add SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Spinner Trigger on Form Submit -->
    <script>
        document.querySelector("form").addEventListener("submit", function () {
            Swal.fire({
                html: '<div class="spinner"></div>',
                showConfirmButton: false,
                allowOutsideClick: false,
                width: 150,
                padding: '1em',
                background: '#fff',
                color: '#000',
                backdrop: true,
                position: 'center'
            });
        });
    </script>


</body>

</html>