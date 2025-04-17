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
    $admin_pages = ['admin_dashboard.php', 'admin-view-break-request.php', 'admin-view-approved-request.php', 'admin-view-denied-request.php', 'admin_settings.php', 'admin-enroll.php']; // Add more admin pages here
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



    <!-- for modal -->
     <!-- Bootstrap CSS -->
<link rel="stylesheet" href="../../src/css/bootstrap.css">
<link rel="stylesheet" href="../../src/css/custom.css">

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- JavaScript Files -->
<script src="../src/js/jquery-3.5.0.min.js"></script>
<script src="../src/js/bootstrap.bundle.js"></script>
<script src="../src/js/es6-shim.js"></script>
<script src="../src/js/websdk.client.bundle.min.js"></script>
<script src="../src/js/fingerprint.sdk.min.js"></script>
<script src="../src/js/custom.js"></script>
<script src="../backend/js/load_users.js"></script>
<script src="../backend/js/hello.js"></script>
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="./admin_dashboard.php" class="text-nowrap logo-img">
                        <img src="../assets/images/logos/dark-logo.png" width="180" alt="" />
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Home</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="./admin_dashboard.php" aria-expanded="false">
                                <span>
                                    <i class="ti ti-layout-dashboard"></i>
                                </span>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Actions</span>
                        </li>
                       
                        
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="./admin-view-break-request.php" aria-expanded="false">
                                <span>
                                    <i class="ti ti-cards"></i>
                                </span>
                                <span class="hide-menu"> View Break Request</span>
                            </a>
                        </li>
                         <li class="sidebar-item">
                            <a class="sidebar-link" href="./admin-view-denied-request.php" aria-expanded="false">
                                <span>
                                    <i class="ti ti-cards"></i>
                                </span>
                                <span class="hide-menu"> View Denied Request</span>
                            </a>
                        </li>
                         <li class="sidebar-item">
                            <a class="sidebar-link" href="./admin-view-approved-request.php" aria-expanded="false">
                                <span>
                                    <i class="ti ti-cards"></i>
                                </span>
                                <span class="hide-menu"> View Approved Request</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="\fingerprint\index.php" aria-expanded="false">
                                <span>
                                    <i class="ti ti-cards"></i>
                                </span>
                                <span class="hide-menu"> Enroll User</span>
                            </a>
                        </li>
                       
                    </ul>
                    
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                        <div role="">
                        <span class="badge bg-success rounded-3 fw-semibold">
   Welcome Admin
</span>

                        </div>
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <img src="../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="./profile.php" class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-user fs-6"></i>
                                            <p class="mb-0 fs-3">My Profile</p>
                                        </a>
                                        <!-- <a href="./change_password.php" class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-lock fs-6"></i>
                                            <p class="mb-0 fs-3">Change Password</p>
                                        </a> -->
                                       
                                        
                                        <a href="../backend/php/logout.php" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>