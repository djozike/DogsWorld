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


function blogbeallitas(){
var blogiras = 0;
if(document.getElementById("iraslecke").checked)
{
	blogiras = 1;
}
AjaxAdatKuld("inc/ajax.php?blognap="+document.getElementById("blognapok").value+"&blogiras="+blogiras, function(){ 
    var valasz=arguments[0].split("|");
    if(valasz.length==2){
        document.getElementById("blognapok").value=valasz[0];
		if(valasz[1]==1)
		{
			document.getElementById("iraslecke").checked=true;
		}
		else
		{
			document.getElementById("iraslecke").checked=false;
		}
		    alert("Sikeres mentés!");
        }  
    else{
    alert(xmlhttp.responseText);
    }
});

}

function penzKuldes(){
AjaxAdatKuld("inc/ajax.php?kutya="+document.getElementById("kutya").value.replace(" ","SPACE")+"&penz="+document.getElementById("penz").value, function(){ 
document.getElementById("penzKuldesUzenet").innerHTML=arguments[0];
document.getElementById("kutya").value="";
document.getElementById("penz").value="";
});

}

function penzKuldesekMutat() {
	var obj = document.getElementById("penzKuldesek");
	var obj2 = document.getElementById("penzKuldesekSzoveg");
	if (obj.style.display == "none") {
		obj.style.display = "block";
		obj2.innerHTML="Eddigi pénzküldések elrejtése";
	}
	else 
	{
		obj.style.display = "none";
		obj2.innerHTML="Eddigi pénzküldések megmutatása";
	}
}
	