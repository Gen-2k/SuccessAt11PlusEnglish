<?php
ob_start();
if (!isset($_SESSION)) {
    session_start();
    require dirname(__DIR__) . '/database/dbconfig.php';
}
if (!isset($_SESSION['logged_in']) == true) {
    header("Location:../Login");
}
if (isset($_GET['session_id'])) {
        $userid =  $_SESSION['id'];
        $userData = "SELECT * FROM students WHERE id = $userid ";
        //echo $userData;
        //die();
        $query_userData = mysqli_query($connection, $userData);
       // print_r($query_userData);
        if(mysqli_num_rows($query_userData) > 0){
            
            $u_data = mysqli_fetch_array($query_userData,MYSQLI_ASSOC);  
            //echo '<pre>';
            //print_r($u_data);
            
            $email = $u_data['email'];
            //print_r($email);
            $stuFname = $u_data['fname'];
            $stuLname = $u_data['surname'];
            $studob = $u_data['dob'];
            $parentname = $u_data['parentfirstname'];
            $phone = $u_data['phone'];
            $sub = $u_data['Stu_Sub'];
            $cat = $u_data['Stu_Cat'];
            $exterm = $u_data['terms'];
            // var_dump($exterm);
            $expterms = explode(",", $exterm);
        }
        $hwsub = $_SESSION['paid_Lang'];
        $hwcat = $_SESSION['paid_Cat'];
        $transctionId = $_GET['session_id'];
        $termname =  $_SESSION['termname'];
        $termprice = $_SESSION['termprice'];
        // echo $termname;
        // echo '<br>';
        // echo $termprice;
        // echo '<br>';
        // echo $sub;
        // echo '<br>';
        // echo $cat;
        // echo '<br>';
        // echo $userid;
        // die();
        //$isEbook = $_SESSION['isEBook'];
        if($userid && $sub && $cat && $transctionId && $termname && $termprice ){
             
              array_push($expterms, $termname);
            // print_r($expterms);
            $addTerm = implode(",", $expterms);
            $insert_query = "INSERT INTO terms_details (student_id,language,course,termname,termprice,transaction_id,payment_status) VALUES ('$userid','$sub','$cat','$termname','$termprice','$transctionId','$termname')";
            //echo $insert_query;
             $query_run1 = mysqli_query($connection, $insert_query);
           // print_r($query_run1);
           $update_sql = "UPDATE students SET terms = '$addTerm' WHERE id= '$userid' ";
           $query_run = mysqli_query($connection, $update_sql);
            //die();
        require   '../mail/PHPMailerAutoload.php';                    //PHPMailerAutoload.php
        require   '../mail/class.phpmailer.php';
        require   '../mail/class.smtp.php';


        $mail = new PHPMailer;
        $mail->isSendMail();
        $mail->isMail();
        // $mail->isSMTP();
        
        $mail->Host = 'smtp.gmail.com'; //smtp.mail.yahoo.com
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';  //ssl tls
        $mail->Port = 465;       //465 587
        // $mail->SMTPDebug = 1;
        $mail->Username = 'Safrina@smile4kids.co.uk'; //your-Yahoo-address@Yahoo.com
        $mail->Password = 'teoiljmskiwvamwh'; //add-your-Yahoo-Password
        $mail->setfrom('Safrina@smile4kids.co.uk', ' Success at 11 plus English');
    //   Recipient
        $mail->addAddress($email, $stuFname);
        $mail->addReplyTo('Safrina@smile4kids.co.uk', ' Success at 11 plus English');
        //$mail->addCustomHeader('Content-Transfer-Encoding: BASE64');
        $mail->isHTML(true); // Set email format to HTML
    //   Content
        $mail->Subject = 'Payment Successful On Your Purchase';
        $mail->Body    = '<html><body><p>Dear ' . $stuFname . ' ' . $stuLname . ',<br> Thank you for your purchasing,<br><br> Language : ' . $sub . '.<br>Course : ' . $cat . '.<br>Item : ' . $termname . '.<br> Price : ' . $termprice . ' <br><br>Regards,<br> Success at 11 plus English Indian Language School.<br><a href="https://smile4kids.co.in/index" target="_blank">smile4kids.co.in</a></p></body></html>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients at <a href="https://smile4kids.co.uk/">Visit Smile4kids.com!</a>';

    // This should be the same as the domain of your From address
        $mail->DKIM_domain = 'smile4kids.co.uk';
    // See the DKIM_gen_keys.phps script for making a key pair -
    // here we assume you've already done that.
    // Path to your private key:
        $mail->DKIM_private = './mail/dkim_private.pem';
    // Set this to your own selector
        $mail->DKIM_selector = 'default';
    // Put your private key's passphrase in here if it has one
        $mail->DKIM_passphrase = '';
    // The identity you're signing as - usually your From address
        $mail->DKIM_identity = $mail->From;
    // Suppress listing signed header fields in signature, defaults to true for debugging purpose
        $mail->DKIM_copyHeaderFields = false;

        if (!$mail->Send()) {
            // $_SESSION['status'] = $mail->ErrorInfo;
            // header("Location:index.php");  
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            exit;
        } else {

            // $_SESSION['status'] ="Your subscription added successfully!";
            // header("Location:index.php");
            echo 'Message1 of Send email using Yahoo SMTP server has been sent';
            $mail->ClearAllRecipients();
        //   Admin
            $mail->addAddress('sfs662001@yahoo.com', "Safrina");
            // $mail->AddAddress('reguramachandran007@gmail.com', "Safrina");
            // $mail->AddAddress('vinothkumar.umapathy@yahoo.com', "Safrina");
            $mail->addReplyTo($email,$stuFname);
            $mail->addCustomHeader('Content-Transfer-Encoding: BASE64');
            

            $mail->Subject = 'Hi safrina';
            $mail->Body    = '<html><body><p><strong style = "color : #ff0000;"> ' . $stuFname . ' ' . $stuLname . '</strong>, has bought  ' . $termname . ' in ' . $course . ' - <strong>' . $lan . '</strong>.<br><strong>Contact Details</strong><br>Date of Birth : ' . $studob . '<br>Parent\'s Name : ' . $parentname . '<br> Email Address : ' . $email . '<br>Phone Number : ' . $phone . '<br><br>Regards,<br> Success at 11 plus English Indian language School.</p></body></html>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients at <a href="https://smile4kids.co.uk/">Visit Smile4kids.com!</a>';

        // This should be the same as the domain of your From address
            $mail->DKIM_domain = 'smile4kids.co.uk';
        // See the DKIM_gen_keys.phps script for making a key pair -
        // here we assume you've already done that.
        // Path to your private key:
            $mail->DKIM_private = './mail/dkim_private.pem';
        // Set this to your own selector
            $mail->DKIM_selector = 'default';
        // Put your private key's passphrase in here if it has one
            $mail->DKIM_passphrase = '';
        // The identity you're signing as - usually your From address
            $mail->DKIM_identity = $mail->From;
        // Suppress listing signed header fields in signature, defaults to true for debugging purpose
            $mail->DKIM_copyHeaderFields = false;

                if (!$mail->send()) {
                echo 'Message2 could not be sent.';
                echo 'Mailer Error: ' .$mail->ErrorInfo;
                exit;
                } else {
                    // echo 'Message2 of Send email using Yahoo SMTP server has been sent';
                    // print_r($mail);
                    $_SESSION['status'] = "Thank you for purchasing e-book...!";
                    // $_SESSION['category'] = $course;
                    header("Location:adminstu");
                }
            }
        }
    } elseif (isset($_GET['cancel'])) {
        //echo "<script type='text/javascript'>alert('Payment canceled!?')</script>";
        echo "<script type='text/javascript'>toastr.info('Your Payment is canceled..!?')</script>";
        //unset($_SESSION['status']); 
        //header("Location:../Login.php");
        //session_destroy();
    }
