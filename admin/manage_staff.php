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
    <title>Manage Doctors - Care Compass Hospitals</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <section class="manage-doctors">
        <h1>Manage Doctors</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Specialty</th>
                    <th>qualifications</th>
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
                                <td>
                                    <a href='edit_doctor.php?id={$row['id']}'>Edit</a>
                                    <a href='delete_doctor.php?id={$row['id']}'>Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No doctors found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="add_staff.php" class="btn">Add New Staff</a>
    </section>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
