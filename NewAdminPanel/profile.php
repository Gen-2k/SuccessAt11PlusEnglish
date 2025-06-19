<?php
require_once 'config/config.php';
require_once 'includes/auth.php';

// Check authentication
checkAdminAuth();
$current_admin = getCurrentAdmin();
$current_page = 'profile';

// Get current admin data from database
$conn = getDBConnection();
$admin_id = $current_admin['id'];
$stmt = mysqli_prepare($conn, "SELECT id, fname, surname, email, created_at FROM students WHERE id = ? AND role = 'admin'");
mysqli_stmt_bind_param($stmt, "i", $admin_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$admin_data = mysqli_fetch_assoc($result);

if (!$admin_data) {
    die("Admin not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    $errors = [];
    
    // Validate inputs
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    if (empty($email)) {
        $errors[] = "Email is required";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    // Check if email already exists (for other users)
    $stmt = mysqli_prepare($conn, "SELECT id FROM students WHERE email = ? AND id != ?");
    mysqli_stmt_bind_param($stmt, "si", $email, $admin_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
        $errors[] = "Email already exists for another user";
    }
    
    // If changing password
    if (!empty($new_password)) {
        if (empty($current_password)) {
            $errors[] = "Current password is required to change password";
        } else {
            // Verify current password
            $stmt = mysqli_prepare($conn, "SELECT password FROM students WHERE id = ? AND role = 'admin'");
            mysqli_stmt_bind_param($stmt, "i", $admin_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $password_data = mysqli_fetch_assoc($result);
            
            if (!$password_data || $password_data['password'] !== $current_password) {
                $errors[] = "Current password is incorrect";
            }
        }
        
        if ($new_password !== $confirm_password) {
            $errors[] = "New passwords do not match";
        }
        if (strlen($new_password) < 6) {
            $errors[] = "New password must be at least 6 characters";
        }
    }
    
    if (empty($errors)) {
        // Update profile
        if (!empty($new_password)) {
            // Update with new password
            $stmt = mysqli_prepare($conn, "UPDATE students SET fname = ?, email = ?, password = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ? AND role = 'admin'");
            mysqli_stmt_bind_param($stmt, "sssi", $name, $email, $new_password, $admin_id);
        } else {
            // Update without changing password
            $stmt = mysqli_prepare($conn, "UPDATE students SET fname = ?, email = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ? AND role = 'admin'");
            mysqli_stmt_bind_param($stmt, "ssi", $name, $email, $admin_id);
        }
        
        if (mysqli_stmt_execute($stmt)) {
            // Update session data
            $_SESSION['fname'] = $name;
            $_SESSION['email'] = $email;
            
            // Refresh admin data
            $stmt = mysqli_prepare($conn, "SELECT id, fname, surname, email, created_at FROM students WHERE id = ? AND role = 'admin'");
            mysqli_stmt_bind_param($stmt, "i", $admin_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $admin_data = mysqli_fetch_assoc($result);
            
            $success_message = "Profile updated successfully!";
        } else {
            $errors[] = "Failed to update profile. Please try again.";
        }
    }
}

include 'includes/header.php';
include 'includes/navigation.php';
?>

<div class="main-content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h1 class="page-title">Profile</h1>
                    <p class="page-subtitle">Manage your account settings</p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <?php if (isset($success_message)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $success_message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php foreach ($errors as $error): ?>
                        <div><?php echo htmlspecialchars($error); ?></div>
                    <?php endforeach; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0">Profile Information</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Full Name</label>
                                            <input type="text" class="form-control" id="name" name="name" 
                                                   value="<?php echo htmlspecialchars($admin_data['fname'] ?? ''); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="email" class="form-control" id="email" name="email" 
                                                   value="<?php echo htmlspecialchars($admin_data['email'] ?? ''); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" 
                                           value="<?php echo htmlspecialchars($admin_data['email'] ?? ''); ?>" readonly>
                                    <div class="form-text">Username cannot be changed</div>
                                </div>

                                <hr>
                                <h5>Change Password</h5>
                                <p class="text-muted">Leave blank if you don't want to change your password</p>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="current_password" class="form-label">Current Password</label>
                                            <input type="password" class="form-control" id="current_password" name="current_password">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="new_password" class="form-label">New Password</label>
                                            <input type="password" class="form-control" id="new_password" name="new_password">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <a href="index.php" class="btn btn-secondary me-2">Cancel</a>
                                    <button type="submit" name="update_profile" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Profile
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0">Account Info</h4>
                        </div>
                        <div class="card-body text-center">
                            <img src="assets/img/admin-avatar.svg" alt="Admin" class="rounded-circle mb-3" width="80" height="80">
                            <h5><?php echo htmlspecialchars($admin_data['fname'] ?? 'Admin'); ?></h5>
                            <p class="text-muted">Administrator</p>
                            <p class="text-muted">
                                <i class="fas fa-envelope"></i> 
                                <?php echo htmlspecialchars($admin_data['email'] ?? 'admin@example.com'); ?>
                            </p>
                            <p class="text-muted">
                                <i class="fas fa-calendar"></i> 
                                Member since <?php echo date('M Y', strtotime($admin_data['created_at'] ?? 'now')); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
