<?php
session_start();
include '../includes/db.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Check if ID is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the patient
    $sql = "DELETE FROM patients WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Patient deleted successfully.";
    } else {
        $_SESSION['message'] = "Error deleting patient.";
    }
}

// Redirect back
header("Location: manage_patients.php");
exit();
?>
