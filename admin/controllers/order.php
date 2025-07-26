<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include '../../config.php';
require '../../PHPMailer/PHPMailer.php';
require '../../PHPMailer/SMTP.php';
require '../../PHPMailer/Exception.php';

$admin = new Admin();

if (isset($_GET["or_id"])) {
    $orid = $_GET['or_id'];
    $or_status = $_GET['or_status'];

    $orderData = $admin->ret("SELECT * FROM `order` WHERE `or_id`='$orid'");
    $row = $orderData->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo "<script>alert('Order details not found.');window.location='../view-orders.php';</script>";
        exit();
    }

    $or_name = $row['or_name'];
    $or_city = $row['or_city'];
    $or_address = $row['or_address'];
    $customer_email = $row['or_email'];
    $dateTime = date('Y-m-d H:i:s'); // current datetime

    // Initialize email variables
    $sendMail = false;
    $subject = "";
    $message = "";

    // Fetch product names and quantities for this order
    $productList = '';
    $product_q = $admin->ret("
        SELECT p.p_name, op.op_quantity 
        FROM ordered_products op 
        JOIN product p ON op.p_id = p.p_id 
        WHERE op.or_id = '$orid'
    ");
    while ($row = $product_q->fetch(PDO::FETCH_ASSOC)) {
        $productList .= "<li>{$row['p_name']} (Qty: {$row['op_quantity']})</li>";
    }

    if (isset($_GET['py_status']) && $_GET['py_status'] == "Verified") {
        $py_status = $_GET['py_status'];

        // Update payment status
        $admin->cud("UPDATE `order` SET `or_status`='$or_status', `or_payment_status`='$py_status' WHERE `or_id`='$orid'", "saved");

        // Prepare email for payment verified
        $sendMail = true;
        $subject = "Ordered Successfully";
        $message = "
            Hello $or_name,<br><br>
            Your order has been <strong>successfully placed</strong> and is now being processed.<br><br>
            <strong>Order Details:</strong><br> 
            <ul>
                <li><strong>Order ID:</strong> {$orid}</li>
                <li><strong>Name:</strong> {$or_name}</li>
                <li><strong>City:</strong> {$or_city}</li>
                <li><strong>Address:</strong> {$or_address}</li>
                <li><strong>Accepted On:</strong> {$dateTime}</li>
            </ul>
            <strong>Products:</strong><br>
            <ul>
                $productList
            </ul>
            <br>
            Thank you for choosing WrenchKing.<br><br>
            Regards,<br>
            WrenchKing Team
        ";
    } elseif ($or_status == "Dispatched") {
        // Update order status
        $admin->cud("UPDATE `order` SET `or_status`='$or_status' WHERE `or_id`='$orid'", "saved");

        // Prepare email for dispatch
        $sendMail = true;
        $subject = "Order Dispatched - Order ID: " . $orid;
        $message = "
            Hello $or_name,<br><br>
            We are happy to inform you that your order has been <strong>dispatched</strong>.<br><br>
            <strong>Order Details:</strong><br>
            <ul>
                <li><strong>Order ID:</strong> {$orid}</li>
                <li><strong>Name:</strong> {$or_name}</li>
                <li><strong>City:</strong> {$or_city}</li>
                <li><strong>Address:</strong> {$or_address}</li>
                <li><strong>Dispatched On:</strong> {$dateTime}</li>
            </ul>
            <strong>Products:</strong><br>
            <ul>
                $productList
            </ul>
            <br>
            Please keep an eye on your delivery.<br><br>
            Regards,<br>
            WrenchKing Team
        ";
    }

    // Send the email if applicable
    if ($sendMail) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'knoxshraone@gmail.com';  // replace with your email
            $mail->Password = 'sqgi spxk yiot nlrc';   // replace with your password or app-specific password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('knoxshraone@gmail.com', 'WrenchKing');
            $mail->addAddress($customer_email, $or_name);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;

            if (!$mail->send()) {
                error_log("Order Email Error: " . $mail->ErrorInfo);
            }
        } catch (Exception $e) {
            error_log("PHPMailer Exception: " . $e->getMessage());
        }
    }

    echo "<script>alert('Order updated successfully.');window.location='../view-orders.php';</script>";
}
?>