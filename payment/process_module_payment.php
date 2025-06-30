<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once __DIR__ . '/../database/dbconfig.php';

// Validate session data for payment processing
if (!isset($_SESSION['classid']) || !isset($_SESSION['courseName'])) {
    $_SESSION['status_code'] = "Error";
    $_SESSION['status'] = 'Session expired. Please fill out the application form again.';
    header("Location: " . BASE_URL . "index.php");
    exit();
}

// Extract module information from session
$classId = $_SESSION['classid']; // e.g., 'year4', 'year5', 'year6'
$courseName = $_SESSION['courseName']; // e.g., 'Year 4 - Comprehension Module'
$courseId = $_SESSION['courseId']; // e.g., 'Year4'

// Extract module name - use simplified format if available
$moduleName = '';
if (isset($_SESSION['module'])) {
    $moduleName = $_SESSION['module'];
} else {
    // Fallback: extract from course name (e.g., "Year 4 - Comprehension Module" -> "Comprehension")
    if (preg_match('/Year \d+ - (.+) Module/', $courseName, $matches)) {
        $moduleName = trim($matches[1]);
    }
}

// Define module pricing based on year pages
$modulePricing = [
    'Comprehension' => 115,
    'Creative Writing' => 165,
    'SPaG' => 125,
    'English Vocabulary' => 125,
    'Verbal Reasoning' => 210,
    'Carousel Course' => 68,
    '1:1 Tutoring' => 45
];

// Get module price
if (!isset($modulePricing[$moduleName])) {
    $_SESSION['error'] = "Invalid module selected.";
    header("Location: " . BASE_URL . "applyForm.php?lan=" . urlencode($classId) . "&course=" . urlencode($courseId) . "&courseName=" . urlencode($courseName));
    exit();
}

$modulePrice = $modulePricing[$moduleName];

// Extract student information from session (since this is accessed via redirect)
$studentData = [
    'fname' => $_SESSION['fname'] ?? '',
    'surname' => $_SESSION['lname'] ?? '',
    'dob' => $_SESSION['dob'] ?? '2010-01-01', // Default DOB if not provided
    'gender' => $_SESSION['gender'] ?? 'Not specified',
    'parent_firstname' => $_SESSION['parentName'] ?? '',
    'parent_surname' => $_SESSION['parentSurname'] ?? '',
    'address' => $_SESSION['address'] ?? 'Not provided',
    'email' => trim($_SESSION['email'] ?? ''),
    'phone' => $_SESSION['phone'] ?? '',
    'yesorno' => $_SESSION['yesorno'] ?? 'yes'
];

// Validate required session data
if (empty($studentData['email']) || empty($studentData['fname'])) {
    $_SESSION['status_code'] = "Error";
    $_SESSION['status'] = 'Missing required student information. Please fill out the form again.';
    header("Location: " . BASE_URL . "index.php");
    exit();
}

// Check if email already exists
$emailCheck = "SELECT email FROM students WHERE email = ?";
$stmt = mysqli_prepare($connection, $emailCheck);
mysqli_stmt_bind_param($stmt, "s", $studentData['email']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $_SESSION['error'] = "Email already exists. Please use a different email address.";
    
    // Use simplified parameters if available, otherwise fall back to old format
    if (isset($_SESSION['module'])) {
        header("Location: " . BASE_URL . "applyForm.php?class=" . urlencode($classId) . "&module=" . urlencode($_SESSION['module']));
    } else {
        header("Location: " . BASE_URL . "applyForm.php?lan=" . urlencode($classId) . "&course=" . urlencode($courseId) . "&courseName=" . urlencode($courseName));
    }    exit();
}

// Format date properly (handle default DOB)
$dobTimestamp = strtotime($studentData['dob']);
$formattedDob = ($dobTimestamp !== false) ? date("Y-m-d", $dobTimestamp) : '2010-01-01';

// Generate password
function generatePassword($length = 6) {
    $characters = '0123456789';
    return substr(str_shuffle($characters), 0, $length);
}

$password = generatePassword(6);

// Store data in session for use after payment (using new schema field names)
$_SESSION['pending_enrollment'] = [
    'student_data' => array_merge($studentData, ['dob' => $formattedDob, 'password' => $password]),
    'module' => $moduleName, 
    'class' => $classId,      
    'module_price' => $modulePrice,
    'course_name' => $courseName
];

// Initialize Stripe
require_once __DIR__ . '/../vendor/autoload.php';

$stripe = new \Stripe\StripeClient("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");

// Create payment session
try {
    // Build cancel URL using simplified parameters if available
    $cancelUrl = BASE_URL . "applyForm.php?";
    if (isset($_SESSION['module'])) {
        $cancelUrl .= "class=" . urlencode($classId) . "&module=" . urlencode($_SESSION['module']) . "&cancel=1";
    } else {
        $cancelUrl .= "lan=" . urlencode($classId) . "&course=" . urlencode($courseId) . "&courseName=" . urlencode($courseName) . "&cancel=1";
    }
    
    $session = $stripe->checkout->sessions->create([
        'payment_method_types' => ['card'],
        'mode' => 'payment',
        'success_url' => BASE_URL . 'payment/payment_success.php?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => $cancelUrl,
        'line_items' => [
            [
                'price_data' => [
                    'currency' => 'gbp',
                    'product_data' => [
                        'name' => $studentData['fname'] . ' ' . $studentData['surname'] . ' - ' . $moduleName,
                        'description' => $courseId . ' / ' . $moduleName . ' Module',
                    ],
                    'unit_amount' => $modulePrice * 100 // Convert to pence
                ],
                'quantity' => 1
            ]
        ]
    ]);
    
    // Redirect to Stripe
    header('Location: ' . $session->url);
    exit();
    
} catch (Exception $e) {
    $_SESSION['error'] = "Payment setup failed. Please try again.";
    header("Location: " . BASE_URL . "applyForm.php?lan=" . urlencode($classId) . "&course=" . urlencode($courseId) . "&courseName=" . urlencode($courseName));
    exit();
}
?>
