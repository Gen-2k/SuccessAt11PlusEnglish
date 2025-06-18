<?php
require_once 'config/config.php';
require_once 'includes/auth.php';

// Check authentication
checkAdminAuth();

// Include header and navigation
include 'includes/header.php';
include 'includes/navigation.php';

// Get database connection
$conn = getDBConnection();

// Get newsletter subscriber count
$subscriberCount = 0;
$subscribers = [];

if ($conn) {
    // Get subscriber count
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM newsletter");
    if ($result) {
        $subscriberCount = mysqli_fetch_assoc($result)['count'];
    } else {
        error_log("Newsletter count query error: " . mysqli_error($conn));
    }
    
    // Get all subscribers for display
    $result = mysqli_query($conn, "SELECT * FROM newsletter ORDER BY subscribed_at DESC");
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $subscribers[] = $row;
        }
    } else {
        error_log("Newsletter subscribers query error: " . mysqli_error($conn));
    }
} else {
    error_log("Database connection error in newsletter.php");
}
?>

<main class="main-content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="page-title">Newsletter Management</h1>
                    <p class="page-subtitle">Send newsletters to subscribers</p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Newsletter</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>    <div class="content">
        <div class="container-fluid">
            <!-- Main Newsletter Content -->
            <div class="row">
                <!-- Newsletter Compose Section -->                <div class="col-lg-8 mb-4">
                    <div class="card h-100">
                        <div class="card-header newsletter-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Newsletter Management</h4>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sendNewsletterModal">
                                <i class="fas fa-paper-plane me-1"></i> Send Newsletter
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <!-- Statistics Overview -->
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-3 bg-light rounded">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-users fa-2x text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="mb-1"><?php echo $subscriberCount; ?></h5>
                                            <p class="text-muted mb-0">Total Subscribers</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-3 bg-light rounded">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-calendar-plus fa-2x text-success"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="mb-1">
                                                <?php 
                                                $thisMonth = date('Y-m');
                                                $monthlyCount = 0;
                                                foreach ($subscribers as $sub) {
                                                    if (strpos($sub['subscribed_at'], $thisMonth) === 0) {
                                                        $monthlyCount++;
                                                    }
                                                }
                                                echo $monthlyCount;
                                                ?>
                                            </h5>
                                            <p class="text-muted mb-0">New This Month</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if (!empty($subscribers)): ?>
                            <div class="mt-4 p-3 border rounded">
                                <h6 class="mb-2"><i class="fas fa-user-plus me-1"></i> Latest Subscriber</h6>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <strong><?php echo htmlspecialchars($subscribers[0]['fname'] . ' ' . $subscribers[0]['lname']); ?></strong>
                                        <br>
                                        <small class="text-muted"><?php echo htmlspecialchars($subscribers[0]['email']); ?></small>
                                    </div>
                                    <small class="text-muted"><?php echo date('M d, Y', strtotime($subscribers[0]['subscribed_at'])); ?></small>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                  <!-- Subscribers List Section -->
                <div class="col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-header subscribers-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Subscribers</h4>
                            <?php if (!empty($subscribers)): ?>
                                <button type="button" class="btn btn-outline-secondary" onclick="exportSubscribers()" title="Export to CSV">
                                    <i class="fas fa-download"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                        <div class="card-body p-0">
                            <div class="newsletter-subscribers" style="max-height: 400px; overflow-y: auto;">
                                <?php if (!empty($subscribers)): ?>
                                    <?php foreach ($subscribers as $index => $subscriber): ?>
                                        <div class="p-3 border-bottom subscriber-item">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 14px;">
                                                        <?php echo strtoupper(substr($subscriber['fname'], 0, 1)); ?>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-1"><?php echo htmlspecialchars($subscriber['fname'] . ' ' . $subscriber['lname']); ?></h6>
                                                    <p class="text-muted mb-1 small"><?php echo htmlspecialchars($subscriber['email']); ?></p>
                                                    <small class="text-muted"><?php echo date('M d, Y', strtotime($subscriber['subscribed_at'])); ?></small>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="p-4 text-center">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted mb-0">No subscribers yet</p>
                                        <small class="text-muted">Subscribers will appear here once they sign up for your newsletter</small>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Send Newsletter Modal -->
