<?php
require_once 'config/config.php';
require_once 'includes/auth.php';

// Check authentication
checkAdminAuth();

// Include header and navigation
include 'includes/header.php';
include 'includes/navigation.php';
include 'includes/dashboard_stats.php';
?>

<main class="main-content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="page-title">Dashboard</h1>
                    <p class="page-subtitle">Welcome to the Admin Dashboard</p>
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

    <div class="content">        <div class="container-fluid">
            <!-- Dashboard Statistics -->
            <div class="dashboard-stats">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-card-content">
                            <div class="stat-icon students">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?php echo $totalStudents; ?></h3>
                                <p>Total Students</p>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-card-content">
                            <div class="stat-icon students">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?php echo $totalActiveStudents; ?></h3>
                                <p>Active Students</p>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-card-content">
                            <div class="stat-icon homework">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?php echo $totalHomeworks; ?></h3>
                                <p>Homework Items</p>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-card-content">
                            <div class="stat-icon activities">
                                <i class="fas fa-play-circle"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?php echo $totalActivities; ?></h3>
                                <p>Activities</p>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-card-content">
                            <div class="stat-icon ebooks">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?php echo $totalEbooks; ?></h3>
                                <p>E-Books</p>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-card-content">
                            <div class="stat-icon answers">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?php echo $totalAnswers; ?></h3>
                                <p>Answer Sheets</p>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-card-content">
                            <div class="stat-icon newsletter">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?php echo $totalNewsletter; ?></h3>
                                <p>Newsletter Subscribers</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Dashboard Statistics -->
    </div>
</main>

<?php include 'includes/footer.php'; ?>
