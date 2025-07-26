<?php
include "../../config.php"; // ✅ Corrected the path

$admin = new Admin();

if (isset($_GET['id'])) {
    $cid = $_GET['id'];
    $admin->cud("DELETE FROM `customer` WHERE `c_id` = '$cid'", "deleted");
    echo "<script>alert('Customer removed successfully'); window.location='../view-customers.php';</script>";
} else {
    echo "<script>alert('Invalid request'); window.location='../view-customers.php';</script>";
}
?>