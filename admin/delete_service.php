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

// Handle deletion
try {
    $sql = "DELETE FROM services WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $service_id);
    $stmt->execute();

    echo "<p>Service deleted successfully!</p>";
} catch (PDOException $e) {
    if ($e->getCode() == '23000') { // 23000 is the SQLSTATE code for integrity constraint violation
        echo "<p>Can't delete because this service is still currently being used in some places.</p>";
    } else {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Service - Care Compass Hospitals</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <section class="delete-service">
        <h1>Delete Service</h1>
        <p>Are you sure you want to delete this service?</p>
        <form method="POST" action="">
            <button type="submit" name="confirm" value="yes">Yes, Delete</button>
            <a href="manage_services.php" class="btn">No, Go Back</a>
        </form>
    </section>

    <?php include '../includes/footer.php'; ?>
</body>
</html>