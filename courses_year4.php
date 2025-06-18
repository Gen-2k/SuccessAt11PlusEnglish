<?php
session_start();
if (isset($_GET['lan'])) {
    $_SESSION['classid'] = $_GET['lan'];
}
include('navbar2.php');
include('courses/Year4.php');
include('footer.php');