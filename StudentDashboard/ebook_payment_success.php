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

$stripe = new \Stripe\StripeClient("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");

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
        $mailConfig = require __DIR__ . '/../mail/mail_config.php';
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $mailConfig['host'];
        $mail->SMTPAuth = true;
        $mail->Port = $mailConfig['port'];
        $mail->Username = $mailConfig['username'];
        $mail->Password = $mailConfig['password'];
        $mail->SMTPSecure = $mailConfig['smtp_secure'];
        $mail->setFrom($mailConfig['from_email'], $mailConfig['from_name']);
        $mail->addAddress($student_data['email'], $student_data['fname'] . ' ' . $student_data['surname']);
        $mail->addReplyTo($mailConfig['reply_to_email'], $mailConfig['reply_to_name']);
        $mail->isHTML($mailConfig['is_html']);
        $mail->CharSet = $mailConfig['charset'];
        $mail->Subject = 'E-Book Purchase Confirmation & Invoice - Success At 11 Plus English';
        $purchaseDate = date('F j, Y');
        $emailBody = '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E-Book Purchase Confirmation</title>
  <style>
    body { margin:0; padding:0; background:#f7f7f7; }
    .wrapper { width:100%; table-layout:fixed; background:#f7f7f7; padding:30px 0; }
    .main { background:#ffffff; width:100%; max-width:650px; margin:0 auto; border-radius:8px; overflow:hidden; }
    .header { background: linear-gradient(90deg, #1E40AF 0%, #F59E0B 100%); padding:24px; text-align:center; }
    .header h1 { margin:0; font-family:\'Source Serif Pro\', serif; font-size:1.8rem; color:#ffffff; }
    .header p { margin:8px 0 0; font-family:Varela Round, sans-serif; font-size:1rem; color:#e0e0e0; }
    .content { padding:28px; font-family:Varela Round, sans-serif; color:#212529; line-height:1.6; }
    .box { background:#f8f9fa; border-left:4px solid #F59E0B; padding:16px 20px; margin:20px 0; border-radius:4px; }
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
        <h1>E-Book Purchase Confirmation</h1>
        <p>Payment Successful</p>
      </div>
      <div class="content">
        <p style="font-size:1.1rem;">Dear <strong>' . htmlspecialchars($student_data['fname'] . ' ' . $student_data['surname']) . '</strong>,</p>
        <p>Thank you for your e-book purchase! Here are your details:</p>
        <div class="box">
          <h3 style="color:#1e40af;margin-top:0;">E-Book Details</h3>
          <p><strong>Title:</strong> ' . htmlspecialchars($ebook_data['title']) . '</p>
          <p><strong>Class:</strong> ' . htmlspecialchars(ucfirst(str_replace('year', 'Year ', $ebook_data['class']))) . '</p>
          <p><strong>Module:</strong> ' . htmlspecialchars($ebook_data['module']) . '</p>
        </div>
        <div class="invoice">
          <h3>Invoice</h3>
          <table class="invoice-table">
            <tr><th>Description</th><th>Amount</th></tr>
            <tr><td>' . htmlspecialchars($ebook_data['title']) . ' (' . htmlspecialchars($ebook_data['module']) . ')</td><td>£' . number_format($ebook_data['price'], 2) . '</td></tr>
            <tr><td style="font-weight:600;">Total Paid</td><td style="font-weight:600;">£' . number_format($ebook_data['price'], 2) . '</td></tr>
          </table>
          <p style="margin:0.7rem 0 0 0;"><strong>Transaction ID:</strong> ' . htmlspecialchars($transaction_id) . '</p>
          <p style="margin:0;"><strong>Purchase Date:</strong> ' . htmlspecialchars($purchaseDate) . '</p>
        </div>
        <p>You can now access your e-book by logging into your student dashboard and visiting the E-Books section.</p>
        <div style="text-align: center; margin: 30px 0;">
          <a href="https://elevenplusenglish.co.uk/StudentDashboard/ebooks.php" class="cta-btn">Access My E-Books</a>
        </div>
        <p>If you have any questions or need assistance, please don\'t hesitate to contact us.</p>
        <p>Best regards,<br>
        <strong>The Success At 11 Plus English Team</strong><br>
        <a href="https://elevenplusenglish.co.uk">elevenplusenglish.co.uk</a></p>
      </div>
      <div class="footer">
        <p>Need help? Contact us at <a href="mailto:success@elevenplusenglish.co.uk">success@elevenplusenglish.co.uk</a></p>
        <p style="margin-top:1.2rem;">&copy; ' . date('Y') . ' Success At 11 Plus English. All rights reserved.</p>
      </div>
    </div>
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
