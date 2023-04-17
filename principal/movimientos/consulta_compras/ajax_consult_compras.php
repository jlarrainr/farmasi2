<script language="javascript">

function nuevoAjax(){
var xmlhttp=false;
 try {
  xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
 } catch (e) {
  try {
   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  } catch (E) {
   xmlhttp = false;
  }
 }

if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
  xmlhttp = new XMLHttpRequest();
}
return xmlhttp;
}
function cargarContenido(){
////SUMAR DIA FECHA///////
  var num=document.form1.plazo.value; 
  f  =document.form1.fecha1.value; 
  // pasaremos la fecha a formato mm/dd/yyyy 
  f=f.split('-'); 
  f=f[0]+'/'+f[1]+'/'+f[2];
  // 
  var hoy=new Date(f); 
  hoy.setTime(hoy.getTime()+num*24*60*60*1000); 
  var mes=hoy.getMonth()+1; 
  if(mes<9) mes='0'+mes; 
  fecha=hoy.getFullYear()+'-'+mes+'-'+hoy.getDate(); 
  document.form1.fecha3.value =fecha; 
////////////////////////////////////
var date1,plazo,n1, n2,moneda,date2,contenedor;
//contenedor = document.getElementById('contenedor');
date1 = document.getElementById('fecha1').value;
date2 = document.getElementById('fecha3').value;
plazo = document.getElementById('plazo').value;
n1 = document.getElementById('n1').value;
n2 = document.getElementById('n2').value;
moneda = document.getElementById('moneda').value;
ajax=nuevoAjax();
ajax.open("GET", "actualiza_consult_compra.php?plazo="+plazo+"&n1="+n1+"&n2="+n2+"&moneda="+moneda+"&date1="+date1+"&date2="+date2,true);
ajax.onreadystatechange=function() {
if (ajax.readyState==4) {
contenedor.innerHTML = ajax.responseText
}
}
ajax.send(null)
}

</script>