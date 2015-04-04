 <?
include("session.php");
include("sql.php");
include("functions.php");
include("oop.php");

if(isset($_SESSION[id])){
	$kutyuli = new kutya;
	$kutyuli->GetKutyaByID($_SESSION[id]);
	if($kutyuli->rang==3){
		///penz kuldese
		if(isset($_GET[kutya]) && $_GET[penz])
		{
		  if(is_numeric($_GET[penz]))
		  {
					$handle = fopen("../data/csont.txt", "r");
					$kuldheto=fread($handle, filesize("../data/csont.txt"));
					fclose($handle);
					$kuldheto-=$_GET[penz];

				if($kuldheto>=0 or $_SESSION[id] == 1){
					 if($kutyuli->GetKutyaByNev(str_replace("SPACE", " ",$_GET[kutya])))
					 {
						$kutyuli->SendUzenet(0, penz($_GET[penz]) ." került a birtokodba.");
						$kutyuli->PenzHozzaad($_GET[penz]);
						$handle = fopen("../data/csontkuldes.txt", "a+");
						fwrite($handle,  "Idõ: ". date("Y.m.d H:i:s")  ." Küldõ: ".$_SESSION[nev]." Kapó: ". $kutyuli->nev . " Összeg: ". penz($_GET[penz])."\n");
						fclose($handle);
						  
						$handle = fopen("../data/csont.txt", "w");
						fwrite($handle, $kuldheto);
						fclose($handle);
						echo ok("Sikeres pénz küldés!"); 
					 }else{
						echo hiba("Nem létezik ilyen nevû kutya!"); 
					 }
				}
				else{
					echo hiba("Ennyi csont nem küldhetõ!"); 
				}
		  }else{
			echo hiba("Nem számot adtál meg a pénz mezõben!"); 
		  }
		}
		elseif (isset($_GET[kutya]) || $_GET[penz]){
			echo hiba("Nem töltöttél ki minden adatot!"); 
		}
		///penz kuldesnek VEGE
		
		///blog iras engedelyezese min nap es irastanulasa resz
		$blogirasAdatok = fopen("../data/blogiras.txt", "r");
		$blogIras=explode("|", fread($blogirasAdatok, filesize("../data/blogiras.txt")));
		fclose($blogirasAdatok);

		$blognaptol=$blogIras[0];
		$blogiraseng=$blogIras[1];

		if(isset($_GET[blognap]) && isset($_GET[blogiras]))
		{
			if(is_numeric($_GET[blognap]))
			{			
				$blognaptol = $_GET[blognap];
			}
			if($_GET[blogiras] == 1 or $_GET[blogiras] == 0)
			{
				$blogiraseng = $_GET[blogiras];
			}
			
			echo $blognaptol."|". $blogiraseng;
		}
		elseif(isset($_GET[blognap]))
		{
			if(is_numeric($_GET[blognap]))
			{	
				$blognaptol = $_GET[blognap];
			}
			$blogiraseng=0;
			
			echo $blognaptol."|". $blogiraseng;
		} 

		$blogirasAdatok = fopen("../data/blogiras.txt", "w");
		fwrite($blogirasAdatok, $blognaptol."|". $blogiraseng);
		fclose($blogirasAdatok);
		///blog iras engedelyezese min nap es irastanulasa resz VEGE
	}
	//targy vasarlasa
	if(isset($_GET[targyid]))
	{
			$ujTargy = new targy();
			if($ujTargy->GetTargyByID($_GET[targyid]))
			{
					if($ujTargy->ar > $kutyuli->penz)
					{
						echo hiba("Nincs elég pénzed!");
					}
					else
					{
					if($kutyuli->TargyHozzaAdd($_GET[targyid]))
					{
						$kutyuli->PenzElvesz($ujTargy->ar);
					}
					echo Penz($kutyuli->penz) ."|". $kutyuli->kep();
					}
			}
	}

}
else
{
header("Location: ../index.php");
}
 ?>