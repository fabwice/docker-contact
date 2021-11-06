<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

// Load Composer's autoloader
require 'vendor/autoload.php';

function url()
{
    return sprintf(
        "%s://%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME']
    );
}

if ($_POST) {

    $name = trim(stripslashes($_POST['name']));
    $email = trim(stripslashes($_POST['email']));
    $subject = trim(stripslashes($_POST['subject']));
    $contact_message = trim(stripslashes($_POST['message']));


    if ($subject == '') {
        $subject = "Contact from " . url();
    }

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();                                          // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                           // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                                   // Enable SMTP authentication
        $mail->Username = getenv('GMAIL_USER_NAME');              // SMTP username
        $mail->Password = getenv('GMAIL_USER_PASSWORD');          // SMTP password
        $mail->SMTPSecure = 'tls';                                // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                        // TCP port to connect to

        //Recipients
        $mail->setFrom(getenv('FROM_USER_MAIL'), getenv('FROM_USER_NAME'));
        $mail->addCC(getenv('GMAIL_USER_NAME'));

        // Content
        $mail->isHTML(true);                                       // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = '<h3>' . $subject . '</h3><br><p>Message: <br />' . nl2br($contact_message) . '</p><p>Email from: ' . $name . '<br>Email address: ' . filter_var($email, FILTER_SANITIZE_EMAIL) . '</p><br /> ----- <br /> This email was sent from your site ' . url() . ' contact form. <br />';
        $mail->AltBody = nl2br($contact_message);

        $mail->send();
        echo 'OK';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

?>
