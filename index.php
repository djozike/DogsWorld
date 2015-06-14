<? 
include("inc/session.php");
include("inc/functions.php"); 
include("inc/head.php");

if(mysql_num_rows(mysql_query("select * from oldaliptilt WHERE oldaliptilt_ip = '". $ip ."'"))>0){
header("Location: index.html");
}
?> 
	<div style="text-align:center;">
		<div class="main">
			<div style="position:absolute;">
				<div class="logo"></div>
				<div style="position:absolute; top:250px;">
					<div style="position:absolute; top:0px; left:347px; width:535px; height:25px;">
	 			   	<marquee style="color:#774411; font-family:Arial, Helvetica, sans-serif; font-size:18px" onmouseover='stop();' onmouseout='start();'>
					<? uzenofal(); ?>
					</marquee></div>
					<form method=POST action=inc/login.php>
					<input type="text" name=nev class="input" style="position:absolute; left:165px; top:91px;">
					<input type="password" name=jelszo class="input" style="position:absolute; left:165px; top:138px;">
 					<a href="mail.php" class="link" style="position:absolute; left:62px; top:192px;"><b><big>Elfelejtett jelszó</big></b></a>
					<input type="submit" name="OK" value="OK" class="small_btn" style="position:absolute; left:188px; top:172px;">
		 			</form>
					<div style="position:absolute; top:58px; left:375px; width: 470px; height: 150px; text-align: justify; color: black; overflow-y: auto;">
					 <center><big>Üdvözlünk a <? echo $SITENAME;?> oldalon!</big></center><br>
					 Szeretnél egy kutyát, de nem engedik a szüleid? Vagy csak túl sok gond van vele?
				     Nevelj virtuálisan! Mi is ez? A <? echo $SITENAME;?> Magyarország egyik legújabb játéka, ahol
				     az interneten keresztül nevelhetsz egy saját kutyát. Etesd, tanítsd és játssz vele mindennap!
					Regisztrálj és szerezz új barátokat, legyél sikeres falkavezér vagy boldog kutya tulajdonos!
					Mindezt most ingyen.
					</div>
					<div style="position:absolute; top:260px; left:74px;">
					<a href="ujkutya.php" class="button" style="position:absolute; left:30px; top:20px;"><span class="btn_text">Új kutya</span><span class="btn_icon_kutya" style="background:url(pic/kutyafej.gif);">&nbsp;</span></a>
					<a href="szuloknek.php" class="button" style="position:absolute; left:30px; top:95px;"><span class="btn_text">Szülõknek</span><span class="btn_icon" style="background:url(pic/media.gif);">&nbsp;</span></a>
					</div>
					<!-- <div style="position:absolute; top:270px; left:375px;"> -->
					<div style="position:absolute; top:300px; left:400px;">
					<center>
						<div id="fb-root"></div>
						<script>(function(d, s, id) {
						  var js, fjs = d.getElementsByTagName(s)[0];
						  if (d.getElementById(id)) return;
						  js = d.createElement(s); js.id = id;
						  js.src = "//connect.facebook.net/hu_HU/sdk.js#xfbml=1&version=v2.3";
						  fjs.parentNode.insertBefore(js, fjs);
						}(document, 'script', 'facebook-jssdk'));</script>
						<div class="fb-like" data-href="https://www.facebook.com/DogsWord.uw" data-layout="standard" data-action="like" data-show-faces="true" data-share="false"></div>
					</center>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>

<?
if(isset($_SESSION[hiba])){
echo $_SESSION[hiba];
$_SESSION[hiba]="";
}


?>
