<?php
require_once 'config/config.php';
require_once 'includes/auth.php';

// Check authentication
checkAdminAuth();

// Reuse the existing connection from dbconfig.php
$conn = $connection;
$current_page = 'homeworks';

// Handle AJAX requests
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'add_homework':
            addHomework();
            break;
        case 'edit_homework':
            editHomework();
            break;
        case 'delete_homework':
            deleteHomework();
            break;
        case 'get_homework':
            getHomework();
            break;
        case 'get_file_size':
            getHomeworkFileSize();
            break;
    }
    exit();
}

// Get homework with filters
$classFilter = isset($_GET['class']) ? $_GET['class'] : '';
$moduleFilter = isset($_GET['module']) ? $_GET['module'] : '';

// Define available classes and modules (from course files)
$availableClasses = [
    'year4' => 'Year 4',
    'year5' => 'Year 5', 
    'year6' => 'Year 6',
];
$availableModules = [
    'year4' => [
        'Comprehension',
        'Creative Writing',
        'SPaG',
        'English Vocabulary',
        'Verbal Reasoning',
        'Carousel Course',
        '1:1 Tutoring',
    ],
    'year5' => [
        'Comprehension',
        'Creative Writing',
        'SPaG',
        'English Vocabulary',
        'Verbal Reasoning',
        'Carousel Course',
        '1:1 Tutoring',
    ],
    'year6' => [
        'Comprehension',
        'Creative Writing',
        'SPaG',
        'English Vocabulary',
        'Verbal Reasoning',
        'Carousel Course',
        '1:1 Tutoring',
    ],
];

$homeworkQuery = "SELECT * FROM resources WHERE resource_type = 'homework'";
$conditions = [];

if (!empty($classFilter)) {
    $conditions[] = "class = '" . mysqli_real_escape_string($conn, $classFilter) . "'";
}
if (!empty($moduleFilter)) {
    $conditions[] = "module = '" . mysqli_real_escape_string($conn, $moduleFilter) . "'";
}

if (!empty($conditions)) {
    $homeworkQuery .= " AND " . implode(" AND ", $conditions);
}

$homeworkQuery .= " ORDER BY created_at DESC";
$homeworkResult = mysqli_query($conn, $homeworkQuery);

// Get distinct classes and modules for filters
$classesQuery = "SELECT DISTINCT class FROM resources WHERE resource_type = 'homework' AND class IS NOT NULL";
$classesResult = mysqli_query($conn, $classesQuery);

$modulesQuery = "SELECT DISTINCT module FROM resources WHERE resource_type = 'homework' AND module IS NOT NULL";
$modulesResult = mysqli_query($conn, $modulesQuery);

// Functions for AJAX operations
function addHomework() {
    global $conn;
    
    // Validate required fields
    $required = ['title', 'class', 'module'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            echo json_encode(['status' => 'error', 'message' => ucfirst($field) . ' is required.']);
            return;
        }
    }
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = isset($_POST['description']) ? mysqli_real_escape_string($conn, $_POST['description']) : '';
    $class = mysqli_real_escape_string($conn, $_POST['class']);
    $module = mysqli_real_escape_string($conn, $_POST['module']);
    
    // Handle file upload
    $fileName = '';
    $filePath = '';
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $uploadDir = '../uploads/homework/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fileName = time() . '_' . basename($_FILES['file']['name']);
        $filePath = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
            $filePath = 'uploads/homework/' . $fileName;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'File upload failed. Please check file permissions or try a different file.']);
            return;
        }
    }
    $query = "INSERT INTO resources (resource_type, class, module, title, description, file_name, file_path) 
              VALUES ('homework', '$class', '$module', '$title', '$description', '$fileName', '$filePath')";
    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'success', 'message' => 'Homework added successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add homework: ' . mysqli_error($conn)]);
    }
}

