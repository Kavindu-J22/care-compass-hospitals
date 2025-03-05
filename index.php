<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Care Compass Hospitals</title>
    <link rel="stylesheet" href="assets/css/home.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Welcome to Care Compass Hospitals</h1>
            <p>Your health, our priority. We provide world-class medical care with compassion and cutting-edge technology.</p>
            <div class="hero-buttons">
                <a href="register.php" class="btn-primary">Register Now</a>
                <a href="login.php" class="btn-secondary">Login</a>
            </div>
        </div>
        <div class="hero-image">
            <img src="assets/images/hero-image.png" alt="Care Compass Hospitals">
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <h2>Why Choose Care Compass Hospitals?</h2>
        <p>We are committed to providing exceptional healthcare services to our patients.</p>
        <div class="feature-grid">
            <div class="feature-card">
                <img src="assets/images/emergency-icon.png" alt="Emergency Services">
                <h3>24/7 Emergency Services</h3>
                <p>Our emergency department is open round the clock to provide immediate care when you need it the most.</p>
            </div>
            <div class="feature-card">
                <img src="assets/images/doctor-icon.png" alt="Qualified Doctors">
                <h3>Qualified Doctors</h3>
                <p>Our team of highly skilled and experienced doctors ensures the best medical care for all patients.</p>
            </div>
            <div class="feature-card">
                <img src="assets/images/lab-icon.png" alt="Advanced Labs">
                <h3>Advanced Labs</h3>
                <p>Equipped with state-of-the-art technology, our labs deliver accurate and timely diagnostic results.</p>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section class="about-us">
        <div class="about-content">
            <h2>About Care Compass Hospitals</h2>
            <p>Care Compass Hospitals is a leading healthcare provider dedicated to delivering exceptional medical services. With a focus on patient-centered care, we strive to improve the health and well-being of our community.</p>
            <a href="about.php" class="btn-primary">Learn More</a>
        </div>
        <div class="about-image">
            <img src="assets/images/about-image.jpg" alt="About Us">
        </div>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
</body>
</html>