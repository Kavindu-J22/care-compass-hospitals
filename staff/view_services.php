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
    <link rel="stylesheet" href="../assets/css/viewServiceStaff.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <section class="manage-services">
        <div class="container">
            <h1> All Services</h1>
            <p>Below is a list of all services offered by Care Compass Hospitals. You can view and manage them here.</p>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Cost (LKR)</th>
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
            </div>
        </div>
    </section>

</body>
</html>