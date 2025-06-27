<?php
/**
 * Unsubscribe Link Generator
 * Centralized function to generate consistent unsubscribe links
 */

/**
 * Generate unsubscribe link with proper domain detection
 * @param string $email The email address to unsubscribe
 * @return string The complete unsubscribe URL
 */
function generateUnsubscribeLink($email) {
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return '#';
    }
    
    // Get base URL - try to load config if BASE_URL not defined
    if (!defined('BASE_URL')) {
        // Try to include config file
        $configPath = __DIR__ . '/../database/dbconfig.php';
        if (file_exists($configPath)) {
            require_once $configPath;
        }
    }
    
    // Fallback BASE_URL if still not defined
    if (!defined('BASE_URL')) {
        if (isset($_SERVER['HTTP_HOST'])) {
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
            $host = $_SERVER['HTTP_HOST'];
            if (strpos($host, 'localhost') !== false) {
                $baseUrl = $protocol . '://' . $host . '/SuccessAt11PlusEnglish/';
            } else {
                $baseUrl = $protocol . '://elevenplusenglish.co.uk/';
            }
        } else {
            $baseUrl = 'https://elevenplusenglish.co.uk/';
        }
    } else {
        $baseUrl = BASE_URL;
    }
    
    // Encode email for URL
    $encodedEmail = base64_encode($email);
    
    // Generate full unsubscribe URL
    return $baseUrl . 'unsubscribe.php?unsub_email=' . urlencode($encodedEmail);
}

/**
 * Generate unsubscribe footer HTML for emails
 * @param string $email The email address
 * @return string HTML footer with unsubscribe link
 */
function generateUnsubscribeFooter($email) {
    $unsubscribeUrl = generateUnsubscribeLink($email);
    $currentYear = date('Y');
    
    return '
    <div class="footer" style="background:#f8f9fa; text-align:center; padding:20px; font-size:12px; color:#666; border-top:1px solid #dee2e6; margin-top:30px;">
        <p style="margin:0 0 10px;">
            &copy; ' . $currentYear . ' Success at 11 Plus English. All rights reserved.
        </p>
        <p style="margin:0;">
            <a href="' . htmlspecialchars($unsubscribeUrl) . '" style="color:#1E40AF; text-decoration:none;">Unsubscribe from this newsletter</a>
        </p>
    </div>';
}

// /**
//  * Test function to verify unsubscribe link generation
//  * @param string $testEmail Email to test with
//  */
// function testUnsubscribeLink($testEmail = 'test@example.com') {
//     $link = generateUnsubscribeLink($testEmail);
//     echo "<h3>Unsubscribe Link Test</h3>";
//     echo "<p><strong>Test Email:</strong> $testEmail</p>";
//     echo "<p><strong>Generated Link:</strong></p>";
//     echo "<p><a href='$link' target='_blank'>$link</a></p>";
//     echo "<hr>";
//     echo "<h4>Footer HTML:</h4>";
//     echo "<div style='border:1px solid #ccc; padding:10px; background:#f9f9f9;'>";
//     echo generateUnsubscribeFooter($testEmail);
//     echo "</div>";
// }
 ?>
