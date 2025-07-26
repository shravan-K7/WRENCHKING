-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2025 at 11:30 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wrenchking`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `ct_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `ct_qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`ct_id`, `p_id`, `c_id`, `ct_qty`) VALUES
(115, 2, 21, 1);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `branch` int(5) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `branch`, `subject`, `message`, `created_at`) VALUES
(1, 'Shravan Kumar', 'shravankumar7907@gmail.com', 1, 'Excellent Service!', 'I\'m really happy with WrenchKing\'s fast and professional service. The team was helpful, and my car was ready on time. Thank you for the great experience and support!', '2025-04-05 06:34:35'),
(2, 'John abraham', 'shravanxd52@gmail.com', 1, 'Emergency Breakdown Help', ' My car broke down on the highway, and WrenchKing reached within 30 minutes. The technician was skilled and fixed the issue on the spot. Amazing emergency service!', '2025-04-05 06:37:32'),
(3, 'sonu', 'sonu@gmail.com', 3, 'Spare Parts Purchase', 'I ordered brake pads and filters through your site. The parts were genuine and delivered on time. Very happy with the product quality and packaging!', '2025-04-05 06:38:14'),
(4, 'David Beckham', 'david@gmail.com', 2, 'Overall Satisfaction', 'I’ve used WrenchKing multiple times and never been disappointed. Their consistency, quality of service, and customer care are truly top-notch. Keep up the good work!', '2025-04-05 06:39:02'),
(5, 'paolo maldini', 'maldini@gmail.com', 3, 'Staff Behavior and Communication', 'The garage staff was friendly and explained every detail of the repair. I appreciate the transparency and honesty. Makes me trust WrenchKing even more.', '2025-04-05 06:40:14');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `c_id` int(11) NOT NULL,
  `sp_id` int(11) NOT NULL,
  `c_name` varchar(255) NOT NULL,
  `c_email` varchar(255) NOT NULL,
  `c_password` varchar(255) NOT NULL,
  `c_phone` varchar(255) NOT NULL,
  `c_address` longtext NOT NULL,
  `c_created_date` date NOT NULL DEFAULT current_timestamp(),
  `c_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`c_id`, `sp_id`, `c_name`, `c_email`, `c_password`, `c_phone`, `c_address`, `c_created_date`, `c_status`) VALUES
