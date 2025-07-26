WRENCHKING - Online Garage Service Platform
===========================================

📌 Project Description:
WRENCHKING is a web-based platform that allows users to book four-wheeler services, request emergency help, purchase spare parts, and track service history. The system supports customer, service provider, and admin roles.

🛠 Tech Stack:
- HTML, CSS, Bootstrap
- JavaScript
- PHP (Backend)
- MySQL (Database)
- Razorpay (Payment Gateway)
- PHPMailer (OTP verification)
- DomPDF (PDF invoice generation)

🔑 Key Features:
- Car service booking (normal & emergency)
- OTP email verification during registration
- Spare parts and accessories purchase
- Service provider can assign workers to bookings
- Worker availability management
- Admin dashboard with revenue reports
- Razorpay-based online payment
- PDF invoice generation and email delivery
- Customer feedback and rating system

💻 Installation Steps:
1. Download and install [XAMPP](https://www.apachefriends.org/index.html)
2. Open XAMPP Control Panel and start **Apache** and **MySQL**
3. Copy the project folder `wrenchking` into `C:\xampp\htdocs\`
4. Open your browser and go to `http://localhost/phpmyadmin`
5. Create a new database named: `wrenchking`
6. Import the `wrenchking.sql` file (included in the project) into the database
7. Open the project in your browser: `http://localhost/wrenchking/`
8. Edit database connection if needed in `dbcon.php`:
   - `$con = mysqli_connect("localhost", "root", "", "wrenchking");`

🚀 How to Run Locally:
1. Install XAMPP or any PHP server environment.
2. Clone or download this project to `C:\xampp\htdocs\wrenchking`
3. Start Apache and MySQL from XAMPP Control Panel.
4. Create a new MySQL database named `wrenchking`
5. Import the provided `wrenchking.sql` file in phpMyAdmin.
6. Open browser and go to `http://localhost/wrenchking/`

⚙️ Database Configuration:
- File: `dbcon.php`
- Set your MySQL username (`root`) and password (usually empty)

📁 Folder Structure Overview:
- `customer/` - Customer dashboard and features
- `admin/` - Admin panel
- `sp/` - Service provider panel
- `assets/` - Images, JS, CSS
- `invoices/` - Generated PDF invoices

📝 Notes:
This project was developed as part of a personal learning journey in web development and backend integration.
