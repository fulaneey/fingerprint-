<?php

include_once('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect user data
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = 'user'; // Set default role

    // Prepare SQL statement to check if email already exists
    $checkEmailStmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $checkEmailStmt->bind_param("s", $email);
    $checkEmailStmt->execute();
    $checkEmailStmt->store_result();

    // Check if email already exists
    if ($checkEmailStmt->num_rows > 0) {
        // Email already exists
        echo json_encode(["success" => false, "message" => "Email already exists!"]);
    } else {
        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Prepare SQL statement to insert user data
        $stmt = $conn->prepare("INSERT INTO users (fullname, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $fullName, $email, $hashedPassword, $role);

        // Execute the statement
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Registration successful!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
        }

        // Close the statement
        $stmt->close();
    }

    // Close the email check statement and connection
    $checkEmailStmt->close();
    $conn->close();
}
