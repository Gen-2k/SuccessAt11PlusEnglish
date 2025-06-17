<?php
require_once 'config/config.php';
require_once 'includes/auth.php';

// Check authentication
checkAdminAuth();

// Reuse the existing connection from dbconfig.php
$conn = $connection;
$current_page = 'activities';

// Handle AJAX requests
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'add_activity':
            addActivity();
            break;
        case 'edit_activity':
            editActivity();
            break;
        case 'delete_activity':
            deleteActivity();
            break;
        case 'get_activity':
            getActivity();
            break;
    }
    exit();
}

// Get activities with filters
$classFilter = isset($_GET['class']) ? $_GET['class'] : '';
$moduleFilter = isset($_GET['module']) ? $_GET['module'] : '';

$activityQuery = "SELECT * FROM resources WHERE resource_type = 'activities'";
$conditions = [];

if (!empty($classFilter)) {
    $conditions[] = "class = '" . mysqli_real_escape_string($conn, $classFilter) . "'";
}
if (!empty($moduleFilter)) {
    $conditions[] = "module = '" . mysqli_real_escape_string($conn, $moduleFilter) . "'";
}

if (!empty($conditions)) {
    $activityQuery .= " AND " . implode(" AND ", $conditions);
}

$activityQuery .= " ORDER BY created_at DESC";
$activityResult = mysqli_query($conn, $activityQuery);

// Get distinct classes and modules for filters
$classesQuery = "SELECT DISTINCT class FROM resources WHERE resource_type = 'activities' AND class IS NOT NULL";
$classesResult = mysqli_query($conn, $classesQuery);

$modulesQuery = "SELECT DISTINCT module FROM resources WHERE resource_type = 'activities' AND module IS NOT NULL";
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
function addActivity() {
    global $conn;
    
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $class = mysqli_real_escape_string($conn, $_POST['class']);
    $module = mysqli_real_escape_string($conn, $_POST['module']);
    
    // Handle file upload
    $fileName = '';
    $filePath = '';
    
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $uploadDir = '../uploads/activities/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $fileName = time() . '_' . $_FILES['file']['name'];
        $filePath = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
            $filePath = 'uploads/activities/' . $fileName;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'File upload failed']);
            return;
        }
    }
      $query = "INSERT INTO resources (resource_type, class, module, title, description, file_name, file_path) 
              VALUES ('activities', '$class', '$module', '$title', '$description', '$fileName', '$filePath')";
    
    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'success', 'message' => 'Activity added successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add activity']);
    }
}

function editActivity() {
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
              updated_at = CURRENT_TIMESTAMP
              WHERE id = $id AND resource_type = 'activities'";
    
    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'success', 'message' => 'Activity updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update activity']);
    }
}

function deleteActivity() {
    global $conn;
    
    $id = intval($_POST['id']);
      // Get file path before deleting
    $fileQuery = "SELECT file_path FROM resources WHERE id = $id AND resource_type = 'activities'";
    $fileResult = mysqli_query($conn, $fileQuery);
    $fileData = mysqli_fetch_assoc($fileResult);
    
    $query = "DELETE FROM resources WHERE id = $id AND resource_type = 'activities'";
    
    if (mysqli_query($conn, $query)) {
        // Delete file if exists
        if ($fileData && $fileData['file_path'] && file_exists('../' . $fileData['file_path'])) {
            unlink('../' . $fileData['file_path']);
        }
        echo json_encode(['status' => 'success', 'message' => 'Activity deleted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete activity']);
    }
}

