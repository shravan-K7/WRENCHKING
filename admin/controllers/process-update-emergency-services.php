<?php
include '../../config.php';

$admin = new Admin();

// Check if update form is submitted
if (isset($_POST["update"])) {
    if (!isset($_POST["es_id"]) || empty($_POST["es_id"])) {
        die("Error: Emergency Service ID is missing.");
    }

    $esid = $_POST["es_id"];
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];

    // Handle file upload if a new image is provided
    if (!empty($_FILES['picture']['name'])) {
        $picture = "uploads/" . basename($_FILES['picture']['name']);
        move_uploaded_file($_FILES['picture']['tmp_name'], $picture);
        $updateQuery = "UPDATE `emergency_services` SET `es_title` = '$name', `es_picture` = '$picture', `es_description` = '$description', `es_price` = '$price' WHERE `es_id` = '$esid'";
    } else {
        $updateQuery = "UPDATE `emergency_services` SET `es_title` = '$name', `es_description` = '$description', `es_price` = '$price' WHERE `es_id` = '$esid'";
    }

    // Execute update query
    session_write_close(); // Prevent session locking
    $result = $admin->cud($updateQuery, "updated");

    if ($result) {
        echo "<script>
                alert('Emergency service updated successfully!');
                window.location.href = '../view-emergency-services.php';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Error: Update failed.');
                window.location.href = '../update-emergency-service.php?es_id=$esid';
              </script>";
        exit();
    }
} else {
    echo "<script>
            alert('Error: Form was not submitted correctly.');
            window.location.href = '../view-emergency-services.php';
          </script>";
    exit();
}
?>