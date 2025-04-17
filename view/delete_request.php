<?php
require_once '../backend/php/connection.php';

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $request_id = intval($_GET['id']); // Ensure it's an integer to prevent SQL injection

    // Prepare the DELETE SQL statement
    $sql = "DELETE FROM leave_requests WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    // Bind the 'id' parameter to the query
    $stmt->bind_param("i", $request_id);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to the break requests page with a success message
        header("Location: view-break-request.php?msg=deleted");
        exit();
    } else {
        echo "Error deleting record: " . htmlspecialchars($stmt->error);
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect if the 'id' is not set
    header("Location: view-break-request.php?msg=error");
    exit();
}
