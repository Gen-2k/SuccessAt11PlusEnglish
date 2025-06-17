<?php
if (!isset($_SESSION)) {
    session_start();
    require dirname(__DIR__) . '/database/dbconfig.php';
}
if (!isset($_SESSION['logged_in']) == true) {
    header("Location:../Login");
}
?>
<!DOCTYPE html>
<html lang='en' class=''>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Smile4Kids | FESTIVAL</title>
    <!-- <link rel="icon" type="image/x-icon" href="./assets/images/logonew.png"> -->
    <!--<link rel="stylesheet" href="https://use.typekit.net/qom5wfr.css" />-->
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />-->

    <!--<script src="https://kit.fontawesome.com/398c77c1ca.js" crossorigin="anonymous"></script>-->
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />-->

    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@800&display=swap" rel="stylesheet">
    <!-- heading  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <!-- css path -->
    <style>
       .viewFesMainContainer {
            /* max-width: 600px; */
            width: 100%;
            align-items: center;
        }

         .viewFesMainContainer iframe {
            border-radius: 5px;
            width: 100%;
            height: 90vh;
        }
         @media only screen and (max-width: 425px){
            .viewFesMainContainer iframe {
            height: 45vh;
        }
        }
    </style>


</head>

<body>
    <?php include('studentHeader.php');
    $fespdf = $_GET['fespdf'];
    $festitle = $_GET['festitle'];
    $fesdesc = $_GET['fesdesc'];
    ?>
    <div id="backHomePage">
        <button onclick="history.back()" class="text-decoration-none btn shadow-none ps-0 py-0">
            <div class="backHomePageChild">
                <img src="./stu_assets/home-n.png" alt="back" width="30px" class="mx-2"><span class="fw-bold ps-2">Back to List</span>
            </div>
        </button>
    </div>
    <div class="container d-flex justify-content-center">
        <div class="bg-white rounded my-5 viewFesMainContainer">
            <div>
                <div class="embed-responsive">
                    <iframe class="embed-responsive-item" src="<?php echo BASE_URL;
                                                                echo $fespdf ?>" width="100%" height="100%" controls controlsList="nodownload"></iframe>
                </div>
                <div class="p-3">
                    <div class="h4 fw-bold" style="font-family: 'Nunito', sans-serif;"><?php echo $festitle ?></div>
                    <div class="fw-bold" style="font-family: 'Nunito', sans-serif;"><?php echo $fesdesc ?> </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>