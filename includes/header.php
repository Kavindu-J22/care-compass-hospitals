<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Care Compass Hospitals</title>
    <link rel="stylesheet" href="assets/css/header.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo-container">
                <img src="assets/images/Logo.png" alt="Care Compass Logo" class="logo">
                <h1>Care Compass Hospitals</h1>
            </div>
            <nav>
                <ul class="left-nav">
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
                <ul class="right-nav">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="services.php">Services</a></li>
                    <li><a href="doctors.php">Doctors & Staff</a></li>
                    <li><a href="contact.php">Contact & Send Query</a></li>
                    <li><a href="feedback.php">Feedback</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="dashboard.php">Dashboard</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
</body>
</html>