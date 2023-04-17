<?php require_once('../../../session_user.php');
$venta   = $_SESSION['venta'];
require_once('../../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once('../../../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $desemp?></title>
<link href="../../../../css/style.css" rel="stylesheet" type="text/css" />
<link href="css/autocomplete.css" rel="stylesheet" type="text/css" />
<?php require_once('../../../../funciones/funct_principal.php');
require_once('../../../../funciones/highlight.php');	//ILUMINA CAJAS DE TEXTOS
require_once('../../../../funciones/botones.php');	//COLORES DE LOS BOTONES
?>
<script type="text/javascript" src="funciones/ajax.js"></script>
<script type="text/javascript" src="funciones/ajax-dynamic-list.js"></script>
<script type="text/javascript">
function fc(){
document.form1.country.focus();
}
function asigna()
{
  var f = document.form1;
  if (f.country.value == "")
  { alert("Ingrese el nombre del Cliente"); f.country.focus(); return; }
  f.method = "post";
  f.submit();
}
function save_cliente(){
  var f = document.form1;
  if (f.nom.value == "")
  { alert("Ingrese el nombre del Cliente"); f.nom.focus(); return; }
  ventana=confirm("Desea Grabar este Cliente");
  if (ventana) {
  f.method = "post";
  f.action ="cliente_reg.php";
  f.submit();
  }
}
function cerrar_popup()
{
window.close()
}
</script>

<style type="text/css">
<!--
body {
	background-color: #FFFFCC;
}
-->
</style>
</head>
<?php $val = $_REQUEST['val'];
if ($val == 1)
{
	$codcli = $_REQUEST['country_ID'];
	$sql="SELECT * FROM cliente where codcli = '$codcli'";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	while ($row = mysqli_fetch_array($result)){
		$codcli         = $row["codcli"];
		$descli         = $row["descli"];
		$dnicli         = $row["dnicli"];
		mysqli_query($conexion, "UPDATE venta set cuscod = '$codcli' where invnum = '$venta'");
		mysqli_query($conexion, "UPDATE temp_venta set cuscod = '$codcli' where invnum = '$venta'");
	}
	}
}
$sql="SELECT * FROM venta where invnum = '$venta'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$invnum       = $row['invnum'];		//codgio
		$nrovent      = $row['nrovent'];
		$invfec       = $row['invfec'];
		$cuscod       = $row['cuscod'];
		$usecod       = $row['usecod'];
		$codven       = $row['codven'];
		$forpag       = $row['forpag'];
		$fecven       = $row['fecven'];
}
}
$sql="SELECT * FROM cliente where codcli = '$cuscod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$codcli         = $row["codcli"];
	$descli         = $row["descli"];
}
}
function formato($c) {
printf("%08d",  $c);
} 
?>

<body onload="fc()">
<form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">
  <table width="565" border="0">
    <tr>
      <td width="74" valign="top">NRO DE VENTA </td>
      <td width="481" valign="top">
      <input type="text" name="textfield" disabled="disabled" value="<?php echo formato($invnum)?>"/>      </td>
    </tr>
    <tr>
      <td valign="top">CLIENTE</td>
      <td valign="top">
	  <input name="country" type="text" id="country" onkeyup="ajax_showOptions(this,'getCountriesByLetters',event)" size="52" onclick="this.value=''"/>
          <input type="hidden" id="country_hidden" name="country_ID">
          <input name="val" type="hidden" id="val" value="1" />
          <input name="button" type="button" value="ASIGNAR" onclick="asigna()"/>
          <input type="button" name="Submit2" value="CERRAR VENTANA" onclick="cerrar_popup()"/>      
	  </td>
    </tr>
  </table>
  <img src="../../../../images/line2.png" width="570" height="4" />
  <table width="399" border="0">
    <tr>
      <td><strong>NUEVO CLIENTE </strong></td>
    </tr>
  </table>
  <table width="565" border="0">
    <tr>
      <td width="74">NOMBRE</td>
      <td width="481">
        <input name="nom" type="text" id="nom" size="60" onKeyUp="this.value = this.value.toUpperCase();"/>
      </td>
    </tr>
    <tr>
      <td>DNI</td>
      <td>
        <input name="dni" type="text" id="dni" onKeyPress="return acceptNum(event)" maxlength="8"/>
      </td>
    </tr>
    <tr>
      <td>RUC</td>
      <td>
        <input name="ruc" type="text" id="ruc" onKeyPress="return acceptNum(event)"/>
      </td>
    </tr>
    <tr>
      <td>TELEFONO 1 </td>
      <td>
        <input name="fono" type="text" id="fono" onKeyPress="return acceptNum(event)"/>
      </td>
    </tr>
    <tr>
      <td>TELEFONO 2 </td>
      <td>
        <input name="fono1" type="text" id="fono1" onKeyPress="return acceptNum(event)"/>
      </td>
    </tr>
    <tr>
      <td>EMAIL</td>
      <td>
        <input name="mail" type="text" id="mail" size="45" />
        <input type="button" name="Submit" value="GRABAR" onclick="save_cliente()"/>
      </td>
    </tr>
  </table>
</form>
</body>
</html>
