<?php include('../../../session_user.php');
session_set_cookie_params(0);
session_start();
$venta   	 = $_SESSION['cotiz'];
$search  	 = $_SESSION['searchcot'];
//$search	 	 = $_REQUEST['search'];
$vals	 	 = $_REQUEST['vals'];
$codigo_busk = $_REQUEST['country_ID'];
$cerrado 	 = $_REQUEST['cerrado'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../../../../css/autocomplete.css" rel="stylesheet" type="text/css" />
<style>
 a:link,
 a:visited {
 color: #0066CC;
 border: 0px solid #e7e7e7;
 }
 a:hover {
 background: #fff;
 border: 0px solid #ccc;
 }
 a:focus {
 background-color: #FFFF99;
 color: #0066CC;
 border: 0px solid #ccc;
 }
 a:active {
 background-color: #FFFF99;
 color: #0066CC;
 border: 0px solid #ccc;
 } 
</style>
<?php require_once ('../../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once ('../funciones/datos_generales.php'); //////CODIGO Y NOMBRE DEL LOCAL
require_once("../../../../funciones/botones.php");	//COLORES DE LOS BOTONES
?>
<script>
function cerrar(){
	window.close();
}
function cerrar_popup()
{
//ventana=confirm("Desea Grabar este Cliente");
document.form1.target = "venta_principal";
<?php if (($search == 1) || ($search == 5))
{
?>
window.opener.location.href="salir1.php?add=1&typpe=1&codigo_busk=<?php echo $codigo_busk?>";
<?php }
else
{
?>
window.opener.location.href="salir1.php?&val=1&tipo=2&codigo_busk=<?php echo $codigo_busk?>";
<?php }
?>
self.close();
}
function tarjet(){
document.form1.country.disabled = true;
document.form1.tarjeta.focus();
}
function tarjet1(){
document.form1.country.disabled = false;
document.form1.country.focus();
}
function cerrar(e){
tecla=e.keyCode
	if (tecla == 27)
	{
	window.close();
	}
}
function actualiza()
{
var f = document.form1;
f.action = "tip_busqueda1.php";
f.method = "post";
f.submit();
}
var nav4 = window.Event ? true : false;
function enteres(evt){
	// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
	var key = nav4 ? evt.which : evt.keyCode;
	//alert(tecla);
	if (key == 13)
	{
		if (document.form1.country.value=="")
		{
		alert("Debe Ingresar una descripcion para realizar la Busqueda");document.form1.country.focus(); return;
		}
		document.form1.cerrado.value = 1;
		f.action = "tip_busqueda.php";
		f.method = "post";
		alert("AQUI");
		//f.submit();
	}
	return (key == 37 || key == 39 || (key >= 48 && key <= 57));
}
</script>
<script type="text/javascript" src="../../../../funciones/ajax.js"></script>
<script type="text/javascript" src="../../../../funciones/ajax-dynamic-list.js"></script>
<title>MODULO DE VENTAS</title>
<style type="text/css">
<!--
.Estilo3 {color: #FFFFFF}
body {
	background-color: #FFFFFF;
}
select { width:260px; }
-->
</style>
</head>
<body onload="<?php if ($cerrado == 1){ ?> cerrar_popup()<?php }else{if ($vals == 1){?>tarjet1()<?php }else{?>tarjet()<?php }}?>" onkeyup="cerrar(event)">
<form name="form1">
  <table width="675" border="0">
    <tr>
      <td bgcolor="#50ADEA"><span class="Estilo3">TIPO</span></td>
      <td><?php if ($search == "")
	  {
	  $nn = 1;
	  }
	  else
	  {
	  $nn = 0;
	  }
	  ?>
          <select name="tarjeta" id="tarjeta">
            <option value="1" <?php if (($search == 1) || ($nn == 1)){?> selected="selected"<?php }?>>Busqueda por Nombre</option>
            <option value="2" <?php if ($search == 2){?> selected="selected"<?php }?>>Busqueda por Familia</option>
            <option value="3" <?php if ($search == 3){?> selected="selected"<?php }?>>Busqueda por Uso</option>
            <option value="4" <?php if ($search == 4){?> selected="selected"<?php }?>>Busqueda por Marca</option>
            <option value="5" <?php if ($search == 5){?> selected="selected"<?php }?>>Busqueda por Codigo</option>
            <option value="6" <?php if ($search == 6){?> selected="selected"<?php }?>>Busqueda por Presentacion</option>
          </select>
          <input type="button" name="Submit" value="Actualizar" onclick="actualiza()"/>
      </td>
    </tr>
    <tr>
      <td width="82" bgcolor="#50ADEA"><span class="Estilo3">BUSQUEDA</span></td>
      <td width="583">
	  <input name="country" type="text" class="busk" id="country" onkeypress="enteres(event)" onkeyup="ajax_showOptions(this,'getCountriesByLetters',event)" value="" size="90"/>
      <input name="cerrado" type="hidden" id="cerrado" />
      <input type="hidden" id="country_hidden" name="country_ID" />
	  </td>
    </tr>
  </table>
</form>
</body>
</html>
