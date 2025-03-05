<?php
session_start();
include '../includes/db.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password
    $role = 'staff'; // Default role for staff
    $name = $_POST['name'];
    $specialty = $_POST['specialty'];
    $qualifications = $_POST['qualifications'];
    $contact_info = $_POST['contact_info'];

    try {
        // Insert into users table
        $sql = "INSERT INTO users (username, password, role) VALUES (:username, :password, :role)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        $stmt->execute();

        // Get the last inserted user ID
        $user_id = $conn->lastInsertId();

        // Insert into doctors table
        $sql = "INSERT INTO doctors (name, specialty, qualifications, contact_info) VALUES (:name, :specialty, :qualifications, :contact_info)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':specialty', $specialty);
        $stmt->bindParam(':qualifications', $qualifications);
        $stmt->bindParam(':contact_info', $contact_info);
        $stmt->execute();

        echo "<p>Staff member added successfully!</p>";
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
    <title>Add Staff - Care Compass Hospitals</title>
    <link rel="stylesheet" href="../assets/css/addStaff.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Add Staff Hero Section -->
    <section class="add-staff-hero">
        <div class="add-staff-hero-content">
            <h1>Add New Staff Member</h1>
            <p>Welcome to the staff management portal. Add new doctors, nurses, lab assistants, and other healthcare professionals to the Care Compass Hospitals team.</p>
        </div>
    </section>

    <!-- Add Staff Form Section -->
    <section class="add-staff-form">
        <h2>Staff Details</h2>
        <p>Fill out the form below to add a new staff member.</p>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
            <label for="specialty">Specialty or Occupation:</label>
            <select name="specialty" id="specialty" required>
                <option value=""> Select From List </option>
                <option value="doctor">Doctor</option>
                <option value="nurse">Nurse</option>
                <option value="lab_assistant">Lab Assistant</option>
                <option value="pharmacist">Pharmacist</option>
                <option value="receptionist">Receptionist</option>
                <option value="admin">Admin</option>
                <option value="surgeon">Surgeon</option>
                <option value="therapist">Therapist</option>
                <option value="radiologist">Radiologist</option>
                <option value="dentist">Dentist</option>
                <option value="cardiologist">Cardiologist</option>
                <option value="pediatrician">Pediatrician</option>
                <option value="gynecologist">Gynecologist</option>
                <option value="orthopedic">Orthopedic</option>
                <option value="neurologist">Neurologist</option>
                <option value="psychiatrist">Psychiatrist</option>
                <option value="anesthesiologist">Anesthesiologist</option>
            </select>
        </div>
            <div class="form-group">
                <label for="qualifications">Qualifications:</label>
                <textarea name="qualifications" id="qualifications" required></textarea>
            </div>
            <div class="form-group">
                <label for="contact_info">Contact Info:</label>
                <input type="text" name="contact_info" id="contact_info" required>
            </div>
            <button type="submit" class="btn-primary">Add to Staff</button>
        </form>
        <a href="manage_staff.php" class="btn-secondary">Back to Manage Staff</a>
    </section>

</body>
</html>