<?php
include '../../config.php';

$admin = new Admin();

// DELETE Worker via GET
if (isset($_GET["delete"]) && $_GET["delete"] == "1") {
    if (!isset($_GET["w_id"]) || empty($_GET["w_id"])) {
        die("❌ Error: Worker ID is missing for deletion.");
    }

    $wid = $_GET["w_id"];

    // Delete query
    $deleteQuery = "DELETE FROM `workers` WHERE `w_id` = '$wid'";
    $result = $admin->cud($deleteQuery, "deleted");

    if ($result) {
        echo "<script>alert('🗑️ Worker deleted successfully!'); window.location.href='../view-workers.php';</script>";
    } else {
        echo "❌ Error: Failed to delete worker.";
    }
    exit;
}

// UPDATE Worker via POST
if (isset($_POST["update"])) {
    if (!isset($_POST["w_id"]) || empty($_POST["w_id"])) {
        die("❌ Error: Worker ID is missing.");
    }

    $wid = $_POST["w_id"];
    $name = $_POST["name"];
    $phone = $_POST["phone"];

    // Validate phone format (10 digits)
    if (!preg_match('/^\d{10}$/', $phone)) {
        die("❌ Error: Phone number must be exactly 10 digits.");
    }

    // Update query
    $updateQuery = "UPDATE `workers` SET `w_name` = '$name', `w_phone` = '$phone' WHERE `w_id` = '$wid'";
    $result = $admin->cud($updateQuery, "updated");

    if ($result) {
        echo "<script>alert('✅ Worker updated successfully!'); window.location.href='../view-workers.php';</script>";
    } else {
        echo "❌ Error: Update failed.";
    }
    exit;
}

echo "❌ Error: No valid action detected.";
exit;