function editHomework() {
    global $conn;
    
    $id = intval($_POST['id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $class = mysqli_real_escape_string($conn, $_POST['class']);
    $module = mysqli_real_escape_string($conn, $_POST['module']);
    
    $query = "UPDATE resources SET 
              title = '$title', 
              description = '$description', 
              class = '$class', 
              module = '$module',
              updated_at = NOW()
              WHERE id = $id AND resource_type = 'homework'";
    
    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'success', 'message' => 'Homework updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update homework: ' . mysqli_error($conn)]);
    }
}

function deleteHomework() {
    global $conn;
    
    $id = intval($_POST['id']);
    
    // Get file path before deleting
    $fileQuery = "SELECT file_path FROM resources WHERE id = $id AND resource_type = 'homework'";
    $fileResult = mysqli_query($conn, $fileQuery);
    $fileData = mysqli_fetch_assoc($fileResult);
    
    $query = "DELETE FROM resources WHERE id = $id AND resource_type = 'homework'";
    
    if (mysqli_query($conn, $query)) {
        // Delete file if exists
        if ($fileData && $fileData['file_path'] && file_exists('../uploads/' . $fileData['file_path'])) {
            unlink('../uploads/' . $fileData['file_path']);
        }
        echo json_encode(['status' => 'success', 'message' => 'Homework deleted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete homework: ' . mysqli_error($conn)]);
    }
}

function getHomework() {
    global $conn;
    
    $id = intval($_POST['id']);
    $query = "SELECT * FROM resources WHERE id = $id AND resource_type = 'homework'";
    $result = mysqli_query($conn, $query);
    
    if ($homework = mysqli_fetch_assoc($result)) {
        echo json_encode(['status' => 'success', 'data' => $homework]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Homework not found']);
    }
}

function getHomeworkFileSize() {
    global $conn;
    $id = intval($_POST['id']);
    $query = "SELECT file_path FROM resources WHERE id = $id AND resource_type = 'homework'";
    $result = mysqli_query($conn, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        $filePath = $row['file_path'];
        if ($filePath) {
            $fullPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $filePath);
            if (file_exists($fullPath)) {
                $size = filesize($fullPath);
                echo json_encode(['status' => 'success', 'size' => $size]);
                return;
            }
        }
    }
    echo json_encode(['status' => 'error', 'size' => null]);
}

// Include header and navigation
include 'includes/header.php';
include 'includes/navigation.php';
?>

