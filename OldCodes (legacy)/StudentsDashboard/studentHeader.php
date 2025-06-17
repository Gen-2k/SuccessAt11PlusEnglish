<?php
if (!isset($_SESSION)) {
    session_start();
    require dirname(__DIR__).'/database/dbconfig.php';
}
// if (!isset($_SESSION['logged_in']) == true) {
//     header("Location:Login");
// }
?>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Smile4Kids | Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <script src="https://kit.fontawesome.com/398c77c1ca.js" crossorigin="anonymous"></script>
    <!-- <link rel="icon" type="image/x-icon" href="./assets/images/logonew.png"> -->
    <!-- <link rel="stylesheet" href="https://use.typekit.net/qom5wfr.css" /> -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" /> -->

    <!-- <script src="https://kit.fontawesome.com/398c77c1ca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" /> -->
    <!-- css path -->

    <!-- datapicker -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="studentStyle.css">
    <style>

    </style>
</head>

<body>
    <div class="position-fixed changeProfileContainer">
        <div class="card p-4" id="proInfo">
            <h3 class="h3 text-center text-dark py-3">Edit Info</h3>
            <form id="updateProfile" class="needs-validation" novalidate>
                <div class="row g-3">
                    <div class="col-md">
                        <label for="FirstName" class="form-label h5 fw-bold">First Name</label>
                        <input type="text" name="fname" value="" class="form-control shadow-none FirstName" placeholder="" id="FirstName" pattern="\S(.*\S)? ||[a-zA-Z]+" required>
                        <small class="invalid-feedback">
                            Please enter your firstname.
                        </small>
                    </div>
                    <div class="col-md ">
                        <label for="SurName" class="form-label h5 fw-bold">Surname</label>
                        <input type="text" name="surname" class="form-control shadow-none" id="SurName" placeholder="Enter Surname" pattern="\S(.*\S)? ||[a-zA-Z]+" required>
                        <small class="invalid-feedback">
                            Please enter your surname.
                        </small>
                    </div>
                </div>
                <div class="row mt-3 ">
                    <div class="col">
                        <label for="dateOfBirth" class="form-label h5 fw-bold text-dark" name="Date of Birth">Date of
                            Birth</label>
                        <input type="text" name="dob" class="form-control datepicker shadow-none" id="dateOfBirth" aria-describedby="inputGroupPrepend" required>
                        <small class="invalid-feedback">
                            Please choose valid Date.
                        </small>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <label for="phoneNumber" class="form-label text-dark h5 fw-bold">Phone Number</label>
                        <input type="text" name="phone" class="form-control shadow-none" pattern="^(?:\d{11}|\d{10})$" id="phoneNumber" placeholder="Enter phone Number" required>
                        <small class="invalid-feedback">
                            Please Enter your Phone Number.
                        </small>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <label for="parentAdderss" class="form-label text-dark h5 fw-bold">Address</label>
                        <textarea class="form-control shadow-none" name="parentAdderss" id="parentAdderss" rows="3" placeholder="Enter your parent Address" required></textarea>
                        <small class="invalid-feedback">
                            Please Enter your parent Address.
                        </small>
                    </div>
                </div>
                <div class="mt-4 d-flex justify-content-between">
                    <button class="btn btn-danger shadow-none closeBtn" type="button">Close</button>
                    <button class="btn btn-success shadow-none" type="submit" name="submit">Save changes</button>
                </div>
            </form>
        </div>

        <div class="card p-4" id="passwordContainer">
            <h3 class="h3 text-center text-dark py-2">Change Password</h3>
            <form id="passwordChange" class="needs-validation" oninput='conPwd.setCustomValidity(conPwd.value != newPwd.value ? "Passwords do not match." : "") ' novalidate autocomplete="off">

                <!-- <span class="text-center pt-3 text-secondary">(or)</span> -->
                <div class="row mb-3">
                    <div class="col">
                        <label for="Email" class="form-label h5 fw-bold text-dark">Email Address</label>
                        <input autocomplete="FALSE" type="email" name="email" class="form-control shadow-none" id="email" placeholder="Enter Email" required>
                        <small class="invalid-feedback">
                            Please Enter your Email.
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="oldPwd" class="form-label h5 fw-bold text-dark">Old Password</label>
                        <input type="password" name="oldPwd" class="form-control shadow-none" id="oldPwd" placeholder="Enter old password" required>
                        <small class="invalid-feedback">
                            Please Enter corect password.
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="newPwd" class="form-label h5 fw-bold text-dark">New Password</label>
                        <input type="password" name="newPwd" class="form-control shadow-none" id="newPwd" minlength="6" placeholder="Enter new password" required>
                        <small class="invalid-feedback">
                            Please Enter your new password (Minimum 6 characters).
                        </small>
                        <!-- show pwd -->
                        <input class="form-check-input shadow-none" type="checkbox" id="shoPWD" onclick="showPassword()">
                        <small><label class="form-check-label user-select-none text-black" for="shoPWD">
                                Show Password
                            </label></small>

                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="conpwd" class="form-label h5 fw-bold text-dark">Conform Password</label>
                        <input type="password" name="conPwd" class="form-control shadow-none" id="conpwd" placeholder="Enter conform password" required>
                        <small class="invalid-feedback">
                            Please Enter correct password.
                        </small>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <button class="btn btn-danger shadow-none closeBtn" type="button">Close</button>
                    <button class="btn btn-success shadow-none" type="submit" id="checkout" name="submit">Update password</button>
                </div>
            </form>
        </div>
    </div>
    <!-- header -->
    <header class="stu_act_head d-flex justify-content-between align-items-center px-3">
        <div class="py-3 logo_sec">
            <img src="<?php echo BASE_URL ?>assets/images/log2.png" alt="logo">
        </div>
        <div class="d-flex align-items-center justify-content-center prifile_info">
            <div class="name_sec">
                <p class="text-center text-white m-0" style="font-size:17px; ">
                    <?php print_r($_SESSION['name']); ?>
                </p>
            </div>
            <!-- change boy or girl -->
            <div class="d-flex justify-content-center ps-2 userProPic">
                <?php
                $_gender = $_SESSION['gender'];
                if ($_gender == "male") { ?>
                    <img src="stu_assets/images/profile_pic_stu_b.png" alt="profile pic" width="30px">
                <?php } else { ?>
                    <img src="stu_assets/images/profile_pic_stu_g.png" alt="profile pic" width="30px">
                <?php } ?>
            </div>
            <div class="proInfo justify-content-center">
                <div class="proInfoCon">

                    <div class="d-flex justify-content-center ps-2 userProPic">
                        <?php
                        $_gender = $_SESSION['gender'];
                        if ($_gender == "male") { ?>
                            <img src="stu_assets/images/profile_pic_stu_b.png" alt="profile pic" width="50px">
                        <?php } else { ?>
                            <img src="stu_assets/images/profile_pic_stu_g.png" alt="profile pic" width="50px">
                        <?php } ?>
                    </div>
                    <div class="name_sec">
                        <p class="text-center text-white m-0 text-break" style="font-size:17px; ">
                            <?php print_r($_SESSION['name']); ?>
                        </p>
                    </div>
                    <!-- <hr class="bg-white mt-2 mb-0"> -->
                    <div class="text-center"><small class="text-white" style="font-size:12px ;"><?php print_r($_SESSION['emailId']); ?></small></div>
                    <hr class="m-2">
                    <div class="text-center">
                        <button class="btn shadow-none p-0 edit_profile" value="<?php echo $_SESSION['id']; ?>">Edit profile</button>
                        <button class="btn shadow-none p-0 change_Pwd" value="<?php echo $_SESSION['id']; ?>">Change password</button>
                    </div>
                    <div class="header_nav_bar text-center py-3">
                        <div class="nav_item">
                            <a href="<?php echo BASE_URL ?>logoutPage" class="btn shadow-none" data-toggle="tooltip" onclick="preventBack()" data-placement="bottom" title="Logout">Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div>
                <a href="student-Home.php"><img src="../home-n.png" alt="back" width="30px" class="mx-2"></a>
            </div> -->
        </div>
    </header>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <script>
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
        });

        // form validation 
        (function() {
            'use strict'

            var forms = document.querySelectorAll('.needs-validation')

            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
        const userProPic = document.querySelector('.userProPic');
        const userProPicInfo = document.querySelector('.proInfo');
        userProPic.addEventListener('click', () => {
            if (userProPicInfo.style.display == "none") {
                userProPicInfo.style.display = "flex"
            } else {
                userProPicInfo.style.display = "none"
            }
        })

        const editBtn = document.querySelector('.edit_profile')
        const pwdBtn = document.querySelector('.change_Pwd')
        const popupContainer = document.querySelector('.changeProfileContainer');
        const editeInfo = document.getElementById('proInfo');
        const changePassword = document.getElementById('passwordContainer');
        const closeBtn = document.querySelectorAll('.closeBtn');

        editBtn.addEventListener('click', () => {
            userProPicInfo.style.display = "none";
            popupContainer.style.display = "flex";
            changePassword.style.display = "none";
            editeInfo.style.display = "block";
        })

        pwdBtn.addEventListener('click', () => {
            userProPicInfo.style.display = "none";
            popupContainer.style.display = "flex";
            editeInfo.style.display = "none";
            changePassword.style.display = "block";
        })


        for (let i = 0; i < closeBtn.length; i++) {
            closeBtn[i].addEventListener('click', () => {
                popupContainer.style.display = "none";
            })

        }

        document.addEventListener('click', function(e) {
            if (!userProPic.contains(e.target) && !userProPicInfo.contains(e.target)) {
                userProPicInfo.style.display = "none"
            }
            if (!userProPic.contains(e.target) && !userProPicInfo.contains(e.target) && !editeInfo.contains(e.target) && !changePassword.contains(e.target)) {
                popupContainer.style.display = "none";
            }
        })
        // show password 
        function showPassword() {
            const Password = document.getElementById('newPwd');
            if (Password.type === 'password') {
                Password.type = 'text'
            } else {
                Password.type = 'password'
            }
        }

        $(document).on('click', '.edit_profile', function() {

            var data_id = $(this).val();
            // alert(data_id)
            $.ajax({
                type: "GET",
                url: "studentactCode.php?data_id=" + data_id,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 404) {

                        alert(res.message);
                    } else if (res.status == 200) {
                        // alert(res.message)
                        $('#FirstName').val(res.data.fname);
                        $('#SurName').val(res.data.surname);
                        // $('#dateOfBirth').val(res.data.dob);
                        var dateArr = res.data.dob.split('-');
                        $('#dateOfBirth').val(dateArr[2] + '-' + dateArr[1] + '-' + dateArr[0]);
                        $('#phoneNumber').val(res.data.phone);
                        $('#parentAdderss').val(res.data.address);
                        // $('#view_course').text(res.data.course);
                        // console.log(response);
                        // var url = "hwUploads/" + res.data.Files;
                        // $('.viewPdfBtn').attr('href', url);
                        // $('#dataViewModal').modal('show');
                    }
                }
            });
        });

        $(document).on('submit', '#updateProfile', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("update_profile", true);

            $.ajax({
                type: "POST",
                url: "studentactCode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // $('#proInfo').modal('hide');

                    // alert('Hello');
                    var res = jQuery.parseJSON(response);
                    console.log(response);
                    // if (res.status == 422) {
                    //     $('#errorMessageUpdate').removeClass('d-none');
                    //     $('#errorMessageUpdate').text(res.message);
                    //     // } else if (res.status == 200) {
                    // } else 
                    if (res.status == 500) {
                        alert(res.message);
                    } else if (res.status == 200) {
                        userProPicInfo.style.display = "none";
                        popupContainer.style.display = "none";
                        alert(res.message);
                        // $('#updateProfile')[0].reset();
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.alert.success(res.message);

                    }
                    // $('#errorMessageUpdate').addClass('d-none');


                    // $('#dataEditModal').modal('hide');
                    // $('#updateData')[0].reset();

                    // $('#myTable').load(location.href + " #myTable");

                }
            });

        });

        $(document).on('click', '.change_Pwd', function() {
            var data_id = $(this).val();
            // alert(data_id)
            $.ajax({
                type: "GET",
                url: "studentactCode.php?data_id=" + data_id,
                success: function(response) {

                    $(document).on('submit', '#passwordChange', function(e) {
                        e.preventDefault();

                        var formData = new FormData(this);
                        formData.append("password_change", true);

                        $.ajax({
                            type: "POST",
                            url: "studentactCode.php",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                // alert('Hello');
                                // console.log(response);
                                var res = jQuery.parseJSON(response);
                                if (res.status == 200) {
                                    changePassword.style.display = "none";
                                    popupContainer.style.display = "none";
                                    alert(res.message);
                                    alertify.alert.success(res.message);
                                } else if (res.status == 500) {

                                    alert(res.message);
                                    alertify.alert.error(res.message);
                                }
                            }
                        });
                    });
                }
            });
        });
    </script>
</body>

</html>