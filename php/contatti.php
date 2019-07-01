<?php
// Check for empty fields
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';
require 'variabili.php';
echo '<link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon" />';
if(empty($_POST['nome']) || empty($_POST['email']) || empty($_POST['mex'])) {
  http_response_code(500);
  exit();
}



      $mail = new PHPMailer(true);
      $mail->SMTPDebug = 0;
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'myparcelsproject@gmail.com';
      $mail->Password = $password;
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;


      $mail->setFrom('myparcelsproject@gmail.com', 'My Parcels');
      $mail->addAddress("myparcelsproject@gmail.com");
      //Content
      $mail->Subject = "Mail da ". filter_var($_POST['nome'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
      $mail->Body    = 'Mail da '. filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); . ". Messaggio: ". filter_var($_POST['mex'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

      if (!$mail->Send()) {

       echo "Messaggio NON inviato, se vuoi contattare il supporto scrivi a myparcelsproject@gmail.com";
       header('Location: ../index.html');
       exit;

      } else {
        echo "Messaggio inviato";
        header('Location: ../index.html');
        exit();
      }

?>
