<?php
include("session.php");
include("sql.php");
include("functions.php");
include("oop.php");

if(isset($_SESSION[id])){
$kutyuli = new kutya;
$kutyuli->GetKutyaByID($_SESSION[id]);
if($kutyuli->rang==3){
if($_POST[kutya] && $_POST[penz])
{
  if(is_numeric($_POST[penz]))
  {
			$handle = fopen("../data/csont.txt", "r");
			$kuldheto=fread($handle, filesize("../data/csont.txt"));
			fclose($handle);
			$kuldheto-=$_POST[penz];

		if($kuldheto>=0){
     if($kutyuli->GetKutyaByNev($_POST[kutya]))
     {
      $kutyuli->SendUzenet(0, penz($_POST[penz]) ." ker�lt a birtokodba.");
       $kutyuli->PenzHozzaad($_POST[penz]);
          $handle = fopen("../data/csontkuldes.txt", "a+");
          fwrite($handle,  "Id�: ". date("Y.m.d H:i:s")  ." K�ld�: ".$_SESSION[nev]." Kap�: ". $kutyuli->nev . " �sszeg: ". penz($_POST[penz])."\n");
          fclose($handle);
		  
		  $handle = fopen("../data/csont.txt", "w");
		  fwrite($handle, $kuldheto);
		  fclose($handle);
       $_SESSION[hiba]=ok("Sikeres p�nz k�ld�s!"); 
     }else{
          $_SESSION[hiba]=hiba("Nem l�tezik ilyen nev� kutya!"); 
     }
	 }
	 else{
		$_SESSION[hiba]=hiba("Ennyi csont nem k�ldhet�!"); 
	 }
  }else{
    $_SESSION[hiba]=hiba("Nem sz�mot adt�l meg a p�nz mez�ben!"); 
  }
}
else{
$_SESSION[hiba]=hiba("Nem t�lt�tt�l ki minden adatot!"); 
}


header("Location: ../admin.php");
}
else{
header("Location: ../index.php");
}
}else{
header("Location: ../index.php");
}

?>
