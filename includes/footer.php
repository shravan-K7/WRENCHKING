<div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-3 col-md-6">
                <h4 class="text-light mb-4">Address</h4>

                <div id="addressCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                    <div class="carousel-inner">
                        <?php
                        // Fetch service provider contact info
                        $query = "SELECT sp_address, sp_phone, sp_email FROM s_provider";
                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result) > 0) {
                            $isFirst = true;
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<div class="carousel-item ' . ($isFirst ? 'active' : '') . '">';
                                echo '<p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>' . $row['sp_address'] . '</p>';
                                echo '<p class="mb-2"><i class="fa fa-phone-alt me-3"></i>' . $row['sp_phone'] . '</p>';
                                echo '<p class="mb-2"><i class="fa fa-envelope me-3"></i>' . $row['sp_email'] . '</p>';
                                echo '</div>';
                                $isFirst = false;
                            }
                        } else {
                            echo '<div class="carousel-item active">';
                            echo '<p class="mb-2">No Service Providers Found</p>';
                            echo '</div>';
                        }
                        ?>
                    </div>

                    <!-- Invisible Prev Button -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#addressCarousel"
                        data-bs-slide="prev">
                        <span class="visually-hidden">Previous</span>
                    </button>

                    <!-- Invisible Next Button -->
                    <button class="carousel-control-next" type="button" data-bs-target="#addressCarousel"
                        data-bs-slide="next">
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>


            <div class="col-lg-3 col-md-6">
                <h4 class="text-light mb-4">Opening Hours</h4>
                <h6 class="text-light">Monday - Saturday:</h6>
                <p class="mb-4">09.00 AM - 08.00 PM</p>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-light mb-4">Services</h4>
                <a class="btn btn-link" href="carservice.php">Diagnostic Test</a>
                <a class="btn btn-link" href="carservice.php">Engine Servicing</a>
                <a class="btn btn-link" href="carservice.php">Tires Replacement</a>
                <a class="btn btn-link" href="carservice.php">Oil Changing</a>
                <a class="btn btn-link" href="carservice.php">Denting and Painting</a>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-light mb-4">Emergency Services</h4>
                <a class="btn btn-link" href="emergencyservice.php">Flat Tire Replacement</a>
                <a class="btn btn-link" href="emergencyservice.php">Battery Jump-Start</a>
                <a class="btn btn-link" href="emergencyservice.php">Towing Service</a>
                <a class="btn btn-link" href="emergencyservice.php">Engine Diagnostics</a>
                <a class="btn btn-link" href="emergencyservice.php">Lockout Service</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="copyright">
            <div class="row">
                <div class="col-md-12 text-center mb-3 mb-md-0">
                    &copy; <a class="text-center">WrenchKing</a>, All Right Reserved.
                </div>

            </div>
        </div>
    </div>
</div>