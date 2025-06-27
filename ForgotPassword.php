<?php
if (!isset($_SESSION)) {
    session_start();
    require_once __DIR__ . '/database/dbconfig.php';
}
// Fix: Handle reset/start over request BEFORE any output
if (isset($_GET['reset']) || isset($_POST['start_over'])) {
    unset($_SESSION['reset_email'], $_SESSION['otp_sent'], $_SESSION['otp_verified'], 
          $_SESSION['generated_otp'], $_SESSION['otp_time']);
    header('Location: ForgotPassword.php');
    exit();
}
// Helper: prepared statement for select
function db_select($conn, $sql, $params, $types = '') {
    $stmt = $conn->prepare($sql);
    if ($params) {
        if (!$types) $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}
// Helper: prepared statement for update/insert
function db_exec($conn, $sql, $params, $types = '') {
    $stmt = $conn->prepare($sql);
    if ($params) {
        if (!$types) $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
    }
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
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
            margin: 0;
            padding: 0;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Source Serif Pro', serif;
        }
        
        .forgot-container {
            flex: 1;
            display: flex;
            align-items: stretch;
            padding: 0;
            min-height: calc(100vh - 80px); /* Subtract navbar height */
        }
        
        .forgot-card {
            background: var(--card-bg);
            border-radius: 0;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(30, 64, 175, 0.15);
            border: none;
            min-height: 100vh;
            margin: 0;
        }
        
        .forgot-card .row {
            height: 100%;
            min-height: 100vh;
        }
        
        .forgot-card .col-lg-6 {
            display: flex;
            flex-direction: column;
        }
        
        .forgot-image {
            background: linear-gradient(135deg, var(--theme-blue) 0%, var(--theme-blue-dark) 100%);
            padding: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100%;
        }
        
        .forgot-image img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.2);
        }
        
        .forgot-form {
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 100%;
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
            .forgot-container {
                min-height: calc(100vh - 60px); /* Adjust for smaller navbar */
            }
            
            .forgot-card {
                margin: 0;
                border-radius: 0;
                min-height: 100vh;
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
    // Initialize variables
    $step = 'email'; // Default step: email, otp, password, success
    $error_message = "";
    $success_message = "";
    
    // Determine current step based on session and form submissions
    if (isset($_SESSION['reset_email']) && isset($_SESSION['otp_verified']) && $_SESSION['otp_verified'] === true) {
        $step = 'password';
    } elseif (isset($_SESSION['reset_email']) && isset($_SESSION['otp_sent']) && $_SESSION['otp_sent'] === true) {
        $step = 'otp';
    }
    
    // Handle form submissions
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        // Step 1: Email submission
        if (isset($_POST['submit_email']) && !empty($_POST['email'])) {
            $email = trim($_POST['email']);
            
            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error_message = "Please enter a valid email address.";
            } else {
                // Check if email exists in database
                $emailCheck = "SELECT id, email FROM students WHERE email = ?";
                $result = db_select($connection, $emailCheck, [$email]);
                
                if ($result->num_rows > 0) {
                    // Generate and send OTP
                    $otp = sprintf("%06d", mt_rand(100000, 999999));
                    
                    // Clear any existing sessions for fresh start
                    unset($_SESSION['reset_email'], $_SESSION['otp_sent'], $_SESSION['otp_verified'], $_SESSION['generated_otp']);
                    
                    // Store in session
                    $_SESSION['reset_email'] = $email;
                    $_SESSION['generated_otp'] = $otp;
                    $_SESSION['otp_time'] = time();
                    
                    // Send OTP email
                    require_once("./forgotOtpMail.php");
                    $mail_status = sendOTP($email, $otp);
                    
                    if ($mail_status) {
                        // Expire previous OTPs for this email in database
                        db_exec($connection, "UPDATE otp SET is_expired = 1 WHERE email = ?", [$email]);
                        
                        // Insert new OTP record
                        $insertOtp = "INSERT INTO otp (email, otp_code, is_expired, created_at) VALUES (?, ?, 0, NOW())";
                        db_exec($connection, $insertOtp, [$email, $otp]);
                        
                        $_SESSION['otp_sent'] = true;
                        $step = 'otp';
                        $success_message = "Verification code sent to your email address.";
                    } else {
                        $error_message = "Failed to send verification code. Please try again.";
                    }
                } else {
                    $error_message = "This email address is not registered with us.";
                }
            }
        }
        
        // Step 2: OTP verification
        if (isset($_POST['submit_otp']) && isset($_SESSION['reset_email'])) {
            // Simple OTP collection - get all 6 digits
            $entered_otp = '';
            $all_digits_present = true;
            
            for ($i = 1; $i <= 6; $i++) {
                $digit = isset($_POST["otp$i"]) ? trim($_POST["otp$i"]) : '';
                if ($digit === '' || !ctype_digit($digit)) {
                    $all_digits_present = false;
                    break;
                }
                $entered_otp .= $digit;
            }
            
            if (!$all_digits_present || strlen($entered_otp) !== 6) {
                $error_message = "Please enter all 6 digits of the verification code.";
                $step = 'otp';
            } else {
                $email = $_SESSION['reset_email'];
                
                // Check OTP validity (within 5 minutes)
                if (isset($_SESSION['otp_time']) && (time() - $_SESSION['otp_time']) > 300) {
                    $error_message = "Verification code has expired. Please request a new one.";
                    unset($_SESSION['otp_sent'], $_SESSION['generated_otp'], $_SESSION['otp_time']);
                    $step = 'email';
                } else {
                    // Verify OTP against session and database
                    $session_otp_valid = isset($_SESSION['generated_otp']) && $_SESSION['generated_otp'] === $entered_otp;
                    
                    // Also check database
                    $otpCheck = "SELECT id FROM otp WHERE email = ? AND otp_code = ? AND is_expired = 0 AND created_at >= (NOW() - INTERVAL 5 MINUTE) ORDER BY id DESC LIMIT 1";
                    $otpResult = db_select($connection, $otpCheck, [$email, $entered_otp]);
                    $db_otp_valid = $otpResult->num_rows > 0;
                    
                    if ($session_otp_valid && $db_otp_valid) {
                        // Mark OTP as used
                        db_exec($connection, "UPDATE otp SET is_expired = 1 WHERE email = ? AND otp_code = ?", [$email, $entered_otp]);
                        
                        $_SESSION['otp_verified'] = true;
                        unset($_SESSION['otp_sent'], $_SESSION['generated_otp'], $_SESSION['otp_time']);
                        $step = 'password';
                        $success_message = "Email verified successfully. Please set your new password.";
                    } else {
                        $error_message = "Invalid verification code. Please check and try again.";
                        $step = 'otp';
                    }
                }
            }
        }
        
        // Step 3: Password reset
        if (isset($_POST['submit_password']) && isset($_SESSION['reset_email']) && isset($_SESSION['otp_verified'])) {
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            
            // Relaxed password validation: only require minimum 6 characters
            if (empty($new_password) || empty($confirm_password)) {
                $error_message = "Both password fields are required.";
                $step = 'password';
            } elseif ($new_password !== $confirm_password) {
                $error_message = "Passwords do not match.";
                $step = 'password';
            } elseif (strlen($new_password) < 6) {
                $error_message = "Password must be at least 6 characters long.";
                $step = 'password';
            } else {
                // Update password in database (storing as plain text as requested)
                $email = $_SESSION['reset_email'];
                $updatePassword = "UPDATE students SET password = ? WHERE email = ?";
                $updateResult = db_exec($connection, $updatePassword, [$new_password, $email]);
                
                if ($updateResult) {
                    // Clear all session data
                    unset($_SESSION['reset_email'], $_SESSION['otp_verified']);
                    $step = 'success';
                    $success_message = "Your password has been reset successfully. You can now login with your new password.";
                } else {
                    $error_message = "Failed to update password. Please try again.";
                    $step = 'password';
                }
            }
        }
    }
    ?>
    <div class="forgot-container">
        <div class="container-fluid px-0">
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
                                <div class="alert alert-danger">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    <?php echo htmlspecialchars($error_message); ?>
                                </div>
                            <?php } ?>
                            
                            <?php if (!empty($success_message)) { ?>
                                <div class="alert alert-success">
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    <?php echo htmlspecialchars($success_message); ?>
                                </div>
                            <?php } ?>

                            <?php if ($step === 'email') { ?>
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
                                        <input type="email" id="email" name="email" class="form-control" 
                                               placeholder="Enter your registered email" 
                                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" 
                                               required />
                                        <div class="invalid-feedback">Please enter a valid email address</div>
                                    </div>

                                    <button type="submit" name="submit_email" class="btn-primary">
                                        <i class="bi bi-send me-2"></i>Send Verification Code
                                    </button>
                                    
                                    <a href="./Login.php" class="btn-secondary">
                                        <i class="bi bi-arrow-left me-2"></i>Back to Login
                                    </a>
                                </form>
                                
                            <?php } elseif ($step === 'otp') { ?>
                                <!-- OTP Verification Step -->
                                <div class="otp-container">
                                    <div class="otp-header">
                                        <h2><i class="bi bi-envelope-check me-2"></i>Verify Your Email</h2>
                                        <p>We've sent a 6-digit code to <strong><?php echo htmlspecialchars($_SESSION['reset_email']); ?></strong></p>
                                    </div>
                                    
                                    <div class="timer" id="time">05:00</div>
                                    <div class="otp-info">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Check your <strong>inbox</strong> and <strong>spam folder</strong>
                                    </div>
                                    
                                    <form action="" method="POST">
                                        <div class="otp-inputs" id="otp">
                                            <input class="otp-input form-control" type="text" name="otp1" id="first" maxlength="1" />
                                            <input class="otp-input form-control" type="text" name="otp2" id="second" maxlength="1" />
                                            <input class="otp-input form-control" type="text" name="otp3" id="third" maxlength="1" />
                                            <input class="otp-input form-control" type="text" name="otp4" id="fourth" maxlength="1" />
                                            <input class="otp-input form-control" type="text" name="otp5" id="fifth" maxlength="1" />
                                            <input class="otp-input form-control" type="text" name="otp6" id="sixth" maxlength="1" />
                                        </div>
                                        
                                        <button type="submit" name="submit_otp" class="btn-primary">
                                            <i class="bi bi-check-circle me-2"></i>Verify Code
                                        </button>
                                        
                                        <div class="mt-3 text-center">
                                            <p class="small text-muted">Didn't receive the code?</p>
                                            <a href="?reset=1" class="btn btn-link">
                                                <i class="bi bi-arrow-counterclockwise me-1"></i>Start Over
                                            </a>
                                        </div>
                                    </form>
                                </div>
                                
                            <?php } elseif ($step === 'password') { ?>
                                <!-- New Password Step -->
                                <div class="forgot-header">
                                    <h1><i class="bi bi-key me-2"></i>Create New Password</h1>
                                    <p>Choose a strong password for your account</p>
                                </div>
                                
                                <form action="" method="POST" class="needs-validation" novalidate>
                                    <div class="mb-3">
                                        <label for="newPassword" class="form-label">
                                            <i class="bi bi-lock-fill"></i>New Password
                                        </label>
                                        <div class="password-toggle">
                                            <input type="password" id="newPassword" name="new_password" class="form-control" 
                                                   placeholder="Enter your new password" required />
                                            <button type="button" class="password-toggle-btn" onclick="togglePassword('newPassword', this)">
                                                <i class="bi bi-eye-slash"></i>
                                            </button>
                                        </div>
                                        <small class="form-text text-muted">
                                            Password must be at least 6 characters long
                                        </small>
                                        <div class="invalid-feedback">Please enter a password</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="confirmPassword" class="form-label">
                                            <i class="bi bi-lock-fill"></i>Confirm New Password
                                        </label>
                                        <div class="password-toggle">
                                            <input type="password" id="confirmPassword" name="confirm_password" class="form-control" 
                                                   placeholder="Confirm your new password" required />
                                            <button type="button" class="password-toggle-btn" onclick="togglePassword('confirmPassword', this)">
                                                <i class="bi bi-eye-slash"></i>
                                            </button>
                                        </div>
                                        <div class="invalid-feedback">Passwords do not match</div>
                                    </div>

                                    <button type="submit" name="submit_password" class="btn-primary">
                                        <i class="bi bi-check-circle me-2"></i>Change Password
                                    </button>
                                    
                                    <a href="./Login.php" class="btn-secondary">
                                        <i class="bi bi-arrow-left me-2"></i>Back to Login
                                    </a>
                                </form>
                                
                            <?php } elseif ($step === 'success') { ?>
                                <!-- Success Step -->
                                <div class="forgot-header text-center">
                                    <div class="mb-4">
                                        <i class="bi bi-check-circle-fill" style="font-size: 4rem; color: var(--bs-success);"></i>
                                    </div>
                                    <h1><i class="bi bi-check2 me-2"></i>Password Reset Complete</h1>
                                    <p class="lead">Your password has been successfully reset!</p>
                                    <p>You can now login with your new password.</p>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <a href="./Login.php" class="btn-primary text-center">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>Go to Login
                                    </a>
                                </div>
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
        // Initialize components based on current step
        const step = "<?php echo $step; ?>";
        
        if (step === 'otp') {
            initializeOTPInput();
            startOTPTimer();
        }
        
        // Enhanced OTP input handling
        function initializeOTPInput() {
            const inputs = document.querySelectorAll('#otp input');
            
            inputs.forEach((input, index) => {
                // Handle input events
                input.addEventListener('input', function(e) {
                    const value = e.target.value;
                    
                    // Only allow digits
                    if (value && !/^\d$/.test(value)) {
                        e.target.value = '';
                        return;
                    }
                    
                    // Move to next input if current is filled
                    if (value && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });
                
                // Handle backspace
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace') {
                        // If current input is empty, move to previous
                        if (!e.target.value && index > 0) {
                            inputs[index - 1].focus();
                        }
                        // Clear current input
                        e.target.value = '';
                    }
                });
                
                // Handle paste
                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const paste = e.clipboardData.getData('text').replace(/\D/g, '');
                    
                    for (let i = 0; i < Math.min(paste.length, inputs.length); i++) {
                        if (inputs[i]) {
                            inputs[i].value = paste[i];
                        }
                    }
                    
                    // Focus on next empty input or last input
                    const nextIndex = Math.min(paste.length, inputs.length - 1);
                    if (inputs[nextIndex]) {
                        inputs[nextIndex].focus();
                    }
                });
            });
            
            // Focus first input
            if (inputs[0]) {
                inputs[0].focus();
            }
        }
        
        // OTP Timer function
        function startOTPTimer() {
            const display = document.querySelector('#time');
            if (!display) return;
            
            let timeLeft = 300; // 5 minutes in seconds
            
            const timer = setInterval(function() {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                
                display.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                
                if (timeLeft <= 0) {
                    clearInterval(timer);
                    display.innerHTML = '<i class="bi bi-exclamation-triangle me-1"></i>Code expired! Please request a new one.';
                    display.className = 'alert alert-warning text-center small';
                    
                    // Disable OTP inputs
                    const inputs = document.querySelectorAll('#otp input');
                    inputs.forEach(input => input.disabled = true);
                    
                    // Disable submit button
                    const submitBtn = document.querySelector('button[name="submit_otp"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="bi bi-clock me-2"></i>Code Expired';
                    }
                }
                
                timeLeft--;
            }, 1000);
        }
        
        // Password toggle function
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
        
        // Form validation enhancements
        document.addEventListener('DOMContentLoaded', function() {
            // Email validation
            const emailForm = document.querySelector('button[name="submit_email"]');
            if (emailForm) {
                emailForm.closest('form').addEventListener('submit', function(e) {
                    const emailInput = document.querySelector('input[name="email"]');
                    if (emailInput && !isValidEmail(emailInput.value)) {
                        e.preventDefault();
                        showError('Please enter a valid email address.');
                    }
                });
            }
            
            // Password validation
            const passwordForm = document.querySelector('button[name="submit_password"]');
            if (passwordForm) {
                passwordForm.closest('form').addEventListener('submit', function(e) {
                    const newPass = document.querySelector('input[name="new_password"]');
                    const confirmPass = document.querySelector('input[name="confirm_password"]');
                    
                    if (!newPass || !confirmPass) return;
                    
                    if (newPass.value !== confirmPass.value) {
                        e.preventDefault();
                        showError('Passwords do not match.');
                        return;
                    }
                    
                    if (newPass.value.length < 6) {
                        e.preventDefault();
                        showError('Password must be at least 6 characters long.');
                        return;
                    }
                });
            }
            
            // OTP form validation is now disabled to prevent interference
            // Server-side validation handles all OTP validation
        });
        
        // Helper functions
        function isValidEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
        
        function showError(message) {
            // Create or update error alert
            let errorDiv = document.querySelector('.alert-danger');
            if (!errorDiv) {
                errorDiv = document.createElement('div');
                errorDiv.className = 'alert alert-danger';
                const form = document.querySelector('.forgot-form');
                form.insertBefore(errorDiv, form.firstChild);
            }
            
            errorDiv.innerHTML = `<i class="bi bi-exclamation-triangle-fill me-2"></i>${message}`;
            errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    </script>
</body>

</html>