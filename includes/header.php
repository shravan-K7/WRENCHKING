<style>
    .train-container {
        position: relative;
        overflow: hidden;
        height: 50px;
        background-color: #f8f9fa;
        /* Light bg for visibility (optional) */
        display: flex;
        align-items: center;
        /* vertically center content */
    }

    .train-animation {
        display: inline-flex;
        align-items: center;
        white-space: nowrap;
        animation: slideTrain 40s linear infinite;
    }

    @keyframes slideTrain {
        0% {
            transform: translateX(100%);
        }

        100% {
            transform: translateX(-100%);
        }
    }
</style>



<!-- Topbar Start -->
<?php
include_once __DIR__ . '/../config.php';

$query = "SELECT sp_name, sp_phone, sp_address, sp_email FROM s_provider";
$result = mysqli_query($conn, $query);
?>

<div class="container-fluid p-0 bg-light">
    <div class="row gx-0 d-none d-lg-flex">
        <div class="col-lg-12">
            <div class="train-container">
                <div class="train-animation">
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="me-5 d-inline-flex align-items-center">';
                            echo '<small class="fa fa-tools text-primary me-2"></small>';
                            echo '<small><strong>' . $row['sp_name'] . '</strong> | ';
                            echo '📞 ' . $row['sp_phone'] . ' | ';
                            echo '📍 ' . $row['sp_address'] . ' | ';
                            echo '📧 ' . $row['sp_email'] . '</small>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="me-5 d-inline-flex align-items-center">';
                        echo '<small>No Service Providers Found</small>';
                        echo '</div>';
                    }
                    ?>
                    <span>Opening Hours Monday - Saturday: 09.00 AM - 08.00 PM</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Topbar End -->

<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="index.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <img style="width: 260px; height: auto;" src="img/logo.png">
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="index.php" class="nav-item nav-link">Home</a>
            <a href="about.php" class="nav-item nav-link">About</a>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Services</a>
                <div class="dropdown-menu fade-up m-0">
                    <a href="carservice.php" class="dropdown-item">Car Services</a>
                    <!-- <a href="booking.php" class="dropdown-item">Booking</a> -->
                    <a href="emergencyservice.php" class="dropdown-item">Emergency Services</a>
                </div>
            </div>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Extras</a>
                <div class="dropdown-menu fade-up m-0">
                    <!-- <a href="team.php" class="dropdown-item">Technicians</a> -->
                    <a href="testimonial.php" class="dropdown-item">Testimonial</a>
                    <a href="spares.php" class="dropdown-item">Products</a>
                    <a href="insurance.php" class="dropdown-item">Renew Insurance</a>
                </div>
            </div>
            <a href="contact.php" class="nav-item nav-link">Contact</a>
            <a href="cart.php" class="nav-item nav-link fs-5 mt-n1">
                <i class="bi bi-cart3"></i>
            </a>

        </div>
        <?php
        if (isset($_SESSION['c_id'])) { ?>

            <a href="profile.php" class="btn py-4 px-4 d-flex justify-content-center align-items-center">
                <i class="bi bi-person-circle fs-3" style="color: #000;"></i>

            </a>
            <a onclick="return confirm('Are you sure, want to logout?')" href="./controllers/auth.php?action=logout"
                class="btn btn-primary py-4  d-none d-lg-inline-block">Logout</a>
        <?php } else { ?>
            <a href="signin.php" class="btn btn-primary py-4 d-none d-lg-inline-block">
                Sign In/Sign Up <i class="fa fa-arrow-right ms-3"></i>
            </a>
        <?php } ?>
    </div>
</nav>
<!-- Navbar End -->