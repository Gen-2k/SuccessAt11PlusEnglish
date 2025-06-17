<?php
session_start();
require dirname(__DIR__) . '/database/dbconfig.php';
// $_SESSION['ses_data_id'] = "";

if (isset($_POST['update_data'])) {

    $upload_dir = 'hwUploads/';
    // $allowed_types = array('jpg', 'png', 'jpeg', 'gif');
    $allowed_types = array('pdf', 'docx', 'mp3', '3gp', 'm4p');
    // Maxsize for files i.e 50MB
    $maxsize = 52428800;

    $data_id = $_SESSION['ses_data_id'];
    printf($data_id);
    $category = $_POST['category'];
    $subject = $_POST['subject'];
    // $files = mysqli_real_escape_string($connection, $_FILES['files']);

    $file_tmpname = $_FILES['files']['tmp_name'];
    $file_name = $_FILES['files']['name'];
    $file_size = $_FILES['files']['size'];
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

    // Set upload file path
    $filepath = $upload_dir . $file_name;


    if ($category == NULL || $subject == NULL || $file_name == NULL) {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return false;
    }
    if (in_array(strtolower($file_ext), $allowed_types)) {
        if ($file_size > $maxsize) {
            $res = [
                'status' => 100,
                'message' => 'File size is larger than the allowed limit.'
            ];
            echo json_encode($res);
            return false;
        } else if (move_uploaded_file($file_tmpname, $filepath)) {

            $query = "UPDATE addhomework SET Category= '$category', Subject= '$subject', Files= '$file_name', file_Path= '$filepath' WHERE Id= '$data_id'";
            $query_run = mysqli_query($connection, $query);
            // printf($query);
            if ($query_run) {
                $res = [
                    'status' => 200,
                    'message' => 'File Updated Successfully'
                ];
                echo json_encode($res);
                return;
            } else {
                $res = [
                    'status' => 500,
                    'message' => 'File Not Updated'
                ];
                echo json_encode($res);
                return;
            }
        } else {
            $res = [
                'status' => 500,
                'message' => 'File Not Updated'
            ];
            echo json_encode($res);
            return false;
        }
    }
    $res = [
        'status' => 200,
        'message' => 'Successfully Uploaded to Database'
    ];
    echo json_encode($res);
    return false;
}


