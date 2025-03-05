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
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <section class="add-staff">
        <h1>Add Staff Member</h1>
        <form method="POST" action="">
            <h2>User Details</h2>
            <div>
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>

            <h2>Doctor Details</h2>
            <div>
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div>
                <label for="specialty">Specialty:</label>
                <input type="text" name="specialty" id="specialty" required>
            </div>
            <div>
                <label for="qualifications">Qualifications:</label>
                <textarea name="qualifications" id="qualifications" required></textarea>
            </div>
            <div>
                <label for="contact_info">Contact Info:</label>
                <input type="text" name="contact_info" id="contact_info" required>
            </div>

            <button type="submit">Add Staff</button>
        </form>
        <a href="manage_staff.php" class="btn">Back to Manage Staff</a>
    </section>

    <?php include '../includes/footer.php'; ?>
</body>
</html>