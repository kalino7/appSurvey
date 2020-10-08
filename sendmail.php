<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


// require 'path/to/PHPMailer/src/Exception.php';
require 'PHPMailer101/src/Exception.php';
require 'PHPMailer101/src/PHPMailer.php';
require 'PHPMailer101/src/SMTP.php';


function SenderZesk($key, $email, $fullname){

  // Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.mailtrap.io';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = '28da9bd830c6d2';                     // SMTP username
    $mail->Password   = '2885225b2956bb';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('AppSurvey@example.com', 'App Survey');
    $mail->addAddress($email, $fullname);     // Add a recipient
    // $mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    // Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Activation Link';
    $mail->Body    = '<p>Click On The Link Below To Activate Your Account</p> <a href="http://localhost/appSurvey/welcome.php?keys='.$key.'">Click Here</a>';
    $mail->AltBody = 'Copy and Paste This Link In The Url of Your Browser To Activate Your Account -> "http://localhost/appSurvey/welcome.php?keys='.$key.'"';

    $mail->send();
    //echo 'Message has Delivered';
    return true;
} catch (Exception $e) {
   // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    return false;
}

}



//survey link
function SenderToken($token, $email, $fullname){
    
      // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);
    
    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.mailtrap.io';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = '28da9bd830c6d2';                     // SMTP username
        $mail->Password   = '2885225b2956bb';                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    
        //Recipients
        $mail->setFrom('AppSurvey@example.com', 'App Survey');
        $mail->addAddress($email, $fullname);     // Add a recipient
        $mail->addReplyTo('info@example.com', 'Information');
    
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Chosen For Survey Question';
        $mail->Body    = '<p>Dear Sir/Madam</p>
        <p>You Have Been Selected For This Survey Session, Please Click On The Link Below To Access The Survey Page</p> 
        <p>Please This Token Expires In An Hour Time, Hence Advised To Make Use Of It While The Link Is Still Available And The Survey Session Open.</p>
        <a href="http://localhost/appSurvey/lock.php?tok='.$token.'">Click Here</a>';
        $mail->AltBody = 'Copy and Paste This Link In The Url of Your Browser To Access Page -> "http://localhost/appSurvey/lock.php?tok='.$token.'"';
    
        $mail->send();
        //echo 'Message has Delivered';
        return true;
    } catch (Exception $e) {
       // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
    
    }


    function SenderReset($token, $email){
        
          // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);
        
        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.mailtrap.io';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = '28da9bd830c6d2';                     // SMTP username
            $mail->Password   = '2885225b2956bb';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        
            //Recipients
            $mail->setFrom('AppSurvey@example.com', 'App Survey');
            $mail->addAddress($email);     // Add a recipient
            $mail->addReplyTo('info@example.com', 'Information');
            
            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Password Reset Token';
            $mail->Body    = '<p>Dear Customer, </p>
            <p>Your Password Reset Request Was Successful. Click On The Link Below To Reset Your Account Password</p> 
            <p>Please This Token Expires In An Hour Time, Hence Advised To Make Use Of It While The Link Is Active.</p>
            <a href="http://localhost/appSurvey/reset.php?tok='.$token.'">Click Here</a>';
            $mail->AltBody = 'Copy and Paste This Link In The Url of Your Browser To Reset Your Password -> "http://localhost/appSurvey/reset.php?tok='.$token.'"';
        
            $mail->send();
            //echo 'Message has Delivered';
            return true;
        } catch (Exception $e) {
           // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
        
        }

?>