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
    global $connection;
    
    require_once __DIR__ . '/../mail/PHPMailerAutoload.php';
    require_once __DIR__ . '/../mail/class.phpmailer.php';
    require_once __DIR__ . '/../mail/class.smtp.php';
    
    $mail = new PHPMailer;
    $mail->isSMTP();
    // Mailtrap SMTP settings for testing
    $mail->Host = 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Port = 2525;
    $mail->Username = '49c99e63f1b312'; // <-- Replace with your Mailtrap username
    $mail->Password = 'a8f396dbd198bb'; // <-- Replace with your Mailtrap password
    $mail->setFrom('test@successat11plusenglish.com', 'Success At 11 Plus English (Test)');
    
    // Recipient
    $mail->addAddress($studentData['email'], $studentData['fname'] . ' ' . $studentData['surname']);
    $mail->addReplyTo('test@successat11plusenglish.com', 'Success At 11 Plus English (Test)');
    
    $mail->isHTML(true);
    
    // Email content
    $mail->Subject = 'Welcome to Success At 11 Plus English - Your Login Credentials';
    
    $mailBody = '
    <html>
    <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
        <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
            <h2 style="color: #6e20a7;">Welcome to Success At 11 Plus English!</h2>
            
            <p>Dear ' . $studentData['fname'] . ' ' . $studentData['surname'] . ',</p>
            
            <p>Thank you for your purchase! Your payment has been successfully processed and your account has been created.</p>
              <div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <h3 style="color: #6e20a7; margin-top: 0;">Purchase Details:</h3>
                <p><strong>Module:</strong> ' . $moduleName . '</p>
                <p><strong>Year Group:</strong> ' . $class . '</p>
                <p><strong>Student:</strong> ' . $studentData['fname'] . ' ' . $studentData['surname'] . '</p>
            </div>
            
            <div style="background-color: #e8f5e8; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <h3 style="color: #16a34a; margin-top: 0;">Your Login Credentials:</h3>
                <p><strong>Email:</strong> ' . $studentData['email'] . '</p>
                <p><strong>Password:</strong> ' . $studentData['password'] . '</p>
                <p><strong>Login URL:</strong> <a href="' . BASE_URL . 'Login.php">' . BASE_URL . 'Login.php</a></p>
            </div>
            
            <p><strong>Important:</strong> Please keep these credentials safe and change your password after your first login for security.</p>
            
            <p>You can now access your module and begin your learning journey. If you have any questions or need support, please don\'t hesitate to contact us.</p>
            
            <p>Best regards,<br>
            The Success at 11 Plus English Team<br>
            <a href="https://successat11plusenglish.com">successat11plusenglish.com</a></p>
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
