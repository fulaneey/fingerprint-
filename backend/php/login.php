<?php

session_start(); // Start the session

include_once('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    $email = $input['email'];
    $password = $input['password'];

    // Prepare SQL statement to get user details
    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashedPassword, $role);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Set session variables
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $id; // Set user id session variable if needed
            $_SESSION['role'] = $role;

            // Set response headers and send the response
            header('Content-Type: application/json');
            echo json_encode(["success" => true, "role" => $role]);
        } else {
            header('Content-Type: application/json');
            echo json_encode(["success" => false, "message" => "Invalid password."]);
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode(["success" => false, "message" => "User not found."]);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
