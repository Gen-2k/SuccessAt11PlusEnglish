<?php
require_once 'config/config.php';
require_once 'includes/auth.php';

// Check authentication
checkStudentAuth();

// Get session ID from Stripe
$sessionId = $_GET['session_id'] ?? '';

if (!$sessionId) {
    header('Location: ebooks.php?error=invalid_session');
    exit;
}

// Check if we have pending ebook purchase data
if (!isset($_SESSION['pending_ebook_purchase'])) {
    header('Location: ebooks.php?error=no_pending_purchase');
    exit;
}

$purchase_data = $_SESSION['pending_ebook_purchase'];

// Initialize Stripe
require_once __DIR__ . '/../vendor/autoload.php';

$stripe = new \Stripe\StripeClient("sk_test_51RWXNGRpJQGKwRds9xlMwIqdodtLHtOXNhdLs2Q0TBJQxEWOU4iOeNteMrFS9UpZHXQ55auZQ2UnrR9wCsYlupan005sNBiK3o");

// Logging function
function logEbookPaymentEvent($message, $context = []) {
    $logFile = __DIR__ . '/../payment/ebook_payment_event_log.txt';
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
    logEbookPaymentEvent('Stripe session retrieved', ['session_id' => $sessionId, 'payment_status' => $session->payment_status]);
    
    if ($session->payment_status !== 'paid') {
        logEbookPaymentEvent('Payment not completed', ['session_id' => $sessionId, 'status' => $session->payment_status]);
        throw new Exception('Payment not completed');
    }
    
    // Payment successful, create enrollment record
    $ebook_data = $purchase_data['ebook_data'];
    $student_id = $purchase_data['student_id'];
    $student_data = $purchase_data['student_data'];
    
    logEbookPaymentEvent('Processing ebook payment', [
        'session_id' => $sessionId,
        'student_email' => $student_data['email'],
        'ebook_title' => $ebook_data['title'],
        'price' => $ebook_data['price']
    ]);
    
    // Begin transaction
    $conn = getDBConnection();
    mysqli_begin_transaction($conn);
      try {
        // Create ebook purchase record
        $purchase_id = createEbookPurchase($student_id, $ebook_data['id'], $ebook_data['price'], $sessionId, 'paid');
        
        if (!$purchase_id) {
            logEbookPaymentEvent('Failed to create ebook purchase', ['student_id' => $student_id, 'ebook' => $ebook_data['title'], 'error' => mysqli_error($conn)]);
            throw new Exception('Failed to create ebook purchase record');
        }
        
        logEbookPaymentEvent('Ebook purchase created', ['student_id' => $student_id, 'ebook' => $ebook_data['title'], 'purchase_id' => $purchase_id]);
        
        // Add user to newsletter table if not already subscribed
        $checkNewsletter = "SELECT id FROM newsletter WHERE email = ?";
        $stmt = mysqli_prepare($conn, $checkNewsletter);
        mysqli_stmt_bind_param($stmt, "s", $student_data['email']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) == 0) {
            $insertNewsletter = "INSERT INTO newsletter (email, fname, lname, subscribed_at) VALUES (?, ?, ?, NOW())";
            $stmt = mysqli_prepare($conn, $insertNewsletter);
            mysqli_stmt_bind_param($stmt, "sss", 
                $student_data['email'], 
                $student_data['fname'], 
                $student_data['surname']
            );
            mysqli_stmt_execute($stmt);
            logEbookPaymentEvent('Added to newsletter', ['email' => $student_data['email']]);
        }
        
        // Commit transaction
        mysqli_commit($conn);
        logEbookPaymentEvent('Transaction completed successfully', ['session_id' => $sessionId]);
        
        // Clear pending purchase data
        unset($_SESSION['pending_ebook_purchase']);
        
        // Send confirmation email (optional)
        sendEbookPurchaseConfirmationEmail($student_data, $ebook_data, $sessionId);
        
        // Set success message
        $_SESSION['success_message'] = "E-book '{$ebook_data['title']}' purchased successfully! You can now access it from your E-Books page.";
        
        // Redirect to ebooks page
        header('Location: ebooks.php?purchase=success');
        exit;
        
    } catch (Exception $e) {
        mysqli_rollback($conn);
        logEbookPaymentEvent('Database transaction failed', ['error' => $e->getMessage(), 'session_id' => $sessionId]);
        throw $e;
    }
    
} catch (Exception $e) {
    logEbookPaymentEvent('Payment processing failed', ['error' => $e->getMessage(), 'session_id' => $sessionId]);
    
    // Set error message
    $_SESSION['error_message'] = 'Payment processing failed. Please contact support if you were charged.';
    
    // Redirect to ebooks page with error
    header('Location: ebooks.php?error=payment_failed');
    exit;
}

