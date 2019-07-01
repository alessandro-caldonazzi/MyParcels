<?php
//starto sessione
require 'db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';
require 'variabili.php';
echo '<link rel="icon" type="x-icon" href="../img/favicon.png" />';

header('Content-Type: text/html; charset=utf-8');

  session_start();
  //controllo se l'utente è loggato
  if(!isset($_SESSION['id'])||!isset($_SESSION['nome'])||empty($_SESSION['id'])||empty($_SESSION['nome'])){
    //se l'utente non è loggato e lo rimando al login per loggare
    header('Location: ../html/loginht.php');
  }
  if (isset($_GET['errore'])&&!empty($_GET['errore'])) {
		if($_GET['errore']=="doppio"){
			$errore="La spedizione che hai provato ad aggiungere è gia presente nel tuo profilo.";
		}else if($_GET['errore']=="erroresql"){
      $errore="C'è stato un problema con le nostre infrastrutture";
    }else if($_GET['errore']=="track"){
      $errore="ATTENZIONE: Il tuo codice di tracking è molto strano, ricorda che la sua lunghezza va da 5 a 50 caratteri e non contiene caratteri speciali.";
    }else if($_GET['errore']=="dati"){
      $errore="ATTENZIONE: Mancano dei dati.";
    }else if($_GET['errore']=="nome"){
      $errore="ATTENZIONE: Il tuo codice di nome della spedizione non va bene, ricorda che la sua lunghezza va da 3 a 20 caratteri e non contiene caratteri speciali. CONSIGLIO: Preferisci il nome Televisione anzichè TV.";
    }else if($_GET['errore']=="nomeerr"){
      $errore="ATTENZIONE: Il tuo nome non va bene, ricorda che la sua lunghezza va da 2 a 50 caratteri e non contiene caratteri speciali.";
    }else if($_GET['errore']=="errorepwd"){
      $errore="ATTENZIONE: Le password inserite non coincidono";
    }



	}

  if(isset($_POST['track'])&&!empty($_POST['track'])&&isset($_POST['nome'])&&!empty($_POST['nome'])){
    //se l'utente sta aggiungendo una spedizione

    $track=$_POST['track'];
    $id=$_SESSION['id'];
    $email=$_SESSION['email'];
    $nomespedizione=$_POST['nome'];
    $ladata=date('Y-m-d');
    if(strlen($track)<5||strlen($track)>50||preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $track)){
      header('Location: dashboard.php?errore=track');
      exit();
    }else if(strlen($nomespedizione)<3||strlen($nomespedizione)>20||preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $nomespedizione)){
      header('Location: dashboard.php?errore=nome');
      exit();
    }else{
    $emailesc=mysqli_real_escape_string($conn,$email);
    $trackesc=mysqli_real_escape_string($conn,$track);
    $queryv="SELECT * from spedizioni where track='$trackesc' AND email='$emailesc'";

    if($result = mysqli_query($conn,$queryv)){
      $nrighe=mysqli_num_rows($result);


      if ($nrighe>0){
          //significa che il codice di spedizione è gia stato inserito nel database legata a questo utente

            header('Location: dashboard.php?errore=doppio');
            exit();

      }else {
        // nuovo codice Tracking
        $query= "INSERT into spedizioni (nome,track, email,aggiunta) VALUES (?,? ,?,?)";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $query)){
                  header("Location: dashboard.php?error=erroresql");
                  exit();
              }else {

                mysqli_stmt_bind_param($stmt, "ssss", $nomespedizione,$track,$email,$ladata);

                if (mysqli_stmt_execute($stmt)) {

                    header("Location: dashboard.php");

                }else {
                  // non sono riuscito ad eseguire l'stmt
                  header("Location: dashboard.php?error=erroresql");
                  exit();

                }
              }

      }
    }
  }

}
if (isset($_GET['elimina'])&&!empty($_GET['elimina'])&&isset($_GET['si'])&&!empty($_GET['si'])) {
  // codice per eliminare Spedizione
  $queryrm= "DELETE from spedizioni WHERE track=? AND email=?";
  $stmtrm = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmtrm, $queryrm)){
            header("Location: dashboard.php?error=erroresql");
            exit();
        }else {

          mysqli_stmt_bind_param($stmtrm, "ss", $_GET['elimina'],$_SESSION['email']);

          if (mysqli_stmt_execute($stmtrm)) {

              header("Location: dashboard.php");

          }else {
            // non sono riuscito ad eseguire l'stmt
            header("Location: dashboard.php?errore=erroresql");
            exit();

          }
        }

}
if (!isset($_SESSION['sesso'])||empty($_SESSION['sesso'])) {

  // sigifica che non so di che sesso è l'utente
  $email=mysqli_real_escape_string($conn,$_SESSION['email']);

  $querysess="SELECT * from utenti where email='$email'";

  if($resultss = mysqli_query($conn,$querysess)){

    $rowss = mysqli_fetch_array($resultss, MYSQLI_ASSOC);
    $_SESSION['sesso']=$rowss['sesso'];
    header("Refresh:0");


  }




}
if (isset($_GET['no'])||!empty($_GET['no'])) {

  // sigifica che l'utente dice di non aver ricevuto il pacco con possibile consegna
  $_SESSION['consegna']="no";
  header("Location: dashboard.php");



}
if (isset($_POST['nomenuovo'])||!empty($_POST['nomenuovo'])) {

  // sigifica che l'utente ha inserito il suo nuovo nome
  if(strlen($_POST['nomenuovo'])<2||strlen($_POST['nomenuovo'])>50||preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $_POST['nomenuovo'])){
    header('Location: dashboard.php?errore=nomeerr');
    exit();
  }
  $querynome= "UPDATE utenti SET nome=? WHERE email=?";
  $stmtnome = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmtnome, $querynome)){
            header("Location: dashboard.php?error=erroresql");
            exit();
        }else {

          mysqli_stmt_bind_param($stmtnome, "ss", $_POST['nomenuovo'], $_SESSION['email']);

          if (mysqli_stmt_execute($stmtnome)) {

              $_SESSION['nome']=$_POST['nomenuovo'];
              header("Location: dashboard.php");
              exit();

          }else {
            // non sono riuscito ad eseguire l'stmt
            header("Location: dashboard.php?errore=erroresql");
            exit();

          }
        }



}

