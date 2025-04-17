<?php
// Include database connection
require_once '../backend/php/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get request ID, action (approve/deny), and admin reason (if provided)
    $id = $_POST['id'];
    $action = $_POST['action'];
    $admin_reason = isset($_POST['admin_reason']) ? $_POST['admin_reason'] : null;

    // Validate the action value
    if ($action === 'approved' || $action === 'denied') {
        // Prepare the SQL query based on the action
        if ($action === 'denied' && $admin_reason) {
            // Update status and admin_reason for denied requests
            $stmt = $conn->prepare("UPDATE leave_requests SET status = ?, admin_reason = ? WHERE id = ?");
            $stmt->bind_param("ssi", $action, $admin_reason, $id);
        } else {
            // Update only the status for approved requests
            $stmt = $conn->prepare("UPDATE leave_requests SET status = ? WHERE id = ?");
            $stmt->bind_param("si", $action, $id);
        }

        // Execute the query
        if ($stmt->execute()) {
            // Redirect back to the leave request page with a success message
            header("Location: admin-view-break-request.php?status=success");
            exit();
        } else {
            // Handle error
            echo "Error updating status: " . $conn->error;
        }

        $stmt->close();
    } else {
        // Handle invalid action
        echo "Invalid action specified.";
    }
}

$conn->close();
?>