<?php
// Include database connection
require_once '../backend/php/connection.php';

// Check if ID is provided
if (isset($_GET['id'])) {
    $request_id = $_GET['id'];
} else {
    // Redirect if no ID is provided
    header("Location: view-break-request.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_return_time = $_POST['new_return_time'];
    $extension_reason = $_POST['extension_reason'];

    // Update the request with the extension details (you may modify the database schema if needed)
    $sql = "UPDATE leave_requests SET return_time = ?, extension_reason = ?, status = 'pending' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $new_return_time, $extension_reason, $request_id);

    if ($stmt->execute()) {
        // Redirect to the break requests page or show a success message
        header("Location: view-break-request.php?msg=extension_requested");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Extension</title>
</head>
<body>
    <h2>Request Extension</h2>
    <form method="post" action="request_extension.php?id=<?php echo $request_id; ?>">
        <div>
            <label for="new_return_time">New Return Time:</label>
            <input type="datetime-local" id="new_return_time" name="new_return_time" required>
        </div>
        <div>
            <label for="extension_reason">Reason for Extension:</label>
            <textarea id="extension_reason" name="extension_reason" required></textarea>
        </div>
        <div>
            <button type="submit">Submit Request</button>
        </div>
    </form>
</body>
</html>
