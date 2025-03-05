<?php
session_start();
include '../includes/db.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $cost = trim($_POST['cost']);

    // Validate inputs
    if (empty($name) || empty($cost)) {
        $error = "Name and Cost are required!";
    } elseif (!is_numeric($cost) || $cost < 0) {
        $error = "Cost must be a valid positive number!";
    } else {
        try {
            $sql = "INSERT INTO services (name, description, cost) VALUES (:name, :description, :cost)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':description' => $description,
                ':cost' => $cost
            ]);

            $success = "Service added successfully!";
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Service - Care Compass Hospitals</title>
    <link rel="stylesheet" href="../assets/css/addServices.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>


    <!-- Add Service Hero Section -->
    <section class="add-service-hero">
        <div class="add-service-hero-content">
            <h1>Add New Service</h1>
            <p>Expand the range of healthcare services offered by Care Compass Hospitals. Add new services to meet the needs of our patients.</p>
        </div>
    </section>

    <!-- Add Service Form Section -->
    <section class="add-service-form">
        <h2>Service Details</h2>
        <p>Fill out the form below to add a new service.</p>

        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <?php if (isset($success)) { echo "<p class='success'>$success</p>"; } ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Service Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description"></textarea>
            </div>
            <div class="form-group">
                <label for="cost">Cost (LKR):</label>
                <input type="text" id="cost" name="cost" required>
            </div>
            <button type="submit" class="btn-primary">Add Service</button>
        </form>
        <a href="manage_services.php" class="btn-secondary">Back to Services</a>
    </section>

</body>
</html>
