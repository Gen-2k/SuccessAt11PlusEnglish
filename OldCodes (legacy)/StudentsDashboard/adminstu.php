<?php
if (!isset($_SESSION)) {
    session_start();
    require dirname(__DIR__) . '/database/dbconfig.php';
}

if (!isset($_SESSION['logged_in']) == true) {
     header("Location:../Login.php");
}
$userid =  $_SESSION['id'];
$fullCat = $_SESSION['category'];
//print_r($_SESSION);
$_query = "SELECT * FROM students WHERE id = '". $userid ."' ";
//print_r($fullCat);
$query_run1 = mysqli_query($connection, $_query);
$row1 = mysqli_fetch_all($query_run1, MYSQLI_ASSOC); 

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="smile4kids" />
    <title>Smile4Kids | Student</title>

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <script src="https://kit.fontawesome.com/398c77c1ca.js" crossorigin="anonymous"></script> -->

    <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=oswald&family=georgia%family=serif">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

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
    <style>
    .img-hover-zoom--colorize img {
        border-radius: 50%;
        width: 150px;
        height: auto;
        margin-top: 20px;
        padding: 1px;
        transition: transform .5s;
    }

    .img-hover-zoom--colorize:hover img {
        filter: grayscale(0);
        transform: scale(1.05);
    }

    #toast-container>.toast-success {
        background-color: #26b280;
        color: #000;
    }
    </style>

</head>

<body>
    <?php include('studentHeader.php') ?>
    <?php
    if (isset($_SESSION['status'])) {
        //$msg = $_SESSION['status'];
        //print_r($msg);
        //echo "<script type='text/javascript'>toastr.success(hello)</script>";
        //session_start();
        echo "<script type='text/javascript'>toastr.success('" . $_SESSION['status'] . "')</script>";
        unset($_SESSION['status']);
    }
    ?>
    <div class="container p-5 my-5">
        <h3 class="h3 text-center text-white pb-3"><?php echo $fullCat; ?></h3>
        <div class="d-flex flex-wrap justify-content-center card_main_Container">
            <a href="student-Home" class="text-decoration-none">
                <div class="shadow sudent_card" style="background: linear-gradient(to bottom, green 0%, red 100%);">
                    <div class="text-center">

                        <div class="img-hover-zoom--colorize">
                            <img class="shadow" src="<?php echo BASE_URL ?>assets/images/adminstuhw.jpg"
                                alt="homeworks image">
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="clearfix mb-3">
                        </div>

                        <div class="my-2 text-center col fw-bold">
                            <h1 class="fw-bold">HOMEWORK</h1>
                        </div>

                    </div>
                </div>
            </a>
            <a href="songs" class="text-decoration-none ">
                <div class="shadow sudent_card" style="background: linear-gradient(to bottom, blue 0%, red 100%);">
                    <div class="text-center">
                        <div class="img-hover-zoom--colorize">
                            <img class="shadow" src="<?php echo BASE_URL ?>assets/images/adminstuson.png"
                                alt="songs image">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="clearfix mb-3">
                        </div>

                        <div class="my-2 text-center col fw-bold">
                            <h1 class="fw-bold">SONGS</h1>
                        </div>

                    </div>
                </div>
            </a>
            <a href="activities" class="text-decoration-none ">
                <div class="shadow sudent_card" style="background: linear-gradient(to bottom, black 0%, red 100%);">
                    <div class="text-center">
                        <div class="img-hover-zoom--colorize">
                            <img class="shadow" src="<?php echo BASE_URL ?>assets/images/adminstuact.jpg"
                                alt="activities image">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="clearfix mb-3">
                        </div>

                        <div class="my-2 text-center col fw-bold">
                            <h1 class="fw-bold">ACTIVITIES</h1>
                        </div>

                    </div>
                </div>
            </a>
            <a href="festivals" class="text-decoration-none ">
                <div class="shadow sudent_card" style="background: linear-gradient(to bottom, yellow 0%,red 100%);">
                    <div class="text-center">

                        <div class="img-hover-zoom--colorize">
                            <img class="shadow" src="<?php echo BASE_URL ?>assets/images/adminstufest.jpg"
                                alt="Festival">
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="clearfix mb-3">
                        </div>

                        <div class="my-2 text-center col fw-bold">
                            <h1 class="fw-bold">FESTIVALS</h1>
                        </div>
                    </div>
                </div>
            </a>
            <?php
            foreach ($row1 as $termname) {
                 $selectTerm = $termname['Stu_Cat'];
                 
                if ($selectTerm == 'Junior' || $selectTerm == 'PrePrep') { 
                   
                ?>
            <a href="itemebook?eBok=<?php echo 'EBook' ?>" class="text-decoration-none ">
                <div class="shadow sudent_card" style="background: linear-gradient(to bottom, yellow 0%,red 100%);">
                    <div class="text-center">

                        <div class="img-hover-zoom--colorize">
                            <img class="shadow" src="stu_assets/E-book.jpg" alt="Festival">
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="clearfix mb-3">
                        </div>

                        <div class="my-2 text-center col fw-bold">
                            <h1 class="fw-bold">E-BOOK</h1>
                        </div>
                    </div>
                </div>
            </a>
            <?php
                }
            }
            ?>
        </div>
    </div>
    </div>
</body>

</html>

<script>
function check_session_id() {
    var session_id = "<?php echo $_SESSION['user_session_id']; ?>";
    //alert(session_id);
    // var page = "logoutPage.php";
    //console.log(session_id);

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