<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!-- Sidebar -->
<nav class="col-md-3 col-lg-2 profile-sidebar bg-light p-3 mb-4 mb-md-0 rounded-3 shadow-sm">
    <h5 class="text-start mb-3 d-none d-md-block text-secondary text-uppercase fw-bold" style="font-size: 0.85rem; letter-spacing: 1px;">Dashboard</h5>
    <div class="nav nav-pills flex-row flex-md-column flex-nowrap flex-md-wrap overflow-auto pb-2 pb-md-0 gap-1 gap-md-2 dashboard-nav">
        <a href="profile.php" class="nav-link text-nowrap <?php echo ($currentPage == 'profile.php' || $currentPage == 'update_profile.php') ? 'active bg-danger text-white' : 'text-dark'; ?>">
            <i class="bi bi-person me-1 me-md-2"></i> Account
        </a>
        <a href="bookinghistory.php" class="nav-link text-nowrap <?php echo ($currentPage == 'bookinghistory.php' || $currentPage == 'pay-service.php') ? 'active bg-danger text-white' : 'text-dark'; ?>">
            <i class="bi bi-tools me-1 me-md-2"></i> Car Service
        </a>
        <a href="eb_history.php" class="nav-link text-nowrap <?php echo ($currentPage == 'eb_history.php') ? 'active bg-danger text-white' : 'text-dark'; ?>">
            <i class="bi bi-exclamation-triangle me-1 me-md-2"></i> Emergency
        </a>
        <a href="order_history.php" class="nav-link text-nowrap <?php echo ($currentPage == 'order_history.php') ? 'active bg-danger text-white' : 'text-dark'; ?>">
            <i class="bi bi-bag-check me-1 me-md-2"></i> Orders
        </a>
    </div>
</nav>