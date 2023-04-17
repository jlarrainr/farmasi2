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
			.botonimagenUpdate {
			background-image: url(update.svg);

			background-repeat: no-repeat;
			position: relative;

			width: 25%;
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
  
   <!--   <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>-->


	<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
	require_once('../../../funciones/funct_principal.php');	//DESHABILITA TECLAS
	require_once('funciones/datos_generales.php'); //////CODIGO Y NOMBRE DEL LOCAL
	require_once('../../../funciones/botones.php');	//COLORES DE LOS BOTONES
	require_once('../../local.php');	//LOCAL DEL 
	require_once('calcula_monto.php');
	$close = isset($_REQUEST['close']) ? $_REQUEST['close'] : "";

	$close =  $_REQUEST['close'];


	?>
	<script>
		function sumarDias(fecha, dias) {
			fecha.setDate(fecha.getDate() + dias);
			return fecha;
		}

		var html = "";

		function cargarContenido() {
			document.getElementById("tablaMostrarCuota").style.display = "block";
			var html = "";
			$("#tbodyPagos").html("");
			numeroCuotas = document.form1.numeroCuota.value;
			
		//	cuotaDias = document.form1.textPasswordCambio.value;
			cuotaDias = document.form1.diasCuotasVentas.value;
			
			montototal = document.form1.monto_total.value;

			mostarMonto = parseFloat(montototal / numeroCuotas);
			mostarMonto = Math.round(mostarMonto * Math.pow(10, 4)) / Math.pow(10, 4);
			var html = "";
			diasAsumar = 0;
			for (var i = 1; i <= numeroCuotas; i++) {



				diasAsumar = parseFloat(cuotaDias * i);
				var diaActual = new Date();
				fecha = sumarDias(diaActual, diasAsumar);

				MesMostrar1 = (fecha.getMonth() + 1);

				if (MesMostrar1 <= 9) {
					MesMostrar2 = '0' + MesMostrar1;
				} else {
					MesMostrar2 = MesMostrar1;
				}

				diaMostrar1 = fecha.getDate();

				if (diaMostrar1 <= 9) {
					diaMostrar2 = '0' + diaMostrar1;
				} else {
					diaMostrar2 = diaMostrar1;
				}

				fecha2 = diaMostrar2 + "/" + MesMostrar2 + "/" + fecha.getFullYear()




				html += "<tr><td>" + i + "</td><td>" + fecha2 + "</td><td>" + mostarMonto + "</td></tr>";
			}
			$("#tbodyPagos").append(html);
		}

		function nuevoAjax() {
			var xmlhttp = false;
			try {
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				try {
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (E) {
					xmlhttp = false;
				}
			}

			if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
				xmlhttp = new XMLHttpRequest();
			}
			return xmlhttp;
		}



		function cambiarPassword(valor1, invnumVenta) {

			var f = document.form1;
			text = f.textPasswordCambio.value;
			textOriginal = f.textCambioOriginal.value;
			passwordText = f.passwordText.value;
			numeroCuotas = f.numeroCuota.value;
			
            if(passwordText !=''){
			if (!isNaN(text)) {
				if (text != textOriginal) {
					if ((f.textPasswordCambio.value == "") || (f.textPasswordCambio.value == "0")) {
						alert("El numero de dias por cuota no puede ser cero ni vacio.");
						f.textPasswordCambio.focus();
						return;
					}
					var valor1;
					var invnumVenta;
					
					     /*       w = 300;
                            h = 150;
                            var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : window.screenX;
                            var dualScreenTop = window.screenTop != undefined ? window.screenTop : window.screenY;

                            var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
                            var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

                            var left = ((width / 2) - (w / 2)) + dualScreenLeft;
                            var top = ((height / 2) - (h / 2)) + dualScreenTop;
                            var newWindow = window.open('inputPassword.php?valor1=' + valor1 + '&invnumVenta=' + invnumVenta, 'PRIMPRIMIR', 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

 */
				 
					var valor1;
					var invnumVenta;
					//var opcion = prompt("Introduzca la contrase\u00F1a");
					
					var opcion = passwordText;
				 
						if ((text != 0) && (text != '')) {
							if (opcion != valor1) {
							    
							    $(document.body).append('<span class="loading"><div></div></span>');
							    
							    //var opcion, text;
    								ajax = nuevoAjax();
    								ajax.open("GET", "intentoCambioPassword.php?text=" + text + "&opcion=" + opcion, true);
    								ajax.onreadystatechange = function() {
    								    if (ajax.readyState == 4) {
    								        contenedor.innerHTML = ajax.responseText
    								    }
    								}
    								ajax.send(null);
							    
								setTimeout(function() {
									$('.loading').remove();
									alert('contrase\u00F1a invalida, sera informada del intendo que realizo.');
    								document.form1.textPasswordCambio.value = textOriginal;
    								document.form1.passwordText.value = '';
    								document.form1.cambioDias.value = 0;
    								
								}, 2000);
							    
							} else {
								document.form1.textPasswordCambio.value = text;
								$(document.body).append('<span class="loading"><div></div></span>');
								setTimeout(function() {
									$('.loading').remove();
									alert("Operacion con \u00E9xito");
								
									//Swal.fire('Operacion con ���xito');
									document.getElementById("cargado").innerHTML = "Se realizo cambio de " + textOriginal + " dias a " + text + " dias por cuota.";
									document.form1.passwordText.value = '';
									document.form1.diasCuotasVentas.value =text;
										document.form1.cambioDias.value = 1;
											if(numeroCuotas >0){
									    cargarContenido();
									}
								}, 2000); // 5 seconds
							}
						} else {
							alert("Se cancelo la operacion, porque el numero de dias por cuota no puede ser cero ni vacio.");
							document.form1.passwordText.value = '';
							document.form1.cambioDias.value = 0;
							return;
						}
				 
				 
					
				} else {
					alert("El numero de dias por cuota sigue siedo el mismo, se mantendra el valor predeterminado.");
					document.form1.passwordText.value = '';
					document.form1.cambioDias.value = 0;
					return;

				}
			} else {
				alert("Solo cantidad numerica.");
				document.form1.textPasswordCambio.value = textOriginal;
				document.form1.passwordText.value = '';
				document.form1.cambioDias.value = 0;
				return;
			}
		    
		} else {
				alert("Password esta vacío. ");
				document.form1.textPasswordCambio.value = textOriginal;
				document.form1.passwordText.value = '';
				document.form1.passwordText.focus();
				document.form1.cambioDias.value = 0;
				return;
			}
		}

		function publico() {
			alert("La opcion de credito tiene que ser asignada a un cliente con RUC o DNI, No puede ser asignada a un publico en general.");
		}

		function pasoLimiteCredito() {
			alert("El cliente paso el limite de credito o no tiene linea de credito permitido.");
			document.getElementById("tablaMostrar").style.display = "none";


		}

		function credito() {
			var f = document.form1;
			f.numeroCuota.disabled = false;
			f.textPasswordCambio.disabled = false;
			f.cambiarTextPasswordCambio.disabled = false;
	        document.getElementById("tablaMostrar").style.display = "block";
		}

		function efectivo() {

			var f = document.form1;
			f.textPasswordCambio.disabled = true;
			f.cambiarTextPasswordCambio.disabled = true;
			f.numeroCuota.disabled = true;
			document.getElementById("tablaMostrar").style.display = "none";
		}


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
			var key = nav4 ? evt.which : evt.keyCode;
		 
			if (key == 13) {
				document.form1.Submit.focus();
			}
			return (key == 70 || key == 102 || (key <= 13 || (key >= 48 && key <= 57)));
		}

		function saves() {
			var f = document.form1;
			
			textCambioOriginal = f.textCambioOriginal.value
			textPasswordCambio = f.textPasswordCambio.value
			cambioDias = f.cambioDias.value
			ventaDiasCuotas = f.ventaDiasCuotas.value
			
			 if(ventaDiasCuotas == 0){
			    var comparador = textCambioOriginal;
			 }else{
			    var comparador = ventaDiasCuotas;
			 }
			
			if(comparador !=textPasswordCambio){
			    
			    if(cambioDias==0){
			        
			        document.form1.cambioDias.value = 0;
			        document.form1.passwordText.value = '';
			        alert("No ha presionado el boton de cambio de dias.");
			        f.passwordText.focus();
					return;
					
			    }
			    
			}else{
			    
			     document.form1.cambioDias.value = 1;
			     
			}
			
		 			t = document.form1.tradioC.value;
					if (t == "C") {
						if ((f.numeroCuota.value == "") || (f.numeroCuota.value == 0)) {
							alert("DEBE SELECCIONAR NUMEROS DE CUOTAS");
							f.numeroCuota.focus();
							return;
						}
					}

			f.action = "tip_venta1.php";
			f.method = "post";
			f.submit();
		}

		function tieneDeuda() {
		    var mensaje;
            var opcion = confirm("El cliente seleccionado tiene una cuota pendiente, aun no pagada, Desea continuar a pesar de la deuda? ");
            if (opcion == true) {
             
                var f = document.form1;
				    f.tradioC.checked= true;
				 	f.numeroCuota.disabled = false;
        			f.textPasswordCambio.disabled = false;
        			f.cambiarTextPasswordCambio.disabled = false;
        	        document.getElementById("tablaMostrar").style.display = "block";

        	} else {
        	    
          document.getElementById("tablaMostrar").style.display = "none";
            document.form1.target = "venta_principal";
            window.opener.location.href = "clienteDeudaCancelo.php";
            self.close();
            
        	}
		}
		function clickContado() {
			var f = document.form1;

			textOriginal = f.textCambioOriginal.value
			document.form1.textPasswordCambio.value = textOriginal;

			f.numeroCuota.disabled = true;
			f.textPasswordCambio.disabled = true;
			f.cambiarTextPasswordCambio.disabled = true;


			$("#numeroCuota").val(0).trigger("change");

			document.getElementById("tablaMostrar").style.display = "none";
			document.getElementById("tablaMostrarCuota").style.display = "none";
			document.getElementById("cargado").innerHTML = "";
		}

		function tip1() {
			var f = document.form1;

			textOriginal = f.textCambioOriginal.value
			document.form1.textPasswordCambio.value = textOriginal;
			f.numeroCuota.disabled = true;
			f.textPasswordCambio.disabled = true;
			f.cambiarTextPasswordCambio.disabled = true;
			$("#numeroCuota").val(0).trigger("change");
			document.getElementById("tablaMostrar").style.display = "none";

		}

		function clickCredito() {
		    
			var f = document.form1;
			f.numeroCuota.disabled = false;
			f.textPasswordCambio.disabled = false;
			f.cambiarTextPasswordCambio.disabled = false;
			document.getElementById("tablaMostrar").style.display = "block";

		}

		function cerrar_popup() {

			document.form1.target = "venta_principal";
			window.opener.location.href = "salir_pago.php";
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
<?php

$sqldatagen = "SELECT diasCuotasVentas,diasCuotasVentasPassword FROM datagen ";
$resultdatagen = mysqli_query($conexion, $sqldatagen);
if (mysqli_num_rows($resultdatagen)) {
	while ($rowdatagen = mysqli_fetch_array($resultdatagen)) {
		$diasCuotasVentasDatagen    = $rowdatagen['diasCuotasVentas'];
		$diasCuotasVentasPassword    = $rowdatagen['diasCuotasVentasPassword'];
	}
}

$sql = "SELECT forpag,codtab,numtarjet,numeroCuota,ventaDiasCuotas,cuscod FROM venta where invnum = '$venta'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
	while ($row = mysqli_fetch_array($result)) {
		$forpag    = $row['forpag'];
		$numeroCuota   = $row['numeroCuota'];
		$ventaDiasCuotas   = $row['ventaDiasCuotas'];
		$codtab    = $row['codtab'];
		$numtarjet = $row['numtarjet'];
		$cuscod = $row['cuscod'];
	}
}

