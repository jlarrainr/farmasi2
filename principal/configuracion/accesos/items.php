<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
<?php require_once ('../../../conexion.php');
require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");	//DESHABILITA TECLAS
require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
?>
<script language="JavaScript">
function graba()
{
var f  = document.form1;
if (f.items.value == "")
{ alert("Ingrese el Nombre del Item"); f.items.focus(); return; }
if (f.nombre.value == "")
{ alert("Ingrese el un nombre para este Item"); f.nombre.focus(); return; }
f.method = "post";
f.action ="items_reg.php";
f.submit();
}
function sf(){
document.form1.items.focus();
}
</script>
<style type="text/css">
<!--
.Estilo1 {color: #0066CC}
-->
</style>
</head>
<body onload="sf();">
<table width="584" border="0" align="center">
  <tr>
    <td width="578">
	<span class="text_combo_select"><strong> ITEMS DEL SISTEMA - <?php echo $nomgrup?></strong></span>
	<img src="../../../images/line2.jpg" width="570" height="4" />
	</td>
  </tr>
</table>
<?php if ($val == 1)
{
?>
<table width="584" border="0" align="center" class="tabla2">
  <tr>
    <td><span class="Estilo1">
      <?php if ($ok == 1)
	{
	echo "SE LOGRO REGISTRAR SATISFACTORIAMENTE UN USUARIO";
	}
	if ($error == 1)
	{
	echo "NO SE PUDO REGISTRAR EL USUARIO, ESTE YA SE ENCUENTRA REGISTRADO EN EL SISTEMA";
	}
	?>
    </span> </td>
  </tr>
</table>
<?php }
?>
<table width="584" border="0" align="center" class="tabla2">
  <tr>
    <td>
	<form id="form1" name="form1" onClick="highlight(event)" onKeyUp="highlight(event)">
      <table width="552" border="0" align="center">
        <tr>
          <td width="148">ITEM</td>
          <td width="394">
            <input name="items" type="text" id="items" size="20" onKeyUp="this.value = this.value.toUpperCase();"/>          </td>
        </tr>
        <tr>
          <td>NOMBRE</td>
          <td><input name="nombre" type="text" id="nombre" size="60" onKeyUp="this.value = this.value.toUpperCase();"/>
            <input type="button" name="Submit" value="Grabar" class="grabar" onclick="graba()"/></td>
        </tr>
      </table>
      </form>
    </td>
  </tr>
</table>
<table width="584" border="0" align="center">
  <tr>
    <td width="578"><span class="text_combo_select"><strong> LISTADO DE OPCIONES DEL SISTEMA </strong></span><img src="../../../images/line2.jpg" width="570" height="4" />	</td>
  </tr>
</table>
<table width="584" border="0" align="center" class="tabla2">
  <tr>
    <td>
	<center>
	<iframe src="items1.php" name="iFrame1" width="566" height="398" scrolling="Automatic" frameborder="No" id="iFrame1" allowtransparency="True">
	</iframe>
	</center>
	</td>
  </tr>
</table>
</body>
</html>
