<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item profile">
            <div class="profile-desc">
                <div class="profile-pic">
                    <!-- <div class="count-indicator">
                        <img class="img-xs rounded-circle " src="assets/images/faces/face15.jpg" alt="">
                        <span class="count bg-success"></span>
                    </div> -->
                    <div class="profile-name">
                        <h5 class="mb-0 font-weight-normal"><?php echo $profile['sp_name']; ?></h5>
                        <span>Admin</span>
                    </div>
                </div>
            </div>
        </li>
        <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="index.php">
                <span class="menu-icon">
                    <i class="mdi mdi-view-dashboard" style="color: #6f03fc"></i>
                </span>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="./view-customers.php">
                <span class="menu-icon">
                    <i class="mdi mdi-contacts" style="color: #ff7700;"></i>
                </span>
                <span class="menu-title">Customers</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link d-flex align-items-center" href="./view-spare-parts.php">
                <span class="menu-icon d-flex justify-content-center align-items-center">
                    <i class="mdi mdi-settings" style="color: #0356fc;"></i>
                </span>
                <span class="menu-title ms-2">Products</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="./view-services.php">
                <span class="menu-icon">
                    <i class="mdi mdi-car" style="color: #00ff44;"></i>
                </span>
                <span class="menu-title">Services</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="./view-emergency-services.php">
                <span class="menu-icon">
                    <i class="mdi mdi-alert" style="color: #ff0000;"></i>
                </span>
                <span class="menu-title">Emergency Services</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="./view-service-bookings.php">
                <span class="menu-icon">
                    <i class="bi bi-tools" style="color:rgb(255, 230, 0);"></i>
                </span>
                <span class="menu-title">Service Bookings</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="./view-emergency-bookings.php">
                <span class="menu-icon">
                    <i class="bi bi-exclamation-circle" style="color:rgb(255, 0, 0);"></i>
                </span>
                <span class="menu-title">Emergency Bookings</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="./view-orders.php">
                <span class="menu-icon">
                    <i class="bi bi-box-seam" style="color:rgb(255, 0, 162);"></i>
                </span>
                <span class="menu-title">Orders</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="./all-payments.php">
                <span class="menu-icon">
                    <i class="bi bi-currency-rupee" style="color:rgb(167, 244, 0);"></i>
                </span>
                <span class="menu-title">Payments</span>
            </a>
        </li>

        <li class="nav-item menu-items">
            <a class="nav-link" href="./view-workers.php">
                <span class="menu-icon">
                    <i class="bi bi-person-vcard"></i>
                </span>
                <span class="menu-title">Workers</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="./reviews.php">
                <span class="menu-icon">
                    <i class="bi bi-chat-left-dots-fill"></i>
                </span>
                <span class="menu-title">Reviews</span>
            </a>
        </li>
    </ul>
</nav>

<!-- Add this in the <head> section -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">