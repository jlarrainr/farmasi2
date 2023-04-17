<?php include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
require_once('../../../convertfecha.php');	//CONEXION A BASE DE DATOS
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<title><?php echo $desemp ?></title>
	<link href="../css/style1.css" rel="stylesheet" type="text/css" />
	<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
</head>

<style type="text/css">
	.Estilo1 {
		color: #0035f9;

	}

	.Estilo2 {
		color: #7cbecf;

	}

	#customers {
		font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
		border-collapse: collapse;
		width: 100%;

	}

	#customers td,
	#customers th {
		border: 1px solid #ddd;
		padding: 3px;

	}

	#customers tr:nth-child(even) {
		background-color: #f0ecec;
	}

	#customers tr:hover {
		background-color: #ddd;
	}

	#customers th {

		text-align: center;
		background-color: #50ADEA;
		color: white;
		font-size: 12px;
		font-weight: 900;
	}
</style>
<?php require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUME
require_once("../../local.php");	//LOCAL DEL USUARIO
$marca = $_REQUEST['marca'];
$val   = $_REQUEST['val'];
$sql = "SELECT nomusu FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
	while ($row = mysqli_fetch_array($result)) {
		$user    = $row['nomusu'];
	}
}
function formato($c)
{
	printf("%08d", $c);
}
$date1   = $_REQUEST['date1'];
$local   = $_REQUEST['local'];
$date2   = $_REQUEST['date2'];
$tipo    = $_REQUEST['tipo'];
$val     = $_REQUEST['val'];

// echo $tipo;
?>

