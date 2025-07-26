<?php
include '../../config.php';
$admin = new Admin();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eb_id = $_POST['eb_id'];
    $assigned_worker_id = $_POST['assigned_worker_id'];
    $eb_status = $_POST['eb_status'];
    $eb_notes = $_POST['eb_notes'];
    $updated_date = date("Y-m-d H:i:s");

    // Get current assigned_worker_id before updating
    $existing = $admin->ret("SELECT assigned_worker_id, eb_status FROM e_booking WHERE eb_id = '$eb_id'");
    $existingData = $existing->fetch(PDO::FETCH_ASSOC);
    $previous_worker_id = $existingData['assigned_worker_id'];
    $previous_status = $existingData['eb_status'];

    // Update e_booking record
    $update = $admin->cud("UPDATE e_booking SET assigned_worker_id = '$assigned_worker_id', eb_status = '$eb_status', eb_feedback = '$eb_notes', eb_updated_date = '$updated_date' WHERE eb_id = '$eb_id'", "updated");

    // Set old worker as available if changed or status completed/cancelled
    if ($previous_worker_id && ($previous_worker_id != $assigned_worker_id || $eb_status == "Completed" || $eb_status == "Cancelled")) {
        $admin->cud("UPDATE workers SET w_status = 'available' WHERE w_id = '$previous_worker_id'", "updated");
    }

    // Set new worker as assigned if status is not completed/cancelled
    if (!empty($assigned_worker_id) && $eb_status != "Completed" && $eb_status != "Cancelled") {
        $admin->cud("UPDATE workers SET w_status = 'assigned' WHERE w_id = '$assigned_worker_id'", "updated");
    }

    echo "<script>alert('Emergency booking updated successfully.'); window.location.href='../view-emergency-bookings.php';</script>";
} else {
    echo "<script>alert('Invalid request'); window.location.href='../view-emergency-bookings.php';</script>";
}
?>