<?php
require('database/dbconfig.php');
if (!isset($_SESSION)) {
   session_start();
}

if (isset($_POST['login_submit'])) { // changed from 'submit' to 'login_submit'
   // Get and validate input
   $email = isset($_POST['username']) ? trim($_POST['username']) : '';
   $password = isset($_POST['password']) ? trim($_POST['password']) : '';
   
   // Server-side validation
   if (empty($email) || empty($password)) {
      $_SESSION['status_code'] = "Please enter both email and password.";
      header('Location: Login.php');
      exit();
   }
   
   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $_SESSION['status_code'] = "Please enter a valid email address.";
      header('Location: Login.php');
      exit();
   }
   
   if (strlen($password) < 3) {
      $_SESSION['status_code'] = "Password must be at least 3 characters long.";
      header('Location: Login.php');
      exit();
   }
   
   // Sanitize inputs for database query
   $email = mysqli_real_escape_string($connection, $email);
   $password = mysqli_real_escape_string($connection, $password);
   
   // Query database
   $query = "SELECT * FROM students WHERE email = '$email' AND password = '$password'";
   $query_run = mysqli_query($connection, $query);
   
   if (!$query_run) {
      $_SESSION['status_code'] = "Database error. Please try again later.";
      header('Location: Login.php');
      exit();
   }
   
   $row = mysqli_fetch_array($query_run);
   
   if (empty($row)) {
      $_SESSION['status_code'] = "Invalid email or password. Please check your credentials and try again.";
      header('Location: Login.php');
      exit();
   }
   
   // Successful login - set session variables
   $_SESSION['id'] = $row['id'];
   $_SESSION['name'] = $row['fname'];
   $_SESSION['gender'] = $row['gender'];
   $_SESSION['emailId'] = $email;
   $_SESSION['logged_in'] = true;
   
   // Role-based redirection
   if ($row['role'] === 'admin') {
      session_regenerate_id();
      $user_session_id = session_id();
      $updateSession = "UPDATE students SET user_session_id = '$user_session_id' WHERE id = '" . $row['id'] . "'";
      mysqli_query($connection, $updateSession);
      $_SESSION['user_session_id'] = $user_session_id;
      $_SESSION['role'] = 'admin';
      $_SESSION['user_id'] = $row['id'];
      header('Location: NewAdminPanel/');
      exit();
   } elseif ($row['role'] === 'user') {
      session_regenerate_id();
      $user_session_id = session_id();
      $updateSession = "UPDATE students SET user_session_id = '$user_session_id' WHERE id = '" . $row['id'] . "'";
      mysqli_query($connection, $updateSession);
      $_SESSION['user_session_id'] = $user_session_id;
      $_SESSION['role'] = 'user';
      header('Location: StudentDashboard/');
      exit();
   } else {
      // Unknown role
      $_SESSION['status_code'] = "Account access error. Please contact support.";
      header('Location: Login.php');
      exit();
   }
} else {
   // Direct access without form submission
   header('Location: Login.php');
   exit();
}
