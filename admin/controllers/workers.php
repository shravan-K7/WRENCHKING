<?php
include '../../config.php';
$admin = new Admin();

//INSERT PRODUCT
if (isset($_POST["insert"])) {
    $sp_id = $_SESSION['sp_id'];
    $name = $_POST["name"];
    $phone = $_POST["Phone"];
    $check = $admin->ret("SELECT * FROM `workers` WHERE `w_phone`='$phone'");
    $count = $check->rowCount();
    if ($count > 0) {
        echo "<script>alert('Worker already exists!');window.location='../insert-worker.php';</script>";
    } else {
        $insert = $admin->cud("INSERT INTO `workers`(`sp_id`, `w_name`, `w_phone`) 
        VALUES ('$sp_id','$name','$phone')", "inserted");
        echo "<script>alert('New worker added succesfully');window.location='../view-workers.php';</script>";
    }
}
?>