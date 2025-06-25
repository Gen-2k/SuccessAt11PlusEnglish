<?php
// -----------------------------------------------------------------------------
// Success At 11 Plus English - Newsletter Tip Action Handler
// -----------------------------------------------------------------------------
// Handles AJAX requests for newsletter email validation and subscription.
// Outputs JSON responses. All errors are logged to error_log.txt.
// -----------------------------------------------------------------------------

// =============================
// Error Reporting & Output Buffering
// =============================
ini_set('display_errors', 0); // Hide errors from user
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', __DIR__ . '/error_log.txt'); // Log file location
error_reporting(E_ALL); // Report all errors
ob_start(); // Start output buffering

// =============================
// Session Management
// =============================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// =============================
// Database Connection
// =============================
require_once __DIR__ . '/database/dbconfig.php'; // Assumes $connection is established
if (!$connection) {
    error_log("Database connection failed in tipAction.php");
    echo json_encode(['status' => 'error', 'message' => 'Database connection error.']);
    exit;
}

// =============================
// Set JSON Response Header
// =============================
header('Content-Type: application/json');

// -----------------------------------------------------------------------------
// ACTION: Check if Email Already Exists (AJAX blur event)
// -----------------------------------------------------------------------------
if (isset($_POST['check_email'])) {
    $emailToCheck = trim($_POST['check_email']);
    $response = ['status' => 'error', 'message' => 'An unknown error occurred during email check.'];

    // --- Validate Email Format ---
    if (empty($emailToCheck) || !filter_var($emailToCheck, FILTER_VALIDATE_EMAIL)) {
        $response = ['status' => 'invalid_input', 'message' => 'Invalid email format provided.'];
    } else {
        // --- Check Email in Database (Prepared Statement) ---
        $stmt = $connection->prepare("SELECT email FROM newsletter WHERE email = ?");
        if ($stmt) {
            $stmt->bind_param("s", $emailToCheck);
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    // Email exists: allow resending tips for already subscribed
                    $response = ['status' => 'exists', 'message' => 'Already Subscribed, Thank You.'];
                } else {
                    $response = ['status' => 'valid', 'message' => 'Email is available.'];
                }
            } else {
                error_log("Database Error executing email check: " . $stmt->error);
                $response['message'] = 'Database query failed during email check.';
            }
            $stmt->close();
        } else {
            error_log("Database Error preparing email check: " . $connection->error);
            $response['message'] = 'Database statement preparation failed.';
        }
    }
    echo json_encode($response);
    exit;
}

