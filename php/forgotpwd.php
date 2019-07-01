<?php ob_start("ob_gzhandler"); ?>
<?php
require 'db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';
require 'variabili.php';
echo '<link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon" />';
//controllo se è presente il dato email inviato con post ( quindi inviato dalla pagina di richiesta cambio pw (forgotpwdht.php))
if(!empty($_POST['email'])){
  $email=$_POST['email'];
  $token= (String)mt_rand(10000000,99999999);
  $link="https://myparcels.it/php/forgotpwd.php?email=$email&token=$token";


  $emailesc=mysqli_real_escape_string($conn,$email);
$queryv="SELECT * from utenti where email='$emailesc'";

  if($result = mysqli_query($conn,$queryv)){
    $nrighe=mysqli_num_rows($result);


    if ($nrighe>0){

      //segnifica che la email esiste
      $query="UPDATE utenti SET token=?, usato='no' where email=?";
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $query)){
            //non è riuscito a preparare l'stmt
            echo "C'è stata una problemazione tecnica, riprovi piu tardamente. Error 250";
            header('Location: ../html/forgotpwdht.php?errore=erroresql');
            exit();

        }else {
          mysqli_stmt_bind_param($stmt, "ss", $token, $email);
          if(mysqli_stmt_execute($stmt)){
            //qui vuol dire che ho inserito correttamente il token nel database e allora invio la email all'utente
            echo "Operazione completata";
            //creo la email
            
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
          $mail->addAddress($email);
          //Content
          $mail->Subject = "Modifica password";
          $mail->Body    = "Grazie per esserti iscritto.\nClicca sul link sottostante per modificare la password:\n .".$link."\n\nA presto.";

          if (!$mail->Send()) {

            echo "Messaggio NON inviato";
            header('Location: ../html/forgotpwdht.php?errore=erroresql');
           exit;

          } else {
            echo "Messaggio inviato";
            header('Location: ../html/forgotpwdht.php?errore=mex');
            exit();
          }

        }else{
            //vuol dire che non sono riuscito ad inserire il token nel db
            echo "problema tecnico, riprova più tardi. Error 585";
            header('Location: ../html/forgotpwdht.php?errore=erroresql');
            exit();

          }
      }
    }else {
      // email non esiste
      echo "email non esiste";
      header('Location: ../html/forgotpwdht.php?errore=noemail');
      exit();
    }


}else {
  echo "non riesco a fare il resulrt";
  header('Location: ../html/forgotpwdht.php?errore=erroresql');
  exit();
}


}

