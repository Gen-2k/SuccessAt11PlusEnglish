<?php
// --- Ensure clean JSON output and log all errors ---
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log.txt');
error_reporting(E_ALL);
ob_start();
/**
 * Handles AJAX requests for newsletter email validation and subscription.
 * Outputs JSON responses.
 */

// Ensure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database configuration
require_once __DIR__ . '/database/dbconfig.php'; // Assumes dbconfig.php establishes $connection

// Check database connection
if (!$connection) {
    error_log("Database connection failed in tipAction.php");
    echo json_encode(['status' => 'error', 'message' => 'Database connection error.']);
    exit;
}

// Set the content type to JSON for all responses
header('Content-Type: application/json');

// --- Action Handling ---

// Action: Check if email already exists (triggered by blur event in frontend JS)
if (isset($_POST['check_email'])) {
    $emailToCheck = trim($_POST['check_email']);
    $response = ['status' => 'error', 'message' => 'An unknown error occurred during email check.']; // Default error

    if (empty($emailToCheck) || !filter_var($emailToCheck, FILTER_VALIDATE_EMAIL)) {
        $response = ['status' => 'invalid_input', 'message' => 'Invalid email format provided.'];
    } else {
        // Prepare statement to prevent SQL injection
        $stmt = $connection->prepare("SELECT email FROM newsletter WHERE email = ?");
        if ($stmt) {
            $stmt->bind_param("s", $emailToCheck);
            if ($stmt->execute()) {
                $stmt->store_result(); // Needed to check num_rows
                if ($stmt->num_rows > 0) {
                    $response = ['status' => 'exists', 'message' => 'Already Subscribed, Thank You.'];
                } else {
                    $response = ['status' => 'valid', 'message' => 'Email is available.'];
                }
            } else {
                error_log("Database Error executing email check: " . $stmt->error); // Log DB errors server-side
                $response['message'] = 'Database query failed during email check.';
            }
            $stmt->close();
        } else {
            error_log("Database Error preparing email check: " . $connection->error);
            $response['message'] = 'Database statement preparation failed.';
        }
    }
    echo json_encode($response);
    exit; // Stop script execution after handling this action
}

