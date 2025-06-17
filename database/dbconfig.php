<?php
// Database and global site configuration
$server_name = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "successat11plus";

$connection = mysqli_connect($server_name, $db_username, $db_password, $db_name);
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Global site constants
if (!defined('BASE_URL')) define('BASE_URL', 'http://localhost/SuccessAt11PlusEnglish/');
if (!defined('SITE_NAME')) define('SITE_NAME', 'Success At 11 Plus English');
if (!defined('ADMIN_EMAIL')) define('ADMIN_EMAIL', 'admin@successat11plusenglish.com');
// Global session timeout (4 hours)
if (!defined('SESSION_TIMEOUT')) define('SESSION_TIMEOUT', 14400);
if (!defined('MAX_FILE_SIZE')) define('MAX_FILE_SIZE', 50 * 1024 * 1024); // 50MB default
if (!defined('ALLOWED_FILE_TYPES')) define('ALLOWED_FILE_TYPES', ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'txt', 'jpg', 'jpeg', 'png', 'gif']);
if (!defined('DATE_FORMAT')) define('DATE_FORMAT', 'M j, Y');
if (!defined('DATETIME_FORMAT')) define('DATETIME_FORMAT', 'M j, Y g:i A');
if (!defined('DEBUG_MODE')) define('DEBUG_MODE', true);
if (!defined('SITE_URL')) define('SITE_URL', BASE_URL);

date_default_timezone_set('Europe/London');


