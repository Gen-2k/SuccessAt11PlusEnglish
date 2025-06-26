<?php	
	function sendOTP($otpEmail,$otp) {
		require './mail/PHPMailerAutoload.php';                    //PHPMailerAutoload.php
        require './mail/class.phpmailer.php';
        require './mail/class.smtp.php';
 
		// Unified, branded HTML template for OTP email (matches latest blue/gold design)
		$message_body = '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>OTP for Success At 11 Plus English</title>
  <style>
    body { margin:0; padding:0; background:#f7f7f7; }
    .wrapper { width:100%; table-layout:fixed; background:#f7f7f7; padding:30px 0; }
    .main { background:#ffffff; width:100%; max-width:480px; margin:0 auto; border-radius:8px; overflow:hidden; box-shadow:0 2px 8px #e0e0e0; }
    .header { background: linear-gradient(90deg, #1E40AF 0%, #F59E0B 100%); padding:24px; text-align:center; }
    .header h1 { margin:0; font-family:\'Source Serif Pro\', serif; font-size:1.5rem; color:#ffffff; }
    .header p { margin:8px 0 0; font-family:Varela Round, sans-serif; font-size:1rem; color:#e0e0e0; }
    .content { padding:28px; font-family:Varela Round, sans-serif; color:#212529; line-height:1.6; }
    .otp-box { background:#f0f4ff; color:#1E40AF; font-size:2rem; font-weight:bold; letter-spacing:6px; padding:18px 0; border-radius:6px; text-align:center; margin:24px 0; }
    .footer { background:#ffffff; text-align:center; padding:16px; font-size:12px; color:#888888; }
    .footer a { color:#1E40AF; text-decoration:none; }
    @media(max-width:600px) { .content{padding:20px;} .header h1{font-size:1.2rem;} }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="main">
      <div class="header">
        <h1>Password Reset OTP</h1>
        <p>Success at 11 Plus English</p>
      </div>
      <div class="content">
        <p>Dear User,</p>
        <p>Use the following OTP to reset your password for <strong>Success at 11 Plus English</strong>:</p>
        <div class="otp-box">' . htmlspecialchars($otp) . '</div>
        <p>This OTP is valid for a limited time. If you did not request a password reset, please ignore this email.</p>
        <table role="presentation" border="0" cellspacing="0" cellpadding="0" align="center" style="margin:24px auto 0;">
          <tr>
            <td align="center" bgcolor="#1E40AF" style="border-radius:4px;">
              <a href="https://elevenplusenglish.co.uk/Login.php" target="_blank" style="font-family:Varela Round, sans-serif; font-size:16px; color:#ffffff; text-decoration:none; padding:12px 24px; display:inline-block; font-weight:600;">Reset Password</a>
            </td>
          </tr>
        </table>
      </div>
      <div class="footer">
        &copy; ' . date('Y') . ' Success at 11 Plus English. All rights reserved.<br>
        <a href="https://elevenplusenglish.co.uk">www.elevenplusenglish.co.uk</a>
      </div>
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
