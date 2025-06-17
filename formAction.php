<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once __DIR__ . '/database/dbconfig.php';

// Handle AJAX email check
if (isset($_POST['userEmail'])) {
    $userEmail = $_POST['userEmail'];
    $emailQ = "SELECT email FROM students WHERE email = '$userEmail'";
    $emailQR = mysqli_query($connection, $emailQ);
    if (mysqli_num_rows($emailQR) > 0) {
        echo "Email Exist";
    } else {
        echo "Available";
    }
    exit();
}

// Handle form submission for new payment flow
if (isset($_POST['submit'])) {
    if (!empty($_POST)) {
        // Set session data from form submission to ensure it's available
        if (isset($_POST['studentCourse'])) {
            $_SESSION['classid'] = $_POST['studentCourse'];
            $_SESSION['courseId'] = $_POST['studentCourse'];
            
            // Check if module is provided (new format)
            if (isset($_POST['module'])) {
                $_SESSION['module'] = $_POST['module'];
                $_SESSION['courseName'] = $_POST['studentCourse'] . ' - ' . $_POST['module'];
            } elseif (!isset($_SESSION['courseName'])) {
                // Fallback for old format or missing courseName
                $_SESSION['courseName'] = $_POST['studentCourse'];
            }
        }
        
        // Validate required session data (less strict validation)
        if (!isset($_SESSION['classid']) || empty($_SESSION['classid'])) {
            $_SESSION['status_code'] = "Error";
            $_SESSION['status'] = 'Session expired. Please try again.';
            header("Location: " . BASE_URL . "index.php");
            exit();
        }        // Extract form data
        $email = trim($_POST['email']);
          // Set additional session data for payment processing
        $_SESSION['fname'] = $_POST['fname'] ?? '';
        $_SESSION['lname'] = $_POST['surname'] ?? '';
        $_SESSION['email'] = $email;
        $_SESSION['phone'] = $_POST['phone'] ?? '';
        $_SESSION['parentName'] = $_POST['parentfirstname'] ?? '';
        $_SESSION['parentSurname'] = $_POST['parentsurname'] ?? '';
        $_SESSION['dob'] = $_POST['dob'] ?? '';
        $_SESSION['gender'] = $_POST['gender'] ?? '';
        $_SESSION['address'] = $_POST['address'] ?? '';
        $_SESSION['yesorno'] = $_POST['yesorno'] ?? 'yes';
        
        // Check if email already exists
        $emailQ = "SELECT email FROM students WHERE email = ?";
        $stmt = mysqli_prepare($connection, $emailQ);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) > 0) {
            $_SESSION['error'] = "Email already exists. Please use a different email address.";
            
            // Use simplified parameters if available, otherwise fall back to old format
            if (isset($_SESSION['module'])) {
                $class = $_SESSION['classid'];
                $module = $_SESSION['module'];
                header("Location: " . BASE_URL . "applyForm.php?class=" . urlencode($class) . "&module=" . urlencode($module));
            } else {
                $classId = $_SESSION['classid'];
                $courseId = $_SESSION['courseId']; 
                $courseName = $_SESSION['courseName'];
                header("Location: " . BASE_URL . "applyForm.php?lan=" . urlencode($classId) . "&course=" . urlencode($courseId) . "&courseName=" . urlencode($courseName));
            }
            exit();
        }

        // All validation passed, redirect to new payment flow
        header("Location: " . BASE_URL . "payment/process_module_payment.php");
        exit();
        
    } else {
        $_SESSION['status_code'] = "Error";
        $_SESSION['status'] = 'Please fill in all required fields.';
        header("Location: " . BASE_URL . "index.php");
        exit();
    }
}
?>

