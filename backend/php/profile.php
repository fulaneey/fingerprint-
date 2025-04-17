<?php
session_start();
include_once('connection.php');

// Assuming you're getting user ID from the session
$userId = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $rank = $_POST['rank'];
    $department = $_POST['department'];
    $staffID = $_POST['staffID']; // This should be generated and captured
    $address_staff = $_POST['address_staff'];
    $nextOfKinName = $_POST['nextOfKinName'];
    $nextOfKinPhone = $_POST['nextOfKinPhone'];

    // Prepare to check if the record exists
    $stmt = $conn->prepare("SELECT * FROM user_profiles WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Record exists, perform an update
        $stmt = $conn->prepare("UPDATE user_profiles SET date_of_birth = ?, phone_number = ?, rank_level = ?, department = ?, address_staff = ?, next_of_kin_name = ?, next_of_kin_phone = ? WHERE user_id = ?");
        $stmt->bind_param("sssssssi", $dob, $phone, $rank, $department, $address_staff, $nextOfKinName, $nextOfKinPhone, $userId);
        
        if ($stmt->execute()) {
            echo "Profile updated successfully.";
        } else {
            echo "Error updating profile: " . $stmt->error;
        }
    } else {
        // Record does not exist, perform an insert
        $stmt = $conn->prepare("INSERT INTO user_profiles (user_id, date_of_birth, phone_number, rank_level, department, staff_id, address_staff, next_of_kin_name, next_of_kin_phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ississsss", $userId, $dob, $phone, $rank, $department, $staffID, $address_staff, $nextOfKinName, $nextOfKinPhone);
        
        if ($stmt->execute()) {
            echo "Profile saved successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
