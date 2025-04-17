<?php
session_start();
include_once('connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $user_id = $_SESSION['user_id']; // Assuming user is logged in and user ID is stored in the session
    $leave_time = $_POST['leave_time'];
    $return_time = $_POST['return_time'];
    $reason = $_POST['reason'];

    // Validate the input (you can add more validation logic if necessary)
    if (empty($leave_time) || empty($return_time) || empty($reason)) {
        echo "All fields are required.";
        exit;
    }

    // Insert data into the leave_requests table
    $sql = "INSERT INTO leave_requests (user_id, leave_time, return_time, reason)
            VALUES (?, ?, ?, ?)";
    
    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters
        $stmt->bind_param("isss", $user_id, $leave_time, $return_time, $reason);
        
        // Execute the statement
        if ($stmt->execute()) {
            // Leave request submitted successfully
            echo "
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        $(document).ready(function() {
            Swal.fire({
                title: 'Success!',
                text: 'Your request has been submitted successfully.',
                icon: 'success',
                confirmButtonText: 'OK',
            }).then(() => {
                window.location.href = '../../view/view-break-request.php';
            });
        });
    </script>
    ";
        } else {
            echo "Error: " . htmlspecialchars($stmt->error);
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . htmlspecialchars($conn->error);
    }

    // Close the connection
    $conn->close();
}
?>