<main class="main-content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="page-title">Homework Management</h1>
                    <p class="page-subtitle">Manage homework assignments and resources</p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Homework</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-12">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addHomeworkModal">
                        <i class="fas fa-plus"></i> Add Homework
                    </button>
                </div>
            </div>

            <!-- Filters -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Class</label>
                            <select name="class" class="form-select" onchange="this.form.submit()">
                                <option value="">All Classes</option>
                                <?php foreach ($availableClasses as $classKey => $className): ?>
                                    <option value="<?php echo $classKey; ?>" <?php echo $classFilter == $classKey ? 'selected' : ''; ?>>
                                        <?php echo $className; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Module</label>
                            <select name="module" class="form-select" onchange="this.form.submit()">
                                <option value="">All Modules</option>
                                <?php 
                                $modulesToShow = [];
                                if (!empty($classFilter) && isset($availableModules[$classFilter])) {
                                    $modulesToShow = $availableModules[$classFilter];
                                } else {
                                    // Show all modules from all classes (unique)
                                    $all = [];
                                    foreach ($availableModules as $mods) { $all = array_merge($all, $mods); }
                                    $modulesToShow = array_unique($all);
                                }
                                foreach ($modulesToShow as $module): ?>
                                    <option value="<?php echo $module; ?>" <?php echo $moduleFilter == $module ? 'selected' : ''; ?>>
                                        <?php echo $module; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="button" class="btn btn-secondary" onclick="window.location.href='homeworks.php'">
                                    <i class="fas fa-times"></i> Clear Filters
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Homework List -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table homework-table">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Class</th>
                                    <th>Module</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($homeworkResult) > 0): ?>
                                    <?php $serial_no = 1; while($homework = mysqli_fetch_assoc($homeworkResult)): ?>
                                    <tr>
                                        <td><?php echo $serial_no++; ?></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($homework['title']); ?></strong>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <?php echo htmlspecialchars(substr($homework['description'], 0, 100)) . (strlen($homework['description']) > 100 ? '...' : ''); ?>
                                            </small>
                                        </td>
                                        <td><span class="badge badge-homework"><?php echo htmlspecialchars($homework['class']); ?></span></td>
                                        <td><span class="badge bg-secondary"><?php echo htmlspecialchars($homework['module']); ?></span></td>
                        <td><?php echo date('M d, Y', strtotime($homework['created_at'])); ?></td>                        <td>
                            <div class="btn-group">
                                <button class="btn-sm btn-view btn-tooltip" onclick="viewHomework(<?php echo $homework['id']; ?>)" data-tooltip="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-sm btn-edit btn-tooltip" onclick="editHomework(<?php echo $homework['id']; ?>)" data-tooltip="Edit Homework">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-sm btn-delete btn-tooltip" onclick="deleteHomework(<?php echo $homework['id']; ?>)" data-tooltip="Delete Homework">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <div class="empty-state" style="padding: 48px 0; color: #6B7280;">
                                                <div class="empty-state-icon" style="font-size: 3.5rem; color: #1E40AF; margin-bottom: 12px;">
                                                    <i class="fas fa-inbox"></i>
                                                </div>
                                                <div class="empty-state-title" style="font-size: 1.5rem; font-weight: 600; margin-bottom: 6px; color: #1E40AF;">No Homework Found</div>
                                                <div class="empty-state-text" style="font-size: 1.08rem; margin-bottom: 10px;">There are currently no homework assignments added.<br>Click <b>"Add Homework"</b> to create your first homework assignment.</div>
                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addHomeworkModal">
                                                    <i class="fas fa-plus"></i> Add Homework
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Add Homework Modal -->
<div class="modal fade" id="addHomeworkModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 16px; border: 1px solid #dbeafe;">
            <div class="modal-header" style="background: linear-gradient(90deg, #1E40AF 0%, #60A5FA 100%); color: #fff; border-top-left-radius: 16px; border-top-right-radius: 16px; padding: 1.25rem 1.5rem;">
                <h5 class="modal-title" style="font-weight: 700; letter-spacing: 0.5px;"><i class="fas fa-plus me-2"></i>Add Homework</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="addHomeworkForm" enctype="multipart/form-data">
                <div class="modal-body" style="background: #f1f5f9; padding: 1.5rem 1.5rem 1.25rem 1.5rem;">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Title *</label>
                            <input type="text" class="form-control" name="title" required placeholder="Enter homework title">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3" placeholder="Homework instructions and details"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Class *</label>
                            <select class="form-select" name="class" id="addHomeworkClass" required onchange="updateModuleDropdown('add')">
                                <option value="">Select Class</option>
                                <option value="year4">Year 4</option>
                                <option value="year5">Year 5</option>
                                <option value="year6">Year 6</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Module *</label>
                            <select class="form-select" name="module" id="addHomeworkModule" required>
                                <option value="">Select Module</option>
                                <?php 
                                $allModules = array_unique(array_merge(...array_values($availableModules)));
                                foreach ($allModules as $module): ?>
                                    <option value="<?php echo $module; ?>"><?php echo $module; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">File Upload</label>
                            <input type="file" class="form-control" name="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip">
                        </div>
                        <div class="col-md-12">
                            <small class="form-text text-muted">Supported formats: PDF, DOC, DOCX, JPG, PNG, ZIP</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background: #e0e7ef; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px; padding: 1rem 1.5rem;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background: #1E40AF; border: none;">Add Homework</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Homework Modal -->
