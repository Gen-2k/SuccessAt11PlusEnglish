<?php
// Student Filter and Search Module
// This file handles the filtering logic for the student management system

// Check if this is an AJAX request for filtering students
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'filter_students') {
    header('Content-Type: application/json');
    
    $class_filter = isset($_POST['class']) ? $_POST['class'] : '';
    $module_filter = isset($_POST['module']) ? $_POST['module'] : '';
    $status_filter = isset($_POST['status']) ? $_POST['status'] : '';
    $search = isset($_POST['search']) ? $_POST['search'] : '';
    
    // Build the filtered query
    $query = "SELECT 
        s.id, 
        s.fname,
        s.surname,
        CONCAT(s.fname, ' ', s.surname) as student_name, 
        s.email, 
        s.dob,
        s.gender,
        s.phone,
        s.parent_firstname,
        s.parent_surname,
        s.address,
        s.yesorno,
        s.role,
        s.created_at,
        e.class,
        e.module,
        e.price,
        e.payment_status,
        e.access_start,
        e.access_end,
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
    WHERE s.role = 'user'";
    
    $params = [];
    $types = "";
    
    if (!empty($class_filter)) {
        $query .= " AND e.class = ?";
        $params[] = $class_filter;
        $types .= "s";
    }
    
    if (!empty($module_filter)) {
        $query .= " AND e.module LIKE ?";
        $params[] = "%$module_filter%";
        $types .= "s";
    }
    
    if (!empty($status_filter)) {
        if ($status_filter === 'Active') {
            $query .= " AND e.payment_status = 'paid' AND (e.access_end IS NULL OR e.access_end >= CURDATE())";
        } elseif ($status_filter === 'Pending') {
            $query .= " AND e.payment_status = 'pending'";
        } elseif ($status_filter === 'Expired') {
            $query .= " AND e.access_end < CURDATE()";
        } elseif ($status_filter === 'Inactive') {
            $query .= " AND (e.payment_status IS NULL OR (e.payment_status != 'paid' AND e.payment_status != 'pending'))";
        }
    }
    
    if (!empty($search)) {
        $query .= " AND (CONCAT(s.fname, ' ', s.surname) LIKE ? OR s.email LIKE ? OR s.parent_firstname LIKE ?)";
        $search_param = "%$search%";
        $params[] = $search_param;
        $params[] = $search_param;
        $params[] = $search_param;
        $types .= "sss";
    }
    
    $query .= " ORDER BY s.created_at DESC";
    
    $stmt = mysqli_prepare($conn, $query);
    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $students = [];
    while ($student = mysqli_fetch_assoc($result)) {
        $students[] = $student;
    }
    
    echo json_encode([
        'success' => true,
        'students' => $students,
        'count' => count($students)
    ]);
    exit();
}

// Check if this is an AJAX request for getting modules
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'get_modules') {
    header('Content-Type: application/json');
    
    // Get distinct modules for filter
    $modules_query = "SELECT DISTINCT module FROM enrollments WHERE module IS NOT NULL AND module != '' ORDER BY module";
    $modules_result = mysqli_query($conn, $modules_query);
      $modules = [];
    while ($module = mysqli_fetch_assoc($modules_result)) {
        $modules[] = $module['module'];
    }
    
    echo json_encode([
        'success' => true,
        'modules' => $modules
    ]);
    exit();
}

// Check if this is an AJAX request for getting modules and classes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'get_modules_and_classes') {
    header('Content-Type: application/json');
    // Get distinct modules
    $modules_query = "SELECT DISTINCT module FROM enrollments WHERE module IS NOT NULL AND module != '' ORDER BY module";
    $modules_result = mysqli_query($conn, $modules_query);
    $modules = [];
    while ($module = mysqli_fetch_assoc($modules_result)) {
        $modules[] = $module['module'];
    }
    // Get distinct classes
    $classes_query = "SELECT DISTINCT class FROM enrollments WHERE class IS NOT NULL AND class != '' ORDER BY class";
    $classes_result = mysqli_query($conn, $classes_query);
    $classes = [];
    while ($class = mysqli_fetch_assoc($classes_result)) {
        $classes[] = $class['class'];
    }
    echo json_encode([
        'success' => true,
        'modules' => $modules,
        'classes' => $classes
    ]);
    exit();
}

// Get filter parameters for page load
$class_filter = isset($_GET['class']) ? $_GET['class'] : '';
$module_filter = isset($_GET['module']) ? $_GET['module'] : '';
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Build query with filters for initial page load
$query = "SELECT 
    s.id, 
    s.fname,
    s.surname,
    CONCAT(s.fname, ' ', s.surname) as student_name, 
    s.email, 
    s.dob,
    s.gender,
    s.phone,
    s.parent_firstname,
    s.parent_surname,
    s.address,
    s.yesorno,
    s.role,
    s.created_at,
    e.class,
    e.module,
    e.price,
    e.payment_status,
    e.access_start,
    e.access_end,
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
WHERE s.role = 'user'";

$params = [];
$types = "";

if (!empty($class_filter)) {
    $query .= " AND e.class = ?";
    $params[] = $class_filter;
    $types .= "s";
}

if (!empty($module_filter)) {
    $query .= " AND e.module LIKE ?";
    $params[] = "%$module_filter%";
    $types .= "s";
}

if (!empty($status_filter)) {
    if ($status_filter === 'Active') {
        $query .= " AND e.payment_status = 'paid' AND (e.access_end IS NULL OR e.access_end >= CURDATE())";
    } elseif ($status_filter === 'Pending') {
        $query .= " AND e.payment_status = 'pending'";
    } elseif ($status_filter === 'Expired') {
        $query .= " AND e.access_end < CURDATE()";
    } elseif ($status_filter === 'Inactive') {
        $query .= " AND (e.payment_status IS NULL OR (e.payment_status != 'paid' AND e.payment_status != 'pending'))";
    }
}

if (!empty($search)) {
    $query .= " AND (CONCAT(s.fname, ' ', s.surname) LIKE ? OR s.email LIKE ? OR s.parent_firstname LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "sss";
}

$query .= " ORDER BY s.created_at DESC";
?>
