<?php	
	function sendOTP($otpEmail,$otp) {
		require './mail/PHPMailerAutoload.php';                    //PHPMailerAutoload.php
        require './mail/class.phpmailer.php';
        require './mail/class.smtp.php';
 
	
		$message_body = "One Time Password for Smile4Kids Forgot Password Authentication is:<br/><br/>" . $otp;
		$mail = new PHPMailer();
		$mail->isMail();
		$mail->SMTPDebug = 0;
		$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = "Safrina@smile4kids.co.uk";                 // SMTP username
		$mail->Password = 'teoiljmskiwvamwh';                           // SMTP password
		$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 465;
		$mail->SetFrom("Safrina@smile4kids.co.uk", " Success at 11 plus English");
		$mail->AddAddress($otpEmail);
		$mail->isHTML(true);
		$mail->Subject = "OTP for  Success at 11 plus English";
		$mail->MsgHTML($message_body);
		
		//This should be the same as the domain of your From address
                $mail->DKIM_domain = 'smile4kids.co.uk';
                //See the DKIM_gen_keys.phps script for making a key pair -
                //here we assume you've already done that.
                //Path to your private key:
                $mail->DKIM_private = './mail/dkim_private.pem';
                //Set this to your own selector
                $mail->DKIM_selector = 'default';
                //Put your private key's passphrase in here if it has one
                $mail->DKIM_passphrase = '';
                //The identity you're signing as - usually your From address
                $mail->DKIM_identity = $mail->From;
                //Suppress listing signed header fields in signature, defaults to true for debugging purpose
                $mail->DKIM_copyHeaderFields = false;
		
		$result = $mail->Send();
		
		return $result;
	}
