<?php
require_once 'config/config.php';
require_once 'includes/auth.php';

// Check authentication
checkAdminAuth();

// Reuse the existing connection from dbconfig.php
$conn = $connection;
$current_page = 'answers';

// Handle AJAX requests
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'add_answer':
            addAnswer();
            break;
        case 'edit_answer':
            editAnswer();
            break;
        case 'delete_answer':
            deleteAnswer();
            break;
        case 'get_answer':
            getAnswer();
            break;
        case 'get_file_size':
            getAnswerFileSize();
            break;
    }
    exit();
}

// Get answers with filters
$classFilter = isset($_GET['class']) ? $_GET['class'] : '';
$moduleFilter = isset($_GET['module']) ? $_GET['module'] : '';

$answerQuery = "SELECT * FROM resources WHERE resource_type = 'answers'";
$conditions = [];

if (!empty($classFilter)) {
    $conditions[] = "class = '" . mysqli_real_escape_string($conn, $classFilter) . "'";
}
if (!empty($moduleFilter)) {
    $conditions[] = "module = '" . mysqli_real_escape_string($conn, $moduleFilter) . "'";
}

if (!empty($conditions)) {
    $answerQuery .= " AND " . implode(" AND ", $conditions);
}

$answerQuery .= " ORDER BY created_at DESC";
$answerResult = mysqli_query($conn, $answerQuery);

// Get distinct classes and modules for filters
$classesQuery = "SELECT DISTINCT class FROM resources WHERE resource_type = 'answers' AND class IS NOT NULL";
$classesResult = mysqli_query($conn, $classesQuery);

$modulesQuery = "SELECT DISTINCT module FROM resources WHERE resource_type = 'answers' AND module IS NOT NULL";
$modulesResult = mysqli_query($conn, $modulesQuery);

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
        '1:1 Tutoring',    ],
];

// Create variables for use in filters and forms
$classes = $availableClasses;
$allModules = [];
foreach ($availableModules as $yearModules) {
    $allModules = array_merge($allModules, $yearModules);
}
$allModules = array_unique($allModules);

// Functions for AJAX operations
function addAnswer() {
    global $conn;
    
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $class = mysqli_real_escape_string($conn, $_POST['class']);
    $module = mysqli_real_escape_string($conn, $_POST['module']);
    
    // Handle file upload
    $fileName = '';
    $filePath = '';
    
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $uploadDir = '../uploads/answers/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $fileName = time() . '_' . $_FILES['file']['name'];
        $filePath = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
            $filePath = 'uploads/answers/' . $fileName;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'File upload failed']);
            return;
        }
    }
    
    $query = "INSERT INTO resources (resource_type, class, module, title, description, file_name, file_path) 
              VALUES ('answers', '$class', '$module', '$title', '$description', '$fileName', '$filePath')";
    
    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'success', 'message' => 'Answer sheet added successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add answer sheet']);
    }
}

function editAnswer() {
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
              WHERE id = $id AND resource_type = 'answers'";
    
    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'success', 'message' => 'Answer sheet updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update answer sheet']);
    }
}

function deleteAnswer() {
    global $conn;
    
    $id = intval($_POST['id']);
    
    // Get file path before deleting
    $fileQuery = "SELECT file_path FROM resources WHERE id = $id AND resource_type = 'answers'";
    $fileResult = mysqli_query($conn, $fileQuery);
    $fileData = mysqli_fetch_assoc($fileResult);
    
    $query = "DELETE FROM resources WHERE id = $id AND resource_type = 'answers'";
    
    if (mysqli_query($conn, $query)) {
        // Delete file if exists
        if ($fileData && $fileData['file_path']) {
            $fullPath = '../' . $fileData['file_path'];
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }
        echo json_encode(['status' => 'success', 'message' => 'Answer sheet deleted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete answer sheet']);
    }
}

