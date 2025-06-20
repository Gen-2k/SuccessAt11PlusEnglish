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

    try {
        require './mail/PHPMailerAutoload.php';
    require './mail/class.phpmailer.php';
    require './mail/class.smtp.php';

    $mail = new PHPMailer;

        $mail->SMTPDebug = 2; // Increase debugging level for troubleshooting
        $mail->Debugoutput = function($str, $level) {
            log_error("PHPMailer [$level]: $str");
        };
        
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'Safrina@smile4kids.co.uk';
        $mail->Password   = 'teoiljmskiwvamwh';
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

    $mail->setFrom('Safrina@smile4kids.co.uk', ' Success at 11 plus English');
    $mail->addAddress('sfs662001@yahoo.com', 'Safrina Saran');
    $mail->addReplyTo('Safrina@smile4kids.co.uk', ' Success at 11 plus English');
    
        $mail->isHTML(true);
        
        // Determine subject based on form type
        if (isset($_POST["eqFTC"])) {
            $mail->Subject = 'Enquiry for TRY a Free Class ENQUIRY';
        } else {
            $mail->Subject = 'Trial Class Application';
        }
        
        // Create more detailed HTML email body with all form fields
        $mail->Body = '
        <html>
        <body style="font-family: Arial, sans-serif; line-height: 1.6;">
            <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px;">
                <h2 style="color: #6e20a7; border-bottom: 2px solid #eee; padding-bottom: 10px;">New Enquiry Received</h2>
                <p><strong>Name:</strong> ' . htmlspecialchars($enqName) . '</p>
                <p><strong>Phone:</strong> ' . htmlspecialchars($enqPhone) . '</p>
                <p><strong>Email:</strong> ' . htmlspecialchars($enqMail) . '</p>
                <p><strong>Year Group:</strong> ' . htmlspecialchars($enqApply) . '</p>
                ' . (!empty($enqModule) ? '<p><strong>Module Interest:</strong> ' . htmlspecialchars($enqModule) . '</p>' : '') . '
                ' . (!empty($enqMsg) ? '<p><strong>Message:</strong> ' . nl2br(htmlspecialchars($enqMsg)) . '</p>' : '') . '
                <p style="font-size: 12px; color: #777; margin-top: 30px;">This message was sent from the Success at 11 Plus English website.</p>
            </div>
        </body>
        </html>';
        
        $mail->AltBody = 'Name: ' . $enqName . "\n" .
                        'Phone: ' . $enqPhone . "\n" .
                        'Email: ' . $enqMail . "\n" .
                        'Year Group: ' . $enqApply . "\n" .
                        (!empty($enqModule) ? 'Module Interest: ' . $enqModule . "\n" : '') .
                        (!empty($enqMsg) ? 'Message: ' . $enqMsg : '');
        
        // DKIM setup
                $mail->DKIM_domain = 'smile4kids.co.uk';
                $mail->DKIM_private = './mail/dkim_private.pem';
                $mail->DKIM_selector = 'default';
                $mail->DKIM_passphrase = '';
                $mail->DKIM_identity = $mail->From;
                $mail->DKIM_copyHeaderFields = false;
        
    if (!$mail->send()) {
            log_error('Email could not be sent. Mailer Error: ' . $mail->ErrorInfo);
            outputResponse('error', 'There was a problem sending your application. Please try again or contact us directly.', $redirectUrl);
    } else {
            // Log successful submission details
            log_error('Email sent successfully to: ' . $enqMail);
            
            // Send an auto-response to the user if this is a trial class form
            if(isset($_POST["eqTry"])) {
                try {
                    $autoResponse = new PHPMailer;
                    $autoResponse->isSMTP();
                    $autoResponse->Host       = 'smtp.gmail.com';
                    $autoResponse->SMTPAuth   = true;
                    $autoResponse->Username   = 'Safrina@smile4kids.co.uk';
                    $autoResponse->Password   = 'teoiljmskiwvamwh';
                    $autoResponse->SMTPSecure = 'ssl';
                    $autoResponse->Port       = 465;
                    
                    $autoResponse->setFrom('Safrina@smile4kids.co.uk', ' Success at 11 plus English');
                    $autoResponse->addAddress($enqMail, $enqName);
                    $autoResponse->isHTML(true);
                    $autoResponse->Subject = 'We Received Your Trial Class Application';
                    $autoResponse->Body = '
                    <html>
                    <body style="font-family: Arial, sans-serif; line-height: 1.6;">
                        <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px;">
                            <h2 style="color: #6e20a7; border-bottom: 2px solid #eee; padding-bottom: 10px;">Thank You For Your Application</h2>
                            <p>Dear ' . htmlspecialchars($enqName) . ',</p>
                            <p>Thank you for applying for a trial class with Success at 11 Plus English. We\'ve received your application and one of our team members will contact you within the next 24 hours to arrange your session.</p>
                            <p>If you have any questions in the meantime, feel free to reply to this email or call us.</p>
                            <p>We look forward to meeting you!</p>
                            <p>Warm regards,<br>Success at 11 Plus English Team</p>
                        </div>
                    </body>
                    </html>';
                    
                    $autoResponse->AltBody = 'Thank you for applying for a trial class with Success at 11 Plus English. We\'ve received your application and one of our team members will contact you within the next 24 hours to arrange your session.';
                    
                    $autoResponse->send();
                    log_error('Auto-response email sent to user: ' . $enqMail);
                } catch (Exception $e) {
                    log_error('Auto-response could not be sent: ' . $e->getMessage());
                    // Don't fail the whole process if auto-response fails
                }
            }
            
            outputResponse('success', 'Your application has been submitted successfully! We will contact you shortly.', $redirectUrl);
        }
        
    } catch (Exception $e) {
        log_error('Exception caught: ' . $e->getMessage());
        outputResponse('error', 'There was a problem with your application. Please try again.', $redirectUrl);
    }
} else {
    // No form data submitted
    log_error('No form submission detected. POST data: ' . print_r($_POST, true));
    outputResponse('error', 'No form data received', 'index.php');
}