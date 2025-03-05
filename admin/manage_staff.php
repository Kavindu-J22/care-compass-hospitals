<?php
session_start();
include '../includes/db.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

try {
    // Fetch all doctors' details
    $sql = "SELECT * FROM doctors";
    $stmt = $conn->query($sql);
    $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Manage Doctors & Staff - Care Compass Hospitals</title>
    <link rel="stylesheet" href="../assets/css/manageStaff.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Manage Doctors & Staff Hero Section -->
    <section class="manage-doctors-hero">
        <div class="manage-doctors-hero-content">
            <h1>Manage Doctors & Staff</h1>
            <p>Efficiently manage the doctors and staff members of Care Compass Hospitals. Add, edit, or remove records as needed.</p>
        </div>
    </section>

    <!-- Manage Doctors & Staff Table Section -->
    <section class="manage-doctors-table">
        <h2>Doctors & Staff List</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Specialty</th>
                        <th>Qualifications</th>
                        <th>Contact Info</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($doctors)) {
                        foreach ($doctors as $row) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['name']}</td>
                                    <td>{$row['specialty']}</td>
                                    <td>{$row['qualifications']}</td>
                                    <td>{$row['contact_info']}</td>
                                    <td class='actions'>
                                        <a href='edit_doctor.php?id={$row['id']}' class='btn-edit'>Edit</a>
                                        <a href='delete_doctor.php?id={$row['id']}' class='btn-delete'>Delete</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No doctors found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <a href="add_staff.php" class="btn-primary">Add New Staff</a>
    </section>

</body>
</html>
