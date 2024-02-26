<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'vendor/autoload.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $name = htmlspecialchars($_POST['name']);
   $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
   $phone = htmlspecialchars($_POST['phone']);
   $installation_type = htmlspecialchars($_POST['installation_type']);
   $contact_preference = htmlspecialchars($_POST['contact_preference']);
   $additional_info = htmlspecialchars($_POST['additional_info']); // New line to retrieve additional information

   if (empty($name) || empty($email) || empty($phone) || empty($installation_type) || empty($contact_preference)) {
      echo "Please fill out all required fields.";
      exit;
   }

   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo "Invalid email format.";
      exit;
   }

   $mail = new PHPMailer(true);

   try {
      $mail->isSMTP();
      $mail->Host       = 'send.one.com';
      $mail->SMTPAuth   = true;
      $mail->Username   = 'info@yktechnics.com';
      $mail->Password   = 'YKtechnics!1962';
      $mail->SMTPSecure = 'tls';
      $mail->Port       = 587;

      $mail->setFrom('info@yktechnics.com', 'Mert');
      $mail->addAddress('mertcode0@gmail.com');
      $mail->isHTML(true);
      $mail->Subject = 'Aanvraag offerte';

      $message = "Naam: $name<br>";
      $message .= "Email: $email<br>";
      $message .= "Telefoon: $phone<br>";
      $message .= "Type installatie: $installation_type<br>";
      $message .= "Contactvoorkeur: $contact_preference<br>";
      $message .= "Extra informatie: $additional_info<br>"; // New line to include additional information
      $mail->Body = $message;

      $mail->send();
      echo 'Bedankt voor uw aanvraag. We nemen zo spoedig mogelijk contact met u op.';
   } catch (Exception $e) {
      echo "Het versturen van uw aanvraag is mislukt. Probeer het later nog eens. Mailer Error: {$mail->ErrorInfo}";
   }
}
