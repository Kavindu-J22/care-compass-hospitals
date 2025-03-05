<?php
session_start();
include '../includes/db.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Get the doctor ID from the URL
if (!isset($_GET['id'])) {
    echo "<p>Error: Doctor ID not provided.</p>";
    exit();
}
$doctor_id = $_GET['id'];

// Fetch the doctor details
try {
    $sql = "SELECT * FROM doctors WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $doctor_id);
    $stmt->execute();
    $doctor = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$doctor) {
        echo "<p>Error: Doctor not found.</p>";
        exit();
    }
} catch (PDOException $e) {
    echo "<p>Error fetching doctor: " . $e->getMessage() . "</p>";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $specialty = $_POST['specialty'];
    $qualifications = $_POST['qualifications'];
    $contact_info = $_POST['contact_info'];

    try {
        // Update the doctor
        $sql = "UPDATE doctors 
                SET name = :name, specialty = :specialty, qualifications = :qualifications, contact_info = :contact_info 
                WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':specialty', $specialty);
        $stmt->bindParam(':qualifications', $qualifications);
        $stmt->bindParam(':contact_info', $contact_info);
        $stmt->bindParam(':id', $doctor_id);
        $stmt->execute();

        echo "<p>Staff Member updated successfully!</p>";

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
    <title>Edit Doctor - Care Compass Hospitals</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <section class="edit-doctor">
        <h1>Edit Doctor</h1>
        <form method="POST" action="">
            <div>
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" value="<?php echo $doctor['name']; ?>" required>
            </div>
            <div>
                <label for="specialty">Specialty:</label>
                <input type="text" name="specialty" id="specialty" value="<?php echo $doctor['specialty']; ?>" required>
            </div>
            <div>
                <label for="qualifications">Qualifications:</label>
                <textarea name="qualifications" id="qualifications" required><?php echo $doctor['qualifications']; ?></textarea>
            </div>
            <div>
                <label for="contact_info">Contact Info:</label>
                <input type="text" name="contact_info" id="contact_info" value="<?php echo $doctor['contact_info']; ?>" required>
            </div>
            <button type="submit">Update Doctor</button>
        </form>
        <a href="manage_staff.php" class="btn">Back to Manage Doctors</a>
    </section>

    <?php include '../includes/footer.php'; ?>
</body>
</html>