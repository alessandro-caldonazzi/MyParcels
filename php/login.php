<?php
session_start();
echo '<link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon" />';
require 'db.php';
if(!empty($_POST['email'])&&!empty($_POST['pass'])){
  $email=filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
  $pass=$_POST['pass'];
  $query="SELECT * from utenti where email=?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $query)){
            header("Location: ../html/loginht.php?errore=erroresql");
            exit();
        }else {
          mysqli_stmt_bind_param($stmt, "s", $email);
          mysqli_stmt_execute($stmt);
        }
  $risultato = mysqli_stmt_get_result($stmt);
  $riga=mysqli_fetch_assoc($risultato);

  $passwdcontr= password_verify($pass, $riga['passwd']);
  if ($passwdcontr) {
    if ($riga['verifica']) {
      $_SESSION['email']=$riga['email'];
      $_SESSION['nome']=$riga['nome'];
      $_SESSION['id']=$riga['id'];
      if($riga['afstate']=="si"){
        $_SESSION['af']=1;
      }else {
        $_SESSION['af']=0;
      }
      header('Location: dashboard.php');
      exit();
    }else {
      header("Location: ../html/loginht.php?errore=noverifica&email=". $email ."&token=". $riga['token']);
      exit();
    }

  }else {
    echo "la password è sbaglitaa";
    header('Location: ../html/loginht.php?errore=pwd');
    exit();


  }
}else {
  echo "mancano dei dati";
  header('Location: ../html/loginht.php?errore=data');
  exit();

}
?>
