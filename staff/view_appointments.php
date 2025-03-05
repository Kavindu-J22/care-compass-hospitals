<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

try {
    // Fetch all appointments with patient, doctor, and service details
    $sql = "SELECT a.id, a.appointment_number, a.appointment_date, a.status, 
                   p.full_name AS patient_name, d.name AS doctor_name, s.name AS service_name
            FROM appointments a
            JOIN patients p ON a.patient_id = p.id
            JOIN doctors d ON a.doctor_id = d.id
            JOIN services s ON a.service_id = s.id
            ORDER BY a.appointment_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>View Appointments - Care Compass Hospitals</title>
    <link rel="stylesheet" href="../assets/css/viewAppoinmentStaff.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <!-- View Appointments Hero Section -->
    <section class="view-appointments-hero">
        <div class="view-appointments-hero-content">
            <h1>View Appointments</h1>
            <p>Access and manage all patient appointments efficiently to ensure smooth operations.</p>
        </div>
    </section>

    <!-- View Appointments Table Section -->
    <section class="view-appointments-table">
        <h2>Appointment List</h2>
        <p>Below is a list of all appointments. You can view details and track their status.</p>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Appointment No.</th>
                        <th>Patient Name</th>
                        <th>Doctor Name</th>
                        <th>Service</th>
                        <th>Appointment Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($appointments)) { ?>
                        <?php foreach ($appointments as $appointment) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($appointment['appointment_number']); ?></td>
                                <td><?php echo htmlspecialchars($appointment['patient_name']); ?></td>
                                <td><?php echo htmlspecialchars($appointment['doctor_name']); ?></td>
                                <td><?php echo htmlspecialchars($appointment['service_name']); ?></td>
                                <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                                <td><span class="status-<?php echo strtolower($appointment['status']); ?>"><?php echo ucfirst($appointment['status']); ?></span></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr><td colspan="6">No appointments found.</td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>

</body>
</html>