<?php
// NewAdminPanel Configuration (now uses global config from dbconfig.php)
require_once dirname(__DIR__, 2) . '/database/dbconfig.php';

// Admin panel specific settings
if (!defined('UPLOAD_PATH')) define('UPLOAD_PATH', __DIR__ . '/../uploads/');
if (!defined('RECORDS_PER_PAGE')) define('RECORDS_PER_PAGE', 25);
?>
