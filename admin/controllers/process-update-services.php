<?php
include '../../config.php';

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$admin = new Admin();

// if (!isset($_POST["s_id"]) || empty($_POST["s_id"])) {
//     die("Error: Product ID is missing.");
// }

//UPDATE 
if (isset($_POST["update"])) {
    if (!isset($_POST["s_id"]) || empty($_POST["s_id"])) {
        die("Error: Product ID is missing.");
    }

    $sid = $_POST["s_id"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $description = $_POST["description"];

    // Debugging: Check values before updating
    //echo "Debug: s_id=$sid, name=$name, price=$price, description=$description<br>";

    if (!empty($_FILES['picture']['name'])) {
        $picture = "uploads/" . basename($_FILES['picture']['name']);
        move_uploaded_file($_FILES['picture']['tmp_name'], $picture);
        $updateQuery = "UPDATE `services` SET `s_title` = '$name', `s_image` = '$picture', `s_description` = '$description', `s_price` = '$price' WHERE `s_id` = '$sid'";
    } else {
        $updateQuery = "UPDATE `services` SET `s_title` = '$name', `s_description` = '$description', `s_price` = '$price' WHERE `s_id` = '$sid'";
    }

    // echo "Executing query: " . $updateQuery . "<br>";

    // Execute update query
    $result = $admin->cud($updateQuery, "updated");

    if ($result) {
        echo "<script>alert('Service updated successfully!'); window.location.href='../view-services.php';</script>";
    } else {
        echo "Error: Update query failed.";
    }
} else {
    echo "Error: Form was not submitted correctly.";
}
exit();