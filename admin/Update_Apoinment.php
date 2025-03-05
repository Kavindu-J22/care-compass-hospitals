<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "<p>Invalid appointment ID.</p>";
    exit();
}

$appointment_id = $_GET['id'];

try {
    // Fetch appointment details
    $sql = "SELECT * FROM appointments WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $appointment_id);
    $stmt->execute();
    $appointment = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$appointment) {
        echo "<p>Appointment not found.</p>";
        exit();
    }
} catch (PDOException $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $appointment_number = $_POST['appointment_number'];
    $appointment_date = $_POST['appointment_date'];
    $status = $_POST['status'];

    try {
        $sql = "UPDATE appointments SET appointment_number = :appointment_number, appointment_date = :appointment_date, status = :status WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':appointment_number', $appointment_number);
        $stmt->bindParam(':appointment_date', $appointment_date);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $appointment_id);
        $stmt->execute();

        header("Location: manage_Appointments.php");
        exit();
    } catch (PDOException $e) {
        echo "<p>Error updating appointment: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Appointment - Care Compass Hospitals</title>
    <link rel="stylesheet" href="../assets/css/updateAppoinment.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>


    <!-- Update Appointment Hero Section -->
    <section class="update-appointment-hero">
        <div class="update-appointment-hero-content">
            <h1>Update Appointment</h1>
            <p>Modify appointment details to ensure accurate scheduling and patient satisfaction.</p>
        </div>
    </section>

    <!-- Update Appointment Form Section -->
    <section class="update-appointment-form">
        <h2>Edit Appointment Details</h2>
        <p>Update the appointment information below and save the changes.</p>

        <form method="POST">
            <div class="form-group">
                <label for="appointment_number">Appointment Number:</label>
                <input type="text" name="appointment_number" id="appointment_number" value="<?php echo htmlspecialchars($appointment['appointment_number']); ?>" required>
            </div>
            <div class="form-group">
                <label for="appointment_date">Appointment Date:</label>
                <input type="datetime-local" name="appointment_date" id="appointment_date" value="<?php echo date('Y-m-d\TH:i', strtotime($appointment['appointment_date'])); ?>" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select name="status" id="status" required>
                    <option value="pending" <?php echo ($appointment['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                    <option value="completed" <?php echo ($appointment['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                    <option value="cancelled" <?php echo ($appointment['status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                </select>
            </div>
            <button type="submit" class="btn-primary">Update Appointment</button>
        </form>
        <a href="manage_Appointments.php" class="btn-secondary">Back to Manage Appointments</a>
    </section>

</body>
</html>
