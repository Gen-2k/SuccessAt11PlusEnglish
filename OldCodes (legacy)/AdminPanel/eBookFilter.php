<?php
session_start();
require dirname(__DIR__) . '/database/dbconfig.php';

// $_SESSION['ses_data_id'] = "";
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
    $query = "SELECT * FROM addhomework WHERE Section= '$section'";
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

        //print_r($result);
        //die();
       $serialNumber = 1;
       while($row = mysqli_fetch_assoc($query_run)){

            $output .= '<tr id= "row'.$row['Id'].'">
                <td>' . $serialNumber++ . '</td>
                <td>' . $row['Category'] . '</td>
                <td>' . $row['Files'] . '</td>
                
                <td>
                    <button type="button" value="' . $row['Id'] . '" class="viewDatatBtn viewBtn btn btn-sm shadow-none fs-6 fw-bold"><i class="fa-regular fa-eye mx-2"></i>VIEW</button>
                </td>
                <td>
                    <button type="button" value="' . $row['Id'] . '" class="editDataBtn btn btn-success btn-sm shadow-none fs-6 fw-bold"><i class="fa-regular fa-pen-to-square mx-2"></i>EDIT</button>
                </td>
                <td>
                    <button type="button" value="' . $row['Id'] . '" class="deleteDataBtn btn btn-danger btn-sm shadow-none fs-6 fw-bold" id = "'.$row['file_Path'].'"><i class="fa-solid fa-trash-can mx-1"></i>DELETE</button>
                </td>
            </tr>';
        }
        echo $output;
    } else {
        $output .= '<td  colspan="6"><h3 class="fs-3 text-danger">DATA NOT FOUND</h3></td>';
        echo $output;
    }
}