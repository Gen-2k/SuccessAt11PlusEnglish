<?php
ob_start();
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['logged_in']) == true) {
    header("Location:../Login");
}

require dirname(__DIR__) . '/database/dbconfig.php';
$userId = $_SESSION['id'];
//echo $userId;
// $userId = 125;

// if (!empty($userId)) {
    $query = "SELECT termname FROM terms_details WHERE student_id = '$userId'";
    $query_run = mysqli_query($connection, $query);
    $row = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
    //print_r($row);

    // if (mysqli_num_rows($query_run) >0) {
    //   $row = mysqli_fetch_assoc($query_run);
    // } else {
    //     echo "somthing went to wrong..!";
    // }

    $query1 = "SELECT *	FROM students WHERE id = '$userId'";
    $query_run1 = mysqli_query($connection, $query1);
   

    // if (mysqli_num_rows($query_run1)>0) {
        $row1 = mysqli_fetch_assoc($query_run1);
        $stuFname = $row1['fname'];
        $stuLname = $row1['surname'];
        $email = $row1['email'];
        $parentname = $row1['parentfirstname'];
        $phone = $row1['phone'];
        $lan = $row1['Stu_Sub'];
        $cat = $row1['Stu_Cat'];
        $course = $row1['category'];
        $exterm = $row1['terms'];
        // var_dump($exterm);
        $expterms = explode(",", $exterm);
        
        
    // } else {
    //     echo "somthing went to wrong..!";
    // }
    // }

    $termPrice = "";
    $termName = "";

    if (isset($_POST['submit'])) {
        //print_r($_POST);
        //die();
        $term = $_POST['term'];
         $impterms = explode(",", $term);
         $valres = array_intersect($expterms, $impterms);
        // var_dump($valres);
        
        if ($term == implode($valres) && ($row1['status'] == 1 || $row1['status'] == 2)) {
            // $termPrice = $_POST['test'];
            $termPrice = 13.00;
            $termName = "TEST";
            // echo $termPrice; 
            // echo "<br>";
            // echo $termName;
        } elseif ($term == "Term 12" || $term == "Term 13") {
            // $termPrice = $_POST['readandwrite'];
            // $termPrice = 155;
            $termPrice = 155 + (155  * (20 / 100));
            $termName = $term;
            // echo $termPrice; 
            // echo "<br>";
            // echo $termName;
        } elseif ($term == "EBook" && $row1['Stu_Cat'] == "PrePrep") {
            // $termPrice = $_POST['ebookforpreprep'];
            $queryTerm = "SELECT * FROM addhomework WHERE Section='E-Book' AND Category='PrePrep' AND Terms='EBook'";
            $queryTRun = mysqli_query($connection, $queryTerm);
            
            if(mysqli_num_rows($queryTRun) > 0 ){
                $row2 = mysqli_fetch_assoc($queryTRun);
                $termPrice = $row2['Amount'];
                $termName = $term;
                $ebook = 'E-Book';
                //print_r($termPrice);
                //echo $termPrice;
            }else{
                
                $termPrice = 18.99;
                $termName = $term;
                $ebook = 'E-Book';
                //print_r($termPrice);
                //echo $termPrice;
            }        } elseif ($term == "EBook" && $row1['Stu_Cat'] == "Junior") {
            // $termPrice = $_POST['ebookforjunior'];
            $queryTerm = "SELECT * FROM addhomework WHERE Section='E-Book' AND Category='Junior' AND Terms='EBook'";
            $queryTRun = mysqli_query($connection, $queryTerm);
            
            if(mysqli_num_rows($queryTRun) > 0 ){
                $row2 = mysqli_fetch_assoc($queryTRun);
                $termPrice = $row2['Amount'];
                $termName = $term;
                //print_r($termPrice);
                $ebook = 'E-Book';
                //echo $termPrice;
            }else{
                
                $termPrice = 21;
                $termName = $term;
                $ebook = 'E-Book';
                //print_r($termPrice);
                //echo $termPrice;
            }
        } elseif ($term == "EBook" && ($row1['Stu_Cat'] == "Year4" || $row1['Stu_Cat'] == "Year5" || $row1['Stu_Cat'] == "Year6")) {
            // E-Book pricing for Year4, Year5, Year6 students
            $queryTerm = "SELECT * FROM addhomework WHERE Section='E-Book' AND (Category='Year4' OR Category='Year5' OR Category='Year6') AND Terms='EBook'";
            $queryTRun = mysqli_query($connection, $queryTerm);
            
            if(mysqli_num_rows($queryTRun) > 0 ){
                $row2 = mysqli_fetch_assoc($queryTRun);
                $termPrice = $row2['Amount'];
                $termName = $term;
                $ebook = 'E-Book';
            }else{
                // Default E-Book price for Year4/5/6 students
                $termPrice = 21;
                $termName = $term;
                $ebook = 'E-Book';
            }
        } 
        // Module-based pricing for Year4, Year5, and Year6 students
        elseif (($row1['Stu_Cat'] == "Year4" || $row1['Stu_Cat'] == "Year5" || $row1['Stu_Cat'] == "Year6") && 
                 ($term == "Comprehension" || $term == "Creative Writing" || $term == "SPaG" || 
                  $term == "English Vocabulary" || $term == "Verbal Reasoning" || 
                  $term == "Carousel Course" || $term == "1:1 Tutoring")) {
            
            // Set fixed prices for modules based on the Year pages pricing
            if ($term == "Comprehension") {
                $termPrice = 105; // 6-8 classes
            } elseif ($term == "Creative Writing") {
                $termPrice = 165; // 8 classes
            } elseif ($term == "SPaG") {
                $termPrice = 125; // 8 classes
            } elseif ($term == "English Vocabulary") {
                $termPrice = 125; // 8 classes
            } elseif ($term == "Verbal Reasoning") {
                $termPrice = 210; // 12 classes
            } elseif ($term == "Carousel Course") {
                $termPrice = 68; // Per month
            } elseif ($term == "1:1 Tutoring") {
                $termPrice = 45; // Per hour
            }
            $termName = $term;
        }
        else {
            // $termPrice = $_POST['price'];
            $termPrice = $_POST['price'] + ($_POST['price'] * (20 / 100));
            $termName = $term;
            //echo $termPrice; 
            //echo "<br>";
            //echo $termName;
        }
        $_SESSION['termprice'] = $termPrice;
        $_SESSION['term'] = $termName;
        //echo $_SESSION['termname'];
        //echo $_SESSION['termprice'];
        // die();
        

        if ($termName && $termPrice != "") {
             $user_session_id = $_SESSION['id'];
            //echo BASE_URL;
            // echo "<br>";
            // echo $termName;
            // echo "<br>";
            // echo $termPrice;
            //die();
            $success_url = BASE_URL . 'StudentsDashboard/update_status';
            $cancel_url = BASE_URL . 'StudentsDashboard/purchaseTerms';
            //echo $success_url;
            //echo "<br>";
            //echo $cancel_url;
            //echo "<br>";
            //echo $lan;
            //echo "<br>";
            // $course;
            //die();
            require '../vendor/autoload.php';
           //header('Content-Type','application/json');
            $stripe = new Stripe\StripeClient("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");
            // $stripe = new Stripe\StripeClient("sk_test_51LCh96SDeGlL7XhCXtq0EhWWmyc7vgZHVMdtvJ2mnyZagjcOpfRWqUKHBpdPyl5f8VJzyu5ljTP0NjQHNtPpJSvy00TaYGmj4P");
 
            $session = $stripe->checkout->sessions->create([
            "success_url" => "$success_url?session_id={CHECKOUT_SESSION_ID}&stuid=".urlencode($user_session_id)."&term=".urlencode($termName)."&price=".urlencode($termPrice),
                "cancel_url" => "$cancel_url?cancel",
                "payment_method_types" => ['card'],
                "mode" => 'payment',
                "line_items" => [
                    [
                        "price_data" => [
                            "currency" => "gbp",
                            "product_data" => [
                                "name" => $stuFname . ' ' . $stuLname . ' - ' .  $lan,
                                "description" => $course . ' / ' . $termName,

                            ],
                            "unit_amount" => $termPrice * 100
                        ],
                        "quantity" => 1
                    ],


                ],
            //     'automatic_tax' => [
            //     'enabled' => true,
            // ],
            ]);
            //echo json_encode($session->url);
            header('Location:'.$session->url);
            exit();
        }
    }
