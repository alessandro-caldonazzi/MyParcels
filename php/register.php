<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';
require 'variabili.php';
require 'db.php';
session_start();

echo '<link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon" />';
if (!empty($_POST['nome'])&&!empty($_POST['email'])&&!empty($_POST['pass'])&&!empty($_POST['pass1'])&&!empty($_POST['accetto'])) {
  $accetto=$_POST['accetto'];
  if ($accetto!=1) {
  header('Location: ../html/registerht.php?errore=policy');
  exit();
  }
  $nome=filter_var($_POST['nome'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
  $email=$_POST['email'];
  $pw1=$_POST['pass'];
  $pw2=$_POST['pass1'];
  $verifica=(String)"0";
  $token= (String)mt_rand(10000000,99999999);
  echo $token;

  if($pw1==$pw2){
    filter_var($email, FILTER_SANITIZE_EMAIL);
    $emailesc=mysqli_real_escape_string($conn,$email);
    $hash = password_hash($pw1, PASSWORD_DEFAULT);

    $queryv="SELECT * from utenti where email='$emailesc'";
    $result = mysqli_query($conn,$queryv);



    if (mysqli_num_rows($result)>0){
      header('Location: ../html/registerht.php?errore=email');
      echo "L'email è gia presente. Vi preghiamo di cambiarla. Error 313";
      exit();

    }else {

        $sesso="";

        $checkf = fopen("nomif.txt", "r");
        $seqf = fgets($checkf);

        // Outputs a line of the file until
        // the end-of-file is reached
        while(! feof($checkf))
        {
          if(strcasecmp($seqf, $nome) == 0){
            $sesso="female";
          }
          $seqf = fgets($checkf);
        }

      if (strcasecmp($sesso, 'female') != 0) {
      $sesso="male";
      }


      $query= "INSERT into utenti (nome, email, passwd,verifica, token, sesso) VALUES (? ,?,?,?,?,?)";
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $query)){
                header("Location: ../html/registerht.php?error=erroresql");
                exit();
            }else {

              mysqli_stmt_bind_param($stmt, "ssssss", $nome,$email,$hash,$verifica,$token, $sesso);
              if (mysqli_stmt_execute($stmt)) {

                //imposto variabili Session
                $_SESSION['email_ver']=$email;
                $_SESSION['token_ver']=$token;
              //invio email


              $toAddress = $email; //To whom you are sending the mail.

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
              $mail->addAddress($toAddress);
              //Content
              $mail->Subject = "Verifica account My Parcels";
              $mail->Body    = 'Verifica account My Parcels';
              $mail->msgHTML(file_get_contents('file.html'));
              if (!$mail->Send()) {
                echo "Messaggio NON inviato";
               header('Location: ../html/registerht.php?error=erroresql');
               exit;

              } else {
                echo "Messaggio inviato";
                header('Location: ../html/loginht.php?registrazione=riuscita');
                exit();
              }



              }else {
                header("Location: ../html/registerht.php?error=erroresql");
                exit;
              }
            }
          }

    }else {
      header('Location: ../html/registerht.php?errore=pwd');
      echo "le due password sono diverse";
      exit;
  }

}else {
    header('Location: ../html/registerht.php?errore=data');
    echo "Mancano Alcuni Dati";
    exit;
}

?>