// -----------------------------------------------------------------------------
// ACTION: Newsletter Subscription Form Submission
// -----------------------------------------------------------------------------
if (isset($_POST['action']) && $_POST['action'] == 'newsletter') {
    error_log("Newsletter subscription attempt started");
    $name = trim($_POST['n_name'] ?? '');
    $email = trim($_POST['n_email'] ?? '');
    $tip_type = trim($_POST['tip_type'] ?? '');
    $response = ['status' => 'error', 'message' => 'An unknown error occurred during subscription.'];

    // --- Basic Validation ---
    if (empty($name)) {
        $response['message'] = 'Name is required.';
        echo json_encode($response);
        exit;
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = 'A valid email is required.';
        $response['field'] = 'email';
        echo json_encode($response);
        exit;
    }

    // -------------------------------------------------------------------------
    // Helper: Generate Email Content Based on Tip Type
    // -------------------------------------------------------------------------
    function generateTipContent($tip_type, $name, $email) {
        $subject = '';
        $content = '';
        // --- Comprehension & Creative Writing Tips ---
        if ($tip_type === 'comprehension_creative_writing') {
            $subject = 'Your FREE Comprehension & Creative Writing Tips!';
            $content = '
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                        .header { background: linear-gradient(135deg, #1e40af, #0369a1); color: white; padding: 20px; text-align: center; }
                        .content { padding: 20px; }
                        .tips-section { margin: 20px 0; padding: 15px; border-left: 4px solid #0dcaf0; background-color: #f8f9fa; }
                        .tip-item { margin: 10px 0; padding: 8px 0; border-bottom: 1px dotted #ccc; }
                        .tip-number { font-weight: bold; color: #0dcaf0; }
                        .creative-section { margin: 20px 0; padding: 15px; border-left: 4px solid #198754; background-color: #f8f9fa; }
                        .footer { background-color: #f8f9fa; padding: 15px; text-align: center; font-size: 12px; color: #666; }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>Your FREE 11+ Success Tips!</h1>
                        <p>Expert strategies for Comprehension & Creative Writing</p>
                    </div>
                    <div class="content">
                        <p>Dear ' . htmlspecialchars($name) . ',</p>
                        <p>Thank you for requesting our expert tips! Here are proven strategies to help your child excel in 11+ English exams.</p>
                        <div class="tips-section">
                            <h3 style="color: #0dcaf0; margin-top: 0;">🔍 COMPREHENSION - Top Tips</h3>
                            <div class="tip-item"><span class="tip-number">1.</span> Read the title first to understand the context</div>
                            <div class="tip-item"><span class="tip-number">2.</span> Read and understand each paragraph carefully</div>
                            <div class="tip-item"><span class="tip-number">3.</span> Re-read questions and underline what is being asked</div>
                            <div class="tip-item"><span class="tip-number">4.</span> For multiple choice - use process of elimination</div>
                            <div class="tip-item"><span class="tip-number">5.</span> Provide evidence from text to support answers</div>
                            <div class="tip-item"><span class="tip-number">6.</span> Remember: if it is not in the text, it is NOT TRUE!</div>
                            <div class="tip-item"><span class="tip-number">7.</span> Match synonyms exactly to quoted questions</div>
                            <div class="tip-item"><span class="tip-number">8.</span> Always double-check all answers</div>
                        </div>
                        <div class="creative-section">
                            <h3 style="color: #198754; margin-top: 0;">✍️ CREATIVE WRITING - What Examiners Look For</h3>
                            <p><strong>Successfully passing your 11+ creative writing exam is less daunting when you know what examiners want:</strong></p>
                            <div class="tip-item">✅ A well-planned piece of writing</div>
                            <div class="tip-item">✅ Strong creativity and good imagination</div>
                            <div class="tip-item">✅ A fluent writing style</div>
                            <div class="tip-item">✅ Good and correct use of punctuation</div>
                            <div class="tip-item">✅ Sophisticated vocabulary choices</div>
                            <div class="tip-item">✅ Varied sentence structures</div>
                            <div class="tip-item">✅ Clear paragraph organization</div>
                            <div class="tip-item">✅ Engaging opening and satisfying conclusion</div>
                        </div>
                        <div style="background-color: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; margin: 20px 0; border-radius: 5px;">
                            <h4 style="color: #856404; margin-top: 0;">🌟 Why Reading & Vocabulary Matter</h4>
                            <p><strong>Vocabulary as Foundation:</strong> A strong vocabulary is essential because readers cannot understand what they are reading without knowing word meanings.</p>
                            <p><strong>Reading Improves Everything:</strong> Daily purposeful reading (15+ minutes) enhances comprehension, vocabulary, and writing skills simultaneously.</p>
                        </div>
                        <p>Best of luck with your 11+ preparation!</p>
                        <p>Warm regards,<br><strong>The Success At 11 Plus English Team</strong></p>
                    </div>
                    <div class="footer">
                        <p>© ' . date('Y') . ' Success At 11 Plus English | 
                        <a href="https://elevenplusenglish.co.uk/unsubscribe.php?unsub_email=' . base64_encode($email) . '">Unsubscribe</a></p>
                    </div>
                </body>
                </html>';
        }
        // --- Reading Tips ---
        elseif ($tip_type === 'reading_tips') {
            $subject = 'Your FREE Reading Tips - Parents Guide!';
            $content = '
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                        .header { background: linear-gradient(135deg, #dc3545, #b02a37); color: white; padding: 20px; text-align: center; }
                        .content { padding: 20px; }
                        .reading-section { margin: 20px 0; padding: 15px; border-left: 4px solid #dc3545; background-color: #f8f9fa; }
                        .reading-item { margin: 10px 0; padding: 10px; background-color: white; border-radius: 5px; border-left: 3px solid #dc3545; }
                        .icon { font-size: 20px; margin-right: 10px; }
                        .footer { background-color: #f8f9fa; padding: 15px; text-align: center; font-size: 12px; color: #666; }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>❤️ Parents Guide to Help Students Love Reading!</h1>
                        <p>Transform your child into an enthusiastic reader</p>
                    </div>
                    <div class="content">
                        <p>Dear ' . htmlspecialchars($name) . ',</p>
                        <p>Thank you for requesting our reading guide! Here is how to inspire your child to love reading and improve their 11+ performance.</p>
                        <div style="background-color: #ffe6e6; border: 2px solid #dc3545; padding: 20px; margin: 20px 0; border-radius: 10px; text-align: center;">
                            <h3 style="color: #dc3545; margin-top: 0;">🎯 Key Principles to Remember</h3>
                            <p><strong>Everyone is different.</strong> We do not all like the same films, so why should we all like the same books?</p>
                            <p><strong>What is most important is that you enjoy reading and find what makes you tick!</strong></p>
                            <h4 style="color: #dc3545;">Remember: Every kind of reading counts!</h4>
                        </div>
                        <div class="reading-section">
                            <h3 style="color: #dc3545; margin-top: 0;">📚 Every Kind of Reading is Good Reading!</h3>
                            <p><strong>Do not just read stories - try the following:</strong></p>
                            <div class="reading-item">
                                <span class="icon">📖</span><strong>Non-fiction books</strong> - about science, history, nature, space, sport, or anything else you are curious about
                            </div>
                            <div class="reading-item">
                                <span class="icon">📰</span><strong>Newspapers and magazines</strong> - like National Geographic Kids, or magazines about your hobbies
                            </div>
                            <div class="reading-item">
                                <span class="icon">👤</span><strong>Biographies and autobiographies</strong> - real-life stories of people you admire in sports or films
                            </div>
                            <div class="reading-item">
                                <span class="icon">ℹ️</span><strong>Information texts</strong> - travel guides, websites, holiday brochures, leaflets about local attractions
                            </div>
                            <div class="reading-item">
                                <span class="icon">📢</span><strong>Persuasive writing</strong> - adverts, opinion pieces, letters, websites selling products
                            </div>
                            <div class="reading-item">
                                <span class="icon">📜</span><strong>Instructions and recipes</strong> - cooking recipes, game rules, DIY guides
                            </div>
                        </div>
                        <div style="background-color: #f0f9ff; border: 1px solid #0dcaf0; padding: 15px; margin: 20px 0; border-radius: 5px;">
                            <h4 style="color: #0369a1; margin-top: 0;">💡 Why This Approach Works</h4>
                            <p>✅ <strong>Reading improves comprehension skills</strong></p>
                            <p>✅ <strong>Expands vocabulary naturally</strong></p>
                            <p>✅ <strong>Helps develop better writing skills</strong></p>
                            <p>✅ <strong>But reading must be purposeful and mindful</strong></p>
                            <p>✅ <strong>Understanding what you have read is key!</strong></p>
                        </div>
                        <div style="background-color: #e8f5e8; border: 1px solid #198754; padding: 15px; margin: 20px 0; border-radius: 5px;">
                            <h4 style="color: #198754; margin-top: 0;">🎯 Daily Reading Goals</h4>
                            <p><strong>Aim for at least 15 minutes of purposeful reading per day</strong></p>
                            <p>• Choose materials that match your child\'s interests</p>
                            <p>• Discuss what they have read</p>
                            <p>• Look up difficult words together</p>
                            <p>• Make connections to real life</p>
                        </div>
                        <p>Happy reading!</p>
                        <p>Warm regards,<br><strong>The Success At 11 Plus English Team</strong></p>
                    </div>
                    <div class="footer">
                        <p>© ' . date('Y') . ' Success At 11 Plus English | 
                        <a href="https://elevenplusenglish.co.uk/unsubscribe.php?unsub_email=' . base64_encode($email) . '">Unsubscribe</a></p>
                    </div>
                </body>
                </html>';
        }
        // --- Default Content (Fallback) ---
        else {
            $subject = 'Thank You For Subscribing!';
            $content = '<html><body><div><p>Dear ' . htmlspecialchars($name) . ',<br><br> Thanks for subscribing to the Success At 11 Plus English newsletter.<br><br>We will send regular updates on new courses and products.<br><br>Regards,<br>The Success At 11 Plus English Team.<br /><br />To unsubscribe, click <a href="https://elevenplusenglish.co.uk/unsubscribe.php?unsub_email=' . base64_encode($email) . '">here</a></p></div></body></html>';
        }
        return ['subject' => $subject, 'content' => $content];
    }

    // -------------------------------------------------------------------------
    // Check for Existing Subscription
    // -------------------------------------------------------------------------
    $stmt_check = $connection->prepare("SELECT email FROM newsletter WHERE email = ?");
    if (!$stmt_check) {
        error_log("Database Error preparing email check (subscription): " . $connection->error);
        $response['message'] = 'Database error checking email before subscription.';
        echo json_encode($response);
        exit;
    }
    $stmt_check->bind_param("s", $email);
    if (!$stmt_check->execute()) {
        error_log("Database Error executing email check (subscription): " . $stmt_check->error);
        $response['message'] = 'Database query failed checking email.';
        $stmt_check->close();
        echo json_encode($response);
        exit;
    }
    $stmt_check->store_result();
    $alreadySubscribed = ($stmt_check->num_rows > 0);
    $stmt_check->close();

    // -------------------------------------------------------------------------
    // Insert New Subscription if Not Already Subscribed
    // -------------------------------------------------------------------------
    if (!$alreadySubscribed) {
        $stmt_insert = $connection->prepare("INSERT INTO newsletter (fname, email) VALUES (?, ?)");
        if (!$stmt_insert) {
            error_log("Database Error preparing insert: " . $connection->error);
            $response['message'] = 'Database error preparing subscription.';
            echo json_encode($response);
            exit;
        }
        $stmt_insert->bind_param("ss", $name, $email);
        error_log("Attempting to insert newsletter subscription: Name=$name, Email=$email");
        if (!$stmt_insert->execute() || $stmt_insert->affected_rows <= 0) {
            error_log("Database Error executing insert: " . $stmt_insert->error);
            error_log("Newsletter subscription failed for: Name=$name, Email=$email");
            $response['message'] = 'Failed to add subscription to the database.';
            $stmt_insert->close();
            echo json_encode($response);
            exit;
        }
        $stmt_insert->close();
    }

    // -------------------------------------------------------------------------
    // Send Tip Email (always, even if already subscribed)
    // -------------------------------------------------------------------------
    try {
        // --- PHPMailer Setup ---
        if (!file_exists('./mail/PHPMailerAutoload.php')) {
            throw new Exception('PHPMailerAutoload.php file not found');
        }
        require_once './mail/PHPMailerAutoload.php';
        if (!class_exists('PHPMailer')) {
            throw new Exception('PHPMailer class not found after autoload');
        }
        $mail = new PHPMailer();
        $mail->isHTML(true);
        // --- SMTP Settings (Domain SMTP) ---
        $mail->isSMTP();
        $mail->Host = 'mail.elevenplusenglish.co.uk';
        $mail->SMTPAuth = true;
        $mail->Username   = 'success@elevenplusenglish.co.uk';
        $mail->Password   = 'Monday@123'; // Replace securely
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        // --- Sender Info ---
        $mail->setFrom('success@elevenplusenglish.co.uk', 'Success At 11 Plus English');
        $mail->addReplyTo('success@elevenplusenglish.co.uk', 'Success At 11 Plus English');
        // --- Send Email to User ---
        $emailData = generateTipContent($tip_type, $name, $email);
        $mail->addAddress($email, $name);
        $mail->Subject = $emailData['subject'];
        $mail->Body = $emailData['content'];
        $mail->AltBody = strip_tags($emailData['content']);
        $mail->send();
        // --- Admin notification removed ---
        error_log("Newsletter tip email sent for: " . $email);
        $response = ['status' => 'success', 'message' => $alreadySubscribed ? 'You are already subscribed. Tips have been sent to your email.' : 'Subscription successful! Thank you.'];
    } catch (Exception $e) {
        error_log("Mailer Error: " . $e->getMessage());
        error_log("Newsletter tip email failed for: " . $email);
        $response = ['status' => 'success', 'message' => ($alreadySubscribed ? 'You are already subscribed. (Email could not be sent)' : 'Subscription successful! (Confirmation email could not be sent)')];
    }
    echo json_encode($response);
    exit;
}

// -----------------------------------------------------------------------------
// FALLBACK: Invalid Request
// -----------------------------------------------------------------------------
echo json_encode(['status' => 'error', 'message' => 'Invalid request or missing parameters.']);
exit;

?>