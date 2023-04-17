<?php include('../../session_user.php');
$invnummovmae = $_SESSION['nota_credito'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">


	<title>Documento sin t&iacute;tulo</title>
	<link href="../css/style.css" rel="stylesheet" type="text/css" />
	<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
	<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
	<?php
	require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
	require_once("../funciones/devolucion.php");	//FUNCIONES DE ESTA PANTALLA
	require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
	require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
	require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
	$invnum = $_REQUEST['invnum'];

	?>
	<style>
		.Estilo2 {
			color: #ff4b0d;
			font-size: 35px;
			/* font-weight: bold; */
		}
	</style>
</head>

<body>

	<?php
	$sql = "SELECT valven,invtot,igv FROM temp_venta2 where invnum = '$invnum' ";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$valvennota         = $row['valven'];
			$invtotnota         = $row['invtot'];
			$igvnota            = $row['igv'];
		}
	}
	?>
	<table width="100%" border="0" align="center">
		<tr>
			<!--              <td width="73">
                <div align="right">V. BRUTO </div>
              </td>
              <td width="132">
                <input name="mont1" class="sub_totales" type="text" id="mont1" onclick="blur()" size="15" value="<?php if ($bruto > 0) { ?> <?php echo $bruto ?> <?php } else { ?>0.00<?php } ?>" /> </td>
              <td width="50">
                <div align="right">DCTOS</div>
              </td>-->
			<!--              <td width="132">
                <input name="mont2" class="sub_totales" type="text" id="mont2" onclick="blur()" size="15" value="0.00"> </td>-->
			<td width="50" class="LETRA">
				<div align="right">V. VENTA </div>
			</td>
			<td width="132">
				<input name="mont3" class="sub_totales" type="text" id="mont3" onclick="blur()" size="15" value="<?php if ($valvennota > 0) { ?> <?php echo $valvennota ?> <?php } else { ?>0.00<?php } ?>" /></td>
			<td width="50" class="LETRA">
				<div align="right">IGV</div>
			</td>
			<td width="132">
				<input name="mont4" class="sub_totales" type="text" id="mont4" onclick="blur()" size="15" value="<?php if ($igvnota > 0) { ?> <?php echo $igvnota ?> <?php } else { ?>0.00<?php } ?>" /></td>
			<td width="50">
				<div align="right" class="LETRA">TOTAL</div>
			</td>
			<td width="112">
				<input name="mont5" class="sub_totales" type="text" id="mont5" onclick="blur()" size="15" value="<?php if ($invtotnota > 0) { ?> <?php echo $invtotnota ?> <?php } else { ?>0.00<?php } ?>" /></td>
		</tr>
	</table>
</body>

</html>