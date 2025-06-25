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
        // Production SMTP settings
        $mail->Host = 'mail.elevenplusenglish.co.uk';
        $mail->SMTPAuth = true;
        $mail->Port = 465;
        $mail->Username = 'success@elevenplusenglish.co.uk';
        $mail->Password = 'Monday@123';
        $mail->SMTPSecure = 'ssl';
        $mail->setFrom('success@elevenplusenglish.co.uk', 'Success At 11 Plus English');
        $mail->addAddress($student_data['email'], $student_data['fname'] . ' ' . $student_data['surname']);
        $mail->addReplyTo('success@elevenplusenglish.co.uk', 'Success At 11 Plus English');
        $mail->isHTML(true);
        $mail->Subject = 'E-Book Purchase Confirmation & Invoice - Success At 11 Plus English';
        $purchaseDate = date('F j, Y');
        $emailBody = '
        <html>
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>E-Book Purchase Confirmation</title>
        <style>
            body { background: linear-gradient(135deg, #1e40af 0%, #f59e0b 100%); margin: 0; padding: 0; font-family: Segoe UI, Arial, sans-serif; }
            .email-container { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 1rem; box-shadow: 0 8px 32px rgba(30,64,175,0.10); overflow: hidden; }
            .header { background: #16a34a; color: #fff; padding: 2.5rem 2rem 1.5rem; text-align: center; }
            .header-flex { display: flex; flex-direction: column; align-items: center; justify-content: center; }
            .header-icon {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 80px;
                height: 80px;
                background: rgba(255,255,255,0.18);
                border-radius: 50%;
                margin-bottom: 1.2rem;
            }
            .header-icon svg {
                width: 2.5rem;
                height: 2.5rem;
                color: #fff;
                display: block;
            }
            .header-title {
                font-size: 1.7rem;
                font-weight: 700;
                margin-bottom: 0.3rem;
            }
            .header-success {
                font-size: 1.15rem;
                font-weight: 500;
                opacity: 0.95;
                margin-bottom: 0;
            }
            .body { padding: 2.5rem 2rem; color: #222; }
            .details { background: #f8fafc; border-radius: 0.7rem; padding: 1.2rem 1.5rem; margin: 1.5rem 0; }
            .invoice { background: #f3f4f6; border-radius: 0.7rem; padding: 1.2rem 1.5rem; margin: 1.5rem 0; border: 1px solid #e5e7eb; }
            .invoice h3 { color: #1e40af; margin-top: 0; }
            .invoice-table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
            .invoice-table th, .invoice-table td { padding: 0.5rem 0.7rem; text-align: left; border-bottom: 1px solid #e5e7eb; }
            .invoice-table th { background: #f8fafc; color: #1e40af; font-weight: 600; }
            .invoice-table td:last-child, .invoice-table th:last-child { text-align: right; }
            .cta-btn { display: inline-block; background: #1e40af; color: #fff; text-decoration: none; padding: 0.8rem 2rem; border-radius: 0.5rem; font-weight: 600; margin-top: 1.5rem; }
            .footer { text-align: center; color: #888; font-size: 0.95rem; padding: 1.5rem 2rem 2rem; }
            .footer a { color: #1e40af; text-decoration: none; }
            @media (max-width: 600px) { .email-container, .body, .footer { padding: 1rem !important; } }
        </style>
        </head>
        <body>
        <div class="email-container">
            <div class="header">
                <div class="header-flex">
                    <div class="header-icon">
                        <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Success">
                            <circle cx="16" cy="16" r="16" fill="#16a34a"/>
                            <path d="M10 17.5L15 22L22 12" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="header-title">E-Book Purchase Confirmation</div>
                    <div class="header-success">Payment Successful</div>
                </div>
            </div>
            <div class="body">
                <p style="font-size:1.1rem;">Dear <strong>' . htmlspecialchars($student_data['fname'] . ' ' . $student_data['surname']) . '</strong>,</p>
                <p>Thank you for your e-book purchase! Here are your details:</p>
                <div class="details">
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
                    <a href="https://elevenplusenglish.co.uk/StudentDashboard/ebooks.php" 
                       style="background: #1e40af; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; display: inline-block;">
                        Access My E-Books
                    </a>
                </div>
                <p>If you have any questions or need assistance, please don\'t hesitate to contact us.</p>
                <p>Best regards,<br>
                <strong>The Success At 11 Plus English Team</strong><br>
                <a href="https://elevenplusenglish.co.uk">elevenplusenglish.co.uk</a></p>
            </div>
            <div class="footer">
                <p>Need help? Contact us at <a href="mailto:success@elevenplusenglish.co.uk">success@elevenplusenglish.co.uk</a></p>
                <p style="margin-top:1.2rem;">&copy; ' . date('Y') . ' Success At 11 Plus English</p>
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
