<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch services
$sql = "SELECT * FROM services";
$stmt = $conn->query($sql);
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Services - Care Compass Hospitals</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <section class="manage-services">
        <h1>Manage Services</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Cost</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($services) > 0) {
                    foreach ($services as $row) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['description']}</td>
                                <td>LKR {$row['cost']}</td>
                                
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No services found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        
    </section>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