// Action: Handle newsletter subscription form submission
if (isset($_POST['action']) && $_POST['action'] == 'newsletter') {
    error_log("Newsletter subscription attempt started"); // Debug log
    $name = trim($_POST['n_name'] ?? ''); // Use null coalescing operator for safety
    $email = trim($_POST['n_email'] ?? '');

    $response = ['status' => 'error', 'message' => 'An unknown error occurred during subscription.']; // Default error

    // --- Basic Validation ---
    if (empty($name)) {
        $response['message'] = 'Name is required.';
        echo json_encode($response);
        exit;
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = 'A valid email is required.';
        $response['field'] = 'email'; // Hint for frontend JS
        echo json_encode($response);
        exit;
    }

    // --- Check if email already exists (again, using prepared statement) ---
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

    if ($stmt_check->num_rows > 0) {
        // Email already exists
        $response = ['status' => 'error', 'message' => 'This email is already subscribed.', 'field' => 'email'];
        $stmt_check->close();
        echo json_encode($response);
        exit;
    }
    $stmt_check->close(); // Close the check statement

    // --- Email does not exist, proceed with INSERT ---
    $stmt_insert = $connection->prepare("INSERT INTO newsletter (fname, email) VALUES (?, ?)");
    if (!$stmt_insert) {
        error_log("Database Error preparing insert: " . $connection->error);
        $response['message'] = 'Database error preparing subscription.';
        echo json_encode($response);
        exit;
    }

    $stmt_insert->bind_param("ss", $name, $email);

    error_log("Attempting to insert newsletter subscription: Name=$name, Email=$email"); // Debug log
    if ($stmt_insert->execute()) {
        // --- INSERT Successful, Proceed with Email Sending ---
        if ($stmt_insert->affected_rows > 0) {
            error_log("Newsletter subscription inserted successfully into database"); // Debug log

            try {
                // Include PHPMailer libraries (ensure paths are correct relative to tipAction.php)
                if (!file_exists('./mail/PHPMailerAutoload.php')) {
                    throw new Exception('PHPMailerAutoload.php file not found');
                }
                
                require_once './mail/PHPMailerAutoload.php'; // Use require_once
                
                // Check if PHPMailer class exists after autoload
                if (!class_exists('PHPMailer')) {
                    throw new Exception('PHPMailer class not found after autoload');
                }

                // Create PHPMailer instance (compatible with older versions)
                $mail = new PHPMailer();
                $mail->isHTML(true); // Set email format to HTML

                // Server settings (keep original)
                // $mail->SMTPDebug = 2; // Enable verbose debug output for testing ONLY
                $mail->isSMTP(); // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username   = 'admin@successat11plusenglish.com'; // SMTP username
                $mail->Password   = 'teoiljmskiwvamwh'; // SMTP password (consider environment variables)
                $mail->SMTPSecure = 'ssl'; // Use 'ssl' for PHPMailer 5.x compatibility
                $mail->Port = 465;

                // DKIM Settings (keep original)
                $mail->DKIM_domain = 'successat11plusenglish.com';
                $mail->DKIM_private = './mail/dkim_private.pem'; // Ensure path is correct
                $mail->DKIM_selector = 'default';
                $mail->DKIM_passphrase = '';
                $mail->DKIM_identity = 'admin@successat11plusenglish.com'; // Use sender email
                $mail->DKIM_copyHeaderFields = false;

                // Sender
                $mail->setFrom('Safrina@successat11plusenglish.com', 'Success At 11 Plus English');
                $mail->addReplyTo('Safrina@successat11plusenglish.com', 'Success At 11 Plus English');

                // --- Send Email to User ---
                $mail->addAddress($email, $name); // Add recipient
                $mail->Subject = 'Thank You For Subscribing!'; // Slightly improved subject
                $user_content = '<html><body><div><p>Dear ' . htmlspecialchars($name) . ',<br><br> Thanks for subscribing to the Success At 11 Plus English newsletter.<br><br>We will send regular updates on new courses and products.<br><br>Regards,<br>The Success At 11 Plus English Team.<br /><br />To unsubscribe, click <a href="https://www.successat11plusenglish.com/unsubscribe.php?unsub_email=' . base64_encode($email) . '">here</a></p></div></body></html>';
                $mail->Body    = $user_content;
                $mail->AltBody = strip_tags($user_content); // Add plain text version

                $mail->send(); // Send the email

                // --- Send Notification Email to Admin ---
                $mail->clearAddresses(); // Clear previous recipient
                $mail->addAddress('regutest@outlook.com', 'Admin'); // Admin email address
                $mail->Subject = 'New Newsletter Subscription';
                $admin_content = '<html><body><div><p>A new user has subscribed to the newsletter:</p><ul><li>Name: ' . htmlspecialchars($name) . '</li><li>Email: ' . htmlspecialchars($email) . '</li><li>Date: ' . date("d/m/Y") . '</li></ul></div></body></html>';
                $mail->Body    = $admin_content;
                $mail->AltBody = strip_tags($admin_content);

                $mail->send(); // Send admin notification

                // If both emails sent successfully (or at least didn't throw exceptions)
                error_log("Newsletter subscription completed successfully for: " . $email); // Debug log
                $response = ['status' => 'success', 'message' => 'Subscription successful! Thank you.'];

            } catch (Exception $e) {
                error_log("Mailer Error: " . $e->getMessage()); // Log detailed mail errors server-side
                // Even if mail fails, the subscription was added to DB, so return success but maybe log issue.
                error_log("Newsletter subscription completed (email failed) for: " . $email); // Debug log
                $response = ['status' => 'success', 'message' => 'Subscription successful! Thank you. (Confirmation email could not be sent)'];
            }

        } else {
             // Insert executed but no rows affected? Unlikely but possible.
            error_log("Newsletter subscription: 0 rows affected for email: " . $email); // Debug log
            $response['message'] = 'Subscription could not be added to the database (0 rows affected).';
        }

    } else {
        // --- INSERT Failed ---
        error_log("Database Error executing insert: " . $stmt_insert->error);
        error_log("Newsletter subscription failed for: Name=$name, Email=$email"); // Debug log
        $response['message'] = 'Failed to add subscription to the database.';
    }
    $stmt_insert->close(); // Close insert statement

    // Output the final JSON response for the subscription action
    echo json_encode($response);
    exit;
}

// Fallback if no known action is matched
echo json_encode(['status' => 'error', 'message' => 'Invalid request or missing parameters.']);
exit;

?>