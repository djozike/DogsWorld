<?php
include("session.php");
include("sql.php");
include("oop.php");
if(isset($_SESSION[id]))
{
	$en=new kutya();
	$en->GetKutyaByID($_SESSION[id]);
	if(( ($BLOGIRASTANULAS==1 and $en->Tanult("IR")) or $BLOGIRASTANULAS==0) and (($BLOGIRASMINNAP!=0 and $BLOGIRASMINNAP <= $en->kor) or $BLOGIRASMINNAP==0))
	{
		if(isset($_GET[id])){
			if($_POST[cim] and $_POST[leiras]!=""){
				if(hosszellenorzes($_POST[cim],0,60)==1){
					$_SESSION[hiba]=hiba("Nem megfelel� hossz� c�m!");
					header("Location: ../ujbejegyzes.php?id=". $_GET[id]);
				}
				else
				{
					mysql_query("UPDATE blog SET blog_ido = NOW(), blog_cim = '". $_POST[cim] ."', blog_bejegyzes = '". $_POST[leiras] ."' WHERE blog_id = '". $_GET[id] ."'");
					header("Location: ../blog.php?blog=". $_GET[id]);
				}
			}
			else
			{
				$_SESSION[hiba]=hiba("Nem t�lt�tt�l ki minden mez�t!");
				header("Location: ../ujbejegyzes.php?id=". $_GET[id]);
			}
		}
		else
		{
			if($_POST[cim] and $_POST[leiras]!=""){
				if(hosszellenorzes($_POST[cim],0,60)==1){
					$_SESSION[hiba]=hiba("Nem megfelel� hossz� c�m!");
					header("Location: ../ujbejegyzes.php");
				}
				else
				{
					mysql_query("INSERT INTO blog VALUES ('', '". $_SESSION[id] ."', NOW(), '". $_POST[cim] ."', '". $_POST[leiras] ."')");
					$lekerid8=mysql_query("SELECT * FROM blog WHERE blog_kutya = '". $_SESSION[id] ."' ORDER BY blog_id DESC limit 1");
					while($kell=mysql_fetch_object($lekerid8))
					{
						header("Location: ../blog.php?blog=". $kell->blog_id);
					}
				}
			}
			else
			{
				$_SESSION[hiba]=hiba("Nem t�lt�tt�l ki minden mez�t!");
				header("Location: ../ujbejegyzes.php");
			}
		}
	}
	else
	{
			header("Location: ../index.php");
	}
}
else
{
	header("Location: ../index.php");
}
?>
