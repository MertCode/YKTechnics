<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $name = $_POST['name'];
   $email = $_POST['email'];
   $phone = $_POST['phone'];
   $installation_type = $_POST['installation_type'];
   $contact_preference = $_POST['contact_preference'];

   $to = "mertcode0@gmail.com"; // Enter your email address here
   $subject = "Aanvraag offerte";
   $message = "Naam: $name\n";
   $message .= "Email: $email\n";
   $message .= "Telefoon: $phone\n";
   $message .= "Type installatie: $installation_type\n";
   $message .= "Contactvoorkeur: $contact_preference\n";

   $headers = "From: $email";

   if (mail($to, $subject, $message, $headers)) {
      echo "Bedankt voor uw aanvraag. We nemen zo spoedig mogelijk contact met u op.";
   } else {
      echo "Er is een probleem opgetreden bij het verzenden van uw aanvraag. Probeer het later opnieuw.";
   }
}
