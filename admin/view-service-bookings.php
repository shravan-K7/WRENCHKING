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
if (isset($_POST['verify_btn']) && isset($_POST['verify_id'])) {
    $verifyId = $_POST['verify_id'];
    $admin->cud("UPDATE service_booking SET verify = 1 WHERE sb_id = $verifyId", "updated");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Service Provider</title>
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
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
                                        <h4 class="card-title">Service Bookings</h4>
                                    </div>

                                    <div class="table-responsive scroll-x-hidden">
                                        <table class="table table-bordered" style="border-top: 1px solid #2c2e33">
                                            <thead class="table-dark">
                                                <tr>
                                                    <!-- <th> S.NO </th> -->
                                                    <th> Customer Name </th>
                                                    <th> Vehicle </th>
                                                    <th> Service Type </th>
                                                    <th> Date </th>
                                                    <th> Allotted Time </th>
                                                    <th> Assigned Worker </th>
                                                    <th> Notes </th>
                                                    <th> Expected Return </th>
                                                    <th> Status </th>
                                                    <th> Invoice </th>
                                                    <th> Action </th>
                                                    <th> Payment </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $bookings = $admin->ret("
                                                    SELECT 
                                                        sb.sb_id, 
                                                        c.c_name, 
                                                        sb.car_brand,
                                                        sb.car_model,
                                                        s.s_title, 
                                                        sb.sb_time, 
                                                        sb.sb_booked_date, 
                                                        sb.sb_status,
                                                        sb.exp_date,
                                                        w.w_name AS assigned_worker,
                                                        w.w_phone,
                                                        sb.sb_response,
                                                        sb.t_id,
                                                        sb.vehicle_number,
                                                            sb.verify
                                                        FROM 
                                                            service_booking sb
                                                        JOIN 
                                                            customer c ON sb.c_id = c.c_id
                                                        JOIN 
                                                            services s ON sb.s_id = s.s_id
                                                        LEFT JOIN 
                                                            workers w ON sb.assigned_worker_id = w.w_id
                                                        WHERE 
                                                            s.sp_id = '$aid'
                                                        ORDER BY 
                                                            sb.sb_id DESC
                                                ");

                                                // $sn = 1;
                                                while ($row = $bookings->fetch(PDO::FETCH_ASSOC)) {
                                                    $status = $row['sb_status'];
                                                    switch ($status) {
                                                        case 'Pending':
                                                            $statusLabel = '<label class="badge badge-warning">Pending</label>';
                                                            break;
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
                                                        default:
                                                            $statusLabel = '<label class="badge badge-secondary">Unknown</label>';
                                                    }

                                                    echo "
                                                    <tr>
                                                        
                                                        <td>{$row['c_name']}</td>
                                                        <td>
                                                            {$row['car_brand']} - {$row['car_model']}<br>
                                                            {$row['vehicle_number']}
                                                        </td>
                                                        <td>{$row['s_title']}</td>
                                                        <td>{$row['sb_booked_date']}</td>
                                                        <td>{$row['sb_time']}</td>
                                                        <td>";

                                                    if (!empty($row['assigned_worker'])) {
                                                        echo "{$row['assigned_worker']}<br>
                                                            <span style='font-size: 0.9em;'>📞 {$row['w_phone']}</span>";
                                                    } else {
                                                        echo "<span class='text-warning'>Not Assigned</span>";
                                                    }

                                                    echo "</td>
                                                        <td>" . (!empty($row['sb_response']) ? $row['sb_response'] : "<i class='text-muted'>No notes</i>") . "</td>
                                                        <td>" . (!empty($row['exp_date']) ? $row['exp_date'] : "<i class='text-muted'>Not Set</i>") . "</td>
                                                        <td>{$statusLabel}</td>
                                                        <td>
                                                            <a href='generate-invoice.php?booking_id={$row['sb_id']}' class='btn btn-sm btn-success'>
                                                                Generate Invoice
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <button 
                                                                class='btn btn-sm btn-primary edit-btn' 
                                                                data-id='{$row['sb_id']}'
                                                                data-booked-date='{$row['sb_booked_date']}'
                                                                data-status='{$status}'
                                                                data-toggle='modal' 
                                                                data-target='#editBookingModal'>
                                                                Edit
                                                            </button>
                                                        </td>
                                                        <td>";

                                                    if (!empty($row['t_id'])) {
                                                        echo "T_ID: {$row['t_id']}<br>";
                                                        if ($row['verify'] == 1) {
                                                            echo "<span class='badge bg-success'>Verified</span>";
                                                        } else {
                                                            echo "
                                                            <form method='post' style='display:inline;'>
                                                                <input type='hidden' name='verify_id' value='{$row['sb_id']}'>
                                                                <button type='submit' name='verify_btn' class='btn btn-sm btn-warning'>Verify</button>
                                                            </form>";
                                                        }
                                                    }

                                                    echo "</td>
                                                    </tr>";


                                                    // $sn++;
                                                    // <td>{$sn}</td> this goes in 160s for showing SNO
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

                <form id="editBookingForm" method="POST" action="./controllers/update-service-booking.php">
                    <div class="modal-body">
                        <input type="hidden" name="sb_id" id="edit_sb_id">

                        <div class="form-group">
                            <label>Scheduled Time</label>
                            <select class="form-control bg-dark text-white border-secondary" name="sb_time" required>
                                <option value="09:00 AM">09:00 AM</option>
                                <option value="10:30 AM">10:30 AM</option>
                                <option value="12:00 PM">12:00 PM</option>
                                <option value="01:30 PM">01:30 PM</option>
                                <option value="03:00 PM">03:00 PM</option>
                                <option value="04:30 PM">04:30 PM</option>
                                <option value="06:00 PM">06:00 PM</option>
                                <option value="07:30 PM">07:30 PM</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Assign Worker</label>
                            <select class="form-control bg-dark text-white border-secondary" name="assigned_worker_id"
                                id="assigned_worker_select">
                                <option value="">-- Select Worker --</option>
                                <?php
                                $current_booking_id = isset($_POST['sb_id']) ? $_POST['sb_id'] : null;
                                $assigned_worker_id = null;
                                if ($current_booking_id) {
                                    $res = $admin->ret("SELECT assigned_worker_id FROM service_booking WHERE sb_id = '$current_booking_id'");
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
                            <select class="form-control bg-dark text-white border-secondary" name="sb_status"
                                id="edit_sb_status">
                                <option value="Approved">Approved</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>

                        <!-- Date picker -->
                        <div class="form-group">
                            <label>Expected Return Date</label>
                            <input type="date" class="form-control bg-dark text-white border-secondary" name="exp_date"
                                id="edit_exp_date">
                        </div>

                        <div class="form-group">
                            <label>Admin Notes</label>
                            <textarea class="form-control bg-dark text-white border-secondary" rows="3"
                                placeholder="Add notes (optional)" name="sb_notes"></textarea>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <!-- Scripts -->
    <script>
        $('#editBookingModal').on('show.bs.modal', function () {
            $(this).find('form')[0].reset();
        });

        $('.edit-btn').on('click', function () {
            $('#edit_sb_id').val($(this).data('id'));
            $('#edit_sb_status').val($(this).data('status'));
        });
    </script>

    <!-- Script for Date Picker     -->
    <script>
        $(document).ready(function () {
            // Initialize datepicker with min date as today
            $("#edit_exp_date").datepicker({
                dateFormat: "yy-mm-dd",
                minDate: 0 // Prevent past dates
            });

            // Reset modal form on open
            $('#editBookingModal').on('show.bs.modal', function () {
                $(this).find('form')[0].reset();
            });

            // Populate modal fields when "Edit" button is clicked
            $('.edit-btn').on('click', function () {
                $('#edit_sb_id').val($(this).data('id'));
                $('#edit_sb_status').val($(this).data('status'));
                $('#edit_exp_date').val($(this).data('exp-date')); // Populate expected date
            });
        });
    </script>

</body>

</html>