if ($ventaDiasCuotas == 0) {
	$diasCuotasVentas = $diasCuotasVentasDatagen;
} else {
	$diasCuotasVentas = $ventaDiasCuotas;
}

$sqlCuota = "SELECT SUM(VC.montoCobro) FROM venta_cuotas as VC INNER JOIN venta as V on V.invnum=VC.venta_id WHERE V.cuscod='$cuscod' and VC.montoCobro>0 ";
$resultCuota = mysqli_query($conexion, $sqlCuota);
if (mysqli_num_rows($resultCuota)) {
	while ($rowCuota = mysqli_fetch_array($resultCuota)) {

		$saldo_cuota = $rowCuota['0'];
	}
}


if ($forpag == 'C') {


	$sqlCli = "SELECT codcli,limiteCredito FROM cliente where  descli like '%PUBLICO EN GENERAL%'";
	$resultCli = mysqli_query($conexion, $sqlCli);
	if (mysqli_num_rows($resultCli)) {
		while ($row = mysqli_fetch_array($resultCli)) {

			$codcli = $row['codcli'];
			$limiteCredito = $row['limiteCredito'];
		}
	}

	if ($cuscod == $codcli) {
		//mysqli_query($conexion, "UPDATE venta set forpag='E',numeroCuota='0' where invnum = '$venta'"); ///controla bonificaciones
	}
}

