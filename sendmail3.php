<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $name = $_POST['name3'];
   $email = filter_var($_POST['email3'], FILTER_SANITIZE_EMAIL);
   $phone = $_POST['phone3'];
   $installation_type = $_POST['installation_type3'];
   $contact_preference = $_POST['contact_preference3'];
   $additional_info = $_POST['additional_info3']; // No sanitization for additional info

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
      $mail->Username   = $_ENV['SMTP_USERNAME'];
      $mail->Password   = $_ENV['SMTP_PASSWORD'];
      $mail->SMTPSecure = 'tls';
      $mail->Port       = 587;

      $mail->setFrom('info@yktechnics.com', 'YK Technics');
      $mail->addAddress('offerte@yktechnics.com'); // Send to testmail until one fixed
      $mail->isHTML(true);
      $mail->Subject = 'Aanvraag offerte via Website';

      $message = '<html>
               <head>
                  <style>
                        /* Stijl voor de tabel */
                        table {
                           border-collapse: collapse;
                           width: 100%;
                        }
                        
                        /* Stijl voor de tabelcellen */
                        th, td {
                           border: 1px solid #dddddd;
                           text-align: left;
                           padding: 8px;
                        }
                        
                        /* Stijl voor de eerste kolom (headers) */
                        th {
                           background-color: #f2f2f2;
                        }
                  </style>
               </head>
               <body>
                  <h2>Aanvraag Offerte Details</h2>
                  <table>
                        <tr>
                           <th>Onderwerp</th>
                           <td>Offerte aanvraag</td>
                        </tr>
                        <tr>
                           <th>Naam</th>
                           <td>' . $name . '</td>
                        </tr>
                        <tr>
                           <th>Email</th>
                           <td>' . $email . '</td>
                        </tr>
                        <tr>
                           <th>Telefoon</th>
                           <td>' . $phone . '</td>
                        </tr>
                        <tr>
                           <th>Type installatie</th>
                           <td>' . $installation_type . '</td>
                        </tr>
                        <tr>
                           <th>Contactvoorkeur</th>
                           <td>' . $contact_preference . '</td>
                        </tr>
                        <tr>
                           <th>Extra informatie</th>
                           <td>' . $additional_info . '</td>
                        </tr>
                  </table>
               </body>
            </html>';
      $mail->Body = $message;


      $mail->send();
      var_dump($message);

      echo 'Bedankt voor uw aanvraag. We nemen zo spoedig mogelijk contact met u op.';
   } catch (Exception $e) {
      echo "Het versturen van uw aanvraag is mislukt. Probeer het later nog eens. Mailer Error: {$mail->ErrorInfo}";
   }
}
