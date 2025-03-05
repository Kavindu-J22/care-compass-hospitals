<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
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
    <title>Manage Appointments</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        .btn {
            padding: 8px 12px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
        }
        .update-btn { background-color: #28a745; }
        .update-btn:hover { background-color: #218838; }
    </style>
</head>
<body>
    <section class="dashboard">
        <h1>Manage Appointments</h1>
        <table>
            <thead>
                <tr>
                    <th>Appointment No.</th>
                    <th>Patient Name</th>
                    <th>Doctor Name</th>
                    <th>Service</th>
                    <th>Appointment Date</th>
                    <th>Status</th>
                    <th>Action</th>
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
                            <td><?php echo ucfirst($appointment['status']); ?></td>
                            <td>
                                <a href="Update_Apoinment.php?id=<?php echo $appointment['id']; ?>" class="btn update-btn">Update & Get Action</a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr><td colspan="7">No appointments found.</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </section>
</body>
</html>

<?php include '../includes/footer.php'; ?>
