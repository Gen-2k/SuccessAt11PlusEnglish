<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once __DIR__ . '/../database/dbconfig.php';

// Check if session ID is provided
if (!isset($_GET['session_id']) || !isset($_SESSION['pending_enrollment'])) {
    header("Location: " . BASE_URL . "index.php");
    exit();
}

$sessionId = $_GET['session_id'];
$enrollmentData = $_SESSION['pending_enrollment'];

// Initialize Stripe to verify payment
require_once __DIR__ . '/../vendor/autoload.php';

$stripe = new \Stripe\StripeClient("sk_test_51RWXNGRpJQGKwRds9xlMwIqdodtLHtOXNhdLs2Q0TBJQxEWOU4iOeNteMrFS9UpZHXQ55auZQ2UnrR9wCsYlupan005sNBiK3o");

// Log helper function
function logPaymentEvent($message, $context = []) {
    $logFile = __DIR__ . '/payment_event_log.txt';
    $date = date('Y-m-d H:i:s');
    $contextStr = '';
    if (!empty($context)) {
        $contextStr = ' | Context: ' . json_encode($context, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
    $entry = "[$date] $message$contextStr\n";
    file_put_contents($logFile, $entry, FILE_APPEND);
}

try {
    // Retrieve the session to verify payment
    $session = $stripe->checkout->sessions->retrieve($sessionId);
    logPaymentEvent('Stripe session retrieved', ['session_id' => $sessionId, 'payment_status' => $session->payment_status]);
    if ($session->payment_status !== 'paid') {
        logPaymentEvent('Payment not completed', ['session_id' => $sessionId, 'status' => $session->payment_status]);
        throw new Exception('Payment not completed');
    }
    
    // Payment successful, proceed with user creation and enrollment
    $studentData = $enrollmentData['student_data'];
    $moduleName = $enrollmentData['module'];      // Updated field name
    $class = $enrollmentData['class'];           // Updated field name  
    $modulePrice = $enrollmentData['module_price'];
    logPaymentEvent('Payment successful', [
        'session_id' => $sessionId,
        'student_email' => $studentData['email'],
        'module' => $moduleName,
        'class' => $class,
        'price' => $modulePrice
    ]);
    // Begin transaction
    mysqli_begin_transaction($connection);
    
    try {
        // Insert student into students table
        $insertStudent = "INSERT INTO students (fname, surname, dob, gender, parent_firstname, parent_surname, address, email, password, phone, yesorno, role, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'user', CURRENT_TIMESTAMP)";
        
        $stmt = mysqli_prepare($connection, $insertStudent);
        mysqli_stmt_bind_param($stmt, "sssssssssss", 
            $studentData['fname'],
            $studentData['surname'], 
            $studentData['dob'],
            $studentData['gender'],
            $studentData['parent_firstname'],
            $studentData['parent_surname'],
            $studentData['address'],
            $studentData['email'],
            $studentData['password'],
            $studentData['phone'],
            $studentData['yesorno']
        );
        
        if (!mysqli_stmt_execute($stmt)) {
            logPaymentEvent('Failed to create student account', ['email' => $studentData['email'], 'error' => mysqli_error($connection)]);
            throw new Exception('Failed to create student account');
        }
        $studentId = mysqli_insert_id($connection);
        logPaymentEvent('Student account created', ['student_id' => $studentId, 'email' => $studentData['email']]);
        // Insert enrollment record using new schema field names
        $accessStart = date('Y-m-d');
        $accessEnd = date('Y-m-d', strtotime('+2 years')); // 2 years access
          $insertEnrollment = "INSERT INTO enrollments (student_id, class, module, price, transaction_id, payment_status, access_start, access_end) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt2 = mysqli_prepare($connection, $insertEnrollment);
        $paymentStatus = 'paid';
        mysqli_stmt_bind_param($stmt2, "issdssss",
            $studentId,
            $class,        // Updated field name
            $moduleName,   // Updated field name
            $modulePrice,
            $sessionId,
            $paymentStatus,
            $accessStart,
            $accessEnd
        );
        
        if (!mysqli_stmt_execute($stmt2)) {
            logPaymentEvent('Failed to create enrollment', ['student_id' => $studentId, 'module' => $moduleName, 'error' => mysqli_error($connection)]);
            throw new Exception('Failed to create enrollment record');
        }
        logPaymentEvent('Enrollment created', ['student_id' => $studentId, 'module' => $moduleName]);
        // Add user to newsletter table if not already subscribed
        $newsletterCheck = mysqli_prepare($connection, "SELECT id FROM newsletter WHERE email = ?");
        mysqli_stmt_bind_param($newsletterCheck, "s", $studentData['email']);
        mysqli_stmt_execute($newsletterCheck);
        $newsletterResult = mysqli_stmt_get_result($newsletterCheck);
        if (mysqli_num_rows($newsletterResult) === 0) {
            $insertNewsletter = mysqli_prepare($connection, "INSERT INTO newsletter (email, fname, lname) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($insertNewsletter, "sss", $studentData['email'], $studentData['fname'], $studentData['surname']);
            if (mysqli_stmt_execute($insertNewsletter)) {
                logPaymentEvent('Added to newsletter', ['email' => $studentData['email']]);
            } else {
                logPaymentEvent('Failed to add to newsletter', ['email' => $studentData['email'], 'error' => mysqli_error($connection)]);
            }
        } else {
            logPaymentEvent('Already subscribed to newsletter', ['email' => $studentData['email']]);
        }
        
        // Commit transaction
        mysqli_commit($connection);
        logPaymentEvent('Database commit successful', ['student_id' => $studentId]);
        // Send email with credentials
        sendCredentialsEmail($studentData, $moduleName, $class);
        
        // Clear session data
        unset($_SESSION['pending_enrollment']);
        unset($_SESSION['classid']);
        unset($_SESSION['courseName']);
        unset($_SESSION['courseId']);
        unset($_SESSION['module']);
        
        // Redirect to success page
        $_SESSION['success_message'] = "Payment successful! Your login credentials have been sent to your email address.";
        header("Location: " . BASE_URL . "payment/payment_complete.php");
        exit();
        
    } catch (Exception $e) {
        // Rollback transaction
        mysqli_rollback($connection);
        logPaymentEvent('Transaction rolled back', ['error' => $e->getMessage()]);
        throw $e;
    }
    
} catch (Exception $e) {
    logPaymentEvent('Payment error', ['error' => $e->getMessage()]);
    $_SESSION['error'] = "Payment verification failed. Please contact support.";
    header("Location: " . BASE_URL . "index.php");
    exit();
}

function sendCredentialsEmail($studentData, $moduleName, $class) {
    global $connection, $sessionId, $modulePrice, $session;
    require_once __DIR__ . '/../mail/PHPMailerAutoload.php';
    require_once __DIR__ . '/../mail/class.phpmailer.php';
    require_once __DIR__ . '/../mail/class.smtp.php';
    $mailConfig = require __DIR__ . '/../mail/mail_config.php';
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = $mailConfig['host'];
    $mail->SMTPAuth = true;
    $mail->Username = $mailConfig['username'];
    $mail->Password = $mailConfig['password'];
    $mail->SMTPSecure = $mailConfig['smtp_secure'];
    $mail->Port = $mailConfig['port'];
    $mail->setFrom($mailConfig['from_email'], $mailConfig['from_name']);
    $mail->addAddress($studentData['email'], $studentData['fname'] . ' ' . $studentData['surname']);
    $mail->addReplyTo($mailConfig['reply_to_email'], $mailConfig['reply_to_name']);
    $mail->isHTML($mailConfig['is_html']);
    $mail->CharSet = $mailConfig['charset'];
    $mail->Subject = 'Welcome to Success At 11 Plus English - Your Login Credentials & Invoice';
    $paymentDate = isset($session->created) ? date('F j, Y', $session->created) : date('F j, Y');
    $mailBody = '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to Success At 11 Plus English</title>
  <style>
    body { margin:0; padding:0; background:#f7f7f7; }
    .wrapper { width:100%; table-layout:fixed; background:#f7f7f7; padding:30px 0; }
    .main { background:#ffffff; width:100%; max-width:650px; margin:0 auto; border-radius:8px; overflow:hidden; }
    .header { background: linear-gradient(90deg, #1E40AF 0%, #F59E0B 100%); padding:24px; text-align:center; }
    .header h1 { margin:0; font-family:\'Source Serif Pro\', serif; font-size:1.8rem; color:#ffffff; }
    .header p { margin:8px 0 0; font-family:Varela Round, sans-serif; font-size:1rem; color:#e0e0e0; }
    .content { padding:28px; font-family:Varela Round, sans-serif; color:#212529; line-height:1.6; }
    .box { background:#f8f9fa; border-left:4px solid #F59E0B; padding:16px 20px; margin:20px 0; border-radius:4px; }
    .credentials { background:#e8f5e8; border-radius:4px; padding:16px 20px; margin:20px 0; }
    .invoice { background:#f3f4f6; border-radius:4px; padding:16px 20px; margin:20px 0; border:1px solid #e5e7eb; }
    .invoice-table { width:100%; border-collapse:collapse; margin-top:1rem; }
    .invoice-table th, .invoice-table td { padding:0.5rem 0.7rem; text-align:left; border-bottom:1px solid #e5e7eb; }
    .invoice-table th { background:#f8fafc; color:#1e40af; font-weight:600; }
    .invoice-table td:last-child, .invoice-table th:last-child { text-align:right; }
    .cta-btn { display:inline-block; background:#1e40af; color:#fff; text-decoration:none; padding:12px 28px; border-radius:4px; font-weight:600; margin-top:1.5rem; }
    .footer { background:#ffffff; text-align:center; padding:16px; font-size:12px; color:#888888; }
    .footer a { color:#1E40AF; text-decoration:none; }
    @media(max-width:600px) { .content{padding:20px;} .header h1{font-size:1.5rem;} }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="main">
      <div class="header">
        <h1>Payment Successful</h1>
        <p>Welcome to Success at 11 Plus English!</p>
      </div>
      <div class="content">
        <p style="font-size:1.1rem;">Dear <strong>' . htmlspecialchars($studentData['fname'] . ' ' . $studentData['surname']) . '</strong>,</p>
        <p>Thank you for your purchase! Your payment has been processed and your account is now active.</p>
        <div class="box">
          <h3 style="color:#1e40af;margin-top:0;">Purchase Details</h3>
          <p><strong>Module:</strong> ' . htmlspecialchars($moduleName) . '</p>
          <p><strong>Year Group:</strong> ' . htmlspecialchars($class) . '</p>
          <p><strong>Student:</strong> ' . htmlspecialchars($studentData['fname'] . ' ' . $studentData['surname']) . '</p>
        </div>
        <div class="credentials">
          <h3 style="color:#16a34a;margin-top:0;">Your Login Credentials</h3>
          <p><strong>Email:</strong> ' . htmlspecialchars($studentData['email']) . '</p>
          <p><strong>Password:</strong> ' . htmlspecialchars($studentData['password']) . '</p>
          <p><strong>Login URL:</strong> <a href="' . BASE_URL . 'Login.php" style="color:#1e40af;">' . BASE_URL . 'Login.php</a></p>
        </div>
        <div class="invoice">
          <h3>Invoice</h3>
          <table class="invoice-table">
            <tr><th>Description</th><th>Amount</th></tr>
            <tr><td>' . htmlspecialchars($moduleName) . ' (' . htmlspecialchars($class) . ')</td><td>£' . number_format($modulePrice, 2) . '</td></tr>
            <tr><td style="font-weight:600;">Total Paid</td><td style="font-weight:600;">£' . number_format($modulePrice, 2) . '</td></tr>
          </table>
          <p style="margin:0.7rem 0 0 0;"><strong>Transaction ID:</strong> ' . htmlspecialchars($sessionId) . '</p>
          <p style="margin:0;"><strong>Payment Date:</strong> ' . htmlspecialchars($paymentDate) . '</p>
        </div>
        <p style="margin-top:2rem;"><strong>Important:</strong> Please keep these credentials safe and change your password after your first login for security.</p>
        <a href="' . BASE_URL . 'Login.php" class="cta-btn">Login Now</a>
      </div>
      <div class="footer">
        <p>Need help? Contact us at <a href="mailto:success@elevenplusenglish.co.uk">success@elevenplusenglish.co.uk</a></p>
        <p>Visit <a href="https://elevenplusenglish.co.uk">elevenplusenglish.co.uk</a></p>
        <p style="margin-top:1.2rem;">&copy; ' . date('Y') . ' Success At 11 Plus English. All rights reserved.</p>
      </div>
    </div>
  </div>
</body>
</html>';
    $mail->Body = $mailBody;
    $mail->AltBody = strip_tags($mailBody);
    $context = [
        'to' => $studentData['email'],
        'name' => $studentData['fname'] . ' ' . $studentData['surname'],
        'module' => $moduleName,
        'class' => $class
    ];
    if (!$mail->send()) {
        logPaymentEvent('Email failed to send', $context + ['error' => $mail->ErrorInfo]);
        error_log('Email failed to send: ' . $mail->ErrorInfo);
    } else {
        logPaymentEvent('Email sent', $context);
    }
}
?>
