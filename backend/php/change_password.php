<?php
session_start();
include_once('connection.php');

// Assuming you're getting the user ID from the session
$userId = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];
    $confirmNewPassword = $_POST['confirm_new_password'];

    // Check if the new passwords match
    if ($newPassword !== $confirmNewPassword) {
        echo "New passwords do not match.";
        exit;
    }

    // Fetch the current password from the database
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify the old password
    if (password_verify($oldPassword, $user['password'])) {
        // Hash the new password
        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the password in the database
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashedNewPassword, $userId);

        if ($stmt->execute()) {
            echo "Password reset successfully.";
        } else {
            echo "Error updating password: " . $stmt->error;
        }
    } else {
        echo "Old password is incorrect.";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
