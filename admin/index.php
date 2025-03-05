<?php
session_start();
include '../includes/db.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Care Compass Hospitals</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <section class="admin-dashboard">
        <h1>Admin Dashboard</h1>
        <nav>
            <ul>
                <li><a href="manage_staff.php">Manage Staff</a></li>
                <li><a href="manage_services.php">Manage Services</a></li>
                <li><a href="manage_queries.php">Manage Queries</a></li>
                <li><a href="manage_feedback.php">Manage Feedback</a></li>
                <li><a href="manage_Patients.php">Manage Patients</a></li>
                <li><a href="manage_Appointments.php">Manage Appointments</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </section>

    <?php include '../includes/footer.php'; ?>
</body>
</html>