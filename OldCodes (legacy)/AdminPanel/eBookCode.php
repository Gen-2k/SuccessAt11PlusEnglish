<?php
if (!isset($_SESSION)) {
    session_start();
    require dirname(__DIR__) . '/database/dbconfig.php';
    
    // Enable error reporting for debugging
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

// Log function to help debug issues
function log_error($message) {
    $logFile = dirname(__DIR__) . '/error_log.txt';
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[{$timestamp}] {$message}\n", FILE_APPEND);
}

// $_SESSION['ses_data_id'] = "";
if (isset($_POST['save_data'])) {
    // Log the start of the process
    log_error("Starting E-Book save process");
    
    // Check the upload directory exists and create it if not
    $upload_dir = 'hwUploads/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
        log_error("Created upload directory: " . $upload_dir);
    }
    
    // $allowed_types = array('jpg', 'png', 'jpeg', 'gif');
    $allowed_types = array('pdf', 'docx');
    // Maxsize for files i.e 50MB
    $maxsize = 52428800;

    // Checks if user sent an empty form

    //if (!empty(array_filter($_FILES['files']['name']))) {

        // Loop through each file in files[] array
       // foreach ($_FILES['files']['tmp_name'] as $key => $value) {
            $category = $_POST['category'];
            $subject = $_POST['subject'];
            $amount = $_POST['eBamount'];
            $terms = $_POST['terms'];
            // $date = $_POST['addDate'];
            $section = $_POST['section'];
            
            // Set current date if date is not provided
            $date = date('Y-m-d');
            
            // Log the received data
            log_error("E-Book data: Category=$category, Subject=$subject, Amount=$amount, Terms=$terms, Section=$section");

            // Check if file is uploaded
            if(!isset($_FILES['files']) || empty($_FILES['files']['name'])) {
                $res = [
                    'status' => 100,
                    'message' => 'Please select a file to upload.'
                ];
                echo json_encode($res);
                log_error("No file uploaded");
                return false;
            }

            $file_tmpname = $_FILES['files']['tmp_name'];
            $file_name = $_FILES['files']['name'];
            $file_size = $_FILES['files']['size'];
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
            
            log_error("File details: Name=$file_name, Size=$file_size, Extension=$file_ext");

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
                    log_error("File too large: $file_size bytes");
                    return false;
                } else if (file_exists($filepath)) {
                    // Add timestamp to make filename unique
                    $filepath = $upload_dir . pathinfo($file_name, PATHINFO_FILENAME) . "_" . time() . "." . $file_ext;
                    $unique_file_name = pathinfo($file_name, PATHINFO_FILENAME) . "_" . time() . "." . $file_ext;
                    
                    log_error("File already exists, using unique path: $filepath");

                    if (move_uploaded_file($file_tmpname, $filepath)) {
                        log_error("File moved successfully to: $filepath");
                        
                        $insertQuery = "INSERT INTO addhomework(Section, Category, Subject, Amount, Terms, Files, file_Path, Date) VALUES('$section', '$category', '$subject', '$amount', '$terms', '$unique_file_name', '$filepath', '$date')";
                        log_error("SQL Query: $insertQuery");
                        
                        $queryRun = mysqli_query($connection, $insertQuery);
                        if ($queryRun) {
                            $res = [
                                'status' => 200,
                                'message' => 'E-Book Added Successfully...!'
                            ];
                            echo json_encode($res);
                            log_error("E-Book added successfully, ID: " . mysqli_insert_id($connection));
                        } else {
                            $res = [
                                'status' => 500,
                                'message' => 'Database error: ' . mysqli_error($connection)
                            ];
                            echo json_encode($res);
                            log_error("Database error: " . mysqli_error($connection));
                            return false;
                        }
                    } else {
                        $res = [
                            'status' => 500,
                            'message' => 'Failed to move uploaded file. Check directory permissions.'
                        ];
                        echo json_encode($res);
                        log_error("Failed to move uploaded file. Error: " . error_get_last()['message']);
                        return false;
                    }
                } else {
                    if (move_uploaded_file($file_tmpname, $filepath)) {
                        log_error("File moved successfully to: $filepath");
                        
                        $insertQuery = "INSERT INTO addhomework(Section, Category, Subject, Amount, Terms, Files, file_Path, Date) VALUES('$section', '$category', '$subject', '$amount', '$terms', '$file_name', '$filepath', '$date')";
                        log_error("SQL Query: $insertQuery");
                        
                        $queryRun = mysqli_query($connection, $insertQuery);
                        if (!$queryRun) {
                            $res = [
                                'status' => 500,
                                'message' => 'Database error: ' . mysqli_error($connection)
                            ];
                            echo json_encode($res);
                            log_error("Database error: " . mysqli_error($connection));
                            return false;
                        }

                        $res = [
                            'status' => 200,
                            'message' => 'E-Book Added Successfully...!'
                        ];
                        echo json_encode($res);
                        log_error("E-Book added successfully, ID: " . mysqli_insert_id($connection));
                    } else {
                        $res = [
                            'status' => 500,
                            'message' => 'Failed to move uploaded file. Check directory permissions.'
                        ];
                        echo json_encode($res);
                        log_error("Failed to move uploaded file. Error: " . error_get_last()['message']);
                        return false;
                    }
                }
            } else {
                $res = [
                    'status' => 500,
                    'message' => 'Invalid file format. Allowed formats: PDF, DOCX'
                ];
                echo json_encode($res);
                log_error("Invalid file format: $file_ext");
                return false;
            }
 
}


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
    $amount = $_POST['amount'];
    $oldfile = $_POST['oldfile'];
    var_dump($amount);
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

                $query = "UPDATE addhomework SET Category= '$category', Amount= '$amount', Subject= '$subject', Files= '$file_name', file_Path= '$filepath' WHERE Id= '$data_id'";
                $query_run = mysqli_query($connection, $query);
                // printf($query);
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
        $query = "UPDATE addhomework SET Category= '$category', Amount= '$amount', Subject= '$subject' WHERE Id= '$data_id'";
        $query_run = mysqli_query($connection, $query);
        if($query_run){
            $res = [
                'status' => 200,
                'message' => 'Successfully Uploaded to Database'
                ];
                echo json_encode($res);
                return false;
        }
    }
}

