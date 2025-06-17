<?php
if (!isset($_SESSION)) {
    session_start();
    require dirname(__DIR__) . '/database/dbconfig.php';
}

//echo $_SESSION['id'];

//echo $_SESSION['user_session_id'];

$query = "SELECT user_session_id FROM students WHERE id = '" . $_SESSION['id'] . "'";

$result = mysqli_query($connection, $query);

foreach ($result as $row) {
    if ($_SESSION['user_session_id'] != $row['user_session_id']) {
        $data['output'] = 'logout';
    } else {
        $data['output'] = 'login';
    }
}

echo json_encode($data);