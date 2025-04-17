<?php
// Include database connection
require_once '../backend/php/connection.php';

if (isset($_GET['id'])) {
    $requestId = $_GET['id'];

    // Fetch the denial reason
    $sql = "SELECT admin_reason FROM leave_requests WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $requestId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode([
            'success' => true,
            'reason' => $row['admin_reason']
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'reason' => 'Reason not found.'
        ]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode([
        'success' => false,
        'reason' => 'Invalid request.'
    ]);
}
?>