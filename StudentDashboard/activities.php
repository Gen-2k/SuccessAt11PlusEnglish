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

// Get activities resources for the student
$activities_resources = getStudentResources($student_id, 'activities');
?>

<main class="main-content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="page-title">Activities</h1>
                    <p class="page-subtitle">Explore interactive learning activities</p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Activities</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>    <div class="content">
        <div class="container-fluid">
            <!-- Activities Resources -->
            <?php if (!empty($activities_resources)): ?>            <div class="resource-grid">
                <?php foreach ($activities_resources as $resource): ?>
                <div class="resource-card activities">
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
                            <?php if ($resource['file_path'] && resourceFileExists($resource['file_path'], 'activities')): ?>
                            <a href="<?php echo htmlspecialchars(getResourceUrl($resource['file_path'], 'activities')); ?>" 
                               target="_blank" class="btn btn-activities">
                                <i class="fas fa-play"></i> Start Activity
                            </a>
                            <?php else: ?>
                            <button class="btn btn-outline" disabled>
                                <i class="fas fa-exclamation-triangle"></i> Activity Not Available
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
            <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-puzzle-piece"></i>
                </div>
                <h3 class="empty-state-title">No Activities Available</h3>
                <!-- <p class="empty-state-text">
                    You don't have access to any learning activities yet. Check back later or contact your instructor for more information.
                </p>
                <a href="index.php" class="btn btn-activities">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a> -->
            </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
