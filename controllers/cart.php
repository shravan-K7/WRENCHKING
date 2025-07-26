<?php
include '../config.php';
$admin = new Admin();
if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $checkEmail = $admin->ret("SELECT * FROM `customer` WHERE `c_email`='$email' AND `c_password`='$password'");
    $count = $checkEmail->rowCount();
    if ($count > 0) {
        $profile = $checkEmail->fetch(PDO::FETCH_ASSOC);
        $cId = $profile["c_id"];
        $_SESSION['c_id'] = $cId;
        echo "<script>alert('Login successful');window.location='../index.php';</script>";
    } else {
        echo "<script>alert('Invalid credential');window.location='../signin.php';</script>";
    }

} else
    if (isset($_POST["register"])) {
        $name = $_POST["name"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $checkEmail = $admin->ret("SELECT * FROM `customer` WHERE `c_email`='$email'");
        $count = $checkEmail->rowCount();
        if ($count > 0) {
            echo "<script>alert('Email already exists!');window.location='../signup.php';</script>";
        } else {
            $register = $admin->cud("INSERT INTO `customer`(`c_name`, `c_email`, `c_password`, `c_phone`, `c_status`)
         VALUES ('$name','$email','$password','$phone','Active')", "register");
            echo "<script>alert('Registration successful!');window.location='../signin.php';</script>";
        }

    } else if (isset($_GET['action'])) {
        $action = $_GET['action'];
        if ($action == 'add') {
            $p_id = $_GET['p_id'];
            $cid = $_SESSION['c_id'];
            $checkCart = $admin->ret("SELECT * FROM `cart` INNER JOIN `product` on product.p_id=cart.p_id WHERE  `c_id`='$cid'");
            $cartCount = $checkCart->rowCount();
            if ($cartCount == 0) {
                $check = $admin->ret("SELECT * FROM `cart` WHERE `p_id`='$p_id' and  `c_id`='$cid'");
                $count = $check->rowCount();
                if ($count > 0) {
                    $cart = $check->fetch(PDO::FETCH_ASSOC);
                    $cartId = $cart["ct_id"];
                    $quantity = $cart["ct_qty"];
                    $updated = $quantity + 1;
                    $update = $admin->cud("UPDATE `cart` SET `ct_qty`='$updated' WHERE `ct_id`='$cartId'", "updated");
                    echo "<script>alert('Product quantity updated in cart!');window.location='../cart.php';</script>";
                } else {

                    $insert = $admin->cud("INSERT INTO `cart`(`p_id`, `c_id`, `ct_qty`) VALUES ('$p_id','$cid','1')", "inserted");
                    echo "<script>alert('Product added to cart!');window.location='../cart.php';</script>";
                }
            } else {
                $cartProduct = $checkCart->fetch(PDO::FETCH_ASSOC);
                $serviceProvider = $cartProduct['sp_id'];
                $productData = $admin->ret("SELECT * FROM `product` WHERE `p_id`='$p_id'");
                $productInfo = $productData->fetch(PDO::FETCH_ASSOC);
                $productServiceProvider = $productInfo['sp_id'];
                if ($serviceProvider == $productServiceProvider) {
                    $check = $admin->ret("SELECT * FROM `cart` WHERE `p_id`='$p_id' and  `c_id`='$cid'");
                    $count = $check->rowCount();
                    if ($count > 0) {
                        $cart = $check->fetch(PDO::FETCH_ASSOC);
                        $cartId = $cart["ct_id"];
                        $quantity = $cart["ct_qty"];
                        $updated = $quantity + 1;
                        $update = $admin->cud("UPDATE `cart` SET `ct_qty`='$updated' WHERE `ct_id`='$cartId'", "updated");
                        echo "<script>alert('Product quantity updated in cart!');window.location='../cart.php';</script>";
                    } else {

                        $insert = $admin->cud("INSERT INTO `cart`(`p_id`, `c_id`, `ct_qty`) VALUES ('$p_id','$cid','1')", "inserted");
                        echo "<script>alert('Product added to cart!');window.location='../cart.php';</script>";
                    }
                } else {
                    echo "<script>alert('The Product which you have selected posted by different service provider! please empty your cart to add this product into the cart!!');window.location='../cart.php';</script>";

                }
            }

        } else if ($action == "Decrement") {
            $ctId = $_GET['ct_id'];
            $check = $admin->ret("SELECT * FROM `cart` WHERE `ct_id`='$ctId'");
            $cart = $check->fetch(PDO::FETCH_ASSOC);
            $quantity = $cart["ct_qty"];
            $updated = $quantity - 1;
            $update = $admin->cud("UPDATE `cart` SET `ct_qty`='$updated' WHERE `ct_id`='$ctId'", "updated");
            header("Location: ../cart.php"); // Redirect without alert
            exit;
        } else if ($action == "Increment") {
            $ctId = $_GET['ct_id'];

            // Get cart item
            $check = $admin->ret("SELECT * FROM `cart` WHERE `ct_id`='$ctId'");
            $cart = $check->fetch(PDO::FETCH_ASSOC);
            $quantity = $cart["ct_qty"];
            $productId = $cart["p_id"]; // Make sure `product_id` exists in your `cart` table

            // Get available stock for the product
            $stockCheck = $admin->ret("SELECT `p_stock` FROM `product` WHERE `p_id`='$productId'");
            $product = $stockCheck->fetch(PDO::FETCH_ASSOC);
            $stockAvailable = $product["p_stock"];

            if ($quantity < $stockAvailable) {
                $updated = $quantity + 1;
                $update = $admin->cud("UPDATE `cart` SET `ct_qty`='$updated' WHERE `ct_id`='$ctId'", "updated");
                header("Location: ../cart.php");
                exit;
            } else {
                echo "<script>alert('Cannot add more than available stock!'); window.location.href='../cart.php';</script>";
                exit;
            }
        } else if ($action == "Delete") {
            $ctId = $_GET['ct_id'];
            $update = $admin->cud("DELETE FROM `cart` WHERE `ct_id`='$ctId'", "updated");
            echo "<script>alert('Product removed from the cart!');window.location='../cart.php';</script>";
            # code...
        }
    } else {
        echo "<script>window.location='../index.php';</script>";

    }

?>