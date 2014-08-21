function KapottPenz(szazalek)
{
  for (var i=0; i<document.getElementById("penzselect").options.length; i++){
  if (document.getElementById("penzselect").options[i].selected==true){
  penz= document.getElementById("penzselect").options[i].value*100;
  break
  }
  }
  kapottpenz=penz*szazalek;
  if(kapottpenz==0){
  kiir="0 csont";
  }else{
  csont=kapottpenz/100;
  csont= parseInt(csont);
  ossa=kapottpenz-(csont*100);
  if(csont==0){
  kiir=ossa+" ossa";
  }else{
  if(ossa==0){
  kiir=csont+" csont";
  }else{
  kiir=csont+" csont "+ossa+" ossa";
  }
  }
  }
  document.getElementById("megerkezoosszeg").innerHTML=kiir;

}