if (isset($_POST['pwd'])||!empty($_POST['pwd'])||isset($_POST['pwd2'])||!empty($_POST['pwd2'])) {

  // sigifica che l'utente ha inserito la sua nuova password
  $pwd=$_POST['pwd'];
  $pwd2=$_POST['pwd2'];
  if($pwd==$pwd2){
    $hash = password_hash($pwd, PASSWORD_DEFAULT);
    $querypwd= "UPDATE utenti SET passwd=? WHERE email=?";
    $stmtpwd = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmtpwd, $querypwd)){
              header("Location: dashboard.php?error=erroresql");
              exit();
          }else {

            mysqli_stmt_bind_param($stmtpwd, "ss", $hash, $_SESSION['email']);

            if (mysqli_stmt_execute($stmtpwd)) {

              
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
                $mail->addAddress($_SESSION['email']);
                //Content
                $mail->Subject = "Cambiata Password Account My Parcels";
                $mail->Body    = "Ti confermiamo che la tua password è stata modificata con succeso, se non riconsci questa attività, contatta immediatamente il supporto tecnico";

                if (!$mail->Send()) {

                 echo "Messaggio NON inviato, se vuoi contattare il supporto scrivi a myparcelsproject@gmail.com";
                 header("Location: dashboard.php");
                 exit();

                } else {
                  echo "Messaggio inviato";
                  header("Location: dashboard.php");
                  exit();
                }


            }else {
              // non sono riuscito ad eseguire l'stmt
              header("Location: dashboard.php?errore=erroresql");
              exit();

            }
          }
  }else {
    header("Location: dashboard.php?errore=errorepwd");
    exit();
  }




}
if(isset($_GET['notifiche'])&&!empty($_GET['notifiche'])){
  if($_GET['notifiche']=="on"){
    $testo_notifiche="Stai per attivare le notifiche, riceverai via email tutte le novità delle tue spedizioni";
  }else{
    $testo_notifiche="Stai per disattivare le notifiche, non riceverai più notizie via email.";
  }

}
if(isset($_GET['cambionotifiche'])&&!empty($_GET['cambionotifiche'])){
  $mail_x_notifiche=mysqli_real_escape_string($conn,$_SESSION['email']);
  if($_GET['cambionotifiche']=="on"||$_GET['cambionotifiche']=="off"){
    $cambio_notifiche=$_GET['cambionotifiche'];
      $query_cambionot="UPDATE utenti SET notifiche='$cambio_notifiche' where email='$mail_x_notifiche'";
      if($result_x_notifiche = mysqli_query($conn,$query_cambionot)){
        header("Location: dashboard.php");
        exit();
      }else{
        //errore
        header("Location: dashboard.php?errore=erroresql");
        exit();
      }


  }else{
    //velore non valido
    header("Location: dashboard.php?errore=erroresql");
    exit();
  }

}
  //eseguo sempre il recupero delle spedizioni dell'Utente
  mysqli_query($conn,"SET NAMES utf8;");
  $mail=mysqli_real_escape_string($conn,$_SESSION['email']);

  $queryv="SELECT * from spedizioni where email='$mail'";

  if($result = mysqli_query($conn,$queryv)){
    $nrighe=mysqli_num_rows($result);

    $dati =array();
      if ($nrighe>0){
          //significa che l'utente ha almeno una Spedizione
          while ($row = mysqli_fetch_assoc($result)) {
        $dati[]=$row;


      }


      }
    }
    $query_not="SELECT notifiche from utenti where email='$mail'";

    if($result_notifiche = mysqli_query($conn,$query_not)){
      $notifiche = mysqli_fetch_assoc($result_notifiche);
    }


    if(!isset($_SESSION['consegna'])||empty($_SESSION['consegna'])){
    $comp=0; //variabile che contiene il numero delle spedizioni complete.
    $posiz=-1;//posizione nell'array dati della prima spedizione consegnata
    for ($k=0; $k < $nrighe; $k++) {
      // controllo se ci sono delle spedizioni forse consegnate
      if ($dati[$k]['completo']=="forse") {
        $comp++;
      }
    }
    if($comp>0){
      //ci sono delle spedizioni forse consegnate.
      $j=0;
      while ($posiz==-1) {

        if ($dati[$j]['completo']=="forse") {
          $posiz=$j;
        }
        $j++;
      }
      $completo=$posiz;

    }


  }
  if (isset($_GET['track'])&&!empty($_GET['track'])&&isset($_GET['pos'])) {
    // controllo se l'utente ha cliccato su espandi di una delle card
    $track=$_GET['track'];
    for ($a=0; $a <$nrighe ; $a++) {
      // controllo se il tracking code è valido

      if($track==$dati[$a]['track']){
        //la spedizione è stata trovata
        $trackspedizione=$track;
        $pos=$_GET['pos'];

      }



    }

  }
  if (isset($_GET['profilazione'])&&!empty($_GET['profilazione'])) {
    // eliminazione utente
    $emailelimina=mysqli_real_escape_string($conn,$_SESSION['email']);

    $queryvv="DELETE from spedizioni where email= '$emailelimina'";

    if($resultcontrelim = mysqli_query($conn,$queryvv)){
      $queryvvelim="DELETE from utenti where email= '$emailelimina'";

      if($resultcontrelim2 = mysqli_query($conn,$queryvvelim)){
        header("Location: ../index.html");
        exit();

      }else {
        header("Location: dashboard.php?errore=erroresql");
        exit();
      }

    }else {
      header("Location: dashboard.php?errore=erroresql");
      exit();
    }


  }
  if(isset($_GET['consegnato'])&&!empty($_GET['consegnato'])){

    $emailconsegnato=mysqli_real_escape_string($conn,$_SESSION['email']);
    $trackingcode=mysqli_real_escape_string($conn,$_GET['consegnato']);
    $queryvv="SELECT * from spedizioni where email= '$emailconsegnato'AND track='$trackingcode'";

    if($resultcontr = mysqli_query($conn,$queryvv)){
      $numerorighe=mysqli_num_rows($resultcontr);
      if($numerorighe>0){
        $querycon= "UPDATE spedizioni SET completo='si' WHERE track=?";
        $stmtcon = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmtcon, $querycon)){
                  header("Location: dashboard.php?error=erroresql");
                  exit();
              }else {

                mysqli_stmt_bind_param($stmtcon, "s", $_GET['consegnato']);

                if (mysqli_stmt_execute($stmtcon)) {

                    header("Location: dashboard.php");

                }else {
                  // non sono riuscito ad eseguire l'stmt
                  header("Location: dashboard.php?errore=erroresql");
                  exit();

                }
              }
      }
    }

  }
  if(isset($_GET['noconsegnato'])&&!empty($_GET['noconsegnato'])){

    $emailconsegnato=mysqli_real_escape_string($conn,$_SESSION['email']);
    $trackingcode=mysqli_real_escape_string($conn,$_GET['noconsegnato']);
    $queryvv="SELECT * from spedizioni where email= '$emailconsegnato'AND track='$trackingcode'";

    if($resultcontr = mysqli_query($conn,$queryvv)){
      $numerorighe=mysqli_num_rows($resultcontr);
      if($numerorighe>0){
        $querycon= "UPDATE spedizioni SET completo='no' WHERE track=?";
        $stmtcon = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmtcon, $querycon)){
                  header("Location: dashboard.php?error=erroresql");
                  exit();
              }else {

                mysqli_stmt_bind_param($stmtcon, "s", $_GET['noconsegnato']);

                if (mysqli_stmt_execute($stmtcon)) {

                    header("Location: dashboard.php");

                }else {
                  // non sono riuscito ad eseguire l'stmt
                  header("Location: dashboard.php?errore=erroresql");
                  exit();

                }
              }
      }
    }

  }
 ?>
