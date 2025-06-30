<?php
if (!isset($_SESSION)) {
    session_start();
}

// Clear all session data
if (isset($_SESSION['user_session_id'])) {
    session_id($_SESSION['user_session_id']);
}

// Unset all session variables
$_SESSION = array();

// Delete the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Clear remember me cookies
setcookie("username", "", time() - 3600, "/Login");
setcookie("password", "", time() - 3600, "/Login");

// Redirect to login page
header("Location: Login.php");
exit();
?>