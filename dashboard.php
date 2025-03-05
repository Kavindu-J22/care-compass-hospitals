<?php 
session_start();
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    // Fetch patient details
    $sql = "SELECT * FROM patients WHERE user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$patient) {
        echo "<p>Patient not found.</p>";
        exit();
    }

    $patient_id = $patient['id'];

    // Fetch appointments
    $sql = "SELECT * FROM appointments WHERE patient_id = :patient_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':patient_id', $patient_id);
    $stmt->execute();
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch queries
    $sql = "SELECT * FROM queries WHERE patient_id = :patient_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':patient_id', $patient_id);
    $stmt->execute();
    $queries = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch feedback
    $sql = "SELECT * FROM feedback WHERE patient_id = :patient_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':patient_id', $patient_id);
    $stmt->execute();
    $feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Care Compass Hospitals</title>
    <link rel="stylesheet" href="assets/css/pationDashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Dashboard Hero Section -->
    <section class="dashboard-hero">
        <div class="dashboard-hero-content">
            <h1>Welcome, <?php echo htmlspecialchars($patient['full_name']); ?></h1>
            <p>Your health is our priority. Manage your appointments, queries, and feedback here.</p>
        </div>
        <div class="dashboard-hero-image">
            <img src="assets/images/dashboard-hero.jpg" alt="Care Compass Hospitals Dashboard">
        </div>
    </section>

    <!-- Dashboard Content Section -->
    <section class="dashboard-content">
        <!-- My Appointments & Status -->
        <div class="dashboard-section">
            <h2>📍 My Appointments & Status</h2>
            <a href="add_newAppoinmnt.php" class="btn-primary">+ Add New Appointment</a>
            <div class="appointments">
                <?php if (!empty($appointments)) { ?>
                    <div class="appointment-grid">
                        <?php foreach ($appointments as $row) { ?>
                            <div class="appointment-card">
                                <h3>Appointment #<?php echo $row['appointment_number']; ?></h3>
                                <p><strong>Date & Time:</strong> <?php echo $row['appointment_date']; ?></p>
                                <p><strong>Status:</strong> <span class="status-<?php echo strtolower($row['status']); ?>"><?php echo ucfirst($row['status']); ?></span></p>
                            </div>
                        <?php } ?>
                    </div>
                <?php } else { echo "<p>No appointments found.</p>"; } ?>
            </div>
        </div>

        <!-- My Queries & Responses -->
        <div class="dashboard-section">
            <h2>📥 My Queries & Responses</h2>
            <div class="queries">
                <?php if (!empty($queries)) { ?>
                    <div class="query-grid">
                        <?php foreach ($queries as $row) { ?>
                            <div class="query-card">
                                <h3>Query #<?php echo $row['id']; ?></h3>
                                <p><strong>Query:</strong> <?php echo htmlspecialchars($row['query']); ?></p>
                                <p><strong>Response:</strong> <?php echo ($row['response']) ? htmlspecialchars($row['response']) : "Pending"; ?></p>
                                <p><strong>Status:</strong> <span class="status-<?php echo strtolower($row['status']); ?>"><?php echo ucfirst($row['status']); ?></span></p>
                            </div>
                        <?php } ?>
                    </div>
                <?php } else { echo "<p>No queries found.</p>"; } ?>
            </div>
        </div>

        <!-- My Feedback -->
        <div class="dashboard-section">
            <h2>👍 My Feedbacks</h2>
            <div class="feedback">
                <?php if (!empty($feedbacks)) { ?>
                    <div class="feedback-grid">
                        <?php foreach ($feedbacks as $row) { ?>
                            <div class="feedback-card">
                                <h3>Feedback #<?php echo $row['id']; ?></h3>
                                <p><strong>Rating:</strong> <?php echo $row['rating']; ?> / 5</p>
                                <p><strong>Comment:</strong> <?php echo htmlspecialchars($row['comment']); ?></p>
                            </div>
                        <?php } ?>
                    </div>
                <?php } else { echo "<p>No feedback found.</p>"; } ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
</body>
</html>