$sqlCli2 = "SELECT codcli FROM cliente where  descli like '%PUBLICO EN GENERAL%'";
$resultCli2 = mysqli_query($conexion, $sqlCli2);
if (mysqli_num_rows($resultCli2)) {
	while ($row2 = mysqli_fetch_array($resultCli2)) {

		$codcli = $row2['codcli'];
	}
}

if ($codcli == $cuscod) {
	$publico = '1';
} else {

	$sqlCli222 = "SELECT limiteCredito FROM cliente where  codcli='$cuscod'";
	$resultCli222 = mysqli_query($conexion, $sqlCli222);
	if (mysqli_num_rows($resultCli222)) {
		while ($row222 = mysqli_fetch_array($resultCli222)) {
			$limiteCredito22 = $row222['limiteCredito'];
		}
	}
	$publico = '0';
}


$montoPermitido = $monto_total + $saldo_cuota;
//echo '$montoPermitido = '.$montoPermitido."<br>";
//echo '$limiteCredito22 = '.$limiteCredito22."<br>";


$soloDispones = $limiteCredito22 - $montoPermitido;
//echo '$soloDispones = '.$soloDispones."<br>";
if ($montoPermitido > $limiteCredito22) {
	$yaNoCredito = 1;
} else {
	$yaNoCredito = 0;
}

