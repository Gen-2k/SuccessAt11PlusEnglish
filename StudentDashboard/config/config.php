<?php
// Student Dashboard Configuration (now uses global config from dbconfig.php)
require_once __DIR__ . '/../../database/dbconfig.php';

// Paths & URLs
if (!defined('STUDENT_DASHBOARD_PATH')) define('STUDENT_DASHBOARD_PATH', __DIR__ . '/..');
if (!defined('STUDENT_DASHBOARD_URL')) define('STUDENT_DASHBOARD_URL', BASE_URL . 'StudentDashboard/');

// Student Dashboard specific settings (if any)

// Session timeout for student dashboard (4 hours)
// (Now set globally in dbconfig.php)

// Debug functions (optional)
$debugFile = __DIR__ . '/../includes/debug.php';
if (file_exists($debugFile)) {
    require_once $debugFile;
}
?>
