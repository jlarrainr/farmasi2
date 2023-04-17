<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');
$desprod = "";
include('../../session_user.php');

$invnum = $_SESSION['consulta_comp'];

//echo $invnum;


$cantidadRegistros = 0;



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


		function imprimirre(valor) {
			//    PARA DESHABILITAR
			var f = document.form1;
			ventana = confirm("Desea imprimir los codigos de barra?");
			if (ventana) {
				f.method = "post";
				f.target = "_top";
				f.action = "impresionCodbar.php?codpro=" + valor;
				f.submit();
			}
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

	<?php

	$sqlalerta = "SELECT count(*) as cantidadRegistros FROM tempmovmov where invnum='$invnum'";

	$resultalerta = mysqli_query($conexion, $sqlalerta);
	if (mysqli_num_rows($resultalerta)) {
		while ($rowalerta = mysqli_fetch_array($resultalerta)) {
			$cantidadRegistros    = $rowalerta['cantidadRegistros'];			//////OBTENGO EL CODIGO DEL LOCAL ACTUAL O DESTINO

		}
	}

	//if($cantidadRegistros ==0 ) {
	?>
	<form name="form1">
		<table width="100%" border="0">
			<tr>
				<td>

					<?php $sql = "SELECT  codpro,qtypro,qtyprf,codloc,usecod FROM movmov as MOV INNER JOIN movmae as MA on MA.invnum=MOV.invnum where MOV.invnum='$invnum' ";
					$result = mysqli_query($conexion, $sql);

					//echo $sql;
					if (mysqli_num_rows($result)) {
					?>
						<table width="100%" border="0" align="center" id="customers">
							<thead id="Topicos_Cabecera_Datos">
								<tr>
									<th width="5%"><strong>CODIGO PRODUCTO</strong></th>
									<th width="15%"><strong>DESCRIPCION </strong></th>
									<th width="8%"><strong>CODIGO DE BARRAS </strong></th>
									<th width="5%"><strong>CANTIDAD </strong></th>
									<th width="5%"><strong>SUCURSAL </strong></th>
									<th width="5%"><strong>USUARIO </strong></th>
									<th width="5%"><strong>IMPIRMIR</strong></th>
								</tr>
							</thead>
							<tbody id="gtnp_Listado_Datos">
								<?php while ($row = mysqli_fetch_array($result)) { 
									$codpro         = $row['codpro'];
									$usecod         = $row['usecod'];
									$sucursal       = $row['codloc'];
									$qtypro       = $row['qtypro'];
									$qtyprf       = $row['qtyprf'];

									$sqlPro = "SELECT desprod,codbar from producto where codpro='$codpro'";
									$resultPro = mysqli_query($conexion, $sqlPro);
									if (mysqli_num_rows($resultPro)) {
										while ($row1 = mysqli_fetch_array($resultPro)) {
											$desprod         = $row1['desprod'];
											$codbar         = $row1['codbar'];
										}
									}

									//echo $sqlPro;

									



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
											<a>
												<?php echo $codpro; ?>

											</a>

										</td>
										<td>
											<a>
												<?php echo $desprod; ?>
											</a>
										</td>

										<td>
											
										<img src="barcode_pdf.php?text=<?php echo $codbar;?> &size=50&orientation=horizontal&codetype=Code128&print=true" > 
											
										</td>

										<!-- <td>
											<a>
												<?php echo $codbar; ?>
											</a>
										</td> -->
										<?php if ($qtypro > 0) { ?>
											<td>
												<a>
													<?php echo $qtypro; ?>
												</a>
											</td>
										<?php } else { ?>

											<td>
												<a>
													<?php echo $qtyprf; ?>
												</a>
											</td>

										<?php } ?>

										<td>
											<a>
												<?php echo $nombre; ?>
											</a>
										</td>

										<td>
											<a>
												<?php echo $nomusu; ?>
											</a>
										</td>


										<td>

											<a title="HABILITADO" href="#" onclick="imprimirre(<?php echo $codpro ?>)"><img src="printer2.png"></img></a>
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
	<!--	<?php // } else {
			?>
	
	<div style="padding:5px;color:red;font-size:18px;">
	
	<span >

	     Antes de realizar la busqueda de un nuevo prepedido por favor cancelar la transferencia.
	</span>
	</div> 
	

	<?php //} 
	?> -->

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