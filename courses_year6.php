<?php

session_start();
$_SESSION['classid'] = $_GET['lan'];

include('navbar2.php');
include('courses/Year6.php');
include('footer.php');
