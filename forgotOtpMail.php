<?php	
	function sendOTP($otpEmail,$otp) {
		require './mail/PHPMailerAutoload.php';                    //PHPMailerAutoload.php
        require './mail/class.phpmailer.php';
        require './mail/class.smtp.php';
 
		// Modern, branded HTML template for OTP email
		$message_body = '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>OTP for Success At 11 Plus English</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f7f7fb; margin: 0; padding: 0; }
    .container { background: #fff; max-width: 480px; margin: 40px auto; border-radius: 8px; box-shadow: 0 2px 8px #e0e0e0; padding: 32px 24px; }
    .logo { text-align: center; margin-bottom: 24px; }
    .otp-box { background: #f0f4ff; color: #1a237e; font-size: 2rem; font-weight: bold; letter-spacing: 6px; padding: 18px 0; border-radius: 6px; text-align: center; margin: 24px 0; }
    .footer { color: #888; font-size: 0.95rem; text-align: center; margin-top: 32px; }
    .brand { color: #1a237e; font-weight: bold; }
  </style>
</head>
<body>
  <div class="container">
    <div class="logo">
      <img src="https://elevenplusenglish.co.uk/assets/images/logonew.png" alt="Success At 11 Plus English" style="max-width: 180px;">
    </div>
    <h2 style="color:#1a237e;">Your One Time Password (OTP)</h2>
    <p>Dear User,</p>
    <p>Use the following OTP to reset your password for <span class="brand">Success At 11 Plus English</span>:</p>
    <div class="otp-box">' . htmlspecialchars($otp) . '</div>
    <p>This OTP is valid for a limited time. If you did not request a password reset, please ignore this email.</p>
    <div class="footer">
      &copy; ' . date('Y') . ' Success At 11 Plus English. All rights reserved.<br>
      <a href="https://elevenplusenglish.co.uk" style="color:#1a237e;text-decoration:none;">www.elevenplusenglish.co.uk</a>
    </div>
  </div>
</body>
</html>';

		// Load common mail config
        $mailConfig = require __DIR__ . '/mail/mail_config.php';

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = $mailConfig['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $mailConfig['username'];
        $mail->Password = $mailConfig['password'];
        $mail->SMTPSecure = $mailConfig['smtp_secure'];
        $mail->Port = $mailConfig['port'];
        $mail->SetFrom($mailConfig['from_email'], $mailConfig['from_name']);
        $mail->addReplyTo($mailConfig['reply_to_email'], $mailConfig['reply_to_name']);
        $mail->AddAddress($otpEmail);
        $mail->isHTML(true);
        $mail->Subject = 'OTP for Success At 11 Plus English';
        $mail->MsgHTML($message_body);

        // DKIM settings (commented out for now)
        // if (isset($mailConfig['dkim_domain'])) {
        //     $mail->DKIM_domain = $mailConfig['dkim_domain'];
        //     $mail->DKIM_private = $mailConfig['dkim_private'];
        //     $mail->DKIM_selector = $mailConfig['dkim_selector'];
        //     $mail->DKIM_passphrase = $mailConfig['dkim_passphrase'];
        //     $mail->DKIM_identity = $mailConfig['dkim_identity'];
        //     $mail->DKIM_copyHeaderFields = $mailConfig['dkim_copyHeaderFields'];
        // }

		
		$result = $mail->Send();
		return $result;
	}
