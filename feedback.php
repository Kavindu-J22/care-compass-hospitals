<?php
session_start(); // Start the session
include 'includes/db.php';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo "<p>You must be logged in to submit feedback.</p>";
        exit();
    }

    $patient_id = $_SESSION['user_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

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
        $sql = "INSERT INTO feedback (patient_id, rating, comment) VALUES (:patient_id, :rating, :comment)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':patient_id', $patient['id']); // Use the patient's ID from the patients table
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':comment', $comment);
        $stmt->execute();

        echo "<p>Thank you for your feedback!</p>";
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
    <title>Feedback - Care Compass Hospitals</title>
    <link rel="stylesheet" href="assets/css/feedback.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Feedback Hero Section -->
    <section class="feedback-hero">
        <div class="feedback-hero-content">
            <h1>We Value Your Feedback</h1>
            <p>Your feedback helps us improve our services and provide better care. Share your experience with us!</p>
        </div>
        <div class="feedback-hero-image">
            <img src="assets/images/feedback-hero.jpg" alt="Care Compass Hospitals Feedback">
        </div>
    </section>

    <!-- Feedback Form Section -->
    <section class="feedback-form">
        <h2>Share Your Experience</h2>
        <p>Please take a moment to rate your experience and provide any comments or suggestions.</p>
        <form method="POST" action="">
            <div class="rating-input">
                <label for="rating">Rating (1-5):</label>
                <input type="number" name="rating" id="rating" min="1" max="5" placeholder="Enter rating (1-5)" required>
            </div>
            <div class="comment-input">
                <label for="comment">Your Feedback:</label>
                <textarea name="comment" id="comment" placeholder="Enter your feedback" required></textarea>
            </div>
            <button type="submit" class="submit-btn">Submit Feedback</button>
        </form>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
</body>
</html>