<body>
	<form id="form1" name="form1">
		<?php if ($tipo == 1) {
		?>
			<table width="100%" border="0" class="tabla2">
				<tr>
					<td width="951">
						<table width="100%%" border="0" align="center">
							<tr>
								<td width="389"><?php if ($val == 1) { ?>FECHAS ENTRE EL <b><?php echo $date1; ?></b> AL <b><?php echo $date2; ?></b><?php } ?></td>
								<td width="174">
									<div align="right"><span class="text_combo_select"><strong>LOCAL:</strong> <img src="../../../images/controlpanel.png" width="16" height="16" /> <?php echo $nombre_local ?></span></div>
								</td>
								<td width="338">
									<div align="right"><span class="text_combo_select"><strong>USUARIO :</strong> <img src="../../../images/user.gif" width="15" height="16" /> <?php echo $user ?></span></div>
								</td>
							</tr>
						</table>
						<img src="../../../images/line2.png" width="100%" height="4" />

						<div align="center">
							<img src="../../../images/line2.png" width="920" height="4" />
							<?php if ($val == 1) {
								if ($local <> 'all') {
									$sql = "SELECT invnum,invfec,numdoc,invtot,sucursal,sucursal1,estado,val_habil FROM movmae where tipmov = '2' and tipdoc = '3' and invfec between '$date1' and '$date2' and proceso = '0' and val_habil ='0' and estado = '1' and (sucursal ='$local' or sucursal1 ='$local' )";
								} else {
									$sql = "SELECT invnum,invfec,numdoc,invtot,sucursal,sucursal1,estado,val_habil FROM movmae where tipmov = '2' and tipdoc = '3' and invfec between '$date1' and '$date2' and proceso = '0' and val_habil ='0' and estado = '1'";
								}




								$result = mysqli_query($conexion, $sql);
								if (mysqli_num_rows($result)) {
							?>
									<table width="100%" border="0" align="center" id="customers">

										<tr>
											<th>
												<div align="left"><strong>LOCAL DE SALIDA</strong></div>
											</th>
											<th><strong>FECHA </strong></th>
											<th>
												<div align="left"><strong>NUMERO </strong></div>
											</th>
											<th>
												<div align="right"><strong>MONTO </strong></div>
											</th>
											<th>
												<div align="right"><strong></strong></div>
											</th>
											<th>
												<div align="left"><strong>LOCAL DE DESTINO</strong></div>
											</th>
											<th><strong>FECHA </strong></th>
											<th>
												<div align="left"><strong>NUMERO </strong></div>
											</th>

											<th>
												<div align="right"><strong>MONTO </strong></div>
											</th>
											<th>
												<div align="center"><strong>VER</strong></div>
											</th>
										</tr>


										<?php while ($row = mysqli_fetch_array($result)) {
											$invnum         = $row['invnum'];
											$invfec         = $row['invfec'];
											$numdoc         = $row['numdoc'];
											$invtot         = $row['invtot'];
											$sucursal       = $row['sucursal'];
											$sucursal1      = $row['sucursal1'];
											$estado         = $row['estado'];
											$val_habil         = $row['val_habil'];
											if ($estado == 1) {
												$desc = "RECIBIDO";
											} else {
												$desc = "AUN NO RECIBIDO";
											}
											$sql1 = "SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal'";
											$result1 = mysqli_query($conexion, $sql1);
											if (mysqli_num_rows($result1)) {
												while ($row1 = mysqli_fetch_array($result1)) {
													$localorig         = $row1['nomloc'];
													$nombre1	       = $row1['nombre'];
													if ($nombre1 <> '') {
														$localorig = $nombre1;
													}
												}
											}
											$sql1 = "SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal1'";
											$result1 = mysqli_query($conexion, $sql1);
											if (mysqli_num_rows($result1)) {
												while ($row1 = mysqli_fetch_array($result1)) {
													$localdest        = $row1['nomloc'];
													$nombre2	          = $row1['nombre'];
													if ($nombre2 <> '') {
														$localdest = $nombre2;
													}
												}
											}
											$sql1 = "SELECT invnum,invfec,numdoc,invtot FROM movmae where invnumrecib = '$invnum'";
											$result1 = mysqli_query($conexion, $sql1);
											if (mysqli_num_rows($result1)) {
												while ($row1 = mysqli_fetch_array($result1)) {
													$invnum1         = $row1['invnum'];
													$invfec1         = $row1['invfec'];
													$numdoc1         = $row1['numdoc'];
													$invtot1         = $row1['invtot'];
												}
											}
										?>
											<tr>
												<td width="197">
													<div align="left"><?php echo $localorig ?></div>
												</td>
												<td width="67"><?php echo fecha($invfec) ?></td>
												<td width="80">
													<div align="left"><?php echo formato($numdoc); ?></div>
												</td>
												<td width="65">
													<div align="right"><?php echo $invtot ?></div>
												</td>
												<td width="10">
													<div align="right"></div>
												</td>
												<td width="197">
													<div align="left"><?php echo $localdest ?></div>
												</td>
												<td width="67"><?php echo $invfec1 ?></td>
												<td width="80">
													<div align="left"><?php echo formato($numdoc1); ?></div>
												</td>
												<!--  <td width="50"><div align="left"><?php if ($val_habil == 1) {
																							$reso = "ACTIVADO";
																							echo "<p class='Estilo1'>$desc</p>";
																						} else {
																							$reso = " ";
																							echo "<p class='Estilo2'>$reso</p>";
																						} ?></div></td>-->
												<td width="65">
													<div align="right"><?php echo $invtot1 ?></div>
												</td>
												<td width="45">
													<div align="center"><a href="javascript:popUpWindow('ver_transf.php?invnum=<?php echo $invnum ?>', 30, 100, 985, 550)">VER</a></div>
												</td>
											</tr>
										<?php }
										?>
									</table>
							<?php }
							}
							?>
						</div>
					</td>
				</tr>
			</table>
		<?php } else {
		?>
			<table width="100%" border="0" class="tabla2">
				<tr>
					<td width="951">
						<table width="100%" border="0" align="center">
							<tr>
								<td width="389"><?php if ($val == 1) { ?>FECHAS ENTRE EL <b><?php echo $date1; ?></b> AL <b><?php echo $date2; ?></b><?php } ?></td>
								<td width="174">
									<div align="right"><span class="text_combo_select"><strong>LOCAL:</strong> <img src="../../../images/controlpanel.png" width="16" height="16" /> <?php echo $nombre_local ?></span></div>
								</td>
								<td width="338">
									<div align="right"><span class="text_combo_select"><strong>USUARIO :</strong> <img src="../../../images/user.gif" width="15" height="16" /> <?php echo $user ?></span></div>
								</td>
							</tr>
						</table>
						<img src="../../../images/line2.png" width="100%" height="4" />

						<div align="center">
							<img src="../../../images/line2.png" width="100%" height="4" />
							<?php if ($val == 1) {
								if ($local <> 'all') {
									$sql = "SELECT invnum,invfec,numdoc,invtot,sucursal,sucursal1,estado, val_habil  FROM movmae where tipmov = '2' and tipdoc = '3' and invfec between '$date1' and '$date2' and ((sucursal ='$local') or ( sucursal1 ='$local'))and proceso = '0' and val_habil ='0'  and estado = '0'";
								} else {
									$sql = "SELECT invnum,invfec,numdoc,invtot,sucursal,sucursal1,estado, val_habil  FROM movmae where tipmov = '2' and tipdoc = '3' and invfec between '$date1' and '$date2'  and proceso = '0' and val_habil ='0'  and estado = '0'";
								}
								// echo $sql;
								$result = mysqli_query($conexion, $sql);
								if (mysqli_num_rows($result)) {
							?>
									<table width="100%" border="0" align="center" id="customers">
										<tr>
											<th>
												<div align="left"><strong>LOCAL DE SALIDA</strong></div>
											</th>
											<th>
												<div align="left"><strong>LOCAL DE DESTINO</strong></div>
											</th>
											<th><strong>FECHA DE SALIDA </strong></th>
											<th width="211">
												<div align="left"><strong>NUMERO DE DOCUMENTO </strong></div>
											</th>
											<th>
												<div align="right"><strong>MONTO </strong></div>
											</th>
											<th>
												<div align="center"><strong>VER</strong></div>
											</th>
										</tr>
										<?php while ($row = mysqli_fetch_array($result)) {
											$invnum         = $row['invnum'];
											$invfec         = $row['invfec'];
											$numdoc         = $row['numdoc'];
											$invtot         = $row['invtot'];
											$sucursal       = $row['sucursal'];
											$sucursal1      = $row['sucursal1'];
											$estado         = $row['estado'];
											$val_habil         = $row['val_habil'];
											if ($estado == 1) {
												$desc = "RECIBIDO";
											} else {
												$desc = "AUN NO RECIBIDO";
											}
											$sql1 = "SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal'";
											$result1 = mysqli_query($conexion, $sql1);
											if (mysqli_num_rows($result1)) {
												while ($row1 = mysqli_fetch_array($result1)) {
													$localorig         = $row1['nomloc'];
													$nombre1           = $row1['nombre'];
													if ($nombre1 <> '') {
														$localorig = $nombre1;
													}
												}
											}
											$sql1 = "SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal1'";
											$result1 = mysqli_query($conexion, $sql1);
											if (mysqli_num_rows($result1)) {
												while ($row1 = mysqli_fetch_array($result1)) {
													$localdest        = $row1['nomloc'];
													$nombre2	      = $row1['nombre'];
													if ($nombre2 <> '') {
														$localdest = $nombre2;
													}
												}
											}
										?>
											<tr>
												<td width="194">
													<div align="left"><?php echo $localorig ?></div>
												</td>
												<td width="191">
													<div align="left"><?php echo $localdest ?></div>
												</td>
												<td width="103"><?php echo fecha($invfec) ?></td>
												<td width="150">
													<div align="left"><?php echo formato($numdoc); ?></div>
												</td>
												<!-- <td width="90"><div align="left"><strong>  <?php if ($val_habil == 0) {
																									$reso = "ACTIVADO";
																									echo "<p class='Estilo1'>$reso</p>";
																								} else {
																									$reso = " ";
																									echo "<p class='Estilo2'>$reso</p>";
																								} ?></strong></div></td>-->
												<td width="75">
													<div align="right"><?php echo $invtot ?></div>
												</td>
												<td width="65">
													<div align="center"><a href="javascript:popUpWindow('ver_transf.php?invnum=<?php echo $invnum ?>', 30, 100, 985, 550)" style="font-size:18px">VER</a></div>
												</td>
											</tr>
										<?php }
										?>
									</table>
							<?php }
							}
							?>
						</div>
					</td>
				</tr>
			</table>
		<?php }
		?>
	</form>
</body>

</html>