<!DOCTYPE html>
<html lang="it">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Traccia spedizioni  ">
  <meta name="author" content="Caldonazzi Alessandro, Foradori Giacomo">
  <meta charset="UTF-8">


  <title>My Parcels</title>

  <!-- Bootstrap core CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../fonts/montserrat/400-700.css" rel="stylesheet" type="text/css">
  <link href="../fonts/montserrat/italic.css" rel="stylesheet" type="text/css">

  <!-- Plugin CSS -->
  <link href="../vendor/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template -->
  <link href="../css/freelancer.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../css/organicfoodicons.css" />
	<!-- demo styles -->
	<link rel="stylesheet" type="text/css" href="../css/demo.css" />

<link rel="stylesheet" type="text/css" href="../css/test.css" />
	<!-- menu styles -->
	<link rel="stylesheet" type="text/css" href="../css/component.css" />
	<script src="../js/modernizr-custom.js"></script>
  <style>
  table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
  }

  td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
  }

  tr:nth-child(even) {
    background-color: #dddddd;
  }
  </style>
</head>

<body id="page-top">

  <!-- Navigation -->
  <div class="container">
		<!-- Blueprint header -->
		<header class="bp-header cf">
			<div class="dummy-logo">

				<h2 class="dummy-heading">My Parcels</h2>

			</div>

			<div class="bp-header__main text-right">
				<h1 class="bp-header__present" >My Parcels</h1>
				<h1 class="bp-header__title" style="color: #e5e5e5;">Le tue spedizioni</h1>
        <h1 class="bp-header__title" style="color: #e5e5e5; font-size:15px">Spedizioni Attive: <?php echo $nrighe; ?></h1>

        <nav class="bp-nav">
    <div class="text-right">
      <button type="button" data-toggle="modal" data-target="#exampleModalLong" class="btn btn-outline-success btn-circle btn-grande  "><i class="fa fa-plus "></i>
      </button>
      <br>
      <br>

    </div>

        </nav>
			</div>
		</header>
		<button class="action action--open" aria-label="Open Menu"><span class="icon icon--menu"></span></button>
		<nav id="ml-menu" class="menu text-center">
			<button class="action action--close" aria-label="Close Menu"><span class="icon icon--cross"></span></button>

      <img src="<?php if ($_SESSION['sesso']=="male") {
        echo "../img/man.png";
      }else {
        echo "../img/girl.png";
      } ?>" alt="Avatar" style="width: 170px; height: 170px; margin-top: 14px;" >
      <br>
      <br>
      <h3><a href="dashboard.php?cambia=nome"><?php echo $_SESSION['nome']; ?></a></h3>

      <br>
      <br>
      <h5><img src="../img/notifica.png" style="width: 20px;"><a href="dashboard.php?notifiche=<?php if($notifiche['notifiche']=="off"){
                                                            echo "on";}else{ echo "off";}
       ?>"><?php if($notifiche['notifiche']=="off"){
                                                            echo " Attiva notifiche ";}else{ echo " Disattiva notifiche ";}
       ?></a><img src="../img/notifica.png" style="width: 20px;"></h5>
      <br>
      <br>


      <h5><img src="../img/lock.png" style="width: 20px;"><a href="dashboard.php?modifica=pw">Cambia Password</a><img src="../img/lock.png" style="width: 20px;"></h5>
      <br>
      <h5><img src="../img/delete.png" style="width: 20px;"><a href="dashboard.php?profilo=elimina">Elimina account</a><img src="../img/delete.png" style="width: 20px;"></h5>

    <br>
      <h5><img src="../img/enter.png" style="width: 20px;"><a href="logout.php">  Logout  </a><img src="../img/enter.png" style="width: 20px;"></h5>

		</nav>
