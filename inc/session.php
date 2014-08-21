<?php
 function mysqlsession_open($aEleresiUt,$asessionNev)
	{
	return True;
	}

 function mysqlsession_close()
	{
	return True;
	}

 function mysqlsession_read($id)
	{
include("sql.php");
 $sql="SELECT * FROM session WHERE id='$id'";
	$aQResult=mysql_query($sql,$kapcsolat);
	if($aQResult==True)
		{
		if(mysql_num_rows($aQResult)>0)
			{
			$aRow=mysql_fetch_array($aQResult);
			return $aRow["tartalom"];
			}else
				{										
				$sql="INSERT INTO session VALUES ('$id',NOW(),'','','". $_SERVER["PHP_SELF"] ."')";																			
				$aQResult=mysql_query($sql,$kapcsolat);				
				return "";
				}
		}
	}

 function mysqlsession_write($id,$tartalom)
	{
include("sql.php");
	$tartalom=addslashes($tartalom);
	$sql="UPDATE session SET date=". time().", tartalom='$tartalom', hely = '". $_SERVER["PHP_SELF"] ."' WHERE id='$id'";
	$aQResult=mysql_query($sql,$kapcsolat);
	return True;
	}

 function mysqlsession_destroy($id)
	{
include("sql.php");
$sql="DELETE FROM session WHERE id='$id'";
	$aQResult=mysql_query($sql,$kapcsolat);
	return True;
	}

 function mysqlsession_gc($aElettartam)
	{
include("sql.php");	$sql= "delete FROM session where date < '" . (time() - 1000) . "'";
	$aQResult=mysql_query($sql,$kapcsolat);
	return True;
	}

session_set_save_handler("mysqlsession_open","mysqlsession_close","mysqlsession_read","mysqlsession_write","mysqlsession_destroy","mysqlsession_gc");
session_name("TIRuserID");
session_cache_limiter("nocache");
session_start();
?>
