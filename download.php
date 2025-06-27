<?php
// Secure File Download with Proper Authorization
if (!isset($_SESSION)) {
    session_start();
}

require_once 'database/dbconfig.php';

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: Login.php');
    exit();
}

// Get the filename from the query string
$file = isset($_GET['file']) ? $_GET['file'] : '';
$resource_type = isset($_GET['type']) ? $_GET['type'] : '';
$action = isset($_GET['action']) ? $_GET['action'] : 'download'; // 'view' or 'download'

if (empty($file)) {
    http_response_code(400);
    die('No file specified.');
}

// Enhanced security: prevent directory traversal attacks
$file = str_replace(['../', '..\\', '../', '..'], '', $file);

// Determine the full file path
$fullPath = '';
if (strpos($file, 'uploads/') === 0) {
    $fullPath = __DIR__ . '/' . $file;
} else {
    // For backward compatibility, also check with basename
    $basename = basename($file);
    $fullPath = __DIR__ . '/uploads/' . $basename;
    
    // If basename doesn't exist, try the full path in uploads
    if (!file_exists($fullPath)) {
        $fullPath = __DIR__ . '/uploads/' . $file;
    }
}

// Check if file exists
if (!file_exists($fullPath) || !is_file($fullPath)) {
    http_response_code(404);
    die('File not found.');
}

// Authorization checks based on user role
$user_role = $_SESSION['role'] ?? '';
$user_id = $_SESSION['id'] ?? 0;

if ($user_role === 'admin') {
    // Admins can access all files
    if ($action === 'view') {
        viewFile($fullPath);
    } else {
        downloadFile($fullPath);
    }
} elseif ($user_role === 'user') {
    // Students need permission validation
    if (validateStudentFileAccess($user_id, $file, $resource_type, $fullPath)) {
        if ($action === 'view') {
            viewFile($fullPath);
        } else {
            downloadFile($fullPath);
        }
    } else {
        http_response_code(403);
        die('Access denied. You do not have permission to access this file.');
    }
} else {
    http_response_code(403);
    die('Access denied. Invalid user role.');
}

/**
 * Validate if a student has access to a specific file
 */
function validateStudentFileAccess($student_id, $file_path, $resource_type, $full_path) {
    global $connection;
    
    // Extract resource type from file path if not provided
    if (empty($resource_type)) {
        if (strpos($file_path, 'homework/') !== false || strpos($full_path, 'homework/') !== false) {
            $resource_type = 'homework';
        } elseif (strpos($file_path, 'activities/') !== false || strpos($full_path, 'activities/') !== false) {
            $resource_type = 'activities';
        } elseif (strpos($file_path, 'answers/') !== false || strpos($full_path, 'answers/') !== false) {
            $resource_type = 'answers';
        } elseif (strpos($file_path, 'ebooks/') !== false || strpos($full_path, 'ebooks/') !== false) {
            $resource_type = 'ebooks';
        }
    }
    
    // For regular resources (homework, activities, answers)
    if (in_array($resource_type, ['homework', 'activities', 'answers'])) {
        return validateResourceAccess($student_id, $file_path, $resource_type);
    }
    
    // For ebooks - check purchased_ebooks table
    if ($resource_type === 'ebooks') {
        return validateEbookAccess($student_id, $file_path);
    }
    
    // For newsletter or other files, deny access to students
    return false;
}

/**
 * Validate access to homework, activities, answers based on enrollment
 */
function validateResourceAccess($student_id, $file_path, $resource_type) {
    global $connection;
    
    // Try multiple variations of the file path to match database records
    $paths_to_check = [
        $file_path,
        'uploads/' . $file_path,
        'uploads/' . $resource_type . '/' . basename($file_path),
        $resource_type . '/' . basename($file_path),
        basename($file_path)
    ];
    
    foreach ($paths_to_check as $path) {
        $query = "SELECT r.*, e.student_id 
                  FROM resources r
                  JOIN enrollments e ON (r.class = e.class AND r.module = e.module)
                  WHERE r.resource_type = ? 
                  AND (r.file_path = ? OR r.file_name = ?)
                  AND e.student_id = ? 
                  AND e.payment_status = 'paid'";
        
        $stmt = mysqli_prepare($connection, $query);
        $filename = basename($path);
        mysqli_stmt_bind_param($stmt, "sssi", $resource_type, $path, $filename, $student_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) > 0) {
            return true;
        }
    }
    
    return false;
}

/**
 * Validate ebook access based on purchase
 */
function validateEbookAccess($student_id, $file_path) {
    global $connection;
    
    // Try multiple variations of the file path
    $paths_to_check = [
        $file_path,
        'uploads/' . $file_path,
        'uploads/ebooks/' . basename($file_path),
        'ebooks/' . basename($file_path),
        basename($file_path)
    ];
    
    foreach ($paths_to_check as $path) {
        $query = "SELECT pe.student_id 
                  FROM purchased_ebooks pe
                  JOIN ebooks e ON pe.ebook_id = e.id
                  WHERE (e.file_path = ? OR e.file_name = ?)
                  AND pe.student_id = ? 
                  AND pe.payment_status = 'paid'";
        
        $stmt = mysqli_prepare($connection, $query);
        $filename = basename($path);
        mysqli_stmt_bind_param($stmt, "ssi", $path, $filename, $student_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) > 0) {
            return true;
        }
    }
    
    return false;
}

/**
 * Securely view the file in browser
 */
function viewFile($filePath) {
    $filename = basename($filePath);
    $filesize = filesize($filePath);
    
    // Get file extension for proper content type
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $contentType = getContentType($ext);
    
    // Check if file can be viewed in browser
    $viewableTypes = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg', 'txt', 'html', 'htm'];
    
    if (!in_array($ext, $viewableTypes)) {
        // If file can't be viewed, force download instead
        downloadFile($filePath);
        return;
    }
    
    // Set appropriate headers for viewing
    header('Content-Type: ' . $contentType);
    header('Content-Length: ' . $filesize);
    header('Content-Disposition: inline; filename="' . $filename . '"');
    header('Cache-Control: public, max-age=3600'); // Cache for 1 hour
    header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');
    
    // Security headers
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    
    // Clear output buffer
    if (ob_get_level()) {
        ob_end_clean();
    }
    
    // Read and output file
    readfile($filePath);
    exit();
}

/**
 * Securely download the file
 */
function downloadFile($filePath) {
    $filename = basename($filePath);
    $filesize = filesize($filePath);
    
    // Get file extension for proper content type
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $contentType = getContentType($ext);
    
    // Set appropriate headers
    header('Content-Description: File Transfer');
    header('Content-Type: ' . $contentType);
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . $filesize);
    
    // Clear output buffer
    if (ob_get_level()) {
        ob_end_clean();
    }
    
    // Read and output file
    readfile($filePath);
    exit();
}

/**
 * Get appropriate content type based on file extension
 */
function getContentType($extension) {
    $mimeTypes = [
        'pdf' => 'application/pdf',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'webp' => 'image/webp',
        'svg' => 'image/svg+xml',
        'txt' => 'text/plain',
        'html' => 'text/html',
        'htm' => 'text/html',
        'mp4' => 'video/mp4',
        'mp3' => 'audio/mpeg',
        'zip' => 'application/zip',
    ];
    
    return $mimeTypes[$extension] ?? 'application/octet-stream';
}
?>