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
    <title>Manage Feedback - Care Compass Hospitals</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <section class="manage-feedback">
        <h1>Manage Feedback</h1>
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
                if (!empty($feedbacks)) { // Check if there are results
                    foreach ($feedbacks as $row) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['full_name']}</td>
                                <td>{$row['rating']}</td>
                                <td>{$row['comment']}</td>
                                <td>
                                    <a href='delete_feedback.php?id={$row['id']}' onclick='return confirm(\"Are you sure you want to delete this feedback?\");'>Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No feedback found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
