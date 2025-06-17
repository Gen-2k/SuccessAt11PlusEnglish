<?php
if (!isset($_SESSION)) {
    session_start();
    require dirname(__DIR__) . '/database/dbconfig.php';
}
// $_SESSION['ses_data_id'] = "";
if (isset($_GET['data_id'])) {
    $data_id = mysqli_real_escape_string($connection, $_GET['data_id']);
    $_SESSION['ses_data_id'] = $data_id;
    $query = "SELECT * FROM students WHERE id= '$data_id'";
    $query_run = mysqli_query($connection, $query);

    if (mysqli_num_rows($query_run) == 1) {
        $dataID = mysqli_fetch_array($query_run);

        $res = [
            'status' => 200,
            'message' => 'Data Fetch Successfully by id',
            'data' => $dataID
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 404,
            'message' => 'Data Id Not Found'
        ];
        echo json_encode($res);
        return;
    }
}

if (isset($_POST['update_profile'])) {
    $data_id = $_SESSION['ses_data_id'];
    // printf($data_id);
    $fname = $_POST['fname'];
    $sname = $_POST['surname'];
    $dob = date("Y-m-d", strtotime($_POST['dob']));

    $phone = $_POST['phone'];
    $address = $_POST['parentAdderss'];
    // printf($fname);
    $query = "UPDATE students SET fname='$fname', surname='$sname', dob='$dob', phone='$phone', address='$address' WHERE id='$data_id'";
    $queryRun = mysqli_query($connection, $query);
    if ($queryRun) {
        $res = [
            'status' => 200,
            'message' => 'Profile Updated Successfully'
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Unable to update, Try again sometime'
        ];
        echo json_encode($res);
        return;
    }
};

if (isset($_POST['password_change'])) {
    $data_id = $_SESSION['ses_data_id'];
    // printf($data_id);
    // $eMail = mysqli_real_escape_string($connection, $_POST['email']);
    // $oldPwd = mysqli_real_escape_string($connection, $_POST['oldPwd']);
    $eMail = $_POST['email'];
    $oldPwd = $_POST['oldPwd'];
    $newPwd = $_POST['conPwd'];

    if (!empty($eMail) && !empty($oldPwd)) {
        $query = "SELECT * FROM students WHERE id='$data_id'";
        $queryPwd = mysqli_query($connection, $query);
        $rowPwd = mysqli_fetch_array($queryPwd);
        if ($rowPwd['email'] == $eMail && $rowPwd['password'] == $oldPwd) {
            $queryPC = "UPDATE students SET password='$newPwd' WHERE id='$data_id'";
            $queryRPC = mysqli_query($connection, $queryPC);
            if ($queryRPC) {
                $res = [
                    'status' => 200,
                    'message' => 'Password Updated Successfully.',
                    'data' => $data_id
                ];
                echo json_encode($res);
                return;
            } else {
                $res = [
                    'status' => 500,
                    'message' => 'Password Not Changed.',
                    'data' => $data_id
                ];
                echo json_encode($res);
                return;
            }
        } else {
            $res = [
                'status' => 500,
                'message' => 'Invalid Password / Email Id.',
                'data' => $data_id
            ];
            echo json_encode($res);
            return;
        }
    }
};
