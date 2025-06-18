<?php
    include('database/dbconfig.php');
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="./assets/images/logonew.png">
        <!-- boostrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <!-- font awasom -->        <script src="https://kit.fontawesome.com/398c77c1ca.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="style/navbar2.css">
        <link rel="stylesheet" href="style/navbar2-additional.css">
        <title>Success At 11 Plus English</title>
    </head>

    <body>
        <nav class="nav_col navbar navbar-expand-lg">
            <div class="container-fluid">                <!-- logo -->
                <a href="./index" class="navbar-brand p-1"> <img src="./assets/logo/success-logo.png" alt="Success At 11 Plus English logo" class="img-fluid"></a>
                

                <!-- nav list -->
                <button class="navbar-toggler nav_button shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navItem" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="nav_icon"><i class="fa-solid fa-bars"></i></span>
                </button>                <div class="collapse navbar-collapse nav_collapse" id="navItem" style="right:0;flex-grow: 0;">
                    <div class="nav-container ms-auto">
                        <ul class="navbar-nav nav_list col">
                            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item position-relative show_drop dropdown"><a class="nav-link dropdown-toggle" id="classDropdownlist" role="button" aria-expanded="false">Classes</a>
                            <ul class="dropdown_list" aria-labelledby="classDropdownlist">
                                <li><a class="dropdown-item" href="courses_year4?lan=<?php echo "Year 4" ?>">Year 4</a></li>
                                <li><a class="dropdown-item" href="courses_year5?lan=<?php echo "Year 5" ?>">Year 5</a></li>
                                <li><a class="dropdown-item" href="courses_year6?lan=<?php echo "Year 6" ?>">Year 6</a></li>
                            </ul>
                        </li>
                        <li class="nav-item position-relative show_drop dropdown"><a class="nav-link  dropdown-toggle" id="classDropdownlist" role="button" aria-expanded="false">Policies</a>
                            <ul class="dropdown_list" aria-labelledby="classDropdownlist">
                                <li><a class="dropdown-item" href="Remoteteaching">Remote Teaching and Online Safety Policy</a></li>
                                <li><a class="dropdown-item" href="Privacy-policy">Privacy Policy</a></li>
                                <li><a class="dropdown-item" href="TermsAndCondition">Terms and Conditions</a></li>
                                <li><a class="dropdown-item" href="Safeguarding">Safeguarding Children Policy</a></li>
                            </ul>
                        </li>
                        

                        
                            <li class="nav-item"><a class="nav-link" href="About">About</a></li>
                                  <li><a href="Login"><button class="button">Sign In</button></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

    </body>

    </html>