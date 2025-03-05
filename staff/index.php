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
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <section class="staff-dashboard">
        <h1>Welcome, <?php echo $staff['username']; ?></h1>
        <nav>
            <ul>
                <li><a href="view_appointments.php">View Appointments</a></li>
                <li><a href="view_services.php">View services</a></li>
                <li><a href="view_queries.php">View Queries</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </section>

    <?php include '../includes/footer.php'; ?>
</body>
</html>