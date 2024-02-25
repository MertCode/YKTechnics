<?php
// Include PHPMailer classes at the top 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require_once 'vendor/autoload.php';

// Display errors for debugging (remove in production) 
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // Form Data and Validation
   $name = htmlspecialchars($_POST['name']);
   $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
   $phone = htmlspecialchars($_POST['phone']);
   $installation_type = htmlspecialchars($_POST['installation_type']);
   $contact_preference = htmlspecialchars($_POST['contact_preference']);

   // Basic validation
   if (empty($name) || empty($email) || empty($phone) || empty($installation_type) || empty($contact_preference)) {
      echo "Please fill out all required fields.";
      exit;
   }

   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo "Invalid email format.";
      exit;
   }

   // SMTP Configuration (Replace with your mail service details)
   $mail = new PHPMailer(true);

   try {
      $mail->isSMTP();
      $mail->Host       = 'send.one.com';
      $mail->SMTPAuth   = true;
      $mail->Username   = 'info@yktechnics.com';
      $mail->Password   = 'YKtechnics!1962';
      $mail->SMTPSecure = 'tls';
      $mail->Port       = 587;

      $mail->setFrom($_POST['email'], $_POST['name']);
      $mail->addAddress('mertsozen77@gmail.com'); // This is the recipient's email address
      $mail->isHTML(true);
      $mail->Subject = 'Aanvraag Offerte via Website';

      // Build message body
      $message = "Naam: $name<br>";
      $message .= "Email: $email<br>";
      $message .= "Telefoon: $phone<br>";
      $message .= "Type installatie: $installation_type<br>";
      $message .= "Contactvoorkeur: $contact_preference<br>";
      $mail->Body = $message;

      // Send the email
      $mail->send();
      echo 'Bedankt voor uw aanvraag. We nemen zo spoedig mogelijk contact met u op.';
   } catch (Exception $e) {
      echo "Het versturen van uw aanvraag is mislukt. Probeer het later nog eens. Mailer Error: {$mail->ErrorInfo}";
   }
}
