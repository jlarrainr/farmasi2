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
	<link href="css/tabla2.css" rel="stylesheet" type="text/css" />
	<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
	require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
	require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
	require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUME
	require_once("funciones/compra.php");	//IMPRIMIR-NUME
	require_once("../../local.php");	//LOCAL DEL USUARIO
	$sql = "SELECT nomusu FROM usuario where usecod = '$usuario'";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$user    = $row['nomusu'];
		}
	}
	?>
	<style type="text/css">
		.Estilo1 {
			color: #FF0000
		}

		.Estilo2 {
			color: #0066CC
		}

		.Estilo3 {
			color: #009900
		}

		.Estilo4 {
			color: #0066CC;
			font-weight: bold;
		}

		.Estilo5 {
			color: #666666;
			font-weight: bold;
		}

		#n1 {
			color: #2980b9;
			font-family: Georgia, 'Times New Roman', serif;
			font-size: 12px;
			text-decoration: none;
		}

		#n1:hover {
			color: #1f618c;
			font-family: Georgia, 'Times New Roman', serif;
			font-size: 14px;
			text-decoration: none;
		}

		#n2 {
			color: #9b59b6;
			font-family: Georgia, 'Times New Roman', serif;
			font-size: 12px;
			text-decoration: none;
		}

		#n2:hover {
			color: #723e87;
			font-family: Georgia, 'Times New Roman', serif;
			font-size: 14px;
			text-decoration: none;
		}

		#n3 {
			color: #27ae60;
			font-family: Georgia, 'Times New Roman', serif;
			font-size: 12px;
			text-decoration: none;
		}

		#n3:hover {
			color: #079543;
			font-family: Georgia, 'Times New Roman', serif;
			font-size: 14px;
			text-decoration: none;
		}

		#n2-n {
			color: #7d7d7d;
			font-family: Georgia, 'Times New Roman', serif;
			font-size: 12px;
			text-decoration: none;
		}

		#n3-n {
			color: #7d7d7d;
			font-family: Georgia, 'Times New Roman', serif;
			font-size: 12px;
			text-decoration: none;
		}
	</style>
	<?php $tip = $_REQUEST['tip'];
	if ($tip == 1) {
		$dir = 'busca_prov/proveedor.php';
	} else {
		if ($tip == 2) {
			$dir = 'busca_marca/marcas.php';
		} else {
			if ($tip == 3) {
				$codpro = $_REQUEST['codpro'];
				$val    = $_REQUEST['val'];
				$dir = 'productos.php?codpro=$codpro';
			} else {
				$dir = 'busca_prov/proveedor.php';
			}
		}
	}
	$sql = "SELECT invnum,provee FROM ordmae where codusu = '$usuario' and estado ='1'";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$invnum    = $row['invnum'];
			$provee    = $row['provee'];
		}
	}
	$_SESSION['ord_compra']			= $invnum;
	$sql = "SELECT invnum FROM temp_marca where invnum = '$ord_compra'";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		$marca_act = 1;
	} else {
		$marca_act = 0;
	}
	?>
</head>

<body>
	<form name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)">
		<table width="100%" border="0">
			<tr>
				<td width="100%">
					<table width="100%" border="0" class="tabla2">
						<tr align="center">

							<td width="32%">
								<a id="n1" href="ocompra_index1.php?tip=1"><?php if (($tip == 1) || ($tip == "")) { ?><b>DATOS DEL PROVEEDOR</b><?php } else { ?>DATOS DEL PROVEEDOR<?php } ?></a>
							</td>
							<td width="32%">
								<?php if ($provee <> 0) { ?><a id="n2" href="ocompra_index1.php?tip=2"><?php if ($tip == 2) { ?><b>MARCA DE PRODUCTOS</b><?php } else { ?>MARCA DE PRODUCTOS<?php } ?></a><?php } else { ?><a id="n2-n">MARCA DE PRODUCTOS</a> <?php } ?>
							</td>
							<td width="32%">
								<?php if (($provee <> 0) and ($marca_act == 1)) { ?><a id="n3" href="ocompra_index1.php?tip=3"><?php if ($tip == 3) { ?><b>DATOS DEL PRODUCTO</b><?php } else { ?>DATOS DEL PRODUCTO<?php } ?></a><?php } else { ?><a id="n3-n">DATOS DEL PRODUCTO</a> <?php } ?>
							</td>

							<td width="4%">
								<div align="right">
									<input name="exit" type="button" id="exit" value="Salir" onclick="salir1()" class="salir" />
								</div>
							</td>
						</tr>
					</table>
					<!-- <img src="../../../images/line2.png" width="930" height="4" /> -->
				</td>
			</tr>
		</table>
		<table width="100%" border="0" align="center" class="tabla2">
			<tr>
				<td width="100%">
					<iframe src="<?php echo $dir ?>" name="compra_index1" width="100%" height="520" scrolling="Automatic" frameborder="0" id="compra_index1" allowtransparency="0">
					</iframe>
				</td>
			</tr>
		</table>
	</form>
</body>

</html>