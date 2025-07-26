<?php
include '../../config.php';

$admin = new Admin();

if (isset($_POST["update"])) {
    if (!isset($_POST["p_id"]) || empty($_POST["p_id"])) {
        die("Error: Product ID is missing.");
    }

    $pid = $_POST["p_id"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    $stock = $_POST["stock"]; // New stock input

    // Debugging: Check values before updating
    // echo "Debug: p_id=$pid, name=$name, price=$price, description=$description, stock=$stock<br>";

    if (!empty($_FILES['picture']['name'])) {
        $picture = "uploads/" . basename($_FILES['picture']['name']);
        move_uploaded_file($_FILES['picture']['tmp_name'], $picture);
        $updateQuery = "UPDATE `product` SET `p_name` = '$name', `p_image` = '$picture', `p_description` = '$description', `p_price` = '$price', `p_stock` = '$stock' WHERE `p_id` = '$pid'";
    } else {
        $updateQuery = "UPDATE `product` SET `p_name` = '$name', `p_description` = '$description', `p_price` = '$price', `p_stock` = '$stock' WHERE `p_id` = '$pid'";
    }

    // echo "Executing query: " . $updateQuery . "<br>";

    // Execute update query
    $result = $admin->cud($updateQuery, "updated");

    if ($result) {
        echo "<script>alert('Product updated successfully!'); window.location.href='../view-spare-parts.php';</script>";
    } else {
        echo "Error: Update query failed.";
    }
} else {
    echo "Error: Form was not submitted correctly.";
}
exit();