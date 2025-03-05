<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
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
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <section class="manage-queries">
        <h1>Manage Queries</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Patient Name</th>
                    <th>Query</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($queries)) { // Check if there are results
                    foreach ($queries as $row) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['full_name']}</td>
                                <td>{$row['query']}</td>
                                <td>{$row['status']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No queries found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
