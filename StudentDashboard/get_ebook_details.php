<?php
require_once 'config/config.php';
require_once 'includes/auth.php';

// Check authentication
checkStudentAuth();

// Get ebook ID
$ebook_id = intval($_GET['id'] ?? 0);

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

// Build HTML content for the modal
$html = '
<div class="ebook-details">
    <div class="row">
        <div class="col-md-12 mb-3">
            <h4>' . htmlspecialchars($ebook['title']) . '</h4>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="info-group">
                <label><strong>Class:</strong></label>
                <span class="badge bg-info">' . htmlspecialchars(ucfirst(str_replace('year', 'Year ', $ebook['class']))) . '</span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="info-group">
                <label><strong>Module:</strong></label>
                <span class="badge bg-secondary">' . htmlspecialchars($ebook['module']) . '</span>
            </div>
        </div>
    </div>
    
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="info-group">
                <label><strong>Price:</strong></label>
                ' . ($ebook['price'] > 0 ? 
                    '<span class="badge bg-success">£' . number_format($ebook['price'], 2) . '</span>' : 
                    '<span class="badge bg-primary">Free</span>') . '
            </div>
        </div>
        <div class="col-md-6">
            <div class="info-group">
                <label><strong>Added:</strong></label>
                <span>' . date('M j, Y', strtotime($ebook['created_at'])) . '</span>
            </div>
        </div>
    </div>';

if ($ebook['description']) {
    $html .= '
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="info-group">
                <label><strong>Description:</strong></label>
                <p class="mt-2">' . nl2br(htmlspecialchars($ebook['description'])) . '</p>
            </div>
        </div>
    </div>';
}

// Check if student has access
$current_student = getCurrentStudent();
$student_id = $current_student['id'];
$has_access = hasEbookAccess($student_id, $ebook_id);

// Professional, modern modal footer (only positive message if access)
if ($has_access) {
    $html .= '
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="alert alert-success d-flex align-items-center gap-2" style="border-radius: 8px; font-size: 1.08rem; padding: 1.1rem 1.4rem; background: #e8f5e8; border: 1.5px solid #b6e2c6; color: #198754; box-shadow: 0 2px 8px rgba(34,197,94,0.07);">
                <i class="fas fa-check-circle text-success" style="font-size: 1.5rem;"></i>
                <span style="font-weight: 500;">You have access to this e-book through your current enrollments.</span>
            </div>
        </div>
    </div>';
}

$html .= '
</div>

<style>
.ebook-details { padding: 0.5rem 0 0.5rem 0; }
.ebook-details h4 {
    font-weight: 700;
    color: #1e40af;
    margin-bottom: 0.5rem;
    letter-spacing: 0.01em;
    font-size: 1.5rem;
}
.ebook-details .info-group {
    margin-bottom: 1.1rem;
    background: #f8f9fa;
    border-radius: 8px;
    padding: 0.85rem 1.2rem;
    box-shadow: 0 1px 4px rgba(110,32,167,0.06);
    border: 1px solid #ececec;
}
.ebook-details .info-group label {
    display: block;
    margin-bottom: 0.25rem;
    color: #1e40af;
    font-weight: 600;
    font-size: 1.07rem;
}
.ebook-details .badge {
    font-size: 1.01rem;
    padding: 0.48em 0.95em;
    border-radius: 0.5em;
    font-weight: 500;
    letter-spacing: 0.01em;
}
.ebook-details .alert {
    margin-bottom: 0;
    border-radius: 8px;
    font-size: 1.08rem;
    padding: 1.1rem 1.4rem;
    background: #f8f9fa;
    border: 1.5px solid #e0e0e0;
    color: #333;
    box-shadow: 0 2px 8px rgba(110,32,167,0.04);
}
.ebook-details .alert-success {
    background: #e8f5e8;
    border-color: #b6e2c6;
    color: #198754;
    box-shadow: 0 2px 8px rgba(34,197,94,0.07);
}
</style>';

echo json_encode(['success' => true, 'html' => $html]);
?>