(2, 2, 'sonu', 'sonu@gmail.com', 'Sonu123', '9633360299', '', '2025-02-17', 'Active'),
(3, 3, 'David Beckham', 'david@gmail.com', 'David234', '123456789', '', '2025-02-20', 'Active'),
(7, 2, 'paolo maldini', 'maldini@gmail.com', 'maldiniCB3', '2587413960', '', '2025-03-13', 'Active'),
(9, 1, 'Tony Stark', 'knoxshraone@gmail.com', 'Tonystark33', '7907899186', '', '2025-03-23', 'Active'),
(11, 1, 'bellari raja', 'sshravanxd52@gmail.com', 'BenzRaja123', '5434656454', '', '2025-03-23', 'Active'),
(12, 2, 'John abraham', 'ssshravanxd52@gmail.com', 'Shra17907', '7907899186', '', '2025-03-29', 'Active'),
(21, 1, 'Shravan Kumar', 'shravankumar7907@gmail.com', 'Shravankumar7907', '7907899186', 'k.k pala kanyapaddy house p/o nirchal', '2025-04-03', 'Active'),
(22, 2, 'Fernando Torres', 'shravanxd52@gmail.com', 'FernandoT7907', '9654551516', '', '2025-04-20', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `emergency_services`
--

CREATE TABLE `emergency_services` (
  `es_id` int(11) NOT NULL,
  `sp_id` int(11) NOT NULL,
  `es_title` varchar(255) NOT NULL,
  `es_picture` varchar(255) NOT NULL,
  `es_description` varchar(255) NOT NULL,
  `es_price` varchar(255) NOT NULL,
  `s_id` int(11) NOT NULL,
  `es_created_date` date NOT NULL DEFAULT current_timestamp(),
  `es_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emergency_services`
--

INSERT INTO `emergency_services` (`es_id`, `sp_id`, `es_title`, `es_picture`, `es_description`, `es_price`, `s_id`, `es_created_date`, `es_status`) VALUES
(1, 1, 'Flat Tire Replacement', 'uploads/tire.png', 'Got a flat? We will replace it with your spare or repair it on-site', '200', 0, '2025-02-27', 'Available'),
(2, 1, 'Battery Jump-Start', 'uploads/car-battery.png', 'Dead battery? Our experts will jump-start your vehicle instantly.', '120', 0, '2025-02-27', 'Available'),
(3, 1, 'Towing Service', 'uploads/tow-truck.png', 'We provide safe and fast towing to the nearest service station.', '300', 0, '2025-02-27', 'Available'),
(4, 2, 'Engine Diagnostics', 'uploads/engine.png', 'Diagnose engine issues, sensor faults, misfires, and transmission problems.\r\n', '200', 0, '2025-02-27', 'Available'),
(5, 2, 'Coolant or Overheating Fix', 'uploads/thermometer.png', 'Help with an overheated engine or low coolant levels.\r\n', '150', 0, '2025-02-27', 'Available'),
(6, 1, 'Lockout Service', 'uploads/car-rental.png', 'Our mechanics safely unlock vehicles using professional tools, quick and damage-free service.', '80', 0, '2025-02-27', 'Available'),
(7, 3, 'Tire puncture repair', 'uploads/transport.png', 'Quick on-site tire puncture repair to get you back on the road. Includes patching, sealing leaks, and pressure checks for safety.', '130', 0, '2025-03-31', 'Available'),
(8, 3, 'Electrical & Minor Engine Fixes', 'uploads/broken-wire.png', 'On-site repair of loose wires or minor engine issues, ensuring quick fixes for ignition, battery, or electrical faults to restore functionality.', '100', 0, '2025-03-31', 'Available'),
(9, 3, 'Spare tire replacement', 'uploads/automotive.png', 'Swift spare tire replacement to ensure a safe and smooth ride. Our experts will install your spare and check tire pressure.', '75', 0, '2025-03-31', 'Available'),
(10, 2, 'Spare tire replacement', 'uploads/automotive.png', 'Quick spare tire replacement for a safe and smooth journey ahead.', '80', 0, '2025-03-31', 'Available'),
(11, 2, 'Battery Jump-Start', 'uploads/car-battery (1).png', 'Instant jump-start service to revive dead batteries and get you moving.', '100', 0, '2025-03-31', 'Available'),
(12, 3, 'Towing Service', 'uploads/tow-truck (1).png', 'Reliable car towing service to safely transport your vehicle to the nearest garage or preferred location in case of breakdowns or accidents.', '280', 0, '2025-03-31', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `e_booking`
--

CREATE TABLE `e_booking` (
  `eb_id` int(11) NOT NULL,
  `eb_date` date NOT NULL DEFAULT current_timestamp(),
  `es_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `c_phone` int(11) NOT NULL,
  `eb_location` varchar(255) NOT NULL,
  `eb_location_link` varchar(255) NOT NULL,
  `eb_message` varchar(255) NOT NULL,
  `eb_status` varchar(50) DEFAULT 'Pending',
  `eb_updated_date` date NOT NULL DEFAULT current_timestamp(),
  `eb_payment_mode` varchar(255) NOT NULL,
  `eb_amount` int(11) NOT NULL,
  `eb_transaction_id` bigint(20) NOT NULL,
  `eb_payment_status` varchar(255) NOT NULL,
  `eb_feedback` longtext NOT NULL,
  `eb_car` varchar(255) NOT NULL,
  `eb_model` varchar(255) NOT NULL,
  `vehicle_number` varchar(15) NOT NULL,
  `assigned_worker_id` int(11) DEFAULT NULL,
  `eb_notes` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `e_booking`
--

INSERT INTO `e_booking` (`eb_id`, `eb_date`, `es_id`, `c_id`, `c_phone`, `eb_location`, `eb_location_link`, `eb_message`, `eb_status`, `eb_updated_date`, `eb_payment_mode`, `eb_amount`, `eb_transaction_id`, `eb_payment_status`, `eb_feedback`, `eb_car`, `eb_model`, `vehicle_number`, `assigned_worker_id`, `eb_notes`) VALUES
(1, '2025-04-16', 2, 21, 2147483647, 'kasargod', 'https://maps.app.goo.gl/DFDinaBoyh4FJTSMA', '', 'Completed', '2025-04-25', '', 0, 0, 'Verified', '', 'maruti', '800', 'KL14G6680', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `or_id` int(11) NOT NULL,
  `or_date` datetime DEFAULT current_timestamp(),
  `c_id` int(11) NOT NULL,
  `or_name` varchar(255) NOT NULL,
  `or_email` varchar(255) NOT NULL,
  `or_phone` varchar(255) NOT NULL,
  `or_city` varchar(255) NOT NULL,
  `or_pin` int(11) NOT NULL,
  `or_address` longtext NOT NULL,
  `or_alternative_phone` varchar(255) NOT NULL,
  `or_state` varchar(255) NOT NULL,
  `or_landmark` varchar(255) NOT NULL,
  `or_status` varchar(255) NOT NULL,
  `or_updated_date` date NOT NULL DEFAULT current_timestamp(),
  `or_payment_status` varchar(255) NOT NULL,
  `or_payment_method` varchar(255) NOT NULL,
  `or_transaction_id` varchar(255) NOT NULL,
  `or_feedback` varchar(255) NOT NULL,
  `or_received` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`or_id`, `or_date`, `c_id`, `or_name`, `or_email`, `or_phone`, `or_city`, `or_pin`, `or_address`, `or_alternative_phone`, `or_state`, `or_landmark`, `or_status`, `or_updated_date`, `or_payment_status`, `or_payment_method`, `or_transaction_id`, `or_feedback`, `or_received`) VALUES
(1, '2025-04-29 00:00:00', 21, 'Shravan Kumar', ' shravankumar7907@gmail.com', ' 7907899186', '   Kasargod', 671321, ' k.k pala kanyapaddy house p/o nirchal', ' 1234567899', 'Kerala', '  ', 'Dispatched', '2025-04-29', 'Verified', 'UPI', '542486210215', '', 0),
(2, '2025-04-29 00:00:00', 21, 'Shravan Kumar', 'shravankumar7907@gmail.com', '7907899186', 'Kasargod', 671321, 'k.k pala kanyapaddy house p/o nirchal', '1234567899', 'Kerala', '', 'Placed', '2025-04-29', 'Pending', 'RazorPay', 'pay_QOlRrK466SKJJS', '', 0),
(3, '2025-05-04 00:00:00', 21, 'Shravan Kumar', 'shravankumar7907@gmail.com', '7907899186', 'Nirchal', 671321, '513', '', 'Kerala', '', 'Placed', '2025-05-04', 'Pending', 'RazorPay', 'pay_QQjfaJUkD5wMLa', '', 0),
(4, '2025-05-09 00:00:00', 21, 'Shravan Kumar', ' shravankumar7907@gmail.com', ' 7907899186', '   Kasargod', 671321, ' Nirchal, Kasargod, Kerala', ' ', 'Kerala', '  ', 'Placed', '2025-05-09', 'Pending', 'UPI', '147258369147', '', 0),
(5, '2025-05-09 00:00:00', 21, 'Shravan Kumar', 'shravankumar7907@gmail.com', '7907899186', 'Kasargod', 671321, 'k.k pala kanyapaddy house p/o nirchal', '1234567899', 'Kerala', '', 'Placed', '2025-05-09', 'Pending', 'RazorPay', 'pay_QSgRTjO73qTQLa', '', 0),
(6, '2025-05-09 09:05:20', 21, 'Shravan Kumar', ' shravankumar7907@gmail.com', ' 7907899186', '   Kasargod', 671321, ' k.k pala kanyapaddy house p/o nirchal', ' 1234567899', 'Kerala', '  ', 'Placed', '2025-05-09', 'Pending', 'UPI', '147258369147', '', 0),
(7, '2025-05-09 09:06:19', 21, 'Shravan Kumar', 'shravankumar7907@gmail.com', '7907899186', 'Kasargod', 671321, 'k.k pala kanyapaddy house p/o nirchal', '', 'Kerala', '', 'Placed', '2025-05-09', 'Pending', 'RazorPay', 'pay_QSgTdfLCxA4lL5', '', 0),
(8, '2025-05-09 09:13:02', 21, 'Shravan Kumar', ' shravankumar7907@gmail.com', ' 7907899186', '   Kasargod', 671321, ' Nirchal, Kasargod, Kerala', ' ', 'Kerala', '  ', 'Placed', '2025-05-09', 'Pending', 'UPI', '123456789123', '', 0),
(9, '2025-05-09 09:18:47', 21, 'Shravan Kumar', ' shravankumar7907@gmail.com', ' 7907899186', '   Kasargod', 671321, ' Nirchal', ' ', 'Kerala', '  ', 'Placed', '2025-05-09', 'Pending', 'UPI', '123456789444', '', 0),
(10, '2025-05-09 09:20:16', 21, 'Shravan Kumar', ' shravankumar7907@gmail.com', ' 7907899186', '   Kasargod', 671321, ' k.k pala kanyapaddy house p/o nirchal', ' ', 'Kerala', '  ', 'Placed', '2025-05-09', 'Pending', 'UPI', '123456789444', '', 0),
(11, '2025-05-09 09:20:51', 21, 'Shravan Kumar', 'shravankumar7907@gmail.com', '7907899186', 'Kasargod', 671321, 'k.k pala kanyapaddy house p/o nirchal', '1234567899', 'Kerala', '', 'Placed', '2025-05-09', 'Pending', 'RazorPay', 'pay_QSgj0xv6tPZ4Kh', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ordered_products`
--

CREATE TABLE `ordered_products` (
  `op_id` int(11) NOT NULL,
  `or_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `op_quantity` varchar(255) NOT NULL,
  `op_amount` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ordered_products`
--

INSERT INTO `ordered_products` (`op_id`, `or_id`, `p_id`, `op_quantity`, `op_amount`) VALUES
(1, 1, 7, '2', '1460'),
(2, 2, 20, '1', '2260'),
(3, 3, 3, '1', '460'),
(4, 4, 2, '1', '240'),
(5, 5, 2, '1', '240'),
(6, 5, 13, '1', '1070'),
(7, 6, 2, '1', '240'),
(8, 6, 13, '1', '1070'),
(9, 7, 3, '1', '460'),
(10, 7, 7, '1', '735'),
(11, 8, 2, '1', '240'),
(12, 9, 2, '1', '240'),
(13, 10, 2, '1', '240'),
(14, 11, 2, '1', '240');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `expires_at`) VALUES
(17, 'shravankumar7907@gmail.com', '7e773ff21bba2cdb295a71e06840b265da77b9e1af70a05778a28a09518ca7dae3885aaa5c055ace2882a65e4a12dcc56e31', '2025-04-24 20:06:52');

-- --------------------------------------------------------

--
-- Table structure for table `pending_customers`
--

CREATE TABLE `pending_customers` (
  `email` varchar(100) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `otp` varchar(10) DEFAULT NULL,
  `sp_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `p_id` int(11) NOT NULL,
  `sp_id` int(11) NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `p_image` varchar(255) NOT NULL,
  `p_description` longtext NOT NULL,
  `p_price` varchar(255) NOT NULL,
  `p_stock` varchar(255) NOT NULL,
  `p_date` date NOT NULL DEFAULT current_timestamp(),
  `p_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`p_id`, `sp_id`, `p_name`, `p_image`, `p_description`, `p_price`, `p_stock`, `p_date`, `p_status`) VALUES
(1, 1, 'Spark Plug', 'uploads/sparkplug.webp', 'Ignites the air-fuel mixture, ensuring efficient combustion and engine performance.', '230', '0', '2025-02-22', 'Available'),
(2, 2, 'Brake Pads', 'uploads/brakepads.jpg', 'Provides friction to stop the vehicle safely, ensuring reliable braking performance.', '230', '7', '2025-02-25', 'Available'),
(3, 1, 'Timing Belt', 'uploads/belt.jpg', 'Transmits power to engine accessories like alternator, water pump, and AC.', '450', '0', '2025-02-25', 'Available'),
(4, 1, 'Oil filter Kit', 'uploads/oilfilter.jpg', 'Removes contaminants from engine oil, ensuring clean lubrication and performance.', '600', '0', '2025-02-25', 'Available'),
(5, 1, 'V-belt', 'uploads/V-beltt.png', 'Transfers power to engine accessories, ensuring efficient and smooth operation.\r\n', '340', '-5', '2025-02-25', 'Available'),
(6, 1, 'Brake Fluids', 'uploads/brake fluids.jpg', 'Brake fluid flush with top-up, system check, and safety inspection.', '205.00', '6', '2025-02-27', 'Available'),
(7, 1, 'Universal Symphony Fanfare Trumpet Horn (Set of 2)', 'uploads/bosch horn universal.jpg', 'Loud and durable 12V Bosch horn set for all vehicles.', '725', '0', '2025-03-25', 'Available'),
(8, 3, 'Universal Europa Disc Horn (Set of 2)', 'uploads/europa_disc_horn.png', 'Powerful 12V Europa Disc Horn set for clear, loud sound.', '2300', '4', '2025-03-25', 'Available'),
(9, 3, 'Spark Plug', 'uploads/sparkplug.webp', 'Ignites the air-fuel mixture, ensuring efficient combustion and engine performance.', '210', '12', '2025-03-25', 'Available'),
(10, 3, 'V-Belt', 'uploads/V-beltt.png', 'Transfers power to engine accessories, ensuring efficient and smooth operation.', '205', '7', '2025-03-25', 'Available'),
(11, 3, 'Oil Filter Kit', 'uploads/oilfilter.jpg', 'Removes contaminants from engine oil, ensuring clean lubrication and performance.', '595', '9', '2025-03-25', 'Available'),
(12, 3, 'Engine Oil 5W-30 (3L) ', 'uploads/SHELL HELIX HX5 AZ.jpg', '(Shell Helix HX5 AZ MGO Premium Multigrade Oil). \r\nHigh-performance 5W-30 engine oil for smooth and efficient running.', '1070', '6', '2025-03-25', 'Available'),
(13, 2, 'Engine Oil 5W-30 (3L)', 'uploads/SHELL HELIX HX5 AZ.jpg', ' (Shell Helix HX5 AZ MGO Premium Multigrade Oil). \r\nHigh-performance 5W-30 engine oil for smooth and efficient running.', '1060', '3', '2025-03-25', 'Available'),
(14, 2, 'Engine Oil 10W-40 (1L)', 'uploads/Hella_oil.png', ' (Cool Maker Fully Synthetic Oil). \r\nHigh-performance 10W-40 engine oil for smooth and efficient running.', '535', '4', '2025-03-25', 'Available'),
(15, 2, 'Dot 4 Synthetic Racing Brake Fluid(355ml)', 'uploads/AMSOIL.jpg', 'High-performance DOT 4 synthetic brake fluid for superior braking efficiency.', '1010', '5', '2025-03-25', 'Available'),
(16, 2, 'Wiper Blade Set (22\"/16\")', 'uploads/wiper_blade set 22-16.png', 'Durable wiper blade set (22\"/16\") for clear visibility.', '555', '0', '2025-03-25', 'Available'),
(17, 2, 'Universal S-90 Electric Disc Horn (Set of 2)', 'uploads/S-90 electric disc.jpg', 'Loud and reliable S-90 electric disc horn set for all vehicles.', '540', '6', '2025-03-25', 'Available'),
(18, 2, 'Wiper Blade 26\"', 'uploads/wiper blades bosch 26s.jpg', 'Durable 26\" wiper blade for clear and streak-free visibility.', '880', '5', '2025-03-25', 'Available'),
(19, 3, 'Wiper Blade 24\"', 'uploads/wiper blade bosch 24s.jpg', 'Durable 24\" wiper blade for clear and streak-free visibility.', '850', '4', '2025-03-25', 'Available'),
(20, 1, 'Engine Oil 5W-30 (3.5L)', 'uploads/SHELL HELIX HX8 FULLY.JPG', '(Shell Helix HX8 Fully Synthetic Motor Oil). \r\nPremium 5W-30 fully synthetic engine oil for smooth performance.', '2250', '3', '2025-03-25', 'Available'),
(21, 3, 'High Pitch Horn', 'uploads/high_pitch_horn.png', 'Loud and clear high-pitch horn for enhanced road safety.', '1500', '5', '2025-03-25', 'Available'),
(22, 3, 'Oil Filter', 'uploads/oilfilter21.png', 'Efficient oil filter for optimal engine protection and performance.', '190', '8', '2025-03-25', 'Available'),
(23, 2, 'Timing Belt', 'uploads/Timing_Belt.png', 'Durable timing belt ensures precise engine timing and smooth performance.', '900', '6', '2025-03-25', 'Available'),
(24, 1, 'Air Filter', 'uploads/airfilter.png', 'High-quality air filter for improved engine performance and efficiency.', '540', '0', '2025-03-25', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `s_id` int(11) NOT NULL,
  `sp_id` int(11) NOT NULL,
  `s_title` varchar(255) NOT NULL,
  `s_image` varchar(255) NOT NULL,
  `s_price` varchar(255) NOT NULL,
  `s_description` longtext NOT NULL,
  `s_created_date` date NOT NULL DEFAULT current_timestamp(),
  `s_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`s_id`, `sp_id`, `s_title`, `s_image`, `s_price`, `s_description`, `s_created_date`, `s_status`) VALUES
(1, 1, 'Oil Change', 'uploads/service-4.jpg', '330', 'We use high-quality engine oil and premium filters to ensure optimal lubrication, reduce wear and tear, improve fuel efficiency, and extend engine lifespan.', '2025-02-27', 'Available'),
(2, 1, 'Denting and Painting', 'uploads/denting-painting.jpg', '1450', 'Professional denting and painting service restores your car’s original look by fixing dents, scratches, and applying a high-quality paint finish.', '2025-03-06', 'Available'),
(3, 2, 'Denting and Painting', 'uploads/shot-professional-repairman-preparing-vehicle-new-paint.jpg', '1500', 'Professional denting and painting service restores your car’s original look by fixing dents, scratches, and faded paint with precision and quality.', '2025-03-16', 'Available'),
(4, 1, 'Custom Service', 'uploads/maxime-agnelli-HPB0LQGDED4-unsplash.jpg', '500', 'Custom car service offers personalized modifications, performance upgrades, and aesthetic enhancements to match your unique style and driving needs.', '2025-03-25', 'Available'),
(5, 1, 'Engine Decarbonization', 'uploads/joshua-aragon-SlgLD4_drDA-unsplash.jpg', '1000', 'Engine decarbonization removes carbon buildup, reducing engine vibration, improving fuel efficiency, restoring power, and ensuring smoother performance for a longer engine life.', '2025-03-25', 'Available'),
(6, 3, 'Engine Decarbonization', 'uploads/theo-5W0AASCOViM-unsplash.jpg', '1001', 'Engine decarbonization removes carbon buildup from the engine’s intake, combustion chamber, and exhaust system, improving performance, fuel efficiency, and reducing emissions.', '2025-03-25', 'Available'),
(7, 3, 'Denting and Painting', 'uploads/service-worker-painting-car-auto-service.jpg', '1000', 'Denting and painting services restore your car’s body by fixing dents, scratches, and paint damage, ensuring a smooth, factory-finish look.', '2025-03-28', 'Available'),
(8, 2, 'Oil Change', 'uploads/pexels-daniel-andraski-197681005-13065691.jpg', '600', 'An oil change service replaces old engine oil with fresh, high-quality oil, ensuring optimal engine performance, lubrication, and longevity while improving fuel efficiency.', '2025-03-28', 'Available'),
(9, 2, 'Wheel Alignment', 'uploads/mechanic-working-shop-car.jpg', '1200', 'Wheel alignment ensures that your car’s wheels are set at the correct angles, improving stability, tire lifespan, fuel efficiency, and overall driving safety.', '2025-03-28', 'Available'),
(10, 2, 'Transmission Repair ', 'uploads/female-mechanic-holding-spare-parts-car.jpg', '1500', 'Transmission repair involves diagnosing and fixing issues with the gearbox, ensuring smooth gear shifting, improved performance, fuel efficiency, and preventing costly long-term damage.', '2025-03-28', 'Available'),
(11, 3, 'Exhaust System Repair', 'uploads/exhaust.jpg', '2500', 'Exhaust system repair involves fixing leaks, replacing damaged components, and ensuring proper emission control, improving engine efficiency, fuel economy, and reducing harmful pollutants.', '2025-03-28', 'Available'),
(12, 3, 'Brake Repair & Replacement', 'uploads/maxime-agnelli-NM4YfueqpU0-unsplash.jpg', '2450', 'Brake repair and replacement services include inspecting, repairing, or replacing brake pads, rotors, calipers, and fluid, ensuring safe stopping power, smooth braking, and optimal vehicle control.', '2025-03-28', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `service_booking`
--

CREATE TABLE `service_booking` (
  `sb_id` int(11) NOT NULL,
  `sb_date` date NOT NULL DEFAULT current_timestamp(),
  `c_id` int(11) NOT NULL,
  `s_id` int(11) NOT NULL,
  `car_brand` varchar(255) NOT NULL,
  `car_model` varchar(255) NOT NULL,
  `sb_booked_date` date NOT NULL,
  `sb_message` varchar(255) NOT NULL,
  `sb_time` varchar(11) NOT NULL,
  `sb_response` varchar(255) NOT NULL,
  `sb_status` varchar(50) DEFAULT 'Pending',
  `assigned_worker_id` int(11) DEFAULT NULL,
  `exp_date` date DEFAULT NULL,
  `invoice` varchar(255) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `pay_status` varchar(255) NOT NULL,
  `paid_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `t_id` varchar(255) DEFAULT NULL,
  `vehicle_number` varchar(15) NOT NULL,
  `verify` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_booking`
--

INSERT INTO `service_booking` (`sb_id`, `sb_date`, `c_id`, `s_id`, `car_brand`, `car_model`, `sb_booked_date`, `sb_message`, `sb_time`, `sb_response`, `sb_status`, `assigned_worker_id`, `exp_date`, `invoice`, `total_amount`, `pay_status`, `paid_at`, `t_id`, `vehicle_number`, `verify`) VALUES
(1, '2025-05-04', 21, 2, 'maruti', 'ritz', '2025-05-14', '', '09:00:00', '', 'Completed', 0, '2025-05-17', 'C:xampphtdocswrenchkingadmin/invoices/invoice_1.pdf', 1450.00, 'Paid', '2025-05-04 06:07:45', '342432434242', 'KL14G7769', 0),
(2, '2025-05-04', 21, 5, 'renault', 'duster', '2025-05-06', '', '09:00:00', '', 'Completed', 0, '2025-05-08', 'C:xampphtdocswrenchkingadmin/invoices/invoice_2.pdf', 1000.00, 'Paid', '2025-05-04 06:07:45', '454425245425', 'KL14G2345', 1),
(3, '2025-05-04', 21, 1, 'mahindra', 'thar', '2025-05-06', '', '01:30:00', '', 'Approved', 0, '0000-00-00', 'C:xampphtdocswrenchkingadmin/invoices/invoice_3.pdf', 330.00, 'Paid', '2025-05-04 06:14:25', '132564435616', 'KL60G7999', 0),
(4, '2025-05-09', 21, 2, 'nissan', 'micra', '2025-05-19', '', '10:30 AM', '', 'Approved', 3, '0000-00-00', NULL, 0.00, '', '2025-05-09 04:24:42', NULL, 'KL60F9786', 0),
(5, '2025-05-11', 21, 2, 'toyota', 'glanza', '2025-05-12', '', '', '', 'Pending', NULL, NULL, NULL, 0.00, '', '2025-05-11 05:54:31', NULL, 'KL60F9999', 0);

-- --------------------------------------------------------

--
-- Table structure for table `s_provider`
--

CREATE TABLE `s_provider` (
  `sp_id` int(11) NOT NULL,
  `sp_name` varchar(255) NOT NULL,
  `sp_email` varchar(255) NOT NULL,
  `sp_phone` varchar(255) NOT NULL,
  `sp_password` varchar(255) NOT NULL,
  `sp_address` longtext NOT NULL,
  `sp_created-date` date NOT NULL DEFAULT current_timestamp(),
  `sp_status` varchar(255) NOT NULL,
  `sp_profile_picture` varchar(255) NOT NULL,
  `sp_qrcode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `s_provider`
--

INSERT INTO `s_provider` (`sp_id`, `sp_name`, `sp_email`, `sp_phone`, `sp_password`, `sp_address`, `sp_created-date`, `sp_status`, `sp_profile_picture`, `sp_qrcode`) VALUES
(1, 'WK Adkathbail', 'wrenchkingadk@gmail.com', '9876543210', 'wrench@adk', 'Adkathbail, Kasaragod', '2025-02-19', '', 'uploads/settings.png', 'uploads/qrcode_branch1.jpg'),
(2, 'WK Kumbla', 'wrenchkingkmb@gmail.com', '1234567890', 'wrench@kmb', 'Kumbla,Kasargod', '2025-02-19', '', 'uploads/admin.png', 'uploads/qrcode_branch2.jpg'),
(3, 'WK Nileshwar', 'wrenchkingnle@gmail.com', '1234567890', 'wrench@nle', 'Nileshwar,Kasargod', '2025-02-19', '', 'uploads/businessman.png', 'uploads/qrcode_branch3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `workers`
--

CREATE TABLE `workers` (
  `w_id` int(11) NOT NULL,
  `sp_id` int(11) NOT NULL,
  `w_name` varchar(255) NOT NULL,
  `w_status` enum('available','assigned') DEFAULT 'available',
  `w_phone` varchar(255) NOT NULL,
  `added_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workers`
--

INSERT INTO `workers` (`w_id`, `sp_id`, `w_name`, `w_status`, `w_phone`, `added_date`) VALUES
(2, 1, 'Shravan Kumar', 'available', '7907899186', '2025-03-18'),
(3, 1, 'Sonu Madhukumar', 'assigned', '9633360299', '2025-03-18'),
(4, 1, 'Messi', 'available', '9656276140', '2025-03-21'),
(5, 1, 'Ronaldo', 'available', '1597534682', '2025-03-21'),
(6, 1, 'Neymar', 'available', '3256897410', '2025-03-21'),
(7, 1, 'David Beckham', 'available', '7894561230', '2025-03-22'),
(8, 1, 'Peter Parker', 'available', '2581479632', '2025-03-22'),
(9, 1, 'Tony Stark', 'available', '9856214789', '2025-03-22'),
(10, 1, 'John Abraham', 'available', '9875621034', '2025-03-22'),
(11, 1, 'Rodrygo', 'available', '6845214750', '2025-03-22'),
(12, 2, 'Liam Anderson', 'available', '9876543210', '2025-03-28'),
(13, 2, 'Benjamin Müller', 'available', '9765432109', '2025-03-28'),
(14, 2, 'Carlos Fernandes', 'available', '9654321098', '2025-03-28'),
(15, 2, 'David Anderson', 'available', '9543210987', '2025-03-28'),
(16, 2, 'Elijah Brown', 'available', '9432109876', '2025-03-28'),
(17, 2, 'Felix Hoffmann', 'available', '9321098765', '2025-03-28'),
(18, 2, 'Giovanni Russo', 'available', '9210987654', '2025-03-28'),
(19, 2, 'Hiroshi Takahashi', 'available', '9109876543', '2025-03-28'),
(20, 2, 'Ismail Al-Farsi', 'available', '9998765432', '2025-03-28'),
(21, 2, 'Javier Morales', 'available', '9887654321', '2025-03-28'),
(22, 3, 'Kai Schmidt', 'available', '9776543210', '2025-03-28'),
(23, 3, 'Noah Svensson', 'available', '9443210987', '2025-03-28'),
(24, 3, 'Mateo Gonzalez', 'available', '9554321098', '2025-03-28'),
(25, 3, 'Omar Ibrahim', 'available', '9332109876', '2025-03-28'),
(26, 3, 'Pablo Martinez', 'available', '9221098765', '2025-03-28'),
(27, 3, 'Quentin Dubois', 'available', '9110987654', '2025-03-28'),
(28, 3, 'Rafael Mendes', 'available', '9009876543', '2025-03-28'),
(29, 3, 'Samuel Johansson', 'available', '9898765432', '2025-03-28'),
(30, 3, 'Tariq Aziz', 'available', '9787654321', '2025-03-28'),
(31, 3, 'Liam Connor', 'available', '9665432109', '2025-03-28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`ct_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `emergency_services`
--
ALTER TABLE `emergency_services`
  ADD PRIMARY KEY (`es_id`);

--
-- Indexes for table `e_booking`
--
ALTER TABLE `e_booking`
  ADD PRIMARY KEY (`eb_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`or_id`);

--
-- Indexes for table `ordered_products`
--
ALTER TABLE `ordered_products`
  ADD PRIMARY KEY (`op_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pending_customers`
--
ALTER TABLE `pending_customers`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `service_booking`
--
ALTER TABLE `service_booking`
  ADD PRIMARY KEY (`sb_id`);

--
-- Indexes for table `s_provider`
--
ALTER TABLE `s_provider`
  ADD PRIMARY KEY (`sp_id`);

--
-- Indexes for table `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`w_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `ct_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `emergency_services`
--
ALTER TABLE `emergency_services`
  MODIFY `es_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `e_booking`
--
ALTER TABLE `e_booking`
  MODIFY `eb_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `or_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ordered_products`
--
ALTER TABLE `ordered_products`
  MODIFY `op_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `service_booking`
--
ALTER TABLE `service_booking`
  MODIFY `sb_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `s_provider`
--
ALTER TABLE `s_provider`
  MODIFY `sp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1004;

--
-- AUTO_INCREMENT for table `workers`
--
ALTER TABLE `workers`
  MODIFY `w_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
