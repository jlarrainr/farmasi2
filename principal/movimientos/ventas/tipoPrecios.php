<?php require_once('../../session_user.php');
$venta   = $_SESSION['venta'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
	<link href="css/style.css" rel="stylesheet" type="text/css" />
	<style>
		a:link,
		a:visited {
			color: #0066CC;
			border: 0px solid #e7e7e7;
		}

		a:hover {
			background: #fff;
			border: 0px solid #ccc;
		}

		a:focus {
			background-color: #FFFF99;
			color: #0066CC;
			border: 0px solid #ccc;
		}

		a:active {
			background-color: #FFFF99;
			color: #0066CC;
			border: 0px solid #ccc;
		}
	</style>

	<!-- <link href="../../select2/css/select2.min.css" rel="stylesheet" />
	<script src="../../select2/jquery-3.4.1.js"></script>
	<script src="../../select2/js/select2.min.js"></script> -->

	<link href="../../../funciones/datatable/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
	<script src="../../../funciones/datatable/jquery-3.3.1.js"></script>
	<script src="../../../funciones/datatable/jquery.dataTables.min.js"></script>

	<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
	require_once('../../../funciones/funct_principal.php');	//DESHABILITA TECLAS
	require_once('funciones/datos_generales.php'); //////CODIGO Y NOMBRE DEL LOCAL
	require_once('../../../funciones/botones.php');	//COLORES DE LOS BOTONES
	require_once('../../local.php');	//LOCAL DEL USUARIO
	$close = isset($_REQUEST['close']) ? $_REQUEST['close'] : "";

	$close =  $_REQUEST['close'];


	?>
	<script>
		function cerrar(e) {
			tecla = e.keyCode
			if (tecla == 27) {
				window.close();
			}
			if (tecla == 13) {
				document.form1.Submit.focus();
			}
		}

		function radio(e) {
			tecla = e.keyCode
			return;
		}
		var nav4 = window.Event ? true : false;

		function enters(evt) {
			// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
			var key = nav4 ? evt.which : evt.keyCode;
			//alert(tecla);
			if (key == 13) {
				document.form1.Submit.focus();
			}
			return (key == 70 || key == 102 || (key <= 13 || (key >= 48 && key <= 57)));
		}

		function saves() {
			var f = document.form1;

			if ((f.tradio2.checked == true) || (f.tradio3.checked == true) || (f.tradio4.checked == true) || (f.tradio5.checked == true)) {


			} else {
				alert("Seleccione un numero de opcion para poder concluir con el proceso, de lo contrario se tomara la primera opcion.");
				return;
			}


			f.action = "tipoPrecios1.php";
			f.method = "post";
			f.submit();
		}

		function cerrar_popup() {

			document.form1.target = "venta_principal";
			window.opener.location.href = "tipoPrecios1_salir.php";
			self.close();
		}
	</script>
	<title>MODULO DE VENTAS</title>
	<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
	<style type="text/css">
		body {
			background-color: #f4f4f4;
		}

		#customers {
			font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
			border-collapse: collapse;
			width: 100%;
		}

		#customers th {
			border: 1px solid #ddd;
			padding: 1px;

		}

		#customers td {
			border: 1px solid #ddd;
			padding: 5px;
		}

		#customers tr:nth-child(even) {
			background-color: #f2f2f2;
		}

		#customers tr:hover {
			background-color: #e3e2e2;
		}

		#customers th {
			padding: 2px;
			text-align: left;
			background-color: #2e91d2;
			color: white;
			font-size: 15px;
		}

		/* label:hover {
			font-size: 15px;
			color: #6a6565;
		} */
	</style>

</head>
<?php $sql = "SELECT tipoOpcionPrecio FROM venta where invnum = '$venta'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
	while ($row = mysqli_fetch_array($result)) {
		$tipoOpcionPrecio    = $row['tipoOpcionPrecio'];
	}
}




?>

<body onkeyup="cerra3r(event)" <?php if ($close == 1) { ?> onload="cerrar_popup();" <?php } ?>>
	<form name="form1" id="form1">
		<table width="100%" border="0" id="customers">

			<tr>
				<td style="float:left;" align="center" width="45%">
					<table width="100%" border="0" id="customers">
						<tr>
							<th>OPCION 2</th>
							<th>OPCION 3</th>
							<th>OPCION 4</th>
							<th>OPCION 5</th>
							<th></th>
						</tr>
						<tr>
							<td>
								<label for="tradio2" class="LETRA">
									<input type="radio" name="tradio" id="tradio2" <?php if ($tipoOpcionPrecio == 2) { ?>checked="" <?php } ?> value="2">
									Opcion precio 2
								</label>
							</td>
							<td>
								<label for="tradio3" class="LETRA">
									<input type="radio" name="tradio" id="tradio3" <?php if ($tipoOpcionPrecio == 3) { ?>checked="" <?php } ?> value="3">
									Opcion precio 3
								</label>
							</td>
							<td>
								<label for="tradio4" class="LETRA">
									<input type="radio" name="tradio" id="tradio4" <?php if ($tipoOpcionPrecio == 4) { ?>checked="" <?php } ?> value="4">
									Opcion precio 4
								</label>
							</td>
							<td>
								<label for="tradio5" class="LETRA">
									<input type="radio" name="tradio" id="tradio5" <?php if ($tipoOpcionPrecio == 5) { ?>checked="" <?php } ?>value="5">
									Opcion precio 5
								</label>
							</td>
							<td rowspan="4">

								<input type="button" name="Submit" value="Grabar" onclick="saves();" class="grabar" />
							</td>
						</tr>
					</table>

				</td>
				<td width="50%" style="float:right;">

					<table style="width: 100%" id="customersDataTable">
						<?php
						$sql3 = "SELECT codcli,descli,dnicli,ruccli,numeroPrecio FROM cliente  ";
						$result3 = mysqli_query($conexion, $sql3);
						if (mysqli_num_rows($result3)) {
						?>
							<thead id="Topicos_Cabecera_Datos">
								<tr>
									<th style="text-align: left;" class="LETRA">CODIGO</th>
									<th style="text-align: left;" class="LETRA">NOMBRE DE CLIENTE</th>
									<th style="text-align: left;" class="LETRA">DOCUMENTO</th>
									<th style="text-align: left;" class="LETRA">ULTIMA PRECIO DE VENTA X CLIENTE</th>
								</tr>
							</thead>
							<tbody id="gtnp_Listado_Datos">
								<?php
								$i = 0;
								while ($row3 = mysqli_fetch_array($result3)) {
									$codcli         = $row3['codcli'];
									$descli        = $row3['descli'];
									$dnicli         = $row3['dnicli'];
									$ruccli         = $row3['ruccli'];
									$numeroPrecio         = $row3['numeroPrecio'];
									if ($dnicli <> '') {
										$documento = 'DNI: ' . $dnicli;
									} else {
										$documento = 'RUC: ' . $ruccli;
									}

								?>
									<tr>
										<td><?php echo $codcli; ?></td>
										<td><?php echo $descli; ?></td>
										<td><?php echo $documento; ?></td>
										<td><?php echo $numeroPrecio; ?></td>
									</tr>
								<?php
									$i++;
								}
								?>
							</tbody>
						<?php
						} else {
						?>

							<div class="siniformacion">
								<center>
									No se logro encontrar informacion con los datos ingresados
								</center>
							</div>
						<?php
						}
						?>


				</td>
			</tr>
		</table>
	</form>
</body>

</html>

<script>
	$(document).ready(function() {
			$('#customersDataTable').DataTable({
				"pageLength": 50,
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