<?php
session_start();
include 'includes/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch patient details
$patient_id = $_SESSION['user_id'];
try {
    $sql = "SELECT id FROM patients WHERE user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $patient_id);
    $stmt->execute();
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$patient) {
        echo "<p>Error: Patient record not found. Please contact support.</p>";
        exit();
    }

    $patient_id = $patient['id']; // Set patient_id from the patients table
} catch (PDOException $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
    exit();
}

// Fetch doctors for dropdown
try {
    $sql = "SELECT id, name FROM doctors";
    $stmt = $conn->query($sql);
    $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p>Error fetching doctors: " . $e->getMessage() . "</p>";
    exit();
}

// Fetch services for dropdown
try {
    $sql = "SELECT id, name FROM services";
    $stmt = $conn->query($sql);
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p>Error fetching services: " . $e->getMessage() . "</p>";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctor_id = $_POST['doctor_id'];
    $service_id = $_POST['service_id'];
    $appointment_number = uniqid('APPT-'); // Generate a unique appointment number
    $appointment_date = $_POST['appointment_date'];
    $status = 'pending'; // Default status

    try {
        // Insert into appointments table
        $sql = "INSERT INTO appointments (patient_id, doctor_id, service_id, appointment_number, appointment_date, status) 
                VALUES (:patient_id, :doctor_id, :service_id, :appointment_number, :appointment_date, :status)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':patient_id', $patient_id);
        $stmt->bindParam(':doctor_id', $doctor_id);
        $stmt->bindParam(':service_id', $service_id);
        $stmt->bindParam(':appointment_number', $appointment_number);
        $stmt->bindParam(':appointment_date', $appointment_date);
        $stmt->bindParam(':status', $status);
        $stmt->execute();

        echo "<p>Appointment booked successfully! Your Temporary appointment number is: $appointment_number</p>";
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
    <title>Add Appointment - Care Compass Hospitals</title>
    <link rel="stylesheet" href="assets/css/addAppoinment.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <?php include 'includes/header.php'; ?>

    <!-- Add Appointment Hero Section -->
    <section class="add-appointment-hero">
        <div class="add-appointment-hero-content">
            <h1>Book an Appointment</h1>
            <p>Schedule your visit with our expert doctors and healthcare professionals. We’re here to provide you with the best care.</p>
        </div>
        <div class="add-appointment-hero-image">
            <img src="assets/images/appointment-hero.jpg" alt="Care Compass Hospitals Appointment">
        </div>
    </section>

    <!-- Add Appointment Form Section -->
    <section class="add-appointment-form">
        <h2>Add New Appointment</h2>
        <p>Fill out the form below to book your appointment.</p>
        <form method="POST" action="">
            <div class="form-group">
                <label for="doctor_id">Select Doctor or Staff:</label>
                <select name="doctor_id" id="doctor_id" required>
                    <option value="">-- Select Doctor --</option>
                    <?php foreach ($doctors as $doctor): ?>
                        <option value="<?php echo $doctor['id']; ?>"><?php echo $doctor['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="service_id">Select Service:</label>
                <select name="service_id" id="service_id" required>
                    <option value="">-- Select Service --</option>
                    <?php foreach ($services as $service): ?>
                        <option value="<?php echo $service['id']; ?>"><?php echo $service['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="appointment_date">Appointment Date:</label>
                <input type="datetime-local" name="appointment_date" id="appointment_date" required>
            </div>
            <button type="submit" class="btn-primary">Book Appointment</button>
        </form>
        <a href="dashboard.php" class="btn-secondary">Back to Dashboard</a>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
</body>
</html>