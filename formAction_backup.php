<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once __DIR__ . '/database/dbconfig.php';
if (isset($_POST['userEmail'])) {
    $userEmail = $_POST['userEmail'];
    $emailQ = "SELECT email FROM students WHERE email = '$userEmail'";
    $emailQR = mysqli_query($connection, $emailQ);
    if (mysqli_num_rows($emailQR) > 0) {
        echo "Email Exist";
    } else {
        echo "Available";
    }
}
$terms = '';
$termPrice = '';
$email_error = '';  
$parentFname = '';
$parentLname = '';
if (isset($_POST['submit'])) {

    if (!empty($_POST)) {
        $class_id = $_SESSION['classid'];
        $course_id = $_SESSION['courseName'];
        $course_Name = $_SESSION['courseId'];
        $stud_name = $_POST['fname'];
        $surname = $_POST['surname'];
        $dob = strtotime($_POST['dob']);
        $date = date("Y-m-d", $dob);
        $users_type = isset($_POST['users_type']) ? $_POST['users_type'] : 'NewStudent';
        if (isset($_POST['existing_users_term'])) {
            $existing_users_term = $_POST['existing_users_term'];
            $terms = implode(",", $existing_users_term);
        } else {
            $terms = '';
        }
         $email = $_POST['email'];
         $emailQ = "SELECT email FROM students WHERE email = '$email'";
            $emailQR = mysqli_query($connection, $emailQ);
                if (mysqli_num_rows($emailQR) > 0) {
                    $email_error ='';
                    
                } else {
                    $email_error = $email;
                }
        
        // Remove price category logic - set default price
        $termPrice = 140; // Default price for all students
        $gender = $_POST['gender'];
        if(isset($_POST['parentfirstname']) !=''){
           $parentFname = $_POST['parentfirstname']; 
        }
         if(isset($_POST['parentsurname']) !=''){
           $parentLname = $_POST['parentfirstname']; 
        }
        
        $address = $_POST['address'];
        $email = preg_replace('/\s+/', '', $_POST['email']);
        $recpt = 'admin';
        $recpt = explode(" ", $recpt);
        $emaile = explode(" ", $email);
        $push = array_merge($emaile, $recpt);
        
        $phone = $_POST['phone'];
        $yesorno = $_POST['yesorno'];
       
        function password_generate($chars)
        {
            $data = '1234567890';
            return substr(str_shuffle($data), 0, $chars);
        }
        $password =  password_generate(6);
        
        if($email_error != ''&& $password !='' && $class_id != '' && $course_id !='' && $course_Name !=''){
            
            $query = "INSERT INTO students 
                        (fname,surname,dob,users_type,terms,gender,parentfirstname,parentsurname,address,email,password,phone,yesorno,Stu_Sub,Stu_Cat,child_category,category,Stu_Status) 
                        VALUES ('$stud_name','$surname','$date','$users_type','$terms','$gender','$parentFname','$parentLname','$address','$email_error','$password','$phone','$yesorno','$class_id','$course_Name','$termPrice','$course_id','Pending')";
                       
            $query_run = mysqli_query($connection, $query);
            
            $body = file_get_contents('logincredentials.phtml');
            $body = str_replace('%studfname%', $stud_name, $body);
            $body = str_replace('%studlname%', $surname, $body);
            $body = str_replace('%courseid %', $course_id , $body);
            $body = str_replace('%classid%', $class_id, $body);
            $body = str_replace('%email%', $email, $body);
            $body = str_replace('%password%', $password, $body);
            
            
            if ($query_run) {
            
              require './mail/PHPMailerAutoload.php';                    //PHPMailerAutoload.php
              require './mail/class.phpmailer.php';
              require './mail/class.smtp.php';
              
                $mail = new PHPMailer;
            
                // $mail->isSendMail();
                $mail->SMTPDebug = 2;
                // $mail->isMail();
                $mail->isSMTP();
                // $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'Safrina@smile4kids.co.uk';                     //SMTP username
                $mail->Password   = 'teoiljmskiwvamwh';                               //SMTP password
                $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                
              $mail->setFrom('Safrina@smile4kids.co.uk', ' Success at 11 plus English');
              $mail->addAddress($email, $stud_name);
              $mail->addReplyTo('Safrina@smile4kids.co.uk', ' Success at 11 plus English');
              $mail->isHTML(true); // Set email format to HTML
              $mail->Subject = "Welcome to Smile4kids ";
              $mail->Body =$body ;
              $mail->AltBody = 'This is the body in plain text for non-HTML mail clients at https://smle4kids.co.uk/';
                //This should be the same as the domain of your From address
                $mail->DKIM_domain = 'smile4kids.co.uk';
                //See the DKIM_gen_keys.phps script for making a key pair -
                //here we assume you've already done that.
                //Path to your private key:
                $mail->DKIM_private = './mail/dkim_private.pem';
                //Set this to your own selector
                $mail->DKIM_selector = 'default';
                //Put your private key's passphrase in here if it has one
                $mail->DKIM_passphrase = '';
                //The identity you're signing as - usually your From address
                $mail->DKIM_identity = $mail->From;
                //Suppress listing signed header fields in signature, defaults to true for debugging purpose
                $mail->DKIM_copyHeaderFields = false;
                
            
            
              if (!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
                exit;
               } else {
                        $_SESSION['status'] = 'Thank for applying to ' .
                        $course_Name . " - " . $class_id . '!';
                        $_SESSION['status_code'] = "success";
                        $vemailQ = "SELECT Subr_email FROM newsletter WHERE Subr_email = '$email'";
                        $vemailQR = mysqli_query($connection, $vemailQ);
                        if (mysqli_num_rows($vemailQR) == 0){
                        $newsletter = "INSERT INTO newsletter (Subr_fname,subr_lname,Subr_email) VALUES ('$stud_name','$surname','$email')";
                        $query_run = mysqli_query($connection, $newsletter);
                        }
                      header("Location: " . BASE_URL . "index.php");
                      exit;
              }
                               
            }
        }else{
              $_SESSION['status_code'] = "Error";
              $_SESSION['status'] = 'Unable to Applied...Try again sometimes...?';
             header("Location: " . BASE_URL . "index.php");
            exit;
        }

          
       
    } else {
            echo "somthing is wrong";
            $_SESSION['status_code'] = "Error";
            $_SESSION['status'] = "<script type='text/javascript'>alert('Somthing went to wrong!?')</script>";
            header('Location: ' . BASE_URL . 'index.php');
            exit();
        }
    }

