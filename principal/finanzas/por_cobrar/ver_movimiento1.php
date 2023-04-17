<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="css/style1.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	<!--
	.Estilo1 {
		color: #FF0000;
		font-weight: bold;
	}

	.Estilo2 {
		color: #FF0000
	}
	-->
</style>
<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once('../../../titulo_sist.php');
require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUME
require_once('../../../convertfecha.php');	//CONEXION A BASE DE DATOS
$sql = "SELECT * FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
	while ($row = mysqli_fetch_array($result)) {
		$users    = $row['nomusu'];
	}
}
$hour   = date('G');
//$date	= CalculaFechaHora($hour);
$date = date("Y-m-d");
//$hour   = CalculaHora($hour);
$min	   = date('i');
if ($hour <= 12) {
	$hor    = "am";
} else {
	$hor    = "pm";
}
$mov    = $_REQUEST['mov'];
$user   = $_REQUEST['user'];
$local  = $_REQUEST['local'];
$invnum = $_REQUEST['invnum'];
function formato($c)
{
	printf("%08d",  $c);
}
function formato1($c)
{
	printf("%06d",  $c);
}
////////////////////////////
if ($mov == 1) {
	$desc_mov = "TODOS LOS MOVIMIENTOS";
}
if ($mov == 2) {
	$desc_mov = "SOLAMENTE INGRESOS";
}
if ($mov == 3) {
	$desc_mov = "SOLAMENTE SALIDAS";
}
if ($mov == 4) {
	$desc_mov = "COMPRAS";
}
if ($mov == 5) {
	$desc_mov = "INGRESO POR TRANSFERENCIA DE SUCURSAL";
}
if ($mov == 6) {
	$desc_mov = "DEVOLUCION EN BUEN ESTADO";
}
if ($mov == 7) {
	$desc_mov = "CANJE AL LABORATORIO";
}
if ($mov == 8) {
	$desc_mov = "OTROS INGRESOS";
}
if ($mov == 9) {
	$desc_mov = "SALIDAS VARIAS";
}
if ($mov == 10) {
	$desc_mov = "GUIAS DE REMISION";
}
if ($mov == 11) {
	$desc_mov = "SALIDA POR TRANSFERENCIA DE SUCURSAL";
}
if ($mov == 12) {
	$desc_mov = "CANJE PROVEEDOR";
}
if ($mov == 13) {
	$desc_mov = "PRESTAMOS CLIENTE";
}
if ($user == 1) {
	$desc_user = "CLIENTE";
}
if ($user == 2) {
	$desc_user = "PROVEEDOR";
}
if ($user == 3) {
	$desc_user = "SUCURSAL";
}
////////////////////////////
$sql = "SELECT invfec,invnum,tipmov,tipdoc,numdoc,cuscod,refere,invtot FROM movmae where invnum = '$invnum'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
	while ($row = mysqli_fetch_array($result)) {
		$invfec    = $row['invfec'];
		$invnum    = $row['invnum'];
		$tipmov    = $row['tipmov'];
		$tipdoc    = $row['tipdoc'];
		$numdoc    = $row['numdoc'];
		$cuscod    = $row['cuscod'];
		$refere    = $row['refere'];
		$monto     = $row['invtot'];
		if ($tipmov == 1) {
			$desctip_mov = "INGRESO";
		} else {
			$desctip_mov = "SALIDA";
		}
	}
}
?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title><?php echo $desemp ?></title>
</head>

