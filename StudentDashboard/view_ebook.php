<?php
require_once 'config/config.php';
require_once 'includes/auth.php';

// Check authentication
checkStudentAuth();

// Get current student info
$current_student = getCurrentStudent();
$student_id = $current_student['id'];

// Get ebook ID
$ebook_id = intval($_GET['id'] ?? 0);

if (!$ebook_id) {
    header('Location: ebooks.php?error=invalid_ebook');
    exit;
}

// Check if student has access to this ebook
if (!hasEbookAccess($student_id, $ebook_id)) {
    header('Location: ebooks.php?error=access_denied');
    exit;
}

// Get ebook details
$ebook = getEbook($ebook_id);
if (!$ebook) {
    header('Location: ebooks.php?error=ebook_not_found');
    exit;
}

// Get file path
$file_path = getEbookFilePath($ebook_id);
if (!$file_path || !file_exists($file_path)) {
    header('Location: ebooks.php?error=file_not_found');
    exit;
}

// Determine file type and appropriate viewer
$file_extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));

// Set appropriate headers
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="' . $ebook['title'] . '.pdf"');
header('Content-Length: ' . filesize($file_path));

// Output the file
readfile($file_path);
exit;
?>
