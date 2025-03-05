<?php
session_start(); // Start the session
include 'includes/header.php';
include 'includes/db.php';

try {
    // Fetch services from the database
    $sql = "SELECT * FROM services";
    $stmt = $conn->query($sql);
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Services - Care Compass Hospitals</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <section class="services">
        <h1>Our Services</h1>
        <div class="service-list">
            <?php
            if (!empty($services)) {
                foreach ($services as $row) {
                    echo "<div class='service-item'>
                            <h2>{$row['name']}</h2>
                            <p>{$row['description']}</p>
                            <p>Cost: LKR {$row['cost']}</p>
                          </div>";
                }
            } else {
                echo "<p>No services available.</p>";
            }
            ?>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>