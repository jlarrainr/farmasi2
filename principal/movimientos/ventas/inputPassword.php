<?php
 require_once('../../session_user.php');

$venta   = $_SESSION['venta'];
 
  require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
	require_once('../../../funciones/funct_principal.php');	//DESHABILITA TECLAS

	require_once('../../../funciones/botones.php');	//COLORES DE LOS BOTONES

$valor1 = isset($_REQUEST['valor1']) ? $_REQUEST['valor1'] : '';
$invnumVenta = isset($_REQUEST['invnumVenta']) ? $_REQUEST['invnumVenta'] : '';

//echo '$valor1 = '.$valor1."<br>";
//echo '$invnumVenta = '.$invnumVenta."<br>";
$sqldatagen = "SELECT diasCuotasVentas,diasCuotasVentasPassword FROM datagen ";
$resultdatagen = mysqli_query($conexion, $sqldatagen);
if (mysqli_num_rows($resultdatagen)) {
	while ($rowdatagen = mysqli_fetch_array($resultdatagen)) {
		$diasCuotasVentasDatagen    = $rowdatagen['diasCuotasVentas'];
		$diasCuotasVentasPassword    = $rowdatagen['diasCuotasVentasPassword'];
	}
}
//echo '$diasCuotasVentasDatagen = '.$diasCuotasVentasDatagen."<br>";
//echo '$diasCuotasVentasPassword = '.$diasCuotasVentasPassword."<br>";
?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
	<link href="css/style.css" rel="stylesheet" type="text/css" />
	<style>
		

		.botonimagenUpdate {
			background-image: url(update.svg);

			background-repeat: no-repeat;
			position: relative;

			width: 10%;
			background-position: center;

		}

		.loading {
			position: fixed;
			z-index: 9999;
			background: rgba(17, 17, 17, 0.5);
			width: 100%;
			height: 100%;
			top: 0;
			left: 0;
		}

		.loading div {
			position: absolute;
			background-image: url('loading.gif');
			background-size: 60px 60px;
			top: 50%;
			left: 50%;
			width: 60px;
			height: 60px;
			margin-top: -30px;
			margin-left: -30px;
		}
		.Scroll {
  height: 640px;
  overflow-y: scroll;
}
	</style>

	<link href="../../select2/css/select2.min.css" rel="stylesheet" />
	<script src="../../select2/jquery-3.4.1.js"></script>
	<script src="../../select2/js/select2.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
  
	<script>
	
		function carga() {
		    
		    	var f = document.form1;
		     
				document.form1.passwordText.value = '';
			f.passwordText.focus();
					
				 
		}
		function cerrar_popup() {

			document.form1.target = "venta_principal";
			window.opener.location.href = "salir_pago.php";
			self.close();
		}
		
		function cambiarPassword2() {



var f = document.form1;
			 
	var	textOriginal = 	f.textOriginal.value;
	var	passwordText = 	f.passwordText.value;
	
	
		 



		 
			 
			 
					
		 				if (passwordText != textOriginal) {
							    
							    $(document.body).append('<span class="loading"><div></div></span>');
								setTimeout(function() {
									$('.loading').remove();
									alert('contrase\u00F1a invalida, sera informada del intendo que realizo.');
    								
    								document.form1.passwordText.value = '';
			                        f.passwordText.focus();
    								
    							 
								}, 2000);
							    
							} else {
							//	document.form1.textPasswordCambio.value = text;
								$(document.body).append('<span class="loading"><div></div></span>');
								setTimeout(function() {
									$('.loading').remove();
									alert("Operacion con \u00E9xito");
									//Swal.fire('Operacion con ���xito');
    								document.form1.target = "venta_principal";
    								self.close();
								
								
								}, 2000); // 5 seconds
							 
						}
					 
		}
		
	</script>
	<title>CAMBIO DE DIAS CUOTAS PASSWORD</title>
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
			background-color: #ededed;
		}

		#customers th {
			padding: 2px;
			text-align: left;
			background-color: #2e91d2;
			color: white;
			font-size: 15px;
		}
	</style>

</head>

<body onload="carga()">
	<form name="form1" id="form1">
		<table width="100%" border="0" id="customers">
			<tr>
				<th colspan="3">
					<div align="center">
						CONTRASEÑA DE CAMBIO
					</div>
				</th>
			</tr>
			<tr>
				<td>
					<input name="passwordText"  id="passwordText"  type="password"  onclick="this.value = ''"/>
				</td>
				<td>
					<div align="center">
						<input type="button" name="Submit" value="Cambiar" onClick="cambiarPassword2()" class="grabar"     />
						<input name="textOriginal" type="hidden" id="textOriginal" value="<?php echo $diasCuotasVentasPassword ?>" />
					</div>
				</td>
			</tr>
		</table>
	</form>
</body>

</html>
 