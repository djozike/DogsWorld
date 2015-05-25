<?php 
include_once("functions.php");
  class kutya
  {
    var $id= 0;
    var $nev = "törölt kutya";
    var $nevszin=0;
    var $suly=0;
    var $egeszseg=0;
    var $kaja=0;
    var $kajatipus=0;
    var $fagyaszt=0;
    var $nem = "szuka";
    var $penz = 0;
    var $kor = 0;
    var $rang = 0;
    var $genek = 0;
    var $genkutat=0;
    var $fajta=0;
    var $szin=0;
    var $falka=0;
    var $oldalroltiltva=0;
    var $egyszammin=1;
    var $egyszammax=76; 
    var $online = false;
    var $adatlap = false;
    var $blog = false;
	var $targyak = array();
	var $targyakHord = array();

    function GetKutya($leker) {
        global $ma;
        include("sql.php");
        if(mysql_num_rows($leker)>0)
        {
            while($adatok=mysql_fetch_object($leker))
            {
              $this->id=$adatok->kutya_id;
              $this->nev=$adatok->kutya_nev;
              $this->suly=$adatok->kutya_suly;
              $this->egeszseg=$adatok->kutya_egeszseg;
              $this->kaja=$adatok->kutya_etel;
              $this->kajatipus=$adatok->kutya_kajatipus;
              $this->fagyaszt=$adatok->kutya_fagyasztva;
              $this->penz=$adatok->kutya_penz;
              $this->nevszin=$adatok->kutya_betuszin;
              $this->fajta=$adatok->kutya_fajta;
              $this->szin=$adatok->kutya_szin;
              $this->kor=$adatok->kutya_kor;
              $this->genkutat=$adatok->kutya_genkutat;
              $this->genek=$adatok->kutya_gen;
              $this->legjobbgondozo=$adatok->kutya_legjobbgondozo;
              $this->falka=$adatok->kutya_falka;
              $this->belepido=$adatok->kutya_belepido;
              $this->belepip=$adatok->kutya_belepip;
              $this->tanult=explode('|', $adatok->kutya_tanul);
              $this->egyszampont=0;
              if($adatok->kutya_nem==2){
              $this->nem="kan";
              }
              $this->rang=0;
            }
            
              $leker2=mysql_query("SELECT * FROM moderator WHERE mod_kutya = '". $this->id ."'");
              while($mod=mysql_fetch_object($leker2))
              {
              $this->rang=$mod->mod_rang;
              }
              
              $leker3=mysql_query("SELECT * FROM oldaltilt WHERE oldaltilt_kid = '". $this->id ."'");
              while($oTilt=mysql_fetch_object($leker3))
              {
              $this->oldalroltiltva=$oTilt->oldaltilt_ido;
              }
              
			  ///kolykok
			  $i=0;
			  $lekerKolyok=mysql_query("SELECT * FROM `kutya` WHERE `kutya_apa` = ". $this->id ." or `kutya_anya` = ". $this->id ."");
              while($kolyokok=mysql_fetch_object($lekerKolyok))
              {
                  $this->kolyok[$i]=$kolyokok->kutya_id;
			     $i++;
              }
			  
			  //baratok
              $leker4=mysql_query("SELECT * FROM baratlista WHERE baratlista_owner = '". $this->id ."'");
              $i=0;
              while($barat=mysql_fetch_object($leker4))
              {
              $this->baratok[$i]=$barat->baratlista_barat;
              $i++;
              }
              
			  //online-e
              $leker5=mysql_query("SELECT * FROM `session` WHERE `nev` = '". $this->nev ."'");
              if(mysql_num_rows($leker5)>0)
              {
                  $this->online=true;
              }
              else{
                $this->online=false;
              }
              
			  ///van-e adatlap
              $leker6=mysql_query("SELECT * FROM `adatlap` WHERE `adatlap_id` = '". $this->id ."' and adatlap_aktiv = '1'");
              if(mysql_num_rows($leker6)>0)
              {
                  $this->adatlap=true;
              }
              else{
                $this->adatlap=false;
              }
              
			  //van-e blog
              $leker7=mysql_query("SELECT * FROM `blog` WHERE `blog_kutya` = '". $this->id ."'");
              if(mysql_num_rows($leker7)>0)
              {
                  $this->blog=true;
              }
              else{
                $this->blog=false;
              }
              
			  ///egyszam
              $leker8=mysql_query("SELECT * FROM `egyszampontok` WHERE `egyszampontok_kid` = '". $this->id ."'");
              while($egyszampont=mysql_fetch_object($leker8))
              {
                  $this->egyszammin=$egyszampont->egyszampontok_min;
                  $this->egyszammax=$egyszampont->egyszampontok_max;
                  $this->egyszam=$egyszampont->egyszampontok_szam;
                  $this->egyszampont=$egyszampont->egyszampontok_pont;
                  $this->egyszamproba=$egyszampont->egyszampontok_tipp;
              }
			  
			  //targyak
			  $lekerTargyak=mysql_query("SELECT * FROM `kutyatargyak` WHERE `kutyatargyak_kutyaid` = '". $this->id ."'");
			  $db=0;
              while($Targyak=mysql_fetch_object($lekerTargyak))
              {
                  $this->targyak[$db]=$Targyak->kutyatargyak_targyid;
				$db++;
              }
			  $lekerTargyak=mysql_query("SELECT * FROM `kutyatargyak` WHERE `kutyatargyak_kutyaid` = '". $this->id ."' and `kutyatargyak_hord` = '1'");
			  $db=0;
              while($Targyak=mysql_fetch_object($lekerTargyak))
              {
                  $this->targyakHord[$db]=$Targyak->kutyatargyak_targyid;
				$db++;
              }
        return true;
        }
        return false;
    }

    function GetKutyaByID($id1) {
        include("sql.php");
        $leker=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $id1 ."'");
        return $this->GetKutya($leker);
    }
        function GetKutyaByNev($id1) {
        include("sql.php");
        $leker=mysql_query("SELECT * FROM kutya WHERE kutya_nev = '". $id1 ."'");
        return $this->GetKutya($leker);
    }
    function Login($nev, $jelszo)
    {
       global $ip;
       global $_REQUEST;
       $user=mysql_query("SELECT * FROM `kutya` WHERE `kutya_nev` = '". $nev ."' and `kutya_jelszo` = '". $jelszo ."'");
       if(mysql_num_rows($user)==1){
           $this->GetKutyaByNev($nev);
           if($this->oldalroltiltva==0){
             mysql_query("UPDATE `kutya` SET `kutya_belepip` = '". $ip ."' WHERE `kutya_id` = '". $this->id ."'");
            mysql_query("UPDATE `session` SET `nev` = '". $this->nev ."' WHERE `id` = '". $_REQUEST[TIRuserID] ."'");
           }
           return true;
       }else{
          return false;
       }
       
    }
    function NevMegjelenit()
    {
        if($this->nevszin==774411)
        {
             return htmlentities($this->nev);
        }else{
            return '<font color=#'. $this->nevszin .'>'. htmlentities($this->nev) .'</font>';
        
        }
    
    }
    function NevMegjelenitRanggal()
    {
        $rang="";
        if($this->rang>0)
        {
        $rang=" <img src=pic/mod". $this->rang .".gif>";
        }
        $elso=mysql_query("SELECT * FROM egyszampontok ORDER BY egyszampontok_pont DESC limit 0,3");
        for($i=0;$i<3;$i++)
        {
          $gyoztes=mysql_fetch_object($elso);
         if($gyoztes->egyszampontok_kid==$this->id)
         {
                  switch($i)
                  {
                  case 0:
                  $hely="a";
                  break;
                  case 1:
                  $hely="e";
                  break;
                  case 2:
                  $hely="b";
                  break;
                  }
                  $rang.=" <img src=pic/egyszam". $hely .".png>";
         }
        }
            return $this->NevMegjelenit().$rang;
    
    }
    function NevMegjelenitLinkelve()
    {
            return "<a href=kutyak.php?id=". $this->id ." class='feherlink'>".$this->NevMegjelenit() ."</a>";
    }
    function NevMegjelenitRanggalLinkelve()
    {
            return "<a href=kutyak.php?id=". $this->id ." class='feherlink'>".$this->NevMegjelenitRanggal() ."</a>";
    }
    function Kep()
    {
		$kep="<div style=\"position: relative; left: 0; top: 0;\">
					<img src=pic/kutyak/". kutyaszamtofile($this->fajta) . $this->szin .".png style=\"position: relative; top: 0; left: 0;\">";
	
		for($i=0; $i<sizeof($this->targyakHord);$i++)
		{
			$targy = new targy();
			if($targy->GetTargyByID($this->targyakHord[$i]))
			{
				$kep.="<img src=pic/targyak/". kutyaszamtofile($this->fajta) . $targy->file .".png style=\"position: absolute; top: 0; left: 0;\">";
			}
		}

		return $kep . "</div>";
    }
    function SulyCsik($w)
    {
      if($this->suly<25.1){
      $v[0]="szazalekkezdjo";
      $v[1]="szazalekjo";
      $v[2]="szazalekvegjo";
      }elseif ($this->suly>79.9){
      $v[0]="szazalekkezdrossz";
      $v[1]="szazalekrossz";
      $v[2]="szazalekvegrossz";
      }else{
      $v[0]="szazalekkezd";
      $v[1]="szazalek";
      $v[2]="szazalekveg";
      } 

      return "<table border=0 cellpadding=0 cellspacing=0><tr><th width=3 height=12 background=pic/". $v[0] .".JPG></th><th width=". $w ." height=12 background=pic/". $v[1] .".JPG></th><th width=3 height=12 background=pic/". $v[2] .".JPG></th></tr></table>";
    }
    function EgeszsegCsik($w)
    {
      if($this->egeszseg>79){
      $v[0]="szazalekkezdjo";
      $v[1]="szazalekjo";
      $v[2]="szazalekvegjo";
      }elseif ($this->egeszseg<21){
      $v[0]="szazalekkezdrossz";
      $v[1]="szazalekrossz";
      $v[2]="szazalekvegrossz";
      }else{
      $v[0]="szazalekkezd";
      $v[1]="szazalek";
      $v[2]="szazalekveg";
      }
    
      return "<table border=0 cellpadding=0 cellspacing=0><tr><th width=3 height=12 background=pic/". $v[0] .".JPG></th><th width=". $w ." height=12 background=pic/". $v[1] .".JPG></th><th width=3 height=12 background=pic/". $v[2] .".JPG></th></tr></table>";

    }
    function Talak()
    {
     switch($this->kajatipus){
     case 1: 
      $kajatipus="salata";
      break;
     case 2:
      $kajatipus="tal";
      break;
     case 3:
      $kajatipus="fagyi";
      break;
     }
     for($i=0;$i<7;$i++){
      $tal[$i]=1;
     }
     for($i=0;$i<$this->kaja;$i++){
      $tal[$i]=2;
     }
      $talsor="";
      for($i=0;$i<7;$i++){
      $talsor.="<th><img src=pic/". $kajatipus . $tal[$i] .".gif></th>";
      }
      return $talsor;
    }
    function GenMegjelenit()
    {
        global $GENKUTAT;
		global $_SESSION;
        if($this->genkutat==0)
        {       
			if($_SESSION['id']==$this->id)
			{
         $text='<script>
                function genkutatas() {
                if (confirm("Szeretnél génkutatást végezni? (Ára: '. penz($GENKUTAT) .')")) {
                    genkutat();
                }
                }
                </script>';
          $text.="<i>Még nem végeztél génkutatást</i> <a href='javascript:genkutatas()' class='feherlink'><img src=pic/nagyito.png>Kutat</a> <a href=segitseg.php?page=ismerteto#genek class='feherlink'>Mi ez?</a>";
          return $text;
		  }
		  else{
		  return "<i>Még nem végeztél génkutatást</i> <a href=segitseg.php?page=ismerteto#genek class='feherlink'>Mi ez?</a>";
		  }
        }
        else{
            return $this->genek ."  <a href=segitseg.php?page=ismerteto#genek class='feherlink'>Mi ez?</a>";
        }
    
    }
    function GenKutat()
    {
       $this->genkutat=1;
       mysql_query("UPDATE kutya SET kutya_genkutat = '". $this->genkutat ."' WHERE kutya_id = '". $this->id ."'");
       return true;
    }
    function EtetMegjelenit()
    {
      $talak="";
      if($this->kaja!=7){
      $talak.="<td colspan=7 align=left>Adok <select name=kaja style='width:60px;' id='kajaselect'>";
      for($i=1;$i<(8-$this->kaja);$i++){
      $talak.="<option value=". $i .">". $i ." napi</option>";
      }
      $talak.='</select> ételt a kutyámnak. <input type=submit name=elkuld value="Megetetem" style="width:75px;" onclick="megetet()"></td>';
      }
      return $talak;
    }
    function Etet($nap)
    {
      if(($this->kaja+$nap)>7)
      {
      $this->kaja=7;
      }else if(($this->kaja+$nap) < 1)
      {
       return false;
      }
      else{
      $this->kaja+=$nap;
      }
      mysql_query("UPDATE `kutya` SET `kutya_etel` = '". $this->kaja ."' WHERE `kutya_id` = '". $this->id ."'");

      return true;
    }
    function KajaValt($kaja)
    {
       if($kaja>0 and $kaja<4 and $kaja!=$this->kajatipus)
       {
        $this->kajatipus=$kaja;
        mysql_query("UPDATE kutya SET kutya_kajatipus = '". $this->kajatipus ."' WHERE kutya_id = '". $this->id ."'");
        return true;
       }
       return false;
    }
    function Fagyasztas()
    {
      global $FAGYASZTIDO;
      if($this->fagyaszt==0){
      $this->fagyaszt=$FAGYASZTIDO;
      }else{
      $this->fagyaszt=0;
      }
      mysql_query("UPDATE kutya SET kutya_fagyasztva = '". $this->fagyaszt ."' WHERE kutya_id = '". $this->id ."'");
     
    }
    function FagyasztasMegjelenit()
    {
      global $FAGYASZTIDO;
      if($this->fagyaszt==0){
      return "Ha elõre tudod, hogy pár napig nem tudod látogatni a kutyád, akkor fagyaszd le és maximum ". $FAGYASZTIDO ." napig nincs gondod vele.<br><center><input type=submit name=fagyaszt value=Lefagyasztom onclick='fagyaszt()'></center>";
      }else{
      return "Kutyád még ". $this->fagyaszt ." napig vacog a jég fogságában. Talán itt az ideje, hogy újra felébredjen a téli álomból?<br><center><input type=submit name=fagyaszt value=Kiolvasztom onclick='fagyaszt()'></center>";
      }
    }
	function KolyokMegjelenit()
    {
      if(sizeof($this->kolyok)==0){
      return "<td>Nincsenek még kölykeid.</td>";
      }else{
	  $vissz="";
	  for($i=0;$i<sizeof($this->kolyok);$i++)
		{
			 $kutyi=new kutya();
			 $kutyi->getKutyaByID($this->kolyok[$i]);
			 if($i==0){
			 $vissz.=$kutyi->nevMegjelenitLinkelve()." <a href='javascript:nemutat()' class='feherlink'><img src=pic/fel.png width=16 height=16></a><br>";
			 }
			 else{
			 $vissz.=$kutyi->nevMegjelenitLinkelve()."<br>";
			 }
		}
			$adat="<script>
			    function mutat() {
				var adatok=\"". $vissz ."\";
				document.getElementById(\"kolyok\").innerHTML=adatok;
                }
				
				function nemutat() {
				document.getElementById(\"kolyok\").innerHTML=\"<a href='javascript:mutat()' class='feherlink'>Mutasd! <img src=pic/le.png width=16 height=16></a>\";
                }
			</script>
			<td id=\"kolyok\"><a href='javascript:mutat()' class='feherlink'>Mutasd! <img src=pic/le.png width=16 height=16></a></td>";
      return $adat;
	  }
    }
    function Tanult($mit)
    {
      return in_array($mit, $this->tanult);
    }
    function PenzHozzaad($osszeg)
    {
       $this->penz= $this->penz+$osszeg;
	   mysql_query("UPDATE kutya SET kutya_penz = '". $this->penz ."' WHERE kutya_id = '". $this->id ."'");
       return true;
    }
    function PenzElvesz($osszeg)
    {
       if($this->penz-$osszeg<0)
       {
         return false;
       
       }else{
        $this->PenzHozzaad(-1*$osszeg);
        return true;
       
       }   
    }
    function Latogat()
    {
      global $LEGJOBBGAZDANAP;
      $this->legjobbgondozo++; 
       mysql_query("UPDATE kutya SET kutya_legjobbgondozo = '". $this->legjobbgondozo ."' WHERE kutya_id = '". $this->id ."'"); 
      if($this->legjobbgondozo==$LEGJOBBGAZDANAP){
         $this->legjobbgondozo=0;
         mysql_query("UPDATE kutya SET kutya_legjobbgondozo = '0' WHERE kutya_belepip = '". $this->belepip ."'");  
         return true;
      }
      return false;  
    }
  function NemLatogat()
    {
      $this->legjobbgondozo=0; 
      mysql_query("UPDATE kutya SET kutya_legjobbgondozo = '". $this->legjobbgondozo ."' WHERE kutya_id = '". $this->id ."'"); 
    }
    function SendUzenet($kitol, $mit)
    {
      $tilto=mysql_query("SELECT * FROM tilto WHERE tilto_tiltott = '". $kitol ."' and tilto_tilto = '". $this->id ."'");
      if(mysql_num_rows($tilto)==0)
      {     
      $olvas=0;
      if($kitol==0){ $olvas=1;} 
      mysql_query("INSERT INTO `uzenetek` VALUES ('', '". $mit ."', '". $kitol ."', '". $this->id ."', NOW(), 0, 0, ". $olvas .", 0)");
      return true;
      }
      return false;
        
    }
    function SetRang($rang)
    {
            mysql_query("DELETE FROM  moderator WHERE mod_kutya = '". $this->id ."'");
            if($rang==0)
            {
                $this->rang=0;
            }
            else if($rang>0 && $rang<4)
            {
                $this->rang=$rang;
                mysql_query("INSERT INTO moderator VALUES ('". $this->id ."','". $this->rang ."')");
            }
            else
            {
                return false;
            }
      return true;
    }
    function EgyszamPont($pont)
    {
      switch($pont){
      case 1:
        return 25;
      case 2:
        return 18;
      case 3:
        return 15;
      case 4:
        return 12;
      case 5:
        return 10;
      case 6:
        return 8;
      case 7:
        return 6;
      case 8:
        return 4;
      case 9:
        return 3;
      case 10:
        return 2;
      default:
        return 1;
      }
    }
    function EgyszamTipp($szam)
    {
      $egyszam=mysql_query("SELECT * from egyszampontok WHERE egyszampontok_kid = '". $this->id ."'");
       if(mysql_num_rows($egyszam)==0)
       {
          $this->egyszam=rand(1,75);
          mysql_query("INSERT INTO egyszampontok VALUES('". $this->id ."','". $this->egyszam ."', '0', '0', '1','75')");
          $this->egyszamproba=0;
          $this->egyszampont=0;
          
       }
      $this->egyszamproba++;
      if($this->egyszam==$szam){
      $this->egyszampont+=$this->EgyszamPont($this->egyszamproba);
      $this->egyszamproba=-1;
      mysql_query("UPDATE `egyszampontok` SET `egyszampontok_tipp` = '". $this->egyszamproba ."', `egyszampontok_pont` = '". $this->egyszampont ."' WHERE `egyszampontok_kid` = '". $this->id ."'");
      return "<br>Eltaláltad!!!";
      }elseif($this->egyszam<$szam){
       mysql_query("UPDATE `egyszampontok` SET `egyszampontok_tipp` = '". $this->egyszamproba ."', `egyszampontok_pont` = '". $this->egyszampont ."', `egyszampontok_max` = '". $szam ."' WHERE `egyszampontok_kid` = '". $this->id ."'");
      $this->egyszammax=$szam;
	  return "Nem jó! Ennél kisebbet próbálj!";
      }else{
      mysql_query("UPDATE `egyszampontok` SET `egyszampontok_tipp` = '". $this->egyszamproba ."', `egyszampontok_pont` = '". $this->egyszampont ."', `egyszampontok_min` = '". ($szam+1) ."' WHERE `egyszampontok_kid` = '". $this->id ."'");
      $this->egyszammin=($szam+1);
	  return "Nem jó! Ennél nagyobbat próbálj!";
      }
 
 
      
    }
    function EgyszamMegjelenit($szoveg)
    {
    if($this->Tanult("SZ")){
    $egyszam="<br>Gondoltam egy számra egy és 75 között...Találd ki! Minél kevesebb tippbõl találod ki annál több pontot ér. <a href=segitseg.php?page=ismerteto#egyszam class='feherlink'>Részletek...</a><br><br>";
    if($this->egyszamproba!=-1){
    $egyszam.="<center><select id=egyszamselect style='width: 38px;'>";
    for($i=$this->egyszammin;$i<$this->egyszammax;$i++){$egyszam.="<option value". $i .">". $i ."</option>";}
      $egyszam.="</select> <input type=submit name=rendben value=Tippelek style='width: 80px;' onclick='egyszam()'></center>";
    }
    $egyszam.="<br><center>Eheti pontszám: ". $this->egyszampont."</center>";
    $egyszam.=hiba($szoveg);
    }else{
    $egyszam="Ahhoz, hogy tudj játszani az egyszám játékkal ismerned kell a számokat. Tanítsd meg a számokat leckét a kutyádnak!<br>";
    }
    $egyszam.="<br><center><a href=egyszamstat.php class='feherlink'>Egyszám statisztika</a></center>";
    return $egyszam;
    }
    function TiltOldalrol($ki, $ido)
    {  
        if($ido==0){
                  mysql_query("DELETE FROM oldaltilt WHERE oldaltilt_kid = '". $this->id ."'");
                  return true;
        }else{
        $tilte=mysql_query("SELECT * FROM oldaltilt WHERE oldaltilt_kid = '". $this->id ."'");
        if(mysql_num_rows($tilte)==0){
         $this->oldalroltiltva=$ido;
         mysql_query("INSERT INTO oldaltilt VALUES (". $this->id .", ". $ki .", ". $ido .")");
         mysql_query("DELETE FROM session WHERE nev = '". $this->nev ."'");
         return true;
        }
        }
        return false;
    }
  
	function VanTargy($targyID)
	{
		return in_array($targyID, $this->targyak);
	}
	
	function RajtavanTargy($targyID)
	{
		return in_array($targyID, $this->targyakHord);
	}
	
	function TargyHozzaAdd($targyID)
	{
		$ujTargy = new targy();
		
		if($ujTargy->GetTargyByID($_GET[targyid]))
		{
			if($ujTargy->AlkalmasFajta($this->fajta) && !$this->VanTargy($targyID))
			{
				mysql_query("INSERT INTO `kutyatargyak` VALUES ('". $this->id ."', '". $targyID ."', '1')");
				array_push($this->targyak, $targyID);
				array_push($this->targyakHord, $targyID);
				return true;
			}
		}
		return false;
	}
	
	function TargyLeVesz($targyID)
	{
		if($this->RajtavanTargy($targyID) && $this->VanTargy($targyID))
		{
			mysql_query("UPDATE `kutyatargyak` SET kutyatargyak_hord = '0' WHERE kutyatargyak_kutyaid = '". $this->id ."' and kutyatargyak_targyid = '". $targyID ."'");
			if(($key = array_search($targyID, $this->targyakHord)) !== false) {
				unset($this->targyakHord[$key]);
			}
			return true;
		}
		return false;
	}
	
	function TargyFelVesz($targyID)
	{
		if(!$this->RajtavanTargy($targyID) && $this->VanTargy($targyID))
		{
			mysql_query("UPDATE `kutyatargyak` SET kutyatargyak_hord = '1' WHERE kutyatargyak_kutyaid = '". $this->id ."' and kutyatargyak_targyid = '". $targyID ."'");
			array_push($this->targyakHord, $targyID);
			return true;
		}
		return false;
	}
	
  }   
  class lotto
  {
	var $nyeremeny=0;
	   
	function lotto() {
	   $handle = fopen("data/lottonyeremeny.txt", "r");
	   $this->nyeremeny=fread($handle, filesize("data/lottonyeremeny.txt"));
	   fclose($handle);
    }
  }
  
  class targy
  {
	var $ar=0;
	var $fajta;
	var $file;
  
	function GetTargyByID($id1) {
        include("sql.php");
        $leker=mysql_query("SELECT * FROM targyak WHERE targyak_id = '". $id1 ."'");
        if(mysql_num_rows($leker)>0)
        {
            while($adatok=mysql_fetch_object($leker))
            {
              $this->ar=$adatok->targyak_ar;
			  $this->file=$adatok->targyak_file;
              $this->fajta=explode("|", $adatok->targyak_fajta);
            }
			return true;
		}
		return false;
    }
	
	function AlkalmasFajta($mit)
	{
		 return in_array($mit, $this->fajta);
	}
  }
?>
