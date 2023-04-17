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
document.form1.nombre.value = document.form1.nombre.value.toUpperCase();
var nom,contenedor;
//contenedor = document.getElementById('contenedor');
contenedor = document.getElementById('contenedor');
nom = document.form1.nombre.value;
ajax=nuevoAjax();
ajax.open("GET", "ajax_user1.php?nom="+nom,true);
ajax.onreadystatechange=function() {
if (ajax.readyState==4) {
contenedor.innerHTML = ajax.responseText
}
}
ajax.send(null)
}

</script>