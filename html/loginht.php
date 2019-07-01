<?php ob_start("ob_gzhandler"); ?>
<?php
//qui recupero se esiste l'errore
	if (isset($_GET['errore'])&&!empty($_GET['errore'])) {
		if($_GET['errore']=="pwd"){
			$errore="La password è sbagliata";
		}else if ($_GET['errore']=="erroresql"){
			$errore="C'è stato un problema con le nostre infrastrutture";
		}else if ($_GET['errore']=="noverifica"){
			$errore="Il tuo utente non è stato verificato, per verificarlo clicca i link che ti è stato inviato via email nel momento della registrazione. Oppure clicca
			<a href=../php/verifica.php?motivo=newlink&email=". $_GET['email'] . "&token=".$_GET['token'] .">Qui</a>
			per verificarlo ora. Ricorda di completare la procedura dallo stesso dispositivo";

		}else if ($_GET['errore']=="data"){
			$errore="Mancano dei dati";
		}else if ($_GET['errore']=="pwmod"){
			$errore="Password modifica con successo effetua il login";
		}else if ($_GET['errore']=="token"){
			$errore="Token non valido";
		}else if ($_GET['errore']=="giaver"){
			$errore="Utente gia verificato";
		}else if ($_GET['errore']=="sessionscad"){
			$errore="La tua sessione è scaduta, ricordati di effettuare tutto il processo di registrazione da un solo dispositivo senza chiudere il browser";
		}
		// se sono presenti errori come get parameter


	}


 ?>
<!DOCTYPE html>
<html lang="it">
<head>
	<title>Login My Parcels</title>
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

	<!--errore del login-->
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
					<?php if ($_GET['errore']=="noverifica"): ?>
						<button type="button" class="btn btn-success" onclick="location.href='../php/verifica.php?motivo=newlink&email=<?php echo $_GET['email']; ?>&token=<?php echo $_GET['token'];?>';" data-dismiss="modal">Verifica</button>
					<?php endif; ?>
	        <button type="button" class="btn btn-primary" data-dismiss="modal">Chiudi</button>

	      </div>
	    </div>
	  </div>
	</div>
	<div class="modal fade" id="Successo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Registrazione avvenuta</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
					Grazie per esserti registrato, clicca sul link che hai ricevuto via email per confermare l'account. Nel frattempo ricordati di non cambiare dispositivo, esegui tutto da questo. Grazie
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" data-dismiss="modal">Chiudi</button>

	      </div>
	    </div>
	  </div>
	</div>
	<div class="modal fade" id="Verificato" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Utente Verificato</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					Il tuo utente è stato verificato correttamente. Esegui il login.
					</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">Chiudi</button>

				</div>
			</div>
		</div>
	</div>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100" >
				<div class="login100-pic js-tilt" data-tilt>
					<img src="../img/profile.png" alt="My Parcels">
				</div>

				<form class="login100-form validate-form" action="../php/login.php" method="post">
					<span class="login100-form-title">
						Login Utente
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="email" placeholder="Email">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="pass" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" style="color: #fff;" type="submit">
							Entra
						</button>
					</div>

					<div class="text-center p-t-12">
						<span class="txt1">
							Dimenticata
						</span>
						<a class="txt2" href="forgotpwdht.php">
							Username / Password?
						</a>
					</div>
					<div class="container text-center">
						<img src="../img/shield.png" alt="My Parcels - Alessandro Caldonazzi - Giacomo Foradori" style="width: 60px; margin-top:10px;">

					</div>

					<div class="text-center p-t-90">
						<a class="txt2" href="registerht.php">
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
	}

	if (isset($_GET['registrazione'])&&!empty($_GET['registrazione'])) {

		// se sono presenti errori come get parameter

		echo "<script type='text/javascript'>
	$(document).ready(function(){
	$('#Successo').modal('show');
	});
	</script>";
	}
	if (isset($_GET['successo'])&&!empty($_GET['successo'])) {

		// se sono presenti errori come get parameter

		echo "<script type='text/javascript'>
	$(document).ready(function(){
	$('#Verificato').modal('show');
	});
	</script>";
	}
 ?>
