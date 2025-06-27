<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Check if this is an AJAX request
$isAjaxRequest = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

// Log function to help debug issues
function log_error($message) {
    $logFile = dirname(__FILE__) . '/error_log.txt';
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[{$timestamp}] {$message}\n", FILE_APPEND);
}

log_error("Form submission received - POST data: " . print_r($_POST, true));
log_error("Is AJAX request: " . ($isAjaxRequest ? 'Yes' : 'No'));

// Function to output response based on request type
function outputResponse($status, $message, $redirectUrl = '') {
    global $isAjaxRequest;
    
    $_SESSION['status'] = $message;
    $_SESSION['status_code'] = $status;
    
    if ($isAjaxRequest) {
        // Clear any previous output that might break JSON
        if (ob_get_length()) ob_clean();
        
        header('Content-Type: application/json');
        echo json_encode([
            'status' => $status,
            'message' => $message,
            'redirect' => $redirectUrl
        ]);
        exit;
    } else {
        if ($status === 'success' && isset($_POST["eqTry"])) {
            // For successful trial class submissions, use the thank-you page
            $_SESSION['form_submitted'] = true;
            header("Location: thank-you.php");
            exit;
        } elseif (!empty($redirectUrl)) {
            header("Location: $redirectUrl");
            exit;
        }
    }
}

