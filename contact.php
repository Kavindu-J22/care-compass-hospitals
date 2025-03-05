<?php
session_start(); // Start the session
include 'includes/db.php';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo "<p>You must be logged in to submit a query.</p>";
        exit();
    }

    $patient_id = $_SESSION['user_id'];
    $query = $_POST['query'];

    try {
        // Check if the patient exists in the patients table
        $sql = "SELECT id FROM patients WHERE user_id = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $patient_id);
        $stmt->execute();
        $patient = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$patient) {
            echo "<p>Error: Patient record not found. Please contact support.</p>";
            exit();
        }

        // Use prepared statements to prevent SQL injection
        $sql = "INSERT INTO queries (patient_id, query, status) VALUES (:patient_id, :query, 'pending')";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':patient_id', $patient['id']); // Use the patient's ID from the patients table
        $stmt->bindParam(':query', $query);
        $stmt->execute();

        echo "<p>Your query has been submitted successfully.</p>";
    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Care Compass Hospitals</title>
    <link rel="stylesheet" href="assets/css/contact.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Contact Hero Section -->
    <section class="contact-hero">
        <div class="contact-hero-content">
            <h1>Contact Us</h1>
            <p>We’re here to help! Reach out to us for any questions, concerns, or feedback. Our team is ready to assist you.</p>
        </div>
        <div class="contact-hero-image">
            <img src="assets/images/contact-hero.jpg" alt="Care Compass Hospitals Contact">
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="contact-form">
        <h2>Have a Question?</h2>
        <p>Fill out the form below, and we’ll get back to you as soon as possible.</p>
        <form method="POST" action="">
            <textarea name="query" placeholder="Enter your query" required></textarea>
            <button type="submit" class="submit-btn">Submit Query</button>
        </form>
    </section>

    <!-- Contact Information Section -->
    <section class="contact-info">
        <h2>Our Contact Information</h2>
        <div class="info-grid">
            <div class="info-card">
                <img src="assets/images/location-icon.png" alt="Location Icon">
                <h3>Location</h3>
                <p>123 Hospital Road, Colombo, Sri Lanka</p>
            </div>
            <div class="info-card">
                <img src="assets/images/phone-icon.png" alt="Phone Icon">
                <h3>Phone</h3>
                <p>+94 11 123 4567</p>
            </div>
            <div class="info-card">
                <img src="assets/images/email-icon.png" alt="Email Icon">
                <h3>Email</h3>
                <p>info@carecompass.lk</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
</body>
</html>