<?php
include("session.php");
include("sql.php");
include("oop.php");
 if(isset($_SESSION[id])){
 $kutyus=new kutya();
 $kutyus->GetKutyaByID($_SESSION[id]);
 if($kutyus->genkutat==0){
 if($kutyus->PenzElvesz($GENKUTAT)){
    $kutyus->GenKutat();
    echo penz($kutyus->penz). "*" . $kutyus->GenMegjelenit();
 } else{
     echo "Nincs elég pénzed!";
 }
 }
 }else{
header("Location: ../index.php"); 
 }
?>
