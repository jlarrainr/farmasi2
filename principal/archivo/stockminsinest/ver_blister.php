<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<link href="css/tabla2.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
//require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");	//DESHABILITA TECLAS
require_once ('funciones/datos_generales.php'); //////CODIGO Y NOMBRE DEL LOCAL
require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
$cod	 = $_REQUEST['cod'];
$cr  	 = $_REQUEST['cr'];
$sql="SELECT desprod,blister,codmar FROM producto where codpro = '$cod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
			$desprod        = $row['desprod'];
			$blister        = $row['blister'];
			$codmar         = $row['codmar'];
}
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $desprod?></title>
<script>
function cerrar(e){
tecla=e.keyCode
	if (tecla == 27)
	{
	var f = document.form1;
	var prod = f.codpro.value;
	var marc = f.marca.value;
	var cr   = f.cr.value;
	document.form1.target = "mark";
	window.opener.location.href="salir1.php?prod="+prod+"&marca="+marc+"&cr="+cr;
	self.close();
	}
}
function blist()
{
	var f = document.form1;
	if (f.blister.value == "")
	{
	alert("Debe ingresar un valor"); return;
	}
	else
	{
	f.method = "post";
	f.action = "ver_blister1.php";
	f.submit();
	}
}
var nav4 = window.Event ? true : false;
function numeros1(evt) {
var key = nav4 ? evt.which : evt.keyCode;
	if (key == 13)
	{
	   var f = document.form1;
		if (f.blister.value == "")
		{
		alert("Debe ingresar un valor"); f.blister.focus();return;
		}
		else
		{
		f.method = "post";
		f.action = "ver_blister1.php";
		f.submit();
		}
	}
	else
	{
	return (key <= 13 || (key >= 48 && key <= 57));
	}
}
function carga()
{
document.form1.blister.focus();
}
</script>
</head>

<body onload="carga()" onkeyup="cerrar(event)">
<table width="486" height="80" border="0" class="tabla2">
  <tr>
    <td width="478" >
	<form id="form1" name="form1" >
      <table width="471" border="0">
        <tr>
          <td width="74"><strong>PRODUCTO</strong></td>
          <td width="387"><?php echo $desprod?></td>
        </tr>
        <tr>
          <td><strong>BLISTER</strong></td>
          <td>
          <input name="blister" type="text" id="blister" onkeypress="return numeros1(event);" size="10" maxlength="3" value="<?php echo $blister?>"/>
          <input name="codpro" type="hidden" id="codpro" value="<?php echo $cod?>" />
          <input name="marca" type="hidden" id="marca" value="<?php echo $codmar?>" />
          <input name="cr" type="hidden" id="cr" value="<?php echo $cr?>" />
          <input type="button" name="Submit" value="Actualizar" class="grabar" onclick="blist()"/>
          </td>
        </tr>
      </table>
        </form>
    </td>
  </tr>
</table>
</body>
</html>
