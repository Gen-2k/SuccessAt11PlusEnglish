<?php
session_start();
require dirname(__DIR__) . '/database/dbconfig.php';

if (isset($_POST['save_data'])) {

    $upload_dir = 'hwUploads/';
    // $allowed_types = array('jpg', 'png', 'jpeg', 'gif');
    $allowed_types = array('pdf', 'docx');
    // Maxsize for files i.e 50MB
    $maxsize = 52428800;

    // Checks if user sent an empty form

    // if (!empty(array_filter($_FILES['files']['name']))) {

    // Loop through each file in files[] array
    // foreach ($_FILES['files']['tmp_name'] as $key => $value) {
    $category = $_POST['category'];
    $subject = $_POST['subject'];
    $terms = $_POST['terms'];
    $date = $_POST['addDate'];
    $title = mysqli_real_escape_string($connection,$_POST['title']);
    $description = mysqli_real_escape_string($connection,$_POST['description']);
    $section = $_POST['section'];

    $file_tmpname = $_FILES['files']['tmp_name'];
    $file_name = $_FILES['files']['name'];
    $file_size = $_FILES['files']['size'];
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

    // Set upload file path
    $filepath = $upload_dir . $file_name;
    // if ($file_name == NULL || $date == NULL) {
    // $res = [
    // 'status' => 422,
    // 'message' => 'All fields are mandatory'
    // ];
    // echo json_encode($res);
    // return;
    // }
    // Check file type is allowed or not
    if (in_array(strtolower($file_ext), $allowed_types)) {
        if ($file_size > $maxsize) {
            $res = [
                'status' => 100,
                'message' => 'File size is larger than the allowed limit.'
            ];
            echo json_encode($res);
            return false;
        } else if (file_exists($filepath)) {
            $filepath = $upload_dir . $file_name . time();

            if (move_uploaded_file($file_tmpname, $filepath)) {
                $insertQuery = "INSERT INTO addhomework(Section, Category, Subject, Terms, Title, Files, file_Path, Description, Date) VALUES('$section', '$category', '$subject', '$terms', '$title', '$file_name', '$filepath', '$description', '$date')";
                $queryRun = mysqli_query($connection, $insertQuery);
            } else {
                $res = [
                    'status' => 500,
                    'message' => 'Files Not Uploaded'
                ];
                echo json_encode($res);
                return;
            }
        } else {

            if (move_uploaded_file($file_tmpname, $filepath)) {
                $insertQuery = "INSERT INTO addhomework(Section, Category, Subject, Terms, Title, Files, file_Path, Description, Date) VALUES('$section', '$category', '$subject', '$terms', '$title', '$file_name', '$filepath', '$description', '$date')";
                $queryRun = mysqli_query($connection, $insertQuery);

                $res = [
                    'status' => 200,
                    'message' => 'Cultural Added Successfully...!'
                ];
                echo json_encode($res);
                return;
            } else {
                $res = [
                    'status' => 500,
                    'message' => 'Files Not Uploaded'
                ];
                echo json_encode($res);
                return;
            }
        }
    } else {
        $res = [
            'status' => 500,
            'message' => 'Invaild file format...?'
        ];
        echo json_encode($res);
        return false;
    }
    // }
    // } else {
    //     $res = [
    //         'status' => 422,
    //         'message' => 'No files selected.'
    //     ];
    //     echo json_encode($res);
    //     return false;
    // }
    $res = [
        'status' => 200,
        'message' => 'Cultural Added Successfully...!'
    ];
    echo json_encode($res);
    return false;
}

