<?php include('../../session_user.php');
$ord_compra   = $_SESSION['ord_compra'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/tabla2.css" rel="stylesheet" type="text/css" />
<?php require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
//require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once ('funciones/datos_generales.php'); //////CODIGO Y NOMBRE DEL LOCAL
require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
?>
<?php function formato($c) {
printf("%08d",$c);
} 
$cod	 = $_REQUEST['cod'];
$sql="SELECT invnum,observacion FROM ordmov where invnum = '$ord_compra' and codpro = '$cod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    	$invnum         = $row['invnum'];
		$observacion    = $row['observacion'];
}
}
$sql="SELECT nrocomp FROM ordmae where invnum = '$invnum'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    	$nrocomp        = $row['nrocomp'];
}
}
$sql="SELECT desprod FROM producto where codpro = '$cod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    	$desprod        = $row['desprod'];
}
}
?>
<script>
function cerrar(e){
tecla=e.keyCode
	if (tecla == 27)
	{
	window.close();
	}
}
</script>
<title><?php echo $desprod?></title>
<script>
function cerrar_popup(valor,marca)
{
var prod = valor;
var marc = marca;
document.form1.target = "mark";
window.opener.location.href="salir1.php?prod="+prod+"&marca="+marc;
self.close();
}
function fc()
{
document.form1.obs.focus();
}
function grabar()
{
var f = document.form1;
	if (f.obs.value == "")
	{ 
	alert("INGRESE UNA OBSERVACION");f.obs.focus();
	}
	f.method = "post";
	f.action = "observacion1.php";
	f.submit();
}
</script>
<?php /*?><link href="../css/tablas.css" rel="stylesheet" type="text/css" /><?php */?>
<style type="text/css">
<!--
.Estilo1 {color: #FFFFFF}
</style>
</head>

<body onkeyup="cerrar(event)" onload="fc();">
<form name="form1" id="form1" onKeyUp="highlight(event)" onClick="highlight(event)">
  <table width="527" border="0" class="tabla2">
    <tr>
      <td width="519"><table width="514" border="0">
        <tr>
          <td width="81">COMPRA</td>
          <td width="423"><?php echo formato($invnum)?></td>
        </tr>
        <tr>
          <td>PRODUCTO</td>
          <td><?php echo $desprod?></td>
        </tr>
        <tr>
          <td>OBSERVACION</td>
          <td>
            <textarea name="obs" cols="70" id="obs" onKeyUp="this.value = this.value.toUpperCase();"><?php echo $observacion?></textarea>
          </td>
        </tr>
      </table>
        <table width="514" border="0">
          <tr>
            <td width="81">&nbsp;</td>
            <td width="423">
              <input name="codpro" type="hidden" id="codpro" value="<?php echo $cod?>" />
              <input type="button" name="Submit" value="Grabar" onclick="grabar()" class="grabar"/>
            </td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
</body>
</html>
