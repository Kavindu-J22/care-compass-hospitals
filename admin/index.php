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
    <link rel="stylesheet" href="../assets/css/adminDB.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Admin Dashboard Hero Section -->
    <section class="admin-dashboard-hero">
        <div class="admin-dashboard-hero-content">
            <h1>Welcome to the Admin Dashboard</h1>
            <p>Manage all aspects of Care Compass Hospitals efficiently and effectively.</p>
        </div>
        
    </section>

    <!-- Admin Dashboard Navigation Section -->
    <section class="admin-dashboard-navigation">
        <h2>Quick Links</h2>
        <div class="navigation-grid">

        <a href="../index.php" class="navigation-card">
                <img src="../assets/images/Logo.png" alt="Manage Staff">
                <h3>Home</h3>
                <p>Add, update, or remove staff members.</p>
            </a>

            <a href="manage_staff.php" class="navigation-card">
                <img src="../assets/images/ad-staff-icon.png" alt="Manage Staff">
                <h3>Manage Staff</h3>
                <p>Add, update, or remove staff members.</p>
            </a>
            <a href="manage_services.php" class="navigation-card">
                <img src="../assets/images/services-iocn.png" alt="Manage Services">
                <h3>Manage Services</h3>
                <p>Add, update, or remove hospital services.</p>
            </a>
            <a href="manage_queries.php" class="navigation-card">
                <img src="../assets/images/queries-icon.png" alt="Manage Queries">
                <h3>Manage Queries</h3>
                <p>View and respond to patient queries.</p>
            </a>
            <a href="manage_feedback.php" class="navigation-card">
                <img src="../assets/images/feedback-icon.png" alt="Manage Feedback">
                <h3>Manage Feedback</h3>
                <p>View and analyze patient feedback.</p>
            </a>
            <a href="manage_Patients.php" class="navigation-card">
                <img src="../assets/images/patients-icon.png" alt="Manage Patients">
                <h3>Manage Patients</h3>
                <p>View and manage patient records.</p>
            </a>
            <a href="manage_Appointments.php" class="navigation-card">
                <img src="../assets/images/appointments-icon.png" alt="Manage Appointments">
                <h3>Manage Appointments</h3>
                <p>View and manage patient appointments.</p>
            </a>
            <a href="../logout.php" class="navigation-card">
                <img src="../assets/images/logout-icon.png" alt="Logout">
                <h3>Logout</h3>
                <p>Log out of the admin dashboard.</p>
            </a>
        </div>
    </section>
</body>
</html>