if (isset($_POST['update_data'])) {
    // print_r($_POST);
    // echo '<pre>';
    // print_r($_FILES);
    // die();
    $upload_dir = 'hwUploads/';
    // $allowed_types = array('jpg', 'png', 'jpeg', 'gif');
    $allowed_types = array('pdf', 'docx');
    // Maxsize for files i.e 50MB
    $maxsize = 52428800;

    $data_id = $_SESSION['ses_data_id'];
    // printf($data_id);
    $description =mysqli_real_escape_string($connection,$_POST['description']);
    $title = mysqli_real_escape_string($connection, $_POST['title']);
    $category = $_POST['category'];
    $subject = $_POST['subject'];
    $oldfile = $_POST['oldfiles'];
    // $files = mysqli_real_escape_string($connection, $_FILES['files']);

    $file_tmpname = $_FILES['files']['tmp_name'];
    $file_name = $_FILES['files']['name'];
    $file_size = $_FILES['files']['size'];
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

    // Set upload file path
    $filepath = $upload_dir . $file_name;


    if ($category == NULL || $subject == NULL) {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return false;
    }
    if (!empty($_FILES['files']['tmp_name'])) {
        if (in_array(strtolower($file_ext), $allowed_types)) {
            if ($file_size > $maxsize) {
                $res = [
                    'status' => 100,
                    'message' => 'File size is larger than the allowed limit.'
                ];
                echo json_encode($res);
                return false;
            } else if (move_uploaded_file($file_tmpname, $filepath)) {

                $query = "UPDATE addhomework SET Title='$title', Category= '$category', Subject= '$subject', Files= '$file_name', file_Path= '$filepath', Description= '$description' WHERE Id= '$data_id'";
                $query_run = mysqli_query($connection, $query);
                // printf($query);
                //$oldfile
                if ($query_run) {
                    unlink($oldfile);
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
    } else {
        $query = "UPDATE addhomework SET Title='$title', Category= '$category', Subject= '$subject', Description= '$description' WHERE Id= '$data_id'";
        $query_run = mysqli_query($connection, $query);
    }
    $res = [
        'status' => 200,
        'message' => 'Successfully Uploaded to Database'
    ];
    echo json_encode($res);
    return false;
}
if (isset($_POST['action']) || isset($_POST['selLang']) || isset($_POST['selTerm']) || isset($_POST['selCat'])) {
    // mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $section = $_POST['action'];
    // echo $section;
    // echo "<br>";
    // $subject = implode($_POST['selLang']);
    // echo $subject;
    // echo "<br>";
    // $term = implode("','", $_POST['selTerm']);
    // echo $term;
    // echo "<br>";
    // $category = implode($_POST['selCat']);
    // echo $category;
    // echo "<br>";
    // $query = "SELECT * FROM addhomework WHERE Section= '$section'  AND Subject= '$subject' AND Terms= '$term' AND Category= '.$category.'";
    $query = "SELECT * FROM addhomework WHERE Section= '$section' ";
    if (isset($_POST['selLang'])) {
        $subject = implode($_POST['selLang']);
        // echo $subject;
        // echo "<br>";
        $query .= "AND Subject IN('" . $subject . "')";
    }
    if (isset($_POST['selTerm'])) {
        $term = implode($_POST['selTerm']);
        // echo $term;
        // echo "<br>";
        $query .= "AND Terms IN('" . $term . "')";
    }
    if (isset($_POST['selCat'])) {
        $category = implode($_POST['selCat']);
        // echo $category;
        // echo "<br>";
        $query .= "AND Category IN('" . $category . "')";
    }
    $query .= "ORDER BY id ASC";
    $query_run = mysqli_query($connection, $query);
    $output = '';
    if (mysqli_num_rows($query_run) > 0) {
        //$result = mysqli_fetch_array($query_run, MYSQLI_ASSOC);

        // print_r($result);
        // die();
        $serialNumber = 1;
        while($row = mysqli_fetch_assoc($query_run)) {

            $output .= '<tr id = "row'.$row['Id'].'">
                <td>' . $serialNumber++ . '</td>
                <td>' . $row['Title'] . '</td>
                <td>' . $row['Category'] . '</td>
                <td>' . $row['Files'] . '</td>
                <td>' . $row['Date'] . '</td>

                <td>
                    <button type="button" value="' . $row['Id'] . '" class="viewDatatBtn viewBtn btn btn-sm shadow-none fs-6 fw-bold"><i class="fa-regular fa-eye mx-2"></i>VIEW</button>
                </td>
                <td>
                    <button type="button" value="' . $row['Id'] . '" class="editDataBtn btn btn-success btn-sm shadow-none fs-6 fw-bold" id = "'.$row['file_Path'].'"><i class="fa-regular fa-pen-to-square mx-2"></i>EDIT</button>
                </td>
                <td>
                    <button type="button" value="' . $row['Id'] . '" class="deleteDataBtn btn btn-danger btn-sm shadow-none fs-6 fw-bold" id = "'.$row['file_Path'].'"><i class="fa-solid fa-trash-can mx-1"></i>DELETE</button>
                </td>
            </tr>';
        }
        echo $output;
    } else {
        $output .= '<td  colspan="7"><h3 class="fs-3 text-danger">DATA NOT FOUND</h3></td>';
        echo $output;
    }

    // $queryforAll = "SELECT * FROM addhomework WHERE Section= '$section'  AND Subject LIKE '%$subject%' AND Category LIKE '%$category%' AND Terms LIKE '%$term%' order by Id asc  ";
    // $queryAll = mysqli_query($connection, $queryforAll);
    // 
    // if (mysqli_num_rows($queryAll) > 0) {
    // $results = mysqli_fetch_all($queryAll, MYSQLI_ASSOC);

    // foreach ($results as $result) {

    // $alloutput['id'] = $result['Id'];
    // $alloutput['cat'] = $result['category'];
    // $alloutput['sub'] = $result['Subject'];
    // $alloutput['term'] = $result['Terms'];
    // $alloutput['date'] = $result['Date'];
    // $alloutput['file'] = $result['Files'];
    // $alloutputs[] = $alloutput;
    // }
    // $res = [
    // 'status' => 200,
    // 'data' => $results
    // ];
    // echo json_encode($res);
    // }
}