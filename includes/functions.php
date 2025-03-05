<?php
// Function to display error messages
function displayError($message) {
    echo "<div class='error-message'>$message</div>";
}

// Function to display success messages
function displaySuccess($message) {
    echo "<div class='success-message'>$message</div>";
}

// Function to sanitize user input
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Function to check if user is an admin
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

// Function to redirect users
function redirect($url) {
    header("Location: $url");
    exit();
}
?>