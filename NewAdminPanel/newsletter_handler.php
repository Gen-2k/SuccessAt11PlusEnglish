<?php
// Prevent any output before JSON response
ob_start();

// Production error settings
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

require_once 'config/config.php';
require_once 'includes/auth.php';

// Clean any previous output
if (ob_get_length()) ob_clean();

// Set JSON response headers
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache, must-revalidate');

// Security and session checks
if (!isset($_SESSION)) session_start();
checkAdminAuth();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    respondWithJson(['success' => false, 'message' => 'Access denied. Administrator privileges required.']);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['action']) || $_POST['action'] !== 'send_newsletter') {
    respondWithJson(['success' => false, 'message' => 'Invalid request method or action.']);
}

// Debug mode for testing
if (isset($_POST['debug']) && $_POST['debug'] === 'true') {
    respondWithJson([
        'success' => true, 
        'message' => 'Newsletter system is operational',
        'debug_info' => [
            'timestamp' => date('Y-m-d H:i:s'),
            'memory_usage' => memory_get_usage(true),
            'php_version' => PHP_VERSION
        ]
    ]);
}

/**
 * Clean JSON response helper
 */
function respondWithJson($data) {
    if (ob_get_length()) ob_clean();
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    ob_end_flush();
    exit;
}

/**
 * Handle file upload with validation
 */
function handleFileUpload() {
    if (!isset($_FILES['newsletterFile']) || $_FILES['newsletterFile']['error'] !== UPLOAD_ERR_OK) {
        return ['success' => true, 'path' => '', 'name' => ''];
    }
    
    $uploadDir = '../uploads/newsletter/';
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            return ['success' => false, 'message' => 'Unable to create upload directory.'];
        }
    }
    
    // Ensure directory is writable
    if (!is_writable($uploadDir)) {
        return ['success' => false, 'message' => 'Upload directory is not writable.'];
    }
    
    $fileName = $_FILES['newsletterFile']['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExtensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
    
    if (!in_array($fileExtension, $allowedExtensions)) {
        return ['success' => false, 'message' => 'File type not supported. Please use: PDF, DOC, DOCX, JPG, JPEG, or PNG files.'];
    }
    
    if ($_FILES['newsletterFile']['size'] > 5 * 1024 * 1024) {
        return ['success' => false, 'message' => 'File is too large. Please use files smaller than 5MB.'];
    }
    
    // Create unique filename with timestamp to avoid conflicts
    $timestamp = date('Y-m-d_H-i-s');
    $uniqueFileName = 'newsletter_' . $timestamp . '_' . uniqid() . '_' . $fileName;
    $attachmentPath = $uploadDir . $uniqueFileName;
    
    if (!move_uploaded_file($_FILES['newsletterFile']['tmp_name'], $attachmentPath)) {
        return ['success' => false, 'message' => 'Failed to process file upload. Please try again.'];
    }
    
    // Verify file was uploaded successfully and is readable
    if (!file_exists($attachmentPath) || !is_readable($attachmentPath)) {
        return ['success' => false, 'message' => 'File upload verification failed. Please try again.'];
    }
    
    return ['success' => true, 'path' => $attachmentPath, 'name' => $fileName];
}

/**
 * Get newsletter subscribers from database
 */
function getNewsletterSubscribers() {
    $conn = getDBConnection();
    if (!$conn) {
        return ['success' => false, 'message' => 'Database connection unavailable. Please try again later.'];
    }
    
    $result = mysqli_query($conn, "SELECT email, fname, lname FROM newsletter ORDER BY fname, lname");
    if (!$result) {
        mysqli_close($conn);
        return ['success' => false, 'message' => 'Unable to retrieve subscriber list. Please contact support.'];
    }
    
    $subscribers = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $subscribers[] = $row;
    }
    
    mysqli_close($conn);
    
    if (empty($subscribers)) {
        return ['success' => false, 'message' => 'No newsletter subscribers found. Please add subscribers first.'];
    }
    
    return ['success' => true, 'subscribers' => $subscribers];
}

/**
 * Create PHPMailer instance with optimized settings
 */
