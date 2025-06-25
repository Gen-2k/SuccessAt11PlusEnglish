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
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+Pro:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --theme-blue: #1e40af;
            --theme-blue-dark: #1e3a8a;
            --theme-gold: #f59e0b;
            --theme-gold-dark: #d97706;
            --body-bg: #f8f9fa;
            --card-bg: #ffffff;
        }
        
        body {
            background: linear-gradient(135deg, #f0f8ff 0%, #e6f3ff 100%);
            font-family: 'Varela Round', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Source Serif Pro', serif;
        }
        
        .forgot-container {
            flex: 1;
            display: flex;
            align-items: center;
            padding: 2rem 0;
        }
        
        .forgot-card {
            background: var(--card-bg);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(30, 64, 175, 0.15);
            border: 1px solid rgba(30, 64, 175, 0.1);
            max-width: 900px;
            margin: 2rem auto;
        }
        
        .forgot-image {
            background: linear-gradient(135deg, var(--theme-blue) 0%, var(--theme-blue-dark) 100%);
            padding: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 500px;
        }
        
        .forgot-image img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.2);
        }
        
        .forgot-form {
            padding: 3rem;
        }
        
        .forgot-header {
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .forgot-header h1 {
            color: var(--theme-blue);
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .forgot-header p {
            color: #6c757d;
            font-size: 1rem;
            margin-bottom: 0;
        }
        
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }
        
        .form-label i {
            margin-right: 0.5rem;
            color: var(--theme-blue);
            width: 18px;
        }
        
        .form-control {
            padding: 0.875rem 1rem;
            font-size: 1rem;
            border-radius: 12px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
            margin-bottom: 1rem;
        }
        
        .form-control:focus {
            border-color: var(--theme-blue);
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
            background-color: #fff;
        }
        
        .otp-container {
            text-align: center;
            margin: 2rem 0;
        }
        
        .otp-header h2 {
            color: var(--theme-blue);
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .otp-inputs {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin: 1.5rem 0;
        }
        
        .otp-input {
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 1.2rem;
            font-weight: bold;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            background-color: #f8f9fa;
        }
        
        .otp-input:focus {
            border-color: var(--theme-blue);
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
            background-color: #fff;
        }
        
        .timer {
            color: #dc3545;
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }
        
        .otp-info {
            color: #198754;
            margin-bottom: 1.5rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--theme-blue), var(--theme-blue-dark));
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            padding: 0.875rem 2rem;
            border-radius: 12px;
            border: none;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 1rem;
            box-shadow: 0 4px 15px rgba(30, 64, 175, 0.3);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--theme-blue-dark), var(--theme-blue));
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 64, 175, 0.4);
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            padding: 0.875rem 2rem;
            border-radius: 12px;
            border: none;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 1rem;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
            color: white;
        }
        
        .alert {
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }
        
        .password-toggle {
            position: relative;
        }
        
        .password-toggle-btn {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            padding: 0;
            z-index: 10;
        }
        
        .password-toggle-btn:hover {
            color: var(--theme-blue);
        }
        
        @media (max-width: 768px) {
            .forgot-card {
                margin: 1rem;
                border-radius: 15px;
            }
            
            .forgot-form {
                padding: 2rem 1.5rem;
            }
            
            .forgot-image {
                min-height: 300px;
                padding: 1.5rem;
            }
            
            .forgot-header h1 {
                font-size: 1.5rem;
            }
            
            .otp-inputs {
                gap: 0.25rem;
            }
            
            .otp-input {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
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
                $insertOtp = "INSERT INTO otp(email, otp_code, is_expired) VALUES ('$otpEmail', '$otp', 0)";
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
            $updateOtp = "UPDATE otp SET is_expired = 1 WHERE otp_code = '$otp'";
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
    <div class="forgot-container">
        <div class="container">
            <div class="forgot-card">
                <div class="row g-0">
                    <div class="col-lg-6">
                        <div class="forgot-image">
                            <div class="text-center">
                                <i class="bi bi-shield-lock" style="font-size: 8rem; color: white; opacity: 0.8;"></i>
                                <h3 style="color: white; margin-top: 1rem;">Secure Password Reset</h3>
                                <p style="color: rgba(255,255,255,0.8); margin-top: 0.5rem;">We'll help you get back into your account safely</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="forgot-form">
                            <?php if (!empty($error_message)) { ?>
                                <div class="alert alert-<?php echo ($error_message == 'Updated Successfully') ? 'success' : 'danger'; ?>">
                                    <i class="bi bi-<?php echo ($error_message == 'Updated Successfully') ? 'check-circle' : 'exclamation-triangle'; ?>-fill me-2"></i>
                                    <?php echo $error_message; ?>
                                </div>
                            <?php } ?>

                            <?php if ($success == 1) { ?>
                                <!-- OTP Verification Step -->
                                <div class="otp-container">
                                    <div class="otp-header">
                                        <h2><i class="bi bi-envelope-check me-2"></i>Verify Your Email</h2>
                                        <p>We've sent a 6-digit code to your registered email address</p>
                                    </div>
                                    
                                    <div class="timer" id="time">05:00</div>
                                    <div class="otp-info">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Check your <strong>inbox</strong> and <strong>spam folder</strong>
                                    </div>
                                    
                                    <form action="" method="POST" class="needs-validation" novalidate>
                                        <div class="otp-inputs" id="otp">
                                            <input class="otp-input form-control" type="text" name="otp1" id="first" maxlength="1" required />
                                            <input class="otp-input form-control" type="text" name="otp2" id="second" maxlength="1" required />
                                            <input class="otp-input form-control" type="text" name="otp3" id="third" maxlength="1" required />
                                            <input class="otp-input form-control" type="text" name="otp4" id="fourth" maxlength="1" required />
                                            <input class="otp-input form-control" type="text" name="otp5" id="fifth" maxlength="1" required />
                                            <input class="otp-input form-control" type="text" name="otp6" id="sixth" maxlength="1" required />
                                        </div>
                                        
                                        <button type="submit" name="submit_otp" class="btn-primary">
                                            <i class="bi bi-check-circle me-2"></i>Verify Code
                                        </button>
                                    </form>
                                </div>
                                
                            <?php } else if ($success == 2) { ?>
                                <!-- New Password Step -->
                                <div class="forgot-header">
                                    <h1><i class="bi bi-key me-2"></i>Create New Password</h1>
                                    <p>Choose a strong password for your account</p>
                                </div>
                                
                                <form action="" method="POST" class="needs-validation" oninput='confirmPass.setCustomValidity(confirmPass.value != newPass.value ? "Passwords do not match." : "")' novalidate>
                                    <div class="mb-3">
                                        <label for="newPass" class="form-label">
                                            <i class="bi bi-lock-fill"></i>New Password
                                        </label>
                                        <div class="password-toggle">
                                            <input type="password" id="newPass" name="pass" class="form-control" placeholder="Enter your new password" required />
                                            <button type="button" class="password-toggle-btn" onclick="togglePassword('newPass', this)">
                                                <i class="bi bi-eye-slash"></i>
                                            </button>
                                        </div>
                                        <div class="invalid-feedback">Please enter a password</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="confirmPass" class="form-label">
                                            <i class="bi bi-lock-fill"></i>Confirm New Password
                                        </label>
                                        <input type="password" id="confirmPass" name="pass1" class="form-control" placeholder="Confirm your new password" required />
                                        <div class="invalid-feedback">Passwords do not match</div>
                                    </div>

                                    <button type="submit" name="submit_pass" class="btn-primary">
                                        <i class="bi bi-check-circle me-2"></i>Change Password
                                    </button>
                                    
                                    <a href="./Login" class="btn-secondary">
                                        <i class="bi bi-arrow-left me-2"></i>Back to Login
                                    </a>
                                </form>
                                
                            <?php } else { ?>
                                <!-- Email Entry Step -->
                                <div class="forgot-header">
                                    <h1><i class="bi bi-envelope me-2"></i>Reset Password</h1>
                                    <p>Enter your email address and we'll send you a verification code</p>
                                </div>
                                
                                <form action="" method="POST" class="needs-validation" novalidate>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">
                                            <i class="bi bi-envelope-fill"></i>Email Address
                                        </label>
                                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your registered email" required />
                                        <div class="invalid-feedback">Please enter a valid email address</div>
                                    </div>

                                    <button type="submit" name="submit_email" class="btn-primary">
                                        <i class="bi bi-send me-2"></i>Send Verification Code
                                    </button>
                                    
                                    <a href="./Login" class="btn-secondary">
                                        <i class="bi bi-arrow-left me-2"></i>Back to Login
                                    </a>
                                </form>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php') ?>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./formValidation.js"></script>
    <script>
        const suc = "<?php echo $success ?>";
        if (suc == 1) {
            OTPInput();
            var fiveMinutes = 60 * 5,
                display = document.querySelector('#time');
            startTimer(fiveMinutes, display);
        }

        function OTPInput() {
            const editor = document.getElementById('first');
            if (editor) {
                editor.onpaste = pasteOTP;
            }

            const inputs = document.querySelectorAll('#otp input');
            for (let i = 0; i < inputs.length; i++) {
                inputs[i].addEventListener('input', function(event) {
                    if (!event.target.value || event.target.value == '') {
                        // Move to previous input
                        const prevInput = inputs[i - 1];
                        if (prevInput) {
                            prevInput.focus();
                        }
                    } else {
                        // Move to next input
                        const nextInput = inputs[i + 1];
                        if (nextInput) {
                            nextInput.focus();
                        }
                    }
                });
                
                // Handle backspace
                inputs[i].addEventListener('keydown', function(event) {
                    if (event.key === 'Backspace' && !event.target.value) {
                        const prevInput = inputs[i - 1];
                        if (prevInput) {
                            prevInput.focus();
                        }
                    }
                });
            }
        }

        function pasteOTP(event) {
            event.preventDefault();
            let pasteVal = event.clipboardData.getData('text').replace(/\D/g, '').split("");
            const inputs = document.querySelectorAll('#otp input');
            
            for (let i = 0; i < Math.min(pasteVal.length, inputs.length); i++) {
                inputs[i].value = pasteVal[i];
            }
            
            // Focus on the next empty input or the last input
            const nextEmptyIndex = Math.min(pasteVal.length, inputs.length - 1);
            inputs[nextEmptyIndex].focus();
        }

        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            }
        }

        function startTimer(duration, display) {
            var timer = duration, minutes, seconds;
            const interval = setInterval(function() {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;
                
                if (--timer < 0) {
                    clearInterval(interval);
                    display.innerHTML = '<i class="bi bi-exclamation-triangle me-1"></i>Your OTP has expired!';
                    display.className = 'alert alert-danger text-center';
                }
            }, 1000);
        }
    </script>
</body>

</html>