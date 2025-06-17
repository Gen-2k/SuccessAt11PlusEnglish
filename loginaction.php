<?php
require('database/dbconfig.php');
if (!isset($_SESSION)) {
   session_start();
}

if (isset($_POST['submit'])) {

   $uname = mysqli_real_escape_string($connection, $_POST['username']);

   $password = mysqli_real_escape_string($connection, $_POST['password']);
   $_SESSION['emailId'] = $uname;
   if ($uname != '' && $password != '') {
      $query = "SELECT * FROM students WHERE email = '$uname' AND password ='$password'";
      $query_run = mysqli_query($connection, $query);
      $row = mysqli_fetch_array($query_run);
      if (empty($row)) {
         $_SESSION['status_code'] = "Invaild Login Credentials!";
         header('Location:Login');
         exit();
      }
      // New role-based login flow
      $_SESSION['id'] = $row['id'];
      $_SESSION['name'] = $row['fname'];
      $_SESSION['gender'] = $row['gender'];
      $_SESSION['user_session_id'] = session_id();
      $_SESSION['logged_in'] = true;      // Admin
      if ($row['role'] === 'admin') {
         session_regenerate_id();
         $user_session_id_admin = session_id();
         $adminSession = "UPDATE students SET user_session_id = '$user_session_id_admin' WHERE id = '" . $row['id'] . "'";
         mysqli_query($connection, $adminSession);
         $_SESSION['user_session_id'] = $user_session_id_admin;
         $_SESSION['role'] = 'admin';
         $_SESSION['user_id'] = $row['id'];
         header('Location:NewAdminPanel/');
         exit();
      }      // Student
      if ($row['role'] === 'user') {
         session_regenerate_id();
         $user_session_id_user = session_id();
         $userSession = "UPDATE students SET user_session_id = '$user_session_id_user' WHERE id = '" . $row['id'] . "'";
         mysqli_query($connection, $userSession);
         $_SESSION['user_session_id'] = $user_session_id_user;
         $_SESSION['role'] = 'user';
         header('Location:StudentDashboard/');
         exit();
      }
      // Fallback: unknown role
      $_SESSION['status_code'] = "Unknown user role. Please contact support.";
      header('Location:Login');
      exit();
   } else {
      header('Location:Login');
      exit();
   }
}