// } else {
    //echo "Please select the term";
// }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="smile4kids" />
    <title>Smile4Kids | Select Term</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
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
            color: #27ae60;
        }

        .termPopUpMsgMain .next_button {
            background-color: #6e20a7;
        }

        .checkbox {
            font-size: 16px;
        }

        .radio {
            accent-color: red;
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
</head>

<body>
    <?php
    if (isset($_GET['cancel'])) {
        //echo "<script type='text/javascript'>alert('Payment canceled!?')</script>";
        echo "<script type='text/javascript'>toastr.info('Your Payment Was canceled..!?')</script>";
        //unset($_SESSION['status']); 
        //header("Location:file-demo.php");
    }
    // if (isset($_GET['session_id']) && $_GET['session_id'] !='') {

    //     $transctionId = $_GET['session_id'];
    //     //echo $transctionId;
    //     //die();
    //     $termname =  $_SESSION['termname'];
        
    //     //echo $termname;
    //     //die();
    //      array_push($expterms, $termname);
    //     // print_r($expterms);
    //     $addTerm = implode(",", $expterms);
    //     $termprice = $_SESSION['termprice'];
        
    //   if($termname == 'EBook' || $termname == 'TEST'){
    //       $insert_query = "INSERT INTO terms_details (student_id,language,course,termname,termprice,transaction_id,payment_status) VALUES ('$userId','$lan','$cat','$termname','$termprice','$transctionId','$termname')";
    //          $query_run1 = mysqli_query($connection, $insert_query);
    //          //print_r($query_run1);
    //          if($termname == 'EBook'){
    //             $update_sql = "UPDATE students SET status = 2, terms = '$addTerm' WHERE id= $userId ";
    //          } else{
    //              $update_sql = "UPDATE students SET status = 2,test_update = CURRENT_TIMESTAMP WHERE id= $userId ";
    //          }
    //         $query_run = mysqli_query($connection, $update_sql);
 
    //   }else{
    //         $update_sql = "UPDATE students SET status = 1 , Stu_Status = 'Live', Stu_term = '$termname', terms = '$addTerm'  WHERE id= $userId ";
    //         $query_run = mysqli_query($connection, $update_sql);
    //         //print_r($update_sql);
    //         $insert_query = "INSERT INTO terms_details (student_id,language,course,termname,termprice,transaction_id,payment_status,created_at) VALUES ('$userId','$lan','$cat','$termname','$termprice','$transctionId','active',CURRENT_TIMESTAMP)";
    //         $query_run1 = mysqli_query($connection, $insert_query);
    //         //print_r($query_run1);
    //   }
    //     require   '../mail/PHPMailerAutoload.php';                    //PHPMailerAutoload.php
    //     require   '../mail/class.phpmailer.php';
    //     require   '../mail/class.smtp.php';

    //     $mail = new PHPMailer;
    //     $mail->isSendMail();
    //     $mail->isMail();
    //     // $mail->isSMTP();

    //     $mail->Host = 'smtp.gmail.com'; //smtp.mail.yahoo.com
    //     $mail->SMTPAuth = true;
    //     $mail->SMTPSecure = 'ssl';  //ssl tls
    //     $mail->Port = 465;       //465 587
    //     // $mail->SMTPDebug = 1;
    //     $mail->Username = 'Safrina@smile4kids.co.uk'; //your-Yahoo-address@Yahoo.com
    //     $mail->Password = 'teoiljmskiwvamwh'; //add-your-Yahoo-Password
    //     $mail->setfrom('Safrina@smile4kids.co.uk', ' Success at 11 plus English');
    // //   Recipient
    //     $mail->addAddress($email, $stuFname);
    //     $mail->addReplyTo('Safrina@smile4kids.co.uk', ' Success at 11 plus English');
    //     $mail->addCustomHeader('Content-Transfer-Encoding: BASE64');
    //     $mail->isHTML(true); // Set email format to HTML
    // //   Content
    //     $mail->Subject = 'Payment Successful On Your Purchase';
    //     $mail->Body    = '<html><body><p>Dear ' . $stuFname.' '.$stuLname.',<br> Thank you for purchasing,<br><br> Language : ' . $lan . '.<br>Course : ' . $course . '.<br>Term : ' . $termname . ' <br>Term Price : ' . $termprice . ' <br><br>Regards,<br> Success at 11 plus English Indian Language School.<br><a href="https://smile4kids.co.uk/index" target="_blank">smile4kids.co.uk</a></p></body></html>';
    //     $mail->AltBody = 'This is the body in plain text for non-HTML mail clients at <a href =https://www.smile4kids.co.uk/</a>';

    // // This should be the same as the domain of your From address
    //     $mail->DKIM_domain = 'smile4kids.co.uk';
    // // See the DKIM_gen_keys.phps script for making a key pair -
    // // here we assume you've already done that.
    // // Path to your private key:
    //     $mail->DKIM_private = '../mail/dkim_private.pem';
    // // Set this to your own selector
    //     $mail->DKIM_selector = 'default';
    // // Put your private key's passphrase in here if it has one
    //     $mail->DKIM_passphrase = '';
    // // The identity you're signing as - usually your From address
    //     $mail->DKIM_identity = $mail->From;
    // // Suppress listing signed header fields in signature, defaults to true for debugging purpose
    //     $mail->DKIM_copyHeaderFields = false;

    //     if (!$mail->Send()) {
    //         // $_SESSION['status'] = $mail->ErrorInfo;
    //         // header("Location:index.php");  
    //         echo 'Message could not be sent.';
    //         echo 'Mailer Error: ' . $mail->ErrorInfo;
    //         exit;
    //     } else {
    //         // $_SESSION['status'] ="Your subscription added successfully!";
    //         // header("Location:index.php");
    //         echo 'Message1 of Send email using Yahoo SMTP server has been sent';
            
    //         $mail->ClearAllRecipients();
    //     //   For Admin
    //         $mail->addAddress('sfs662001@yahoo.com', "Safrina");
    //         // $mail->AddAddress('reguramachandran007@gmail.com', "Safrina");
    //         // $mail->AddAddress('vinothkumar.umapathy@yahoo.com', "Safrina");
    //         $mail->addReplyTo($email,$stuFname);
    //         $mail->addCustomHeader('Content-Transfer-Encoding: BASE64');
    //     //   Content
    //         $mail->Subject = 'Hi safrina';
    //         $mail->Body    = '<html><body><strong style = "font-size:18px"> ' . $stuFname . ' ' . $stuLname . '</strong>, has bought  ' . $course . ' / ' . $termname . ' - <strong>' . $lan . '</strong>.<br><strong>Contact Details</strong><br>Parent\'s Name : ' . $parentname . '<br> Email Address : ' . $email . '<br>Phone Number : ' . $phone . '<br><br>Regards,<br> Success at 11 plus English Indian Language School.</body></html>';
    //         $mail->AltBody = 'This is the body in plain text for non-HTML mail clients at <a href = https://www.smile4kids.co.in/</a>';

    //     // This should be the same as the domain of your From address
    //         $mail->DKIM_domain = 'smile4kids.co.uk';
    //     // See the DKIM_gen_keys.phps script for making a key pair -
    //     // here we assume you've already done that.
    //     // Path to your private key:
    //         $mail->DKIM_private = '../mail/dkim_private.pem';
    //     // Set this to your own selector
    //         $mail->DKIM_selector = 'default';
    //     // Put your private key's passphrase in here if it has one
    //         $mail->DKIM_passphrase = '';
    //     // The identity you're signing as - usually your From address
    //         $mail->DKIM_identity = $mail->From;
    //     // Suppress listing signed header fields in signature, defaults to true for debugging purpose
    //         $mail->DKIM_copyHeaderFields = false;

    //         if (!$mail->Send()) {
    //             echo 'Message2 could not be sent.';
    //             echo 'Mailer Error: ' . $mail->ErrorInfo;
    //             exit;
    //         } else {
    //             // echo 'Message2 of Send email using Yahoo SMTP server has been sent';
    //             $_SESSION['status'] =  " Welcome "  .  $stuFname;
    //             // $_SESSION['category'] = $course;
    //             header('Location:adminstu');
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
    <div class="termPopUpMsgMain p-2">
        <div class="termsContainer card rounded p-3">
            <form action="" method="POST" class="needs-validation" novalidate>                <label for="select-terms" class="h5 fw-bold">Select Term</label>
                    <select class="form-select shadow-none fw-bold" name="term" aria-label="Choose Term" id="select-terms" required>
                        <option value="Term 1">Term 1 <small>(speaking)</small><?php foreach ($row as $termname){if ($termname['termname'] == 'Term 1') {?> <span>✔️</span> <?php } } ?> </option>
                        <option value="Term 2">Term 2 <small>(speaking)</small><?php foreach ($row as $termname){if ($termname['termname'] == 'Term 2') {?> <span>✔️</span> <?php } } ?> </option>
                        <option value="Term 3">Term 3 <small>(speaking)</small><?php foreach ($row as $termname){if ($termname['termname'] == 'Term 3') {?> <span>✔️</span> <?php } } ?> </option>
                        <option value="Term 4">Term 4 <small>(speaking)</small><?php foreach ($row as $termname){if ($termname['termname'] == 'Term 4') {?> <span>✔️</span> <?php } } ?> </option>
                        <option value="Term 5">Term 5 <small>(speaking)</small><?php foreach ($row as $termname){if ($termname['termname'] == 'Term 5') {?> <span>✔️</span> <?php } } ?> </option>
                        <option value="Term 6">Term 6 <small>(speaking)</small><?php foreach ($row as $termname){if ($termname['termname'] == 'Term 6') {?> <span>✔️</span> <?php } } ?> </option>
                        <option value="Term 7">Term 7 <small>(speaking)</small><?php foreach ($row as $termname){if ($termname['termname'] == 'Term 7') {?> <span>✔️</span> <?php } } ?> </option>
                        <option value="Term 8">Term 8 <small>(speaking)</small><?php foreach ($row as $termname){if ($termname['termname'] == 'Term 8') {?> <span>✔️</span> <?php } } ?> </option>
                        <option value="Term 9">Term 9 <small>(speaking)</small><?php foreach ($row as $termname){if ($termname['termname'] == 'Term 9') {?> <span>✔️</span> <?php } } ?> </option>
                        <option value="Term 10">Term 10 <small>(speaking)</small><?php foreach ($row as $termname){if ($termname['termname'] == 'Term 10') {?> <span>✔️</span> <?php } } ?> </option>
                        <option value="Term 11">Term 11 <small>(speaking)</small><?php foreach ($row as $termname){if ($termname['termname'] == 'Term 11') {?> <span>✔️</span> <?php } } ?> </option>
                <?php                if ($row1['Stu_Cat'] == "Junior" || $row1['Stu_Cat'] == "PrePrep") { ?>
                        <option value="Term 12" disabled>Term 12 <small>(Read/write)</small><?php foreach ($row as $termname){if ($termname['termname'] == 'Term 12') {?> <span>✔️</span> <?php } } ?></option>
                        <option value="Term 13" disabled>Term 13 <small>(Read/write)</small><?php foreach ($row as $termname){if ($termname['termname'] == 'Term 13') {?> <span>✔️</span> <?php } } ?></option>
                        <option value="EBook" style="color:#4e46e5;">E-Book <?php foreach ($row as $termname){if ($termname['termname'] == 'EBook') {?> <span>✔️</span> <?php } } ?></option>
                <?php } elseif ($row1['Stu_Cat'] == "Adults" || $row1['Stu_Cat'] == "Teen") { ?>
                        <option value="Term 12">Term 12 <small>(Read/write)</small><?php foreach ($row as $termname){if ($termname['termname'] == 'Term 12') {?> <span>✔️</span> <?php } } ?></option>
                        <option value="Term 13">Term 13 <small>(Read/write)</small><?php foreach ($row as $termname){if ($termname['termname'] == 'Term 13') {?> <span>✔️</span> <?php } } ?></option>
                <?php } elseif ($row1['Stu_Cat'] == "Year4" || $row1['Stu_Cat'] == "Year5" || $row1['Stu_Cat'] == "Year6") { ?>
                        <option value="EBook" style="color:#4e46e5;">E-Book <?php foreach ($row as $termname){if ($termname['termname'] == 'EBook') {?> <span>✔️</span> <?php } } ?></option>
                <?php }?>
                    </select>
                <div class="selectCategory">
                    <!-- selectCategory -->
                </div>
               
                 <input type="hidden" name="price" value="<?php echo $row1['child_category']; ?>"> 

                <div class="d-flex justify-content-between my-2">
                    <button type="button" class="btn shadow-none text-white fw-bold bg-secondary" onclick="locations()">Back</button>
                    <button type="submit" name="submit" class="btn shadow-none next_button text-white fw-bold bg-success">Next</button>
                </div>
            </form>
        </div>
    </div>
    <!-- <script>
        const selectValue = document.getElementById('select-terms');
        const childCategory = document.querySelector('.selectCategory')
        var selectCategory = `
        <div class="h5 fw-bold my-3" >Select Child Category</div>
                <div>
                    <input class="radio" type="radio" name="price" id="firstChild" value="135" required >
                    <label class="user-select-none" for="firstChild">
                        First Child
                    </label>
                </div>
                <div>
                    <input class="radio" type="radio" name="price" id="secondChild" value="125" required >
                    <label class="user-select-none" for="secondChild">
                        Second Child
                    </label>
                </div>
                <div>
                    <input class="radio" type="radio" name="price" id="adult" value="145" required >
                    <label class="user-select-none" for="adult">
                        Adult
                    </label>

                    <div class="invalid-feedback fs-6">Please Choose Category</div>

                </div>
        `
        var creatediv = document.createElement('div');
        creatediv.innerHTML = selectCategory;
        childCategory.appendChild(creatediv)
        document.addEventListener('change', () => {

            if (selectValue.value == "Term 12" || selectValue.value == "Term 13" || selectValue.value == "EBook") {

                creatediv.remove()
            } else {
                childCategory.appendChild(creatediv)
            }
        })
    </script> -->
    <script src="formvalidation.js"></script>
    <script>
        function locations(){
           
        window.location.href="../Login.php";
        }
    </script>
</body>

</html>