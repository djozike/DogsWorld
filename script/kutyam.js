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


function kajavalt(){
var a;
if (document.getElementById("kaja1").checked==true){
a=1;
}else if(document.getElementById("kaja2").checked==true){
a=2;
}else if(document.getElementById("kaja3").checked==true){
a=3;
}else{
a=0;
}

AjaxAdatKuld("inc/kajavalt.php?kaja="+a, function(){
    var valasz=arguments[0].split("|"); 
    if(valasz.length!=3){
    document.getElementById("kiiras").innerHTML=valasz[0];
    }
    if(valasz.length==3)
    {
      document.getElementById("penz").innerHTML=valasz[1];
      document.getElementById("talak").innerHTML=valasz[2];
      kajavaltablak();
    }
});

}

function genkutat(){
AjaxAdatKuld("inc/genkutat.php", function(){ 
    var valasz=arguments[0].split("*");
    if(valasz.length==2){
        document.getElementById("penz").innerHTML=valasz[0];
        document.getElementById("genek").innerHTML=valasz[1];
        }  
    else{
    alert(xmlhttp.responseText);
    }
});

}

function fagyaszt(){
AjaxAdatKuld("inc/fagyaszt.php", function(){ 
document.getElementById("fagyaszt").innerHTML=arguments[0];
});
}

function egyszam(){
AjaxAdatKuld("inc/egyszam.php?egyszam="+document.getElementById("egyszamselect").options[document.getElementById("egyszamselect").selectedIndex].text, function(){ 
document.getElementById("egyszamjatek").innerHTML=arguments[0];
});
}

function megetet(){
for (var i=0; i<document.getElementById("kajaselect").options.length; i++){
  if (document.getElementById("kajaselect").options[i].selected==true){
  nap = i;
  break;
  }
}
nap++;

AjaxAdatKuld("inc/etet.php?kaja="+nap, function(){ 
     var valasz=arguments[0].split("|");
  if(valasz.length==2){
   document.getElementById("talak").innerHTML=valasz[0];
   document.getElementById("etet").innerHTML=valasz[1];
   document.getElementById("kajakiir").innerHTML=parseInt(document.getElementById("kajakiir").innerHTML)+nap;
    }
});  
}

function kajavaltablak()
{
if(document.getElementById("light").style.display=='block'){
document.getElementById("light").style.display='none';
document.getElementById("fade").style.display='none';
}
else{
document.getElementById("light").style.display='block';
document.getElementById("fade").style.display='block';
}
}

function megjelenit(ablaknev)
{
if(document.getElementById(ablaknev).style.display=='block'){
document.getElementById(ablaknev).style.display='none';
document.getElementById("fade").style.display='none';
}
else{
document.getElementById(ablaknev).style.display='block';
document.getElementById("fade").style.display='block';
}
}

function targyvesz(mit)
{
AjaxAdatKuld("inc/ajax.php?targyid="+mit, function(){ 
     var valasz=arguments[0].split("|");
	if(valasz.length==2){
		document.getElementById("penz").innerHTML=valasz[0];
		document.getElementById("kep").innerHTML=valasz[1];
		document.getElementById("megvesz"+mit).style.display='none';
		document.getElementById("levesz"+mit).style.display='block';
		document.getElementById("targyhiba").innerHTML="";
		megjelenit('targyablak');
    }
	else
	{
		document.getElementById("targyhiba").innerHTML="<br>"+arguments[0];
	}
});  
}

function targylevesz(mit)
{
AjaxAdatKuld("inc/ajax.php?targyleid="+mit, function(){ 
		document.getElementById("kep").innerHTML=arguments[0];
		document.getElementById("levesz"+mit).style.display='none';
		document.getElementById("felvesz"+mit).style.display='block';
		document.getElementById("targyhiba").innerHTML="";
		megjelenit('targyablak');
});  
}

function targyfelvesz(mit)
{
AjaxAdatKuld("inc/ajax.php?targyfelid="+mit, function(){ 
		document.getElementById("kep").innerHTML=arguments[0];
		document.getElementById("felvesz"+mit).style.display='none';
		document.getElementById("levesz"+mit).style.display='block';
		document.getElementById("targyhiba").innerHTML="";
		megjelenit('targyablak');
});  
}
