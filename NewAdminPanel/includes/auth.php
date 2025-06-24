<?php
// Simple authentication handler using existing system
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in and is admin
function checkAdminAuth() {
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header('Location: ' . dirname($_SERVER['PHP_SELF'], 2) . '/Login.php');
        exit;
    }
    
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header('HTTP/1.0 403 Forbidden');
        die('Access denied. Admin access required.');
    }
    
    // Check session timeout
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT)) {
        session_unset();
        session_destroy();
        header('Location: ' . dirname($_SERVER['PHP_SELF'], 2) . '/Login.php?timeout=1');
        exit;
    }
    
    // Update last activity
    $_SESSION['last_activity'] = time();
}

// Get current admin info from database using session user_id
function getCurrentAdmin() {
    global $connection;
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        return [
            'id' => null,
            'name' => 'Admin',
            'username' => 'Admin',
            'email' => null,
            'role' => null,
            'created_at' => null
        ];
    }
    $admin_id = $_SESSION['user_id'];
    $stmt = mysqli_prepare($connection, "SELECT id, fname, surname, email, created_at FROM students WHERE id = ? AND role = 'admin' LIMIT 1");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $admin_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $admin = mysqli_fetch_assoc($result);
        if ($admin) {
            return [
                'id' => $admin['id'],
                'name' => trim(($admin['fname'] ?? '') . ' ' . ($admin['surname'] ?? '')),
                'username' => $admin['fname'] ?? 'Admin',
                'email' => $admin['email'] ?? null,
                'role' => 'admin',
                'created_at' => $admin['created_at'] ?? null
            ];
        }
    }
    // fallback
    return [
        'id' => $_SESSION['user_id'],
        'name' => $_SESSION['fname'] ?? 'Admin',
        'username' => $_SESSION['fname'] ?? 'Admin',
        'email' => $_SESSION['email'] ?? null,
        'role' => $_SESSION['role'] ?? null,
        'created_at' => $_SESSION['created_at'] ?? null
    ];
}

// Database connection function using existing dbconfig
function getDBConnection() {
    global $connection;
    return $connection;
}

// Sanitize input
function sanitizeInput($input) {
    if (is_array($input)) {
        return array_map('sanitizeInput', $input);
    }
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// File upload validation
function validateFileUpload($file, $allowed_types = null) {
    if (!$allowed_types) {
        $allowed_types = ALLOWED_FILE_TYPES;
    }
    
    $errors = [];
    
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'File upload error occurred.';
        return $errors;
    }
    
    if ($file['size'] > MAX_FILE_SIZE) {
        $errors[] = 'File size exceeds maximum allowed size (' . (MAX_FILE_SIZE / 1024 / 1024) . 'MB).';
    }
    
    $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($file_ext, $allowed_types)) {
        $errors[] = 'File type not allowed. Allowed types: ' . implode(', ', $allowed_types);
    }
    
    return $errors;
}

// Generate unique filename
function generateUniqueFilename($original_name, $directory) {
    $extension = pathinfo($original_name, PATHINFO_EXTENSION);
    $basename = pathinfo($original_name, PATHINFO_FILENAME);
    $basename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $basename);
    
    $counter = 1;
    $filename = $basename . '.' . $extension;
    
    while (file_exists($directory . '/' . $filename)) {
        $filename = $basename . '_' . $counter . '.' . $extension;
        $counter++;
    }
    
    return $filename;
}
?>