<div class="modal fade" id="editHomeworkModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 16px; border: 1px solid #dbeafe;">
            <div class="modal-header" style="background: linear-gradient(90deg, #1E40AF 0%, #60A5FA 100%); color: #fff; border-top-left-radius: 16px; border-top-right-radius: 16px; padding: 1.25rem 1.5rem;">
                <h5 class="modal-title" style="font-weight: 700; letter-spacing: 0.5px;"><i class="fas fa-edit me-2"></i>Edit Homework</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editHomeworkForm">
                <div class="modal-body" style="background: #f1f5f9; padding: 1.5rem 1.5rem 1.25rem 1.5rem;">
                    <input type="hidden" name="id" id="editHomeworkId">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Title *</label>
                            <input type="text" class="form-control" name="title" id="editHomeworkTitle" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="editHomeworkDescription" rows="3"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Class *</label>
                            <select class="form-select" name="class" id="editHomeworkClass" required onchange="updateModuleDropdown('edit')">
                                <option value="">Select Class</option>
                                <option value="year4">Year 4</option>
                                <option value="year5">Year 5</option>
                                <option value="year6">Year 6</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Module *</label>
                            <select class="form-select" name="module" id="editHomeworkModule" required>
                                <option value="">Select Module</option>
                                <?php 
                                $allModules = array_unique(array_merge(...array_values($availableModules)));
                                foreach ($allModules as $module): ?>
                                    <option value="<?php echo $module; ?>"><?php echo $module; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background: #e0e7ef; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px; padding: 1rem 1.5rem;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background: #1E40AF; border: none;">Update Homework</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Homework Modal -->
<div class="modal fade" id="viewHomeworkModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 16px; border: 1px solid #dbeafe;">
            <div class="modal-header" style="background: linear-gradient(90deg, #1E40AF 0%, #60A5FA 100%); color: #fff; border-top-left-radius: 16px; border-top-right-radius: 16px; padding: 1.25rem 1.5rem;">
                <h5 class="modal-title" style="font-weight: 700; letter-spacing: 0.5px;"><i class="fas fa-book me-2"></i>Homework Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="background: #f1f5f9; padding: 1.5rem 1.5rem 1.25rem 1.5rem;">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Title</label>
                        <p class="form-control-plaintext" id="viewHomeworkTitle"></p>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Description</label>
                        <p class="form-control-plaintext" id="viewHomeworkDescription"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Class</label>
                        <p class="form-control-plaintext" id="viewHomeworkClass"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Module</label>
                        <p class="form-control-plaintext" id="viewHomeworkModule"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Created Date</label>
                        <p class="form-control-plaintext" id="viewHomeworkCreated"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Last Updated</label>
                        <p class="form-control-plaintext" id="viewHomeworkUpdated"></p>
                    </div>
                    <div class="col-md-12" id="viewHomeworkFileSection" style="display: none;">
                        <label class="form-label fw-bold">File Information</label>
                        <div class="card" style="border-radius: 12px; border: 1px solid #dbeafe;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>File Name:</strong> <span id="viewHomeworkFileName"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>File Size:</strong> <span id="viewHomeworkFileSize"></span>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary me-2" style="background: #1E40AF; border: none;" onclick="viewHomeworkFile()" id="viewHomeworkFileBtn">
                                        <i class="fas fa-eye"></i> View File
                                    </button>
                                    <button class="btn btn-success" onclick="downloadHomeworkFile()" id="downloadHomeworkFileBtn">
                                        <i class="fas fa-download"></i> Download File
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" id="viewHomeworkNoFile" style="display: none;">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> No file attached to this homework.
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background: #e0e7ef; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px; padding: 1rem 1.5rem;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Add homework form submission
document.getElementById('addHomeworkForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    const submitBtn = form.querySelector('button[type="submit"]');
    // Client-side validation
    const title = form.querySelector('[name="title"]').value.trim();
    const classVal = form.querySelector('[name="class"]').value.trim();
    const moduleVal = form.querySelector('[name="module"]').value.trim();
    if (!title || !classVal || !moduleVal) {
        swal('Missing Fields', 'Please fill in all required fields (Title, Class, Module).', 'warning');
        return;
    }
    const formData = new FormData(form);
    formData.append('action', 'add_homework');
    // Disable button and show spinner
    submitBtn.disabled = true;
    const origHtml = submitBtn.innerHTML;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...';
    fetch('homeworks.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = origHtml;
        if (data.status === 'success') {
            swal({
                title: 'Success!',
                text: data.message,
                icon: 'success',
                timer: 1800,
                buttons: false
            }).then(() => {
                location.reload();
            });
        } else {
            swal('Error', data.message, 'error');
        }
    })
    .catch(error => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = origHtml;
        console.error('Error:', error);
        swal('Error', 'An error occurred while adding homework', 'error');
    });
});

