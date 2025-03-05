<?php
session_start();
include '../includes/db.php';

// Check if user is logged in and is a staff member
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../login.php");
    exit();
}

// Fetch staff details
$staff_id = $_SESSION['user_id'];
try {
    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $staff_id);
    $stmt->execute();
    $staff = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$staff) {
        echo "<p>Error: Staff record not found.</p>";
        exit();
    }
} catch (PDOException $e) {
    echo "<p>Error fetching staff details: " . $e->getMessage() . "</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard - Care Compass Hospitals</title>
    <link rel="stylesheet" href="../assets/css/staffDashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Staff Dashboard Hero Section -->
    <section class="staff-dashboard-hero">
        <div class="staff-dashboard-hero-content">
            <h1>Welcome, <?php echo $staff['username']; ?></h1>
            <p>Manage your tasks and access important information from your dashboard.</p>
        </div>
    </section>

    <!-- Staff Dashboard Navigation Section -->
    <section class="staff-dashboard-navigation">
        <h2>Quick Links</h2>
        <p>Access the tools and information you need to perform your duties efficiently.</p>
        <div class="navigation-grid">
        <a href="../index.php" class="navigation-card">
                <img src="../assets/images/Logo.png" alt="View Appointments">
                <h3>Home</h3>
                <p>Check and manage patient appointments.</p>
            </a>
            <a href="view_appointments.php" class="navigation-card">
                <img src="../assets/images/appointments-icon.png" alt="View Appointments">
                <h3>View Appointments</h3>
                <p>Check and manage patient appointments.</p>
            </a>
            <a href="view_services.php" class="navigation-card">
                <img src="../assets/images/services-iocn.png" alt="View Services">
                <h3>View Services</h3>
                <p>Explore the services offered by the hospital.</p>
            </a>
            <a href="view_queries.php" class="navigation-card">
                <img src="../assets/images/queries-icon.png" alt="View Queries">
                <h3>View Queries</h3>
                <p>Respond to patient queries and concerns.</p>
            </a>
            <a href="../logout.php" class="navigation-card">
                <img src="../assets/images/logout-icon.png" alt="Logout">
                <h3>Logout</h3>
                <p>Log out of your account securely.</p>
            </a>
        </div>
    </section>

</body>
</html>