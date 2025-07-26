<?php
include './config.php';
$admin = new Admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'load_reviews') {
    $offset = isset($_POST['offset']) ? (int) $_POST['offset'] : 0;
    $limit = isset($_POST['limit']) ? (int) $_POST['limit'] : 10;

    $allReviews = $admin->ret("SELECT * FROM `contact` ORDER BY `created_at` DESC LIMIT $offset, $limit");
    while ($row = $allReviews->fetch(PDO::FETCH_ASSOC)) {
        $reviewedOn = date("F j, Y \a\\t g:i A", strtotime($row['created_at']));
        ?>
        <div class="col-md-12 mb-4 border-bottom pb-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="d-flex align-items-center">
                    <img src="img/default-user.png" alt="User" class="rounded-circle me-3" width="50" height="50">
                    <div>
                        <strong><?= htmlspecialchars($row['name']); ?></strong><br>
                        <small class="text-muted"><?= htmlspecialchars($row['subject']); ?></small>
                    </div>
                </div>
                <div class="text-end">
                    <small class="text-muted">Reviewed on <?= $reviewedOn; ?></small>
                </div>
            </div>
            <p class="mb-1"><?= nl2br(htmlspecialchars($row['message'])); ?></p>
        </div>
        <?php
    }
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Wrenchking</title>
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
</head>

<body>

    <!-- Header -->
    <?php include './includes/header.php'; ?>
    <!-- Header end -->

    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url(img/carousel-bg-1.jpg);">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Testimonial</h1>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Testimonial Start -->
    <div class="container-fluid py-5  wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="text-center">
                <h1 class="mb-5">Our Clients Say!</h1>
            </div>
            <div class="owl-carousel testimonial-carousel position-relative">
                <?php
                // Limit the number of testimonials to 5
                $testimonials = $admin->ret("SELECT * FROM `contact` ORDER BY `created_at` DESC LIMIT 5");
                while ($row = $testimonials->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <div class="testimonial-item text-center">
                        <img class="rounded-circle mx-auto mb-3" src="img/default-user.png"
                            style="width: 80px; height: 80px;">
                        <h5 class="mb-0"><?= htmlspecialchars($row['name']); ?></h5>
                        <p><?= htmlspecialchars($row['subject']); ?></p>
                        <div class="testimonial-text bg-white text-center p-4 rounded">
                            <p class="mb-0"><?= htmlspecialchars($row['message']); ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->

    <!-- All Reviews Section Start -->
    <div class="container py-5">
        <h2 class="mb-4">Customer Reviews</h2>
        <div id="review-container" class="row">
            <!-- Reviews will be loaded here via AJAX -->
        </div>
        <div class="text-center mt-4">
            <button id="loadMoreBtn" class="btn btn-outline-primary">Load More Reviews</button>
        </div>
    </div>
    <!-- All Reviews Section End -->


    <!-- Footer Start -->
    <?php include './includes/footer.php'; ?>
    <!-- Footer End -->

    <script>
        let offset = 0;
        const limit = 10;

        function loadReviews() {
            fetch("testimonial.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `action=load_reviews&offset=${offset}&limit=${limit}`
            })
                .then(response => response.text())
                .then(data => {
                    if (data.trim() === "") {
                        document.getElementById("loadMoreBtn").style.display = "none";
                    } else {
                        document.getElementById("review-container").innerHTML += data;
                        offset += limit;
                    }
                });
        }

        // Load initial reviews on page load
        window.addEventListener("DOMContentLoaded", () => {
            loadReviews();
        });

        // Load more on button click
        document.getElementById("loadMoreBtn").addEventListener("click", loadReviews);
    </script>


    <!-- JavaScript Libraries -->
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