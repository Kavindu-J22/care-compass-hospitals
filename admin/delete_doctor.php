<?php
session_start();
include '../includes/db.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Get the doctor ID from the URL
if (!isset($_GET['id'])) {
    echo "<p>Error: Doctor ID not provided.</p>";
    exit();
}
$doctor_id = $_GET['id'];

// Handle deletion
try {
    $sql = "DELETE FROM doctors WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $doctor_id);
    $stmt->execute();

    echo "<p>Doctor deleted successfully!</p>";
} catch (PDOException $e) {
    if ($e->getCode() == '23000') { // 23000 is the SQLSTATE code for integrity constraint violation
        echo "<p>Can't delete because this Staff Member is still currently being used in some places.</p>";
    } else {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Doctor - Care Compass Hospitals</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <section class="delete-doctor">
        <h1>Delete Doctor</h1>
        <p>Are you sure you want to delete this doctor?</p>
        <form method="POST" action="">
            <button type="submit" name="confirm" value="yes">Yes, Delete</button>
            <a href="manage_doctors.php" class="btn">No, Go Back</a>
        </form>
    </section>

    <?php include '../includes/footer.php'; ?>
</body>
</html>