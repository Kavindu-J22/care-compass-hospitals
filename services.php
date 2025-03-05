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
    <link rel="stylesheet" href="assets/css/services.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
   

    <!-- Services Hero Section -->
    <section class="services-hero">
        <div class="services-hero-content">
            <h1>Our Services</h1>
            <p>At Care Compass Hospitals, we offer a wide range of medical services to meet your healthcare needs. From routine checkups to advanced surgical procedures, we are here for you.</p>
        </div>
        <div class="services-hero-image">
            <img src="assets/images/services-hero.jpg" alt="Care Compass Hospitals Services">
        </div>
    </section>

    <!-- Services List Section -->
    <section class="services-list">
        <h2>Explore Our Services</h2>
        <p>We provide comprehensive healthcare services to ensure the well-being of our patients.</p>
        <div class="service-grid">
            <?php
            if (!empty($services)) {
                foreach ($services as $row) {
                    echo "<div class='service-card'>
                            <img src='assets/images/services-iocn.png' alt='services'>
                            <h3>{$row['name']}</h3>
                            <p>{$row['description']}</p>
                            <p class='service-cost'>Cost: LKR {$row['cost']}</p>
                          </div>";
                }
            } else {
                echo "<p>No services available.</p>";
            }
            ?>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
</body>
</html>