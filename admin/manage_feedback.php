<?php
session_start();
include '../includes/db.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Fetch feedback using PDO
$sql = "SELECT feedback.*, patients.full_name 
        FROM feedback 
        JOIN patients ON feedback.patient_id = patients.id";
$stmt = $conn->query($sql);
$feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Feedbacks - Care Compass Hospitals</title>
    <link rel="stylesheet" href="../assets/css/manageFeedback.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Manage Feedbacks Hero Section -->
    <section class="manage-feedbacks-hero">
        <div class="manage-feedbacks-hero-content">
            <h1>Manage Feedbacks</h1>
            <p>View and analyze patient feedback to improve the quality of care and services provided by Care Compass Hospitals.</p>
        </div>
    </section>

    <!-- Manage Feedbacks Table Section -->
    <section class="manage-feedbacks-table">
        <h2>Patient Feedbacks</h2>
        <p>Below is a list of all patient feedbacks. Use this information to enhance patient satisfaction.</p>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Patient Name</th>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($feedbacks)) {
                        foreach ($feedbacks as $row) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['full_name']}</td>
                                    <td>{$row['rating']} / 5</td>
                                    <td>{$row['comment']}</td>
                                    <td class='actions'>
                                        <a href='delete_feedback.php?id={$row['id']}' class='btn-delete'>Delete</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No feedbacks found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>

</body>
</html>
