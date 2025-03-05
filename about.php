<?php
session_start(); // Start the session
include 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Care Compass Hospitals</title>
    <link rel="stylesheet" href="assets/css/about.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <!-- About Hero Section -->
    <section class="about-hero">
        <div class="about-hero-content">
            <h1>About Care Compass Hospitals</h1>
            <p>Your trusted partner in healthcare. We are dedicated to providing world-class medical services with compassion and innovation.</p>
        </div>
        <div class="about-hero-image">
            <img src="assets/images/Logo.png" alt="Care Compass Hospitals">
        </div>
    </section>

    <!-- Mission and Vision Section -->
    <section class="mission-vision">
        <div class="mission">
            <h2>Our Mission</h2>
            <p>To deliver exceptional healthcare services that improve the lives of our patients and communities through innovation, compassion, and excellence.</p>
            <img src="assets/images/mission-icon.png" alt="Mission Icon">
        </div>
        <div class="vision">
            <h2>Our Vision</h2>
            <p>To be the leading healthcare provider in Sri Lanka, recognized for our commitment to patient-centered care and cutting-edge medical technology.</p>
            <img src="assets/images/vision-icon.png" alt="Vision Icon">
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="our-story">
        <h2>Our Story</h2>
        <p>Care Compass Hospitals was founded in 2005 with a vision to revolutionize healthcare in Sri Lanka. Over the years, we have grown into a network of state-of-the-art hospitals, offering a wide range of medical services to patients across the country.</p>
        <div class="story-images">
            
            <img src="assets/images/story-2.jpg" alt="Our Story Image 2">
        </div>
    </section>

    <!-- Our Team Section -->
    <section class="our-team">
        <h2>Our Team</h2>
        <p>Our team of highly qualified doctors, nurses, and healthcare professionals is dedicated to providing the best possible care to our patients.</p>
        <div class="team-grid">
            <div class="team-member">
                <img src="assets/images/doctor-1.jpg" alt="Doctor 1">
                <h3>Dr. John Doe</h3>
                <p>Chief Medical Officer</p>
            </div>
            <div class="team-member">
                <img src="assets/images/doctor-2.jpg" alt="Doctor 2">
                <h3>Dr. Jane Smith</h3>
                <p>Head of Cardiology</p>
            </div>
            <div class="team-member">
                <img src="assets/images/doctor-3.jpg" alt="Doctor 3">
                <h3>Dr. David Brown</h3>
                <p>Head of Surgery</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
</body>
</html>