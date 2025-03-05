<?php
session_start();
include '../includes/db.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Fetch queries
$sql = "SELECT queries.*, patients.full_name 
        FROM queries 
        JOIN patients ON queries.patient_id = patients.id";
$stmt = $conn->query($sql);
$queries = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Queries - Care Compass Hospitals</title>
    <link rel="stylesheet" href="../assets/css/manageQuery.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>


    <!-- Manage Queries Hero Section -->
    <section class="manage-queries-hero">
        <div class="manage-queries-hero-content">
            <h1>Manage Queries</h1>
            <p>View and respond to patient queries efficiently. Ensure timely and accurate responses to improve patient satisfaction.</p>
        </div>
    </section>

    <!-- Manage Queries Table Section -->
    <section class="manage-queries-table">
        <h2>Patient Queries</h2>
        <p>Below is a list of all patient queries. You can resolve or reply to each query.</p>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Patient Name</th>
                        <th>Query</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($queries)) {
                        foreach ($queries as $row) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['full_name']}</td>
                                    <td>{$row['query']}</td>
                                    <td><span class='status-{$row['status']}'>{$row['status']}</span></td>
                                    <td class='actions'>
                                        <a href='resolve_query.php?id={$row['id']}' class='btn-resolve'>Resolve / Reply</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No queries found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>

</body>
</html>