// Sanitize input function
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// Check if form was submitted
if (isset($_POST["eqName"]) || isset($_POST["eqFTC"]) || isset($_POST["eqTry"])) {
    log_error("Form submission detected - processing now");
    
    // Determine the redirect URL based on form submission type
    $redirectUrl = 'index.php'; // Default fallback
    if(isset($_POST["eqTry"])) {
        $redirectUrl = 'tryfreeform.php';
    }

    // Validate required fields
    $requiredFields = ["eqName", "eqMail", "eqPhone", "eqApply"];
    $missingFields = [];
    $invalidFields = [];
    
    // Check for missing fields
    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            $missingFields[] = $field;
        }
    }
    
    if (!empty($missingFields)) {
        log_error("Missing required fields: " . implode(", ", $missingFields));
        outputResponse('error', 'Please fill in all required fields: ' . implode(", ", $missingFields), $redirectUrl);
        exit;
    }
    
    // Validate email format
    if (!filter_var($_POST["eqMail"], FILTER_VALIDATE_EMAIL)) {
        $invalidFields[] = "eqMail";
        log_error("Invalid email format: " . $_POST["eqMail"]);
    }
    
    // Validate phone number (simple check for length)
    if (strlen($_POST["eqPhone"]) < 10) {
        $invalidFields[] = "eqPhone";
        log_error("Invalid phone number format: " . $_POST["eqPhone"]);
    }
    
    if (!empty($invalidFields)) {
        log_error("Invalid fields: " . implode(", ", $invalidFields));
        outputResponse('error', 'Please correct the invalid information: ' . implode(", ", $invalidFields), $redirectUrl);
        exit;
    }

    // Sanitize all inputs
    $enqName = sanitizeInput($_POST["eqName"]);
    $enqMail = sanitizeInput($_POST["eqMail"]);
    $enqPhone = sanitizeInput($_POST["eqPhone"]);
    $enqApply = sanitizeInput($_POST["eqApply"]);
    $enqModule = isset($_POST["eqModule"]) ? sanitizeInput($_POST["eqModule"]) : '';
    $enqMsg = isset($_POST["eqMsg"]) ? sanitizeInput($_POST["eqMsg"]) : '';

    log_error("Processing form data: Name=$enqName, Email=$enqMail, Phone=$enqPhone, Apply=$enqApply, Module=$enqModule");

    // -------------------------------------------------------------------------
    // EMAIL NOTIFICATION: Admin & User Auto-Response (Robust, Always Attempt User Email)
    // -------------------------------------------------------------------------
    require './mail/PHPMailerAutoload.php';
    require './mail/class.phpmailer.php';
    require './mail/class.smtp.php';

    // Load mail config
    $mailConfig = require __DIR__ . '/mail/mail_config.php';
    
    // Include unsubscribe helper
    require_once __DIR__ . '/includes/unsubscribe_helper.php';

    $adminMailSuccess = false;
    $userMailSuccess = false;
    $adminMailError = '';
    $userMailError = '';

    // =============================
    // 1. Send Auto-Response to User (always attempt)
    // =============================
    if (isset($_POST["eqTry"])) {
        try {
            log_error("Attempting to send auto-response email to: " . $enqMail);
            
            // User auto-response
            $autoResponse = new PHPMailer();
            $autoResponse->isSMTP();
            $autoResponse->SMTPDebug = 0; // 0 = off, 1 = client messages, 2 = client and server messages
            $autoResponse->Host       = $mailConfig['host'];
            $autoResponse->SMTPAuth   = true;
            $autoResponse->Username   = $mailConfig['username'];
            $autoResponse->Password   = $mailConfig['password'];
            $autoResponse->SMTPSecure = $mailConfig['smtp_secure'];
            $autoResponse->Port       = $mailConfig['port'];
            $autoResponse->setFrom($mailConfig['from_email'], $mailConfig['from_name']);
            $autoResponse->addReplyTo($mailConfig['reply_to_email'], $mailConfig['reply_to_name']);
            $autoResponse->addAddress($enqMail, $enqName); // Send to the user who submitted the form
            $autoResponse->isHTML($mailConfig['is_html']);
            $autoResponse->CharSet = $mailConfig['charset'];
            
            log_error("PHPMailer configured for auto-response. Recipients: " . $enqMail);
            // DKIM settings (commented out for now)
            // if (isset($mailConfig['dkim_domain'])) {
            //     $autoResponse->DKIM_domain = $mailConfig['dkim_domain'];
            //     $autoResponse->DKIM_private = $mailConfig['dkim_private'];
            //     $autoResponse->DKIM_selector = $mailConfig['dkim_selector'];
            //     $autoResponse->DKIM_passphrase = $mailConfig['dkim_passphrase'];
            //     $autoResponse->DKIM_identity = $mailConfig['dkim_identity'];
            //     $autoResponse->DKIM_copyHeaderFields = $mailConfig['dkim_copyHeaderFields'];
            // }
            $autoResponse->Subject = 'We Received Your Trial Class Application';
            $autoResponse->Body = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
              <meta charset="UTF-8">
              <meta name="viewport" content="width=device-width, initial-scale=1.0">
              <title>Trial Class Application Received</title>
              <style>
                body { margin:0; padding:0; background:#f7f7f7; font-family: Arial, sans-serif; }
                .wrapper { width:100%; table-layout:fixed; background:#f7f7f7; padding:30px 0; }
                .main { background:#ffffff; width:100%; max-width:650px; margin:0 auto; border-radius:8px; overflow:hidden; }
                .header { background: linear-gradient(90deg, #1E40AF 0%, #F59E0B 100%); padding:24px; text-align:center; }
                .header h1 { margin:0; font-family:\'Arial\', sans-serif; font-size:1.8rem; color:#ffffff; }
                .header p { margin:8px 0 0; font-family:Arial, sans-serif; font-size:1rem; color:#e0e0e0; }
                .content { padding:28px; font-family:Arial, sans-serif; color:#212529; line-height:1.6; }
                .footer { background:#ffffff; text-align:center; padding:16px; font-size:12px; color:#888888; }
                .footer a { color:#1E40AF; text-decoration:none; }
                @media(max-width:600px) { .content{padding:20px;} .header h1{font-size:1.5rem;} }
              </style>
            </head>
            <body>
              <div class="wrapper">
                <div class="main">
                  <div class="header">
                    <h1>Thank You For Your Application</h1>
                    <p>Trial Class Request Received</p>
                  </div>
                  <div class="content">
                    <p>Dear ' . htmlspecialchars($enqName) . ',</p>
                    <p>Thank you for your interest in Success at 11 Plus English. Your trial class application has been received.</p>
                    <p><strong>Your Application Details:</strong></p>
                    <ul style="padding-left:18px;">
                        <li><strong>Name:</strong> ' . htmlspecialchars($enqName) . '</li>
                        <li><strong>Email:</strong> ' . htmlspecialchars($enqMail) . '</li>
                        <li><strong>Phone:</strong> ' . htmlspecialchars($enqPhone) . '</li>
                        <li><strong>Year Group:</strong> ' . htmlspecialchars($enqApply) . '</li>
                        ' . (!empty($enqModule) ? '<li><strong>Module Interest:</strong> ' . htmlspecialchars($enqModule) . '</li>' : '') . '
                        ' . (!empty($enqMsg) ? '<li><strong>Message:</strong> ' . nl2br(htmlspecialchars($enqMsg)) . '</li>' : '') . '
                    </ul>
                    <p>We will be in touch with further details soon.</p>
                    <p>If you have any questions, feel free to reply to this email.</p>
                  </div>
                  ' . generateUnsubscribeFooter($enqMail) . '
                </div>
              </div>
            </body>
            </html>';
$autoResponse->AltBody = 'Thank you for your interest in Success at 11 Plus English. Your trial class application has been received.\n\nApplication Details:\n- Name: ' . $enqName . '\n- Email: ' . $enqMail . '\n- Phone: ' . $enqPhone . '\n- Year Group: ' . $enqApply . (!empty($enqModule) ? '\n- Module Interest: ' . $enqModule : '') . (!empty($enqMsg) ? '\n- Message: ' . $enqMsg : '') . '\nWe will be in touch with further details soon.';
            if ($autoResponse->send()) {
                $userMailSuccess = true;
                log_error('Auto-response email sent to user: ' . $enqMail);
            } else {
                $userMailError = $autoResponse->ErrorInfo;
                log_error('Auto-response could not be sent: ' . $userMailError);
            }
        } catch (Exception $e) {
            $userMailError = $e->getMessage();
            log_error('Auto-response exception: ' . $userMailError);
        }
    }

    // =============================
    // 2. Send Admin Notification (always attempt)
    // =============================
    try {
        log_error("Attempting to send admin notification email");
        
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug = 0; // 0 = off, 1 = client messages, 2 = client and server messages
        $mail->Host       = $mailConfig['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $mailConfig['username'];
        $mail->Password   = $mailConfig['password'];
        $mail->SMTPSecure = $mailConfig['smtp_secure'];
        $mail->Port       = $mailConfig['port'];
        $mail->setFrom($mailConfig['from_email'], $mailConfig['from_name']);
        $mail->addReplyTo($mailConfig['reply_to_email'], $mailConfig['reply_to_name']);
        $mail->addAddress($mailConfig['from_email'], 'Success At 11 Plus English Admin'); // Send to admin
        $mail->isHTML($mailConfig['is_html']);
        $mail->CharSet = $mailConfig['charset'];
        
        log_error("Admin PHPMailer configured. Recipients: " . $mailConfig['from_email']);
        // DKIM settings (commented out for now)
        // if (isset($mailConfig['dkim_domain'])) {
        //     $mail->DKIM_domain = $mailConfig['dkim_domain'];
        //     $mail->DKIM_private = $mailConfig['dkim_private'];
        //     $mail->DKIM_selector = $mailConfig['dkim_selector'];
        //     $mail->DKIM_passphrase = $mailConfig['dkim_passphrase'];
        //     $mail->DKIM_identity = $mailConfig['dkim_identity'];
        //     $mail->DKIM_copyHeaderFields = $mailConfig['dkim_copyHeaderFields'];
        // }
        if (isset($_POST["eqFTC"])) {
            $mail->Subject = 'Enquiry for TRY a Free Class ENQUIRY';
        } else {
            $mail->Subject = 'Trial Class Application';
        }
        $mail->Body = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>New Enquiry Received</title>
          <style>
            body { margin:0; padding:0; background:#f7f7f7; font-family: Arial, sans-serif; }
            .wrapper { width:100%; table-layout:fixed; background:#f7f7f7; padding:30px 0; }
            .main { background:#ffffff; width:100%; max-width:650px; margin:0 auto; border-radius:8px; overflow:hidden; }
            .header { background: linear-gradient(90deg, #1E40AF 0%, #F59E0B 100%); padding:24px; text-align:center; }
            .header h1 { margin:0; font-family:Arial, sans-serif; font-size:1.8rem; color:#ffffff; }
            .header p { margin:8px 0 0; font-family:Arial, sans-serif; font-size:1rem; color:#e0e0e0; }
            .content { padding:28px; font-family:Arial, sans-serif; color:#212529; line-height:1.6; }
            .box { background:#f8f9fa; border-left:4px solid #F59E0B; padding:16px 20px; margin:20px 0; border-radius:4px; }
            .footer { background:#ffffff; text-align:center; padding:16px; font-size:12px; color:#888888; }
            .footer a { color:#1E40AF; text-decoration:none; }
            @media(max-width:600px) { .content{padding:20px;} .header h1{font-size:1.5rem;} }
          </style>
        </head>
        <body>
          <div class="wrapper">
            <div class="main">
              <div class="header">
                <h1>New Enquiry Received</h1>
                <p>Trial Class or Free Class Request</p>
              </div>
              <div class="content">
                <div class="box">
                  <p><strong>Name:</strong> ' . htmlspecialchars($enqName) . '</p>
                  <p><strong>Phone:</strong> ' . htmlspecialchars($enqPhone) . '</p>
                  <p><strong>Email:</strong> ' . htmlspecialchars($enqMail) . '</p>
                  <p><strong>Year Group:</strong> ' . htmlspecialchars($enqApply) . '</p>
                  ' . (!empty($enqModule) ? '<p><strong>Module Interest:</strong> ' . htmlspecialchars($enqModule) . '</p>' : '') . '
                  ' . (!empty($enqMsg) ? '<p><strong>Message:</strong> ' . nl2br(htmlspecialchars($enqMsg)) . '</p>' : '') . '
                </div>
                <p style="font-size: 12px; color: #777; margin-top: 30px;">This message was sent from the Success at 11 Plus English website.</p>
              </div>
              <div class="footer">
                &copy; ' . date('Y') . ' Success at 11 Plus English. All rights reserved.<br>
                <a href="mailto:' . htmlspecialchars($enqMail) . '">Reply to Enquirer</a>
              </div>
            </div>
          </div>
        </body>
        </html>';
        $mail->AltBody = 'Name: ' . $enqName . "\n" .
                        'Phone: ' . $enqPhone . "\n" .
                        'Email: ' . $enqMail . "\n" .
                        'Year Group: ' . $enqApply . "\n" .
                        (!empty($enqModule) ? 'Module Interest: ' . $enqModule . "\n" : '') .
                        (!empty($enqMsg) ? 'Message: ' . $enqMsg : '');
        if ($mail->send()) {
            $adminMailSuccess = true;
            log_error('Admin notification email sent.');
        } else {
            $adminMailError = $mail->ErrorInfo;
            log_error('Admin notification email failed: ' . $adminMailError);
        }
    } catch (Exception $e) {
        $adminMailError = $e->getMessage();
        log_error('Admin notification exception: ' . $adminMailError);
    }

    // =============================
    // 3. Output Response (show user mail status if trial form)
    // =============================
    if (isset($_POST["eqTry"])) {
        // For trial class applications, we always show success to the user
        // but provide different messaging based on email delivery status
        if ($userMailSuccess && $adminMailSuccess) {
            outputResponse('success', 'Your application has been submitted successfully! We will contact you shortly. A confirmation email has been sent to your inbox.', $redirectUrl);
        } elseif ($userMailSuccess && !$adminMailSuccess) {
            outputResponse('success', 'Your application has been submitted successfully! We will contact you shortly. A confirmation email has been sent to your inbox.', $redirectUrl);
            log_error('Trial form submitted successfully but admin notification failed');
        } elseif (!$userMailSuccess && $adminMailSuccess) {
            outputResponse('success', 'Your application has been submitted successfully! We will contact you shortly. However, we could not send a confirmation email to your address - please check your email or contact us directly.', $redirectUrl);
            log_error('Trial form submitted successfully but user confirmation failed');
        } else {
            // Both emails failed, but still show success to user
            outputResponse('success', 'Your application has been submitted! However, there may have been an issue with our email system. We will contact you shortly using the details you provided.', $redirectUrl);
            log_error('Trial form submitted but both emails failed - User: ' . $userMailError . ', Admin: ' . $adminMailError);
        }
    } else {
        // For other forms, require admin email to succeed
        if ($adminMailSuccess) {
            outputResponse('success', 'Your application has been submitted successfully! We will contact you shortly.', $redirectUrl);
        } else {
            outputResponse('error', 'There was a problem sending your application. Please try again or contact us directly.', $redirectUrl);
        }
    }
} else {
    // No form data submitted
    log_error('No form submission detected. POST data: ' . print_r($_POST, true));
    outputResponse('error', 'No form data received', 'index.php');
}