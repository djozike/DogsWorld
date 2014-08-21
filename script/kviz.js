var xmlhttp;
if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
else
  {
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
function AjaxAdatKuld(url, callback)
{
xmlhttp.onreadystatechange = function() {
  if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
    callback(xmlhttp.responseText);
  }
};

xmlhttp.open("GET",url, true);
xmlhttp.send();
}


function elkezd(){
AjaxAdatKuld("inc/lufikuld.php", function(){ 
    var valasz=arguments[0].split("|");
    if(valasz.length==7){
        document.getElementById("kerdes").innerHTML=valasz[0];
		document.getElementById("valasz1").innerHTML=valasz[1];
		document.getElementById("valasz2").innerHTML=valasz[2];
		document.getElementById("valasz3").innerHTML=valasz[3];
		document.getElementById("valasz4").innerHTML=valasz[4];
		document.getElementById("ido").innerHTML="Hátralévõ idõ:"+valasz[5];
		document.getElementById("pont").innerHTML="Pontszám:"+valasz[6];
		document.getElementById("jatek").style.display = "block";

        }  
    else{
    alert(xmlhttp.responseText);
    }
});

}


function valaszol(valasz){
AjaxAdatKuld("inc/lufikuld.php?valasz="+valasz, function(){ 
    var valasz=arguments[0].split("|");
    if(valasz.length==7){
        document.getElementById("kerdes").innerHTML=valasz[0];
		document.getElementById("valasz1").innerHTML=valasz[1];
		document.getElementById("valasz2").innerHTML=valasz[2];
		document.getElementById("valasz3").innerHTML=valasz[3];
		document.getElementById("valasz4").innerHTML=valasz[4];
		document.getElementById("ido").innerHTML="Hátralévõ idõ:"+valasz[5];
		document.getElementById("pont").innerHTML="Pontszám:"+valasz[6];
        }  
    else{
    alert(xmlhttp.responseText);
    }
});

}

window.setInterval(function() {
    AjaxAdatKuld("inc/lufikuld.php?ido=1", function(){ 
		if(document.getElementById("jatek").style.display == "block")
		{
			
			document.getElementById("ido").innerHTML="Hátralévõ idõ:"+arguments[0];
			if (arguments[0] == '0')
			{
				document.getElementById("kerdes").innerHTML="<big>Az idõ lejárt.</big><br><input type=submit value=\"Újra\" onclick=\"elkezd()\">";
				document.getElementById("jatek").style.display = "none";
			}
		}
});
}, 1000);