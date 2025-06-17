<?php
ob_start();

if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['logged_in']) == true) {
    header("Location:../Login");
}

require dirname(__DIR__) . '/database/dbconfig.php';
//echo BASE_URL;
$userId = $_SESSION['id'];

$query1 = "SELECT * FROM students WHERE id = '$userId'";
$query_run1 = mysqli_query($connection, $query1);

$row1 = mysqli_fetch_assoc($query_run1);

$stuFname = $row1['fname'];
$stuLname = $row1['surname'];
$email = $row1['email'];
$parentname = $row1['parentfirstname'];
$phone = $row1['phone'];
$dob = $row1['dob'];
$dob = strtotime($dob);
//$date = date("D-M-Y", $dob);
$studob = date("d-m-Y", $dob); //date("d-m-Y", $dob);
$lan = $row1['Stu_Sub'];
$cat = $row1['Stu_Cat'];
$course = $row1['category'];
// $exterm = $row1['terms'];
// var_dump($exterm);
// $expterms = explode(",", $exterm);
$termPrice = "";

$ebook = "";
if (isset($_POST['submit'])) {
    //print_r($_POST);
    //die();
    $term = $_POST['term'];
    $_SESSION['term'] = $term;
      // Module-based pricing for Year 4, 5, and 6 students
    if ($term == "Comprehension" && ($row1['Stu_Cat'] == "Year4" || $row1['Stu_Cat'] == "Year5" || $row1['Stu_Cat'] == "Year6")) {
        $termPrice = 105.00; // Fixed price for Comprehension module
    } elseif ($term == "Creative Writing" && ($row1['Stu_Cat'] == "Year4" || $row1['Stu_Cat'] == "Year5" || $row1['Stu_Cat'] == "Year6")) {
        $termPrice = 165.00; // Fixed price for Creative Writing module
    } elseif ($term == "SPaG" && ($row1['Stu_Cat'] == "Year4" || $row1['Stu_Cat'] == "Year5" || $row1['Stu_Cat'] == "Year6")) {
        $termPrice = 125.00; // Fixed price for SPaG module
    } elseif ($term == "English Vocabulary" && ($row1['Stu_Cat'] == "Year4" || $row1['Stu_Cat'] == "Year5" || $row1['Stu_Cat'] == "Year6")) {
        $termPrice = 125.00; // Fixed price for English Vocabulary module
    } elseif ($term == "Verbal Reasoning" && ($row1['Stu_Cat'] == "Year4" || $row1['Stu_Cat'] == "Year5" || $row1['Stu_Cat'] == "Year6")) {
        $termPrice = 210.00; // Fixed price for Verbal Reasoning module
    } elseif ($term == "Carousel Course" && ($row1['Stu_Cat'] == "Year4" || $row1['Stu_Cat'] == "Year5" || $row1['Stu_Cat'] == "Year6")) {
        $termPrice = 68.00; // Fixed price for Carousel Course (monthly)
    } elseif ($term == "1:1 Tutoring" && ($row1['Stu_Cat'] == "Year4" || $row1['Stu_Cat'] == "Year5" || $row1['Stu_Cat'] == "Year6")) {
        $termPrice = 45.00; // Fixed price for 1:1 Tutoring (hourly)
    } elseif ($term == "Term 12" || $term == "Term 13") {
        // $termPrice = $_POST['readandwrite']; //readandwrite
        // $termPrice = 155.00;
        $termPrice = 155.00 + (155.00  * (20 / 100));
        //echo $termPrice;
    } elseif ($term == "EBook" && $row1['Stu_Cat'] == "PrePrep") {
        // $termPrice = $_POST['ebookforpreprep'];
        $queryTerm = "SELECT * FROM addhomework WHERE Section='E-Book' AND Category='PrePrep' AND Terms='EBook'";
        $queryTRun = mysqli_query($connection, $queryTerm);
        if(mysqli_num_rows($queryTRun) > 0 ){
            $row2 = mysqli_fetch_assoc($queryTRun);
            $termPrice = $row2['Amount'];
            //$ebook = 'E-Book';
            //print_r($termPrice);
            //echo $termPrice;
        }else{
            
            $termPrice = 18.99;
            //$ebook = 'E-Book';
            //print_r($termPrice);
            //echo $termPrice;
        }
        
    } elseif ($term == "EBook" && $row1['Stu_Cat'] == "Junior") {
        // $termPrice = $_POST['ebookforjunior'];
        $queryTerm = "SELECT * FROM addhomework WHERE Section='E-Book' AND Category='Junior' AND Terms='EBook'";
        $queryTRun = mysqli_query($connection, $queryTerm);
        
        if(mysqli_num_rows($queryTRun) > 0 ){
            $row2 = mysqli_fetch_assoc($queryTRun);
            $termPrice = $row2['Amount'];
            //print_r($termPrice);
            //$ebook = 'E-Book';
            //echo $termPrice;
        }else{
            
            $termPrice = 21;
            //$ebook = 'E-Book';
            //print_r($termPrice);
            //echo $termPrice;
        }
        
    } else {
        // $termPrice = $_POST['price'];
        // $termPrice = $row1['child_category'];
        $termPrice = $row1['child_category'] + ($row1['child_category'] * (20 / 100));
        //echo $termPrice;
    }
    
    $_SESSION['termprice'] = $termPrice;
    $_SESSION['termname'] = $term;
    $_SESSION['isEBook'] = $ebook;
    // echo $termPrice;
    // echo $term;
    // die();
    if ($term && $termPrice != "") {
        //echo $term;
        // $termPrice;
       
        //$success_url .= "?session_id={CHECKOUT_SESSION_ID}";
        // get the user's session name from the sessio
        $user_session_id = $_SESSION['id'];
        // add the user's session name as a query string parameter to the success URL
        //$success_url .= "&user_session_id=" . urlencode($user_session_id);
        //$success_url .= "&termname=" . urlencode($term);
        //$success_url .= "&termprice=" . urlencode($termPrice);
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'];
        $success_url = $protocol . $host . BASE_URL . 'StudentsDashboard/update_status';
        $cancel_url = $protocol . $host . BASE_URL . 'StudentsDashboard/BuyTerm';
        // echo $success_url; // Commented out debug line
        //echo $cancel_url;
        //echo $lan;
        //echo $course;
        //die();
        require'../vendor/autoload.php';
        //header('Content-Type','application/json');

        $stripe = new Stripe\StripeClient("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");
        // $stripe = new Stripe\StripeClient("sk_test_51LCh96SDeGlL7XhCXtq0EhWWmyc7vgZHVMdtvJ2mnyZagjcOpfRWqUKHBpdPyl5f8VJzyu5ljTP0NjQHNtPpJSvy00TaYGmj4P");
        $session = $stripe->checkout->sessions->create([

            "success_url" => "$success_url?session_id={CHECKOUT_SESSION_ID}&stuid=".urlencode($user_session_id)."&term=".urlencode($term)."&price=".urlencode($termPrice),
            "cancel_url" => "$cancel_url?cancel",

            "payment_method_types" => ['card'],
            "mode" => 'payment',
            "line_items" => [
                [
                    "price_data" => [
                        "currency" => "gbp",
                        "product_data" => [
                            "name" => $stuFname . ' ' . $stuLname . ' - ' .  $lan,
                            "description" => $course . ' / ' .  $term,

                        ],
                        "unit_amount" => $termPrice * 100
                    ],
                    "quantity" => 1
                ],


            ],
            // 'automatic_tax' => [
            //     'enabled' => true,
            // ],
        ]);
       
        header('Location:'.$session->url);
        //print_r($session); 
        exit();
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Smile4Kids | Select Term</title>
    <!--<link rel="stylesheet" href="https://use.typekit.net/qom5wfr.css" />-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <script src="https://kit.fontawesome.com/398c77c1ca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <style>
    .termPopUpMsgMain {
        height: 100vh;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: rgb(0, 0, 0, .5);

    }

    .termPopUpMsgMain .termsContainer {
        width: 400px;
        /* color: #27ae60; */
    }

    .termPopUpMsgMain .next_button {
        background-color: #6e20a7;
    }

    .checkbox {
        font-size: 16px;
    }

    .radio {
        accent-color: #6e20a7;
    }

    .termsContainer select {
        font-weight: bold;
    }

    .termsContainer .h5 {
        color: #6e20a7;
    }

    .selectCategory label {
        font-weight: bold;
    }

    option {
        font-weight: bold;
        color: black;
    }
    </style>
    <!-- toest -->
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <!--<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php
    if(isset($_GET['cancel'])) {
        //echo "<script type='text/javascript'>alert('Payment canceled!?')</script>";
        echo "<script type='text/javascript'>toastr.info('Your Payment is canceled..!?')</script>";
    }
    //  if (isset($_GET['session_id'])) {
    //     $transctionId = $_GET['session_id'];
        
    //     //if($_SESSION['termname'] && $_SESSION['termprice']){
    //         $userId = $_SESSION['id'];
    //         $termname =  $_SESSION['termname'];
    //         $termprice = $_SESSION['termprice'];
    //         $lan = $_SESSION['paid_Cat'];
    //         $cat = $_SESSION['paid_Lang'];
    //         $isEbook = $_SESSION['isEBook'];
    //         array_push($expterms, $termname);
    //         if($exterm !== ""){
    //             $addTerm = implode(",", $expterms);
    //         }else{
    //             $addTerm = $termname;
    //         }
    //     //$addTerm = implode(",", $expterms);
    //         if($termname == 'EBook'){
                 
    //             $insert_query = "INSERT INTO terms_details (student_id,language,course,termname,termprice,transaction_id,payment_status) VALUES ('$userId','$lan','$cat','$termname','$termprice','$transctionId','$isEbook')";
    //             //echo $insert_query;
    //              $query_run1 = mysqli_query($connection, $insert_query);
    //             //print_r($query_run1);
    //             if($termname == 'EBook'){
    //                 $update_sql = "UPDATE students SET status = 2, terms = '$addTerm' WHERE id= $userId ";
    //              } else{
    //                 $update_sql = "UPDATE students SET status = 2 ,test_update = CURRENT_TIMESTAMP  WHERE id= $userId";
    //              }
    //             //echo  $update_sql;
    //             $query_run = mysqli_query($connection, $update_sql);
    //             //exit();
    //             //print_r($query_run);
    //         }else{
    //             $update_sql = "UPDATE students SET status = 1 ,Stu_Status = 'Live' , Stu_Term = '$termname', terms = '$addTerm'   WHERE id= $userId ";
    //             //echo  $update_sql;echo'<br>';
    //             $query_run = mysqli_query($connection, $update_sql);
    //             //print_r($query_run);echo'<br>';
    //             $insert_query = "INSERT INTO terms_details (student_id,language,course,termname,termprice,transaction_id,payment_status,created_at) VALUES ('$userId','$lan','$cat','$termname','$termprice','$transctionId','active',CURRENT_TIMESTAMP)";
    //             //echo  $insert_query ;echo'<br>';
    //             $query_run1 = mysqli_query($connection, $insert_query);
    //             //print_r($query_run1);
    //             //exit();
                
    //         }
    //   // }
    //     if($transctionId){
    //         require   '../mail/PHPMailerAutoload.php';                    //PHPMailerAutoload.php
    //         require   '../mail/class.phpmailer.php';
    //         require  '../mail/class.smtp.php';
    
    //         $mail = new PHPMailer;
    //         $mail->isSendMail();
    //         // $mail->isMail();
    //         $mail->isSMTP();
            
    //         $mail->Host = 'smile4kids.co.uk'; //smtp.mail.yahoo.com
    //         $mail->SMTPAuth = true;
    //     //   port for Send email
    //         $mail->SMTPSecure = 'ssl';  //ssl tls
    //         $mail->Port = 465;       //465 587
    //         // $mail->SMTPDebug = 0;
    //         $mail->Username = 'safrina@smile4kids.co.uk'; //your-Yahoo-address@Yahoo.com
    //         $mail->Password = 'Monday@123'; //add-your-Yahoo-Password
    //         $mail->setfrom('safrina@smile4kids.co.uk', ' Success at 11 plus English');
    //     //   Recipient
    //         $mail->addAddress($email, $stuFname);
    //         $mail->addCustomHeader('Content-Transfer-Encoding: BASE64');
    //         $mail->addReplyTo('safrina@smile4kids.co.uk', ' Success at 11 plus English');
    //     //   Content
    //         $mail->isHTML(true); // Set email format to HTML
    //         $mail->Subject = 'Payment Successful On Your Purchase';
    //         $mail->Body    = '<html><body><p>Dear ' . $stuFname . ' ' . $stuLname . ',<br> Thank you for purchasing,<br><br> Language : ' . $lan . '.<br>Course : ' . $course . ' <br>Term : ' . $termname . ' <br>Term Price : ' . $termprice . ' <br><br>Regards,<br> Success at 11 plus English Indian Language School.<br><a href="https://smile4kids.co.uk/" target="_blank">smile4kids.co.uk</a></p></body></html>';
    //         $mail->AltBody = 'This is the body in plain text for non-HTML mail clients at <a href="https://smile4kids.co.uk/">Visit Smile4kids.com!</a>';
    
    //     //This should be the same as the domain of your From address
    //         $mail->DKIM_domain = 'smile4kids.co.uk';
    //     //See the DKIM_gen_keys.phps script for making a key pair -
    //     //here we assume you've already done that.
    //     //Path to your private key:
    //         $mail->DKIM_private = '../mail/dkim_private.pem';
    //     //Set this to your own selector
    //         $mail->DKIM_selector = 'default';
    //     //Put your private key's passphrase in here if it has one
    //         $mail->DKIM_passphrase = '';
    //     //The identity you're signing as - usually your From address
    //         $mail->DKIM_identity = $mail->From;
    //     //Suppress listing signed header fields in signature, defaults to true for debugging purpose
    //         $mail->DKIM_copyHeaderFields = false;
    
    //         if (!$mail->Send()) {
    //             //$_SESSION['status'] =$mail->ErrorInfo;
    //             //header("Location:index.php");  
    //             echo 'Message could not be sent.';
    //             echo 'Mailer Error: ' .$mail->ErrorInfo;
    //             exit;
    //         } else {
    //             //$_SESSION['status'] ="Your subscription added successfully!";
    //             //header("Location:index.php");
    //             echo 'Message1 of Send email using Yahoo SMTP server has been sent';
    //             //print_r($mail);
                
    //         //   Admin Mail
    //             $mail->clearAddresses();
    //             // $mail->addAddress('reguramachandran007@gmail.com', "Safrina");
    //             $mail->addAddress('sfs662001@yahoo.com', "Safrina");
    //             // $mail->AddAddress('vinothkumar.umapathy@yahoo.com', "Safrina");
    //             $mail->addCustomHeader('Content-Transfer-Encoding: BASE64');
    //             $mail->addReplyTo($email,$stuFname);
    //         //   Content
    //             $mail->Subject = 'Hi safrina';
    //             $mail->Body    = '<html><body><strong style = "font-size:18px"> ' . $stuFname . ' ' . $stuLname . '</strong>, has bought  ' . $termname . ' in ' . $course . ' - <strong>' . $lan . '</strong>.<br><strong>Contact Details</strong><br>Date of Birth : ' . $studob . '<br>Parent\'s Name : ' . $parentname . '<br> Email Address : ' . $email . '<br>Phone Number : ' . $phone . '<br><br>Regards,<br> Success at 11 plus English Indian language School.</body></html>';
    //             $mail->AltBody = 'This is the body in plain text for non-HTML mail clients at <a href="https://smile4kids.co.uk/">Visit Smile4kids.co.uk!</a>';
                
    //         //This should be the same as the domain of your From address
    //             $mail->DKIM_domain = 'smile4kids.co.uk';
    //         //See the DKIM_gen_keys.phps script for making a key pair -
    //         //here we assume you've already done that.
    //         //Path to your private key:
    //             $mail->DKIM_private = '../mail/dkim_private.pem';
    //         //Set this to your own selector
    //             $mail->DKIM_selector = 'default';
    //         //Put your private key's passphrase in here if it has one
    //             $mail->DKIM_passphrase = '';
    //         //The identity you're signing as - usually your From address
    //             $mail->DKIM_identity = $mail->From;
    //         //Suppress listing signed header fields in signature, defaults to true for debugging purpose
    //             $mail->DKIM_copyHeaderFields = false;
                
    //             if (!$mail->send()) {
    //                 echo 'Message2 could not be sent.';
    //                 echo 'Mailer Error: ' .$mail->ErrorInfo;
    //                 exit;
    //             } else {
    //                 //echo 'Message2 of Send email using Yahoo SMTP server has been sent';
    //                 //print_r($mail);
    //                 $_SESSION['status'] = " Welcome " .  $stuFname;
    //                 // $_SESSION['category'] = $course;
                    
    //                 header("Location:adminstu");
    //                 exit();
    //             }
    //         }
    //     }
    // } 
    ?>
    <style>
    #toast-container>.toast-info {
        background-color: #D93D1B;
        color: #000;
    }
    </style>
    <div class="termPopUpMsgMain">
        <div class="termsContainer card rounded p-3">
            <form action="" method="POST" class="needs-validation" novalidate>
                <label for="select-terms" class="h5 fw-bold">Select Term</label>                <?php
                if ($row1['Stu_Cat'] == "Year4") { ?>
                <select class="form-select shadow-none fw-bold" name="term" aria-label="Choose Term" id="select-terms"
                    required>
                    <option value="Term 1">Term 1 <small>(speaking)</small></option>
                    <option value="Term 2">Term 2 <small>(speaking)</small></option>
                    <option value="Term 3">Term 3 <small>(speaking)</small></option>
                    <option value="Term 4">Term 4 <small>(speaking)</small></option>
                    <option value="Term 5">Term 5 <small>(speaking)</small></option>
                    <option value="Term 6">Term 6 <small>(speaking)</small></option>
                    <option value="Term 7">Term 7 <small>(speaking)</small></option>
                    <option value="Term 8">Term 8 <small>(speaking)</small></option>
                    <option value="Term 9">Term 9 <small>(speaking)</small></option>
                    <option value="Term 10">Term 10 <small>(speaking)</small></option>
                    <option value="Term 11">Term 11 <small>(speaking)</small></option>
                    <option value="Term 12" disabled>Term 12 <small>(Read/write)</small></option>
                    <option value="Term 13" disabled>Term 13 <small>(Read/write)</small></option>
                    <option value="EBook">E-Book</option>
                </select>                <?php    } elseif ($row1['Stu_Cat'] == "Year5" || $row1['Stu_Cat'] == "Year6") { ?>
                <select class="form-select shadow-none fw-bold" name="term" aria-label="Choose Term" id="select-terms"
                    required>
                    <option value="Term 1">Term 1 <small>(speaking)</small></option>
                    <option value="Term 2">Term 2 <small>(speaking)</small></option>
                    <option value="Term 3">Term 3 <small>(speaking)</small></option>
                    <option value="Term 4">Term 4 <small>(speaking)</small></option>
                    <option value="Term 5">Term 5 <small>(speaking)</small></option>
                    <option value="Term 6">Term 6 <small>(speaking)</small></option>
                    <option value="Term 7">Term 7 <small>(speaking)</small></option>
                    <option value="Term 8">Term 8 <small>(speaking)</small></option>
                    <option value="Term 9">Term 9 <small>(speaking)</small></option>
                    <option value="Term 10">Term 10 <small>(speaking)</small></option>
                    <option value="Term 11">Term 11 <small>(speaking)</small></option>
                    <option value="Term 12">Term 12 <small>(Read/write)</small></option>
                    <option value="Term 13">Term 13 <small>(Read/write)</small></option>
                </select>
                <?php  } else { ?>
                <select class="form-select shadow-none fw-bold" name="term" aria-label="Choose Term" id="select-terms"
                    required>
                    <option value="Term 1">Term 1 <small>(speaking)</small></option>
                    <option value="Term 2">Term 2 <small>(speaking)</small></option>
                    <option value="Term 3">Term 3 <small>(speaking)</small></option>
                    <option value="Term 4">Term 4 <small>(speaking)</small></option>
                    <option value="Term 5">Term 5 <small>(speaking)</small></option>
                    <option value="Term 6">Term 6 <small>(speaking)</small></option>
                    <option value="Term 7">Term 7 <small>(speaking)</small></option>
                    <option value="Term 8">Term 8 <small>(speaking)</small></option>
                    <option value="Term 9">Term 9 <small>(speaking)</small></option>
                    <option value="Term 10">Term 10 <small>(speaking)</small></option>
                    <option value="Term 11">Term 11 <small>(speaking)</small></option>
                    <option value="Term 12">Term 12 <small>(Read/write)</small></option>
                    <option value="Term 13">Term 13 <small>(Read/write)</small></option>
                    <option value="EBook">E-Book</option>
                </select>
                <?php  } ?>
                <!--<div class="selectCategory">-->
                <!-- selectCategory -->
                <!--</div>-->
                <div class="d-flex justify-content-between my-2">
                    <button type="button" class="btn shadow-none text-white fw-bold bg-secondary"
                        onclick="locations()">Back</button>
                    <button type="submit" name="submit"
                        class="btn shadow-none next_button text-white fw-bold bg-success">Next</button>
                </div>
            </form>
        </div>
    </div>
    <!--<script>-->
    <!--    const selectValue = document.getElementById('select-terms');-->
    <!--    const childCategory = document.querySelector('.selectCategory')-->
    <!--    var selectCategory = `-->
    <!--    <div class="h5 fw-bold my-3" >Select Child Category</div>-->
    <!--            <div>-->
    <!--                <input class="radio" type="radio" name="price" id="firstChild" value="140" required >-->
    <!--                <label class="user-select-none" for="firstChild">-->
    <!--                    First Child-->
    <!--                </label>-->
    <!--            </div>-->
    <!--            <div>-->
    <!--                <input class="radio" type="radio" name="price" id="secondChild" value="130" required >-->
    <!--                <label class="user-select-none" for="secondChild">-->
    <!--                    Second Child-->
    <!--                </label>-->
    <!--            </div>-->
    <!--            <div>-->
    <!--                <input class="radio" type="radio" name="price" id="adult" value="155" required >-->
    <!--                <label class="user-select-none" for="adult">-->
    <!--                    Adult-->
    <!--                </label>-->

    <!--                <div class="invalid-feedback fs-6">Please Choose Category</div>-->

    <!--            </div>-->
    <!--    `-->
    <!--    var creatediv = document.createElement('div');-->
    <!--    creatediv.innerHTML = selectCategory;-->
    <!--    childCategory.appendChild(creatediv)-->
    <!--    document.addEventListener('change', () => {-->

    <!--        if (selectValue.value == "Term 12" || selectValue.value == "Term 13" || selectValue.value == "EBook") {-->

    <!--            creatediv.remove()-->
    <!--        } else {-->
    <!--            childCategory.appendChild(creatediv)-->
    <!--        }-->
    <!--    })-->
    <!--</script>-->
    <script src="formvalidation.js"></script>
    <script>
    function locations() {
        //var id=20; get the value of id and save in id(getElementById or jquery) 
        window.location.href = "../Login.php";
    }
    </script>
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
</body>

</html>