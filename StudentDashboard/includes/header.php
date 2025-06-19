<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/auth.php';

// Check authentication
checkStudentAuth();
$current_student = getCurrentStudent();
?>
<!DOCTYPE html>
<html lang="en">
<head>    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Student Dashboard for Success At 11 Plus English - Access homework, activities, and learning resources.">
    <meta name="author" content="Success At 11 Plus English">
    <title>Student Dashboard - Success At 11 Plus English</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/images/logonew.png">
      <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/student-style.css">
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Custom Dashboard JS -->
    <script src="assets/js/dashboard.js"></script>
</head>
<body>
    <div class="student-wrapper">
        <!-- Top Header -->
        <header class="student-header">
            <div class="header-content">
                <div class="header-left">
                    <button class="menu-toggle" id="menuToggle">
                        <i class="fas fa-bars"></i>
                    </button>                    <div class="logo" style="display: flex; align-items: center; gap: 6px;">
    <img src="../assets/logo/success-logo.png" alt="Success At 11 Plus English" style="height: 85px; width: auto; display: block;">
    <div class="brand-text" style="display: flex; flex-direction: column; justify-content: center; line-height: 1.1;">
        <span style="font-family: 'Poppins', 'Inter', sans-serif; font-size: 2rem; font-weight: 700; color: #1E40AF; letter-spacing: -0.02em; margin-bottom: 0;">Success At 11 Plus English</span>
        <span style="font-family: 'Inter', sans-serif; font-size: 1rem; font-weight: 500; color: #F59E0B; margin-top: 2px; letter-spacing: 0.01em;">Student Dashboard</span>
    </div>
</div>
                </div>
                
                <div class="header-right">
                    <div class="user-menu">
                        <div class="user-info">
                            <span class="user-name"><?php echo htmlspecialchars($current_student['name'] ?? 'Student'); ?></span>
                            <img src="assets/img/student-avatar.svg" alt="Student" class="user-avatar">
                        </div>
                        <div class="dropdown">
                            <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-chevron-down"></i>
                            </button>                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user"></i> Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="../logoutPage.php" method="POST" class="m-0">
                                        <button type="submit" name="logout_btn" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>                </div>
            </div>
        </header>

        <!-- Mobile Sidebar Overlay -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