function getActivity() {
    global $conn;
      $id = intval($_POST['id']);
    $query = "SELECT * FROM resources WHERE id = $id AND resource_type = 'activities'";
    $result = mysqli_query($conn, $query);
    
    if ($activity = mysqli_fetch_assoc($result)) {
        echo json_encode(['status' => 'success', 'data' => $activity]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Activity not found']);
    }
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
                            <h1 class="page-title">Activities Management</h1>
                            <p class="page-subtitle">Manage learning activities and resources</p>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active">Activities</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container-fluid">
                    <div class="row mb-3">
                        <div class="col-12">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addActivityModal">
                                <i class="fas fa-plus"></i> Add Activity
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
                                    <button type="button" class="btn btn-secondary" onclick="window.location.href='activities.php'">
                                        <i class="fas fa-times"></i> Clear Filters
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>                <!-- Activities List -->
                <div class="card activity-card">
                
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table activity-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Class</th>
                                        <th>Module</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($activity = mysqli_fetch_assoc($activityResult)): ?>
                                    <tr>
                                        <td><strong><?php echo $activity['id']; ?></strong></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($activity['title']); ?></strong>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <?php echo htmlspecialchars(substr($activity['description'], 0, 100)) . (strlen($activity['description']) > 100 ? '...' : ''); ?>
                                            </small>
                                        </td>
                                        <td><span class="badge badge-activity"><?php echo htmlspecialchars($activity['class']); ?></span></td>
                                        <td><span class="badge badge-secondary"><?php echo htmlspecialchars($activity['module']); ?></span></td>
                                        <td><?php echo date('M d, Y', strtotime($activity['created_at'])); ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn-sm btn-view btn-tooltip" onclick="viewActivity(<?php echo $activity['id']; ?>)" data-tooltip="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn-sm btn-edit btn-tooltip" onclick="editActivity(<?php echo $activity['id']; ?>)" data-tooltip="Edit Activity">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn-sm btn-delete btn-tooltip" onclick="deleteActivity(<?php echo $activity['id']; ?>)" data-tooltip="Delete Activity">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>                </div>
            </div>        </main>

    <!-- Add Activity Modal -->
    <div class="modal fade" id="addActivityModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Activity</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="addActivityForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Title *</label>
                                <input type="text" class="form-control" name="title" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3" placeholder="Brief description of the activity"></textarea>
                            </div>                            <div class="col-md-6">
                                <label class="form-label">Class *</label>
                                <select class="form-select" name="class" id="addActivityClass" required onchange="updateModuleDropdown('add')">
                                    <option value="">Select Class</option>
                                    <option value="year4">Year 4</option>
                                    <option value="year5">Year 5</option>
                                    <option value="year6">Year 6</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Module *</label>
                                <select class="form-select" name="module" id="addActivityModule" required>
                                    <option value="">Select Module</option>
                                    <?php 
                                    $allModules = array_unique(array_merge(...array_values($availableModules)));
                                    foreach ($allModules as $module): ?>
                                        <option value="<?php echo $module; ?>"><?php echo $module; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">File Upload</label>
                                <input type="file" class="form-control" name="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.mp4,.mp3,.zip">
                                <small class="form-text text-muted">Supported formats: PDF, DOC, DOCX, JPG, PNG, MP4, MP3, ZIP</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Activity</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Activity Modal -->
    <div class="modal fade" id="editActivityModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Activity</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editActivityForm">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editActivityId">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Title *</label>
                                <input type="text" class="form-control" name="title" id="editActivityTitle" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="editActivityDescription" rows="3"></textarea>
                            </div>                            <div class="col-md-6">
                                <label class="form-label">Class *</label>
                                <select class="form-select" name="class" id="editActivityClass" required onchange="updateModuleDropdown('edit')">
                                    <option value="">Select Class</option>
                                    <option value="year4">Year 4</option>
                                    <option value="year5">Year 5</option>
                                    <option value="year6">Year 6</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Module *</label>
                                <select class="form-select" name="module" id="editActivityModule" required>
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Activity</button>
                    </div>
                </form>
            </div>
        </div>    </div>

    <!-- View Activity Modal -->
    <div class="modal fade" id="viewActivityModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Activity Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Title</label>
                            <p class="form-control-plaintext" id="viewActivityTitle"></p>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Description</label>
                            <p class="form-control-plaintext" id="viewActivityDescription"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Class</label>
                            <p class="form-control-plaintext" id="viewActivityClass"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Module</label>
                            <p class="form-control-plaintext" id="viewActivityModule"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Created Date</label>
                            <p class="form-control-plaintext" id="viewActivityCreated"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Last Updated</label>
                            <p class="form-control-plaintext" id="viewActivityUpdated"></p>
                        </div>
                        <div class="col-md-12" id="viewActivityFileSection" style="display: none;">
                            <label class="form-label fw-bold">File Information</label>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>File Name:</strong> <span id="viewActivityFileName"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>File Size:</strong> <span id="viewActivityFileSize"></span>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <button class="btn btn-primary me-2" onclick="viewActivityFile()" id="viewFileBtn">
                                            <i class="fas fa-eye"></i> View File
                                        </button>
                                        <button class="btn btn-success" onclick="downloadActivityFile()" id="downloadFileBtn">
                                            <i class="fas fa-download"></i> Download File
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" id="viewActivityNoFile" style="display: none;">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> No file attached to this activity.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    // Add activity form submission
    document.getElementById('addActivityForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        formData.append('action', 'add_activity');
        
        fetch('activities.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Success: ' + data.message);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while adding activity');
        });
    });

    // Edit activity form submission
    document.getElementById('editActivityForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        formData.append('action', 'edit_activity');
        
        fetch('activities.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Success: ' + data.message);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating activity');
        });
    });

    // Edit activity function
    function editActivity(id) {
        const formData = new FormData();
        formData.append('action', 'get_activity');
        formData.append('id', id);
        
        fetch('activities.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())        .then(data => {
            if (data.status === 'success') {
                const activity = data.data;                document.getElementById('editActivityId').value = activity.id;
                document.getElementById('editActivityTitle').value = activity.title;
                document.getElementById('editActivityDescription').value = activity.description;
                document.getElementById('editActivityClass').value = activity.class;
                
                // Update module dropdown and set selected value
                updateModuleDropdown('edit');
                setTimeout(() => {
                    document.getElementById('editActivityModule').value = activity.module;
                }, 100);
                
                new bootstrap.Modal(document.getElementById('editActivityModal')).show();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while loading activity data');
        });
    }

    // Delete activity function
    function deleteActivity(id) {
        if (confirm('Are you sure you want to delete this activity? This action cannot be undone.')) {
            const formData = new FormData();
            formData.append('action', 'delete_activity');
            formData.append('id', id);
            
            fetch('activities.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Success: ' + data.message);
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting activity');            });
        }
    }

    // View activity function
    function viewActivity(id) {
        const formData = new FormData();
        formData.append('action', 'get_activity');
        formData.append('id', id);
        
        fetch('activities.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const activity = data.data;
                
                // Populate the modal with activity data
                document.getElementById('viewActivityTitle').textContent = activity.title;
                document.getElementById('viewActivityDescription').textContent = activity.description || 'No description provided';
                document.getElementById('viewActivityClass').textContent = activity.class;
                document.getElementById('viewActivityModule').textContent = activity.module;                document.getElementById('viewActivityCreated').textContent = new Date(activity.created_at).toLocaleDateString();
                
                // Handle updated_at - show creation date if never updated
                if (activity.updated_at && activity.updated_at !== activity.created_at) {
                    document.getElementById('viewActivityUpdated').textContent = new Date(activity.updated_at).toLocaleDateString();
                } else {
                    document.getElementById('viewActivityUpdated').textContent = 'Not updated yet';
                }
                
                // Handle file information
                if (activity.file_path && activity.file_name) {
                    document.getElementById('viewActivityFileSection').style.display = 'block';
                    document.getElementById('viewActivityNoFile').style.display = 'none';
                    document.getElementById('viewActivityFileName').textContent = activity.file_name;
                    
                    // Calculate and display file size
                    calculateFileSize('../' + activity.file_path).then(size => {
                        document.getElementById('viewActivityFileSize').textContent = size;
                    });
                    
                    // Store file path for download/view functions
                    document.getElementById('viewFileBtn').setAttribute('data-file-path', activity.file_path);
                    document.getElementById('downloadFileBtn').setAttribute('data-file-path', activity.file_path);
                } else {
                    document.getElementById('viewActivityFileSection').style.display = 'none';
                    document.getElementById('viewActivityNoFile').style.display = 'block';
                }
                
                // Show the modal
                new bootstrap.Modal(document.getElementById('viewActivityModal')).show();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while loading activity details');
        });
    }

    // Function to view activity file
    function viewActivityFile() {
        const filePath = document.getElementById('viewFileBtn').getAttribute('data-file-path');
        if (filePath) {
            window.open('../' + filePath, '_blank');
        }
    }

    // Function to download activity file
    function downloadActivityFile() {
        const filePath = document.getElementById('downloadFileBtn').getAttribute('data-file-path');
        if (filePath) {
            const link = document.createElement('a');
            link.href = '../' + filePath;
            link.download = '';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }

    // Function to calculate file size
    async function calculateFileSize(filePath) {
        try {
            const response = await fetch(filePath, { method: 'HEAD' });
            const size = response.headers.get('content-length');
            if (size) {
                const sizeInBytes = parseInt(size);
                if (sizeInBytes < 1024) {
                    return sizeInBytes + ' B';
                } else if (sizeInBytes < 1024 * 1024) {
                    return (sizeInBytes / 1024).toFixed(1) + ' KB';
                } else {
                    return (sizeInBytes / (1024 * 1024)).toFixed(1) + ' MB';
                }
            }
            return 'Unknown';
        } catch (error) {
            return 'Unknown';
        }
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
            classSelect = document.getElementById('addActivityClass');
            moduleSelect = document.getElementById('addActivityModule');
        } else {
            classSelect = document.getElementById('editActivityClass');
            moduleSelect = document.getElementById('editActivityModule');
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
    document.getElementById('editActivityModal').addEventListener('show.bs.modal', function () {
        updateModuleDropdown('edit');
    });

    // Initialize module dropdown on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateModuleDropdown('add');    });
    </script>

<?php include 'includes/footer.php'; ?>