if (isset($_GET['data_id'])) {
    $data_id = mysqli_real_escape_string($connection, $_GET['data_id']);
    $_SESSION['ses_data_id'] = $data_id;
    $query = "SELECT * FROM students WHERE id= '$data_id'";
    $query_run = mysqli_query($connection, $query);
    
    $termquery = "SELECT termname FROM terms_details WHERE student_id= '$data_id'";
    $termquery_run = mysqli_query($connection, $termquery);

    if (mysqli_num_rows($query_run) == 1) {
        $dataID = mysqli_fetch_array($query_run);
        $termName = mysqli_fetch_all($termquery_run, MYSQLI_ASSOC);
        $res = [
            'status' => 200,
            'message' => 'Data Fetch Successfully by id',
            'data' => $dataID,
            'term' => $termName
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

if (isset($_POST['delete_data']) =="delete_data") {
    
    $data_id = mysqli_real_escape_string($connection, $_POST['data_id']);
    
    $query = "DELETE FROM terms_details WHERE student_id= '$data_id'";
    $query_run = mysqli_query($connection, $query);

    $query = "DELETE FROM students WHERE id= '$data_id'";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $res = [
            'status' => 200,
            'message' => 'Student details deleted successfully...!'
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Data Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}



if (isset($_POST['action']) || isset($_POST['selLang']) || isset($_POST['selCat']) || isset($_POST['selTerm'])) {
    // mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $section = $_POST['action'];
    // $query = "SELECT * FROM addhomework WHERE Section= '$section'  AND Subject= '$subject' AND Terms= '$term' AND Category= '.$category.'";
    $query = "SELECT * FROM students WHERE role= '10' AND users_type = 'NewStudent'";
    // $query = "SELECT * FROM students INNER JOIN terms_details ON students.id=terms_details.student_id AND students.role= '10' AND students.users_type = 'NewStudent'";
    if (isset($_POST['selLang'])) {
        $subject = implode($_POST['selLang']);
        // Note: selLang now contains Years/Ages values (Year 4, Year 5, Year 6) instead of languages
        $query .= "AND Stu_Sub IN('" . $subject . "')";
    }
    // if (isset($_POST['selTerm'])) {
    //     $term = implode($_POST['selTerm']);
    //     // echo $term;
    //     // echo "<br>";
    //     $query .= "AND Terms IN('" . $term . "')";
    // }
    if (isset($_POST['selCat'])) {
        $status = implode($_POST['selCat']);
        // echo $status;
        // echo "<br>";
        $query .= "AND Stu_Status IN('" . $status . "')";
    }
    if (isset($_POST['stuCat'])) {
        $stuCat = implode($_POST['stuCat']);
        $query .= "AND Stu_Cat IN('" . $stuCat . "')";
    }
    if (isset($_POST['selTerm'])) {
        $selTerm = implode($_POST['selTerm']);
        $query .= "AND Stu_Term IN('" . $selTerm . "')";
    }
$query .= "ORDER BY id DESC";
    $query_run = mysqli_query($connection, $query);
    $output = '';
    if (mysqli_num_rows($query_run) > 0) {
        $result = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

        //print_r($result);
        //die();
        $serialNumber = 1;
        foreach ($result as $row) {
            $dateFormat = date('d-m-Y', strtotime($row['dob']));
            if ($row['Stu_Status'] == 'Live') {
                $output .= '<tr class="align-middle" id = row' . $row['id'] . ' >
                                    <td> ' . $serialNumber . '</td>
                                    <td>' . $row['fname'] . '</td>
                                    <td>' . $row['Stu_Cat'] . '</td>
                                    <td>' . $row['Stu_Sub'] . '</td>
                                    <td>' . $dateFormat . '</td>
                                    <td class="bg-success text-white">' . $row['Stu_Status'] . '</td>
                                    <td>
                                        <button type="button" value="' . $row['id'] . '" class="viewDatatBtn viewBtn btn btn-sm shadow-none fs-6 fw-bold"><i class="fa-regular fa-eye mx-2"></i>VIEW</button>
                                    </td>
                                    <td>
                                        <button type="button" value="' . $row['id'] . '" class="editDataBtn btn btn-warning btn-sm shadow-none fs-6 fw-bold"><i class="fa-regular fa-pen-to-square mx-2"></i>EDIT</button>
                                    </td>
                                    <td>
                                        <button type="button" value="' . $row['id'] . '" class="deleteDataBtn btn btn-danger btn-sm shadow-none fs-6 fw-bold"><i class="fa-solid fa-trash-can mx-1"></i>DELETE</button>
                                    </td>
                                    
                                </tr>';
            } else if ($row['Stu_Status'] == 'Pending') {
                $output .= '<tr class="align-middle" id = row' . $row['id'] . '>
                                    <td> ' . $serialNumber . '</td>
                                    <td>' . $row['fname'] . '</td>
                                    
                                    <td>' . $row['Stu_Cat'] . '</td>
                                    <td>' . $row['Stu_Sub'] . '</td>
                                    <td>' . $dateFormat . '</td>
                                    <td class="bg-danger text-white">' . $row['Stu_Status'] . '</td>
                                    <td>
                                        <button type="button" value="' . $row['id'] . '" class="viewDatatBtn viewBtn btn btn-sm shadow-none fs-6 fw-bold"><i class="fa-regular fa-eye mx-2"></i>VIEW</button>
                                    </td>
                                    <td>
                                        <button type="button" value="' . $row['id'] . '" class="editDataBtn btn btn-warning btn-sm shadow-none fs-6 fw-bold"><i class="fa-regular fa-pen-to-square mx-2"></i>EDIT</button>
                                    </td>
                                    <td>
                                        <button type="button" value="' . $row['id'] . '" class="deleteDataBtn btn btn-danger btn-sm shadow-none fs-6 fw-bold"><i class="fa-solid fa-trash-can mx-1"></i>DELETE</button>
                                    </td>
                                    
                                </tr>';
            }
            $serialNumber++;
        }
        echo $output;
    } else {
        $output .= '<td  colspan="7"><h3 class="fs-3 text-danger">DATA NOT FOUND</h3></td>';
        echo $output;
    }
}

// if(isset[$_POST['requestAction'] == 'email_note'){
//     echo 'request accepted';
// }

if (isset($_POST['discountAmt'])) {
    $dis_Amt = $_POST['dis_Amt'];
    $stu_Id = $_SESSION['ses_data_id'];
    $disQuery = "UPDATE students SET child_category = '$dis_Amt' WHERE id = '$stu_Id'";
    $disQRun = mysqli_query($connection, $disQuery);
    // echo $disQuery;
    if ($disQRun) {
        echo "Successfully updated";
    } else {
        echo "Failed to update";
    }
}