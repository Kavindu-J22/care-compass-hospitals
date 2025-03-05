<?php
session_start();
include '../includes/db.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
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
    <link rel="stylesheet" href="../assets/css/manageServices.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>


    <!-- Manage Services Hero Section -->
    <section class="manage-services-hero">
        <div class="manage-services-hero-content">
            <h1>Manage Services</h1>
            <p>Efficiently manage the healthcare services offered by Care Compass Hospitals. Add, edit, or remove services as needed.</p>
        </div>
    </section>

    <!-- Manage Services Table Section -->
    <section class="manage-services-table">
        <h2>Services List</h2>
        <p>Below is a list of all the services currently offered by Care Compass Hospitals.</p>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Cost (LKR)</th>
                        <th>Actions</th>
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
                                    <td>{$row['cost']}</td>
                                    <td class='actions'>
                                        <a href='edit_service.php?id={$row['id']}' class='btn-edit'>Edit</a>
                                        <a href='delete_service.php?id={$row['id']}' class='btn-delete'>Delete</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No services found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <a href="add_service.php" class="btn-primary">Add New Service</a>
    </section>

</body>
</html>
