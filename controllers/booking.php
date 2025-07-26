<?php
include '../config.php';
$admin = new Admin();
if (isset($_POST["book"])) {
    $cid = $_SESSION['c_id'];
    $brand = $_POST["brand"];
    $car = $_POST["car"];
    $regno = $_POST["vehicle_number"];
    $date = $_POST["date"];
    $message = $_POST["message"];
    $service = $_POST["service"];

    date_default_timezone_set('Asia/Kolkata'); // or your relevant timezone

    $currentDate = date('Y-m-d');
    // $currentDate = '2025-05-12';
    // Simulate current time as 8:30 PM (for testing)
    // $currentTime = '20:30'; //force to think time
    $currentTime = date('H:i');
    // current time in 24-hour format, e.g., "20:45"
    $cutoffTime = '20:00'; // 7:30 PM cutoff

    if ($date == $currentDate && $currentTime > $cutoffTime) {
        echo "<script>alert('Same-day bookings are not allowed after 7:30 PM. Please select another date.');window.location='../book-service.php?s_id=$service';</script>";
        exit;
    }


    // Step 1: Get the service provider (sp_id) for the selected service
    $getSp = $admin->ret("SELECT sp_id FROM services WHERE s_id = '$service'");
    $sp = $getSp->fetch(PDO::FETCH_ASSOC);
    $sp_id = $sp['sp_id'];

    // Step 2: Check how many bookings already exist for this sp_id on this date
    $limitCheck = $admin->ret("SELECT * FROM service_booking sb 
                                JOIN services s ON sb.s_id = s.s_id 
                                WHERE s.sp_id = '$sp_id' AND sb.sb_booked_date = '$date'");
    $count = $limitCheck->rowCount();

    if ($count >= 5) {
        echo "<script>alert('Booking limit reached for this branch on the selected date. Please choose another date.');window.location='../book-service.php?s_id=$service';</script>";
    } else {
        $checkVehicleNUmber = $admin->ret("SELECT * FROM service_booking 
                                           WHERE vehicle_number = '$regno' 
                                           AND (car_brand != '$brand' OR car_model != '$car')");
        $checkCount = $checkVehicleNUmber->rowCount();
        if ($checkCount > 0) {
            echo "<script>alert('Vehicle with peovided registered number already exists with different vehicle or model! please check your vehicle register number!');window.location='../book-service.php?s_id=$service';</script>";
        } else {
            $book = $admin->cud("INSERT INTO service_booking(`c_id`, `s_id`, `car_brand`, `car_model`, `vehicle_number`, `sb_booked_date`, `sb_message`, `sb_status`)
         VALUES ('$cid','$service','$brand','$car','$regno','$date','$message','Pending')", "booked");
            echo "<script>alert('Booking request has been sent to the service provider! Check status for updates.');window.location='../bookinghistory.php';</script>";
        }
    }
}

if (isset($_POST["e-book"])) {
    date_default_timezone_set('Asia/Kolkata');
    $currentHour = date("G");
    $currentDay = date("w");

    // Restrict Sundays and time before 9 AM or after 8 PM
    if ($currentDay == 0 || $currentHour < 9 || $currentHour >= 20) {
        echo "<script>
            alert('Emergency bookings are only allowed between 9:00 AM and 8:00 PM, Monday to Saturday.');
            window.location='../e-service-book.php?es_id={$_POST['es_id']}';
        </script>";
        exit;
    }

    $cid = $_SESSION['c_id'];
    $es_id = $_POST['es_id'];
    $brand = $_POST["brand"];
    $car = $_POST["car"];
    $regno = $_POST["vehicle_number"];
    $phone = $_POST["phone"];
    $location = $_POST["location"];
    $locationlink = $_POST["locationlink"];
    $message = $_POST["message"];

    // Check booking limit for the day
    $limitCheck = $admin->ret("SELECT * FROM `e_booking` WHERE `es_id`='$es_id' AND DATE(`eb_date`) = CURDATE()");
    $count = $limitCheck->rowCount();

    if ($count >= 5) {
        echo "<script>
            alert('Booking limit reached for this date. Please choose a different garage.');
            window.location='../e-service-book.php?es_id=$es_id';
        </script>";
    } else {
        // Vehicle number check for mismatch with brand/model
        $checkVehicleNumber = $admin->ret("SELECT * FROM e_booking 
                                           WHERE vehicle_number = '$regno' 
                                           AND (eb_car != '$brand' OR eb_model != '$car')");
        $checkCount = $checkVehicleNumber->rowCount();

        if ($checkCount > 0) {
            echo "<script>
                alert('This registration number is already linked to a different vehicle or model. Please check it.');
                window.location='../e-service-book.php?es_id=$es_id';
            </script>";
        } else {
            $book = $admin->cud("INSERT INTO `e_booking`(
                `es_id`, `c_id`, `c_phone`, `eb_location`, `eb_location_link`, `eb_message`, 
                `eb_status`, `eb_car`, `eb_model`, `vehicle_number`
            ) VALUES (
                '$es_id','$cid','$phone','$location','$locationlink','$message',
                'booked','$brand','$car','$regno'
            )", "booked");

            echo "<script>
                alert('Booking request has been sent to the service provider! Check status for updates.');
                window.location='../eb_history.php';
            </script>";
        }
    }
}

if (isset($_POST["order"])) {
    $cid = $_SESSION['c_id'];
    // $es_id = $_POST['es_id'];
    $name = $_POST["name"];
    if (isset($_POST["paymentId"])) {
        $paymentId = $_POST["paymentId"];
    }
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $alt_phone = $_POST["alt_phone"];
    $address = $_POST["address"];
    $pincode = $_POST["pincode"];
    $state = $_POST["state"];
    $city = $_POST["city"];
    $landmark = $_POST["landmark"];
    $tid = $_POST["tid"];
    $transactionId = $tid;
    $method = 'UPI';
    if (isset($_POST["paymentId"])) {
        if (empty($paymentId)) {
            $transactionId = $tid;
            $method = 'UPI';
        } else {
            $transactionId = $paymentId;
            $method = 'RazorPay';
        }
    }
    $order = $admin->Rcud("INSERT INTO `order`(`c_id`, `or_name`, `or_email`, `or_phone`, `or_city`, `or_pin`, `or_address`, `or_alternative_phone`, `or_state`, `or_landmark`, `or_status`, `or_payment_status`,`or_payment_method`, `or_transaction_id`) 
    VALUES ('$cid','$name',' $email',' $phone','   $city','$pincode',' $address',' $alt_phone','$state','  $landmark','Placed','Pending','$method','$transactionId')");
    $getCartProducts = $admin->ret("SELECT * FROM `cart` INNER JOIN `product` on product.p_id=cart.p_id WHERE `c_id`='$cid'");
    while ($product = $getCartProducts->fetch(PDO::FETCH_ASSOC)) {
        $pid = $product['p_id'];
        $price = $product['p_price'];
        $qty = $product['ct_qty'];
        $stock = $product['p_stock'];
        $updatedStock = $stock - $qty;
        $amount = $price * $qty + 10;
        $productInsert = $admin->cud("INSERT INTO `ordered_products`(`or_id`, `p_id`, `op_quantity`, `op_amount`) 
        VALUES ('$order','$pid','$qty','$amount')", "inserted");
        $productInsert = $admin->cud("UPDATE `product` SET`p_stock`='$updatedStock' WHERE `p_id`='$pid'", "inserted");
    }
    $delete = $admin->cud("DELETE FROM `cart` WHERE `c_id`='$cid'", "clear cart");
    echo "<script>alert('Order placed successfully! check the status for updates');window.location='../order_history.php';</script>";

}
?>