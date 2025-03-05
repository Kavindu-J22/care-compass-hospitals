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
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <section class="contact">
        <h1>Contact Us</h1>
        <form method="POST" action="">
            <textarea name="query" placeholder="Enter your query" required></textarea>
            <button type="submit">Submit Query</button>
        </form>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>