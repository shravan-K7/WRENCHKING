<?php
include "../../config.php";
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';
require '../PHPMailer/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;// Include PHPMailer

$admin = new Admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sb_id = $_POST['sb_id'];
    $sb_time = $_POST['sb_time'];
    $sb_response = $_POST['sb_notes'];
    $status = $_POST['sb_status'];
    $assigned_worker_id = $_POST['assigned_worker_id'];
    $exp_date = $_POST['exp_date'];

    // Get old assigned worker
    $old = $admin->ret("SELECT assigned_worker_id FROM service_booking WHERE sb_id = '$sb_id'");
    $old_worker = $old->fetch(PDO::FETCH_ASSOC)['assigned_worker_id'];

    // === Fetch details for email before update ===
    $details_q = $admin->ret("
        SELECT sb.*, c.c_name, c.c_email, s.s_title, w.w_name 
        FROM service_booking sb 
        JOIN customer c ON sb.c_id = c.c_id 
        JOIN services s ON sb.s_id = s.s_id 
        LEFT JOIN workers w ON sb.assigned_worker_id = w.w_id 
        WHERE sb.sb_id = '$sb_id'
    ");
    $details = $details_q->fetch(PDO::FETCH_ASSOC);

    $wasPending = $details['sb_status'] === 'Pending'; // for email check
    $customerEmail = $details['c_email'];
    $customerName = $details['c_name'];

    // Update booking details
    $admin->cud("
        UPDATE service_booking 
        SET sb_time = '$sb_time', 
            sb_status = '$status', 
            sb_response = '$sb_response',
            assigned_worker_id = '$assigned_worker_id',
            exp_date = '$exp_date'
        WHERE sb_id = '$sb_id'
    ", "updated");

    // Update worker status
    if (!empty($assigned_worker_id)) {
        $admin->cud("UPDATE workers SET w_status = 'assigned' WHERE w_id = '$assigned_worker_id'", "updated");
    }
    if ($status === 'Completed' && $assigned_worker_id === $old_worker) {
        $admin->cud("UPDATE workers SET w_status = 'available' WHERE w_id = '$assigned_worker_id'", "freed");
    }
    if (!empty($old_worker) && $old_worker !== $assigned_worker_id) {
        $admin->cud("UPDATE workers SET w_status = 'available' WHERE w_id = '$old_worker'", "freed old");
    }

    // Refetch updated worker name if worker was assigned
    $workerName = "Not Assigned";
    if (!empty($assigned_worker_id)) {
        $worker_q = $admin->ret("SELECT w_name FROM workers WHERE w_id = '$assigned_worker_id'");
        $worker = $worker_q->fetch(PDO::FETCH_ASSOC);
        if ($worker) {
            $workerName = $worker['w_name'];
        }
    }

    // === Send email if status changed to Approved ===
    if ($status === 'Approved' && $wasPending) {
        $subject = "Your Service Has Been Approved";
        $message = "
    Hello $customerName,<br><br>
    Your service booking has been <strong>approved</strong>!<br><br>
    <strong>Details:</strong><br>
    Service Booking ID: {$details['sb_id']}<br>
    Vehicle: " . strtoupper($details['car_brand']) . " - " . strtoupper($details['car_model']) . " (" . strtoupper($details['vehicle_number']) . ")<br>
    Service Type: {$details['s_title']}<br>
    Booking Date: {$details['sb_booked_date']}<br>
    Allotted Time: $sb_time<br>
    Assigned Worker: $workerName<br>
    Expected Return: $exp_date<br><br>
    For further information, please visit <a href='http://localhost/wrenchking'>WrenchKing</a>.<br><br>
    Regards,<br>
    WrenchKing Team
";

        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // replace with your host
        $mail->SMTPAuth = true;
        $mail->Username = 'knoxshraone@gmail.com'; // replace with your email
        $mail->Password = 'sqgi spxk yiot nlrc';     // replace with your password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('knoxshraone@gmail.com', 'WrenchKing');
        $mail->addAddress($customerEmail, $customerName);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        if (!$mail->send()) {
            error_log("Mail Error: " . $mail->ErrorInfo);
        }
    }

    // === Send email if status changed to Completed ===
    if ($status === 'Completed') {
        $subject = "Your Service Has Been Completed";
        $message = "
            Hello $customerName,<br><br>
            We're pleased to inform you that your vehicle service has been <strong>successfully completed</strong>.<br><br>
            <strong>Details:</strong><br>
            Service Booking ID: {$details['sb_id']}<br>
            Vehicle: " . strtoupper($details['car_brand']) . " - " . strtoupper($details['car_model']) . " (" . strtoupper($details['vehicle_number']) . ")<br>
            Service Type: {$details['s_title']}<br>
            Booking Date: {$details['sb_booked_date']}<br>

            You can also pay via your WrenchKing profile dashboard or offline.<br><br>
            An invoice for the service will be sent to you shortly.<br><br>
            You may now collect your vehicle. For any queries or support, feel free to reach out.<br><br>
            For further information, please visit <a href='http://localhost/wrenchking'>WrenchKing</a>.<br><br>
            Regards,<br>
            WrenchKing Team
        ";

        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'knoxshraone@gmail.com';
        $mail->Password = 'sqgi spxk yiot nlrc';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('knoxshraone@gmail.com', 'WrenchKing');
        $mail->addAddress($customerEmail, $customerName);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        if (!$mail->send()) {
            error_log("Completion Mail Error: " . $mail->ErrorInfo);
        }
    }

    // === Send email if status changed to Cancelled ===
    if ($status === 'Cancelled') {
        $subject = "Your Service Has Been Cancelled";
        $message = "
        Hello $customerName,<br><br>
        We regret to inform you that your vehicle service has been <strong>cancelled</strong>.<br><br>
        <strong>Details:</strong><br>
        Service Booking ID: {$details['sb_id']}<br>
        Vehicle: " . strtoupper($details['car_brand']) . " - " . strtoupper($details['car_model']) . " (" . strtoupper($details['vehicle_number']) . ")<br>
        Service Type: {$details['s_title']}<br>
        Booking Date: {$details['sb_booked_date']}<br><br>
        If this was unexpected or if you have any questions, please contact us immediately.<br><br>
        For more details, visit <a href='http://localhost/wrenchking'>WrenchKing</a>.<br><br>
        Regards,<br>
        WrenchKing Team
    ";

        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'knoxshraone@gmail.com';
        $mail->Password = 'sqgi spxk yiot nlrc';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('knoxshraone@gmail.com', 'WrenchKing');
        $mail->addAddress($customerEmail, $customerName);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        if (!$mail->send()) {
            error_log("Cancellation Mail Error: " . $mail->ErrorInfo);
        }
    }


    echo "<script>alert('Booking updated successfully!'); window.location='../view-service-bookings.php';</script>";
}
?>