<div class="content">




      <div class="row text-center carte">
        <?php for ($i=0; $i <$nrighe ; $i++) { ?>
          <div class="col-sm-5 col-md-4 col-lg-5 col-xl-4">
            <div class="z-depth-4 card bg-light mb-3" style="max-width: 18rem;">
              <div class="card-header"style="height: 60px;">

                <?php if ($dati[$i]['completo']=="si") {
                  echo '<img src="../img/spunta.png" style="width: 35px; height:auto;" alt="completato">';
                } ?>
              Spedizione <button type="button" onclick="location.href='dashboard.php?elimina=<?php echo $dati[$i]['track'] ?>';" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              </div>
              <div class="card-body">

                <h5 class="card-title"><?php echo $dati[$i]['nome'];?></h5>

                <p class="card-text">STATO: <?php echo $dati[$i]['stato']; ?><br> CORRIERE: <?php echo  $dati[$i]['corriere'];?> </p>
                <a href="dashboard.php?track=<?php echo  $dati[$i]['track'];?>&pos=<?php echo $i; ?>" class="btn btn-outline-success ">Espandi</a>
              </div>
            </div>
          </div>
      <?php   } ?>



      </div>
</div>
	</div>

    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Aggiungi Spedizione</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="dashboard.php" method="post">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Inserisci Nome Spedizione:</label>
            <input type="text" name="nome" placeholder="Nome Spedizione" class="form-control">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Inserisci Codice Tracking:</label>
            <input type="text" name="track" placeholder="Tracking Code" class="form-control">
          </div>
          <div class="text-center">
            <button  class="btn btn-primary" type="submit">Aggiungi</button>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>

      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Errore</h5>
        <button type="button" class="close" onclick="location.href='dashboard.php';" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo $errore; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="location.href='dashboard.php';" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="Sicuro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Sei sicuro</h5>
        <button type="button" class="close"onclick="location.href='dashboard.php';" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Attenzione: operazione irreversibili, cliccando elimina, questa spedizione verrà completamente rimossa dalle nostre infrestrutture.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="location.href='dashboard.php?elimina=<?php echo $_GET['elimina'] ?>&si=1';" data-dismiss="modal">Elimina</button>
        <button type="button" class="btn btn-primary" onclick="location.href='dashboard.php';" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="Possibile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Consegato</h5>
        <button type="button" class="close"onclick="location.href='dashboard.php?no=consegna';" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Il nostro sistema ha individuato la possibile consegna della spedizione - <?php echo $dati[$completo]['nome']; ?> -. Confermi di avere ricevuto il tuo pacco?
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="location.href='dashboard.php?consegnato=<?php echo $dati[$completo]['track']; ?>';" data-dismiss="modal">Si</button>
        <button type="button" class="btn btn-primary" onclick="location.href='dashboard.php?no=consegna';" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="Consegnato" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Consegato</h5>
        <button type="button" class="close"onclick="location.href='dashboard.php';" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Sei sicuro di voler contrassegnare come consegnato questa spedizione? Cliccando sul pulsante -si- la spedizione rimarrà nei nostri sistemi, ma non verrà più aggiornato.
          </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="location.href='dashboard.php?consegnato=<?php echo $_GET['track']; ?>';" data-dismiss="modal">Si</button>
        <button type="button" class="btn btn-primary" onclick="location.href='dashboard.php';" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="Notifiche" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Notifiche</h5>
        <button type="button" class="close"onclick="location.href='dashboard.php';" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo $testo_notifiche ;?>
          </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="location.href='dashboard.php?cambionotifiche=<?php echo $_GET['notifiche']; ?>';" data-dismiss="modal">Si</button>
        <button type="button" class="btn btn-primary" onclick="location.href='dashboard.php';" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="noConsegnato" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Consegato</h5>
        <button type="button" class="close"onclick="location.href='dashboard.php';" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Stai per segnalare questa spedizione come non consegnata, cliccando -si-, il nostro sistema comincerà a cercare nuovi aggiornamenti della spedizione.
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="location.href='dashboard.php?noconsegnato=<?php echo $_GET['track']; ?>';" data-dismiss="modal">Si</button>
        <button type="button" class="btn btn-primary" onclick="location.href='dashboard.php';" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="eliminaprof" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Elimina Profilo</h5>
        <button type="button" class="close"onclick="location.href='dashboard.php';" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Stai per eliminare completamente il tuo profilo e tutte le tue spedizioni dai nostri sistemi, l'operazione è irreversibile. Ciò significa che dopo aver premuto il pulsante -si-, tutti i tuoi dati verranno cancellati e se vorrai, dovrai creare un nuovo profilo.
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="location.href='dashboard.php?profilazione=eliminazione';" data-dismiss="modal">Si</button>
        <button type="button" class="btn btn-primary" onclick="location.href='dashboard.php';" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="Cambia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cambia Nome</h5>
        <button type="button" class="close"onclick="location.href='dashboard.php';" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="dashboard.php" method="post">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Inserisci il tuo nuovo Nome:</label>
            <input type="text" name="nomenuovo" placeholder="Nome" class="form-control">
          </div>

          <div class="text-center">
            <button  class="btn btn-primary" type="submit">Cambia</button>
          </div>

        </form>
      </div>

      <div class="modal-footer">
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="Pwd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cambia Password</h5>
        <button type="button" class="close"onclick="location.href='dashboard.php';" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="dashboard.php" method="post">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Inserisci la tua password:</label>
            <input type="password" name="pwd" placeholder="Password" class="form-control">
            <label for="recipient-name" class="col-form-label">Conferma password:</label>
            <input type="password" name="pwd2" placeholder="Password" class="form-control">
          </div>

          <div class="text-center">
            <button  class="btn btn-primary" type="submit">Cambia</button>
          </div>

        </form>
      </div>

      <div class="modal-footer">
        </div>
    </div>
  </div>
