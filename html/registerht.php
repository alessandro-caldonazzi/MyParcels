<?php ob_start("ob_gzhandler"); ?>
<?php
//qui recupero se esiste l'errore
	if (isset($_GET['errore'])&&!empty($_GET['errore'])) {
		if($_GET['errore']=="pwd"){
			$errore="Le due password non coincidono";
		}else if ($_GET['errore']=="erroresql"){
			$errore="C'è stato un problema con le nostre infrastrutture";
		}else if ($_GET['errore']=="email"){
			$errore="La tua email ci risulta gia presente nei nostri sistemi. Puoi effetuare il recupero della password se la hai dimentica attraverso l'apposito <a href=forgotpwdht.php>link</a>";
		}else if ($_GET['errore']=="data"){
			$errore="Mancano alcuni dati, ricordati di spuntare la privacy policy";
		}else if ($_GET['errore']=="policy"){
			$errore="I termini Di privacy policy devono essere accettati, per potersi iscrivere.";
		}
		// se sono presenti errori come get parameter


	}


 ?>

<!DOCTYPE html>
<html lang="it">
<head>
	<title>Registrazione My Parcels</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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

	<!--errore nella registrazione-->
	<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Errore</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
					<?php echo $errore; ?>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" data-dismiss="modal">Chiudi</button>

	      </div>
	    </div>
	  </div>
	</div>

	<div class="modal fade bd-example-modal-lg" id="privacy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Privacy Policy</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
					NORMATIVA SULLA PRIVACY
					La presente informativa viene resa in ossequio all'art. 13 del Regolamento 2016/679 (GDPR), ai sensi dell'art. 13 del d.lgs. n. 196/2003 (Codice in materia di protezione dei dati personali) agli utenti che accedono al sito web www.myparcels.it ed è relativa a tutti i dati personali trattati secondo le modalità di seguito indicate.
					Noi di www.myparcels.it riteniamo che la privacy dei nostri visitatori sia estremamente importante. Questo documento descrive dettagliatamente i tipi di informazioni personali raccolti e registrati dal nostro sito e come essi vengano utilizzati. File di Registrazione Informazioni come indirizzi di protocollo Internet (IP), il tipo di browser, Internet Service Provider (ISP) non vengono assolutamente raccolte.
					Titolare Tratttamento Datalist
					Il titolare del trattamento dei dati personali è myparcels.it con sede a Trento. Finalità e Modalità del trattamento I dati raccolti dal nostro sito web sono: Nome e Cognome Email Password I seguenti dati verranno raccolti allo scopo di iscrizione al servizio, per poter contattarvi via email riguardo una notifica di spedizione, allo status di una spedizione e per maggiore comodità nella gestione dei dati.
					Cancellazione dei Dati Personali
					Per esercitare i diritti previsti all'art. 7 del Codice della Privacy ovvero per la cancellazione dei vostri dati dall'archivio, è sufficiente contattarci attraverso uno dei canali messi a disposizione oppure nella dashboard dove è presente il tasto per la cancellazione dell'account. Tutti i dati sono protetti attraverso l'uso di antivirus, firewall e protezione attraverso password. I dati raccolti non verrano ceduti a terzi e resteranno nelle nostre infrastrutture fino a che l’utente non cancelli l’account.
					Consenso
					Usando il nostro sito web, acconsenti alla nostra politica sulla privacy e accetti i suoi termini.
					Se desideri ulteriori informazioni o hai domande sulla nostra politica sulla privacy non esitare a contattarci al seguente indirizzo email: myparcelsproject@gmail.com

	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" data-dismiss="modal">Chiudi</button>

	      </div>
	    </div>
	  </div>
	</div>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="../img/profile.png" alt="My Parcels">
				</div>

				<form class="login100-form validate-form" action="../php/register.php" method="post">
					<span class="login100-form-title">
						Registrazione Utente
						<br>
						<div style="border: 1px solid #883232; border-radius: 5px;" class="pt-2 pb-2 pl-2 pr-2 mt-4">
							<h3 style="font-size: 14px; font-family: 'arial', sans-serif;  color: #faebd7; font-style: normal; font-weight: normal;">Ricorda: Durante la registrazione utilizza la stessa email a cui è legato l'account amazon del tuo dispositivo alexa / profilo personale nel dispositivo. Per maggiori info guarda la <a href="registerht.php?privacy=policy" style="font-size: 14px; font-family: 'arial', sans-serif;  color: #faebd7; font-style: normal; font-weight: normal;">Privacy Policy</a></h3>
						</div>
						</span>

          <div class="wrap-input100 validate-input" data-validate = "Il nome è necessario">
            <input class="input100" type="text" name="nome" placeholder="Nome">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
              <i class="fa fa-user" aria-hidden="true"></i>
            </span>
          </div>
					<div class="wrap-input100 validate-input" data-validate = "Inserisci una email valida">
						<input class="input100" type="text" name="email" placeholder="email dell'account amazon">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "La password è necessaria">
						<input class="input100" type="password" name="pass" placeholder="Password a tua scelta">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
          <div class="wrap-input100 validate-input" data-validate = "La password è necessaria">
						<input class="input100" type="password" name="pass1" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					<div class="form-check text-center">
					  <input class="form-check-input"  name="accetto" type="checkbox" value="1" id="defaultCheck1">
					  <label class="form-check-label " for="defaultCheck1" style="color: #fff;">
					    Accetto la  <a href="registerht.php?privacy=policy" style="color: #ddd">Privacy Policy</a>
					  </label>
					</div>
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit" style="color: #fff;">
							Registrati
						</button>
					</div>

					<div class="container text-center">
						<img src="../img/shield.png" alt="My Parcels - Alessandro Caldonazzi - Giacomo Foradori" style="width: 60px; margin-top:10px;">

					</div>

					<div class="text-center p-t-25">
						<a class="txt2" href="loginht.php">
							Hai già un account
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
	<script src="../vendor/bootstrap/js/popper.min.js"></script>
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
	if (isset($_GET['errore'])&&!empty($_GET['errore'])) {

		// se sono presenti errori come get parameter

		echo "<script type='text/javascript'>
$(document).ready(function(){
$('#Modal').modal('show');
});
</script>";
}if (isset($_GET['privacy'])&&!empty($_GET['privacy'])) {

		// se sono presenti errori come get parameter

		echo "<script type='text/javascript'>
$(document).ready(function(){
$('#privacy').modal('show');
});
</script>";
	}


 ?>
