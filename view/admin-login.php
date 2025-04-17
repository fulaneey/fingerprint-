<?php
session_start(); // Start the session

// Function to handle redirection
function redirectTo($location)
{
  header("Location: $location");
  exit(); // Ensures no further code is executed after redirection
}

// Check if the user is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
  // Check if the current page is the dashboard
  $current_page = basename($_SERVER['PHP_SELF']);

  // Redirect based on the user's role
  if ($_SESSION['role'] === 'admin') {
    if ($current_page !== 'admin_dashboard.php') {
      redirectTo('admin_dashboard.php'); // Redirect admin to admin dashboard
    }
  } else {
    if ($current_page !== 'dashboard.php') {
      redirectTo('dashboard.php'); // Redirect regular user to user dashboard
    }
  }
} else {
  // User is not logged in, redirect to login page
  $current_page = basename($_SERVER['PHP_SELF']);
  if ($current_page !== 'admin-login.php') {
    redirectTo('login.php'); // Redirect to login if not logged in
  }
}

// If the user is already on the correct page, do nothing further
// Your HTML or other content can go here, but it won't execute if the user is redirected above.
?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Attendance Management System - KEDC</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />

  <style>
  .custom-badge {
      padding: 0.5rem 1rem;
      font-size: 3rem;
      color: green;
  }
</style>
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
                <h1 class="text-center custom-badge">Admin Login</h1>
                <p class="text-center">Kaduna Electricity Distribution Company
                </p>

                <form action="#" onsubmit="return false">
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" required>
                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" required>
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                      <input class="form-check-input primary" type="checkbox" value="" id="rememberDevice" checked>
                      <label class="form-check-label text-dark" for="rememberDevice">Remember this Device</label>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2"
                    onclick="loginUser();">Sign In</button>
                    <a href="\fingerprint\src\html\verify.html" class="btn btn-danger w-100 py-8 fs-4 mb-4 rounded-2">Return</a>
                  <div class="d-flex align-items-center justify-content-center">
                   
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


  <script src="../backend/js/login.js"></script>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>