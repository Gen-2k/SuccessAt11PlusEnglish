<?php
if (!isset($_SESSION)) {
    session_start();
    require_once __DIR__ . '/database/dbconfig.php';
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Success At 11 Plus English" />
    <title>Success At 11 Plus English | Forgot Password</title>
    <style>
        .lear_img {
            width: 100%;
            display: flex;
            margin: auto;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        form .input_enter {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            outline: none;
        }

        form .input_enter:focus {
            border: 1px solid #1e40af;
        }


        .header {
            color: #1e40af;

        }

        .txt {
            font-weight: bold;
            color: black;
        }

        /* login */
        .box_shad {
            box-shadow: 3px 3px 20px 10px #e5caf7;
            margin-top: 10%;
            align-items: center;
        }

        /* asasas */
        .height-100 {
            height: 100vh
        }

        .card {
            width: 400px;
            border: none;
            height: 300px;
            box-shadow: 0px 5px 20px 0px #d2dae3;
            z-index: 1;
            display: flex;
            justify-content: center;
            align-items: center
        }



        .inputs input {
            width: 40px;
            height: 40px;
            font-weight: bold;
            color: green;

        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            margin: 0
        }

        .card-2 {
            background-color: #fff;
            padding: 10px;
            width: 350px;
            height: 100px;
            bottom: -50px;
            left: 20px;
            position: absolute;
            border-radius: 5px
        }

        .card-2 .content {
            margin-top: 50px
        }

        .card-2 .content a {
            color: red
        }

        .form-control:focus {
            box-shadow: none;
            border: 2px solid red
        }

        h6 {
            font-weight: bold;
            font-size: 30px;
        }
    </style>
</head>

<body>
    <div class="sticky-sm-top">
        <?php include('navbar2.php') ?>
    </div>
    <?php
    $success = "0";
    $error_message = "";
    if (!empty(isset($_POST["submit_email"]))) {
        $otpEmail = $_POST["email"];
        $_SESSION['sesMail'] = $otpEmail;
        $regMail = "SELECT * FROM students WHERE email='$otpEmail'";
        $result = mysqli_query($connection, $regMail);
        $count  = mysqli_num_rows($result);
        if ($count > 0) {
            $otp = rand(100000, 999999);
            $_SESSION['session_otp'] = $otp;

            $timestamp =  $_SERVER["REQUEST_TIME"];
            $_SESSION['time'] = $timestamp;
            require_once("./forgotOtpMail.php");
            $mail_status = sendOTP($otpEmail, $otp);
                
            if ($mail_status == 1) {
                $insertOtp = "INSERT INTO otp_expiry(email,otp,is_expired) VALUES ('$otpEmail','$otp', 0)";
                $result = mysqli_query($connection, $insertOtp);
                if ($result) {
                    $success = 1;
                } else {
                    $success = 0;
                }
            }
        } else {
            $error_message = "Email not exists!";
        }
    }

    if (!empty($_POST["submit_otp"])) {
        $timestamp =  $_SERVER["REQUEST_TIME"];
        $otp1 = $_POST["otp1"];
        $otp2 = $_POST["otp2"];
        $otp3 = $_POST["otp3"];
        $otp4 = $_POST["otp4"];
        $otp5 = $_POST["otp5"];
        $otp6 = $_POST["otp6"];
        $otp = $otp1 . $otp2 . $otp3 . $otp4 . $otp5 . $otp6;
        if ($_SESSION['session_otp'] == $otp && ($timestamp - $_SESSION['time']) < 300) {
            $updateOtp = "UPDATE otp_expiry SET is_expired = 1 WHERE otp = '$otp'";
            $result = mysqli_query($connection, $updateOtp);
            $success = 2;
        } else {
            $success = 0;
            $error_message = "Invalid OTP!";
        }
        // }
    }
    if (isset($_POST["submit_pass"])) {
        $upPwd = $_POST["pass1"];
        $upMail = $_SESSION['sesMail'];
        $updatePwd = "UPDATE students SET password = '$upPwd' WHERE email = '$upMail'";
        $upPwdQuery = mysqli_query($connection, $updatePwd);

        if ($upPwdQuery) {
            $error_message = "Updated Successfully";
        } else {
            $error_message = "Try Again Sometime...!";
        }
    }
    ?>
    <div class="container">
        <div class="row box_shad d-flex mt-sm-5 mb-sm-5">
            <div class="col-lg" style="background-color: #fff; padding: 10px">
                <img src="./assets/images/forgotani.webp" alt="forgot" class="lear_img" />
            </div>
            <div class="col-lg" style="background-color: #fff; padding: 10px">

                <?php
                if (!empty($error_message)) {
                ?>
                    <div class="message error_message text-danger fs-5 text-center"><?php echo $error_message; ?></div>
                <?php
                }
                ?>
                <div class="p-2">

                    <?php
                    if (!empty($success == 1)) {
                    ?>
                        <form action="" method="POST" class="needs-validation" novalidate>
                            <!-- OTP Enter Start-->
                            <div class="text-center">
                                <h6 style=" font-weight: bold;font-size: 25px;color:#1e40af">
                                    Please enter the One Time Password <br> to verify your account</h6>
                                <div class="text-danger" id="time">00:00</div>
                                <div class="text-success"> <span>The OTP has been sent to your</span> <small style="font-weight: bold;">Registered Mail</small> </div>
                                <div id="otp" class="inputs d-flex mt-2 flex-row justify-content-center mt-2">
                                    <input class="m-2 text-center form-control rounded" type="text" name="otp1" id="first" maxlength="1" required />
                                    <input class="m-2 text-center form-control rounded" type="text" name="otp2" id="second" maxlength="1" required />
                                    <input class="m-2 text-center form-control rounded" type="text" name="otp3" id="third" maxlength="1" required />
                                    <input class="m-2 text-center form-control rounded" type="text" name="otp4" id="fourth" maxlength="1" required />
                                    <input class="m-2 text-center form-control rounded" type="text" name="otp5" id="fifth" maxlength="1" required />
                                    <input class="m-2 text-center form-control rounded" type="text" name="otp6" id="sixth" maxlength="1" required />
                                </div>
                                <div class="mt-4"> <input type="submit" name="submit_otp" value="Validate" class="btn btn-lg btn-danger px-4 ">
                                </div>
                            </div>
                            <!-- OTP Enter End -->
                        </form>
                    <?php
                    } else if ($success == 2) {
                    ?>
                        <form action="" method="POST" class="needs-validation" oninput='pass1.setCustomValidity(pass1.value != pass.value ? "Passwords do not match." : "")' novalidate>
                            <!-- New Password Page Start -->
                            <h1 class="header" style="font-weight: bold;">ENTER NEW PASSWORD</h1>
                            <label for="pass" class="txt"> NEW PASSWORD</label>
                            <input type="password" id="pass" name="pass" class="input_enter form-control shadow-none" placeholder="Enter Your New Password" required />
                            <small class="invalid-feedback">
                                Please Enter your Password
                            </small>
                            <!-- show pwd -->
                            <input class="form-check-input shadow-none" type="checkbox" id="shoPWD" onclick="showPassword()">
                            <small><label class="mb-3 ms-0 form-check-label user-select-none" for="shoPWD">
                                    Show Password
                                </label></small><br>

                            <label for="pass1" class="txt"> CONFIRM NEW PASSWORD</label>
                            <input type="password" id="pass1" name="pass1" class="input_enter form-control shadow-none" placeholder="Enter Your New Password" required />
                            <small class="invalid-feedback">
                                Please Enter your Password correctly
                            </small>
                            <button type="submit" name="submit_pass" class=" btn btn-lg btn-block" style="
                                background-color: #1e40af;
                                color: #fff;
                                width: 100%;
                                margin-top: 25px;
                            ">
                                <span class="d-flex justify-content-center">CHANGE PASSWORD</span>
                            </button>
                            <a href="./Login"><button type="button" class="btn btn-lg btn-block" style="
                                background-color: #000;
                                color: #fff;
                                width: 100%;
                                margin-top: 25px;
                            ">
                                    <span class="d-flex justify-content-center">BACK TO LOGIN</span>
                                </button></a>
                            <!-- New Password Page End -->
                        </form>
                    <?php
                    } else if ($success == 0) {
                    ?>

                        <!-- Enter Email for OTP Start-->
                        <h1 class="header" style="font-weight: bold;">CHANGE PASSWORD</h1>
                        <form action="" method="POST" class="needs-validation" novalidate>
                            <label for="fname" class="txt"> EMAIL</label>
                            <input type="email" id="fname" name="email" class="input_enter form-control shadow-none" placeholder="Enter Your Email" required />
                            <small class="invalid-feedback">
                                Please Enter your email Id correctly
                            </small>
                            <input id="chengePwForm" type="submit" name="submit_email" value="Get OTP" class="btn btn-lg btn-block" style="
                        background-color: #1e40af;
                        color: #fff;
                        width: 100%;
                        margin-top: 25px;
                    ">
                            <a href="./Login"><button type="button" class="btn btn-lg btn-block" style="
                        background-color: #000;
                        color: #fff;
                        width: 100%;
                        margin-top: 25px;
                    ">
                                    <span class="d-flex justify-content-center">BACK TO LOGIN</span>
                                </button></a>
                            <!-- Enter Email for OTP End-->
                        </form>
                    <?php
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php') ?>
    <script src="./formValidation.js"></script>
    <script>
        const suc = "<?php echo $success ?>"
        if (suc == 1) {
            OTPInput();
            var fiveMinutes = 60 * 5,
                display = document.querySelector('#time');
            startTimer(fiveMinutes, display);
        }

        function OTPInput() {
            const editor = document.getElementById('first');
            editor.onpaste = pasteOTP;

            const inputs = document.querySelectorAll('#otp > *[id]');
            for (let i = 0; i < inputs.length; i++) {
                inputs[i].addEventListener('input', function(event) {
                    if (!event.target.value || event.target.value == '') {
                        if (event.target.previousSibling.previousSibling) {
                            event.target.previousSibling.previousSibling.focus();
                        }

                    } else {
                        if (event.target.nextSibling.nextSibling) {
                            event.target.nextSibling.nextSibling.focus();
                        }
                    }
                });
            }
        }

        function pasteOTP(event) {
            event.preventDefault();
            let elm = event.target;
            let pasteVal = event.clipboardData.getData('text').split("");
            if (pasteVal.length > 0) {
                while (elm) {
                    elm.value = pasteVal.shift();
                    elm = elm.nextSibling.nextSibling;
                }
            }
        }

        function showPassword() {
            const Password = document.getElementById('pass');
            if (Password.type === 'password') {
                Password.type = 'text'
            } else {
                Password.type = 'password'
            }
        }

        function startTimer(duration, display) {
            var timer = duration,
                minutes, seconds;
            setInterval(function() {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;
                if (--timer < 0) {
                    document.querySelector('#time').innerHTML = "Your OTP is Expired!!!";
                }
            }, 1000);
        }

        const successVal = <?php echo $success ?>;
       
    </script>
</body>

</html>