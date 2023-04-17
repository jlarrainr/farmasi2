<?php include('../../session_user.php');
$ord_compra   = $_SESSION['ord_compra'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="css/style1.css" rel="stylesheet" type="text/css" />
<link href="css/style2.css" rel="stylesheet" type="text/css" />
<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once('../../../convertfecha.php');	//CONEXION A BASE DE DATOS
require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUME
require_once("../../local.php");	//LOCAL DEL USUARIO
function formato($c) {
printf("%06d",$c);
} 
$codpro = $_REQUEST['codpro'];
?>
<link href="css/tabla2.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="190" border="0" class="tabla2">
  <tr>
    <td>
	<table width="186" border="0">
      <tr>
        <td width="87"><span class="text_gris"><b>NUMERO</b></span></td>
        <td width="87"><span class="text_gris"><b>FECHA</b></span></td>
      </tr>
    </table>
	</td>
  </tr>
</table>
<table width="190" border="0" class="tabla2">
  <tr>
    <td>
	<?php if ($codpro <> "")
	{
	$sql="SELECT ordmov.invnum,invfec FROM ordmae inner join ordmov on ordmae.invnum = ordmov.invnum where codpro = '$codpro'";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	?>
	<table width="186" border="0">
	<?php while ($row = mysqli_fetch_array($result)){
				$invnum     = $row[0];
				$invfec     = $row['invfec'];
	}
	?>
      <tr onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
        <td width="87"><?php echo formato($invnum)?></td>
        <td width="87"><?php echo fecha($invfec);?></td>
      </tr>
    </table>
	<?php }
	else
	{
	?>
	<center>ESTE PRODUCTO NO REGISTRA COMPRAS</center>
	<?php }
	}
	?>
	</td>
  </tr>
</table>
</body>
</html>
