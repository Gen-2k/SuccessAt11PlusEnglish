<?php
// Student authentication handler
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// --- CSRF Protection Helpers ---
function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
// --- End CSRF ---

// Check if user is logged in and is a student
function checkStudentAuth() {
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header('Location: ' . dirname($_SERVER['PHP_SELF'], 2) . '/Login.php');
        exit;
    }
    
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
        header('HTTP/1.0 403 Forbidden');
        die('Access denied. Student access required.');
    }
    
    // Check session timeout (uses global SESSION_TIMEOUT from dbconfig.php)
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT)) {
        session_unset();
        session_destroy();
        header('Location: ' . dirname($_SERVER['PHP_SELF'], 2) . '/Login.php?timeout=1');
        exit;
    }
    
    // Update last activity
    $_SESSION['last_activity'] = time();
}

// Get current student info from session
function getCurrentStudent() {
    return [
        'id' => $_SESSION['id'] ?? null,
        'name' => $_SESSION['name'] ?? 'Student',
        'email' => $_SESSION['emailId'] ?? null,
        'gender' => $_SESSION['gender'] ?? null,
        'role' => $_SESSION['role'] ?? null
    ];
}

// Database connection function using existing dbconfig
function getDBConnection() {
    global $connection;
    return $connection;
}

// Get student enrollments
function getStudentEnrollments($student_id) {
    $conn = getDBConnection();
    $query = "SELECT e.*, s.fname, s.surname 
              FROM enrollments e 
              JOIN students s ON e.student_id = s.id 
              WHERE e.student_id = ? AND e.payment_status = 'paid' 
              ORDER BY e.created_at DESC";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $student_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Get resources for student based on enrollments
function getStudentResources($student_id, $resource_type) {
    $conn = getDBConnection();
    
    // Get student's enrolled classes and modules
    $enrollment_query = "SELECT DISTINCT class, module FROM enrollments 
                        WHERE student_id = ? AND payment_status = 'paid'";
    $stmt = mysqli_prepare($conn, $enrollment_query);
    mysqli_stmt_bind_param($stmt, "i", $student_id);
    mysqli_stmt_execute($stmt);
    $enrollments = mysqli_stmt_get_result($stmt);
    
    $resources = [];
    
    while ($enrollment = mysqli_fetch_assoc($enrollments)) {
        $resource_query = "SELECT * FROM resources 
                          WHERE resource_type = ? 
                          AND (class = ? OR class IS NULL) 
                          AND (module = ? OR module IS NULL)
                          ORDER BY created_at DESC";
        
        $resource_stmt = mysqli_prepare($conn, $resource_query);
        mysqli_stmt_bind_param($resource_stmt, "sss", $resource_type, $enrollment['class'], $enrollment['module']);
        mysqli_stmt_execute($resource_stmt);
        $resource_result = mysqli_stmt_get_result($resource_stmt);
        
        while ($resource = mysqli_fetch_assoc($resource_result)) {
            $resources[] = $resource;
        }
    }
    
    // Remove duplicates based on resource ID
    $unique_resources = [];
    $seen_ids = [];
    
    foreach ($resources as $resource) {
        if (!in_array($resource['id'], $seen_ids)) {
            $unique_resources[] = $resource;
            $seen_ids[] = $resource['id'];
        }
    }
    
    return $unique_resources;
}

// Sanitize input
function sanitizeInput($input) {
    if (is_array($input)) {
        return array_map('sanitizeInput', $input);
    }
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Check if student has access to a resource
function hasResourceAccess($student_id, $resource_class, $resource_module) {
    $conn = getDBConnection();
    
    $query = "SELECT COUNT(*) as count FROM enrollments 
              WHERE student_id = ? 
              AND payment_status = 'paid' 
              AND (class = ? OR class IS NULL)
              AND (module = ? OR module IS NULL)";
              
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iss", $student_id, $resource_class, $resource_module);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    
    return $row['count'] > 0;
}

// Resolve file path to correct upload location
function resolveResourcePath($file_path, $resource_type) {
    if (!$file_path) return null;
    
    // Define possible path patterns to check
    $patterns = [];
    
    // If path already starts with 'uploads/', use it directly
    if (strpos($file_path, 'uploads/') === 0) {
        $patterns[] = '../' . $file_path;
    } else {
        // Try different patterns for files without 'uploads/' prefix
        $patterns[] = '../uploads/' . $file_path;
        $patterns[] = '../uploads/' . $resource_type . '/' . $file_path;
        $patterns[] = '../uploads/' . $resource_type . '/' . basename($file_path);
    }
    
    // Add additional patterns
    $patterns[] = '../NewAdminPanel/' . $file_path;
    $patterns[] = $file_path;
    
    // Return the first existing file path
    foreach ($patterns as $pattern) {
        if (file_exists($pattern)) {
            return $pattern;
        }
    }
    
    // If no file found, return the default expected path
    return '../uploads/' . $file_path;
}

// Check if resource file exists
function resourceFileExists($file_path, $resource_type) {
    $resolved_path = resolveResourcePath($file_path, $resource_type);
    return file_exists($resolved_path);
}

// Get resource file URL (web-accessible path for browser links)
function getResourceUrl($file_path, $resource_type) {
    if (!$file_path) return null;
    $file_path = ltrim($file_path, '/');
    
    // Check if file exists and get the correct path
    $resolved_path = resolveResourcePath($file_path, $resource_type);
    if (!file_exists($resolved_path)) {
        return null;
    }
    
    // Convert physical path to web URL - relative to StudentDashboard folder
    if (strpos($file_path, 'uploads/') === 0) {
        return '../' . $file_path;
    }
    return '../uploads/' . $resource_type . '/' . basename($file_path);
}

// Get student's purchased ebooks
function getStudentEbookEnrollments($student_id) {
    $conn = getDBConnection();
    
    // Get ebooks that the student has purchased directly
    $query = "SELECT eb.*, pe.purchased_at, pe.price as paid_price, pe.payment_status 
              FROM purchased_ebooks pe 
              JOIN ebooks eb ON pe.ebook_id = eb.id 
              WHERE pe.student_id = ? 
              AND pe.payment_status = 'paid' 
              ORDER BY pe.purchased_at DESC";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $student_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Get available ebooks for student to purchase (based on enrolled modules and classes)
function getAvailableEbooks($student_id = null) {
    $conn = getDBConnection();
    
    if ($student_id) {
        // Get ebooks that:
        // 1. Match the student's enrolled classes/modules
        // 2. Haven't been purchased yet by this student
        $query = "SELECT DISTINCT eb.* 
                  FROM ebooks eb 
                  JOIN enrollments e ON (eb.class = e.class AND eb.module = e.module)
                  WHERE e.student_id = ? 
                  AND e.payment_status = 'paid'
                  AND eb.id NOT IN (
                      SELECT pe.ebook_id 
                      FROM purchased_ebooks pe 
                      WHERE pe.student_id = ? 
                      AND pe.payment_status = 'paid'
                  )
                  ORDER BY eb.class, eb.module, eb.title";
        
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ii", $student_id, $student_id);
    } else {
        $query = "SELECT * FROM ebooks ORDER BY class, module, title";
        $stmt = mysqli_prepare($conn, $query);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Get specific ebook details
function getEbook($ebook_id) {
    $conn = getDBConnection();
    
    $query = "SELECT * FROM ebooks WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $ebook_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    return mysqli_fetch_assoc($result);
}

// Check if student has access to specific ebook
function hasEbookAccess($student_id, $ebook_id) {
    $conn = getDBConnection();
    
    $query = "SELECT COUNT(*) as count 
              FROM purchased_ebooks 
              WHERE student_id = ? 
              AND ebook_id = ? 
              AND payment_status = 'paid'";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $student_id, $ebook_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    
    return $row['count'] > 0;
}

// Get ebook file path (for downloads/viewing)
function getEbookFilePath($ebook_id) {
    $ebook = getEbook($ebook_id);
    if (!$ebook || !$ebook['file_path']) {
        return null;
    }
    
    // Use the same resolution pattern as other resources
    return resolveResourcePath($ebook['file_path'], 'ebooks');
}

// Check if ebook file exists
function ebookFileExists($ebook_id) {
    $file_path = getEbookFilePath($ebook_id);
    return $file_path && file_exists($file_path);
}

// Get ebook file URL (web-accessible path for browser links)
function getEbookUrl($ebook_id) {
    $ebook = getEbook($ebook_id);
    if (!$ebook || !$ebook['file_path']) {
        return null;
    }
    $file_path = ltrim($ebook['file_path'], '/');
    if (strpos($file_path, 'uploads/') === 0) {
        return '/' . $file_path;
    }
    return '/uploads/' . $file_path;
}

// Check if student can purchase a specific ebook (based on module enrollment)
function canPurchaseEbook($student_id, $ebook_id) {
    $conn = getDBConnection();
    
    // Check if student is enrolled in the module/class for this ebook
    $query = "SELECT COUNT(*) as count 
              FROM ebooks eb 
              JOIN enrollments e ON (eb.class = e.class AND eb.module = e.module)
              WHERE e.student_id = ? 
              AND eb.id = ? 
              AND e.payment_status = 'paid'";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $student_id, $ebook_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    
    return $row['count'] > 0;
}

// Create ebook purchase record
function createEbookPurchase($student_id, $ebook_id, $price, $transaction_id, $payment_status = 'pending') {
    $conn = getDBConnection();
    
    $query = "INSERT INTO purchased_ebooks (student_id, ebook_id, price, transaction_id, payment_status) 
              VALUES (?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iidss", $student_id, $ebook_id, $price, $transaction_id, $payment_status);
    
    if (mysqli_stmt_execute($stmt)) {
        return mysqli_insert_id($conn);
    }
    
    return false;
}

// Update ebook purchase status
function updateEbookPurchaseStatus($transaction_id, $payment_status) {
    $conn = getDBConnection();
    
    $query = "UPDATE purchased_ebooks SET payment_status = ? WHERE transaction_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $payment_status, $transaction_id);
    
    return mysqli_stmt_execute($stmt);
}
?>