//se non è presente alcun dato inviato via post controllo se l'utente proviene dal link inviato via mail per il recupero pw
if (isset($_GET['email'])&&isset($_GET['token'])&&!empty($_GET['email'])&&!empty($_GET['token'])) {
?>
  <!DOCTYPE html>
  <html lang="it">
  <head>
  	<title>Password Dimenticata My Parcels</title>
  	<meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
  	<meta name="description" content="Traccia spedizioni  ">
  	<meta name="author" content="Caldonazzi Alessandro, Foradori Giacomo">
  	<link rel="icon" type="../img/x-icon" href="../img/favicon.png" />


  <!--===============================================================================================-->
  	<link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
  <!--===============================================================================================-->
  	<link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
  <!--===============================================================================================-->
  	<link rel="stylesheet" type="text/css" href="../vendor/animate/animate.css">
  <!--===============================================================================================-->
  	<link rel="stylesheet" type="text/css" href="../vendor/css-hamburgers/hamburgers.min.css">
  <!--===============================================================================================-->
  	<link rel="stylesheet" type="text/css" href="../vendor/select2/select2.min.css">
  <!--===============================================================================================-->
  	<link rel="stylesheet" type="text/css" href="../css/util.css">
  	<link rel="stylesheet" type="text/css" href="../css/main.css">
  <!--===============================================================================================-->
  </head>
  <body>

  	<div class="limiter">
  		<div class="container-login100">
  			<div class="wrap-login100">
  				<div class="login100-pic js-tilt" data-tilt>
  					<img src="../img/profile.png" alt="My Parcels">
  				</div>

  				<form class="login100-form validate-form" action="#" method="post">
  					<span class="login100-form-title">
  						Password Dimenticata
  					</span>

  					<div class="wrap-input100 validate-input" data-validate = "Inserisci una password">
  						<input class="input100" type="password" name="pw1" placeholder="Password">
  						<span class="focus-input100"></span>
  						<span class="symbol-input100">
  							<i class="fa fa-lock" aria-hidden="true"></i>
  						</span>
  					</div>
            <div class="wrap-input100 validate-input" data-validate = "Inserisci una password">
  						<input class="input100" type="password" name="pw2" placeholder="Ripeti Password">
  						<span class="focus-input100"></span>
  						<span class="symbol-input100">
  							<i class="fa fa-lock" aria-hidden="true"></i>
  						</span>
  					</div>

  					<div class="container-login100-form-btn">
  						<button class="login100-form-btn" type="submit">
  							Recupera Password
  						</button>
  					</div>

  					<div class="text-center p-t-12">
  						<span class="txt1">
  							Ritorna al
  						</span>
  						<a class="txt2" href="../html/loginht.php">
  							Login
  						</a>
  					</div>

  					<div class="text-center p-t-136">
  						<a class="txt2" href="../registerht.php">
  							Crea il tuo account
  							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
  						</a>
  					</div>
  				</form>
  			</div>
  		</div>
  	</div>




  <!--===============================================================================================-->
  	<script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
  <!--===============================================================================================-->
  	<script src="../vendor/bootstrap/js/popper.js"></script>
  	<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
  <!--===============================================================================================-->
  	<script src="../vendor/select2/select2.min.js"></script>
  <!--===============================================================================================-->
  	<script src="../vendor/tilt/tilt.jquery.min.js"></script>
  	<script >
  		$('.js-tilt').tilt({
  			scale: 1.1
  		})
  	</script>
  <!--===============================================================================================-->
  	<script src="../js/main.js"></script>

  </body>
  </html>
<?php
}

if (!empty($_POST['pw1'])&&!empty($_POST['pw2'])) {

  // vuol dire che l'utente è qui dopo aver inserito i dati nel form sceglio quindi la nuova password

  $pw1=$_POST['pw1'];
  $pw2=$_POST['pw2'];
  $token=$_GET['token'];
  $email=$_GET['email'];
if ($pw1==$pw2) {
  $hash = password_hash($pw1, PASSWORD_DEFAULT);
  $query="SELECT * from utenti where email=?";
  $stmt=mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $query)){
    echo "C'è stata una problemazione tecnica, riprovi piu tardamente. Error 526";
    exit();

  }else{
    mysqli_stmt_bind_param($stmt, "s",$email);


    if (mysqli_stmt_execute($stmt)) {
      $risultato = mysqli_stmt_get_result($stmt);
      $riga=mysqli_fetch_assoc($risultato);
      if($token==$riga['token']){
        //vuol dire che il token è il suo e puo procedere
        if ($riga['usato']!="si") {
          //token esiste, associato ad utente corretto e non usato
          $query1="UPDATE utenti SET passwd=?, usato='no' where token=?";

          $stmt1=mysqli_stmt_init($conn);
          if(!mysqli_stmt_prepare($stmt1, $query1)){
            echo "C'è stata una problemazione tecnica, riprovi piu tardamente. Error 526";
            exit();

          }else{
            mysqli_stmt_bind_param($stmt1, "ss", $hash,$token);


            if (mysqli_stmt_execute($stmt1)) {
              echo "Operazione completata con successo, password modificata";
              header('Location: ../html/loginht.php?errore=pwmod');
              exit();
            }else {
              echo "problema tecnico riprova più tardi. Error 736";
              exit();
            }
          }
        }else {
          echo "token gia utilizzato";
        }
      }else {
        echo "token non valido";
      }

    }else {
      echo "problema tecnico riprova più tardi. Error 736";
      exit();
    }

}

}else {
  echo "password diverse";
}
}
?>
