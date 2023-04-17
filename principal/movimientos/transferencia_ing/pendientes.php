<?php
$desprod = "";
include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
	<?php
	require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
	require_once '../../../convertfecha.php';
	require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
	require_once('../../../titulo_sist.php');

	$cuenta  = $_REQUEST['cuenta'];


	$sql = "SELECT codloc,nomusu FROM usuario where usecod = '$usuario'";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$codloc       = $row['codloc'];			//////OBTENGO EL CODIGO DEL LOCAL ACTUAL O DESTINO
			$user    	  = $row['nomusu'];
		}
	}
	?>
	<script>
		function cerrar(e) {
			tecla = e.keyCode
			if (tecla == 27) {
				window.close();
			}
		}

		function cerrars(e) {
			var f = document.form1;
			var cxr = e;
			document.form1.target = "venta_principal";
			window.opener.location.href = "exit1.php?invnum=" + cxr;
			self.close();
		}
	</script>
	<?php function formato($c)
	{
		printf("%08d", $c);
	}
	?>
	<title><?php echo $desprod ?></title>
	<link href="../css2/tablas.css" rel="stylesheet" type="text/css" />
	<link href="../../../funciones/datatable/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
	<script src="../../../funciones/datatable/jquery-3.3.1.js"></script>
	<script src="../../../funciones/datatable/jquery.dataTables.min.js"></script>
</head>

<body onkeyup="cerrar(event)" style="background-color:#f4f4f4;">
	<form name="form1">
		<table width="100%" border="0">
			<tr>
				<td>

					<?php $sql = "SELECT invnum,numdoc,sucursal,usecod,invfec,refere FROM movmae where sucursal1 = '$codloc' and tipmov = '2' and tipdoc = '3' and estado = '0' and proceso = '0' and val_habil = '0'";					/////OBTENGO EL DOCUMENTO
					$result = mysqli_query($conexion, $sql);
					if (mysqli_num_rows($result)) {
					?>
						<table width="100%" border="0" align="center" id="customers">
							<thead id="Topicos_Cabecera_Datos">
								<tr>
									<th width="5%"><strong>NUMERO DOCUMENTO</strong></th>
									<th width="5%"><strong>FECHA DE ENVIO</strong></th>
									<th width="5%"><strong>SUCURSAL DE PROCEDENCIA</strong></th>
									<th width="10%"><strong>USUARIO DE PROCEDENCIA</strong></th>
									<!-- <th width="15%"><strong>REFERENCIA</strong></th> -->
								</tr>
							</thead>
							<tbody id="gtnp_Listado_Datos">
								<?php while ($row = mysqli_fetch_array($result)) {
									$invnum         = $row['invnum'];
									$numdoc         = $row['numdoc'];
									$sucursal       = $row['sucursal'];
									$usecod         = $row['usecod'];
									$invfec         = $row['invfec'];
									$refere         = $row['refere'];
									$sql1 = "SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal'";
									$result1 = mysqli_query($conexion, $sql1);
									if (mysqli_num_rows($result1)) {
										while ($row1 = mysqli_fetch_array($result1)) {
											$nomloc         = $row1['nomloc'];
											$nombre         = $row1['nombre'];
										}
									}
									if ($nombre <> "") {
										$nomloc = $nombre;
									}
									$sql1 = "SELECT nomusu FROM usuario where usecod = '$usecod'";
									$result1 = mysqli_query($conexion, $sql1);
									if (mysqli_num_rows($result1)) {
										while ($row1 = mysqli_fetch_array($result1)) {
											$nomusu         = $row1['nomusu'];
										}
									}
								?>
									<tr align="center">
										<td>
											<a href="javascript:cerrars(<?php echo $invnum ?>)">
												<?php echo $numdoc; ?>
											</a>
										</td>
										<td>
											<a href="javascript:cerrars(<?php echo $invnum ?>)">
												<?php echo fecha($invfec); ?>
											</a>
										</td>
										<td>
											<a href="javascript:cerrars(<?php echo $invnum ?>)">
												<?php echo $nomloc ?>
											</a>
										</td>
										<td>
											<a href="javascript:cerrars(<?php echo $invnum ?>)">
												<?php echo $nomusu ?>
											</a>
										</td>
										<!-- <td>
											<a href="javascript:cerrars(<?php echo $invnum ?>)">
											<pre>	<?php echo $refere ?></pre>
											</a>
										</td> -->
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
				// "pageLength": 25,
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