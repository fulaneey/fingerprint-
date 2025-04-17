<?php
/*
 * Author: Dahir Muhammad Dahir
 * Date: 26-April-2020 12:41 AM
 * About: this file is responsible
 * for all Database queries
 */

namespace fingerprint;
require_once("../core/Database.php");

function setUserFmds($user_id, $index_finger_fmd_string, $middle_finger_fmd_string){
    $myDatabase = new Database();
    $sql_query = "update users set indexfinger=?, middlefinger=? where id=?";
    $param_type = "ssi";
    $param_array = [$index_finger_fmd_string, $middle_finger_fmd_string, $user_id];
    $affected_rows = $myDatabase->update($sql_query, $param_type, $param_array);

    if($affected_rows > 0){
        return "success";
    }
    else{
        return "failed in querydb";
    }
}

function getUserFmds($user_id){
    $myDatabase = new Database();
    $sql_query = "select indexfinger, middlefinger from users where id=?";
    $param_type = "i";
    $param_array = [$user_id];
    $fmds = $myDatabase->select($sql_query, $param_type, $param_array);
    return json_encode($fmds);
}

function getUserDetails($user_id){
    $myDatabase = new Database();
    $sql_query = "select id, username, fullname from users where id=?";
    $param_type = "i";
    $param_array = [$user_id];
    $user_info = $myDatabase->select($sql_query, $param_type, $param_array);
    return json_encode($user_info);
}

function getAllFmds(){
    $myDatabase = new Database();
    $sql_query = "select indexfinger, middlefinger from users where indexfinger != ''";
    $allFmds = $myDatabase->select($sql_query);
    return json_encode($allFmds);
}





// King
// function clockin($user_id){
//     $myDatabase = new Database();
//     $currentDate = date('Y-m-d'); // Format: YYYY-MM-DD
//     $sql_query = "SELECT attendance.attendance_date, users.fullname FROM attendance JOIN users ON attendance.user_id  = users.id  WHERE attendance.user_id = $user_id AND attendance.attendance_date = '$currentDate' LIMIT 1";

//     $allFmds = $myDatabase->select($sql_query);

//     $fullname = $allFmds ? $allFmds[0]["fullname"] : "no name";
    
// $currentTime = date('H:i:s'); // Format: HH:MM:SS
//     if ($allFmds == null) {

//         $query = "INSERT INTO attendance (user_id, attendance_date, sign_in_time) VALUES (?, ?, ?)";

//         $sql_param_type = "iss";  // 'i' for integer, 's' for string, 's' for string
//         $allFmdsExecute = $myDatabase->insert($query, $sql_param_type, [$user_id, $currentDate, $currentTime]);
              
//         $sql_que = "SELECT fullname FROM users WHERE id = $user_id";
//         $allFmds = $myDatabase->select($sql_que);
//         $fullname = $allFmds ? $allFmds[0]["fullname"] : "no name";

//         $response = [
//             "status" => "success",
//             "message" => "Sign-in for the day successfully recorded.",
//             "data" => [
//                 "user_id" => $user_id,
//                 "fullname" => $fullname,
//                 "attendance_date" => $currentDate,
//                 "sign_out_time" => $currentTime,
//             ],
//         ];
//         return json_encode($response);

//     } else {
//         $query = "UPDATE attendance SET sign_out_time = ? WHERE user_id = $user_id AND attendance_date = '$currentDate' LIMIT 1";
//         $sql_param_type = "s";  
//         $allFmdsExecute = $myDatabase->update($query, $sql_param_type, [$currentTime]);
              
//         $response = [
//             "status" => "success",
//             "message" => "Sign-out for the day successfully recorded.",
//             "data" => [
//                 "user_id" => $user_id,
//                 "fullname" => $fullname,
//                 "attendance_date" => $currentDate,
//                 "sign_out_time" => $currentTime,
//             ],
//         ];
//         return json_encode($response);

//     }

// }



function clockin($user_id) {
    $myDatabase = new Database();
    $currentDate = date('Y-m-d'); // Format: YYYY-MM-DD
    $currentTime = date('H:i:s'); // Format: HH:MM:SS

    // Get all attendance records for the user today
    $sql_que = "SELECT * FROM attendance WHERE user_id = ? AND attendance_date = ?";
    $allFmds = $myDatabase->select($sql_que, "is", [$user_id, $currentDate]);

    // Ensure $allFmds is an array before using count()
    if (!is_array($allFmds)) {
        $allFmds = []; // Set to an empty array if the query returns null
    }

    // Determine the action type (Sign-in or Sign-out)
    $actionType = (count($allFmds) % 2 == 0) ? "Sign-in" : "Sign-out";

    // Insert new attendance record with alternating sign-in/sign-out
    $query = "INSERT INTO attendance (user_id, attendance_date, time, action_type) VALUES (?, ?, ?, ?)";
    $sql_param_type = "isss";  
    $allFmdsExecute = $myDatabase->insert($query, $sql_param_type, [$user_id, $currentDate, $currentTime, $actionType]);

    // Get the user's full name and role
    $sql_user = "SELECT fullname, role FROM users WHERE id = ?";
    $userData = $myDatabase->select($sql_user, "i", [$user_id]);
    $fullname = $userData ? $userData[0]["fullname"] : "no name";
    $role = $userData ? $userData[0]["role"] : "user"; // Default role if not found

    // Log the user in by setting session variables
    session_start();
    $_SESSION['loggedin'] = true;
    $_SESSION['user_id'] = $user_id;
    $_SESSION['role'] = $role;

    // Return response
    $response = [
        "status" => "success",
        "message" => "$actionType for the day successfully recorded. You are now logged in.",
        "data" => [
            "user_id" => $user_id,
            "fullname" => $fullname,
            "attendance_date" => $currentDate,
            "time" => $currentTime,
            "action_type" => $actionType,
            "role" => $role,
        ],
    ];

    return json_encode($response);
}

