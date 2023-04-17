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
////////////////////////////////////
document.form1.referencia.value = document.form1.referencia.value.toUpperCase();
var ref,local,vendedor,contenedor;
contenedor = document.getElementById('contenedor');
local= document.form1.local.value; 
vendedor = document.form1.vendedor.value; 
ref = document.getElementById('referencia').value;
ajax=nuevoAjax();
ajax.open("GET", "actualiza_transferencia.php?ref="+ref+"&vend="+vendedor+"&local="+local,true);
ajax.onreadystatechange=function() {
if (ajax.readyState==4) {
contenedor.innerHTML = ajax.responseText
}
}
ajax.send(null)
}

</script>