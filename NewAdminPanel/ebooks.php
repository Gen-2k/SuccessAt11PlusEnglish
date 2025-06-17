<?php
require_once 'config/config.php';
require_once 'includes/auth.php';

// Check authentication
checkAdminAuth();

// Reuse the existing connection from dbconfig.php
$conn = $connection;
$current_page = 'ebooks';

// Handle AJAX requests
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'add_ebook':
            addEbook();
            break;
        case 'edit_ebook':
            editEbook();
            break;
        case 'delete_ebook':
            deleteEbook();
            break;
        case 'get_ebook':
            getEbook();
            break;
    }
    exit();
}

// Get ebooks with filters
$classFilter = isset($_GET['class']) ? $_GET['class'] : '';
$moduleFilter = isset($_GET['module']) ? $_GET['module'] : '';

$ebookQuery = "SELECT * FROM ebooks";
$conditions = [];

if (!empty($classFilter)) {
    $conditions[] = "class = '" . mysqli_real_escape_string($conn, $classFilter) . "'";
}
if (!empty($moduleFilter)) {
    $conditions[] = "module = '" . mysqli_real_escape_string($conn, $moduleFilter) . "'";
}

if (!empty($conditions)) {
    $ebookQuery .= " WHERE " . implode(" AND ", $conditions);
}

$ebookQuery .= " ORDER BY created_at DESC";
$ebookResult = mysqli_query($conn, $ebookQuery);

// Get distinct classes and modules for filters
$classesQuery = "SELECT DISTINCT class FROM ebooks WHERE class IS NOT NULL";
$classesResult = mysqli_query($conn, $classesQuery);

$modulesQuery = "SELECT DISTINCT module FROM ebooks WHERE module IS NOT NULL";
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
function addEbook() {
    global $conn;
    
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $class = mysqli_real_escape_string($conn, $_POST['class']);
    $module = mysqli_real_escape_string($conn, $_POST['module']);
    $price = floatval($_POST['price']);
    
    // Handle file upload
    $fileName = '';
    $filePath = '';
    
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $uploadDir = '../uploads/ebooks/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $fileName = time() . '_' . $_FILES['file']['name'];
        $filePath = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
            $filePath = 'uploads/ebooks/' . $fileName;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'File upload failed']);
            return;
        }
    }
    
    $query = "INSERT INTO ebooks (class, module, title, description, file_name, file_path, price) 
              VALUES ('$class', '$module', '$title', '$description', '$fileName', '$filePath', $price)";
    
    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'success', 'message' => 'E-book added successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add e-book']);
    }
}

function editEbook() {
    global $conn;
    
    $id = intval($_POST['id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $class = mysqli_real_escape_string($conn, $_POST['class']);
    $module = mysqli_real_escape_string($conn, $_POST['module']);
    $price = floatval($_POST['price']);
    
    $query = "UPDATE ebooks SET 
              title = '$title', 
              description = '$description', 
              class = '$class', 
              module = '$module',
              price = $price,
              updated_at = NOW()
              WHERE id = $id";
    
    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'success', 'message' => 'E-book updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update e-book']);
    }
}

function deleteEbook() {
    global $conn;
    
    $id = intval($_POST['id']);
    
    // Get file path before deleting
    $fileQuery = "SELECT file_path FROM ebooks WHERE id = $id";
    $fileResult = mysqli_query($conn, $fileQuery);
    $fileData = mysqli_fetch_assoc($fileResult);
    
    $query = "DELETE FROM ebooks WHERE id = $id";
    
    if (mysqli_query($conn, $query)) {
        // Delete file if exists
        if ($fileData && $fileData['file_path'] && file_exists('../' . $fileData['file_path'])) {
            unlink('../' . $fileData['file_path']);
        }
        echo json_encode(['status' => 'success', 'message' => 'E-book deleted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete e-book']);
    }
}

