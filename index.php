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
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <section class="hero">
        <h1>Welcome to Care Compass Hospitals</h1>
        <p>Your health, our priority.</p>
        <a href="register.php" class="btn">Register Now</a>
        <a href="login.php" class="btn">Login</a>
    </section>

    <section class="features">
        <div class="feature">
            <h2>24/7 Emergency Services</h2>
            <p>We are always here for you in emergencies.</p>
        </div>
        <div class="feature">
            <h2>Qualified Doctors</h2>
            <p>Our doctors are highly skilled and experienced.</p>
        </div>
        <div class="feature">
            <h2>Advanced Labs</h2>
            <p>State-of-the-art laboratory facilities.</p>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>