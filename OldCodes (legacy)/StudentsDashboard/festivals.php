<?php
if (!isset($_SESSION)) {
    session_start();
    require dirname(__DIR__) . '/database/dbconfig.php';
}

if (!isset($_SESSION['logged_in']) == true) {
header("Location:../Login.php");
}
$userid =  $_SESSION['id'];
$_query = "SELECT * FROM terms_details WHERE student_id = $userid ";

$query_run1 = mysqli_query($connection, $_query);
$row1 = mysqli_fetch_all($query_run1, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Smile4Kids | Student Activity</title>
    <!-- <link rel="icon" type="image/x-icon" href="./assets/images/logonew.png"> -->
    <!-- <link rel="stylesheet" href="https://use.typekit.net/qom5wfr.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />

    <script src="https://kit.fontawesome.com/398c77c1ca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" /> -->
    <!-- css path -->
    <link rel="stylesheet" href="studentStyle.css">
</head>

<body>
    <?php include('studentHeader.php') ?>
    <!--  -->
    <div id="backHomePage">
        <a href="adminstu" class="text-decoration-none">
            <div class="backHomePageChild">
                <img src="stu_assets/home-n.png" alt="back" width="30px" class="mx-2"><span class="fw-bold ps-2">Back to
                    Home</span>
            </div>
        </a>
    </div>
    <div class="container pt-3">
        <h1 class="fw-bold text-center text-white">FESTIVALS</h1>


        <div class="d-flex flex-wrap justify-content-center card_main_Container">
            <div class="sudent_card shadow-lg p-3 mb-3  rounded mar"
                style="background: linear-gradient(to bottom, yellow 0%, green 100%);">
                <p class="terms">TERM 1</p>
                <?php
                foreach ($row1 as $termname) {
                    $selectTerm = $termname['termname'];
                    if ($selectTerm == 'Term 1') {
                ?>
                <a href="itemsfestival?festerm=<?php echo 'Term 1' ?>" class="text-decoration-none">
                    <?php
                    }
                }
                    ?>
                    <div class="img-hover-zoom img-hover-zoom--colorize text-center">
                        <img class="shadow" src="stu_assets/terms.jpeg" alt="homeworks image">
                    </div>
                </a>
            </div>
            <div class="sudent_card shadow-lg p-3 mb-3  rounded mar"
                style="background: linear-gradient(to bottom, yellow 0%, red 100%) ;">
                <p class="terms">TERM 2</p>
                <?php
                foreach ($row1 as $termname) {
                    $selectTerm = $termname['termname'];
                    if ($selectTerm == 'Term 2') {
                ?>
                <a href="itemsfestival?festerm=<?php echo 'Term 2' ?>" class="text-decoration-none">
                    <?php
                    }
                }
                    ?>
                    <div class="img-hover-zoom img-hover-zoom--colorize text-center">
                        <img class="shadow" src="stu_assets/terms.jpeg" alt="homeworks image">
                    </div>
                </a>
            </div>
            <div class="sudent_card shadow-lg p-3 mb-3  rounded mar"
                style="background: linear-gradient(to bottom, orange 0%, red 100%);">
                <p class="terms">TERM 3</p>
                <?php
                foreach ($row1 as $termname) {
                    $selectTerm = $termname['termname'];
                    if ($selectTerm == 'Term 3') {
                ?>
                <a href="itemsfestival?festerm=<?php echo 'Term 3' ?>" class="text-decoration-none">
                    <?php
                    }
                }
                    ?>
                    <div class="img-hover-zoom img-hover-zoom--colorize text-center">
                        <img class="shadow" src="stu_assets/terms.jpeg" alt="homeworks image">
                    </div>
                </a>
            </div>
            <div class="sudent_card shadow-lg p-3 mb-3  rounded mar"
                style="background: linear-gradient(to bottom, orange 0%, black 100%);">
                <p class="terms">TERM 4</p>
                <?php
                foreach ($row1 as $termname) {
                    $selectTerm = $termname['termname'];
                    if ($selectTerm == 'Term 4') {
                ?>
                <a href="itemsfestival?festerm=<?php echo 'Term 4' ?>" class="text-decoration-none">
                    <?php
                    }
                }
                    ?>
                    <div class="img-hover-zoom img-hover-zoom--colorize text-center">
                        <img class="shadow" src="stu_assets/terms.jpeg" alt="homeworks image">
                    </div>
                </a>
            </div>
            <!-- </div> -->

            <!-- <div class="row gap-3 g-2"> -->
            <div class="sudent_card shadow-lg p-3 mb-3  rounded mar"
                style="background: linear-gradient(to bottom, yellow 0%,red 100%);">
                <p class="terms">TERM 5</p>
                <?php
                foreach ($row1 as $termname) {
                    $selectTerm = $termname['termname'];
                    if ($selectTerm == 'Term 5') {
                ?>
                <a href="itemsfestival?festerm=<?php echo 'Term 5' ?>" class="text-decoration-none">
                    <?php
                    }
                }
                    ?>
                    <div class="img-hover-zoom img-hover-zoom--colorize text-center">
                        <img class="shadow" src="stu_assets/terms.jpeg" alt="homeworks image">
                    </div>
                </a>
            </div>
            <div class="sudent_card shadow-lg p-3 mb-3  rounded mar"
                style="background: linear-gradient(to bottom, orange 0%,red 100%); ;">
                <p class="terms">TERM 6</p>
                <?php
                foreach ($row1 as $termname) {
                    $selectTerm = $termname['termname'];
                    if ($selectTerm == 'Term 6') {
                ?>
                <a href="itemsfestival?festerm=<?php echo 'Term 6' ?>" class="text-decoration-none">
                    <?php
                    }
                }
                    ?>
                    <div class="img-hover-zoom img-hover-zoom--colorize text-center">
                        <img class="shadow" src="stu_assets/terms.jpeg" alt="homeworks image">
                    </div>
                </a>
            </div>
            <div class="sudent_card shadow-lg p-3 mb-3  rounded mar"
                style="background: linear-gradient(to bottom, yellow 0%, green 100%);">
                <p class="terms">TERM 7</p>
                <?php
                foreach ($row1 as $termname) {
                    $selectTerm = $termname['termname'];
                    if ($selectTerm == 'Term 7') {
                ?>
                <a href="itemsfestival?festerm=<?php echo 'Term 7' ?>" class="text-decoration-none">
                    <?php
                    }
                }
                    ?>
                    <div class="img-hover-zoom img-hover-zoom--colorize text-center">
                        <img class="shadow" src="stu_assets/terms.jpeg" alt="homeworks image">
                    </div>
                </a>
            </div>
            <div class="sudent_card shadow-lg p-3 mb-3  rounded mar"
                style="background: linear-gradient(to bottom, orange 0%, black 100%);">
                <p class="terms">TERM 8</p>
                <?php
                foreach ($row1 as $termname) {
                    $selectTerm = $termname['termname'];
                    if ($selectTerm == 'Term 8') {
                ?>
                <a href="itemsfestival?festerm=<?php echo 'Term 8' ?>" class="text-decoration-none">
                    <?php
                    }
                }
                    ?>
                    <div class="img-hover-zoom img-hover-zoom--colorize text-center">
                        <img class="shadow" src="stu_assets/terms.jpeg" alt="homeworks image">
                    </div>
                </a>
            </div>
            <!-- </div> -->

            <!-- <div class="row gap-3 g-2"> -->
            <div class="sudent_card shadow-lg p-3 mb-3  rounded mar"
                style="background: linear-gradient(to bottom, orange 0%,red 100%); ;">
                <p class="terms">TERM 9</p>
                <?php
                foreach ($row1 as $termname) {
                    $selectTerm = $termname['termname'];
                    if ($selectTerm == 'Term 9') {
                ?>
                <a href="itemsfestival?festerm=<?php echo 'Term 9' ?>" class="text-decoration-none">
                    <?php
                    }
                }
                    ?>
                    <div class="img-hover-zoom img-hover-zoom--colorize text-center">
                        <img class="shadow" src="stu_assets/terms.jpeg" alt="homeworks image">
                    </div>
                </a>
            </div>
            <div class="sudent_card shadow-lg p-3 mb-3  rounded mar"
                style="background: linear-gradient(to bottom, yellow 0%, green 100%);">
                <p class="terms">TERM 10</p>
                <?php
                foreach ($row1 as $termname) {
                    $selectTerm = $termname['termname'];
                    if ($selectTerm == 'Term 10') {
                ?>
                <a href="itemsfestival?festerm=<?php echo 'Term 10' ?>" class="text-decoration-none">
                    <?php
                    }
                }
                    ?>
                    <div class="img-hover-zoom img-hover-zoom--colorize text-center">
                        <img class="shadow" src="stu_assets/terms.jpeg" alt="homeworks image">
                    </div>
                </a>
            </div>
            <div class="sudent_card shadow-lg p-3 mb-3  rounded mar"
                style="background: linear-gradient(to bottom, yellow 0%, green 100%);">
                <p class="terms">TERM 11 </p>
                <?php
                foreach ($row1 as $termname) {
                    $selectTerm = $termname['termname'];
                    if ($selectTerm == 'Term 11') {
                ?>
                <a href="itemsfestival?festerm=<?php echo 'Term 11' ?>" class="text-decoration-none">
                    <?php
                    }
                }
                    ?>
                    <div class="img-hover-zoom img-hover-zoom--colorize text-center">
                        <img class="shadow" src="stu_assets/terms.jpeg" alt="homeworks image">
                    </div>
                </a>
            </div>
            <div class="sudent_card shadow-lg p-3 mb-3  rounded mar"
                style="background: linear-gradient(to bottom, yellow 0%, green 100%);">
                <p class="terms">TERM 12</p>
                <?php
                foreach ($row1 as $termname) {
                    $selectTerm = $termname['termname'];
                    if ($selectTerm == 'Term 12') {
                ?>
                <a href="itemsfestival?festerm=<?php echo 'Term 12' ?>" class="text-decoration-none">
                    <?php
                    }
                }
                    ?>
                    <div class="img-hover-zoom img-hover-zoom--colorize text-center">
                        <img class="shadow" src="stu_assets/terms.jpeg" alt="homeworks image">
                    </div>
                </a>
            </div>
            <div class="sudent_card shadow-lg p-3 mb-3  rounded mar"
                style="background: linear-gradient(to bottom, yellow 0%, green 100%);">
                <p class="terms">TERM 13</p>
                <?php
                foreach ($row1 as $termname) {
                    $selectTerm = $termname['termname'];
                    if ($selectTerm == 'Term 13') {
                ?>
                <a href="itemsfestival?festerm=<?php echo 'Term 13' ?>" class="text-decoration-none">
                    <?php
                    }
                }
                    ?>
                    <div class="img-hover-zoom img-hover-zoom--colorize text-center">
                        <img class="shadow" src="stu_assets/terms.jpeg" alt="homeworks image">
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- </div> -->

</body>
<script>
function check_session_id() {
    var session_id = "<?php echo $_SESSION['user_session_id']; ?>";

    // var page = "logoutPage.php";
    //console.log(url);

    fetch('check_login.php').then(function(response) {

        return response.json();

    }).then(function(responseData) {

        if (responseData.output == 'logout') {
            window.location.href = '../logoutPage.php';
        }

    });
}

setInterval(function() {

    check_session_id();

}, 10000);

var login_ok = "<?php echo $_SESSION['user_session_id']; ?>";
//console.log(login_ok);
</script>

</html>
<style>
#backHomePage {
    position: fixed;
    background-color: #A43931;
    width: 50px;
    left: 0;
    top: 100px;
    overflow: hidden;
    transition: 0.5s;
    border-top-right-radius: 25px;
    border-bottom-right-radius: 25px;
}

#backHomePage:hover {
    width: 200px;

}

#backHomePage .backHomePageChild {
    height: 50px;
    width: 200px;
    display: flex;
    align-items: center;
    color: white;
}
</style>