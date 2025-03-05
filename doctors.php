<?php
session_start(); // Start the session
include 'includes/header.php';
include 'includes/db.php';

try {
    // Fetch doctors from the database
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
    <title>Doctors & Staff - Care Compass Hospitals</title>
    <link rel="stylesheet" href="assets/css/staff.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Doctors Hero Section -->
    <section class="doctors-hero">
        <div class="doctors-hero-content">
            <h1>Meet Our Doctors & Staff</h1>
            <p>Our team of highly qualified doctors and dedicated staff are here to provide you with the best possible care.</p>
        </div>
        <div class="doctors-hero-image">
            <img src="assets/images/doctors-hero.jpg" alt="Care Compass Hospitals Doctors">
        </div>
    </section>

    <!-- Doctors List Section -->
    <section class="doctors-list">
        <h2>Our Medical Experts</h2>
        <p>We are proud to have some of the best medical professionals in the country.</p>
        <div class="doctor-grid">
            <?php
            if (!empty($doctors)) {
                foreach ($doctors as $row) {
                    echo "<div class='doctor-card'>
                            <img src='assets/images/staff-icon.png' alt='Staff'>
                            <h3>{$row['name']}</h3>
                            <p class='specialty'>{$row['specialty']}</p>
                            <p class='qualifications'>{$row['qualifications']}</p>
                            <p class='contact-info'>{$row['contact_info']}</p>
                          </div>";
                }
            } else {
                echo "<p>No doctors available.</p>";
            }
            ?>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
</body>
</html>