<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=3, initial-scale=1.0">
    <!-- all  pages cdn  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <script src="https://kit.fontawesome.com/398c77c1ca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="viewPagestyle.css">
    <!-- end -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/398c77c1ca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Admin Panel</title>
</head>

<body>
    <!-- side bar -->
    <nav class="navbar_container">
        <!-- navbar_container -->
        <div class="innerNavcontainer">
            <div class="profile_pic_con">
                <div class="pro_pic">
                    <img style="max-width: 50px;" src="assect/admindp.jpg" alt="logo" class="profile_photo">
                </div>
            </div>
            <p class="text-center text-white fw-bold mb-0 pt-2">Safrina Saran</p>
            <hr class="bg-white">
            <ul class="navbar-nav">
                <li class="nav-item" id="dashBoard"><a href="admindashboard.php" class="nav-link"><img
                            class="dashboardImg" src="assect/logo/dashboard-n.png" alt="Dashboard">
                        Dashboard</a></li>
                <li class="nav-item dropdown" id="students"><a href="StudentDetails.php"
                        onclick="event.preventDefault()" class="nav-link students"><img class="studentImg"
                            src="assect/logo/student-n.png" alt="Students">Students <img src="assect/logo/down-aaro.png"
                            class="rimg"></a>
                    <ul class="dropdown_menu">
                        <li><a href="StudentDetails.php" class="nav-link">New Students</a></li>
                        <li><a href="existingstudent.php" class="nav-link existingStudent">Existing Students</a></li>
                    </ul>
                </li>
                <!-- <li class="nav-item dropdown" id="culture"><a href="./culturalAdmin.php" class="nav-link"><img
                            class="cultureImg" src="assect/logo/culture-n.png" alt="Teachers">Culture Topic</a>
                </li> -->
                <li class="nav-item dropdown" id="homework"><a href="HomeWork.php" class="nav-link"><img
                            class="homeworkImg" src="assect/logo/homework-n.png" alt="Homework">Homework</a>
                </li>
                <li class="nav-item" id="activity"><a href="activityAdmin.php" class="nav-link"><img class="activityImg"
                            src="assect/logo/activity-n.png" alt="Activity">Activity</a></li>
                <!-- <li class="nav-item dropdown" id="songs"><a href="songsAdmin.php" class="nav-link"><img class="songsImg"
                            src="assect/logo/music-n.png" alt="songs">Songs</a> -->
                </li>
                <li class="nav-item dropdown" id="E-book"><a href="E-Book.php" class="nav-link"><img class="EbookImg"
                            src="assect/logo/e-book-n.png" alt="E-book">E-book</a>
                </li>
            </ul>
        </div>
        <div class="minimize_icon" style="text-align: center;"><img src="assect/logo/left_icon.png" alt="min-max"
                width="40px" class="minimizeIconLeft" id="minimizeIcon">
        </div>
    </nav>


    <script src="adminpanel.js"></script>
    <script>
    const winLocation = window.location.href;
    const navLocation = document.querySelectorAll('.nav-link');

    for (let i = 0; i < navLocation.length; i++) {
        const currentNav = navLocation[i];
        const navLi = document.querySelectorAll('.nav-item');
        const student = document.querySelector('.students');
        const existingStudent = document.querySelector('.existingStudent')
        if (winLocation == currentNav.href) {
            currentNav.style.backgroundColor = 'white';
            currentNav.style.color = "#104078";
        }
        if (winLocation == existingStudent.href) {
            student.style.backgroundColor = 'white';
            student.style.color = "#104078";
        }
    }
    </script>

</body>

</html>