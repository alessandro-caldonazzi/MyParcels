<?php ob_start("ob_gzhandler"); ?>
<?php
//qui recupero se esiste l'errore
	if (isset($_GET['errore'])&&!empty($_GET['errore'])) {
		if($_GET['errore']=="pwd"){
			$errore="Le due password non coincidono";
		}else if ($_GET['errore']=="erroresql"){
			$errore="C'è stato un problema con le nostre infrastrutture";
		}else if ($_GET['errore']=="email"){
			$errore="Inserisci un email";
		}else if ($_GET['errore']=="noemail"){
			$errore="Non è stato trovato alcun utente con indirizzo email per registrarti clicca<a href=registerht.php> qui</a>";
		}else if ($_GET['errore']=="mex"){
			$errore="Clicca sul link che ti è stato inviato via mail";
		// se sono presenti errori come get parameter

		}
	}


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

	<!--errore nella registrazione-->
	<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel"><?php if ($_GET['errore']=="mex"){ echo "Successo";}else{echo "Errore";} ?></h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
					<?php echo $errore; ?>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>

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

				<form class="login100-form validate-form" action="../php/forgotpwd.php" method="post">
					<span class="login100-form-title">
						Password Dimenticata
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="email" placeholder="Email">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit"style="color: #fff;">
							Recupera Password
						</button>
					</div>

					<div class="text-center p-t-12">
						<span class="txt1">
							Ritorna al
						</span>
						<a class="txt2" href="loginht.php">
							Login
						</a>
					</div>
					<div class="container text-center">
						<img src="../img/shield.png" alt="My Parcels - Alessandro Caldonazzi - Giacomo Foradori" style="width: 60px; margin-top:10px;">

					</div>
					<div class="text-center p-t-136">
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


 ?>
