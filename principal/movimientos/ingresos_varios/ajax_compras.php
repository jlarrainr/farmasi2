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
var ref;
//contenedor = document.getElementById('contenedor');
ref = document.form1.referencia.value;
ajax=nuevoAjax();
ajax.open("GET", "actualiza_compra.php?ref="+ref,true);
ajax.onreadystatechange=function() {
if (ajax.readyState==4) {
contenedor.innerHTML = ajax.responseText
}
}
ajax.send(null)
}

</script>