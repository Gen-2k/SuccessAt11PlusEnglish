<?php
if (!isset($_SESSION)) {
    session_start();
    require dirname(__DIR__) . '/database/dbconfig.php';
}
// if (!isset($_SESSION['logged_in']) == true) {
//     header('Location:'.BASE_URL.'Login.php');
// }
 //echo $_SESSION['id']; 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=3, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <!-- jquery date picker cdn -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js">
    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <title>Admin Panel</title>
</head>

<body>
    <header class="admin_header">
        <div class="position-relative py-3 d-flex justify-content-between align-items-center">
            <div class="admin_dash_menu_Btn">
                <button class="btn shadow-none adminMenu_Btn"><img src="assect/logo/menuIcon.png" alt=""
                        width="30px"></button>
            </div>

            <div class="pe-3">
                <img src="log2.png" alt="ptofile" width="200px">
            </div>

            <div class="logout_btn  d-flex justify-content-cente me-2">
                <form action="../logoutPage.php" method="POST">
                    <button type="submit" name="logout_btn"
                        class="btn shadow-none text-decoration-none px-3 py-1 text-center fw-bold"
                        id="logout_btn">Logout</button>
                </form>
                <div class="threDotMenu">
                    <button class="btn shadow-none" id="threDotBtn"><img src="assect/logo/menu-vertical.png"
                            width="18px" alt=""></button>
                </div>
            </div>
        </div>
    </header>

    <script>
    const menuButton = document.querySelector('.adminMenu_Btn');
    const sideBar = document.querySelector('nav');
    menuButton.addEventListener('click', () => {
        if (sideBar.classList.contains('minbar_container')) {
            sideBar.classList.replace('minbar_container', 'navbar_container');
        }
    })

    // logout button
    const dotBtn = document.getElementById('threDotBtn');
    const logoutButton = document.getElementById('threDotBtn');
    dotBtn.addEventListener('click', () => {
        if (logout_btn.style.display == "none") {
            logout_btn.style.display = "block"
        } else {
            logout_btn.style.display = "none"
        }

    })

    const mediaHeader = window.matchMedia('(max-width:423px)');

    function headerMediaQueryCheck(m) {
        if (m.matches) {
            logout_btn.style.display = "none";
            document.addEventListener('click', function(e) {
                if (m.matches && !logout_btn.contains(e.target) && !dotBtn.contains(e.target)) {
                    logout_btn.style.display = "none";
                } else {
                    logout_btn.style.display = "block";
                }
            })
        } else {
            logout_btn.style.display = "block";
        }
    }

    headerMediaQueryCheck(mediaHeader);
    mediaHeader.addEventListener('change', headerMediaQueryCheck);


    // date picker
    $('.datepicker').datepicker('setDate', 'today');
    </script>
    <script src="formValidation.js"></script>
</body>

</html>