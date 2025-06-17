<?php
ob_start();
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['logged_in']) == true) {
    header("Location:../Login");
}
require dirname(__DIR__) . '/database/dbconfig.php';
// echo BASE_URL;

$userId = $_SESSION['id'];
// echo $userId;
$termPrice = "";

$query1 = "SELECT * FROM students WHERE id = '$userId'";
$query_run1 = mysqli_query($connection, $query1);

if(mysqli_num_rows($query_run1)>0){
    
    $row1 = mysqli_fetch_assoc($query_run1);
    $stuFname = $row1['fname'];
    $stuLname = $row1['surname'];
    $lan = $row1['Stu_Sub'];
    $course = $row1['category'];
    
    if($row1['Stu_Cat'] == "PrePrep"){
        $queryTerm = "SELECT * FROM addhomework WHERE Section='E-Book' AND Category='PrePrep' AND Terms='EBook'";
        $queryTRun = mysqli_query($connection, $queryTerm);
        if(mysqli_num_rows($queryTRun) > 0 ){
            $row2 = mysqli_fetch_assoc($queryTRun);
            $termPrice = $row2['Amount'];
            $termname = 'EBook';
            //print_r($termPrice);
            //echo $termPrice;
            //echo $termname;
        }else{
            
            $termPrice = 18.99;
            $termname = 'EBook';
            //echo $termPrice;
            //echo $termname;
        }
        
    }else if($row1['Stu_Cat'] == "Junior"){
        $queryTerm = "SELECT * FROM addhomework WHERE Section='E-Book' AND Category='Junior' AND Terms='EBook'";
        $queryTRun = mysqli_query($connection, $queryTerm);
        
        if(mysqli_num_rows($queryTRun) > 0 ){
            $row2 = mysqli_fetch_assoc($queryTRun);
            $termPrice = $row2['Amount'];
            //print_r($termPrice);
            $termname = 'EBook';
            //echo $termPrice;
            //echo $termname;
        }else{
            
            $termPrice = 21;
            $termname = 'EBook';
            //echo $termPrice;
            //echo $termname;
        }
    }
}
    $_SESSION['termprice'] = $termPrice;
    $_SESSION['termname'] = $termname;
    if ($termname && $termPrice != "") {
        $success_url =  BASE_URL . 'StudentsDashboard/itemebook';
        $cancel_url =   BASE_URL . 'StudentsDashboard/itemebook';
    //   echo $success_url;
        // die();
        require  '../vendor/autoload.php';
        //header('Content-Type', 'application/json');

        $stripe = new Stripe\StripeClient("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");
       // $stripe = new Stripe\StripeClient("sk_test_51LCh96SDeGlL7XhCXtq0EhWWmyc7vgZHVMdtvJ2mnyZagjcOpfRWqUKHBpdPyl5f8VJzyu5ljTP0NjQHNtPpJSvy00TaYGmj4P");

        $session = $stripe->checkout->sessions->create([

            "success_url" => "$success_url?session_id={CHECKOUT_SESSION_ID}",
            "cancel_url" => "$cancel_url?cancel",

            "payment_method_types" => ['card'],
            "mode" => 'payment',
            "line_items" => [
                [
                    "price_data" => [
                        "currency" => "gbp",
                        "product_data" => [
                            "name" => $stuFname . ' ' . $stuLname . ' - ' .  $lan,
                            "description" => $course . ' / ' .  $termname,

                        ],
                        "unit_amount" => $termPrice * 100
                    ],
                    "quantity" => 1
                ],


            ],
            'automatic_tax' => [
                'enabled' => true,
            ],
        ]);
        // echo $session->url;
        header('Location:' . $session->url);
        exit();
    }