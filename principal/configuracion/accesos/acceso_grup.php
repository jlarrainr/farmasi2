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
require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
?>
<script language="JavaScript">
function graba()
{
var f = document.form1;
if (f.grup.value == "")
{ alert("Ingrese el Nombre del Grupo"); f.grup.focus(); return; }
f.method = "post";
f.action ="acceso_grup1.php";
f.submit();
}
function sf(){
document.form1.grup.focus();
}
</script>
<style type="text/css">
<!--
.Estilo1 {color: #0066CC}
-->
</style>
</head>
<?php $val   = $_REQUEST['val'];
$ok    = $_REQUEST['ok'];
$error = $_REQUEST['error'];
$codgrup = $_REQUEST['codu'];
?>
<body onload="sf();">
<table width="489" border="0" align="center">
  <tr>
    <td width="489"><span class="text_combo_select"><strong> <?php  echo "GRUPOS  DE USUARIOS DEL SISTEMA". $codgrup;?></strong></span><img src="../../../images/line2.jpg" width="475" height="4" /></td>
  </tr>
</table>
<?php if ($val == 1)
{
?>
<table width="489" border="0" align="center" class="tabla2">
  <tr>
    <td>
	  <span class="Estilo1">
	  <?php if ($ok == 1)
	{
	echo "SE LOGRO REGISTRAR SATISFACTORIAMENTE UN GRUPO DE USUARIO";
	}
	if ($error == 1)
	{
	echo "NO SE PUDO REGISTRAR EL GRUPO, ESTE YA SE ENCUENTRA REGISTRADO EN EL SISTEMA";
	}
	?>
    </span>	</td>
  </tr>
</table>
<?php }
?>
<table width="489" border="0" align="center" class="tabla2">
  <tr>
    <td><form method = "post" name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)">
      <table width="470" border="0" align="center">
        <tr>
          <td width="112">NOMBRE DEL GRUPO </td>
          <td width="348"><label>
            <input name="grup" type="text" id="grup" size="65" onKeyUp="this.value = this.value.toUpperCase();"/>
          </label></td>
        </tr>
      </table>
        <table width="470" border="0" align="center">
          <tr>
            <td width="112">&nbsp;</td>
            <td width="348"><label>
              <input type="button" name="Submit" value="Grabar" class="grabar" onclick="graba()"/>
            </label></td>
          </tr>
        </table>
    </form>
    </td>
  </tr>
</table>
</body>
</html>
