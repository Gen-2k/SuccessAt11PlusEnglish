<?php
require_once 'config/config.php';
require_once 'includes/auth.php';

// Check authentication
checkStudentAuth();

// Include header and navigation
include 'includes/header.php';
include 'includes/navigation.php';

// Get current student info
$current_student = getCurrentStudent();
$student_id = $current_student['id'];

// Get student's accessible ebooks and available ebooks for purchase
$accessible_ebooks = getStudentEbookEnrollments($student_id);
$available_ebooks = getAvailableEbooks($student_id);
?>

<main class="main-content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="page-title">E-Books</h1>
                    <p class="page-subtitle">Access your digital learning materials</p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">E-Books</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <!-- Success/Error Messages -->
            <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <?php echo $_SESSION['success_message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success_message']); endif; ?>

            <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> <?php echo $_SESSION['error_message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error_message']); endif; ?>            <?php 
            $error = $_GET['error'] ?? '';
            $purchase = $_GET['purchase'] ?? '';
            $payment = $_GET['payment'] ?? '';
            
            if ($error):
                $error_messages = [
                    'invalid_ebook' => 'Invalid e-book selected.',
                    'access_denied' => 'You do not have access to this e-book.',
                    'ebook_not_found' => 'E-book not found.',
                    'file_not_found' => 'E-book file not found.',
                    'already_owned' => 'You already have access to this e-book.',
                    'payment_failed' => 'Payment processing failed. Please try again.',
                    'payment_setup_failed' => 'Unable to setup payment. Please try again later.',
                    'module_not_enrolled' => 'You must be enrolled in the module to purchase this e-book.'
                ];
                $message = $error_messages[$error] ?? 'An unknown error occurred.';
            ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <!-- My E-Books -->
            <?php if (!empty($accessible_ebooks)): ?>
            <div class="mb-4">
                <h2 class="mb-3">
                    <i class="fas fa-book-reader text-success"></i> My E-Books
                    <span class="badge bg-success"><?php echo count($accessible_ebooks); ?></span>
                </h2>                <div class="resource-grid">
                    <?php foreach ($accessible_ebooks as $ebook): ?>
                    <div class="resource-card ebooks">
                        <div class="resource-card-header">
                            <h3 class="resource-card-title"><?php echo htmlspecialchars($ebook['title']); ?></h3>
                            <div class="resource-card-meta">
                                <span><i class="fas fa-graduation-cap"></i> <?php echo htmlspecialchars($ebook['class']); ?></span>
                                <span><i class="fas fa-book"></i> <?php echo htmlspecialchars($ebook['module']); ?></span>
                                <span><i class="fas fa-check-circle"></i> Owned</span>
                            </div>
                        </div>
                        <div class="resource-card-body">
                            <?php if ($ebook['description']): ?>
                            <p class="resource-description">
                                <?php echo htmlspecialchars(substr($ebook['description'], 0, 150)) . (strlen($ebook['description']) > 150 ? '...' : ''); ?>
                            </p>
                            <?php endif; ?>                            <div class="resource-actions">
                                <?php if (ebookFileExists($ebook['id'])): ?>
                                <a href="view_ebook.php?id=<?php echo $ebook['id']; ?>" 
                                   class="btn btn-ebooks" target="_blank">
                                    <i class="fas fa-eye"></i> View E-Book
                                </a>
                                <?php else: ?>
                                <button class="btn btn-outline" disabled>
                                    <i class="fas fa-exclamation-triangle"></i> Not Available
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>            <?php endif; ?>

            <!-- Available E-Books for Purchase -->
            <?php if (!empty($available_ebooks)): ?>
            <div class="mb-4">
                <h2 class="mb-3">
                    <i class="fas fa-shopping-cart text-primary"></i> Available for Purchase
                    <span class="badge bg-primary"><?php echo count($available_ebooks); ?></span>
                </h2>                <div class="resource-grid">
                    <?php foreach ($available_ebooks as $ebook): ?>
                    <div class="resource-card ebooks">
                        <?php if ($ebook['price'] == 0): ?>
                        <div class="card-badge">Free</div>
                        <?php endif; ?>
                        <div class="resource-card-header">
                            <h3 class="resource-card-title"><?php echo htmlspecialchars($ebook['title']); ?></h3>
                            <div class="resource-card-meta">
                                <span><i class="fas fa-graduation-cap"></i> <?php echo htmlspecialchars($ebook['class']); ?></span>
                                <span><i class="fas fa-book"></i> <?php echo htmlspecialchars($ebook['module']); ?></span>
                                <span><i class="fas fa-tag"></i> <?php echo $ebook['price'] > 0 ? '£' . number_format($ebook['price'], 2) : 'Free'; ?></span>
                            </div>
                        </div>
                        <div class="resource-card-body">
                            <?php if ($ebook['description']): ?>
                            <p class="resource-description">
                                <?php echo htmlspecialchars(substr($ebook['description'], 0, 150)) . (strlen($ebook['description']) > 150 ? '...' : ''); ?>
                            </p>
                            <?php endif; ?>                            <div class="resource-actions">
                                <?php if ($ebook['price'] > 0): ?>
                                <button class="btn btn-ebooks" onclick="purchaseEbook(<?php echo $ebook['id']; ?>, '<?php echo addslashes($ebook['title']); ?>', <?php echo $ebook['price']; ?>)">
                                    <i class="fas fa-credit-card"></i> Purchase £<?php echo number_format($ebook['price'], 2); ?>
                                </button>
                                <?php else: ?>
                                <button class="btn btn-ebooks" onclick="claimFreeEbook(<?php echo $ebook['id']; ?>, '<?php echo addslashes($ebook['title']); ?>')">
                                    <i class="fas fa-gift"></i> Get Free
                                </button>
                                <?php endif; ?>
                                <button class="btn btn-outline" onclick="viewEbookDetails(<?php echo $ebook['id']; ?>)">
                                    <i class="fas fa-info-circle"></i> Details
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>            <!-- Empty State -->
            <?php if (empty($accessible_ebooks) && empty($available_ebooks)): ?>
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <h3 class="empty-state-title">No E-Books Available</h3>               
                 <!-- <p class="empty-state-text">
                    E-books are only available for modules you're enrolled in. Purchase a module first to access its e-books.
                </p>
                <a href="index.php" class="btn btn-ebooks">View Available Modules</a> -->
            </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<!-- E-Book Details Modal -->
<div class="modal fade" id="ebookDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">E-Book Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="ebookDetailsContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>



<script>
function purchaseEbook(ebookId, title, price) {
    if (confirm(`Purchase "${title}" for £${price.toFixed(2)}?`)) {
        // Redirect to payment processing
        window.location.href = `process_ebook_payment.php?ebook_id=${ebookId}`;
    }
}

function claimFreeEbook(ebookId, title) {
    if (confirm(`Claim free e-book "${title}"?`)) {
        // Process free ebook claim
        fetch('process_ebook_payment.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `ebook_id=${ebookId}&action=claim_free`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('E-book claimed successfully!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while claiming the e-book.');
        });
    }
}

function viewEbookDetails(ebookId) {
    fetch(`get_ebook_details.php?id=${ebookId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('ebookDetailsContent').innerHTML = data.html;
                new bootstrap.Modal(document.getElementById('ebookDetailsModal')).show();
            } else {
                alert('Error loading e-book details');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while loading e-book details.');
        });
}
</script>

<?php include 'includes/footer.php'; ?>
