<?php
require_once 'config/config.php';
require_once 'includes/auth.php';

// Check authentication
checkAdminAuth();

// Reuse the existing connection from dbconfig.php
$conn = $connection;

$current_page = 'students';

// Include the filter logic module
require_once 'includes/student_filter.php';

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    
    switch ($action) {case 'delete':
            $id = intval($_POST['id']);
            $query = "DELETE FROM students WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $id);
            
            if (mysqli_stmt_execute($stmt)) {
                echo json_encode(['success' => true, 'message' => 'Student deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error deleting student']);
            }
            exit();

        case 'view':
            $id = intval($_POST['id']);
            $query = "SELECT 
                s.id, 
                s.fname,
                s.surname,
                CONCAT(s.fname, ' ', s.surname) as student_name,
                s.email, 
                s.phone,
                s.dob,
                s.gender,
                s.parent_firstname,
                s.parent_surname,
                s.address,
                s.yesorno,
                s.created_at,
                s.password, -- Add password field here
                e.class,
                e.module,
                e.price,
                e.payment_status,
                e.access_start,
                e.access_end,
                e.transaction_id,
                CASE 
                    WHEN e.payment_status = 'paid' AND (e.access_end IS NULL OR e.access_end >= CURDATE()) THEN 'Active'
                    WHEN e.payment_status = 'pending' THEN 'Pending'
                    WHEN e.access_end < CURDATE() THEN 'Expired'
                    ELSE 'Inactive'
                END as status
            FROM students s
            LEFT JOIN enrollments e ON s.id = e.student_id AND e.id = (
                SELECT id FROM enrollments 
                WHERE student_id = s.id 
                ORDER BY created_at DESC 
                LIMIT 1
            )
            WHERE s.id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $student = mysqli_fetch_assoc($result);
            
            // Get all enrollments for this student
            $enrollments_query = "SELECT * FROM enrollments WHERE student_id = ? ORDER BY created_at DESC";
            $enrollments_stmt = mysqli_prepare($conn, $enrollments_query);
            mysqli_stmt_bind_param($enrollments_stmt, "i", $id);
            mysqli_stmt_execute($enrollments_stmt);
            $enrollments_result = mysqli_stmt_get_result($enrollments_stmt);
            $enrollments = [];
            while ($enrollment = mysqli_fetch_assoc($enrollments_result)) {
                $enrollments[] = $enrollment;
            }
            $student['enrollments'] = $enrollments;
            
            echo json_encode($student);
            exit();    }
}

// The filter logic and student query execution is now handled in student_filter.php

// Execute the student query (built in student_filter.php)
$stmt = mysqli_prepare($conn, $query);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$students = mysqli_stmt_get_result($stmt);

// Include header and navigation
include 'includes/header.php';
include 'includes/navigation.php';
?>

<main class="main-content">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h1 class="page-title">Students Management</h1>
                            <p class="page-subtitle">Manage student accounts and information</p>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active">Students</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>            <div class="content">
                <div class="container-fluid">
                    <!-- Enhanced Filters with Real-time Search -->
                    <div class="card mb-4">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Search Students</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" id="searchInput" class="form-control" placeholder="Search by name, email, or parent name" 
                                           value="<?php echo htmlspecialchars($search); ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Class</label>
                                <select id="classFilter" class="form-select">
                                    <option value="">All Classes</option>
                                    <!-- Class options will be loaded dynamically -->
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Module</label>
                                <select id="moduleFilter" class="form-select">
                                    <option value="">All Modules</option>
                                    <!-- Modules will be loaded dynamically -->
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="button" id="clearFilters" class="btn btn-lg btn-outline-danger w-100 fw-bold shadow-sm border-2" style="height:48px; font-size:1.1rem;">
                                    <i class="fas fa-broom"></i> Clear All Filters
                                </button>
                            </div>
                        </div>
                    </div>
                </div>                <!-- Students Table -->
                <div class="card">
                    <div class="card-body">                        <div class="table-responsive">
                            <table class="table table-hover table-students" id="studentsTable">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Student Name</th>
                                        <th>Email</th>
                                        <th>Class</th>
                                        <th>Module</th>
                                        <th>DOB</th>
                                        <th>Parent</th>
                                        <th>Status</th>
                                        <th>Registered</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="studentsTableBody"><?php 
                                    $serial_no = 1;
                                    if (mysqli_num_rows($students) > 0):
                                        while ($student = mysqli_fetch_assoc($students)): ?>
                                            <tr data-student-id="<?php echo $student['id']; ?>">
                                                <td><?php echo $serial_no++; ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="student-avatar me-2">
                                                            <i class="fas fa-user-circle fa-2x text-primary"></i>
                                                        </div>
                                                        <div>
                                                            <strong><?php echo htmlspecialchars($student['student_name'] ?? "No Name"); ?></strong>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?php echo htmlspecialchars($student['email'] ?? ""); ?></td>
                                                <td><span class="badge bg-info"><?php echo htmlspecialchars($student['class'] ?? "Not Assigned"); ?></span></td>
                                                <td><span class="badge bg-secondary"><?php echo htmlspecialchars($student['module'] ?? "No Module"); ?></span></td>
                                                <td><?php echo $student['dob'] ? date('M d, Y', strtotime($student['dob'])) : 'Not Set'; ?></td>
                                                <td>
                                                    <small>
                                                        <?php echo htmlspecialchars($student['parent_firstname'] ?? ""); ?>
                                                        <?php if(!empty($student['parent_surname'])): ?> 
                                                            <?php echo htmlspecialchars($student['parent_surname']); ?>
                                                        <?php endif; ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-<?php echo ($student['status'] ?? "") === 'Active' ? 'success' : (($student['status'] ?? "") === 'Pending' ? 'warning' : 'secondary'); ?>">
                                                        <?php echo ucfirst($student['status'] ?? "inactive"); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo date('M d, Y', strtotime($student['created_at'])); ?></td>                                            <td>
                                                    <div class="btn-group">
                                                        <button class="btn-sm btn-view btn-tooltip" onclick="viewStudent(<?php echo $student['id']; ?>)" data-tooltip="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button class="btn-sm btn-delete btn-tooltip" onclick="deleteStudent(<?php echo $student['id']; ?>)" data-tooltip="Delete Student">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="10" class="text-center">
                                                <div class="empty-state" style="padding: 48px 0; color: #6B7280;">
                                                    <div class="empty-state-icon" style="font-size: 3.5rem; color: #1F2937; margin-bottom: 12px;">
                                                        <i class="fas fa-user-graduate"></i>
                                                    </div>
                                                    <div class="empty-state-title" style="font-size: 1.5rem; font-weight: 600; margin-bottom: 6px; color: #1F2937;">No Students Found</div>
                                                    <div class="empty-state-text" style="font-size: 1.08rem;">There are currently no students in the system.</div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>                        </div>
                    </div>
                </div>
                </div>
            </div>
        </main>    <!-- Include Student View Templates -->
    <?php include 'includes/student_view_templates.php'; ?>

    <!-- Include Enhanced Student Management JavaScript -->
    <script src="assets/js/students.js"></script>
    <script>
        // Initialize StudentManager when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            window.studentManager = new StudentManager();
        });
    </script>

<?php include 'includes/footer.php'; ?>
