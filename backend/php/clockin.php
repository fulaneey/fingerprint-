<?php
session_start();
include_once('connection.php');

// Get the user_id from the query string
if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id']; // Get the user ID passed in the URL
} else {
    echo "User ID is missing!";
    exit;
}

// Get the current date and time
$currentDate = date('Y-m-d'); // Format: YYYY-MM-DD
$currentTime = date('H:i:s'); // Format: HH:MM:SS

// Prepare the SQL query to insert the data into the attendance table
$query = "INSERT INTO attendance (user_id, date, sign_in_time) 
          VALUES (?, ?, ?)";

// Prepare the statement
if ($stmt = $conn->prepare($query)) {
    // Bind the parameters
    $stmt->bind_param('iss', $userId, $currentDate, $currentTime);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Attendance recorded successfully!";
    } else {
        echo "Error recording attendance: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error preparing the query: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