function getAnswer() {
    global $conn;
    
    $id = intval($_POST['id']);
    $query = "SELECT * FROM resources WHERE id = $id AND resource_type = 'answers'";
    $result = mysqli_query($conn, $query);
    
    if ($answer = mysqli_fetch_assoc($result)) {
        echo json_encode(['status' => 'success', 'data' => $answer]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Answer sheet not found']);
    }
}

function getAnswerFileSize() {
    global $conn;
    $id = intval($_POST['id']);
    $query = "SELECT file_path FROM resources WHERE id = $id AND resource_type = 'answers'";
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
                            <h1 class="page-title">Answer Sheets Management</h1>
                            <p class="page-subtitle">Manage answer keys and solution sheets</p>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active">Answer Sheets</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container-fluid">
                    <div class="row mb-3">
                        <div class="col-12">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAnswerModal">
                                <i class="fas fa-plus"></i> Add Answer Sheet
                            </button>
                        </div>
                    </div>                <!-- Filters -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Class</label>
                                <select name="class" class="form-select" onchange="this.form.submit()">
                                    <option value="">All Classes</option>
                                    <?php foreach($classes as $key => $display): ?>
                                        <option value="<?php echo $key; ?>" <?php echo $classFilter == $key ? 'selected' : ''; ?>>
                                            <?php echo $display; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Module</label>
                                <select name="module" class="form-select" onchange="this.form.submit()">
                                    <option value="">All Modules</option>
                                    <?php foreach($allModules as $module): ?>
                                        <option value="<?php echo $module; ?>" <?php echo $moduleFilter == $module ? 'selected' : ''; ?>>
                                            <?php echo $module; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div><div class="col-md-4">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid">
                                    <button type="button" class="btn btn-secondary" onclick="window.location.href='answers.php'">
                                        <i class="fas fa-times"></i> Clear Filters
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Answer Sheets List -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table answer-table">
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
                                    <?php if (mysqli_num_rows($answerResult) > 0): ?>
                                        <?php $serial_no = 1; while($answer = mysqli_fetch_assoc($answerResult)): ?>
                                        <tr>
                                            <td><?php echo $serial_no++; ?></td>
                                            <td><strong><?php echo htmlspecialchars($answer['title']); ?></strong></td>
                                            <td><small class="text-muted"><?php echo htmlspecialchars(substr($answer['description'], 0, 100)) . (strlen($answer['description']) > 100 ? '...' : ''); ?></small></td>
                                            <td><span class="badge badge-answer"><?php echo htmlspecialchars($answer['class']); ?></span></td>
                                            <td><span class="badge bg-secondary"><?php echo htmlspecialchars($answer['module']); ?></span></td>
                                            <td><?php echo date('M d, Y', strtotime($answer['created_at'])); ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn-sm btn-view btn-tooltip" onclick="viewAnswer(<?php echo $answer['id']; ?>)" data-tooltip="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn-sm btn-edit btn-tooltip" onclick="editAnswer(<?php echo $answer['id']; ?>)" data-tooltip="Edit Answer Sheet">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn-sm btn-delete btn-tooltip" onclick="deleteAnswer(<?php echo $answer['id']; ?>)" data-tooltip="Delete Answer Sheet">
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
                                                    <div class="empty-state-icon" style="font-size: 3.5rem; color: #10B981; margin-bottom: 12px;">
                                                        <i class="fas fa-file-alt"></i>
                                                    </div>
                                                    <div class="empty-state-title" style="font-size: 1.5rem; font-weight: 600; margin-bottom: 6px; color: #10B981;">No Answer Sheets Found</div>
                                                    <div class="empty-state-text" style="font-size: 1.08rem; margin-bottom: 10px;">There are currently no answer sheets added.<br>Click <b>"Add Answer Sheet"</b> to upload your first answer sheet.</div>
                                                    <button  style=" background-color: #10B981; border:none; border-radius: 8px; color: #fff; padding: 12px 24px; font-size: 1rem ;" data-bs-toggle="modal" data-bs-target="#addAnswerModal">
                                                        <i class="fas fa-plus"></i> Add Answer Sheet
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>                </div>
            </div>        </main>

    <!-- Add Answer Modal -->
    <div class="modal fade" id="addAnswerModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 16px; border: 1px solid #d1fae5; background: #fff;">
                <div class="modal-header" style="background: linear-gradient(90deg, #10B981 0%, #6EE7B7 100%); color: #fff; border-top-left-radius: 16px; border-top-right-radius: 16px; padding: 1.25rem 1.5rem;">
                    <h5 class="modal-title" style="font-weight: 700; letter-spacing: 0.5px;"><i class="fas fa-plus me-2"></i>Add Answer Sheet</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="addAnswerForm" enctype="multipart/form-data">
                    <div class="modal-body" style="background: #fff; padding: 1.5rem 1.5rem 1.25rem 1.5rem;">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Title *</label>
                                <input type="text" class="form-control" name="title" required placeholder="Enter answer sheet title">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3" placeholder="Description of the answer sheet and what it covers"></textarea>
                            </div>                            <div class="col-md-6">
                                <label class="form-label">Class *</label>
                                <select class="form-select" name="class" id="addAnswerClass" required onchange="updateModuleDropdown('add')">
                                    <option value="">Select Class</option>
                                    <option value="year4">Year 4</option>
                                    <option value="year5">Year 5</option>
                                    <option value="year6">Year 6</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Module *</label>
                                <select class="form-select" name="module" id="addAnswerModule" required>
                                    <option value="">Select Module</option>
                                    <?php 
                                    $allModules = array_unique(array_merge(...array_values($availableModules)));
                                    foreach ($allModules as $module): ?>
                                        <option value="<?php echo $module; ?>"><?php echo $module; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">File Upload *</label>
                                <input type="file" class="form-control" name="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                                <small class="form-text text-muted">Supported formats: PDF, DOC, DOCX, JPG, PNG</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="background: #d1fae5; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px; padding: 1rem 1.5rem;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" style="background: #10B981; border: none; color: #fff;">Add Answer Sheet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Answer Modal -->
    <div class="modal fade" id="editAnswerModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 16px; border: 1px solid #d1fae5; background: #fff;">
                <div class="modal-header" style="background: linear-gradient(90deg, #10B981 0%, #6EE7B7 100%); color: #fff; border-top-left-radius: 16px; border-top-right-radius: 16px; padding: 1.25rem 1.5rem;">
                    <h5 class="modal-title" style="font-weight: 700; letter-spacing: 0.5px;"><i class="fas fa-edit me-2"></i>Edit Answer Sheet</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="editAnswerForm">
                    <div class="modal-body" style="background: #fff; padding: 1.5rem 1.5rem 1.25rem 1.5rem;">
                        <input type="hidden" name="id" id="editAnswerId">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Title *</label>
                                <input type="text" class="form-control" name="title" id="editAnswerTitle" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="editAnswerDescription" rows="3"></textarea>
                            </div>                            <div class="col-md-6">
                                <label class="form-label">Class *</label>
                                <select class="form-select" name="class" id="editAnswerClass" required onchange="updateModuleDropdown('edit')">
                                    <option value="">Select Class</option>
                                    <option value="year4">Year 4</option>
                                    <option value="year5">Year 5</option>
                                    <option value="year6">Year 6</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Module *</label>
                                <select class="form-select" name="module" id="editAnswerModule" required>
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
                    <div class="modal-footer" style="background: #d1fae5; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px; padding: 1rem 1.5rem;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" style="background: #10B981; border: none; color: #fff;">Update Answer Sheet</button>                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Answer Modal -->
    <div class="modal fade" id="viewAnswerModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 16px; border: 1px solid #d1fae5; background: #fff;">
                <div class="modal-header" style="background: linear-gradient(90deg, #10B981 0%, #6EE7B7 100%); color: #fff; border-top-left-radius: 16px; border-top-right-radius: 16px; padding: 1.25rem 1.5rem;">
                    <h5 class="modal-title" style="font-weight: 700; letter-spacing: 0.5px;"><i class="fas fa-file-alt me-2"></i>Answer Sheet Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="background: #fff; padding: 1.5rem 1.5rem 1.25rem 1.5rem;">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Title</label>
                            <p class="form-control-plaintext" id="viewAnswerTitle"></p>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Description</label>
                            <p class="form-control-plaintext" id="viewAnswerDescription"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Class</label>
                            <p class="form-control-plaintext" id="viewAnswerClass"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Module</label>
                            <p class="form-control-plaintext" id="viewAnswerModule"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Created Date</label>
                            <p class="form-control-plaintext" id="viewAnswerCreated"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Last Updated</label>
                            <p class="form-control-plaintext" id="viewAnswerUpdated"></p>
                        </div>
                        <div class="col-md-12" id="viewAnswerFileSection" style="display: none;">
                            <label class="form-label fw-bold">File Information</label>
                            <div class="card" style="border-radius: 12px; border: 1px solid #6EE7B7; background: #f0fdfa;">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>File Name:</strong> <span id="viewAnswerFileName"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>File Size:</strong> <span id="viewAnswerFileSize"></span>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <button class="btn btn-success me-2" onclick="viewAnswerFile()" id="viewAnswerFileBtn" style="border-radius: 8px; background: #10B981; border: none; color: #fff;">
                                            <i class="fas fa-eye"></i> View File
                                        </button>
                                        <button class="btn btn-info" onclick="downloadAnswerFile()" id="downloadAnswerFileBtn" style="border-radius: 8px; background: #6EE7B7; border: none; color: #065F46;">
                                            <i class="fas fa-download"></i> Download File
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" id="viewAnswerNoFile" style="display: none;">
                            <div class="alert alert-info" style="border-radius: 8px; background: #d1fae5; color: #065F46;">
                                <i class="fas fa-info-circle"></i> No file attached to this answer sheet.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background: #d1fae5; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px; padding: 1rem 1.5rem;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    // Add answer form submission
    document.getElementById('addAnswerForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        formData.append('action', 'add_answer');
        
        fetch('answers.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
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
            swal('Error', 'An error occurred while adding answer sheet', 'error');
        });
    });

    // Edit answer form submission
    document.getElementById('editAnswerForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        formData.append('action', 'edit_answer');
        
        fetch('answers.php', {
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
            swal('Error', 'An error occurred while updating answer sheet', 'error');
        });
    });

    // Edit answer function
    function editAnswer(id) {
        const formData = new FormData();
        formData.append('action', 'get_answer');
        formData.append('id', id);
        
        fetch('answers.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())        .then(data => {
            if (data.status === 'success') {
                const answer = data.data;
                document.getElementById('editAnswerId').value = answer.id;
                document.getElementById('editAnswerTitle').value = answer.title;
                document.getElementById('editAnswerDescription').value = answer.description;
                document.getElementById('editAnswerClass').value = answer.class;
                
                // Update module dropdown and set selected value
                updateModuleDropdown('edit');
                setTimeout(() => {
                    document.getElementById('editAnswerModule').value = answer.module;
                }, 100);
                
                new bootstrap.Modal(document.getElementById('editAnswerModal')).show();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while loading answer sheet data');
        });
    }

    // Delete answer function
    function deleteAnswer(id) {
        swal({
            title: 'Are you sure?',
            text: 'Are you sure you want to delete this answer sheet? This action cannot be undone.',
            icon: 'warning',
            buttons: [true, 'Delete'],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                const formData = new FormData();
                formData.append('action', 'delete_answer');
                formData.append('id', id);
                fetch('answers.php', {
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
                    swal('Error', 'An error occurred while deleting answer sheet', 'error');
                });
            }
        });
    }

    // View answer function
    function viewAnswer(id) {
        const formData = new FormData();
        formData.append('action', 'get_answer');
        formData.append('id', id);
        
        fetch('answers.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const answer = data.data;
                
                // Populate the modal with answer data
                document.getElementById('viewAnswerTitle').textContent = answer.title;
                document.getElementById('viewAnswerDescription').textContent = answer.description || 'No description provided';
                document.getElementById('viewAnswerClass').textContent = answer.class;
                document.getElementById('viewAnswerModule').textContent = answer.module;
                document.getElementById('viewAnswerCreated').textContent = new Date(answer.created_at).toLocaleDateString();
                
                // Handle updated_at - show creation date if never updated
                if (answer.updated_at && answer.updated_at !== answer.created_at) {
                    document.getElementById('viewAnswerUpdated').textContent = new Date(answer.updated_at).toLocaleDateString();
                } else {
                    document.getElementById('viewAnswerUpdated').textContent = 'Not updated yet';
                }
                
                // Handle file information
                if (answer.file_path && answer.file_name) {
                    document.getElementById('viewAnswerFileSection').style.display = 'block';
                    document.getElementById('viewAnswerNoFile').style.display = 'none';
                    document.getElementById('viewAnswerFileName').textContent = answer.file_name;
                    // Get and display file size via AJAX
                    getAnswerFileSizeAjax(answer.id).then(size => {
                        document.getElementById('viewAnswerFileSize').textContent = size;
                    });
                    // Store file path for download/view functions
                    document.getElementById('viewAnswerFileBtn').setAttribute('data-file-path', answer.file_path);
                    document.getElementById('downloadAnswerFileBtn').setAttribute('data-file-path', answer.file_path);
                } else {
                    document.getElementById('viewAnswerFileSection').style.display = 'none';
                    document.getElementById('viewAnswerNoFile').style.display = 'block';
                }
                
                // Show the modal
                new bootstrap.Modal(document.getElementById('viewAnswerModal')).show();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while loading answer details');
        });
    }

    // Function to get answer file size via AJAX
    function getAnswerFileSizeAjax(answerId) {
        return fetch('answers.php', {
            method: 'POST',
            body: (() => { const fd = new FormData(); fd.append('action', 'get_file_size'); fd.append('id', answerId); return fd; })()
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

    // Available modules for each class
    const availableModules = {
        'year4': ['Comprehension', 'Creative Writing', 'SPaG', 'English Vocabulary', 'Verbal Reasoning', 'Carousel Course', '1:1 Tutoring'],
        'year5': ['Comprehension', 'Creative Writing', 'SPaG', 'English Vocabulary', 'Verbal Reasoning', 'Carousel Course', '1:1 Tutoring'],
        'year6': ['Comprehension', 'Creative Writing', 'SPaG', 'English Vocabulary', 'Verbal Reasoning', 'Carousel Course', '1:1 Tutoring']
    };    // Function to update module dropdown based on selected class
    function updateModuleDropdown(type) {
        let classSelect, moduleSelect;
        
        if (type === 'add') {
            classSelect = document.getElementById('addAnswerClass');
            moduleSelect = document.getElementById('addAnswerModule');
        } else if (type === 'edit') {
            classSelect = document.getElementById('editAnswerClass');
            moduleSelect = document.getElementById('editAnswerModule');
        }
        
        if (!classSelect || !moduleSelect) return;
        
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
    document.getElementById('editAnswerModal').addEventListener('show.bs.modal', function () {
        updateModuleDropdown('edit');
    });

    // Initialize module dropdown on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateModuleDropdown('add');    });

    // Function to view answer file
    function viewAnswerFile() {
        const filePath = document.getElementById('viewAnswerFileBtn').getAttribute('data-file-path');
        if (filePath) {
            window.open('../download.php?file=' + encodeURIComponent(filePath) + '&type=answers&action=view', '_blank');
        }
    }

    // Function to download answer file
    function downloadAnswerFile() {
        const filePath = document.getElementById('downloadAnswerFileBtn').getAttribute('data-file-path');
        if (filePath) {
            window.location.href = '../download.php?file=' + encodeURIComponent(filePath) + '&type=answers&action=download';
        }
    }
    </script>

<?php include 'includes/footer.php'; ?>
