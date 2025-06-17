<?php
if (!isset($_SESSION)) {
    session_start();
}
require dirname(__DIR__) . '/database/dbconfig.php';
$file_name = '';
$tmp_name = '';
if(isset($_POST['newsletter'])){
    // print_r($_POST);
    // $subject = $_POST['subject'];
    $heading=$_POST['newsLetterHeading'];
    $body = $_POST['news'];
    $file_name = $_FILES['files']['name'];
       
    if($body){
        //$output = '';
        $tmp_name = $_FILES['files']['tmp_name'];
        $allUsers = "SELECT * FROM newsletter";
        $query_run = mysqli_query($connection, $allUsers);
            if(mysqli_num_rows($query_run) > 0){
                $output = '';
                while($userData = mysqli_fetch_assoc($query_run))
                    {
                      //print_r($userData);
                        $nluserMail=$userData['Subr_email'];
                        require_once '../mail/PHPMailerAutoload.php';                    //PHPMailerAutoload.php
                        require_once '../mail/class.phpmailer.php';
                        require_once '../mail/class.smtp.php';
                        
                        $mail = new PHPMailer;
                        $mail->isSendMail();
                       	$mail->isMail();
                        // $mail->isSMTP();
                        
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->SMTPSecure = 'ssl';   //ssl tls
                        $mail->Port = 465;
                        $mail->Username = 'Safrina@smile4kids.co.uk'; //your-Yahoo-address@Yahoo.com
                        $mail->Password = 'teoiljmskiwvamwh'; //add-your-Yahoo-Password
                        $mail->setfrom('Safrina@smile4kids.co.uk', ' Success at 11 plus English');
                        
                        $mail->addAddress($userData['Subr_email'], $userData['Subr_fname']);
                        if($tmp_name !='' && $file_name !=''){
                            $mail->addAttachment($tmp_name, $file_name);
                        }
                        //  $mail->addCustomHeader('Content-Transfer-Encoding: BASE64');
                        $mail->addReplyTo('Safrina@smile4kids.co.uk', ' Success at 11 plus English');
                        $mail->CharSet = 'UTF-8';
                        $mail->isHTML(true);
                        $mail->Subject = 'Newsletter From Smile4Kids';
                        $mail->Body = '<html><body>';
                        $mail->Body.='<div style="font-family: Helvetica Neue, Arial, sans-serif; line-height: 1.5; width:100%;height:100%; display: flex; justify-content:center; align-items:center ; font-size:17px"> <table id="tabbleData" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); background-color: white; width:100%; max-width:50rem; height:100%; padding:2rem;">';
                        $mail->Body.='<tr><td style="text-align: center; border-bottom:solid black 1px; padding:1rem;"><img src="https://smile4kids.co.uk/assets/images/log2.png" alt="smile4kids" style="width:140px;"></td></tr>';
                        $mail->Body.='<tr><td><h2 style="color: #6e20a7; text-align: center;  text-transform: uppercase;">'. nl2br($heading).'</h2></td>';
                        $mail->Body.='<tr style="padding:2rem;"><td>Dear ' . $userData['Subr_fname'] . ',<br><br>' . nl2br($body) . '</td></tr>';
                        $mail->Body.= '<tr></tr><tr style="font-size:12px; text-align:center; background-color:#dcdde1; color:#6e20a7"><td style="padding: 1rem;">Regards,<br>Smile4Kids Indian Language School,<br> <a href="https://smile4kids.co.uk/index" target="_blank">smile4kids.co.uk</a><br/><br/>Unsubscribe to click <a href="https://www.smile4kids.co.uk/unsubscribe.php?unsub_email=' . base64_encode($nluserMail) . '">here</a><td></tr> </table></div></body></html>';
                        // $mail->Body    = '<html><body><p>Dear '.$userData['Subr_fname'].',<br><br>' . $body . '<br><br>Regards,<br>Smile4Kids Indian Language School,<br> <a href="https://smile4kids.co.uk/index" target="_blank">smile4kids.co.uk</a><br/><br/>Unsubscribe to click <a href="https://www.smile4kids.co.uk/unsubscribe.php?unsub_email='. base64_encode($nluserMail) .'">here</a></p></body></html>';
                      
                    //This should be the same as the domain of your From address
                        $mail->DKIM_domain = 'smile4kids.co.uk';
                    //See the DKIM_gen_keys.phps script for making a key pair -
                    //here we assume you've already done that.
                    //Path to your private key:
                        $mail->DKIM_private = '../mail/dkim_private.pem';
                    //Set this to your own selector
                        $mail->DKIM_selector = 'default';
                    //Put your private key's passphrase in here if it has one
                        $mail->DKIM_passphrase = '';
                    //The identity you're signing as - usually your From address
                        $mail->DKIM_identity = $mail->From;
                    //Suppress listing signed header fields in signature, defaults to true for debugging purpose
                        $mail->DKIM_copyHeaderFields = false;
                      
                      if(!$mail->Send()){
                            echo 'Message could not be sent.';
                            echo 'Mailer Error: ' . $mail->ErrorInfo;
                            $output.= 'Newsletter delivered Unsuccessfull...!';
                            exit;
                      }else{
                            //print_r($mail);
                           $output.= 'Newsletter delivered Successfully...!';
                      }
                    }
                         
                    if($output == '')
                     {
                      echo 'not';
                     }
                     else
                     {
                      echo $output;
                     }      
                }
        }else{
        echo "NO";
    }
    }

?>