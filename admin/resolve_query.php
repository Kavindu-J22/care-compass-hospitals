<?php
session_start();
include '../includes/db.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Check if query ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Invalid request.";
    exit();
}

$query_id = $_GET['id'];

// Fetch the relevant query details
$sql = "SELECT queries.*, patients.full_name 
        FROM queries 
        JOIN patients ON queries.patient_id = patients.id 
        WHERE queries.id = :query_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':query_id', $query_id, PDO::PARAM_INT);
$stmt->execute();
$query = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$query) {
    echo "Query not found.";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = $_POST['response'];
    $status = $_POST['status'];

    // Update query response and status
    $update_sql = "UPDATE queries SET response = :response, status = :status WHERE id = :query_id";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bindParam(':response', $response, PDO::PARAM_STR);
    $update_stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $update_stmt->bindParam(':query_id', $query_id, PDO::PARAM_INT);

    if ($update_stmt->execute()) {
        echo "<script>alert('Query updated successfully!'); window.location.href='manage_queries.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error updating query.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resolve Query - Care Compass Hospitals</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <section class="resolve-query">
        <h1>Resolve Query</h1>
        <form method="post">
            <label for="patient_name">Patient Name:</label>
            <input type="text" id="patient_name" value="<?php echo htmlspecialchars($query['full_name']); ?>" disabled>

            <label for="query_text">Query:</label>
            <textarea id="query_text" disabled><?php echo htmlspecialchars($query['query']); ?></textarea>

            <label for="response">Response:</label>
            <textarea id="response" name="response" required><?php echo htmlspecialchars($query['response']); ?></textarea>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="pending" <?php echo ($query['status'] === 'pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="resolved" <?php echo ($query['status'] === 'resolved') ? 'selected' : ''; ?>>Resolved</option>
            </select>

            <button type="submit">Update</button>
        </form>
    </section>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
