function SzinElonezet(kutyanev)
{
  for (var i=0; i<document.getElementById("nevszin").options.length; i++){
  if (document.getElementById("nevszin").options[i].selected==true){
  szin= document.getElementById("nevszin").options[i].style.color;
  break
  }
  }
  
  document.getElementById("elonezet").innerHTML="Elõnézet: <spam id='kutyusnev'>"+kutyanev+"</spam>";
  document.getElementById("kutyusnev").style.color=szin;

}