function createMailer() {
    $phpmailerPath = '../mail/PHPMailerAutoload.php';
    $phpmailerClass = '../mail/class.phpmailer.php';
    $smtpClass = '../mail/class.smtp.php';
    $mailConfig = require __DIR__ . '/../mail/mail_config.php';
    if (!file_exists($phpmailerPath) || !file_exists($phpmailerClass) || !file_exists($smtpClass)) {
        return ['success' => false, 'message' => 'Email system not properly configured. Please contact administrator.'];
    }
    require_once $phpmailerPath;
    require_once $phpmailerClass;
    require_once $smtpClass;
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = $mailConfig['host'];
    $mail->SMTPAuth = true;
    $mail->Port = $mailConfig['port'];
    $mail->Username = $mailConfig['username'];
    $mail->Password = $mailConfig['password'];
    $mail->SMTPSecure = $mailConfig['smtp_secure'];
    $mail->SMTPKeepAlive = true; // Keep connection alive for multiple emails
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    // Performance optimizations
    $mail->CharSet = $mailConfig['charset'];
    $mail->Encoding = 'base64';
    $mail->isHTML($mailConfig['is_html']);
    // Set sender and reply-to for all newsletters
    $mail->setFrom($mailConfig['from_email'], $mailConfig['from_name']);
    $mail->addReplyTo($mailConfig['reply_to_email'], $mailConfig['reply_to_name']);
    // DKIM settings (commented out for now)
    // if (isset($mailConfig['dkim_domain'])) {
    //     $mail->DKIM_domain = $mailConfig['dkim_domain'];
    //     $mail->DKIM_private = $mailConfig['dkim_private'];
    //     $mail->DKIM_selector = $mailConfig['dkim_selector'];
    //     $mail->DKIM_passphrase = $mailConfig['dkim_passphrase'];
    //     $mail->DKIM_identity = $mailConfig['dkim_identity'];
    //     $mail->DKIM_copyHeaderFields = $mailConfig['dkim_copyHeaderFields'];
    // }
    return ['success' => true, 'mailer' => $mail];
}