</div>
<div class="modal fade bd-example-modal-lg" id="Spedizione" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Spedizione n: <?php echo $trackspedizione; ?></h5>
        <button type="button" class="close"onclick="location.href='dashboard.php';" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


            <?php
            $stato=$dati[$pos]['stato'];
            $ultima=$dati[$pos]['ultima'];
            $corriere=$dati[$pos]['corriere'];
            $completospedizione=$dati[$pos]['completo'];
            echo "<p><b>Stato= </b>$stato  <b>Ultima= </b>$ultima  <b>Corriere= </b>$corriere </p>";
            $totale=array();
            $contatore=0;
            $string = $dati[$pos]['totale'];
             $token = strtok($string, "-");

            while ($token !== false)
               {
               $totale[$contatore]=$token;
               $token = strtok("-");
               $contatore++;
               }
                $totaledata=array();
              $contatore=0;
               $stringa = $dati[$pos]['data'];
                $tokena = strtok($stringa, "/");

               while ($tokena !== false)
                  {
                  $totaledata[$contatore]=$tokena;
                  $tokena = strtok("/");
                  $contatore++;
                  }
                  $lungtot=sizeof($totale);
                  $lungdata=sizeof($totaledata);
                  echo '<table>
                    <tr>
                      <th>Data</th>
                      <th>Luogo</th>
                    </tr>';
               for ($nn=0; $nn <$lungtot ; $nn++) {
                 echo '<tr>
                          <td>'. $totaledata[$nn] .'</td>
                          <td>'. $totale[$nn] .'</td>
                          </tr>';
               }
               echo '</table>';


