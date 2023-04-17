<?php include('../../../session_user.php');
$ord_compra   = $_SESSION['ord_compra'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Documento sin t&iacute;tulo</title>
	<link href="../css/style1.css" rel="stylesheet" type="text/css" />
	<link href="../css/style2.css" rel="stylesheet" type="text/css" />
	<link href="../../../../funciones/datatable/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
	<script src="../../../../funciones/datatable/jquery-3.3.1.js"></script>
	<script src="../../../../funciones/datatable/jquery.dataTables.min.js"></script>
	<?php require_once('../../../../conexion.php');	//CONEXION A BASE DE DATOS
	require_once("../../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
	//require_once("../../../../funciones/functions.php");	//DESHABILITA TECLAS
	require_once("../../../../funciones/botones.php");	//COLORES DE LOS BOTONES
	require_once("../../../../funciones/funct_principal.php");	//IMPRIMIR-NUME
	require_once("../../../local.php");	//LOCAL DEL USUARIO

	function formato($c)
	{
		printf("%04d", $c);
	}
	?>
	<style type="text/css">
		.Estilo1 {
			color: #666666;
			font-weight: bold;
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
			background-color: #ddd;
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
<?php $sql = "SELECT provee FROM ordmae where invnum = '$ord_compra'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
	while ($row = mysqli_fetch_array($result)) {
		$provee    = $row['provee'];
	}
}
?>

<body onload="getfocus();" id="body">
	<form name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)">
		<table width="100%" border="0">
			<tr>
				<td width="100%">
					<?php $sql = "SELECT codpro,despro,dirpro,telpro,rucpro FROM proveedor order by codpro";
					$result = mysqli_query($conexion, $sql);
					if (mysqli_num_rows($result)) {
					?>
						<table width="100%" border="0" id="customers">
							<thead id="Topicos_Cabecera_Datos">
								<tr>
									<th width="10%"><span class="Estilo5">CODIGO</span></th>
									<th width="50%"><span class="Estilo5">PROVEEDOR</span></th>
									<th width="15%"><span class="Estilo5">RUC</span></th>
									<th width="15%"><span class="Estilo5">TELEFONO</span></th>
									<th width="10%">
										<div align="center"><span class="Estilo5">AGREGAR </span></div>
									</th>
								</tr>
							</thead>
							<tbody id="gtnp_Listado_Datos">
								<?php while ($row = mysqli_fetch_array($result)) {
									$codpro     = $row['codpro'];
									$despro     = $row['despro'];
									$dirpro     = $row['dirpro'];
									$telpro     = $row['telpro'];
									$rucpro     = $row['rucpro'];
								?>
									<tr bgcolor="<?php if ($provee == $codpro) { ?>#FFFF99<?php } else { ?>#ffffff<?php } ?>" onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='<?php if ($provee == $codpro) { ?>#FFFF99<?php } else { ?>#ffffff<?php } ?>';">
										<td align="center"><?php echo $codpro; ?></td>
										<td><a href="add_proveedor.php?proveedor=<?php echo $codpro ?>" target="compra_index"><?php echo $despro ?></a></td>
										<td><?php echo $rucpro ?></td>
										<td align="center"><?php echo $telpro ?></td>
										<td>
											<div align="center">
												<a href="add_proveedor.php?proveedor=<?php echo $codpro ?>" target="compra_index">
													<?php if ($provee == $codpro) { ?>
														<img src="../../../../images/icon-16-checkin.png" width="16" height="16" border="0" />
													<?php } else { ?>
														<img src="../../../../images/add.gif" width="16" height="16" border="0" />
													<?php } ?>
												</a>
											</div>
										</td>
									</tr>
								<?php }
								?>
							</tbody>
						</table>
					<?php }
					?>
				</td>
			</tr>
		</table>
	</form>
</body>

</html>
<script>
	$(document).ready(function() {
			$('#customers').DataTable({
				"pageLength": 25,
				language: {
					"sProcessing": "Procesando...",
					"sLengthMenu": "Mostrar _MENU_ registros",
					"sZeroRecords": "No se encontraron resultados",
					"sEmptyTable": "NingÃºn dato disponible en esta tabla =(",
					"sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
					"sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
					"sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
					"sInfoPostFix": "",
					"sSearch": "Buscar:",
					"sUrl": "",
					"sInfoThousands": ",",
					"sLoadingRecords": "Cargando...",
					"oPaginate": {
						"sFirst": "Primero",
						"sLast": "Ãltimo",
						"sNext": "Siguiente",
						"sPrevious": "Anterior"
					},
					"oAria": {
						"sSortAscending": ": Activar para ordenar la columna de manera ascendente",
						"sSortDescending": ": Activar para ordenar la columna de manera descendente"
					},
					"buttons": {
						"copy": "Copiar",
						"colvis": "Visibilidad"
					}
				}
			});
		}

	);
</script>