function getEbook() {
    global $conn;
    
    $id = intval($_POST['id']);
    $query = "SELECT * FROM ebooks WHERE id = $id";
    $result = mysqli_query($conn, $query);
    
    if ($ebook = mysqli_fetch_assoc($result)) {
        echo json_encode(['status' => 'success', 'data' => $ebook]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'E-book not found']);
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
                            <h1 class="page-title">E-books Management</h1>
                            <p class="page-subtitle">Manage digital books and educational resources</p>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active">E-books</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container-fluid">
                    <div class="row mb-3">
                        <div class="col-12">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEbookModal">
                                <i class="fas fa-plus"></i> Add E-book
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
                                    <button type="button" class="btn btn-secondary" onclick="window.location.href='ebooks.php'">
                                        <i class="fas fa-times"></i> Clear Filters
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- E-books List -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table ebook-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Class</th>
                                        <th>Module</th>
                                        <th>Price</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($ebook = mysqli_fetch_assoc($ebookResult)): ?>
                                    <tr>
                                        <td><?php echo $ebook['id']; ?></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($ebook['title']); ?></strong>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <?php echo htmlspecialchars(substr($ebook['description'], 0, 100)) . (strlen($ebook['description']) > 100 ? '...' : ''); ?>
                                            </small>
                                        </td>
                                        <td><span class="badge badge-ebook"><?php echo htmlspecialchars($ebook['class']); ?></span></td>
                                        <td><span class="badge bg-secondary"><?php echo htmlspecialchars($ebook['module']); ?></span></td>
                                        <td>
                                            <?php if($ebook['price'] > 0): ?>
                                                <span class="text-success">£<?php echo number_format($ebook['price'], 2); ?></span>
                                            <?php else: ?>
                                                <span class="text-primary">Free</span>
                                            <?php endif; ?>
                                        </td>
                        <td><?php echo date('M d, Y', strtotime($ebook['created_at'])); ?></td>
                        <td>
                            <div class="btn-group">
                                <button class="btn-sm btn-view btn-tooltip" onclick="viewEbook(<?php echo $ebook['id']; ?>)" data-tooltip="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-sm btn-edit btn-tooltip" onclick="editEbook(<?php echo $ebook['id']; ?>)" data-tooltip="Edit E-book">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-sm btn-delete btn-tooltip" onclick="deleteEbook(<?php echo $ebook['id']; ?>)" data-tooltip="Delete E-book">
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

    <!-- Add E-book Modal -->
    <div class="modal fade" id="addEbookModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add E-book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="addEbookForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Title *</label>
                                <input type="text" class="form-control" name="title" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3" placeholder="Book description and content overview"></textarea>
                            </div>                            <div class="col-md-6">
                                <label class="form-label">Class *</label>
                                <select class="form-select" name="class" id="addEbookClass" required onchange="updateModuleDropdown('add')">
                                    <option value="">Select Class</option>
                                    <option value="year4">Year 4</option>
                                    <option value="year5">Year 5</option>
                                    <option value="year6">Year 6</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Module *</label>
                                <select class="form-select" name="module" id="addEbookModule" required>
                                    <option value="">Select Module</option>
                                    <?php 
                                    $allModules = array_unique(array_merge(...array_values($availableModules)));
                                    foreach ($allModules as $module): ?>
                                        <option value="<?php echo $module; ?>"><?php echo $module; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Price (£)</label>
                                <input type="number" class="form-control" name="price" step="0.01" min="0" value="0" placeholder="0.00">
                                <small class="form-text text-muted">Enter 0 for free e-books</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">File Upload *</label>
                                <input type="file" class="form-control" name="file" accept=".pdf,.epub,.mobi" required>
                            </div>
                            <div class="col-md-12">
                                <small class="form-text text-muted">Supported formats: PDF, EPUB, MOBI</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add E-book</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit E-book Modal -->
    <div class="modal fade" id="editEbookModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit E-book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editEbookForm">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editEbookId">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Title *</label>
                                <input type="text" class="form-control" name="title" id="editEbookTitle" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="editEbookDescription" rows="3"></textarea>
                            </div>                            <div class="col-md-6">
                                <label class="form-label">Class *</label>
                                <select class="form-select" name="class" id="editEbookClass" required onchange="updateModuleDropdown('edit')">
                                    <option value="">Select Class</option>
                                    <option value="year4">Year 4</option>
                                    <option value="year5">Year 5</option>
                                    <option value="year6">Year 6</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Module *</label>
                                <select class="form-select" name="module" id="editEbookModule" required>
                                    <option value="">Select Module</option>
                                    <?php 
                                    $allModules = array_unique(array_merge(...array_values($availableModules)));
                                    foreach ($allModules as $module): ?>
                                        <option value="<?php echo $module; ?>"><?php echo $module; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Price (£)</label>
                                <input type="number" class="form-control" name="price" id="editEbookPrice" step="0.01" min="0">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update E-book</button>
                    </div>                </form>
            </div>
        </div>
    </div>

    <!-- View E-book Modal -->
    <div class="modal fade" id="viewEbookModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">E-book Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Title</label>
                            <p class="form-control-plaintext" id="viewEbookTitle"></p>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Description</label>
                            <p class="form-control-plaintext" id="viewEbookDescription"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Class</label>
                            <p class="form-control-plaintext" id="viewEbookClass"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Module</label>
                            <p class="form-control-plaintext" id="viewEbookModule"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Price</label>
                            <p class="form-control-plaintext" id="viewEbookPrice"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Created Date</label>
                            <p class="form-control-plaintext" id="viewEbookCreated"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Last Updated</label>
                            <p class="form-control-plaintext" id="viewEbookUpdated"></p>
                        </div>
                        <div class="col-md-12" id="viewEbookFileSection" style="display: none;">
                            <label class="form-label fw-bold">File Information</label>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>File Name:</strong> <span id="viewEbookFileName"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>File Size:</strong> <span id="viewEbookFileSize"></span>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <button class="btn btn-primary me-2" onclick="viewEbookFile()" id="viewEbookFileBtn">
                                            <i class="fas fa-eye"></i> View File
                                        </button>
                                        <button class="btn btn-success" onclick="downloadEbookFile()" id="downloadEbookFileBtn">
                                            <i class="fas fa-download"></i> Download File
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" id="viewEbookNoFile" style="display: none;">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> No file attached to this e-book.
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
    // Add ebook form submission
    document.getElementById('addEbookForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        formData.append('action', 'add_ebook');
        
        fetch('ebooks.php', {
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
            alert('An error occurred while adding e-book');
        });
    });

    // Edit ebook form submission
    document.getElementById('editEbookForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        formData.append('action', 'edit_ebook');
        
        fetch('ebooks.php', {
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
            alert('An error occurred while updating e-book');
        });
    });    // Edit ebook function
    function editEbook(id) {
        const formData = new FormData();
        formData.append('action', 'get_ebook');
        formData.append('id', id);
        
        fetch('ebooks.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const ebook = data.data;
                document.getElementById('editEbookId').value = ebook.id;
                document.getElementById('editEbookTitle').value = ebook.title;
                document.getElementById('editEbookDescription').value = ebook.description;
                document.getElementById('editEbookClass').value = ebook.class;
                document.getElementById('editEbookPrice').value = ebook.price;
                
                // Update module dropdown and set selected value
                updateModuleDropdown('edit');
                setTimeout(() => {
                    document.getElementById('editEbookModule').value = ebook.module;
                }, 100);
                
                new bootstrap.Modal(document.getElementById('editEbookModal')).show();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while loading e-book data');
        });
    }

    // Delete ebook function
    function deleteEbook(id) {
        if (confirm('Are you sure you want to delete this e-book? This action cannot be undone.')) {
            const formData = new FormData();
            formData.append('action', 'delete_ebook');
            formData.append('id', id);
            
            fetch('ebooks.php', {
                method: 'POST',
                body: formData
            })            .then(response => response.json())
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
                alert('An error occurred while deleting e-book');            });
        }
    }

    // Available modules for each class
    const availableModules = {
        'year4': ['Comprehension', 'Creative Writing', 'SPaG', 'English Vocabulary', 'Verbal Reasoning', 'Carousel Course', '1:1 Tutoring'],
        'year5': ['Comprehension', 'Creative Writing', 'SPaG', 'English Vocabulary', 'Verbal Reasoning', 'Carousel Course', '1:1 Tutoring'],
        'year6': ['Comprehension', 'Creative Writing', 'SPaG', 'English Vocabulary', 'Verbal Reasoning', 'Carousel Course', '1:1 Tutoring']
    };

    // Function to update module dropdown based on selected class
    function updateModuleDropdown(type) {
        let classSelect, moduleSelect;
        
        if (type === 'add') {
            classSelect = document.getElementById('addEbookClass');
            moduleSelect = document.getElementById('addEbookModule');
        } else if (type === 'edit') {
            classSelect = document.getElementById('editEbookClass');
            moduleSelect = document.getElementById('editEbookModule');
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
    document.getElementById('editEbookModal').addEventListener('show.bs.modal', function () {
        updateModuleDropdown('edit');
    });

    // Initialize module dropdown on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateModuleDropdown('add');
    });

    // View ebook function
    function viewEbook(id) {
        const formData = new FormData();
        formData.append('action', 'get_ebook');
        formData.append('id', id);
        
        fetch('ebooks.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const ebook = data.data;
                
                // Populate the modal with ebook data
                document.getElementById('viewEbookTitle').textContent = ebook.title;
                document.getElementById('viewEbookDescription').textContent = ebook.description || 'No description provided';
                document.getElementById('viewEbookClass').textContent = ebook.class;
                document.getElementById('viewEbookModule').textContent = ebook.module;                document.getElementById('viewEbookCreated').textContent = new Date(ebook.created_at).toLocaleDateString();
                
                // Handle updated_at - show creation date if never updated
                if (ebook.updated_at && ebook.updated_at !== ebook.created_at) {
                    document.getElementById('viewEbookUpdated').textContent = new Date(ebook.updated_at).toLocaleDateString();
                } else {
                    document.getElementById('viewEbookUpdated').textContent = 'Not updated yet';
                }
                
                // Handle price display
                if (ebook.price && parseFloat(ebook.price) > 0) {
                    document.getElementById('viewEbookPrice').innerHTML = '<span class="text-success">£' + parseFloat(ebook.price).toFixed(2) + '</span>';
                } else {
                    document.getElementById('viewEbookPrice').innerHTML = '<span class="text-primary">Free</span>';
                }
                
                // Handle file information
                if (ebook.file_path && ebook.file_name) {
                    document.getElementById('viewEbookFileSection').style.display = 'block';
                    document.getElementById('viewEbookNoFile').style.display = 'none';
                    document.getElementById('viewEbookFileName').textContent = ebook.file_name;
                    
                    // Calculate and display file size
                    calculateFileSize('../' + ebook.file_path).then(size => {
                        document.getElementById('viewEbookFileSize').textContent = size;
                    });
                    
                    // Store file path for download/view functions
                    document.getElementById('viewEbookFileBtn').setAttribute('data-file-path', ebook.file_path);
                    document.getElementById('downloadEbookFileBtn').setAttribute('data-file-path', ebook.file_path);
                } else {
                    document.getElementById('viewEbookFileSection').style.display = 'none';
                    document.getElementById('viewEbookNoFile').style.display = 'block';
                }
                
                // Show the modal
                new bootstrap.Modal(document.getElementById('viewEbookModal')).show();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while loading e-book details');
        });
    }

    // Function to view ebook file
    function viewEbookFile() {
        const filePath = document.getElementById('viewEbookFileBtn').getAttribute('data-file-path');
        if (filePath) {
            window.open('../' + filePath, '_blank');
        }
    }

    // Function to download ebook file
    function downloadEbookFile() {
        const filePath = document.getElementById('downloadEbookFileBtn').getAttribute('data-file-path');
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
        }    }
    </script>

<?php include 'includes/footer.php'; ?>
