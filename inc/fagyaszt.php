<?php
include("session.php");
include("sql.php");
include("oop.php");
if(isset($_SESSION[id])){
 $kuty=new kutya();
if($kuty->GetKutyaByID($_SESSION[id]))
{
if($kuty->kor>$FAGYASZTMINAP){
$kuty->Fagyasztas();
if($kuty->falka!=0){
falkapont($kuty->falka);
}
}
echo $kuty->FagyasztasMegjelenit(); 
}else{ header("Location: ../index.php");}
}else{header("Location: ../index.php");}
	?>
