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
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <section class="add-service">
        <h1>Add New Service</h1>

        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <?php if (isset($success)) { echo "<p class='success'>$success</p>"; } ?>

        <form method="POST" action="">
            <label for="name">Service Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description"></textarea>

            <label for="cost">Cost (LKR):</label>
            <input type="text" id="cost" name="cost" required>

            <button type="submit">Add Service</button>
        </form>

        <a href="manage_services.php" class="btn">Back to Services</a>
    </section>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
