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

// Get full student details from database
$conn = getDBConnection();
$query = "SELECT * FROM students WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $student_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$student_details = mysqli_fetch_assoc($result);
?>

<main class="main-content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="page-title">My Profile</h1>
                    <p class="page-subtitle">View and manage your account information</p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-md-4">
                    <!-- Profile Card -->
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center py-5">
                            <img src="assets/img/student-avatar.svg" alt="Student Avatar" class="rounded-circle mb-3 border border-3" width="120" height="120">
                            <h4 class="mb-1" style="font-weight:600; color:#2563eb;"><?php echo htmlspecialchars($student_details['fname'] . ' ' . $student_details['surname']); ?></h4>
                            <div class="text-muted mb-2" style="font-size:1.1rem;">Student</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <!-- Personal Information -->
                    <div class="card mb-4 shadow-sm border-0">
                        <div class="card-header bg-white border-bottom-0 pb-0">
                            <h3 class="card-title mb-0" style="font-weight:600; color:#2563eb;">Personal Information</h3>
                        </div>
                        <div class="card-body pt-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label"><strong>First Name</strong></label>
                                    <div class="form-control-plaintext ps-1"><?php echo htmlspecialchars($student_details['fname']); ?></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Last Name</strong></label>
                                    <div class="form-control-plaintext ps-1"><?php echo htmlspecialchars($student_details['surname']); ?></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Email</strong></label>
                                    <div class="form-control-plaintext ps-1"><?php echo htmlspecialchars($student_details['email']); ?></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Phone</strong></label>
                                    <div class="form-control-plaintext ps-1"><?php echo htmlspecialchars($student_details['phone'] ?: 'Not provided'); ?></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Date of Birth</strong></label>
                                    <div class="form-control-plaintext ps-1"><?php echo $student_details['dob'] ? date('M j, Y', strtotime($student_details['dob'])) : 'Not provided'; ?></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Gender</strong></label>
                                    <div class="form-control-plaintext ps-1"><?php echo htmlspecialchars($student_details['gender'] ?: 'Not provided'); ?></div>
                                </div>
                                <?php if ($student_details['address']): ?>
                                <div class="col-12">
                                    <label class="form-label"><strong>Address</strong></label>
                                    <div class="form-control-plaintext ps-1"><?php echo htmlspecialchars($student_details['address']); ?></div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <!-- Parent/Guardian Information -->
                    <?php if ($student_details['parent_firstname'] || $student_details['parent_surname']): ?>
                    <div class="card mb-4 shadow-sm border-0">
                        <div class="card-header bg-white border-bottom-0 pb-0">
                            <h3 class="card-title mb-0" style="font-weight:600; color:#2563eb;">Parent/Guardian Information</h3>
                        </div>
                        <div class="card-body pt-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Parent/Guardian First Name</strong></label>
                                    <div class="form-control-plaintext ps-1"><?php echo htmlspecialchars($student_details['parent_firstname'] ?: 'Not provided'); ?></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Parent/Guardian Last Name</strong></label>
                                    <div class="form-control-plaintext ps-1"><?php echo htmlspecialchars($student_details['parent_surname'] ?: 'Not provided'); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <!-- Account Information -->
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom-0 pb-0">
                            <h3 class="card-title mb-0" style="font-weight:600; color:#2563eb;">Account Information</h3>
                        </div>
                        <div class="card-body pt-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Account Created</strong></label>
                                    <div class="form-control-plaintext ps-1"><?php echo date(DATETIME_FORMAT, strtotime($student_details['created_at'])); ?></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Last Updated</strong></label>
                                    <div class="form-control-plaintext ps-1"><?php echo $student_details['updated_at'] ? date(DATETIME_FORMAT, strtotime($student_details['updated_at'])) : 'Never'; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