// Edit homework form submission
document.getElementById('editHomeworkForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    formData.append('action', 'edit_homework');
    
    fetch('homeworks.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then((data) => {
        if (data.status === 'success') {
            swal({
                title: 'Success!',
                text: data.message,
                icon: 'success',
                timer: 1800,
                buttons: false
            }).then(() => {
                location.reload();
            });
        } else {
            swal('Error', data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        swal('Error', 'An error occurred while updating homework', 'error');
    });
});

// Edit homework function
function editHomework(id) {
    const formData = new FormData();
    formData.append('action', 'get_homework');
    formData.append('id', id);
    
    fetch('homeworks.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())        .then(data => {
            if (data.status === 'success') {
                const homework = data.data;
                document.getElementById('editHomeworkId').value = homework.id;
                document.getElementById('editHomeworkTitle').value = homework.title;
                document.getElementById('editHomeworkDescription').value = homework.description;
                document.getElementById('editHomeworkClass').value = homework.class;
                
                // Update module dropdown and set selected value
                updateModuleDropdown('edit');
                setTimeout(() => {
                    document.getElementById('editHomeworkModule').value = homework.module;
                }, 100);
                
                new bootstrap.Modal(document.getElementById('editHomeworkModal')).show();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while loading homework data');
    });
}

// Delete homework function
function deleteHomework(id) {
    swal({
        title: 'Are you sure?',
        text: 'Are you sure you want to delete this homework? This action cannot be undone.',
        icon: 'warning',
        buttons: [true, 'Delete'],
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            const formData = new FormData();
            formData.append('action', 'delete_homework');
            formData.append('id', id);
            fetch('homeworks.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    swal({
                        title: 'Deleted!',
                        text: data.message,
                        icon: 'success',
                        timer: 1800,
                        buttons: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    swal('Error', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                swal('Error', 'An error occurred while deleting homework', 'error');
            });
        }
    });
}

// View homework function
function viewHomework(id) {
    const formData = new FormData();
    formData.append('action', 'get_homework');
    formData.append('id', id);
    
    fetch('homeworks.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            const homework = data.data;
            
            // Populate the modal with homework data
            document.getElementById('viewHomeworkTitle').textContent = homework.title;
            document.getElementById('viewHomeworkDescription').textContent = homework.description || 'No description provided';
            document.getElementById('viewHomeworkClass').textContent = homework.class;
            document.getElementById('viewHomeworkModule').textContent = homework.module;            document.getElementById('viewHomeworkCreated').textContent = new Date(homework.created_at).toLocaleDateString();
            
            // Handle updated_at - show creation date if never updated
            if (homework.updated_at && homework.updated_at !== homework.created_at) {
                document.getElementById('viewHomeworkUpdated').textContent = new Date(homework.updated_at).toLocaleDateString();
            } else {
                document.getElementById('viewHomeworkUpdated').textContent = 'Not updated yet';
            }
            
            // Handle file information
            if (homework.file_path && homework.file_name) {
                document.getElementById('viewHomeworkFileSection').style.display = 'block';
                document.getElementById('viewHomeworkNoFile').style.display = 'none';
                document.getElementById('viewHomeworkFileName').textContent = homework.file_name;
                // Get and display file size via AJAX
                getHomeworkFileSizeAjax(homework.id).then(size => {
                    document.getElementById('viewHomeworkFileSize').textContent = size;
                });
                // Store file path for download/view functions
                document.getElementById('viewHomeworkFileBtn').setAttribute('data-file-path', homework.file_path);
                document.getElementById('downloadHomeworkFileBtn').setAttribute('data-file-path', homework.file_path);
            } else {
                document.getElementById('viewHomeworkFileSection').style.display = 'none';
                document.getElementById('viewHomeworkNoFile').style.display = 'block';
            }
            
            // Show the modal
            new bootstrap.Modal(document.getElementById('viewHomeworkModal')).show();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while loading homework details');
    });
}

