<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
include('../../session_user.php');
include('../../local.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="css/style1.css" rel="stylesheet" type="text/css" />
<link href="css/tabla2.css" rel="stylesheet" type="text/css" />
<?php require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUME
require_once('detecta_ip.php');
?>
<?php
$ok = $_REQUEST['ok'];
$error = $_REQUEST['error'];
if ($ok == 1)
{
	$desc = "SE LOGRO GRABAR EXITOSAMENTE ESTE IP";
	$color = "#0066CC";
}
if ($error == 2)
{
	$desc = "NO SE PUDO GRABAR YA QUE ESTA IP EXISTE EN EL SISTEMA";
	$color = "#990000";
}

$sql="SELECT nlicencia FROM datagen ";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	   $nlicencia       = $row['nlicencia'];
}
}
?>
<script>
function salir()
{
	 var f = document.form1;
	 f.method = "POST";
	 f.target = "_top";
	 f.action ="../../index.php";
	 f.submit();
}
function grabar()
{
	 var f = document.form1;
	 f.method = "post";
	 f.action ="graba_ip.php";
	 f.submit();
}
function descargar()
{
  var f = document.form1;
  f.method = "POST";
  f.action ="index2.php";
  f.submit();
}
</script>
</head>
<body onload="sf();">
<div align="left"><img src="../../../images/line2.png" width="500" height="4" /></div>
<br /><?php if ($desc  <> ''){?><font color="<?php echo $color?>"><?php echo $desc;?></font><br /><?php }?>
<form name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)">
  <table width="507" border="0">
    <tr>
      <td width="501"><table width="478" border="0">
        <tr>
          <td><strong>IP  de Local </strong></td>
          <td><?php echo $detect_ip;?></td>
          <td><div align="right">
              <input name="exit" type="button" id="exit" value="Grabar" onclick="grabar()" class="salir"/>
              <input name="exit" type="button" id="exit" value="Salir" onclick="salir()" class="salir"/>
          </div></td>
        </tr>
        <tr>
          <td width="81"><strong>Local </strong></td>
          <td width="160">
		  <select name="local" id="local" class="s1">
			<?php $sql = "SELECT codloc,nomloc FROM xcompa order by codloc ASC LIMIT $nlicencia"; 
				$result = mysqli_query($conexion,$sql); 
				if (mysqli_num_rows($result)){
				while ($row = mysqli_fetch_array($result)){ 
			?>
			<option value="<?php echo $row[0]?>"><?php echo $row[1] ?></option>
			<?php }
				}
				else
				{
			?>
			<option value="0">NO EXISTEN LOCALES REGISTRADOS</option>
			<?php }
			?>
         	 </select>
			 </td>
          <td width="223"><div align="right"></div></td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
<div align="left"><img src="../../../images/line2.png" width="500" height="4" /></div>
</body>
</html>
