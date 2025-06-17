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

// Get homework resources for the student
$homework_resources = getStudentResources($student_id, 'homework');
?>

<main class="main-content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="page-title">Homework</h1>
                    <p class="page-subtitle">Access your homework assignments</p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Homework</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>    <div class="content">
        <div class="container-fluid">
            <!-- Homework Resources -->
            <?php if (!empty($homework_resources)): ?>            <div class="resource-grid">
                <?php foreach ($homework_resources as $resource): ?>
                <div class="resource-card homework">
                    <div class="resource-card-header">
                        <h3 class="resource-card-title"><?php echo htmlspecialchars($resource['title']); ?></h3>
                        <div class="resource-card-meta">
                            <?php if ($resource['class']): ?>
                            <span><i class="fas fa-graduation-cap"></i> <?php echo htmlspecialchars($resource['class']); ?></span>
                            <?php endif; ?>
                            <?php if ($resource['module']): ?>
                            <span><i class="fas fa-folder"></i> <?php echo htmlspecialchars($resource['module']); ?></span>
                            <?php endif; ?>
                            <span><i class="fas fa-calendar"></i> <?php echo date('M j, Y', strtotime($resource['created_at'])); ?></span>
                        </div>
                    </div>
                    <div class="resource-card-body">                        <?php if ($resource['description']): ?>
                        <p class="resource-description"><?php echo htmlspecialchars($resource['description']); ?></p>
                        <?php endif; ?>
                        
                        <div class="resource-actions">
                            <?php if ($resource['file_path'] && resourceFileExists($resource['file_path'], 'homework')): ?>                            <a href="<?php echo htmlspecialchars(getResourceUrl($resource['file_path'], 'homework')); ?>" 
                               target="_blank" class="btn btn-homework">
                                <i class="fas fa-eye"></i> View Homework
                            </a>
                            <?php else: ?>
                            <button class="btn btn-outline" disabled>
                                <i class="fas fa-exclamation-triangle"></i> File Not Available
                            </button>
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle"></i> File path: <?php echo htmlspecialchars($resource['file_path'] ?? 'No file path'); ?>
                            </small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <h3 class="empty-state-title">No Homework Available</h3>
                <p class="empty-state-text">
                    You don't have access to any homework assignments yet. Check back later or contact your instructor for more information.
                </p>                <a href="index.php" class="btn btn-homework">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
