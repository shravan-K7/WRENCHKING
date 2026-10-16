<?php
include '../config.php'; // Ensure correct path
require '../vendor/autoload.php'; // Load DomPDF

$admin = new Admin();
if (!isset($_SESSION['sp_id'])) {
    echo "<script>window.location='./login.php';</script>";
    exit;
}

if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];

    // Fetch Booking Details
    $booking = $admin->ret("
        SELECT sb.sb_id, c.c_name, c.c_email, sb.car_brand, sb.car_model, s.s_title, sb.sb_time, sb.sb_booked_date,sb.vehicle_number,s.s_price
        FROM service_booking sb
        JOIN customer c ON sb.c_id = c.c_id
        JOIN services s ON sb.s_id = s.s_id
        WHERE sb.sb_id = '$booking_id'
    ");

    $row = $booking->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        echo "<script>alert('Invalid Booking ID'); window.location='./view-service-bookings.php';</script>";
        exit;
    }
} else {
    echo "<script>window.location='./view-service-bookings.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Invoice - WrenchKing</title>
    <style>
    * {
        box-sizing: border-box;
    }

    /* Full screen centering */
    body {
        background-color: #F5F5F5;
        font-family: Arial, sans-serif;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 15px;
    }

    /* Centered invoice card with border */
    .invoice-card {
        max-width: 500px;
        width: 100%;
        background: white;
        padding: 20px;
        border: 1px solid black;
        border-radius: 5px;
        box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.1);
    }

    /* Red and bold title */
    .invoice-card h1 {
        color: red;
        font-size: 28px;
        text-align: center;
        margin-bottom: 5px;
    }

    /* Centered invoice title */
    .invoice-card h2 {
        font-size: 22px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 0px;
        margin-top: 10px;
    }

    /* Date aligned to the right */
    .date {
        font-weight: bold;
        text-align: right;
        font-size: 13px;
        margin-bottom: 10px;
    }

    /* Invoice labels */
    .invoice-label {
        font-weight: bold;
        display: inline-block;
        width: 135px;
    }

    .invoice-data {
        text-align: left;
        margin-bottom: 8px;
    }

    /* Align "Enter Price" label and input closely */
    .form-group {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .form-group label {
        font-weight: bold;
        white-space: nowrap;
        margin-right: 5px;
    }

    /* Number input without arrows */
    .form-control {
        width: 120px;
        padding: 5px;
        border: 1px solid black;
        border-radius: 3px;
        font-size: 16px;
        text-align: right;
        -moz-appearance: textfield;
        /* Firefox */
        appearance: textfield;
        /* Chrome, Safari, Edge */
    }

    /* Remove number input arrows (Chrome, Safari, Edge) */
    .form-control::-webkit-inner-spin-button,
    .form-control::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Submit button styling */
    .btn-submit {
        width: 100%;
        background: black;
        color: white;
        border: none;
        padding: 10px;
        font-size: 18px;
        border-radius: 3px;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-submit:hover {
        background: #333;
    }

    hr {
        border: 1px solid black;
        margin: 0px 0;
    }
    </style>
</head>

<body>
    <div class="invoice-card">
        <h1>WrenchKing</h1>
        <hr>
        <h2>Invoice</h2>
        <div class="date">Date: <?= date('d-m-Y'); ?></div>

        <form action="process-invoice.php" method="POST">
            <input type="hidden" name="booking_id" value="<?= $row['sb_id']; ?>">
            <input type="hidden" name="customer_email" value="<?= $row['c_email']; ?>">

            <div class="invoice-data">
                <span class="invoice-label">Customer Name:</span> <?= $row['c_name']; ?>
            </div>
            <div class="invoice-data">
                <span class="invoice-label">Service Type:</span> <?= $row['s_title']; ?>
            </div>
            <div class="invoice-data">
                <span class="invoice-label">Vehicle:</span>
                <?= $row['car_brand'] . ' - ' . $row['car_model'] . ' - ' . $row['vehicle_number']; ?>
            </div>
            <!-- Additional Charges Section -->
            <div id="extra-charges"></div>

            <button type="button" onclick="addLine()" style="margin: 10px 0; padding: 5px 10px; cursor: pointer;">+ Add
                New Line</button>

            <!-- Total Section -->
            <div class="invoice-data">
                <span class="invoice-label">Base Price:</span> ₹<span id="base-price"><?= $row['s_price']; ?></span>
            </div>
            <div class="invoice-data" style="font-weight:bold;">
                <span class="invoice-label">Total Amount:</span> ₹<span id="total-amount"><?= $row['s_price']; ?></span>
            </div>

            <!-- Hidden input to submit total amount -->
            <input type="hidden" name="total_amount" id="hidden-total" value="<?= $row['s_price']; ?>">

            <!-- FIXED: Label and input now sit close together -->
            <div class="form-group">
                <label for="price">Enter Price: ₹</label>
                <input type="text" value="<?php echo $row['s_price']; ?>" class="form-control" name="price" id="price"
                    required maxlength="10">
            </div>

            <hr>
            <button type="submit" class="btn-submit">Generate & Send Invoice</button>
        </form>
    </div>

    <script>
    // Restrict input to numbers only and max 10 digits
    document.getElementById('price').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, ''); // Allow only numbers
        if (this.value.length > 10) {
            this.value = this.value.slice(0, 10); // Limit to 10 digits
        }
    });
    </script>

    <script>
    let basePrice = parseFloat(document.getElementById('price').value) || 0;
    let extraChargesContainer = document.getElementById('extra-charges');
    let lineCount = 0;

    function updateTotal() {
        let total = basePrice;
        document.querySelectorAll('.extra-amount').forEach(input => {
            const val = parseFloat(input.value) || 0;
            total += val;
        });
        document.getElementById('total-amount').textContent = total;
        document.getElementById('hidden-total').value = total;
    }

    function addLine() {
        lineCount++;
        const div = document.createElement('div');
        div.className = 'form-group';

        div.innerHTML = `
        <input type="text" text-center name="extra_desc[]" placeholder="Description" style="flex:1; margin-right:5px; padding:5px;" required>
        <input type="text" text-center name="extra_amount[]" class="extra-amount" placeholder="₹ Amount" style="width: 100px; text-align:right;" required maxlength="10">
    `;

        // Add input listener to recalculate total
        setTimeout(() => {
            div.querySelector('.extra-amount').addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                updateTotal();
            });
        }, 0);

        extraChargesContainer.appendChild(div);
    }

    document.getElementById('price').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
        basePrice = parseFloat(this.value) || 0;
        document.getElementById('base-price').textContent = this.value || 0;
        updateTotal();
    });
    </script>

</body>

</html>