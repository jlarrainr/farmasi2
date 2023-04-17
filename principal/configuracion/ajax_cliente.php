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
var nom,ape,clave,contenedor;
//contenedor = document.getElementById('contenedor');
contenedor = document.getElementById('contenedor');
cod = document.getElementById('cliente').value;
ajax=nuevoAjax();
ajax.open("GET", "ajax_cliente1.php?cod="+cod,true);
ajax.onreadystatechange=function() {
if (ajax.readyState==4) {
contenedor.innerHTML = ajax.responseText
}
}
ajax.send(null)
}

</script>