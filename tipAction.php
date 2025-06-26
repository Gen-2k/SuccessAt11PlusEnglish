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
            $subject = 'Essential Tips for 11 Plus English: Comprehension, Vocabulary & Creative Writing Success';
            $content = '
                <!DOCTYPE html>
                <html lang="en">
                <head>
                  <meta charset="UTF-8">
                  <meta name="viewport" content="width=device-width, initial-scale=1.0">
                  <title>\'Success At 11 Plus English\'  Tips</title>    
                  <style>
                    body { margin:0; padding:0; background:#f7f7f7; }
                    .wrapper { width:100%; table-layout:fixed; background-color:#f7f7f7; padding:30px 0; }
                    .main { background:#ffffff; width:100%; max-width:650px; margin:0 auto; border-radius:8px; overflow:hidden; }
                    .header { background: linear-gradient(90deg, #1E40AF 0%, #F59E0B 100%); padding:24px; text-align:center; }
                    .header h1 { margin:0; font-family:\'Source Serif Pro\', serif; font-size:1.8rem; color:#ffffff; }
                    .header p { margin:8px 0 0; font-family:Varela Round, sans-serif; font-size:1rem; color:#e0e0e0; }
                    .content { padding:28px; font-family:Varela Round, sans-serif; color:#212529; line-height:1.6; }
                    h2 { font-family:\'Source Serif Pro\', serif; color:#1E40AF; font-size:1.25rem; margin:24px 0 12px; }
                    ul, ol { margin:0 0 16px 24px; padding:0; }
                    li { margin-bottom:10px; }
                    .box { background:#f8f9fa; border-left:4px solid #F59E0B; padding:16px 20px; margin:20px 0; border-radius:4px; }
                    .button { display:inline-block; background:#1E40AF; color:#ffffff; text-decoration:none; padding:12px 24px; border-radius:4px; font-weight:600; margin-top:16px; }
                    .button:hover { background:#F59E0B; color:#fff; }
                    .footer { background:#ffffff; text-align:center; padding:16px; font-size:12px; color:#888888; }
                    .footer a { color:#1E40AF; text-decoration:none; }
                    @media(max-width:600px) {
                      .content { padding:20px; }
                      .header h1 { font-size:1.5rem; }
                    }
                  </style>
                </head>
                <body>
                  <div class="wrapper">
                    <div class="main">
                      <div class="header">
                        <h1>\'Success At 11 Plus English\' Tips</h1>

                        <p>Comprehension, Vocabulary & Creative Writing Tips</p>
                      </div>
                      <div class="content">
                        <p>Dear ' . htmlspecialchars($name) . ',</p>
                        <p>Preparing for the 11 Plus English exam can be challenging, but with the right strategies, your child can excel in comprehension, vocabulary, and creative writing. Below are expert tips to help build strong foundations and boost confidence.</p>

                        <h2>General Tips for Success</h2>
                        <div class="box">
                          <ul>
                            <li><strong>Daily Reading:</strong> Aim for at least 15 minutes each day. Read purposefully—understand the material and note any difficult words.</li>
                            <li><strong>Sophisticated Vocabulary:</strong> Use advanced words in daily conversations to enhance comprehension and creative writing skills.</li>
                            <li><strong>Spelling, Punctuation & Grammar:</strong> Mastering these rules is essential for answering test questions accurately.</li>
                          </ul>
                        </div>

                        <h2>Comprehension – Top Tips</h2>
                        <div class="box">
                          <ol>
                            <li>Read the title carefully.</li>
                            <li>Understand each paragraph thoroughly.</li>
                            <li>Re-read questions and underline key points (e.g., true/false).</li>
                            <li>For multiple choice, eliminate unlikely answers, then match with the text.</li>
                            <li>Support worded answers with evidence from the text.</li>
                            <li>If it’s not written or inferred in the text, it’s not true.</li>
                            <li>Match synonyms exactly to the quoted questions.</li>
                            <li>Double-check all answers before submitting.</li>
                          </ol>
                        </div>

                        <h2>Vocabulary – Why It Matters</h2>
                        <div class="box">
                          <ul>
                            <li><strong>Foundation for Comprehension:</strong> Understanding most words is crucial for grasping the text.</li>
                            <li><strong>Comprehension Process:</strong> Involves analyzing and synthesizing words, sentences, and ideas.</li>
                            <li><strong>Making Inferences:</strong> A rich vocabulary helps connect ideas and understand complex material.</li>
                            <li><strong>Word Structure:</strong> Knowing how words are formed supports vocabulary growth and comprehension.</li>
                          </ul>
                        </div>

                        <h2>Creative Writing – What Examiners Look For</h2>
                        <div class="box">
                          <ul>
                            <li>A well-planned piece of writing</li>
                            <li>Strong creativity and imagination</li>
                            <li>Fluent writing style</li>
                            <li>Correct use of punctuation and grammar</li>
                            <li>Complex sentences, clearly structured</li>
                            <li>Accurate spelling</li>
                            <li>Neat, legible handwriting</li>
                            <li>Sophisticated vocabulary</li>
                            <li>A clear purpose to your story</li>
                          </ul>
                        </div>

                        <p><strong>We hope you find these tips valuable.</strong> Our classes incorporate all these techniques and more to help your child succeed—not just in the 11 Plus, but in English for life!</p>
                        <!-- Replace comprehension email CTA button -->
                        <p>
                          <table role="presentation" border="0" cellspacing="0" cellpadding="0" align="center">
                            <tr>
                              <td align="center" bgcolor="#1E40AF" style="border-radius:4px;">
                                <a href="https://elevenplusenglish.co.uk/" target="_blank" style="font-family:Varela Round, sans-serif; font-size:16px; color:#ffffff; text-decoration:none; padding:12px 24px; display:inline-block; font-weight:600;">Join Our Online Class</a>
                              </td>
                            </tr>
                          </table>
                        </p>
                      </div>
                      <div class="footer">
                        &copy; ' . date('Y') . ' Success at 11 Plus English. All rights reserved. <br>
                        <a href="https://elevenplusenglish.co.uk/unsubscribe.php?unsub_email=' . base64_encode($email) . '">Unsubscribe</a>
                      </div>
                    </div>
                  </div>
                </body>
                </html>';
        }
        // --- Reading Tips ---
        elseif ($tip_type === 'reading_tips') {
            $subject = 'Parents Guide: Inspire a Love of Reading – 11+ Success Tips';
            $content = '
                <!DOCTYPE html>
                <html lang="en">
                <head>
                  <meta charset="UTF-8">
                  <meta name="viewport" content="width=device-width, initial-scale=1.0">
                  <title>Parents Guide – 11+ Reading Tips</title>
                  <style>
                    body { margin:0; padding:0; background:#f7f7f7; }
                    .wrapper { width:100%; table-layout:fixed; background:#f7f7f7; padding:30px 0; }
                    .main { background:#ffffff; width:100%; max-width:650px; margin:0 auto; border-radius:8px; overflow:hidden; }
                    .header { background: linear-gradient(90deg, #1E40AF 0%, #F59E0B 100%); padding:24px; text-align:center; }
                    .header h1 { margin:0; font-family:\'Source Serif Pro\', serif; font-size:1.8rem; color:#fff; }
                    .header p { margin:8px 0 0; font-family:Varela Round, sans-serif; font-size:1rem; color:#e0e0e0; }
                    .content { padding:28px; font-family:Varela Round, sans-serif; color:#212529; line-height:1.6; }
                    h2 { font-family:\'Source Serif Pro\', serif; color:#1E40AF; font-size:1.25rem; margin:24px 0 12px; }
                    ul { margin:0 0 16px 24px; }
                    li { margin-bottom:10px; }
                    .box { background:#f8f9fa; border-left:4px solid #F59E0B; padding:16px 20px; margin:20px 0; border-radius:4px; }
                    .button { display:inline-block; background:#1E40AF; color:#fff; text-decoration:none; padding:12px 24px; border-radius:4px; font-weight:600; margin-top:16px; }
                    .button:hover { background:#F59E0B; color:#fff; }
                    .footer { background:#fff; text-align:center; padding:16px; font-size:12px; color:#888; }
                    .footer a { color:#1E40AF; text-decoration:none; }
                    @media(max-width:600px) { .content{padding:20px;} .header h1{font-size:1.5rem;} }
                  </style>
                </head>
                <body>
                  <div class="wrapper">
                    <div class="main">
                      <div class="header">
                        <h1>Parents’ 11+ Reading Guide</h1>
                        <p>Encourage a Lifelong Love of Reading</p>
                      </div>
                      <div class="content">
                        <p>Dear ' . htmlspecialchars($name) . ',</p>
                        <p>Everyone is different. We don’t all like the same films, so why should we all like the same books? What matters most is that reading is enjoyable and meaningful—understanding what you read is key to success in the 11 Plus and beyond.</p>
                        <h2>Every Kind of Reading Counts</h2>
                        <div class="box">
                          <ul>
                            <li>Non-fiction books: Science, history, nature, space, sport, or anything else you’re curious about.</li>
                            <li>Newspapers & magazines: National Geographic Kids, or hobby-focused magazines.</li>
                            <li>Biographies & autobiographies: Real-life stories of people you admire.</li>
                            <li>Information texts: Travel guides, websites, brochures about local attractions.</li>
                            <li>Persuasive writing: Adverts, opinion pieces, letters, or product websites.</li>
                            <li>Instructions & recipes: Cookery or model kits—great for attention to detail.</li>
                          </ul>
                        </div>
                        <h2>Recommended Reads</h2>
                        <div class="box">
                          <h2 style="font-size:1.1rem; color:#F59E0B; margin-bottom:8px;">Classic Fiction</h2>
                          <ul>
                            <li><strong>Swallows and Amazons</strong> – Arthur Ransome</li>
                            <li><strong>The Children of the New Forest</strong> – Frederick Marryat</li>
                            <li><strong>Tom&apos;s Midnight Garden</strong> – Philippa Pearce</li>
                            <li><strong>The Phoenix and the Carpet</strong> – E. Nesbit</li>
                            <li><strong>The Prince and the Pauper</strong> – Mark Twain</li>
                          </ul>
                          <h2 style="font-size:1.1rem; color:#F59E0B; margin-bottom:8px;">Adventure Fiction</h2>
                          <ul>
                            <li><strong>The Explorer</strong> – Katherine Rundell</li>
                            <li><strong>Running on the Roof of the World</strong> – Jess Butterworth</li>
                            <li><strong>The Peculiars</strong> – Kieran Larwood</li>
                            <li><strong>The Way of Dog</strong> – Zana Fraillon</li>
                            <li><strong>Secrets of the Last Spell</strong> – Alex Evelyn</li>
                          </ul>
                        </div>
                        <p><strong>Kickstart your child’s reading journey today!</strong></p>
                        <!-- Replace reading tips CTA button and unify text -->
                        <p>
                          <table role="presentation" border="0" cellspacing="0" cellpadding="0" align="center">
                            <tr>
                              <td align="center" bgcolor="#1E40AF" style="border-radius:4px;">
                                <a href="https://elevenplusenglish.co.uk/" target="_blank" style="font-family:Varela Round, sans-serif; font-size:16px; color:#ffffff; text-decoration:none; padding:12px 24px; display:inline-block; font-weight:600;">Join Our Online Class</a>
                              </td>
                            </tr>
                          </table>
                        </p>
                      </div>
                      <div class="footer">
                        &copy; ' . date('Y') . ' Success at 11 Plus English. All rights reserved.<br>
                        <a href="https://elevenplusenglish.co.uk/unsubscribe.php?unsub_email=' . base64_encode($email) . '">Unsubscribe</a>
                      </div>
                    </div>
                  </div>
                </body>
                </html>';
        }
        // --- Default Content (Fallback) ---
        else {
            $subject = 'Welcome to Success At 11 Plus English';
            $content = '
                <!DOCTYPE html>
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
                    .footer { background:#ffffff; text-align:center; padding:16px; font-size:12px; color:#888888; }
                    .footer a { color:#1E40AF; text-decoration:none; }
                    @media(max-width:600px) { .content{padding:20px;} .header h1{font-size:1.5rem;} }
                  </style>
                </head>
                <body>
                  <div class="wrapper">
                    <div class="main">
                      <div class="header">
                        <h1>Thank You for Subscribing!</h1>
                        <p>Your Newsletter Subscription is Confirmed</p>
                      </div>
                      <div class="content">
                        <p>Dear ' . htmlspecialchars($name) . ',</p>
                        <p>Thank you for subscribing to the Success At 11 Plus English newsletter. We&apos;re excited to share exclusive tips, news on upcoming courses, and special offers to help your child excel in English.</p>
                        <p><strong>Stay tuned for expert guidance delivered to your inbox!</strong></p>
                        <p>
                          <table role="presentation" border="0" cellspacing="0" cellpadding="0" align="center">
                            <tr>
                              <td align="center" bgcolor="#1E40AF" style="border-radius:4px;">
                                <a href="https://elevenplusenglish.co.uk/" target="_blank" style="font-family:Varela Round, sans-serif; font-size:16px; color:#ffffff; text-decoration:none; padding:12px 24px; display:inline-block; font-weight:600;">Join Our Online Class</a>
                              </td>
                            </tr>
                          </table>
                        </p>
                      </div>
                      <div class="footer">
                        &copy; ' . date('Y') . ' Success at 11 Plus English. All rights reserved.<br>
                        <a href="https://elevenplusenglish.co.uk/unsubscribe.php?unsub_email=' . base64_encode($email) . '">Unsubscribe</a>
                      </div>
                    </div>
                  </div>
                </body>
                </html>';
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
        $mailConfig = require __DIR__ . '/mail/mail_config.php';
        $mail = new PHPMailer();
        $mail->isHTML($mailConfig['is_html']);
        // --- SMTP Settings (Domain SMTP) ---
        $mail->isSMTP();
        $mail->Host = $mailConfig['host'];
        $mail->SMTPAuth = true;
        $mail->Username   = $mailConfig['username'];
        $mail->Password   = $mailConfig['password'];
        $mail->SMTPSecure = $mailConfig['smtp_secure'];
        $mail->Port = $mailConfig['port'];
        $mail->CharSet = $mailConfig['charset'];
        // --- Sender Info ---
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