<body>
	<table width="930" border="1" align="center">
		<tr>
			<td>
				<table width="914" border="0">
					<tr>
						<td width="260"><strong><?php echo $desemp ?> </strong></td>
						<td width="380">
							<div align="center"><strong>COMPRA CORRESPONDIENTE </strong></div>
						</td>
						<td width="260">
							<div align="center"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div>
						</td>
					</tr>
					<tr>

						<td colspan="3" width="267">
							<div align="right"><strong>USUARIO:</strong><span class="text_combo_select"><?php echo $users ?></span></div>
						</td>
					</tr>
				</table>

				<div align="center"><img src="../../images/line2.png" width="910" height="4" /></div>
			</td>
		</tr>
	</table>
	<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td>
				<table width="926" border="0" align="center">
					<tr>
						<td width="69"><strong>FECHA</strong></td>
						<td width="97">
							<div align="left"><strong>INTERNO</strong></div>
						</td>
						<td width="150">
							<div align="center"><strong>TIPO MOV </strong></div>
						</td>
						<td width="127">
							<div align="left"><strong>N&ordm; DOCUMENTO </strong></div>
						</td>
						<td width="183">
							<div align="left"><strong><?php echo $desc_user ?></strong></div>
						</td>
						<td width="188">
							<div align="left"><strong>REFERENCIA</strong></div>
						</td>
						<td width="82">
							<div align="center"><strong>MONTO</strong></div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td>
				<table width="926" border="0" align="center">
					<tr>
						<td width="69"><?php echo fecha($invfec) ?></td>
						<td width="97">
							<div align="left"><?php echo formato($invnum) ?></div>
						</td>
						<td width="150">
							<div align="center"><?php echo $desctip_mov ?></div>
						</td>
						<td width="127">
							<div align="left"><?php echo formato($numdoc); ?></div>
						</td>
						<td width="183">
							<div align="left">
								<?php ?>
							</div>
						</td>
						<td width="188"><?php if ($refere <> "") { ?>
								<?php echo substr($refere, 0, 20);
											echo "..."; ?>
							<?php } ?></td>
						<td width="82">
							<div align="center"><?php echo $numero_formato_frances = number_format($monto, 2, '.', ' '); ?></div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<div align="center"><img src="../../images/line2.png" width="910" height="4" /></div>

	<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td>
				<?php $sql = "SELECT * FROM movmov where invnum = '$invnum' order by pripro desc";
				$result = mysqli_query($conexion, $sql);
				$i = 0;
				if (mysqli_num_rows($result)) {
				?>
					<table width="926" border="0" align="center">
						<tr>
							<th>
								<div align="left"><strong>PRODUCTO</strong></div>
			</td>
			<th>
				<div align="left"><strong>MARCA</strong></div>
			</th>
			<th>
				<div align="center"><strong>CANTIDAD</strong></div>
			</th>
			<th>
				<div align="center"><strong>PRECIO REF </strong></div>
			</th>
			<th>
				<div align="center"><strong>DESC 1 </strong></div>
			</th>
			<th>
				<div align="center"><strong>DESC 2 </strong></div>
			</th>
			<th>
				<div align="center"><strong>DESC 3 </strong></div>
			</th>
			<th>
				<div align="center"><strong>TOTAL CON DCTO </strong></div>
			</th>
			<th>
				<div align="center"><strong>SUB TOTAL </strong></div>
			</th>
		</tr>
		<?php while ($row = mysqli_fetch_array($result)) {
						$codpro    = $row['codpro'];
						$qtypro    = $row['qtypro'];
						$qtyprf    = $row['qtyprf'];
						$pripro    = $row['pripro'];
						$prisal    = $row['prisal'];
						$costre    = $row['costre'];
						$desc1     = $row['desc1'];
						$desc2     = $row['desc2'];
						$desc3     = $row['desc3'];
						$sql1 = "SELECT desprod,factor,codmar FROM producto where codpro = '$codpro'";
						$result1 = mysqli_query($conexion, $sql1);
						if (mysqli_num_rows($result1)) {
							while ($row1 = mysqli_fetch_array($result1)) {
								$desprod    = $row1['desprod'];
								$factor     = $row1['factor'];
								$codmar     = $row1['codmar'];
							}
						}
						if ($qtyprf == "") {
							$cantidad = $qtypro;
						} else {
							$cantidad = $qtyprf;
						}
						$sql1 = "SELECT destab,abrev FROM titultabladet  where codtab = '$codmar'";
						$result1 = mysqli_query($conexion, $sql1);
						if (mysqli_num_rows($result1)) {
							while ($row1 = mysqli_fetch_array($result1)) {
								$destab     = $row1['destab'];
								$abrev      = $row1['abrev'];
								if ($abrev <> '') {
									$destab = $abrev;
								}
							}
						}
		?>
			<tr>

				<td><?php echo $desprod;
						echo " ";
						if ($pripro == 0) { ?>(BONIF)<?php } ?></td>
				<td><?php echo $destab; ?></td>
				<td>
					<div align="center"><?php echo $cantidad ?></div>
				</td>
				<td>
					<div align="center"><?php echo $prisal ?></div>
				</td>
				<td>
					<div align="center"><?php echo $desc1 ?></div>
				</td>
				<td>
					<div align="center"><?php echo $desc2 ?></div>
				</td>
				<td>
					<div align="center"><?php echo $desc3 ?></div>
				</td>
				<td>
					<div align="center"><?php echo $pripro ?></div>
				</td>
				<td>
					<div align="center"><?php echo $costre ?></div>
				</td>
			</tr>
		<?php }
					$i++
		?>
	</table>
<?php }
?>
</td>
</tr>
</table>
</body>

</html>