if (isset($_GET['data_id'])) {
    $data_id = mysqli_real_escape_string($connection, $_GET['data_id']);
    $_SESSION['ses_data_id'] = $data_id;
    $query = "SELECT * FROM addhomework WHERE Id= '$data_id'";
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

if (isset($_POST['delete_data'])) {
    $data_id = mysqli_real_escape_string($connection, $_POST['data_id']);

    $query = "DELETE FROM addhomework WHERE Id= '$data_id'";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        unlink($_POST['path']);
        $res = [
            'status' => 200,
            'message' => 'E-book Deleted Successfully...!'
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

if (isset($_POST['action']) == "update") {
    //print_r($_POST['data']);
    $datas = $_POST['data'];
    //print_r($datas);
    $section = $datas[0]['value'];
    $category = $datas[1]['value'];
    $subject =  $datas[2]['value'];
    $eBamount =  $datas[3]['value'];
    //print_r($subject);
    //echo  $category;
    //print_r($_POST['amt_change']);
    // $category = $_POST['category'];
    // $subject = $_POST['subject'];
    // $amount = $_POST['eBamount'];
    // $section = $_POST['section'];

    $query = "UPDATE addhomework SET Amount='$eBamount' WHERE Section='$section'AND Category='$category' AND Subject='$subject'";
    echo $query;
    $queryRun = mysqli_query($connection, $query);
    //print_r($queryRun);
    // print_r(mysqli_num_rows($queryRun) > 0);
    if ($queryRun) {
        $res = [
            'status' => 200,
            'message' => 'Successfully Updated the Offer Price'
        ];
        echo json_encode($res);
        return;
    }
}