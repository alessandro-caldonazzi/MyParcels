<?php
$host = "localhost";
$nomeutente = "locale";
$password = "s59sWHwsDcaHwmVL";
$dbnome = "alexapar45711";
  $conn = mysqli_connect($host, $nomeutente, $password, $dbnome);
  if($conn){
    echo "Connessione Riuscita";


    $querytest="SELECT oraultima from spedizioni where completo!='si' LIMIT 1";

    if($resulttest = mysqli_query($conn,$querytest)){

      $rowss = mysqli_fetch_array($resulttest, MYSQLI_ASSOC);
      echo "<br>";
      echo $rowss['oraultima'];


    }
  }




?>
