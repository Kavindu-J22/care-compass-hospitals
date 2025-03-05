<?php
session_start(); // Start the session
include 'includes/header.php';
include 'includes/db.php';

// Check if a search query is submitted
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

try {
    // Fetch services from the database with search functionality
    $sql = "SELECT * FROM services WHERE name LIKE :search OR description LIKE :search";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['search' => "%$search%"]);
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Debugging: Print the search term and query results
    echo "<pre>";
    echo "Search Term: " . $search . "\n";
    echo "Number of Results: " . count($services) . "\n";
    echo "</pre>";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Services Hero Section -->
    <section class="services-hero">
        <div class="services-hero-content">
            <h1>Our Services</h1>
            <p>At Care Compass Hospitals, we offer a wide range of medical services to meet your healthcare needs. From routine checkups to advanced surgical procedures, we are here for you.</p>
            <!-- Search Bar -->
            <form action="" method="GET" class="search-form">
                <input type="text" name="search" placeholder="Search & hit Enter..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
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
                echo "<p>No services found.</p>";
            }
            ?>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
</body>
</html>