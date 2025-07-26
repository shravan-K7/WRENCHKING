<?php
include '../../config.php';
$admin = new Admin();

//INSERT SERVICE
if (isset($_POST["insert"])) {
    $sp_id = $_SESSION['sp_id'];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    $picture = "uploads/" . basename($_FILES['picture']['name']);
    move_uploaded_file($_FILES['picture']['tmp_name'], $picture);
    $check = $admin->ret("SELECT * FROM `services` WHERE `s_description`='$description' AND `s_price`='$price'");
    $count = $check->rowCount();
    if ($count > 0) {
        echo "<script>alert('Service already exists!');window.location='../insert-service.php';</script>";
    } else {
        $insert = $admin->cud("INSERT INTO `services`(`sp_id`,`s_title`, `s_image`, `s_price`, `s_description`, `s_status`) 
        VALUES ('$sp_id','$name','$picture','$price','$description','Available')", "inserted");
        echo "<script>alert('Service inserted succesfully');window.location='../view-services.php';</script>";
    }
}
?>