<?php
session_start();
session_unset();
session_destroy();

// For testing: Directly output HTML (bypass JSON)
if (isset($_GET['debug'])) {
    die("<h1>Logout Working!</h1><p>Session destroyed. <a href='login.php'>Login again</a>.</p>");
}

// Default JSON response
echo json_encode(["status" => "success"]);
?>