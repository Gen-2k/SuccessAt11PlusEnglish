<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/auth.php';

header('Content-Type: application/json');

$response = ['status' => 'active'];

// Check if session is still valid
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    $response['status'] = 'expired';
} elseif (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    $response['status'] = 'expired';
} elseif (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT)) {
    $response['status'] = 'expired';
    session_unset();
    session_destroy();
}

// Update last activity if session is still active
if ($response['status'] === 'active') {
    $_SESSION['last_activity'] = time();
}

echo json_encode($response);
?>