?>



      </div>

      <div class="modal-footer">
        <?php if($completospedizione=="si") {
          $uguale="si";
          echo '<div class="mr-3">Pacco consegnato?</div>';
          $location='dashboard.php?nuovost=noconsegnato&track='.$dati[$pos]['track'];
        }else{
          echo '<div class="mr-3">Pacco consegnato?</div>';
          $location='dashboard.php?nuovost=consegnato&track='.$dati[$pos]['track'];
        }
          ?>

         <button onclick="location.href='<?php echo $location; ?>';"><img src="../img/spunta.png" style="width: 35px; height:auto; <?php if($completospedizione!=$uguale){ ?> -webkit-filter: grayscale(100%); filter: grayscale(100%); <?php } ?>" alt="completato"></button>


        <button type="button" class="btn btn-primary" onclick="location.href='dashboard.php';" data-dismiss="modal">Chiudi</button>

        </div>
    </div>
  </div>
</div>





  <!-- Bootstrap core JavaScript -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

  <!-- Contact Form JavaScript -->


  <!-- Custom scripts for this template -->
  <script src="../js/freelancer.min.js"></script>
  <script src="../js/classie.js"></script>
  	<script src="../js/dummydata.js"></script>
  	<script src="../js/main1.js"></script>
  	<script>
  	(function() {
  		var menuEl = document.getElementById('ml-menu'),
  			mlmenu = new MLMenu(menuEl, {
  				// breadcrumbsCtrl : true, // show breadcrumbs
  				// initialBreadcrumb : 'all', // initial breadcrumb text
  				backCtrl : false, // show back button
  				// itemsDelayInterval : 60, // delay between each menu item sliding animation
  				onItemClick: loadDummyData // callback: item that doesn´t have a submenu gets clicked - onItemClick([event], [inner HTML of the clicked item])
  			});

  		// mobile menu toggle
  		var openMenuCtrl = document.querySelector('.action--open'),
  			closeMenuCtrl = document.querySelector('.action--close');

  		openMenuCtrl.addEventListener('click', openMenu);
  		closeMenuCtrl.addEventListener('click', closeMenu);

  		function openMenu() {
  			classie.add(menuEl, 'menu--open');
  			closeMenuCtrl.focus();
  		}

  		function closeMenu() {
  			classie.remove(menuEl, 'menu--open');
  			openMenuCtrl.focus();
  		}

  		// simulate grid content loading
  		var gridWrapper = document.querySelector('.content');

  		function loadDummyData(ev, itemName) {
  			ev.preventDefault();

  			closeMenu();
  			gridWrapper.innerHTML = '';
  			classie.add(gridWrapper, 'content--loading');
  			setTimeout(function() {
  				classie.remove(gridWrapper, 'content--loading');
  				gridWrapper.innerHTML = '<ul class="products">' + dummyData[itemName] + '<ul>';
  			}, 700);
  		}
  	})();
  	</script>