// Function to view homework file
function viewHomeworkFile() {
    const filePath = document.getElementById('viewHomeworkFileBtn').getAttribute('data-file-path');
    if (filePath) {
        window.open('../download.php?file=' + encodeURIComponent(filePath) + '&type=homework&action=view', '_blank');
    }
}

// Function to download homework file
function downloadHomeworkFile() {
    const filePath = document.getElementById('downloadHomeworkFileBtn').getAttribute('data-file-path');
    if (filePath) {
        window.location.href = '../download.php?file=' + encodeURIComponent(filePath) + '&type=homework&action=download';
    }
}

// Function to get homework file size via AJAX
function getHomeworkFileSizeAjax(homeworkId) {
    return fetch('homeworks.php', {
        method: 'POST',
        body: (() => { const fd = new FormData(); fd.append('action', 'get_file_size'); fd.append('id', homeworkId); return fd; })()
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success' && data.size !== null) {
            const sizeInBytes = parseInt(data.size);
            if (sizeInBytes < 1024) {
                return sizeInBytes + ' B';
            } else if (sizeInBytes < 1024 * 1024) {
                return (sizeInBytes / 1024).toFixed(1) + ' KB';
            } else {
                return (sizeInBytes / (1024 * 1024)).toFixed(1) + ' MB';
            }
        }
        return 'Unknown';
    })
    .catch(() => 'Unknown');
}

// Update module dropdown based on selected class in Add/Edit modals
const availableModules = {
    'year4': [
        'Comprehension',
        'Creative Writing',
        'SPaG',
        'English Vocabulary',
        'Verbal Reasoning',
        'Carousel Course',
        '1:1 Tutoring',
    ],
    'year5': [
        'Comprehension',
        'Creative Writing',
        'SPaG',
        'English Vocabulary',
        'Verbal Reasoning',
        'Carousel Course',
        '1:1 Tutoring',
    ],
    'year6': [
        'Comprehension',
        'Creative Writing',
        'SPaG',
        'English Vocabulary',
        'Verbal Reasoning',
        'Carousel Course',
        '1:1 Tutoring',
    ]
};

function updateModuleDropdown(formType) {
    let classSelect, moduleSelect;
    if (formType === 'add') {
        classSelect = document.getElementById('addHomeworkClass');
        moduleSelect = document.getElementById('addHomeworkModule');
    } else {
        classSelect = document.getElementById('editHomeworkClass');
        moduleSelect = document.getElementById('editHomeworkModule');
    }
    
    const selectedClass = classSelect.value;
    let modules = [];
    
    if (selectedClass && availableModules[selectedClass]) {
        modules = availableModules[selectedClass];
    } else {
        // Show all modules if no class selected
        modules = [...new Set(Object.values(availableModules).flat())];
    }
    
    // Clear existing options
    moduleSelect.innerHTML = '<option value="">Select Module</option>';
    
    // Add new options
    modules.forEach(function(module) {
        const option = document.createElement('option');
        option.value = module;
        option.textContent = module;
        moduleSelect.appendChild(option);
    });
}

// Set module dropdown on modal show (for edit)
document.getElementById('editHomeworkModal').addEventListener('show.bs.modal', function () {
    updateModuleDropdown('edit');
});

// Initialize module dropdown on page load
document.addEventListener('DOMContentLoaded', function() {
    updateModuleDropdown('add');
});
</script>

<?php include 'includes/footer.php'; ?>
