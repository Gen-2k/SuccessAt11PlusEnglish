<?php
// mail/mail_config.php
// Centralized mail configuration for Success At 11 Plus English
// Usage: $mailConfig = require __DIR__ . '/mail_config.php';

return [
    // SMTP Server
    'host'           => 'mail.elevenplusenglish.co.uk',
    'username'       => 'success@elevenplusenglish.co.uk',
    'password'       => 'Monday@123',
    'smtp_secure'    => 'ssl',
    'port'           => 465,

    // Sender Info
    'from_email'     => 'success@elevenplusenglish.co.uk',
    'from_name'      => 'Success At 11 Plus English',
    'reply_to_email' => 'success@elevenplusenglish.co.uk',
    'reply_to_name'  => 'Success At 11 Plus English',

    // DKIM (commented out for now)
    // 'dkim_domain'         => 'elevenplusenglish.co.uk',
    // 'dkim_private'        => __DIR__ . '/dkim_private.pem',
    // 'dkim_selector'       => 'default',
    // 'dkim_passphrase'     => '',
    // 'dkim_identity'       => 'success@elevenplusenglish.co.uk',
    // 'dkim_copyHeaderFields' => false,

    // General
    'charset'        => 'UTF-8',
    'is_html'        => true,
];
