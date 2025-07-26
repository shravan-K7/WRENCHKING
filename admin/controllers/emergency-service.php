<?php
include '../../config.php';
$admin = new Admin();

//INSERT EMERGENCY SERVICE
if (isset($_POST["insert"])) {
    $sp_id = $_SESSION['sp_id'];
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $picture = "uploads/" . basename($_FILES['picture']['name']);
    move_uploaded_file($_FILES['picture']['tmp_name'], $picture);

    $check = $admin->ret("SELECT * FROM `emergency_services` WHERE `es_title`='$name'");
    $count = $check->rowCount();
    if ($count > 0) {
        echo "<script>alert('Emergency service already exists!');window.location='../insert-emergency-service.php';</script>";
    } else {
        $insert = $admin->cud("INSERT INTO `emergency_services`(`sp_id`, `es_title`, `es_picture`, `es_description`,`es_price`,`es_status`) 
        VALUES ('$sp_id','$name','$picture','$description','$price','Available')", "inserted");
        echo "<script>alert('Emergency service inserted successfully');window.location='../view-emergency-services.php';</script>";
    }
}
?>