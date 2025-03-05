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
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <section class="dashboard">
        <h1>Welcome, <?php echo htmlspecialchars($patient['full_name']); ?></h1>
        
        <!-- My Appointments & Status -->
        <h2>My Appointments & Status</h2>
        <a href="add_newAppoinmnt.php" class="btn">Add New Appointment</a>  <!-- Button Added -->
        <div class="appointments">
            <?php if (!empty($appointments)) { ?>
                <ul>
                    <?php foreach ($appointments as $row) { ?>
                        <li>
                            <strong>Date & Time :</strong> <?php echo $row['appointment_date']; ?> <br>
                            <strong>Number:</strong> <?php echo $row['appointment_number']; ?> |
                            <strong>Status:</strong> <?php echo ucfirst($row['status']); ?>
                        </li>
                    <?php } ?>
                </ul>
            <?php } else { echo "<p>No appointments found.</p>"; } ?>
        </div>

        <!-- My Queries & Responses -->
        <h2>My Queries & Responses</h2>
        <div class="queries">
            <?php if (!empty($queries)) { ?>
                <ul>
                    <?php foreach ($queries as $row) { ?>
                        <li>
                            <strong>Query:</strong> <?php echo htmlspecialchars($row['query']); ?><br>
                            <strong>Response:</strong> <?php echo ($row['response']) ? htmlspecialchars($row['response']) : "Pending"; ?><br>
                            <strong>Status:</strong> <?php echo htmlspecialchars($row['status']); ?>
                        </li>
                    <?php } ?>
                </ul>
            <?php } else { echo "<p>No queries found.</p>"; } ?>
        </div>

        <!-- My Feedback -->
        <h2>My Feedback</h2>
        <div class="feedback">
            <?php if (!empty($feedbacks)) { ?>
                <ul>
                    <?php foreach ($feedbacks as $row) { ?>
                        <li>
                            <strong>Rating:</strong> <?php echo $row['rating']; ?> / 5<br>
                            <strong>Comment:</strong> <?php echo htmlspecialchars($row['comment']); ?>
                        </li>
                    <?php } ?>
                </ul>
            <?php } else { echo "<p>No feedback found.</p>"; } ?>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