</body>

</html>

<?php
	if (isset($_GET['errore'])&&!empty($_GET['errore'])) {

		// se sono presenti errori come get parameter

		echo "<script type='text/javascript'>
$(document).ready(function(){
$('#Modal').modal('show');
});
</script>";
	}
  if (isset($_GET['profilo'])&&!empty($_GET['profilo'])) {

		// se sono presenti errori come get parameter

		echo "<script type='text/javascript'>
$(document).ready(function(){
$('#eliminaprof').modal('show');
});
</script>";
	}
  if (isset($_GET['cambia'])&&!empty($_GET['cambia'])) {

		// se sono presenti errori come get parameter

		echo "<script type='text/javascript'>
$(document).ready(function(){
$('#Cambia').modal('show');
});
</script>";
	}
  if (isset($_GET['modifica'])&&!empty($_GET['modifica'])) {

		// se sono presenti errori come get parameter

		echo "<script type='text/javascript'>
$(document).ready(function(){
$('#Pwd').modal('show');
});
</script>";
	}

if(isset($_GET['elimina'])&&!empty($_GET['elimina'])&&!isset($_GET['si'])&&empty($_GET['si'])){
  echo "<script type='text/javascript'>
  $(document).ready(function(){
  $('#Sicuro').modal('show');
  });
  </script>";

}

if(isset($_GET['notifiche'])&&!empty($_GET['notifiche'])){
  echo "<script type='text/javascript'>
  $(document).ready(function(){
  $('#Notifiche').modal('show');
  });
  </script>";

}
if(isset($_GET['nuovost'])&&!empty($_GET['nuovost'])&&isset($_GET['track'])&&!empty($_GET['track'])){
  if ($_GET['nuovost']=="noconsegnato") {
    echo "<script type='text/javascript'>
    $(document).ready(function(){
    $('#noConsegnato').modal('show');
    });
    </script>";
  }else{
  echo "<script type='text/javascript'>
  $(document).ready(function(){
  $('#Consegnato').modal('show');
  });
  </script>";
}
}
if(isset($completo)){
  echo "<script type='text/javascript'>
  $(document).ready(function(){
  $('#Possibile').modal('show');
  });
  </script>";

}
if(isset($trackspedizione)){
  echo "<script type='text/javascript'>
  $(document).ready(function(){
  $('#Spedizione').modal('show');
  });
  </script>";

}
 ?>
