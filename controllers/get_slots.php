<?php
require '../config.php'; // or your database connection file

if (isset($_POST['date'], $_POST['s_id'])) {
    $date = $_POST['date'];
    $s_id = $_POST['s_id'];

    // Get the service provider ID for the selected service
    $spQuery = $admin->ret("SELECT sp_id FROM services WHERE s_id = '$s_id'");
    $spData = $spQuery->fetch(PDO::FETCH_ASSOC);

    if ($spData) {
        $sp_id = $spData['sp_id'];

        // Count bookings for this SP on the selected date
        $bookingQuery = $admin->ret("SELECT COUNT(*) as total FROM service_booking 
            WHERE sb_booked_date = '$date' AND s_id IN 
            (SELECT s_id FROM services WHERE sp_id = '$sp_id')");

        $booking = $bookingQuery->fetch(PDO::FETCH_ASSOC);
        $count = $booking['total'];
        $available = 5 - $count;

        if ($available <= 0) {
            echo '<div class="alert alert-danger mb-0">⚠️ No slots available for this date. Please choose another date.</div>';
        } else {
            echo '<div class="alert alert-info mb-0">Available slots: <strong>' . $available . '</strong></div>';
        }
    } else {
        echo '<div class="alert alert-warning mb-0">Service not found!</div>';
    }
} else {
    echo '<div class="alert alert-warning mb-0">Invalid request.</div>';
}
?>