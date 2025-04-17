<?php
session_start(); // Start the session

// Function to handle redirection
function redirectTo($location)
{
  header("Location: $location");
  exit(); // Ensures no further code is executed after redirection
}

// Get the current page name
$current_page = basename($_SERVER['PHP_SELF']);

// Pages that don't require login (signup, login, etc.)
$public_pages = ['login.php', 'signup.php'];

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
  // Define allowed pages for admin and user
  $admin_pages = ['admin_dashboard.php', 'admin-view-break-request.php', 'admin-view-approved-request.php', 'admin-view-denied-request.php', 'admin_settings.php']; // Add more admin pages here
  $user_pages = ['dashboard.php', 'user_profile.php', 'user_leave_requests.php']; // Add more user pages here

  if ($_SESSION['role'] === 'admin') {
    // If the user is an admin, allow access to admin pages only
    if (!in_array($current_page, $admin_pages)) {
      redirectTo('admin_dashboard.php'); // Redirect to admin dashboard if trying to access a non-admin page
    }
  } elseif ($_SESSION['role'] === 'user') {
    // If the user is a regular user, allow access to user pages only
    if (!in_array($current_page, $user_pages)) {
      redirectTo('dashboard.php'); // Redirect to user dashboard if trying to access a non-user page
    }
  }
} else {
  // User is not logged in, allow access to public pages (like signup, login)
  if (!in_array($current_page, $public_pages)) {
    redirectTo('login.php'); // Redirect to login if not logged in
  }
}
?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Attendance Management System - KEDC</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="../assets/images/logos/dark-logo.png" width="180" alt="">
                </a>
                <p class="text-center">Kaduna Electricity Distribution Company</p>
                <!-- <form id="signupForm" onsubmit="event.preventDefault(); registerUser();"> -->
                    <form action="#" onsubmit="return false">
                        <div class="mb-3">
                        <label for="fullName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullName" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword" required>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="form-check">
                            <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" >
                            <label class="form-check-label text-dark" for="flexCheckChecked">
                                Remember this Device
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2"onclick="registerUser();">Sign Up</button>
                    <a href="http://localhost/FingerPrint/view/" class="btn btn-danger w-100 py-8 fs-4 mb-4 rounded-2">Return</a>

                    <div class="d-flex align-items-center justify-content-center">
                        <p class="fs-4 mb-0 fw-bold">Already have an account?</p>
                        <a class="text-primary fw-bold ms-2" href="./login.php">Sign In</a>
                    </div>

                    <div id="responseMessage"></div>
                </form>
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  

  <script src="../backend/js/signup.js"></script>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>