?>
<style>
#toast-container>.toast-error {
    background-color: #FF3333;

}
</style>
<!DOCTYPE html>
<html lang='en' class=''>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Smile4Kids | E-BOOK</title>
    <!-- <link rel="icon" type="image/x-icon" href="./assets/images/logonew.png"> -->
    <!--<link rel="stylesheet" href="https://use.typekit.net/qom5wfr.css" />-->
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />-->

    <!--<script src="https://kit.fontawesome.com/398c77c1ca.js" crossorigin="anonymous"></script>-->
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />-->
    <!-- css path -->
</head>

<body>
    <div id="backHomePage">
        <a href="adminstu" class="text-decoration-none">
            <div class="backHomePageChild">
                <img src="stu_assets/home-n.png" alt="back" width="30px" class="mx-2"><span class="fw-bold ps-2">Back to
                    Home</span>
            </div>
        </a>
    </div>
    <?php include('studentHeader.php') ?>
    <h3 class="fw-bold h3 text-center p-3 text-white">E-BOOK</h3>

    <?php
     
    $userid =  $_SESSION['id'];
    $hwterm = $_GET['eBok'];
    $hwsub = $_SESSION['paid_Lang'];
    $hwcat = $_SESSION['paid_Cat'];
    // echo $_SESSION['paid_Term'];

    $_query = "SELECT * FROM terms_details WHERE student_id = $userid AND termname ='EBook'";
   //echo $_query;
    $query_run1 = mysqli_query($connection, $_query);
    //print_r($query_run1);
    
    if(mysqli_num_rows($query_run1)>0){
      $row1 = mysqli_fetch_all($query_run1,MYSQLI_ASSOC);  
      //print_r($row1);
      foreach ($row1 as $termname) {
        //print_r($termname['termname']);
        //echo '<br>';
        //echo $hwterm;
       // $selectTerm = $termname['termname'];
        if ($hwterm == $termname['termname']) {
            $query = "SELECT * FROM addhomework WHERE Section='E-Book' AND Terms='$hwterm' AND Subject='$hwsub' AND Category='$hwcat'";
            //echo $query;
            $result = mysqli_query($connection, $query);
            //print_r($result);
            if (mysqli_num_rows($result) > 0) {
                //$row = mysqli_fetch_assoc($query_run);
           ?> <div class="container">
        <?php  while ($row = mysqli_fetch_assoc($result)) { ?>

        <div class="row text-center shadow-lg mt-3  p-3 align-items-center mx-2"
            style="background-color: white; border-radius:10px">
            <div class="col-sm-2">
                <img src="stu_assets/Ebookview.gif" alt="pdf image" class="py-sm-0 py-2" style="width:100px;">
            </div>
            <div class="col-sm-6" style="align-self: center;">
                <h5 class="h5 fw-bold text-break"><?= $row['Files']; ?></h5>
                <!-- <h6 class="fw-bold"><?= $row['Description']; ?></h6> -->
            </div>

            <div class="col-sm-4" style="align-self: center;">
                <a href="<?php echo BASE_URL ?>AdminPanel/<?= $row['file_Path']; ?>" target="_blank" type="button"
                    class="btn btn-dark btn-md">CLICK TO VIEW</a>
            </div>

        </div>
        <?php  } ?>
    </div>
    <?php } else { ?>
    <div class="container mt-3 shadow-lg p-3 align-items-center" style="background-color: white; border-radius:10px">
        <div class="row text-center">
            <div class="col">
                <img src="stu_assets/Ebookview.gif" alt="pdf image" class="py-sm-0 py-2" style="width:100px;">
                <h4 class="fw-bold text-danger">No Data Found!</h4>
                <!-- <h6 class="fw-bold">Try Again Some Time Please!!!</h6> -->
            </div>
        </div>
    </div>
    <?php
            }
        }
    }
}else{
    echo '<div class="text-center" >';
    echo '<a href="e-BookPayment" type="button" class="btn btn-dark btn-md">CLICK TO BUY e-BOOK</a>';
    echo '</div>';
}
    
    
    ?>
</body>

</html>
<script>
function check_session_id() {
    var session_id = "<?php echo $_SESSION['user_session_id']; ?>";

    // var page = "logoutPage.php";
    //console.log(url);

    fetch('check_login.php').then(function(response) {

        return response.json();

    }).then(function(responseData) {

        if (responseData.output == 'logout') {
            window.location.href = '../logoutPage';
        }

    });
}

setInterval(function() {

    check_session_id();

}, 10000);

var login_ok = "<?php echo $_SESSION['user_session_id']; ?>";
//console.log(login_ok);
</script>