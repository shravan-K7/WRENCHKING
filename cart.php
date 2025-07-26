<?php
include './config.php';
$admin = new Admin();
if (isset($_SESSION['c_id'])) {
    $cId = $_SESSION["c_id"];
    $customerProfile = $admin->ret("SELECT * FROM `customer` WHERE `c_id`='$cId'");

    if ($customerProfile->rowCount() > 0) {
        $profile = $customerProfile->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "No customer data found.";
        exit;
    }
} else {
    echo "<script>alert('Login to view cart');window.location='./signin.php';</script>"; // Redirect to login if session doesn't exist
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>WrenchKing</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link rel="icon" href="favicon_io/favicon.ico">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@600;700&family=Ubuntu:wght@400;500&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="styles.css"> <!-- Link to CSS file -->

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <style>
        th,
        td {
            text-align: center;
        }
    </style>

</head>

<body>
    <!-- Header -->
    <?php
    include './includes/header.php';
    ?>
    <!-- Header end -->

    <div class="container mt-5">
        <h2 class="text-center">Your Cart<i class="bi bi-cart"></i></h2>
        <table class="table table-striped mt-4">
            <thead style="background-color: #d81324;">
                <tr>
                    <td style="color:white;" scope="col">Product</td>
                    <td style="color:white;" scope="col">Product</td>
                    <td style="color:white;" scope="col">Price</td>
                    <td style="color:white;" scope="col">Quantity</td>
                    <td style="color:white;" scope="col">Total</td>
                    <td style="color:white;" scope="col">Remove</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $getCartProducts = $admin->ret("SELECT * FROM `cart` INNER JOIN `product` on product.p_id=cart.p_id WHERE `c_id`='$cId'");
                $count = $getCartProducts->rowCount();
                if ($count > 0) {
                    $grandTotal = 0;
                    while ($product = $getCartProducts->fetch(PDO::FETCH_ASSOC)) {
                        $price = $product['p_price'];
                        $quantity = $product['ct_qty'];
                        $total = $price * $quantity;
                        $grandTotal += $total;
                        ?>
                        <tr class="text-center align-middle">
                            <td>
                                <img src="./admin/controllers/<?php echo $product['p_image']; ?>" class="img-thumbnail"
                                    style="width: 80px; height: 80px;" alt="<?php echo $product['p_name']; ?>">
                            </td>
                            <td><?php echo $product['p_name'] ?></td>
                            <td><?php echo $product['p_price'] ?></td>
                            <td>
                                <?php if ($product['ct_qty'] > 1) { ?>
                                    <a href="./controllers/cart.php?ct_id=<?php echo $product['ct_id'] ?>&action=Decrement">-</a>
                                <?php } ?>
                                <?php echo $product['ct_qty'] ?>
                                <a href="./controllers/cart.php?ct_id=<?php echo $product['ct_id'] ?>&action=Increment">+</a>
                            </td>
                            <td><?php echo $total ?></td>
                            <td><a href="./controllers/cart.php?ct_id=<?php echo $product['ct_id'] ?>&action=Delete"><i
                                        class="bi bi-trash fs-4"></i> <!-- fs-4 is slightly bigger than default -->
                                </a>
                            </td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr class="text-center">
                        <td colspan="6">No products found in cart!</td>
                    </tr>
                <?php } ?>
            </tbody>

        </table>
        <?php
        if ($count > 0) {
            ?>
            <div class="text-black">
                <span class="fs-5 mb-0">Total Amount: <?php echo $grandTotal; ?></span>
            </div>
        <?php } ?>
        <br>
        <div class="text-center mt-3">
            <a href="spares.php" class="btn btn-secondary">Continue Shopping</a>
            <?php
            if ($count > 0) {
                ?>
                <button class="btn btn-success" onclick="location.href='checkout.php'">Proceed to Checkout</button>
            <?php } ?>
        </div>
    </div>


    <!-- Footer Start -->
    <?php
    include './includes/footer.php';
    ?>
    <!-- Footer End -->


    <script src="js/sparpurchase.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>