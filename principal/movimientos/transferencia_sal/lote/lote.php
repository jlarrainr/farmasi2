<?php include('../../../session_user.php');
$invnum  = $_SESSION['transferencia_sal'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../css/style.css" rel="stylesheet" type="text/css" />
<link href="autocomplete.css" rel="stylesheet" type="text/css" />
<?php require_once ('../../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once("../../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../../funciones/botones.php");	//COLORES DE LOS BOTONES
$cod	  = $_REQUEST['cod'];
$sql="SELECT desprod,codmar,factor FROM producto where codpro = '$cod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
			$desprod        = $row['desprod'];
			$codmar         = $row['codmar'];
			$factor         = $row['factor'];
			$sql1="SELECT destab FROM titultabladet where tiptab = 'M' and codtab = '$codmar'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
			$marca        = $row1['destab'];
			}
			}
}
}
$sql1="SELECT numlote FROM tempmovmov where invnum = '$invnum' and codpro = '$cod'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1))
{
	$numlote        = $row1['numlote'];
	
}
	$sql2="SELECT vencim FROM movlote where numlote = '$numlote'";
	$result2 = mysqli_query($conexion,$sql2);
	if (mysqli_num_rows($result2)){
	while ($row2 = mysqli_fetch_array($result2)){
	$vencimi        = $row2['vencim'];
	list($m,$ycar) = split( '[/.-]',$vencimi);
	$search = 0;
	}
	}
}
else
{
$search = 1;
}
?>
<script>
function sf()
{
document.form1.country.focus();
}
function limpia()
{
document.form1.country.value = "";
document.form1.country.focus();
}
function verifica()
{
var f = document.form1;
if (f.country.value == "")
{ alert("Ingrese el Numero de Lote"); f.country.focus(); return; }
f.method = "post";
f.action ="verifica.php";
f.submit();
}
function cerrar(e){
tecla=e.keyCode
	if (tecla == 27)
	{
	window.close();
	}
}
</script>
<title><?php echo $desprod?></title>
<link href="../../css/tablas.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo1 {color: #FFFFFF}
.Estilo2 {color: #FF0000}
-->
</style>
</head>

<body onload="sf();" onkeyup="cerrar(event)">
<table width="548" border="0" bgcolor="#FFFF99" class="tabla2">
  <tr>
    <td width="540"><table width="521" border="0" align="center" bgcolor="#FFFF99">
      <tr>
        <td width="73" class="main1_text">DESCRIPCION</td>
        <td width="438"><?php echo $desprod?></td>
      </tr>
      <tr>
        <td class="main1_text">MARCA</td>
        <td><?php echo $marca?></td>
      </tr>
      <tr>
        <td class="main1_text">FACTOR</td>
        <td><?php echo $factor?></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
<form id="form1" name="form1" method="post" action="verifica.php">
  <table class="tabla2" width="548" border="0">
    <tr>
      <td width="540"><table width="521" border="0" align="center">
        <tr>
          <td>INGRESO  DE LOTE DE PRODUCTO </td>
        </tr>
      </table>
      <img src="../../../../images/line2.png" width="540" height="4" />
      <table width="521" border="0" align="center">
        <tr>
          <td width="96">NUMERO DE LOTE </td>
          <td width="415">
            <input name="country" type="text" id="country" size="50" value="<?php echo $numlote?>" onclick="limpia();"/>
            <input name="codpro" type="hidden" id="codpro" value="<?php echo $cod?>"/>
            <input name="save2" type="button" id="save2" value="Asignar" onclick="verifica()" class="grabar"/></td>
        </tr>
        <tr>
          <td>VENCIMIENTO</td>
          <td>
            <input name="mes" type="text" id="mes" size="4" maxlength="2" value="<?php echo $m?>" disabled="disabled"/>
            /
            <input name="years" type="text" id="years" size="10" maxlength="4" value="<?php echo $ycar?>" disabled="disabled"/>            </td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
</body>
</html>
