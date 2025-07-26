<?php
include '../../config.php';
$admin = new Admin();

//INSERT PRODUCT
if (isset($_POST["insert"])) {
    $sp_id = $_SESSION['sp_id'];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];
    $description = $_POST["description"];
    $picture = "uploads/" . basename($_FILES['picture']['name']);
    move_uploaded_file($_FILES['picture']['tmp_name'], $picture);

    $check = $admin->ret("SELECT * FROM `product` WHERE `p_name`='$name' AND `p_price`='$price'");
    $count = $check->rowCount();
    if ($count > 0) {
        echo "<script>alert('Product already exists!');window.location='../insert-spare-part.php';</script>";
    } else {
        $insert = $admin->cud("INSERT INTO `product`(`sp_id`,`p_name`, `p_image`, `p_description`, `p_price`,`p_stock`, `p_status`) 
        VALUES ('$sp_id','$name','$picture','$description','$price','$stock','Available')", "inserted");
        echo "<script>alert('Product inserted succesfully');window.location='../view-spare-parts.php';</script>";
    }
}
?>