<div class="modal fade newsletter-modal" id="sendNewsletterModal" tabindex="-1" aria-labelledby="sendNewsletterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sendNewsletterModalLabel">
                    <i class="fas fa-paper-plane"></i> Send Newsletter
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="newsletterForm" class="newsletter-form" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> This newsletter will be sent to <strong><?php echo $subscriberCount; ?></strong> subscribers.
                    </div>
                    
                    <div class="mb-3">
                        <label for="newsletterTitle" class="form-label">Newsletter Title *</label>
                        <input type="text" class="form-control" id="newsletterTitle" name="newsletterTitle" placeholder="Enter newsletter title" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="newsletterMessage" class="form-label">Message *</label>
                        <textarea class="form-control" id="newsletterMessage" name="newsletterMessage" rows="8" placeholder="Enter your newsletter message..." required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="newsletterFile" class="form-label">Attachment (optional)</label>
                        <input type="file" class="form-control" id="newsletterFile" name="newsletterFile" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <div class="form-text">Supported formats: PDF, DOC, DOCX, JPG, JPEG, PNG (Max 5MB)</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="sendBtn">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <span class="btn-text">Send Newsletter</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Success/Error Alert -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1050">
    <div id="alertToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="fas fa-check-circle text-success me-2" id="toastIcon"></i>
            <strong class="me-auto" id="toastTitle">Newsletter</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toastMessage">
            Message will appear here
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#newsletterForm').on('submit', function(e) {
        e.preventDefault();
          // Enhanced form validation
        var title = $('#newsletterTitle').val().trim();
        var message = $('#newsletterMessage').val().trim();
        
        if (!title) {
            showToast('📝 Title Required', 'Please enter a title for your newsletter.', 'error');
            $('#newsletterTitle').focus();
            return;
        }
        
        if (title.length < 3) {
            showToast('📝 Title Too Short', 'Newsletter title should be at least 3 characters long.', 'error');
            $('#newsletterTitle').focus();
            return;
        }
        
        if (!message) {
            showToast('💬 Message Required', 'Please enter the newsletter content/message.', 'error');
            $('#newsletterMessage').focus();
            return;
        }
        
        if (message.length < 10) {
            showToast('💬 Message Too Short', 'Newsletter message should be at least 10 characters long.', 'error');
            $('#newsletterMessage').focus();
            return;
        }
        
        // File validation (if file is selected)
        var fileInput = $('#newsletterFile')[0];
        if (fileInput.files.length > 0) {
            var file = fileInput.files[0];
            var maxSize = 5 * 1024 * 1024; // 5MB
            var allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/jpg', 'image/png'];
            
            if (file.size > maxSize) {
                showToast('📎 File Too Large', 'Attachment must be smaller than 5MB. Please choose a smaller file.', 'error');
                return;
            }
            
            if (!allowedTypes.includes(file.type)) {
                showToast('📎 Invalid File Type', 'Please attach a PDF, DOC, DOCX, JPG, JPEG, or PNG file.', 'error');
                return;
            }
        }
          // Enhanced loading state with progress indication
        var $sendBtn = $('#sendBtn');
        var $spinner = $sendBtn.find('.spinner-border');
        var $btnText = $sendBtn.find('.btn-text');
        
        $sendBtn.prop('disabled', true).addClass('btn-loading');
        $spinner.removeClass('d-none');
        $btnText.text('Sending Newsletter...');
        
        // Show progress toast
        showToast('📤 Sending...', 'Your newsletter is being sent to all subscribers. This may take a moment.', 'info');
        
        // Prepare form data
        var formData = new FormData(this);
        formData.append('action', 'send_newsletter');
        
        // Send AJAX request
        $.ajax({
            url: 'newsletter_handler.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,            success: function(response) {
                console.log('Response received:', response);
                try {
                    var result = typeof response === 'string' ? JSON.parse(response) : response;
                    
                    if (result.success) {
                        // Enhanced success message with stats if available
                        var successTitle = '✅ Newsletter Sent Successfully!';
                        var successMessage = result.message;
                        
                        if (result.stats) {
                            successMessage += `\n\n📊 Delivery Summary:\n• Sent: ${result.stats.sent}\n• Total: ${result.stats.total}\n• Time: ${result.stats.duration}`;
                        }
                        
                        showToast(successTitle, successMessage, 'success');
                        $('#sendNewsletterModal').modal('hide');
                        $('#newsletterForm')[0].reset();
                    } else {
                        showToast('❌ Delivery Failed', result.message || 'Unable to send newsletter. Please try again.', 'error');
                    }
                } catch (e) {
                    console.error('Response parsing error:', e);
                    console.error('Raw response:', response);
                    showToast('⚠️ System Error', 'Received invalid response from server. Please refresh the page and try again.', 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('Network error:', {status: status, error: error, response: xhr.responseText});
                
                var errorMessage = 'Network error occurred. ';
                if (xhr.status === 0) {
                    errorMessage += 'Please check your internet connection.';
                } else if (xhr.status >= 500) {
                    errorMessage += 'Server error - please try again later.';
                } else if (xhr.status === 404) {
                    errorMessage += 'Service not found. Please contact support.';
                } else {
                    errorMessage += `Error ${xhr.status}: ${error}`;
                }
                
                showToast('🔌 Connection Error', errorMessage, 'error');
            },            complete: function() {
                // Reset button state with proper cleanup
                $sendBtn.prop('disabled', false).removeClass('btn-loading');
                $spinner.addClass('d-none');
                $btnText.text('Send Newsletter');
            }
        });
    });    function showToast(title, message, type) {
        var $toast = $('#alertToast');
        var $icon = $('#toastIcon');
        var $title = $('#toastTitle');
        var $message = $('#toastMessage');
        
        // Set icon and styling based on type
        if (type === 'success') {
            $icon.removeClass('fa-exclamation-circle text-danger fa-info-circle text-info').addClass('fa-check-circle text-success');
            $toast.removeClass('border-danger border-info').addClass('border-success');
        } else if (type === 'info') {
            $icon.removeClass('fa-exclamation-circle text-danger fa-check-circle text-success').addClass('fa-info-circle text-info');
            $toast.removeClass('border-danger border-success').addClass('border-info');
        } else {
            $icon.removeClass('fa-check-circle text-success fa-info-circle text-info').addClass('fa-exclamation-circle text-danger');
            $toast.removeClass('border-success border-info').addClass('border-danger');
        }
        
        $title.text(title);
        
        // Handle multiline messages by preserving line breaks
        if (message.includes('\n')) {
            $message.html(message.replace(/\n/g, '<br>'));
        } else {
            $message.text(message);
        }
        
        // Auto-hide timeout based on message length and type
        var baseDelay = type === 'info' ? 3000 : type === 'success' ? 5000 : 4000;
        var hideDelay = Math.min(Math.max(message.length * 40, baseDelay), 12000);
        
        // Show toast with custom delay
        var toast = new bootstrap.Toast($toast[0], {
            delay: hideDelay
        });
        toast.show();
    }
});

// Export subscribers function
function exportSubscribers() {
    var csvContent = "data:text/csv;charset=utf-8,";
    csvContent += "Name,Email,Subscription Date\n";
    
    <?php if (!empty($subscribers)): ?>
        <?php foreach ($subscribers as $subscriber): ?>
            csvContent += "<?php echo htmlspecialchars($subscriber['fname'] . ' ' . $subscriber['lname']); ?>,<?php echo htmlspecialchars($subscriber['email']); ?>,<?php echo date('Y-m-d', strtotime($subscriber['subscribed_at'])); ?>\n";
        <?php endforeach; ?>
    <?php endif; ?>
    
    var encodedUri = encodeURI(csvContent);
    var link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "newsletter_subscribers_" + new Date().toISOString().slice(0,10) + ".csv");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>

<?php include 'includes/footer.php'; ?>
