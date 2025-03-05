<?php
session_start();
include '../includes/db.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Fetch patients
$sql = "SELECT * FROM patients";
$stmt = $conn->query($sql);
$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Patients - Care Compass Hospitals</title>
    <link rel="stylesheet" href="../assets/css/managePatient.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>


    <!-- Manage Patients Hero Section -->
    <section class="manage-patients-hero">
        <div class="manage-patients-hero-content">
            <h1>Manage Patients</h1>
            <p>Efficiently manage patient records to ensure accurate and up-to-date information for better healthcare delivery.</p>
        </div>
    </section>

    <!-- Manage Patients Table Section -->
    <section class="manage-patients-table">
        <h2>Patient Records</h2>
        <p>Below is a list of all registered patients. You can edit or delete patient records as needed.</p>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($patients)) {
                        foreach ($patients as $row) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['full_name']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$row['phone']}</td>
                                    <td>{$row['address']}</td>
                                    <td class='actions'>
                                        <a href='edit_patient.php?id={$row['id']}' class='btn-edit'>Edit</a>
                                        <a href='delete_patient.php?id={$row['id']}' class='btn-delete' onclick='return confirm(\"Are you sure you want to delete this patient?\");'>Delete</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No patients found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>

</body>
</html>
