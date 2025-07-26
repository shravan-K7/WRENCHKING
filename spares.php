<?php
include './config.php';
$admin = new Admin();

if (isset($_SESSION['c_id'])) {
    $cId = $_SESSION["c_id"];
    $customerProfile = $admin->ret("SELECT * FROM `customer` WHERE `c_id`='$cId'");
    $profile = $customerProfile->fetch(PDO::FETCH_ASSOC);
}

// Get selected Service Provider
$selectedSpId = isset($_GET['sp_id']) ? $_GET['sp_id'] : '';

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
    <link href="css/spare.css" rel="stylesheet">
</head>

<body>
    <!-- Header -->
    <?php
    include './includes/header.php';
    ?>
    <!-- Header end -->

    <div class="container mt-4 position-relative">
        <div class="d-flex justify-content-end mt-4">
            <a href="cart.php" class="btn btn-outline-primary"><i class="bi bi-cart-dash"></i> View Cart</a>
        </div>
        <h2 class="text-center">Spare Parts for Your Car</h2>

        <!-- Select Service Provider Dropdown -->
        <form method="GET">
            <div class="d-flex justify-content-end my-4">
                <label for="sp_id" class="form-label text-white m-0 bg-danger px-3 py-3 rounded">Select Service
                    Provider</label>
                <select name="sp_id" id="sp_id" class="form-select" style="height: 55px; width: auto;"
                    onchange="this.form.submit()">
                    <option value="">All Providers</option>
                    <?php
                    $getProviders = $admin->ret("SELECT * FROM `s_provider`");
                    while ($provider = $getProviders->fetch(PDO::FETCH_ASSOC)) {
                        $selected = ($provider['sp_id'] == $selectedSpId) ? 'selected' : '';
                        echo "<option value='{$provider['sp_id']}' $selected>{$provider['sp_name']}</option>";
                    }
                    ?>
                </select>
            </div>
        </form>


        <!-- Spare Parts List -->
        <div class="row row-cols-1 row-cols-md-4 g-4 pt-3" id="product-list">
            <?php
            $query = "SELECT * FROM `product` INNER JOIN `s_provider` ON s_provider.sp_id=product.sp_id WHERE `p_status`='Available'";

            if (!empty($selectedSpId)) {
                $query .= " AND product.sp_id = '$selectedSpId'";
            }

            $getSpares = $admin->ret($query);
            if ($getSpares->rowCount() > 0) {
                while ($spare = $getSpares->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <div class="col">
                        <div class="product-card">
                            <img src="./admin/controllers/<?php echo $spare['p_image']; ?>" class="img-fluid"
                                alt="<?php echo $spare['p_name']; ?>">
                            <h5><?php echo $spare['p_name']; ?></h5>
                            <p><strong>₹<?php echo $spare['p_price']; ?></strong></p>
                            <p class="m-2"><?php echo $spare['p_description']; ?></p>
                            <p class="m-1"><strong>Provider:</strong> <?php echo $spare['sp_name']; ?></p>

                            <!-- Stock count -->
                            <?php if ($spare['p_stock'] > 0): ?>
                                <p>
                                    <strong>Stock:</strong> <?= $spare['p_stock']; ?>
                                </p>
                            <?php endif; ?>

                            <?php if (isset($_SESSION['c_id'])) { ?>
                                <?php if ($spare['p_stock'] > 0) { ?>
                                    <a href="./controllers/cart.php?p_id=<?php echo $spare['p_id']; ?>&action=add"
                                        class="btn btn-primary">Add to Cart</a>
                                <?php } else { ?>
                                    <button class="btn btn-dark" disabled>Out of Stock</button>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                    <?php
                }
            } else { ?>
                <div class="col col-lg-12 pt-5">
                    <div class="d-flex justify-content-center">
                        No products found!
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>

    <!-- Footer Start -->
    <?php
    include './includes/footer.php';
    ?>
    <!-- Footer End -->

    <!-- <script>
        let cart = [];
        $(document).on("click", ".add-to-cart", function () {
            let name = $(this).data("name");
            let price = $(this).data("price");
            cart.push({
                name,
                price
            });
            alert(name + " added to cart!");
            localStorage.setItem("cart", JSON.stringify(cart));
        });
    </script> -->



    <!-- JavaScript Libraries -->
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