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
    <title>Delete Doctor & Staff - Care Compass Hospitals</title>
    <link rel="stylesheet" href="../assets/css/deleteStaff.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>


    <!-- Delete Doctor & Staff Hero Section -->
    <section class="delete-doctor-hero">
        <div class="delete-doctor-hero-content">
            <h1>Delete Doctor & Staff</h1>
            <p>Remove a doctor or staff member from the Care Compass Hospitals system. Please confirm your action.</p>
        </div>
    </section>

    <!-- Delete Confirmation Section -->
    <section class="delete-confirmation">
        <h2>Are you sure you want to delete this doctor or staff member?</h2>
        <p>This action cannot be undone. Please confirm your decision.</p>

        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <?php if (isset($success)) { echo "<p class='success'>$success</p>"; } ?>

        <form method="POST" action="">
            <button type="submit" name="confirm" value="yes" class="btn-delete">Yes, Delete</button>
            <a href="manage_doctors.php" class="btn-secondary">No, Go Back</a>
        </form>
    </section>

</body>
</html>