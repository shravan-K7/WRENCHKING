<?php
include '../config.php'; // Make sure the config file is included
require '../vendor/autoload.php'; // DomPDF
use Dompdf\Dompdf;
use Dompdf\Options;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$admin = new Admin();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = $_POST['booking_id'];
    $customer_email = $_POST['customer_email'];
    $price = $_POST['price'];

    $extra_descriptions = $_POST['extra_desc'] ?? [];
    $extra_amounts = $_POST['extra_amount'] ?? [];

    // Start with the base price
    $total_amount = $price;

    // Add extra charges to the total amount if available
    foreach ($extra_amounts as $amt) {
        $total_amount += $amt;
    }

    // Fetch Booking Details
    $booking = $admin->ret("
        SELECT sb.sb_id, c.c_name, sb.car_brand, sb.car_model, s.s_title, sb.sb_time, sb.sb_booked_date, sb.vehicle_number, s.s_price
        FROM service_booking sb
        JOIN customer c ON sb.c_id = c.c_id
        JOIN services s ON sb.s_id = s.s_id
        WHERE sb.sb_id = '$booking_id'
    ");
    $row = $booking->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        die("Invalid Booking ID.");
    }

    $current_date = date("d-m-Y");

    // Start building invoice HTML
    $html = "
    <meta charset='UTF-8'>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .heading { font-size: 24px; font-weight: bold; color: red; text-align: center; }
        .section { margin-bottom: 10px; }
        .right { text-align: right; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 5px; text-align: left; }
    </style>

    <h1 class='heading'>WrenchKing</h1>
    <hr>
    <h3 style='text-align:center;'>Invoice</h3>
    <p class='right'><strong>Date:</strong> {$current_date}</p>
    <div class='section'><strong>Customer Name:</strong> {$row['c_name']}</div>
    <div class='section'><strong>Service:</strong> {$row['s_title']}</div>
    <div class='section'><strong>Vehicle:</strong> {$row['car_brand']} - {$row['car_model']} - {$row['vehicle_number']}</div>
    <div class='section'><strong>Base Service Amount:</strong> ₹{$price}</div>
    ";

    // Add extra charges if available
    if (!empty($extra_descriptions)) {
        $html .= "
        <h4>Additional Charges:</h4>
        <table>
            <tr>
                <th>Description</th>
                <th>Amount (₹)</th>
            </tr>";
        foreach ($extra_descriptions as $index => $desc) {
            $desc = htmlspecialchars($desc);
            $amt = htmlspecialchars($extra_amounts[$index] ?? 0);
            $html .= "
            <tr>
                <td>{$desc}</td>
                <td class='right'>₹{$amt}</td>
            </tr>";
        }
        $html .= "</table>";
    }

    $html .= "
    <p class='right' style='font-size:16px; font-weight:bold; margin-top: 15px;'>Total: ₹{$total_amount}</p>
    <hr>";

    // Generate PDF
    $options = new Options();
    $options->set('defaultFont', 'DejaVu Sans');
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Save to file
    $invoicePath = __DIR__ . "/invoices/invoice_$booking_id.pdf";
    if (file_put_contents($invoicePath, $dompdf->output())) {
        // Save invoice path to DB
        $admin->cud("UPDATE service_booking SET invoice = '$invoicePath', total_amount = '$total_amount' WHERE sb_id = '$booking_id'", "Updated");
    } else {
        die("Failed to save invoice.");
    }

    // Send Email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'knoxshraone@gmail.com';
        $mail->Password = 'sqgi spxk yiot nlrc';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('knoxshraone@gmail.com', 'WrenchKing Garage');
        $mail->addAddress($customer_email);
        $mail->Subject = "Your Service Invoice - WrenchKing";
        $mail->Body = "Dear {$row['c_name']},\n\nPlease find attached your invoice for the recent service.\nTotal Amount: ₹{$total_amount}\n\nThank you for choosing WrenchKing!";
        $mail->addAttachment($invoicePath);

        $mail->send();
        echo "<script>alert('Invoice Generated & Sent Successfully'); window.location='./view-service-bookings.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Invoice generated but email failed: {$mail->ErrorInfo}'); window.location='./view-service-bookings.php';</script>";
    }
} else {
    echo "<script>window.location='./view-service-bookings.php';</script>";
}
?>