// Function to send confirmation email
function sendEbookPurchaseConfirmationEmail($student_data, $ebook_data, $transaction_id) {
    try {
        require_once __DIR__ . '/../mail/PHPMailerAutoload.php';
        require_once __DIR__ . '/../mail/class.phpmailer.php';
        require_once __DIR__ . '/../mail/class.smtp.php';

        $mail = new PHPMailer();
        $mail->isSMTP();
        // Mailtrap SMTP settings for testing (matching module purchase configuration)
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '49c99e63f1b312'; // <-- Replace with your Mailtrap username
        $mail->Password = 'a8f396dbd198bb'; // <-- Replace with your Mailtrap password
        $mail->setFrom('test@successat11plusenglish.com', 'Success At 11 Plus English (Test)');
          // Student email
        $mail->addAddress($student_data['email'], $student_data['fname'] . ' ' . $student_data['surname']);
        $mail->addReplyTo('test@successat11plusenglish.com', 'Success At 11 Plus English (Test)');
        
        $mail->isHTML(true);
        $mail->Subject = 'E-Book Purchase Confirmation - Success At 11 Plus English';
        
        $emailBody = '
        <html>
        <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
            <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
                <h2 style="color: #4CAF50; text-align: center;">E-Book Purchase Confirmation</h2>
                
                <p>Dear ' . htmlspecialchars($student_data['fname'] . ' ' . $student_data['surname']) . ',</p>
                
                <p>Thank you for your e-book purchase! Here are the details:</p>
                
                <div style="background: #f9f9f9; padding: 15px; border-radius: 5px; margin: 20px 0;">
                    <h3 style="margin-top: 0; color: #333;">Purchase Details</h3>
                    <p><strong>E-Book Title:</strong> ' . htmlspecialchars($ebook_data['title']) . '</p>
                    <p><strong>Class:</strong> ' . htmlspecialchars(ucfirst(str_replace('year', 'Year ', $ebook_data['class']))) . '</p>
                    <p><strong>Module:</strong> ' . htmlspecialchars($ebook_data['module']) . '</p>
                    <p><strong>Price:</strong> £' . number_format($ebook_data['price'], 2) . '</p>
                    <p><strong>Transaction ID:</strong> ' . htmlspecialchars($transaction_id) . '</p>
                    <p><strong>Purchase Date:</strong> ' . date('F j, Y') . '</p>
                </div>
                
                <p>You can now access your e-book by logging into your student dashboard and visiting the E-Books section.</p>
                  <div style="text-align: center; margin: 30px 0;">
                    <a href="https://successat11plusenglish.com/StudentDashboard/ebooks.php" 
                       style="background: #4CAF50; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; display: inline-block;">
                        Access My E-Books
                    </a>
                </div>
                
                <p>If you have any questions or need assistance, please don\'t hesitate to contact us.</p>
                  <p>Best regards,<br>
                <strong>The Success At 11 Plus English Team</strong><br>
                <a href="https://successat11plusenglish.com">successat11plusenglish.com</a></p>
            </div>
        </body>
        </html>';
        
        $mail->Body = $emailBody;
        
        if ($mail->send()) {
            logEbookPaymentEvent('Confirmation email sent', ['email' => $student_data['email']]);
        } else {
            logEbookPaymentEvent('Failed to send confirmation email', ['error' => $mail->ErrorInfo]);
        }
        
    } catch (Exception $e) {
        logEbookPaymentEvent('Email sending failed', ['error' => $e->getMessage()]);
    }
}
?>
