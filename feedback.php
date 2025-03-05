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
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <section class="feedback">
        <h1>Feedback</h1>
        <form method="POST" action="">
            <input type="number" name="rating" min="1" max="5" placeholder="Rating (1-5)" required>
            <textarea name="comment" placeholder="Your feedback" required></textarea>
            <button type="submit">Submit Feedback</button>
        </form>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>