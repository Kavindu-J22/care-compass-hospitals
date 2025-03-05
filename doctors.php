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
    <title>Doctors - Care Compass Hospitals</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <section class="doctors">
        <h1>Our Doctors</h1>
        <div class="doctor-list">
            <?php
            if (!empty($doctors)) {
                foreach ($doctors as $row) {
                    echo "<div class='doctor-item'>
                            <h2>{$row['name']}</h2>
                            <p>Specialty: {$row['specialty']}</p>
                            <p>Qualifications: {$row['qualifications']}</p>
                            <p>Contact: {$row['contact_info']}</p>
                          </div>";
                }
            } else {
                echo "<p>No doctors available.</p>";
            }
            ?>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>