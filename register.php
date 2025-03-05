<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    try {
        // Insert into users table
        $sql = "INSERT INTO users (username, password, role) VALUES (:username, :password, 'patient')";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        // Get the last inserted user ID
        $user_id = $conn->lastInsertId();

        // Insert into patients table
        $sql = "INSERT INTO patients (user_id, full_name, email, phone, address) VALUES (:user_id, :full_name, :email, :phone, :address)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->execute();

        echo "<p>Registration successful! <a href='login.php'>Login here</a>.</p>";
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
    <title>Register - Care Compass Hospitals</title>
    <link rel="stylesheet" href="assets/css/register.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="main-register-container">
    <div class="register-container">
        <div class="register-box">
            <div class="logo">
                <img src="assets/images/logo.png" alt="Care Compass Hospitals Logo">
            </div>
            <h1>Patient Registration</h1>
            <p>Create an account to access our services</p>
            <form method="POST" action="">
                <div class="input-group">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="input-group">
                    <input type="text" name="full_name" placeholder="Full Name" required>
                </div>
                <div class="input-group">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-group">
                    <input type="text" name="phone" placeholder="Phone" required>
                </div>
                <div class="input-group">
                    <textarea name="address" placeholder="Address" required></textarea>
                </div>
                <button type="submit" class="register-btn">Register</button>
            </form>
            <p class="login-link">Already have an account? <a href="login.php">Login here</a>.</p>
        </div>
    </div>
    <div class="Register-big-ImgBox">
    <div class="logo">
        <img src=https://nbhc.ca/sites/default/files/assets/images/Article%20image.jpg alt="Care Compass Hospitals Logo">
    </div>
    </div>
</div>
</body>
</html>