<?php
require 'db.php';
session_start();

echo '<link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon" />';
if (isset($_GET['motivo'])&&!empty($_GET['motivo'])) {
  // devo inviare nuovamente il link richiesta dell'Utente
  echo "funzione presto in arrivo, se hai bisogno di maggiore supporto contattaci a: myparcelsproject@gmail.com";
}
if(isset($_SESSION['email_ver'])&&!empty($_SESSION['email_ver'])&&isset($_SESSION['token_ver'])&&!empty($_SESSION['token_ver'])){
  $email=$_SESSION['email_ver'];
  $token=$_SESSION['token_ver'];
  $query="SELECT * from utenti where email=?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $query)){
        echo "C'è stata una problemazione tecnica, riprovi piu tardamente. Error 867";
        header('Location: ../html/loginht.php?errore=erroresql');
        exit();
    }else {
      mysqli_stmt_bind_param($stmt, "s", $email);
      mysqli_stmt_execute($stmt);
  }
$risultato = mysqli_stmt_get_result($stmt);
$riga=mysqli_fetch_assoc($risultato);
if ($token==$riga['token']){
  if ($riga['verifica']=="0"){
    $query1="UPDATE utenti SET verifica=1, usato='si' where email=?";
    $stmt1=mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt1, $query1)){
      echo "C'è stata una problemazione tecnica, riprovi piu tardamente. Error 987";
      header('Location: ../html/loginht.php?errore=erroresql');
      exit();

    }else{
      mysqli_stmt_bind_param($stmt1, "s", $email);


      if (mysqli_stmt_execute($stmt1)) {
        echo "Operazione completata con successo, utente verificato";
        header('Location: ../html/loginht.php?successo=utver');
        exit();
      }else {
        echo "problema tecnico riprova più tardi. Error 203";
        header('Location: ../html/loginht.php?errore=erroresql');
        exit();
      }

    }


  }else {
    echo "Utente già verificazionato con documentazione validatazionata";
    header('Location: ../html/loginht.php?errore=giaver');
    exit();
  }

}else {
  echo "token non validitazionato";
  header('Location: ../html/loginht.php?errore=token');
  exit();
}
}else if(isset($_GET['email'])&&!empty($_GET['email'])&&isset($_GET['token'])&&!empty($_GET['token'])){
  $email=$_GET['email'];
  $token=$_GET['token'];
  $query="SELECT * from utenti where email=?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $query)){
        echo "C'è stata una problemazione tecnica, riprovi piu tardamente. Error 867";
        header('Location: ../html/loginht.php?errore=erroresql');
        exit();
    }else {
      mysqli_stmt_bind_param($stmt, "s", $email);
      mysqli_stmt_execute($stmt);
  }
  $risultato = mysqli_stmt_get_result($stmt);
  $riga=mysqli_fetch_assoc($risultato);
  if ($token==$riga['token']){
  if ($riga['verifica']=="0"){
    $query1="UPDATE utenti SET verifica=1, usato='si' where email=?";
    $stmt1=mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt1, $query1)){
      echo "C'è stata una problemazione tecnica, riprovi piu tardamente. Error 987";
      header('Location: ../html/loginht.php?errore=erroresql');
      exit();

    }else{
      mysqli_stmt_bind_param($stmt1, "s", $email);


      if (mysqli_stmt_execute($stmt1)) {
        echo "Operazione completata con successo, utente verificato";
        header('Location: ../html/loginht.php?successo=utver');
        exit();
      }else {
        echo "problema tecnico riprova più tardi. Error 203";
        header('Location: ../html/loginht.php?errore=erroresql');
        exit();
      }

    }


  }else {
    echo "Utente già verificazionato con documentazione validatazionata";
    header('Location: ../html/loginht.php?errore=giaver');
    exit();
  }

  }else {
  echo "token non validitazionato";
  header('Location: ../html/loginht.php?errore=token');
  exit();
  }

}else{
  header('Location: ../html/loginht.php?errore=sessionscad');
  exit();
}


 ?>