try {
    // Validate input data
    $title = trim($_POST['newsletterTitle'] ?? '');
    $message = trim($_POST['newsletterMessage'] ?? '');
    
    if (empty($title) || empty($message)) {
        respondWithJson(['success' => false, 'message' => 'Please provide both a title and message for your newsletter.']);
    }
      // Handle file upload
    $uploadResult = handleFileUpload();
    if (!$uploadResult['success']) {
        respondWithJson($uploadResult);
    }
    
    $attachmentPath = $uploadResult['path'];
    $attachmentName = $uploadResult['name'];
    
    // Log attachment processing
    if ($attachmentPath && $attachmentName) {
        error_log("Newsletter attachment uploaded: {$attachmentName} -> {$attachmentPath}");
    }
    
    // Get subscribers
    $subscriberResult = getNewsletterSubscribers();
    if (!$subscriberResult['success']) {
        if ($attachmentPath && file_exists($attachmentPath)) unlink($attachmentPath);
        respondWithJson($subscriberResult);
    }
    
    $subscribers = $subscriberResult['subscribers'];
    $totalSubscribers = count($subscribers);
    
    // Create mailer instance
    $mailerResult = createMailer();
    if (!$mailerResult['success']) {
        if ($attachmentPath && file_exists($attachmentPath)) unlink($attachmentPath);
        respondWithJson($mailerResult);
    }
      $mail = $mailerResult['mailer'];
    
    // Prepare attachment info for email template
    $attachmentInfo = '';
    if ($attachmentPath && $attachmentName) {
        $attachmentInfo = '<div style="background-color: #e8f4fd; border-left: 4px solid #0066cc; padding: 15px; margin: 20px 0; border-radius: 5px;">
            <p style="margin: 0; color: #0066cc;">
                <i class="fas fa-paperclip"></i> <strong>Attachment Included:</strong> ' . htmlspecialchars($attachmentName) . '
            </p>
            <p style="margin: 5px 0 0 0; color: #555; font-size: 14px;">
                Please find the attached file with this newsletter.
            </p>
        </div>';
    }
    
    // Prepare email content template
    $htmlTemplate = '
    <html>
    <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto;">
        <div style="padding: 20px;">
            <div style="text-align: center; margin-bottom: 30px;">
                <h1 style="color: #6e20a7; margin: 0;">Success At 11 Plus English</h1>
                <p style="color: #666; margin: 5px 0;">Newsletter</p>
            </div>
            
            <div style="background: linear-gradient(135deg, #6e20a7 0%, #8b5fbf 100%); color: white; padding: 20px; border-radius: 10px; margin: 20px 0;">
                <h2 style="margin: 0 0 15px 0; font-size: 24px;">' . htmlspecialchars($title) . '</h2>
                <div style="font-size: 16px; line-height: 1.6;">
                    ' . nl2br(htmlspecialchars($message)) . '
                </div>
            </div>
            
            ' . $attachmentInfo . '
            
            <div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <p style="margin: 0; color: #555;">
                    <strong>Dear {SUBSCRIBER_NAME},</strong>
                </p>
                <p style="color: #555; margin: 15px 0 0 0;">
                    Thank you for being part of our learning community. We hope this newsletter helps you on your 11 Plus preparation journey!
                </p>
            </div>
            
            <div style="margin-top: 30px; padding: 20px; border-top: 2px solid #6e20a7; text-align: center;">
                <p style="margin: 0; color: #6e20a7; font-weight: bold;">Best regards,</p>
                <p style="margin: 5px 0; color: #666;">The Success At 11 Plus English Team</p>
                <p style="margin: 15px 0 5px 0;">
                    <a href="mailto:info@successat11plusenglish.com" style="color: #6e20a7; text-decoration: none;">
                        📧 info@successat11plusenglish.com
                    </a>
                </p>
                <p style="margin: 15px 0 0 0; font-size: 12px;">
                    <a href="' . (defined('BASE_URL') ? BASE_URL : 'http://localhost/SuccessAt11PlusEnglish/') . 'unsubscribe.php?email={SUBSCRIBER_EMAIL_ENCODED}" 
                       style="color: #999; text-decoration: underline;">Unsubscribe from newsletters</a>
                </p>
            </div>
        </div>
    </body>
    </html>';
      // Set common email properties
    $mail->setFrom('success@elevenplusenglish.co.uk', 'Success At 11 Plus English');
    $mail->addReplyTo('success@elevenplusenglish.co.uk', 'Success At 11 Plus English');
    $mail->Subject = 'Newsletter: ' . $title;
    
    $sentCount = 0;
    $failedCount = 0;
    $errors = [];
    $startTime = microtime(true);
      // Send emails with optimized loop
    foreach ($subscribers as $index => $subscriber) {
        try {
            // Clear previous addresses and attachments but keep SMTP connection
            $mail->clearAddresses();
            $mail->clearAttachments();
              // Add attachment if present for each email
            if ($attachmentPath && file_exists($attachmentPath)) {
                if (!$mail->addAttachment($attachmentPath, $attachmentName)) {
                    error_log("Failed to add attachment {$attachmentName} for {$subscriber['email']}: " . $mail->ErrorInfo);
                }
            } else if ($attachmentPath) {
                error_log("Attachment file not found: {$attachmentPath}");
            }
            
            // Set recipient
            $subscriberName = trim(($subscriber['fname'] ?? '') . ' ' . ($subscriber['lname'] ?? ''));
            if (empty($subscriberName)) $subscriberName = 'Valued Subscriber';
            
            $mail->addAddress($subscriber['email'], $subscriberName);
            
            // Personalize email content
            $personalizedHtml = str_replace(
                ['{SUBSCRIBER_NAME}', '{SUBSCRIBER_EMAIL_ENCODED}'],
                [htmlspecialchars($subscriberName), base64_encode($subscriber['email'])],
                $htmlTemplate
            );
            
            $mail->Body = $personalizedHtml;
            
            // Send email
            if ($mail->send()) {
                $sentCount++;
            } else {
                $failedCount++;
                $errors[] = "Failed to send to {$subscriber['email']}: " . $mail->ErrorInfo;
                error_log("Newsletter send failed for {$subscriber['email']}: " . $mail->ErrorInfo);
            }
            
            // Small delay to prevent overwhelming SMTP server
            if (($index + 1) % 10 === 0) {
                usleep(100000); // 0.1 second pause every 10 emails
            }
            
        } catch (Exception $e) {
            $failedCount++;
            $errorMsg = "Error sending to {$subscriber['email']}: " . $e->getMessage();
            $errors[] = $errorMsg;
            error_log("Newsletter error: " . $errorMsg);
        }
    }
    
    // Close SMTP connection
    $mail->smtpClose();
    
    $endTime = microtime(true);
    $duration = round($endTime - $startTime, 2);
    
    // Clean up attachment file
    if ($attachmentPath && file_exists($attachmentPath)) {
        unlink($attachmentPath);
    }
      // Prepare success message
    $attachmentInfo = '';
    if ($attachmentPath && $attachmentName) {
        $attachmentInfo = " with attachment '{$attachmentName}'";
    }
    
    if ($sentCount > 0) {
        if ($failedCount === 0) {
            $successMessage = "🎉 Newsletter{$attachmentInfo} successfully delivered to all {$sentCount} subscribers in {$duration} seconds!";
        } else {
            $successMessage = "📧 Newsletter{$attachmentInfo} sent to {$sentCount} of {$totalSubscribers} subscribers in {$duration} seconds. {$failedCount} delivery issues occurred.";
        }
        
        respondWithJson([
            'success' => true, 
            'message' => $successMessage,
            'stats' => [
                'sent' => $sentCount,
                'failed' => $failedCount,
                'total' => $totalSubscribers,
                'duration' => $duration . 's',
                'attachment' => !empty($attachmentName) ? $attachmentName : null
            ]
        ]);
    } else {
        respondWithJson([
            'success' => false, 
            'message' => "❌ Unable to deliver newsletter to any subscribers. Please check your email configuration and try again."
        ]);
    }} catch (Exception $e) {
    // Clean up any uploaded files
    if (isset($attachmentPath) && $attachmentPath && file_exists($attachmentPath)) {
        unlink($attachmentPath);
    }
    
    // Log detailed error for debugging
    $errorDetails = [
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => $e->getTraceAsString()
    ];
    error_log("Newsletter system error: " . json_encode($errorDetails));
    
    // Return user-friendly error message
    respondWithJson([
        'success' => false, 
        'message' => '⚠️ An unexpected error occurred while processing your newsletter. Please try again, or contact support if the problem persists.'
    ]);
}

// Ensure clean shutdown and memory cleanup
if (ob_get_length()) ob_end_clean();
?>