$sqlCuotaPago = "SELECT VC.fecha_pago FROM venta_cuotas AS VC INNER JOIN venta AS V on V.invnum=VC.venta_id INNER JOIN cliente AS C on C.codcli=V.cuscod WHERE V.forpag='C' and V.estado='0' and V.val_habil='0' and VC.montoCobro>0  and C.codcli = '$cuscod'  LIMIT 1 ";
    $resultCuotaPago = mysqli_query($conexion, $sqlCuotaPago);
    if (mysqli_num_rows($resultCuotaPago)) {
        while ($rowCuotaPago = mysqli_fetch_array($resultCuotaPago)) {
            $fecha_pago = $rowCuotaPago[0];
            
        }
         $tieneDeudas=1;
    }else{
        $tieneDeudas=0;
    }
    
    
    if($tieneDeudas ==1){
        
        if($fecha_pago <= date('Y-m-d')){
           //echo '<script language="javascript">var mensaje;var opcion = confirm("Clicka en Aceptar o Cancelar");if (opcion == true) {mensaje = "Has clickado OK";} else {	mensaje = "Has clickado Cancelar";};</script>';
        
            $entraEnDeudas=1;
        }else{
            $entraEnDeudas=0;
        }
        
    }


 // echo '$entraEnDeudas = '.$entraEnDeudas."<br>";
?>

