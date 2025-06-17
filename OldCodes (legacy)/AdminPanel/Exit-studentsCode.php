<?php
session_start();
require dirname(__DIR__) . '/database/dbconfig.php';

if (isset($_POST['action']) || isset($_POST['selLang']) || isset($_POST['selCat']) || isset($_POST['selTerm'])) {
    $section = $_POST['action'];

    echo $section;

    $query = "SELECT * FROM students WHERE role= '10' AND users_type = 'ExistingStudent'";
    if (isset($_POST['selLang'])) {
        $subject = implode($_POST['selLang']);
        $query .= "AND Stu_Sub IN('" . $subject . "')";
    }
    if (isset($_POST['selCat'])) {
        $status = implode($_POST['selCat']);
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
                $output .= '<tr class="align-middle" id = row' . $row['id'] . ' >
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

if (isset($_POST['condition'])) {
    $id = $_POST['id'];
    $terms = $_POST['terms'];
    if($terms !=''){
        
    $allTerms = implode(",", $terms);
    }else{
        $allTerms = "";
    }
    if ($id != '' && $allTerms != '' && $_POST['condition'] == 'update_terms') {
        $recentTerm=[];
        $getexstuQy = "SELECT * FROM students WHERE id = '$id'";
    $getexstuQyRn = mysqli_query($connection, $getexstuQy);
    $exrow = mysqli_fetch_array($getexstuQyRn);
    $exid = $exrow['id'];
    $exlan = $exrow['Stu_Sub'];
    $excat = $exrow['Stu_Cat'];
    $exterm = $exrow['terms'];
    $email = $exrow['email'];
    $fname = $exrow['fname'];
    $lname = $exrow['surname'];
    $pass = $exrow['password'];
    $expterms = explode(",", $exterm);
    $delterms = array_diff($expterms, $terms);
        foreach ($terms as $extm) {
            $extmQuery = "SELECT termname FROM terms_details WHERE student_id = '$id' AND termname = '$extm'";
            $extmQRun = mysqli_query($connection, $extmQuery);
            if (mysqli_num_rows($extmQRun) == 0) {
                $extminsQuery = "INSERT INTO terms_details (student_id, language, course, termname, termprice, payment_status, status,created_at) VALUES ('$exid', '$exlan', '$excat', '$extm', 0, 'Old Student', 'active',CURRENT_TIMESTAMP)";
                $extminsQRun = mysqli_query($connection, $extminsQuery);
                array_push($recentTerm, $extm);
            } else {
              //  echo "Already Purchased";
            }
        }
        foreach ($delterms as $extm) {
            $extmdelQuery = "DELETE FROM terms_details WHERE student_id = '$id' AND termname ='$extm'";
            $extmdelQRun = mysqli_query($connection, $extmdelQuery);
            if ($extmdelQRun) {
                //echo "Deleted Sucessfully" . $extm;
            }
        }
        $lastTerm = array_pop($terms);
        $termUpdate = "UPDATE students SET status = 2,Stu_Term = '$lastTerm', Stu_Status = 'Live', terms ='$allTerms' WHERE id = '$id'";
        $run_update = mysqli_query($connection, $termUpdate);
        
        if($run_update && sizeof($recentTerm)!==0){
        require   '../mail/PHPMailerAutoload.php';                    //PHPMailerAutoload.php
        require   '../mail/class.phpmailer.php';
        require  '../mail/class.smtp.php';


        $mail = new PHPMailer;
        $mail->isSendMail();
        $mail->isMail();
        // $mail->isSMTP();   
        
        $mail->Host = 'smtp.gmail.com'; //smtp.mail.yahoo.com
        $mail->SMTPAuth = true;
        $mail->Port = 465;       //465 587
        // port for Send email
        $mail->SMTPSecure = 'ssl';  //ssl tls
        //$mail->SMTPDebug = 1;
         $mail->Username = 'Safrina@smile4kids.co.uk';
        $mail->Password = 'teoiljmskiwvamwh';
        $mail->setfrom('Safrina@smile4kids.co.uk', ' Success at 11 plus English');

        $mail->addAddress($email, $fname);
        $mail->addReplyTo('Safrina@smile4kids.co.uk', ' Success at 11 plus English');
        //$mail->addCustomHeader('Content-Transfer-Encoding: BASE64');
        $mail->isHTML(true); // Set email format to HTML

        $mail->Subject = 'Activated Successful';

        $mail->Body    = '<html><body><p>Dear ' . $fname . ' ' . $lname . ',<br><br>Your account has been activated successfully. You can now login with your login credentials.<br>Email : '.$email.' <br> Password : '.$pass.'<br>' .implode(",",$recentTerm). ' has been added <br><br>Regards,<br> Success at 11 plus English Indian Language School.<br><a href="https://smile4kids.co.uk/index" target="_blank">smile4kids.co.uk</a></p></body></html>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients at <a href="https://smile4kids.co.uk/">Visit Smile4kids.com!</a>';

        //This should be the same as the domain of your From address
        $mail->DKIM_domain = 'smile4kids.co.uk';
        //See the DKIM_gen_keys.phps script for making a key pair -
        //here we assume you've already done that.
        //Path to your private key:
        $mail->DKIM_private = '../mail/dkim_private.pem';
        //Set this to your own selector
        $mail->DKIM_selector = 'default';
        //Put your private key's passphrase in here if it has one
        $mail->DKIM_passphrase = '';
        //The identity you're signing as - usually your From address
        $mail->DKIM_identity = $mail->From;
        //Suppress listing signed header fields in signature, defaults to true for debugging purpose
        $mail->DKIM_copyHeaderFields = false;

        if (!$mail->Send()) {
            //$_SESSION['status'] = $mail->ErrorInfo;
            //header("Location:index.php");  
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            exit;
        } else {

            //$_SESSION['status'] ="Your subscription added successfully!";
            //header("Location:index.php");
            //echo 'Message1 of Send email using Yahoo SMTP server has been sent';
            echo "Student's terms are updated successful";
            exit;
            }
        }
        
    } else {
        $termUpdate = "UPDATE students SET status = 0,Stu_Term = '', Stu_Status = 'Pending', terms ='' WHERE id = '$id'";
        $run_update = mysqli_query($connection, $termUpdate);
        $extmdelQuery = "DELETE FROM terms_details WHERE student_id = '$id'";
        $extmdelQRun = mysqli_query($connection, $extmdelQuery);
        echo "Student's terms are removed successful";
    }
}

if (isset($_POST['requestCondition']) == "delete_student") {
    //print_r($_POST['id']);
    $stu_id = $_POST['id'];
    $deletStudent1 = "DELETE FROM terms_details WHERE student_id= '$stu_id'";
    $run_delete1 = mysqli_query($connection, $deletStudent1);
    $deletStudent = "DELETE FROM students WHERE id= '$stu_id'";
    $run_delete = mysqli_query($connection, $deletStudent);
    if ($stu_id) {
        echo "Students details deleted succssfully";
    } else {
        echo "somthing went wrong";
    }
}

if (isset($_POST['requestAction']) == "email_note") {
    
   $output = '';
   $bodyTitle = $_POST['emailTitle'];
   $bodyMsg = $_POST['emailbody'];
   
    $mailIds = $_POST['id'];
    if($mailIds){
        
        foreach($mailIds as $id){
            $selectUsers = "SELECT * FROM students WHERE id = '$id'";
            $run_select = mysqli_query($connection, $selectUsers);
            if (mysqli_num_rows($run_select) > 0) {
                
                while($userData = mysqli_fetch_assoc($run_select)){
                  
                require_once    '../mail/PHPMailerAutoload.php';                    //PHPMailerAutoload.php
                require_once    '../mail/class.phpmailer.php';
                require_once   '../mail/class.smtp.php';
        
                $mail = new PHPMailer;
                $mail->isSendMail();
                $mail->isMail();
                // $mail->isSMTP();
        
                $mail->Host = 'smtp.gmail.com'; 
                $mail->Port = 465;       //465 587
                $mail->SMTPSecure = 'ssl';  //ssl tls
                // $mail->SMTPDebug = 1;
                $mail->SMTPAuth = true;
                $mail->Username = 'Safrina@smile4kids.co.uk';
                $mail->Password = 'teoiljmskiwvamwh';
                $mail->setfrom('Safrina@smile4kids.co.uk',' Success at 11 plus English');
        
                $mail->addAddress($userData['email'], $userData['fname']);
                $mail->addReplyTo('Safrina@smile4kids.co.uk', ' Success at 11 plus English');
                $mail->IsHTML(true); // Set email format to HTML
        
                $mail->Subject = 'Message From  Success at 11 plus English';
                $mail->Body = '<html><body>';
                $mail->Body.='<div style="font-family: Helvetica Neue, Arial, sans-serif; line-height: 1.5; width:100%;height:100%; display: flex; justify-content:center; align-items:center ; font-size:17px"> <table id="tabbleData" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); background-color: white; width:100%; max-width:50rem; height:100%; padding:2rem;">';
                $mail->Body.='<tr><td style="text-align: center; border-bottom:solid black 1px; padding:1rem;"><img src="https://smile4kids.co.uk/assets/images/log2.png" alt="smile4kids" style="width:140px;"></td></tr>';
                $mail->Body.='<tr><td><h2 style="color: #6e20a7; text-align: center;  text-transform: uppercase;">'. nl2br($bodyTitle).'</h2></td>';
                $mail->Body.='<tr style="padding:2rem;"><td>Dear ' . $userData['fname'] . ' ' . $userData['surname'] . ',<br><br>' . nl2br($bodyMsg) . '</td></tr>';
                $mail->Body.= '<tr></tr><tr style="font-size:12px; text-align:center; background-color:#dcdde1; color:#6e20a7"><td style="padding: 1rem;">Regards,<br>Smile4Kids Indian Language School,<br> <a href="https://smile4kids.co.uk/index" target="_blank">smile4kids.co.uk</a><br/><br/>Unsubscribe to click <a href="https://www.smile4kids.co.uk/unsubscribe.php?unsub_email=' . base64_encode($nluserMail) . '">here</a><td></tr> </table></div></body></html>';
        
                // $mail->Body    = '<html><body><p>Dear ' . $userData['fname'] . ' ' . $userData['surname'] . ',<br>'.$bodyMsg.'<br><br>Regards,<br> Success at 11 plus English Indian Language School.<br><a href="#" target="_blank">smile4kids.uk.co</a></p></body></html>';
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients at <a href="https://smile4kids.co.uk/">Visit Smile4kids.com!</a>';
        
            // This should be the same as the domain of your From address
                $mail->DKIM_domain = 'smile4kids.co.uk';
            // See the DKIM_gen_keys.phps script for making a key pair -
            // here we assume you've already done that.
            // Path to your private key:
                $mail->DKIM_private = '../mail/dkim_private.pem';
            // Set this to your own selector
                $mail->DKIM_selector = 'default';
            // Put your private key's passphrase in here if it has one
                $mail->DKIM_passphrase = '';
            // The identity you're signing as - usually your From address
                $mail->DKIM_identity = $mail->From;
            // Suppress listing signed header fields in signature, defaults to true for debugging purpose
                $mail->DKIM_copyHeaderFields = false;
        
                if (!$mail->Send()) {
                    
                    echo 'Message could not be sent.';
                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                    //exit;
                } else {
    
                    echo "Msg send Successful";
                    
                    }
                }
                 
            }
        }
    }
  
}