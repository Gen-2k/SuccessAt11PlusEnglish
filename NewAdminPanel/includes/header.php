<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/auth.php';

// Check authentication
checkAdminAuth();
$current_admin = getCurrentAdmin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Success At 11 Plus English</title>
      <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome - Multiple CDN for better reliability -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/admin-style.css">    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- SweetAlert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
    <div class="admin-wrapper">
        <!-- Top Header -->
        <header class="admin-header">
            <div class="header-content">
                <div class="header-left">
                    <button class="menu-toggle" id="menuToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="logo" style="display: flex; align-items: center; gap: 6px;">
    <img src="../assets/logo/success-logo.png" alt="Success At 11 Plus English" style="height: 85px; width: auto;  display: block;">
    <div class="brand-text" style="display: flex; flex-direction: column; justify-content: center; line-height: 1.1;">
        <span style="font-family: 'Poppins', 'Inter', sans-serif; font-size: 2rem; font-weight: 700; color: #1E40AF; letter-spacing: -0.02em; margin-bottom: 0;">Success At 11 Plus English</span>
        <span style="font-family: 'Inter', sans-serif; font-size: 1rem; font-weight: 500; color: #F59E0B; margin-top: 2px; letter-spacing: 0.01em;">Admin Panel</span>
    </div>
                    </div>
                </div>
                <div class="header-right">
                    <div class="user-menu">
                        <div class="user-info">
                            <span class="user-name"><?php echo htmlspecialchars($current_admin['username'] ?? 'Admin'); ?></span>
                            <img src="assets/img/admin-avatar.svg" alt="Admin" class="user-avatar">
                        </div>
                        <div class="dropdown">
                            <button class="dropdown-toggle" type="button" id="adminDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="adminDropdown">
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
                    </div>
                </div>
            </div>
        </header>
