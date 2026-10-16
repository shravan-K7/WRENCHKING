<?php
include './config.php';
$admin = new Admin();
if (isset($_SESSION['c_id'])) {
    $cId = $_SESSION["c_id"];
    $customerProfile = $admin->ret("SELECT * FROM `customer` WHERE `c_id`='$cId'");
    $profile = $customerProfile->fetch(PDO::FETCH_ASSOC);
} else {
    echo "<script>alert('Login to book the service');window.location='./signin.php';</script>";
}
$esid = $_GET['es_id'];
$getService = $admin->ret("SELECT * FROM `emergency_services` where `es_id`='$esid'");
$service = $getService->fetch(PDO::FETCH_ASSOC);

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
    <?php

    include './includes/header.php';

    ?>
    <!-- Header end -->


    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Book Our Services</h1>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <div class="text-center mt-2">
        <span class="d-inline-block p-2 border-start border-4 border-warning rounded"
            style="background-color: #fff3cd;">
            <strong>Note:</strong> Price may vary based on car condition.
        </span>
    </div>

    <!-- Booking Start -->
    <div class="container-fluid my-5 wow fadeInUp" style="background-color:white" data-wow-delay="0.1s">
        <div class="container bg-white d-flex justify-content-center">
            <div class="col-lg-8">
                <div class="bg-primary h-100 d-flex flex-column justify-content-center text-center p-4 p-md-5 wow zoomIn"
                    data-wow-delay="0.6s">
                    <h1 class="text-white mb-4">Book Emergency Service</h1>
                    <form action="./controllers/booking.php" method="POST">
                        <div class="row g-3">
                            <!-- Car Brand Dropdown -->
                            <!-- Car Brand Dropdown -->
                            <div class="col-12 col-sm-6">
                                <select name="brand" required id="brandSelect" class="form-select border-0"
                                    style="height: 55px;">
                                    <option value="" hidden>Select a Brand...</option>
                                    <option value="maruti">Maruti Suzuki</option>
                                    <option value="toyota">Toyota</option>
                                    <option value="honda">Honda</option>
                                    <option value="mahindra">Mahindra</option>
                                    <option value="hyundai">Hyundai</option>
                                    <option value="tata">Tata</option>
                                    <option value="renault">Renault</option>
                                    <option value="kia">KIA</option>
                                    <option value="volkswagen">Volkswagen</option>
                                    <option value="mitsubishi">Mitsubishi</option>
                                    <option value="nissan">Nissan</option>
                                </select>
                            </div>

                            <!-- Car Model Dropdown -->
                            <div class="col-12 col-sm-6">
                                <select name="car" required id="carSelect" class="form-select border-0"
                                    style="height: 55px;">
                                    <option hidden value="">Select a Car</option>
                                </select>
                            </div>

                            <!-- Vehicle Registration Number -->
                            <div class="col-12 col-sm-6">
                                <input type="text" name="vehicle_number" id="vehicleNumber"
                                    class="form-control border-0"
                                    placeholder="Enter Vehicle Registration Number (e.g., KL01AB1234)" required
                                    pattern="^[A-Z]{2}[0-9]{2}[A-Z]{1,2}[0-9]{4}$"
                                    title="Enter a valid Indian vehicle number (e.g., KL01AB1234)"
                                    style="height: 55px;">
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="phone" id="phone">
                                    <input readonly disabled value="<?php echo $service['es_title'] ?>" required
                                        type="tele" class="form-control border-0" placeholder="Phone"
                                        style="height: 55px;">
                                    <input name="es_id" value="<?php echo $service['es_id'] ?>" required type="hidden"
                                        class="form-control border-0" placeholder="Phone" style="height: 55px;">

                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="phone" id="phone">
                                    <input name="phone" required type="tel" class="form-control border-0"
                                        placeholder="Phone" style="height: 55px;" pattern="\d{10}" maxlength="10"
                                        minlength="10" title="Please enter a 10-digit phone number">
                                </div>
                            </div>


                            <div class="col-12 col-sm-6">
                                <div class="" id="location">
                                    <input name="location" required type="text" maxlength="10"
                                        placeholder="Type your location" class="form-control border-0"
                                        style="height: 55px;">

                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="" id="locationlink">
                                    <input name="locationlink" required type="text"
                                        placeholder="provide your location link from google map"
                                        class="form-control border-0" style="height: 55px;">

                                </div>
                            </div>


                            <!-- Special Request -->
                            <div class="col-12">
                                <textarea name="message" class="form-control border-0" placeholder="Message"></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12">
                                <button class="btn btn-secondary w-100 py-3" name="e-book" type="submit">Book
                                    Now</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </>
    <!-- Booking End -->

    <!-- Footer Start -->
    <?php include './includes/footer.php'; ?>
    <!-- Footer End -->

    <!-- JavaScript -->
    <script>
        // Car models list based on brand
        const carModels = {
            maruti: ["800", "Omni", "Gypsy", "Zen", "Ritz", "A-Star", "Esteem", "Eeco", "Alto K10", "S-Presso",
                "Celerio",
                "WagonR", "Swift", "Baleno", "Dzire", "Ciaz", "Brezza", "Grand Vitara", "Ignis", "Ertiga"
            ],
            honda: ["Amaze", "City", "WR-V", "Jazz", "BR-V", "Accord", "CR-V", "Civic", "Brio", "Mobilio", "Elevate"],
            toyota: ["Glanza", "Etios Liva", "Etios", "Corolla Altis", "Qualis", "Innova",
                "Innova Crysta", "Fortuner",
            ],
            mahindra: ["Bolero", "Scorpio", "Xylo", "Thar", "XUV500", "Quanto", "TUV300", "Marazzo", "XUV300",
                "Bolero Neo", "Scorpio-N", "XUV700", "Bolero Pik-Up", "Scorpio Getaway", "Imperio"
            ],
            hyundai: ["Santro", "Getz", "Eon", "i10", "Grand i10", "Grand i10 Nios", "i20", "i20 N Line", "Accent",
                "Verna", "Elantra", "Tucson", "Santa Fe", "Creta", "Alcazar", "Venue", "Exter"
            ],
            tata: ["Indica", "Nano", "Bolt", "Tiago", "Altroz", "Indigo", "Indigo eCS", "Zest", "Tigor", "Safari",
                "Sumo", "Hexa", "Aria", "Harrier", "Nexon", "Punch"
            ],
            renault: ["Kwid", "Logan", "Duster", "Captur", "Triber", "Kiger"],
            kia: ["Seltos", "Sonet", "Carens"],
            volkswagen: ["Polo", "Vento", "Virtus", "Tiguan"],
            mitsubishi: ["Lancer", "Pajero", "Pajero Sport",],
            nissan: ["Micra", "Sunny", "Terrano", "Kicks", "Magnite",]
        };

        // Elements
        const brandSelect = document.getElementById("brandSelect");
        const carSelect = document.getElementById("carSelect");
        // Listen for brand change
        brandSelect.addEventListener("change", function () {
            const selectedBrand = brandSelect.value;
            carSelect.innerHTML = '<option hidden value="">Select a car</option>'; // Reset options

            if (carModels[selectedBrand]) {
                carModels[selectedBrand].forEach(car => {
                    let option = document.createElement("option");
                    option.value = car.toLowerCase().replace(/\s+/g,
                        "-"); // Convert to lowercase hyphen format
                    option.textContent = car;
                    carSelect.appendChild(option);
                });
            }
        });
    </script>




    <script>
        brandSelect.addEventListener("change", function () {
            const selectedBrand = brandSelect.value;
            if (!selectedBrand) return;

            // Prevent unnecessary resets
            if (carSelect.dataset.currentBrand === selectedBrand) return;

            carSelect.dataset.currentBrand = selectedBrand;
            carSelect.innerHTML = '<option hidden value="">Select a car</option>';

            carModels[selectedBrand]?.forEach(car => {
                let option = document.createElement("option");
                option.value = car.toLowerCase().replace(/\s+/g, "-");
                option.textContent = car;
                carSelect.appendChild(option);
            });
        });
    </script>
    <script>
        document.querySelector('form').addEventListener('submit', function (e) {
            const now = new Date();
            const day = now.getDay(); // 0 = Sunday, 6 = Saturday
            const hour = now.getHours(); // 0–23

            if (day === 0) {
                alert("Emergency booking is not available on Sundays. Please choose another day.");
                e.preventDefault();
                return;
            }

            if (hour < 9 || hour >= 20) {
                alert("Emergency bookings are allowed only between 9:00 AM and 8:00 PM.");
                e.preventDefault();
            }
        });
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

    <!-- Bootstrap Datepicker Dependencies -->
    <!-- jQuery (Required for Datepicker) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap Bundle (Includes Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap Datepicker CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

    <!-- Bootstrap Datepicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js">
    </script>


    <!-- Template Javascript -->
    <script src="js/main.js"></script>



</body>

</html>