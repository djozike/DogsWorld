<?php
include("sql.php");
include("session.php");
include("oop.php");
if(isset($_SESSION[id])){

$leker=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."'");
if(substr_count($leker->kutya_tanul,"VE")==0){

function veletlenke($mitol, $meddig, $hany)
{
$veletlenek[0]=rand($mitol,$meddig);
$db=1;
while($db<$hany)
{
$veletlen=rand($mitol,$meddig);
if(!in_array($veletlen, $veletlenek))
{
$veletlenek[$db]=$veletlen;
$db++;
}
}
return $veletlenek;
}
if(isset($_GET[ido]))
{
//idofrissites
$ido=mysql_query("SELECT kviztipp_ido, kviztipp_pont  FROM kviztipp WHERE kviztipp_kutyaid = '". $_SESSION[id] ."'");
while($idos=mysql_fetch_object($ido))
{
$jatekIdo=$idos->kviztipp_ido-$most;
	if ($jatekIdo < 0)
	{
		$maxPontLe=mysql_query("SELECT * FROM kvizeredmeny WHERE kvizeredmeny_kutyaid = '". $_SESSION[id] ."'");
		if(mysql_num_rows($maxPontLe)==0)
		{
			mysql_query("INSERT INTO kvizeredmeny VALUES('". $_SESSION[id] ."','". $idos->kviztipp_pont ."')");
		}
		else{
			while($maxpont=mysql_fetch_object($maxPontLe))
			{
				if($maxpont->kvizeredmeny_pont < $idos->kviztipp_pont)
				{
					mysql_query("UPDATE kvizeredmeny SET kvizeredmeny_pont = '". $idos->kviztipp_pont ."'  WHERE kvizeredmeny_kutyaid = '". $_SESSION[id] ."'");
				}
			}
		}
		echo "0";
	}
	else{
		echo $jatekIdo;
	}
}

}
elseif(isset($_GET[valasz]))
{
//valaszolas
$idod=mysql_query("SELECT * FROM kviztipp WHERE kviztipp_kutyaid = '". $_SESSION[id] ."'");
	while($idos=mysql_fetch_object($idod))
	{
		if($idos->kviztipp_ido-$most > 0)
		{
			if($idos->kviztipp_valasz==$_GET[valasz])
			{
				$pont=$idos->kviztipp_pont+1;
				$ido=$idos->kviztipp_ido;
			}
			else
			{
				$pont=$idos->kviztipp_pont;
				$ido=$idos->kviztipp_ido-5;
			}
			
			$handle = fopen("../data/kviz.txt", "r");
				if ($handle) {
				$i=0;
					while (($line = fgets($handle)) !== false) {
						$tomb[$i]=$line;
						$i++;
					}
			$kivalasztott=explode("|",$tomb[rand(0, (sizeof($tomb)-1))]);
			$szam=veletlenke(1,4,4);
	
			for($i=0;$i<4;$i++)
			{
					if ($szam[$i]==1)
					{
						$valasz=$i+1;
						break;
					}
			}
			mysql_query("DELETE FROM kviztipp WHERE kviztipp_kutyaid = '". $_SESSION[id] ."'");
			mysql_query("INSERT INTO kviztipp VALUES('". $_SESSION[id] ."','". $valasz ."','". $ido ."', '". $pont ."')");
			echo $kivalasztott[0]."|". $kivalasztott[$szam[0]]."|". $kivalasztott[$szam[1]]."|". $kivalasztott[$szam[2]]."|". $kivalasztott[$szam[3]] ."|". ($ido-$most) ."|". $pont;
			} else {
				// error opening the file.
			} 
			fclose($handle);
			
		}
	}
}
else{
///jatek indulas
$handle = fopen("../data/kviz.txt", "r");
if ($handle) {
	$i=0;
    while (($line = fgets($handle)) !== false) {
        $tomb[$i]=$line;
		$i++;
    }
	$kivalasztott=explode("|",$tomb[rand(0, (sizeof($tomb)-1))]);
	$szam=veletlenke(1,4,4);
	

	mysql_query("DELETE FROM kviztipp WHERE kviztipp_kutyaid = '". $_SESSION[id] ."'");
	for($i=0;$i<4;$i++)
	{
		if ($szam[$i]==1)
		{
			$valasz=$i+1;
			break;
		}
	}
	mysql_query("INSERT INTO kviztipp VALUES('". $_SESSION[id] ."','". $valasz ."','". ($most+90) ."', '0')");
	echo $kivalasztott[0]."|". $kivalasztott[$szam[0]]."|". $kivalasztott[$szam[1]]."|". $kivalasztott[$szam[2]]."|". $kivalasztott[$szam[3]] ."|90|0";
} else {
    // error opening the file.
} 
fclose($handle);
}


}
else{
header("Location: index.php");
}

}
else{
header("Location: index.php");
}
?>