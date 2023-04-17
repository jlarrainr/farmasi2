<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Documento sin t&iacute;tulo</title>
	<link href="css/style1.css" rel="stylesheet" type="text/css" />
	<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
	require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
	//require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
	require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
	require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUME
	require_once("../../local.php");	//LOCAL DEL USUARIO
	function formato($c)
	{
		printf("%06d", $c);
	}
	$invnum = $_REQUEST['invnum'];
	?>
	<style type="text/css">
		.Estilo1 {
			color: #666666;
			font-weight: bold;
		}

		.Estilo5 {
			/* color: #666666; */
			font-weight: bold;
			font-family: Georgia, 'Times New Roman', serif;
			/* font-size: 16px; */
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

		#customers td a {
			color: #4d9ff7;
			font-weight: bold;
			font-size: 15px;
			text-decoration: none;
		}

		#customers #total {
			text-align: center;
			background-color: #fe5050;
			color: white;
			font-size: 16px;
			font-weight: 900;
		}

		#customers tr:nth-child(even) {
			background-color: #f0ecec;
		}

		#customers tr:hover {
			background-color: #FFFF99;
		}

		#customers th {
			text-align: center;
			background-color: #50adea;
			color: white;
			font-size: 12px;
			font-weight: 900;
		}
	</style>
</head>

<body>
	<form name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)">
		<table width="100%" border="0">
			<tr>
				<td width="932">
					<?php if ($invnum <> "") {
						$sql = "SELECT ordmae.invnum,nrocomp,codpro,canpro,canate,mont_total,desc1,desc2,desc3,precio_ref,costod,canbon,tipbon FROM ordmov inner join ordmae on ordmov.invnum = ordmae.invnum where ordmae.invnum = '$invnum'";
					} else {
						$sql = "SELECT ordmae.invnum,nrocomp,codpro,canpro,canate,mont_total,desc1,desc2,desc3,precio_ref,costod,canbon,tipbon FROM ordmov inner join ordmae on ordmov.invnum = ordmae.invnum where estado = '0' order by invfec desc,invnum desc LIMIT 1";
					}
					$result = mysqli_query($conexion, $sql);
					if (mysqli_num_rows($result)) {
					?>
						<table width="100%" border="1" id="customers">

							<tr>
								<th width="2%"><span class="Estilo5">N&ordm;</span></th>
								<th width="7%"><span class="Estilo5">CODIGO</span></th>
								<th width="7%">
									<div align="center"><span class="Estilo5">CANTIDAD</span></div>
								</th>
								<th width="7%">
									<div align="center"><span class="Estilo5">BONIF</span></div>
								</th>
								<th width="7%">
									<div align="center"><span class="Estilo5">ATENDIDO</span></div>
								</th>
								<th width="7%">
									<div align="center"><span class="Estilo5">SALDO</span></div>
								</th>
								<th width="31%">
									<div align="left"><span class="Estilo5">PRODUCTO </span></div>
								</th>
								<th width="8%">
									<div align="right"><span class="Estilo5">PRECIO</span></div>
								</th>
								<th width="6%">
									<div align="center"><span class="Estilo5">DCTO 1 </span></div>
								</th>
								<th width="6%">
									<div align="center"><span class="Estilo5">DCTO 2 </span></div>
								</th>
								<th width="6%">
									<div align="center"><span class="Estilo5">DCTO 3 </span></div>
								</th>
								<th width="6%">
									<div align="right"><span class="Estilo5">SUBTOTAL</span></div>
								</th>
							</tr>

							<?php while ($row = mysqli_fetch_array($result)) {
								$invnum = $row["invnum"];
								$nrocomp = $row["nrocomp"];
								$codpro = $row["codpro"];
								$canpro = $row["canpro"];
								$canate = $row["canate"];
								$costod = $row["costod"];
								$precio_ref = $row["precio_ref"];
								$mont_total = $row["mont_total"];
								$desc1  = $row["desc1"];
								$desc2  = $row["desc2"];
								$desc3  = $row["desc3"];
								$canbon = $row["canbon"];
								$tipbon = $row["tipbon"];
								$sql1 = "SELECT desprod,factor FROM producto where codpro = '$codpro'";
								$result1 = mysqli_query($conexion, $sql1);
								if (mysqli_num_rows($result1)) {
									while ($row1 = mysqli_fetch_array($result1)) {
										$producto = $row1["desprod"];
										$factor   = $row1["factor"];
									}
								}
								/////ATENDIDA//////////////////////////////////
								/////////////////////////////////////
								$convert1   = $canate / $factor;
								$div1    	= floor($convert1);
								$mult1		= $factor * $div1;
								$tot1		= $canate - $mult1;
								/////RESULTANTE//////////////////////////////////
								$can_fact   = $canpro * $factor;
								$tot        = $can_fact - $canate;
								/////////////////////////////////////
								$convert    = $tot / $factor;
								$div    	= floor($convert);
								$mult		= $factor * $div;
								$tot		= $tot - $mult;
							?>
								<tr <?php if ($costod == 0) { ?> bgcolor="#FFCC66" <?php } ?>>
									<td><?php echo formato($nrocomp) ?></td>
									<td>
										<div align="center"><?php echo $codpro ?></div>
									</td>
									<td>
										<div align="center"><?php if ($mont_total == 0) {
																echo $canbon;
																echo " ";
																echo $tipbon;
															} else {
																echo $canpro;
															} ?>
										</div>
									</td>
									<td>
										<div align="center"><?php if ($mont_total <> 0) {
																echo $canbon;
																if ($canbon <> 0) {
																	echo " ";
																	echo $tipbon;
																}
															} ?>
										</div>
									</td>
									<td>
										<div align="center"><?php if ($mont_total == 0) {
																echo $canate;
															} else {
																echo $div1 ?> F <?php echo $tot1;
																			} ?>
										</div>
									</td>
									<td bgcolor="#FFFF99">
										<div align="center"><?php if ($mont_total == 0) {
																echo ($canbon - $canate);
															} else {
																echo $div ?> F <?php echo $tot;
																			} ?>
										</div>
									</td>
									<td><?php echo $producto;
										?>
									</td>
									<td>
										<div align="right"><?php echo $precio_ref ?></div>
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
										<div align="right"><?php echo $mont_total ?></div>
									</td>
								</tr>
							<?php }
							?>
						</table>
					<?php }
					?>
				</td>
			</tr>
		</table>
	</form>
</body>

</html>