<body onkeyup="cerra3r(event)" <?php if ($close == 1) { ?> onload="cerrar_popup();" <?php } elseif ($forpag == "T") { ?>onload="tarjet()" <?php } elseif ($forpag == "C") { ?> onload="credito()" <?php } elseif ($forpag == "E") { ?> onload="efectivo()" <?php } ?>>


	<form name="form1" id="form1">

		<table width="100%" border="0" id="customers">
		    <?php if($entraEnDeudas == 1){ ?>
		    
		    	<tr>
				<th colspan="3">
					<div align="center">
					<blink> Cliente presenta deudas </blink>
					</div>
				</th>
			</tr>
		    <?php } ?>
			<tr>
				<th colspan="3">
					<div align="center">
						FORMA DE PAGO
					</div>
				</th>
			</tr>
			<tr>
				<td>
					<input name="tradio" id="tradio" type="radio" value="E" onfocus="clickContado()" <?php if ($forpag == "E") { ?>checked="checked" <?php } ?> tabindex="1" />
					<label for="tradio_Efectivo" class="LETRA"> CONTADO</label>
				</td>
				<td>
					<input name="tradio" id="tradioC" type="radio" value="C" <?php if ($publico   == 1) { ?> onfocus="publico()" <?php } else { ?> <?php if ($yaNoCredito == 1) { ?>onfocus="pasoLimiteCredito()"<?php } else if($entraEnDeudas == 1) { ?> onfocus="tieneDeuda()"  <?php } else { ?> onfocus="clickCredito()" <?php } ?> onkeypress="return credito(event);" <?php if ($forpag == "C") { ?>checked="checked" <?php }
																																																																																					} ?> tabindex="3" />
					<label for="tradio_Credito" class="LETRA"> CREDITO</label>
				</td>
				<td>
					<div align="center">
						<input type="button" name="Submit" value="Grabar" onclick="saves();" class="grabar" tabindex="4" />
						<input name="cambioDias" type="hidden" id="cambioDias" value="0" />
					</div>
				</td>
			</tr>

		</table>
		<div id='tablaMostrar' style="display:none">
			<table width="100%" border="0" id="customers">
				<tr>
					<th>
						<span class="LETRA">NUMERO DIAS POR CUOTA</span>
					</th>
					<td>
					   <table cellpadding="0" cellspacing="0" width="100%" border="0" id="customers">
					        <tr>
					            <th>N Dias</th>
					            <th>Contraseña</th>
					            <th>Actualizar</th>
					        </tr>
					        <tr>
					            <td>
					                <input name="textPasswordCambio" size=3 type="text" id="textPasswordCambio" onkeypress="return enters(event);" value="<?php echo $diasCuotasVentas ?>" />
					                <input name="textCambioOriginal" type="hidden" id="textCambioOriginal" value="<?php echo $diasCuotasVentasDatagen ?>" />
					                <input name="ventaDiasCuotas" type="hidden" id="ventaDiasCuotas" value="<?php echo $ventaDiasCuotas ?>" />
					                <input name="diasCuotasVentas" type="hidden" id="diasCuotasVentas" value="<?php echo $diasCuotasVentas ?>" />
						            <input name="monto_total" type="hidden" id="monto_total" value="<?php echo $monto_total ?>" />
					            </td>
					            <td>
					                	<input name="passwordText" type="password" id="passwordText" value=""placeholder="Contraseña de cambio" />
					            </td>
					            <td>
					                <input class="botonimagenUpdate" size="15" name="cambiarTextPasswordCambio" type="button" id="cambiarTextPasswordCambio" class="imprimir"    onClick="cambiarPassword('<?php echo $diasCuotasVentasPassword; ?>','<?php echo $venta; ?>');" title="Click para validar si la contraseña ingresada es valida para concluir con el proceso."/>
					            </td>
					        </tr>
					    </table>
							<span id='cargado' style="color:red;"></span>
					</td>
				</tr>
				<tr>
					<th><span class="LETRA">NUMERO CUOTAS</span></th>
					<td>
						<select name="numeroCuota" id="numeroCuota" style="width: 250px	;" onclick="cargarContenido();" onkeyup="cargarContenido()" onchange="cargarContenido();">
							<option value="0">Seleccione numero Cuotas...</option>
							<?php for ($i = 1; $i <= 36; $i++) {
							?>
								<option value="<?php echo $i; ?>" <?php if ($numeroCuota == $i) { ?>selected="selected" <?php } ?>><?php echo $i; ?></option>
							<?php }
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="color:red;">
						<?php echo 'NUMERO DIAS POR CUOTA POR DEFECTO ESTA EN ' . $diasCuotasVentasDatagen . ' DIAS.' ?>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<p>Su linea de credito es: <?php echo   $limiteCredito22; ?></p>
						<p>Su linea de credito disponible es: <?php echo   $soloDispones; ?></p>

					</td>
				</tr>
				<tr>
					<td colspan="2">
						<div id='tablaMostrarCuota' style="display:none">
						    <div class="Scroll">
							<table width="100%" border="0" id="customers" cellpadding="0" cellspacing="0">
								<thead>
								    <tr>
								        <th colspan="3">
								            <div align="center">
								                CALCULO DE CUOTAS
								            </div>
								        </th>
								    </tr>
									<tr>
										<th>Cuotas</th>
										<th>Fechas de pago</th>
										<th>Monto Pago</th>
									</tr>
								</thead>

								<tbody id='tbodyPagos'>

								</tbody>

							</table>
						</div>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</form>

	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	  
 
   <!-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>-->
</body>

</html>
<script type="text/javascript">
	$('#numeroCuota').select2();

	$("#tarjeta").select2({
		placeholder: "sometext",
		allowClear: false,
		tags: true
	});
	/*
$('#tabla').DataTable({
                 "pageLength": 100,
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ning������n dato disponible en esta tabla =(",
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
                        "sLast": "����ltimo",
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
                },
                dom: 'Bfrtip',
                buttons: [
                    //'copy', 'csv', 'excel', 'pdf', 'print'
                    'excel'
                ]
                
            });*/
	
	
</script>