<?php
session_start();
include '../includes/db.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Get the service ID from the URL
if (!isset($_GET['id'])) {
    echo "<p>Error: Service ID not provided.</p>";
    exit();
}
$service_id = $_GET['id'];

// Fetch the service details
try {
    $sql = "SELECT * FROM services WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $service_id);
    $stmt->execute();
    $service = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$service) {
        echo "<p>Error: Service not found.</p>";
        exit();
    }
} catch (PDOException $e) {
    echo "<p>Error fetching service: " . $e->getMessage() . "</p>";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $cost = $_POST['cost'];

    try {
        // Update the service
        $sql = "UPDATE services 
                SET name = :name, description = :description, cost = :cost 
                WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':cost', $cost);
        $stmt->bindParam(':id', $service_id);
        $stmt->execute();

        echo "<p>Service updated successfully!</p>";

        // Redirect to the previous page after 2 seconds
        header("Refresh:1; url=" . $_SERVER['HTTP_REFERER']);
        exit();
    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service - Care Compass Hospitals</title>
    <link rel="stylesheet" href="../assets/css/editServices.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>


    <!-- Edit Service Hero Section -->
    <section class="edit-service-hero">
        <div class="edit-service-hero-content">
            <h1>Edit Service</h1>
            <p>Update the details of healthcare services to ensure accurate and up-to-date information for patients.</p>
        </div>
    </section>

    <!-- Edit Service Form Section -->
    <section class="edit-service-form">
        <h2>Edit Service Details</h2>
        <p>Update the information for the selected service.</p>

        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <?php if (isset($success)) { echo "<p class='success'>$success</p>"; } ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Service Name:</label>
                <input type="text" name="name" id="name" value="<?php echo $service['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" id="description" required><?php echo $service['description']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="cost">Cost (LKR):</label>
                <input type="number" name="cost" id="cost" value="<?php echo $service['cost']; ?>" required>
            </div>
            <button type="submit" class="btn-primary">Update Service</button>
        </form>
        <a href="manage_services.php" class="btn-secondary">Back to Manage Services</a>
    </section>

</body>
</html>