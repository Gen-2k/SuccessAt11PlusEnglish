<?php
session_id($_SESSION['user_session_id']);
session_start();
unset($_SESSION["id"]);
unset($_SESSION["name"]);
unset($_SESSION['gender']);
unset($_SESSION['logged_in']);
session_destroy();
header("Location: Login.php");
exit();
?>