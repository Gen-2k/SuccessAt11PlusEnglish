<?php
ob_start();
if (!isset($_SESSION)) {
    session_start();
}
require dirname(__DIR__) . '/database/dbconfig.php';

if(isset($_GET['session_id'])){
    // print_r($_GET['stuid']);
    $user_id = $_GET['stuid'];
    $transctionId = $_GET['session_id'];
    //prin $_GET['stuid'];
    // die();
    //echo $transctionId;
    $sql = "SELECT * FROM students WHERE id = '$user_id'";
    $run_sql = mysqli_query($connection, $sql);
    if(mysqli_num_rows($run_sql)>0){
        $row1 = mysqli_fetch_assoc($run_sql);
        //echo '<pre>';
        //print_r($row1);
        $stuFname = $row1['fname'];
        $stuLname = $row1['surname'];
        $email = $row1['email'];
        $parentname = $row1['parentfirstname'];
        $phone = $row1['phone'];
        $dob = $row1['dob'];
        $dob = strtotime($dob);
        $studob = date("d-m-Y", $dob); //date("d-m-Y", $dob);
        $lan = $row1['Stu_Sub'];
        $cat = $row1['Stu_Cat'];
        $course = $row1['category'];
        $termname = $_GET['term'];
        $termprice = $_GET['price'];
        $isEbook = $_SESSION['isEBook'];
        $exterm = $row1['terms'];
// var_dump($exterm);
        $expterms = explode(",", $exterm);
       
            if(is_array($expterms)){
            array_push($expterms, $termname);
                    if($exterm !== ""){
                        $addTerm = implode(",", $expterms);
                    }else{
                        $addTerm = $termname;
                    }
            }else{
                $addTerm = $termname;
            }
        if($termname == 'EBook' || $termname == 'TEST'){
                 
                $insert_query = "INSERT INTO terms_details (student_id,language,course,termname,termprice,transaction_id,payment_status) VALUES ('$user_id','$lan','$cat','$termname','$termprice','$transctionId','$termname')";
                //echo $insert_query;
                 $query_run1 = mysqli_query($connection, $insert_query);
               // print_r($query_run1);
                if($termname == 'EBook'){
                    $update_sql = "UPDATE students SET status = 2, terms = '$addTerm' WHERE id= $user_id ";
                 } else{
                    $update_sql = "UPDATE students SET status = 2 ,test_update = CURRENT_TIMESTAMP  WHERE id= $user_id";
                 }
                //echo  $update_sql;
                $query_run = mysqli_query($connection, $update_sql);
                //exit();
                //print_r($query_run);
            }else{
                $update_sql = "UPDATE students SET status = 1 ,Stu_Status = 'Live' , Stu_Term = '$termname', terms = '$addTerm'   WHERE id= $user_id ";
                //echo  $update_sql;echo'<br>';
                $query_run = mysqli_query($connection, $update_sql);
                //print_r($query_run);echo'<br>';
                $insert_query = "INSERT INTO terms_details (student_id,language,course,termname,termprice,transaction_id,payment_status,created_at) VALUES ('$user_id','$lan','$cat','$termname','$termprice','$transctionId','active',CURRENT_TIMESTAMP)";
                //echo  $insert_query ;echo'<br>';
                $query_run1 = mysqli_query($connection, $insert_query);
                //print_r($query_run1);
                //exit();
                
            }
            //die();
            require   '../mail/PHPMailerAutoload.php';                    //PHPMailerAutoload.php
            require   '../mail/class.phpmailer.php';
            require  '../mail/class.smtp.php';
    
            $mail = new PHPMailer;
            $mail->isSendMail();
            $mail->isMail();
            // $mail->isSMTP();
            
            $mail->Host = 'smtp.gmail.com'; //smtp.mail.yahoo.com
            $mail->SMTPAuth = true;
        //   port for Send email
            $mail->SMTPSecure = 'ssl';  //ssl tls
            $mail->Port = 465;       //465 587
            // $mail->SMTPDebug = 0;
            $mail->Username = 'Safrina@smile4kids.co.uk'; //your-Yahoo-address@Yahoo.com
            $mail->Password = 'teoiljmskiwvamwh'; //add-your-Yahoo-Password
            $mail->setfrom('Safrina@smile4kids.co.uk', ' Success at 11 plus English');
        //   Recipient
            $mail->addAddress($email, $stuFname);
            //$mail->addCustomHeader('Content-Transfer-Encoding: BASE64');
            $mail->addReplyTo('Safrina@smile4kids.co.uk', ' Success at 11 plus English');
        //   Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Payment Successful On Your Purchase';
            $mail->Body    = '<html><body><p>Dear ' . $stuFname . ' ' . $stuLname . ',<br> Thank you for purchasing,<br><br> Language : ' . $lan . '.<br>Course : ' . $course . ' <br>Term : ' . $termname . ' <br>Term Price : ' . $termprice . ' <br><br>Regards,<br> Success at 11 plus English Indian Language School.<br><a href="https://smile4kids.co.uk/" target="_blank">smile4kids.co.uk</a></p></body></html>';
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
                //$_SESSION['status'] =$mail->ErrorInfo;
                //header("Location:index.php");  
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' .$mail->ErrorInfo;
                exit;
            } else {
                //$_SESSION['status'] ="Your subscription added successfully!";
                //header("Location:index.php");
                echo 'Message1 of Send email using Yahoo SMTP server has been sent';
                //print_r($mail);
                
            //   Admin Mail
                $mail->clearAddresses();
                // $mail->addAddress('reguramachandran007@gmail.com', "Safrina");
                $mail->addAddress('sfs662001@yahoo.com', "Safrina");
                // $mail->AddAddress('vinothkumar.umapathy@yahoo.com', "Safrina");
                // $mail->addCustomHeader('Content-Transfer-Encoding: BASE64');
                $mail->addReplyTo($email,$stuFname);
            //   Content
                $mail->Subject = 'Hi safrina';
                $mail->Body    = '<html><body><strong style = "font-size:18px"> ' . $stuFname . ' ' . $stuLname . '</strong>, has bought  ' . $termname . ' in ' . $course . ' - <strong>' . $lan . '</strong>.<br><strong>Contact Details</strong><br>Date of Birth : ' . $studob . '<br>Parent\'s Name : ' . $parentname . '<br> Email Address : ' . $email . '<br>Phone Number : ' . $phone . '<br><br>Regards,<br> Success at 11 plus English Indian language School.</body></html>';
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients at <a href="https://smile4kids.co.uk/">Visit Smile4kids.co.uk!</a>';
                
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
                
                if (!$mail->send()) {
                    echo 'Message2 could not be sent.';
                    echo 'Mailer Error: ' .$mail->ErrorInfo;
                    exit;
                } else {
                    //echo 'Message2 of Send email using Yahoo SMTP server has been sent';
                    //print_r($mail);
                    $_SESSION['status'] = " Welcome " .  $stuFname;
                    // $_SESSION['category'] = $course;
                    
                    header("Location:adminstu");
                    //exit();
                }
            }
        }else{
            $_SESSION['status_code'] = "Your Payment Was Done But please contact further access..?";

            header('Location:Login');
        }
  
}