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

// Get student's ebook enrollments
$ebook_enrollments = getStudentEbookEnrollments($student_id);

// Get resource counts for the student
$homework_count = count(getStudentResources($student_id, 'homework'));
$activities_count = count(getStudentResources($student_id, 'activities'));
$answers_count = count(getStudentResources($student_id, 'answers'));
$ebooks_count = count($ebook_enrollments);
?>

<main class="main-content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="page-title">Dashboard</h1>
                    <p class="page-subtitle">Welcome back, <?php echo htmlspecialchars($current_student['name']); ?>!</p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <!-- Dashboard Statistics -->
            <div class="dashboard-stats">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-card-content">
                            <div class="stat-icon homework">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?php echo $homework_count; ?></h3>
                                <p>Homework Available</p>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-card-content">
                            <div class="stat-icon activities">
                                <i class="fas fa-play-circle"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?php echo $activities_count; ?></h3>
                                <p>Activities Available</p>
                            </div>
                        </div>
                    </div>                    <div class="stat-card">
                        <div class="stat-card-content">
                            <div class="stat-icon answers">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?php echo $answers_count; ?></h3>
                                <p>Answer Sheets Available</p>
                            </div>
                        </div>
                    </div>                    <div class="stat-card">
                        <div class="stat-card-content">
                            <div class="stat-icon ebooks">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?php echo $ebooks_count; ?></h3>
                                <p>E-Books Available</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- Quick Actions -->
            <div class="mt-4">
                <h2 class="mb-3">Quick Actions</h2>
                <div class="quick-actions-grid">
                    <div class="quick-actions-card">
                        <div class="stat-card-content">
                            <div class="stat-icon homework">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="stat-content">
                                <h4>Homework</h4>
                                <p>Access your homework assignments</p>
                                <a href="homework.php" class="btn btn-homework btn-sm mt-2">View All</a>
                            </div>
                        </div>
                    </div>
                    <div class="quick-actions-card">
                        <div class="stat-card-content">
                            <div class="stat-icon activities">
                                <i class="fas fa-play-circle"></i>
                            </div>
                            <div class="stat-content">
                                <h4>Activities</h4>
                                <p>Explore interactive activities</p>
                                <a href="activities.php" class="btn btn-activities btn-sm mt-2">Start Activity</a>
                            </div>
                        </div>
                    </div>
                    <div class="quick-actions-card">
                        <div class="stat-card-content">
                            <div class="stat-icon answers">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-content">
                                <h4>Answer Sheets</h4>
                                <p>Check your answer sheets</p>
                                <a href="answers.php" class="btn btn-answers btn-sm mt-2">View Answers</a>
                            </div>
                        </div>
                    </div>
                    <div class="quick-actions-card">
                        <div class="stat-card-content">
                            <div class="stat-icon ebooks">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <div class="stat-content">
                                <h4>E-Books</h4>
                                <p>Access your digital books</p>
                                <a href="ebooks.php" class="btn btn-ebooks btn-sm mt-2">View E-Books</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
