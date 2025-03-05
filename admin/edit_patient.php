<?php
session_start();
include '../includes/db.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Check if ID is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch patient details
    $sql = "SELECT * FROM patients WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$patient) {
        die("Patient not found.");
    }
}

// Update patient record
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $sql = "UPDATE patients SET full_name = :full_name, email = :email, phone = :phone, address = :address WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':full_name', $full_name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Patient updated successfully.";
        header("Location: manage_patients.php");
        exit();
    } else {
        $_SESSION['message'] = "Error updating patient.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient - Care Compass Hospitals</title>
    <link rel="stylesheet" href="../assets/css/editPateint.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Edit Patient Hero Section -->
    <section class="edit-patient-hero">
        <div class="edit-patient-hero-content">
            <h1>Edit Patient</h1>
            <p>Update patient details to ensure accurate and up-to-date information for better healthcare delivery.</p>
        </div>
    </section>

    <!-- Edit Patient Form Section -->
    <section class="edit-patient-form">
        <h2>Update Patient Details</h2>
        <p>Edit the patient's information below and save the changes.</p>

        <?php if (isset($_SESSION['message'])) { echo "<p class='message'>{$_SESSION['message']}</p>"; unset($_SESSION['message']); } ?>

        <form method="POST">
            <div class="form-group">
                <label for="full_name">Full Name:</label>
                <input type="text" name="full_name" id="full_name" value="<?= htmlspecialchars($patient['full_name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($patient['email']) ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" name="phone" id="phone" value="<?= htmlspecialchars($patient['phone']) ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea name="address" id="address" required><?= htmlspecialchars($patient['address']) ?></textarea>
            </div>
            <button type="submit" class="btn-primary">Update</button>
        </form>
        <a href="manage_patients.php" class="btn-secondary">Back to Manage Patients</a>
    </section>

</body>
</html>