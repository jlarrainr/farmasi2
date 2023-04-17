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
//require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");	//DESHABILITA TECLAS
require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
?>
<script language="JavaScript">
function graba()
{
var f  = document.form1;
if (f.items.value == "")
{ alert("Ingrese el Nombre del Usuario"); f.items.focus(); return; }
if (f.menu.value == "")
{ alert("Ingrese el Login del Usuario"); f.menu.focus(); return; }
f.method = "post";
f.action ="acceso_user1.php";
f.submit();
}
function sf(){
document.form1.item.focus();
}
</script>
<style type="text/css">
<!--
.Estilo1 {color: #0066CC}
-->
</style>
</head>
<?php $codgrup = $_REQUEST['codgrup'];
$sql="SELECT nomgrup FROM grupo_user where codgrup = '$codgrup'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	   $nomgrup       = $row['nomgrup'];
}
}
?>
<body onload="sf();">
<table width="584" border="0" align="center">
  <tr>
    <td width="578">
	<span class="text_combo_select"><strong> ACCESOS DEL GRUPO  <?php echo $nomgrup?></strong></span>
	</td>
  </tr>
</table>
<table width="584" border="0" align="center" class="tabla2">
  <tr>
    <td>
	<center>
	<iframe src="acceso_grup_edit1.php?codgrup=<?php echo $codgrup?>" name="iFrame1" width="566" height="488" scrolling="Automatic" frameborder="No" id="iFrame1" allowtransparency="True">
	</iframe>
	</center>
	</td>
  </tr>
</table>
<table>
 <tr>
      <td class="text_combo_select" style="color:red;"><b>ANTES DE SALIR GRABE LOS CAMBIOS AL FINAL DE LA PAGINA</b></td>
  </tr>
</table>
</body>
</html>
