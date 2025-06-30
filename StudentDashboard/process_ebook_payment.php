<?php
require_once 'config/config.php';
require_once 'includes/auth.php';

// Check authentication
checkStudentAuth();

// Get current student info
$current_student = getCurrentStudent();
$student_id = $current_student['id'];

// Handle different request types
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle AJAX requests for free ebooks
    header('Content-Type: application/json');
    
    if (isset($_POST['action']) && $_POST['action'] === 'claim_free') {
        $ebook_id = intval($_POST['ebook_id'] ?? 0);
        
        if (!$ebook_id) {
            echo json_encode(['success' => false, 'message' => 'Invalid ebook ID']);
            exit;
        }
        
        // Get ebook details
        $ebook = getEbook($ebook_id);
        if (!$ebook) {
            echo json_encode(['success' => false, 'message' => 'E-book not found']);
            exit;
        }
        
        // Check if it's actually free
        if ($ebook['price'] > 0) {
            echo json_encode(['success' => false, 'message' => 'This e-book is not free']);
            exit;
        }
          // Check if student already has access
        if (hasEbookAccess($student_id, $ebook_id)) {
            echo json_encode(['success' => false, 'message' => 'You already have access to this e-book']);
            exit;
        }
        
        // Check if student can purchase this ebook (must be enrolled in the module)
        if (!canPurchaseEbook($student_id, $ebook_id)) {
            echo json_encode(['success' => false, 'message' => 'You must be enrolled in the module to access this e-book']);
            exit;
        }
        
        // Create a free ebook purchase record
        $conn = getDBConnection();
        
        try {
            mysqli_begin_transaction($conn);
            
            $transaction_id = 'FREE_EBOOK_' . $ebook_id . '_' . $student_id . '_' . time();
            
            // Insert into purchased_ebooks table
            $purchase_id = createEbookPurchase($student_id, $ebook_id, 0.00, $transaction_id, 'paid');
            
            if (!$purchase_id) {
                throw new Exception('Failed to create purchase record');
            }
            
            mysqli_commit($conn);
            
            echo json_encode(['success' => true, 'message' => 'Free e-book claimed successfully!']);
            
        } catch (Exception $e) {
            mysqli_rollback($conn);
            echo json_encode(['success' => false, 'message' => 'Failed to claim e-book: ' . $e->getMessage()]);
        }
        
        exit;
    }
} else {
    // Handle GET requests for paid ebook purchases
    $ebook_id = intval($_GET['ebook_id'] ?? 0);
    
    if (!$ebook_id) {
        header('Location: ebooks.php?error=invalid_ebook');
        exit;
    }
    
    // Get ebook details
    $ebook = getEbook($ebook_id);
    if (!$ebook) {
        header('Location: ebooks.php?error=ebook_not_found');
        exit;
    }
      // Check if it's a paid ebook
    if ($ebook['price'] <= 0) {
        header('Location: ebooks.php?error=free_ebook');
        exit;
    }
    
    // Check if student can purchase this ebook (must be enrolled in the module)
    if (!canPurchaseEbook($student_id, $ebook_id)) {
        header('Location: ebooks.php?error=module_not_enrolled');
        exit;
    }
    
    // Check if student already has this ebook
    if (hasEbookAccess($student_id, $ebook_id)) {
        header('Location: ebooks.php?error=already_owned');
        exit;
    }
    
    // Check if student already has access
    if (hasEbookAccess($student_id, $ebook_id)) {
        header('Location: ebooks.php?error=already_owned');
        exit;
    }
    
    // Get student details for payment processing
    $conn = getDBConnection();
    $student_query = "SELECT * FROM students WHERE id = ?";
    $stmt = mysqli_prepare($conn, $student_query);
    mysqli_stmt_bind_param($stmt, "i", $student_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $student_data = mysqli_fetch_assoc($result);
    
    if (!$student_data) {
        header('Location: ebooks.php?error=student_not_found');
        exit;
    }
    
    // Store ebook purchase data in session for use after payment
    $_SESSION['pending_ebook_purchase'] = [
        'ebook_id' => $ebook_id,
        'ebook_data' => $ebook,
        'student_id' => $student_id,
        'student_data' => $student_data
    ];
    
    // Initialize Stripe
    require_once __DIR__ . '/../vendor/autoload.php';
    
    $stripe = new \Stripe\StripeClient("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");
    
    // Create payment session
    try {
        $session = $stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'success_url' => BASE_URL . 'StudentDashboard/ebook_payment_success.php?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => BASE_URL . 'StudentDashboard/ebooks.php?payment=cancelled',
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'gbp',
                        'product_data' => [
                            'name' => $student_data['fname'] . ' ' . $student_data['surname'] . ' - ' . $ebook['title'],
                            'description' => $ebook['class'] . ' / ' . $ebook['module'] . ' E-Book',
                        ],
                        'unit_amount' => $ebook['price'] * 100 // Convert to pence
                    ],
                    'quantity' => 1
                ]
            ]
        ]);
        
        // Redirect to Stripe
        header('Location: ' . $session->url);
        exit();
        
    } catch (Exception $e) {
        error_log('Ebook payment setup failed: ' . $e->getMessage());
        header('Location: ebooks.php?error=payment_setup_failed');
        exit;
    }
}
?>
