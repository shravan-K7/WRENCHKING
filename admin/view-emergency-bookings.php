<?php
include "../config.php";
$admin = new Admin();

if (!isset($_SESSION['sp_id'])) {
    echo "<script>window.location='./login.php';</script>";
    exit;
}

$aid = $_SESSION['sp_id'];
$adminProfile = $admin->ret("SELECT * FROM `s_provider` WHERE `sp_id`='$aid'");
$profile = $adminProfile->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax_verify_payment'])) {
    $eb_id = $_POST['eb_id'];

    // Use the Admin class's CUD method instead of prepare/execute
    $result = $admin->cud("UPDATE e_booking SET eb_payment_status = 'Verified' WHERE eb_id = '$eb_id'", "update");

    echo $result ? 'success' : 'error';
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Service Provider</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->

    <!-- Favicon -->
    <link rel="icon" href="favicon_io/favicon.ico">

    <style>
    /* Hide horizontal scrollbar but keep functionality */
    .scroll-x-hidden {
        overflow-x: scroll;
        overflow-y: hidden;
    }

    /* For Chrome, Edge, Safari */
    .scroll-x-hidden::-webkit-scrollbar {
        height: 0px;
    }

    /* For Firefox */
    .scroll-x-hidden {
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
    </style>
</head>

<body>
    <div class="container-scroller">

        <!-- Side Bar -->
        <?php include './includes/sidebar.php'; ?>

        <div class="container-fluid page-body-wrapper">

            <!-- Header -->
            <?php include './includes/header.php'; ?>

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row d-flex justify-content-between align-items-center">
                                        <h4 class="card-title">Emergency Service Bookings</h4>
                                    </div>

                                    <div class="table-responsive scroll-x-hidden">
                                        <table class="table table-bordered" style="border-top: 1px solid #2c2e33">
                                            <thead class="table-dark">
                                                <tr>
                                                    <!-- <th> S.NO </th> -->
                                                    <th> Customer Name </th>
                                                    <th> Service Type </th>
                                                    <th> Vehicle </th>
                                                    <th> Date </th>
                                                    <th> Location </th> <!-- Added -->
                                                    <th> Assigned Worker </th>
                                                    <th> Status </th>
                                                    <th> Action </th>
                                                    <th> Payment </th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php
                                                $bookings = $admin->ret("
                                                SELECT 
                                                    eb.eb_id, 
                                                    eb.eb_location,
                                                    eb.eb_location_link,
                                                    eb.eb_date,  
                                                    eb.eb_status,
                                                    eb.eb_car,
                                                    eb.eb_model,
                                                    eb.vehicle_number,
                                                    eb.assigned_worker_id,
                                                    eb.eb_payment_status,
                                                    c.c_name, 
                                                    c.c_phone,
                                                    es.es_title,
                                                    w.w_name,
                                                    w.w_phone
                                                FROM 
                                                    e_booking eb
                                                JOIN 
                                                    customer c ON eb.c_id = c.c_id
                                                JOIN 
                                                    emergency_services es ON eb.es_id = es.es_id
                                                LEFT JOIN 
                                                    workers w ON eb.assigned_worker_id = w.w_id
                                                WHERE 
                                                    es.sp_id = '$aid'
                                                ORDER BY 
                                                    eb.eb_id DESC
                                            ");

                                                // $sn = 1;
                                                while ($row = $bookings->fetch(PDO::FETCH_ASSOC)) {
                                                    $workerInfo = "";

                                                    if ($row['w_name']) {
                                                        $serviceTitle = $row['es_title'];
                                                        $customerName = $row['c_name'];
                                                        $customerPhone = $row['c_phone']; // you must fetch this in SQL
                                                        $locationName = $row['eb_location'];
                                                        $locationLink = $row['eb_location_link'];
                                                        $carbrand = $row['eb_car'];
                                                        $carmodel = $row['eb_model'];
                                                        $carreg = $row['vehicle_number'];

                                                        $whatsappMessage = "Emergency Service Assigned!\n\n"
                                                            . "Type of Service: $serviceTitle\n"
                                                            . "Customer: $customerName\n"
                                                            . "Car Details: $carbrand-$carmodel-$carreg\n"
                                                            . "Customer Contact: $customerPhone\n"
                                                            . "Location: $locationName\n"
                                                            . "Map: $locationLink";

                                                        $encodedMsg = urlencode($whatsappMessage);
                                                        $workerPhone = $row['w_phone']; // already in your query
                                                        $whatsappURL = "https://wa.me/$workerPhone?text=$encodedMsg";

                                                        $workerInfo = "{$row['w_name']}<br><small>{$workerPhone}</small><br>
                                                            <a href='$whatsappURL' target='_blank' class='btn btn-sm btn-success mt-1'>
                                                                Send WhatsApp
                                                            </a>";
                                                    } else {
                                                        $workerInfo = "<span class='text-warning'>Not Assigned</span>";
                                                    }

                                                    $status = $row['eb_status'] ?? 'Pending'; // Fallback if null
                                                    switch ($status) {
                                                        case 'Approved':
                                                            $statusLabel = '<label class="badge badge-primary">Approved</label>';
                                                            break;
                                                        case 'In Progress':
                                                            $statusLabel = '<label class="badge badge-info">In Progress</label>';
                                                            break;
                                                        case 'Completed':
                                                            $statusLabel = '<label class="badge badge-success">Completed</label>';
                                                            break;
                                                        case 'Cancelled':
                                                            $statusLabel = '<label class="badge badge-danger">Cancelled</label>';
                                                            break;
                                                        case 'Pending':
                                                        default:
                                                            $statusLabel = '<label class="badge badge-warning">Pending</label>';
                                                            $status = 'Pending'; // ensure consistency if it was null
                                                            break;
                                                    }


                                                    $vehicle = $row['eb_car'] . ' - ' . $row['eb_model'];
                                                    $locationName = $row['eb_location'];
                                                    $locationLink = $row['eb_location_link'];
                                                    $locationCell = "$locationName<br><a href='$locationLink' target='_blank'>View</a>";

                                                    $paymentStatus = $row['eb_payment_status'];

                                                    if ($paymentStatus === 'Verified') {
                                                        $paymentButton = "<span class='badge badge-success'>Verified</span>";
                                                    } else {
                                                        $paymentButton = "
                                                            <button 
                                                                class='badge badge-warning border-0 verify-payment-btn' 
                                                                data-id='{$row['eb_id']}' 
                                                                style='cursor:pointer;'>
                                                                Verify
                                                            </button>";
                                                    }

                                                    echo "<tr>
                                                        
                                                        <td>{$row['c_name']}</td>
                                                        <td>{$row['es_title']}</td>
                                                        <td>{$vehicle}</td>
                                                        <td>{$row['eb_date']}</td>
                                                        <td>{$locationCell}</td>
                                                        <td>{$workerInfo}</td>
                                                        <td>{$statusLabel}</td>
                                                        <td>
                                                            <button 
                                                                class='btn btn-sm btn-primary edit-btn' 
                                                                data-id='{$row['eb_id']}'
                                                                data-booked-date='{$row['eb_date']}'
                                                                data-status='{$status}'
                                                                data-toggle='modal' 
                                                                data-target='#editBookingModal'>
                                                                Edit
                                                            </button>
                                                        </td>

                                                        
                                                        <td>{$paymentButton}</td>

                                                    </tr>";

                                                    // $sn++;
                                                    // <td>{$sn}</td> this goes in 188 for showing SNO
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Booking Modal -->
    <div class="modal fade" id="editBookingModal" tabindex="-1" role="dialog" aria-labelledby="editBookingModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark text-white">
                <!-- dark background and white text -->
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Edit Booking</strong></h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="editBookingForm" method="POST" action="./controllers/update-emergency-booking.php">
                    <div class="modal-body">
                        <input type="hidden" name="eb_id" id="edit_eb_id">

                        <div class="form-group">
                            <label>Assign Worker</label>
                            <select class="form-control bg-dark text-white border-secondary" name="assigned_worker_id"
                                id="assigned_worker_select">
                                <option value="">-- Select Worker --</option>
                                <?php
                                $current_booking_id = isset($_POST['eb_id']) ? $_POST['eb_id'] : null;

                                $assigned_worker_id = null;
                                if ($current_booking_id) {
                                    $res = $admin->ret("SELECT assigned_worker_id FROM e_booking WHERE eb_id = '$current_booking_id'");
                                    $assigned_worker_id = $res->fetch(PDO::FETCH_ASSOC)['assigned_worker_id'];
                                }

                                $workers = $admin->ret("SELECT * FROM workers WHERE sp_id = '$aid'");
                                while ($w = $workers->fetch(PDO::FETCH_ASSOC)) {
                                    $disabled = ($w['w_status'] == 'assigned' && $w['w_id'] != $assigned_worker_id) ? 'disabled' : '';
                                    $selected = ($w['w_id'] == $assigned_worker_id) ? 'selected' : '';
                                    $statusLabel = ($w['w_status'] == 'assigned') ? ' (Busy)' : '';
                                    echo "<option value='{$w['w_id']}' $disabled $selected>{$w['w_name']}{$statusLabel}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control bg-dark text-white border-secondary" name="eb_status"
                                id="edit_eb_status">
                                <option value="Approved">Approved</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Admin Notes</label>
                            <textarea class="form-control bg-dark text-white border-secondary" rows="3"
                                placeholder="Add notes (optional)" name="eb_notes"></textarea>
                        </div>

                        <button type="submit" class="btn btn-success btn-block">Update Booking</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include './includes/footer.php'; ?>

    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="assets/vendors/chart.js/Chart.min.js"></script>
    <script src="assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="assets/js/dashboard.js"></script>

    <!-- Scripts -->
    <script>
    $('#editBookingModal').on('show.bs.modal', function() {
        $(this).find('form')[0].reset();
    });

    $('.edit-btn').on('click', function() {
        $('#edit_eb_id').val($(this).data('id'));
        $('#edit_eb_status').val($(this).data('status'));
    });
    </script>

    <script>
    $(document).ready(function() {
        $('.verify-payment-btn').click(function() {
            var bookingId = $(this).data('id');
            var button = $(this);

            $.ajax({
                url: '', // same page
                type: 'POST',
                data: {
                    ajax_verify_payment: true,
                    eb_id: bookingId
                },
                success: function(response) {
                    if (response.trim() === 'success') {
                        button.replaceWith(
                            "<span class='badge badge-success'>Verified</span>");
                    } else {
                        alert("Failed to verify payment.");
                    }
                }
            });
        });
    });
    </script>


</body>

</html>