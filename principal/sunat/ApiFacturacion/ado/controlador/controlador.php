<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("../../../../conexion.php");


require_once("../xml.php");
require_once("../funciones.php");
require_once("../ApiFacturacion.php");
function remplazar_string($string)
{
	$string = trim($string);

	$string = str_replace(
		array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
		array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
		$string
	);

	$string = str_replace(
		array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
		array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
		$string
	);

	$string = str_replace(
		array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
		array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
		$string
	);

	$string = str_replace(
		array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
		array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
		$string
	);

	$string = str_replace(
		array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
		array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
		$string
	);

	$string = str_replace(
		array('ñ', 'Ñ', 'ç', 'Ç'),
		// array('n', 'N', 'c', 'C',),
		array('ñ', 'Ñ', 'c', 'C',),
		$string
	);

	//Esta parte se encarga de eliminar cualquier caracter extraño
	$string = str_replace(
		array(
			"\\", "Â¨", "Âº",  "~",
			"@", "|", "!", "\"",
			"$", "?",  "Â¡",
			"Â¿", "[", "^", "`", "]",
			"}", "{", "Â¨", "Â´",
			">", "< ", ";", ",", "'", ":", "Â¥", "â€¡", "Ã¹", "Ã¾", "¥", "§", "Œ", "œ", "Š", "š", "Ÿ", "ƒ", "�",


		),
		'',
		$string
	);
	return $string;
}

$accion = $_POST['action'];

controlador($accion, $conexion);

function controlador($accion, $conexion)
{

	// $objCompartido = new clsCompartido();
	// $objEmisor = new clsEmisor();
	$generadoXML = new GeneradorXML();
	$api = new ApiFacturacion();
	// $objVenta = new clsVenta();
	// $objNC = new clsNotaCredito();
	// $objND = new clsNotaDebito();
	// $objCliente = new clsCliente();
	echo 'accion = ' . $accion;
	switch ($accion) {

		case 'GUARDAR_NC':
			$id = addslashes($_POST['id']);

			$sqlnota = "SELECT * FROM nota where invnum = '$id'";
			$resultnota = mysqli_query($conexion, $sqlnota);
			if (mysqli_num_rows($resultnota)) {
				$nota = mysqli_fetch_array($resultnota);
			}

			$sucursal = $nota['sucursal'];
			$sqlemisor = "SELECT * FROM emisor where id = $sucursal";
			$resultemisor = mysqli_query($conexion, $sqlemisor);
			if (mysqli_num_rows($resultemisor)) {
				$emisor = mysqli_fetch_array($resultemisor);
			}

			$idcliente = $nota['cuscod'];
			$sqlcodcli = "SELECT * FROM cliente where codcli = '$idcliente'";
			$resultcodcli = mysqli_query($conexion, $sqlcodcli);
			if (mysqli_num_rows($resultcodcli)) {
				$datosCliente = mysqli_fetch_array($resultcodcli);
			}

			$tipdoc = $nota['tipdoc'];
			$tipodocCliente = ($tipdoc == 1)  ? '6' : '1';
			$nrodocCliente = ($tipdoc == 1)  ? $datosCliente['ruccli'] :  $datosCliente['dnicli'];




			$cliente = array(
				'tipodoc'		=> $tipodocCliente, //6->ruc, 1-> dni 
				'ruc'			=> $nrodocCliente,
				'razon_social'  => $datosCliente['descli'],
				'direccion'		=>  $datosCliente['dircli'],
				'pais'			=> 'PE'
			);


			$detalle = array();
			$igv_porcentaje = 0.18;
			$op_gravadas = 0.00;
			$op_exoneradas = 0.00;
			$op_inafectas = 0.00;
			$igv = 0;

			$sqldetalle_nota = "SELECT * FROM detalle_nota where invnum = '$id'";
			$resultdetalle_nota = mysqli_query($conexion, $sqldetalle_nota);
			$k = 0;
			while ($v = mysqli_fetch_array($resultdetalle_nota, MYSQLI_ASSOC)) {
				//foreach ($carrito as $k => $v) {
				$k++;
				$codigoProducto = $v['codpro'];
				$sqlproducto = "SELECT * FROM producto where codpro = '$codigoProducto'";
				$resultproducto = mysqli_query(
					$conexion,
					$sqlproducto
				);
				if (mysqli_num_rows($resultproducto)) {
					$producto = mysqli_fetch_array($resultproducto);
				}

				$productoCodigoafectacion = ($producto['igv'] == 1)  ? '10' : '20';

				$sqlafectacion = "SELECT * FROM tipo_afectacion where codigo = '$productoCodigoafectacion'";
				$resultafectacion = mysqli_query($conexion, $sqlafectacion);
				if (mysqli_num_rows($resultafectacion)) {
					$afectacion = mysqli_fetch_array($resultafectacion);
				}

				$igv_detalle = 0;
				$factor_porcentaje = 1;
				/*	if ($producto['codigoafectacion'] == 10) {
					$igv_detalle = $v['precio'] * $v['cantidad'] * $igv_porcentaje;
					$factor_porcentaje = 1 + $igv_porcentaje;
				}*/

				if ($productoCodigoafectacion == 10) {
					$igv_detalle = $v['prisal'] * $v['canpro'] * $igv_porcentaje;
					$factor_porcentaje = 1 + $igv_porcentaje;
				}

				$codproducto = $producto['codpro'];
				$unidad = 'NIU';
				$descripcion = remplazar_string(htmlspecialchars($producto['desprod']));
				$cantidad = $v['canpro'];
				$valunitario = ($v['prisal'] / ($factor_porcentaje));
				$valventa = ($v['pripro'] / ($factor_porcentaje));
				$baseigv = $valventa;
				$pcntjeigv = $factor_porcentaje * 100;
				$valigv = $baseigv * $factor_porcentaje;
				$totalimpuesto = $valigv;
				$preciounitario = $v['prisal'];
				$itemx = array(
					'item' 					=> $k,
					'codigo'				=> trim($codproducto),
					'descripcion'			=> trim($descripcion),
					'cantidad'				=> number_format(
						$cantidad,
						2,
						'.',
						''
					),
					'valor_unitario'		=> number_format($valunitario, 2, '.', ''),
					'precio_unitario'		=> number_format($valventa, 2, '.', ''),
					'tipo_precio'			=> '01', //ya incluye igv
					'igv'					=> number_format($igv_detalle, 2, '.', ''),
					'porcentaje_igv'		=> number_format($igv_porcentaje * 100, 2, '.', ''),
					'valor_total'			=> number_format($v['prisal'] * $v['canpro'], 2, '.', ''),
					'importe_total'			=> number_format($v['pripro'] * $v['canpro'] * $factor_porcentaje, 2, '.', ''),
					'unidad'				=> $unidad, //unidad,
					'codigo_afectacion_alt'	=> $productoCodigoafectacion,
					'codigo_afectacion'		=> $afectacion['codigo_afectacion'],
					'nombre_afectacion'		=> $afectacion['nombre_afectacion'],
					'tipo_afectacion'		=> $afectacion['tipo_afectacion']
				);


				$itemx;

				$detalle[] = $itemx;

				if ($itemx['codigo_afectacion_alt'] == 10) {
					$op_gravadas = $op_gravadas + $itemx['valor_total'];
				}

				if ($itemx['codigo_afectacion_alt'] == 20) {
					$op_exoneradas = $op_exoneradas + $itemx['valor_total'];
				}

				if ($itemx['codigo_afectacion_alt'] == 30) {
					$op_inafectas = $op_inafectas + $itemx['valor_total'];
				}

				$igv = $igv + $igv_detalle;
			}

			$total = $op_gravadas + $op_exoneradas + $op_inafectas + $igv;





			$tipodocVenta = '07';
			$idserie = ($nota['tipdoc '] == 1)  ? '1' : '3';
			$doc = explode('-', $nota['nrofactura']);
			$serie_doc = explode('-', $nota['serie_doc']);
			$serie = $doc[0];
			$correlativo = str_pad($doc[1], 8, '0', STR_PAD_LEFT);

			$serieOLD = $serie_doc[0];
			$correlativoOLD = str_pad($serie_doc[1], 8, '0', STR_PAD_LEFT);


			$comprobante =	array(
				'tipodoc'				=> $tipodocVenta,
				'idserie'				=> $idserie,
				'serie'					=> $serie,
				'correlativo'			=> $correlativo,
				'fecha_emision' 		=> $nota['invfec'],
				'moneda'				=> 'PEN', //PEN->SOLES; USD->DOLARES
				'total_opgravadas'		=> number_format($op_gravadas, 2, '.', ''),
				'igv'					=> number_format($igv, 2, '.', ''),
				'total_opexoneradas'	=> number_format($op_exoneradas, 2, '.', ''),
				'total_opinafectas'		=> number_format($op_inafectas, 2, '.', ''),
				'total'					=> number_format($total, 2, '.', ''),
				'total_texto'			=> convertNumberToWord($total, 'PEN'),
				'codcliente'			=> $nota['cuscod'],
				'tipodoc_ref'			=> $nota['tipdoc_afec'],
				'serie_ref'				=> $serieOLD,
				'correlativo_ref' 		=> $correlativoOLD,
				'codmotivo'				=> $nota['codnc'],
				'descripcion'			=> $nota['anotacion'],
			);

			$ruta = "../" . $emisor['ruc'] . '/xml/';
			$nombre = $emisor['ruc'] . '-' . $comprobante['tipodoc'] . '-' . $comprobante['serie'] . '-' . $comprobante['correlativo'];

			$generadoXML->CrearXMLNotaCredito($ruta . $nombre, $emisor, $cliente, $comprobante, $detalle);

			$response = $api->EnviarComprobanteElectronico($emisor, $nombre, "../", "../" . $emisor['ruc'] . "/xml/", "../" . $emisor['ruc'] . "/cdr/");

			$enviador 		= $response['status'];
			$code 			= $response['ResponseCode'];
			$description 	= $response['Description'];
			$hash 			= $response['hash'];
			$description = str_replace("'", "", $description);
			if ($enviador > 0 and $code == '0') {
				$fenvio 	= date('Y-m-d H:i:s');
				$enviado 	= 1;
			} else {
				$fenvio 	= '0000-00-00';
				$enviado 	= 0;
			}

			mysqli_query($conexion, "UPDATE nota SET sunat_fenvio = '$fenvio', sunat_enviado = '$enviado', sunat_respuesta_codigo = '$code', sunat_respuesta_descripcion = '$description', sunat_hash = '$hash' WHERE invnum = '$id'");

			// print_r($response);

			break;

		case 'GUARDAR_VENTA':
			$id = addslashes($_POST['id']);


			$sqlboleta = "SELECT * FROM venta where invnum = '$id'";
			$resultboleta = mysqli_query($conexion, $sqlboleta);
			if (mysqli_num_rows($resultboleta)) {
				$boleta = mysqli_fetch_array($resultboleta);
			}
			$sqldatagen = "SELECT * FROM datagen  ";
			$resultdatagen = mysqli_query($conexion, $sqldatagen);
			if (mysqli_num_rows($resultdatagen)) {
				$datagen = mysqli_fetch_array($resultdatagen);
			}
			$sucursal = $boleta['sucursal'];
			//obtenemos los datos del emisor de la BD
			$sqlemisor = "SELECT * FROM emisor where id = '$sucursal'";
			$resultemisor = mysqli_query($conexion, $sqlemisor);
			if (mysqli_num_rows($resultemisor)) {
				$emisor = mysqli_fetch_array($resultemisor);
			}

			$idcliente = $boleta['cuscod'];

			$sqlcodcli = "SELECT * FROM cliente where codcli = '$idcliente'";
			$resultcodcli = mysqli_query($conexion, $sqlcodcli);
			if (mysqli_num_rows($resultcodcli)) {
				$datosCliente = mysqli_fetch_array($resultcodcli);
			}

			$tipodocCliente = ($boleta['tipdoc'] == 1)  ? '6' : '1';
			$nrodocCliente = ($boleta['tipdoc'] == 1)  ? $datosCliente['ruccli'] :  $datosCliente['dnicli'];


			$cliente = array(
				'tipodoc'		=> $tipodocCliente, //6->ruc, 1-> dni 
				'ruc'			=> $nrodocCliente,
				'razon_social'  => $datosCliente['descli'],
				'direccion'		=>  $datosCliente['dircli'],
				'pais'			=> 'PE'
			);


			// $carrito = $_SESSION['carrito'];
			$detalle = array();


			$porcentajeigv = 0;
			$igvtabla = mysqli_query($conexion, "SELECT porcent FROM datagen ORDER BY cdatagen DESC LIMIT 1");
			while ($rowigvtabla = mysqli_fetch_array($igvtabla, MYSQLI_ASSOC)) {
				$porcentajeigv = (float)$rowigvtabla['porcent'];
				$porcentajeigv = $porcentajeigv / 100;
			}

			$op_gravadas = 0.00;
			$op_exoneradas = 0.00;
			$op_inafectas = 0.00;
			$igv = 0;
			$total = 0;

			$sqldetalle_venta = "SELECT * FROM detalle_venta where invnum = '$id'";
			$resultdetalle_venta = mysqli_query($conexion, $sqldetalle_venta);

			$k = 0;
			// foreach ($detalleVenta as $k => $v) {
			while ($v = mysqli_fetch_array($resultdetalle_venta, MYSQLI_ASSOC)) {
				$k++;

				$porcentaje = $porcentajeigv;


				$codigoProducto = $v['codpro'];
				$sqlproducto = "SELECT * FROM producto where codpro = '$codigoProducto'";
				$resultproducto = mysqli_query($conexion, $sqlproducto);
				if (mysqli_num_rows($resultproducto)) {
					$producto = mysqli_fetch_array($resultproducto);
				}

				if ($producto['igv'] == 1) {
					$productoCodigoafectacion = '10'; //GRAVADO - OPERACION ONEROSA
				} else {
					$porcentaje = 0;
					$productoCodigoafectacion = '20'; //EXONERADO - OPERACION ONEROSA
				}


				$sqlafectacion = "SELECT * FROM tipo_afectacion where codigo = '$productoCodigoafectacion'";
				$resultafectacion = mysqli_query($conexion, $sqlafectacion);
				if (mysqli_num_rows($resultafectacion)) {
					$afectacion = mysqli_fetch_array($resultafectacion);
				}

				$factor_porcentaje = 1;


				$codproducto = $producto['codpro'];
				$unidad = 'NIU';
				$descripcion = remplazar_string(htmlspecialchars($producto['desprod']));
				$cantidad = $v['canpro'];
				$valunitario = ($v['pripro']);
				$valor_total = $valunitario / (1 + $porcentaje);
				$pcntjeigv = $porcentaje;
				$valventa = ($v['prisal']);
				$igv_detalle = $valunitario - $valor_total;
				$valunitarioPor = $valventa  / (1 + $porcentaje);

				$baseigv = $valventa;
				$valigv = $baseigv * $factor_porcentaje;
				$totalimpuesto = $valigv;
				$preciounitario = $v['prisal'];



				$op=($v['prisal'] * $v['canpro'] * $factor_porcentaje);
				$itemx = array(
					'item' 					=> $k,
					'codigo'				=> trim($codproducto),
					'descripcion'			=> trim($descripcion),
					'cantidad'				=> number_format($cantidad, 2, '.', ''),
					'valor_unitario'		=> number_format($valunitarioPor, 4, '.', ''),
					'precio_unitario'		=> number_format($valventa, 2, '.', ''),
					'tipo_precio'			=> '01', //ya incluye igv
					'igv'					=> number_format($igv_detalle, 2, '.', ''),
					'porcentaje_igv'		=> number_format($pcntjeigv * 100, 2, '.', ''),
					'valor_total'			=> number_format($valor_total, 2, '.', ''),
					'importe_total'			=> number_format($op, 2, '.', ''),
					'unidad'				=> $unidad, //unidad,
					'codigo_afectacion_alt'	=> $productoCodigoafectacion,
					'codigo_afectacion'		=> $afectacion['codigo_afectacion'],
					'nombre_afectacion'		=> $afectacion['nombre_afectacion'],
					'tipo_afectacion'		=> $afectacion['tipo_afectacion']
				);

				$itemx;

				$detalle[] = $itemx;
			}
			//var_dump($boleta);

			$igv 				= $boleta['igv'];
			$total 				= $boleta['invtot'];
			$op_gravadas 		= $boleta['gravado'];
			$op_inafectas 		= $boleta['inafecto'];
			$tipodocVenta 		= ($boleta['tipdoc'] == 1)  ? '01' : '03';
			$idserie 			= ($boleta['tipdoc'] == 1)  ? '1' : '3';
			$doc 				= explode('-', $boleta['nrofactura']);
			$serie 				= $doc[0];
			$correlativo 		= str_pad($doc[1], 8, '0', STR_PAD_LEFT);

			$formaPagoActivo 	= ($boleta['numeroCuota'] > 0)  ? '1' : '0';
			if ($boleta['numeroCuota'] > 0) {
				$formaPagoMontoApagarPorMes	= $total / $boleta['numeroCuota'];
			} else {

				$formaPagoMontoApagarPorMes	= 0;
			}



			$comprobante 		= array(
				'tipodoc'				=> $tipodocVenta,
				'idserie'				=> $idserie,
				'serie'					=> $serie,
				'correlativo'			=> $correlativo,
				'fecha_emision' 		=> $boleta['invfec'],
				'moneda'				=> 'PEN', //PEN->SOLES; USD->DOLARES
				'total_opgravadas'		=> number_format($op_gravadas, 2, '.', ''),
				'igv'					=> number_format($igv, 2, '.', ''),
				'total_opexoneradas' 	=> number_format($op_exoneradas, 2, '.', ''),
				'total_opinafectas'		=> number_format($op_inafectas, 2, '.', ''),
				'total'					=> number_format($total, 2, '.', ''),
				'total_texto'			=> convertNumberToWord($total, 'PEN'),
				'codcliente'			=> $boleta['cuscod'],
				'numeroCuota'			=> $boleta['numeroCuota'],
				'formaPagoActivo'		=> $formaPagoActivo,
				'formaPagoMontoApagarPorMes' => number_format($formaPagoMontoApagarPorMes, 2, '.', ''),
				'diasCuotasVentas' 		=> $datagen['diasCuotasVentas']
			);

			$ruta = "../" . $emisor['ruc'] . "/xml/";
			$nombre = $emisor['ruc'] . '-' . $comprobante['tipodoc'] . '-' . $comprobante['serie'] . '-' . $comprobante['correlativo'];

			if ($comprobante['tipodoc'] == '01' || $comprobante['tipodoc'] == '03') {
				$generadoXML->CrearXMLFactura($ruta . $nombre, $emisor, $cliente, $comprobante, $detalle);
			}

			$response = $api->EnviarComprobanteElectronico($emisor, $nombre, "../", "../" . $emisor['ruc'] . "/xml/", "../" . $emisor['ruc'] . "/cdr/");

			// print_r($response);
			// echo '$id = ' . $id . "<br/>";
			$enviador 		= $response['status'];
			$code 			= $response['ResponseCode'];
			$description 	= $response['Description'];
			$hash 			= $response['hash'];

			// $description1 = str_replace("El comprobante fue registrado previamente con otros datos -", "", $description);
			$description = str_replace("'", "", $description);


			if ($enviador > 0 and $code == '0') {
				$fenvio 	= date('Y-m-d H:i:s');
				$enviado 	= 1;
			} else {
				$fenvio 	= '0000-00-00';
				$enviado 	= 0;
			}


			mysqli_query($conexion, "UPDATE venta SET sunat_fenvio = '$fenvio',sunat_enviado = '$enviado',sunat_respuesta_codigo = '$code',sunat_respuesta_descripcion = '$description',sunat_hash = '$hash',sisFacturacion='$enviado' WHERE invnum = '$id'");

			break;
		case 'GUARDAR_VENTA_MASIVO':
			$date 		= addslashes($_POST['date']);
			$sucursal 	= addslashes($_POST['sucursal']);
			// $id 		= addslashes($_POST['id']);




			$sqldetalle_ventaMasiva = "SELECT invnum FROM venta  as v  WHERE v.invfec = '$date' AND (v.nrofactura LIKE 'F%' OR v.nrofactura LIKE 'B%') AND LENGTH(v.nrofactura) > 0 AND v.sucursal = '$sucursal'  and v.sunat_enviado=0  and v.sunat_respuesta_descripcion=''  ORDER BY v.correlativo ASC";
			$resultdetalle_ventaMasiva = mysqli_query($conexion, $sqldetalle_ventaMasiva);


			while ($ventaMasiva = mysqli_fetch_array($resultdetalle_ventaMasiva, MYSQLI_ASSOC)) {

				$id = $ventaMasiva['invnum'];

				$sqlboleta = "SELECT * FROM venta where invnum = '$id'";
				$resultboleta = mysqli_query($conexion, $sqlboleta);
				if (mysqli_num_rows($resultboleta)) {
					$boleta = mysqli_fetch_array($resultboleta);
				}
				$sqldatagen = "SELECT * FROM datagen  ";
				$resultdatagen = mysqli_query($conexion, $sqldatagen);
				if (mysqli_num_rows($resultdatagen)) {
					$datagen = mysqli_fetch_array($resultdatagen);
				}

				$sucursal = $boleta['sucursal'];
				//obtenemos los datos del emisor de la BD
				$sqlemisor = "SELECT * FROM emisor where id = '$sucursal'";
				$resultemisor = mysqli_query($conexion, $sqlemisor);
				if (mysqli_num_rows($resultemisor)) {
					$emisor = mysqli_fetch_array($resultemisor);
				}

				$idcliente = $boleta['cuscod'];

				$sqlcodcli = "SELECT * FROM cliente where codcli = '$idcliente'";
				$resultcodcli = mysqli_query($conexion, $sqlcodcli);
				if (mysqli_num_rows($resultcodcli)) {
					$datosCliente = mysqli_fetch_array($resultcodcli);
				}

				$tipodocCliente = ($boleta['tipdoc'] == 1)  ? '6' : '1';
				$nrodocCliente = ($boleta['tipdoc'] == 1)  ? $datosCliente['ruccli'] :  $datosCliente['dnicli'];


				$cliente = array(
					'tipodoc'		=> $tipodocCliente, //6->ruc, 1-> dni 
					'ruc'			=> $nrodocCliente,
					'razon_social'  => $datosCliente['descli'],
					'direccion'		=>  $datosCliente['dircli'],
					'pais'			=> 'PE'
				);


				// $carrito = $_SESSION['carrito'];
				$detalle = array();


				$porcentajeigv = 0;
				$igvtabla = mysqli_query($conexion, "SELECT porcent FROM datagen ORDER BY cdatagen DESC LIMIT 1");
				while ($rowigvtabla = mysqli_fetch_array($igvtabla, MYSQLI_ASSOC)) {
					$porcentajeigv = (float)$rowigvtabla['porcent'];
					$porcentajeigv = $porcentajeigv / 100;
				}

				$op_gravadas = 0.00;
				$op_exoneradas = 0.00;
				$op_inafectas = 0.00;
				$igv = 0;
				$total = 0;

				$sqldetalle_venta = "SELECT * FROM detalle_venta where invnum = '$id'";
				$resultdetalle_venta = mysqli_query($conexion, $sqldetalle_venta);

				$k = 0;
				// foreach ($detalleVenta as $k => $v) {
				while ($v = mysqli_fetch_array($resultdetalle_venta, MYSQLI_ASSOC)) {
					$k++;

					$porcentaje = $porcentajeigv;


					$codigoProducto = $v['codpro'];
					$sqlproducto = "SELECT * FROM producto where codpro = '$codigoProducto'";
					$resultproducto = mysqli_query($conexion, $sqlproducto);
					if (mysqli_num_rows($resultproducto)) {
						$producto = mysqli_fetch_array($resultproducto);
					}

					if ($producto['igv'] == 1) {
						$productoCodigoafectacion = '10'; //GRAVADO - OPERACION ONEROSA
					} else {
						$porcentaje = 0;
						$productoCodigoafectacion = '20'; //EXONERADO - OPERACION ONEROSA
					}


					$sqlafectacion = "SELECT * FROM tipo_afectacion where codigo = '$productoCodigoafectacion'";
					$resultafectacion = mysqli_query($conexion, $sqlafectacion);
					if (mysqli_num_rows($resultafectacion)) {
						$afectacion = mysqli_fetch_array($resultafectacion);
					}

					$factor_porcentaje = 1;


					$codproducto = $producto['codpro'];
					$unidad = 'NIU';
					$descripcion = remplazar_string(htmlspecialchars($producto['desprod']));
					$cantidad = $v['canpro'];
					$valunitario = ($v['pripro']);
					$valor_total = $valunitario / (1 + $porcentaje);
					$pcntjeigv = $porcentaje;
					$valventa = ($v['prisal']);
					$igv_detalle = $valunitario - $valor_total;
					$valunitarioPor = $valventa  / (1 + $porcentaje);

					$baseigv = $valventa;
					$valigv = $baseigv * $factor_porcentaje;
					$totalimpuesto = $valigv;
					$preciounitario = $v['prisal'];



					$op=($v['prisal'] * $v['canpro'] * $factor_porcentaje);
					$itemx = array(
						'item' 					=> $k,
						'codigo'				=> trim($codproducto),
						'descripcion'			=> trim($descripcion),
						'cantidad'				=> number_format($cantidad, 2, '.', ''),
						'valor_unitario'		=> number_format($valunitarioPor, 2, '.', ''),
						'precio_unitario'		=> number_format($valventa, 2, '.', ''),
						'tipo_precio'			=> '01', //ya incluye igv
						'igv'					=> number_format($igv_detalle, 2, '.', ''),
						'porcentaje_igv'		=> number_format($pcntjeigv * 100, 2, '.', ''),
						'valor_total'			=> number_format($valor_total, 2, '.', ''),
						'importe_total'			=> number_format($op, 2, '.', ''),
						'unidad'				=> $unidad, //unidad,
						'codigo_afectacion_alt'	=> $productoCodigoafectacion,
						'codigo_afectacion'		=> $afectacion['codigo_afectacion'],
						'nombre_afectacion'		=> $afectacion['nombre_afectacion'],
						'tipo_afectacion'		=> $afectacion['tipo_afectacion']
					);

					$itemx;

					$detalle[] = $itemx;
				}
				//var_dump($boleta);

				$igv 				= $boleta['igv'];
				$total 				= $boleta['invtot'];
				$op_gravadas 		= $boleta['gravado'];
				$op_inafectas 		= $boleta['inafecto'];
				$tipodocVenta 		= ($boleta['tipdoc'] == 1)  ? '01' : '03';
				$idserie 			= ($boleta['tipdoc'] == 1)  ? '1' : '3';
				$doc 				= explode('-', $boleta['nrofactura']);
				$serie 				= $doc[0];
				$correlativo 		= str_pad($doc[1], 8, '0', STR_PAD_LEFT);
				$formaPagoActivo 	= ($boleta['numeroCuota'] > 0)  ? '1' : '0';
				if ($boleta['numeroCuota'] > 0) {
					$formaPagoMontoApagarPorMes	= $total / $boleta['numeroCuota'];
				} else {

					$formaPagoMontoApagarPorMes	= 0;
				}

				$comprobante 		= array(
					'tipodoc'				=> $tipodocVenta,
					'idserie'				=> $idserie,
					'serie'					=> $serie,
					'correlativo'			=> $correlativo,
					'fecha_emision' 		=> $boleta['invfec'],
					'moneda'				=> 'PEN', //PEN->SOLES; USD->DOLARES
					'total_opgravadas'		=> number_format($op_gravadas, 2, '.', ''),
					'igv'					=> number_format($igv, 2, '.', ''),
					'total_opexoneradas' 	=> number_format($op_exoneradas, 2, '.', ''),
					'total_opinafectas'		=> number_format($op_inafectas, 2, '.', ''),
					'total'					=> number_format($total, 2, '.', ''),
					'total_texto'			=> convertNumberToWord($total, 'PEN'),
					'codcliente'			=> $boleta['cuscod'],
					'numeroCuota'			=> $boleta['numeroCuota'],
					'formaPagoActivo'		=> $formaPagoActivo,
					'formaPagoMontoApagarPorMes' => number_format($formaPagoMontoApagarPorMes, 2, '.', ''),
					'diasCuotasVentas' 		=> $datagen['diasCuotasVentas']
				);


				$ruta = "../" . $emisor['ruc'] . "/xml/";
				$nombre = $emisor['ruc'] . '-' . $comprobante['tipodoc'] . '-' . $comprobante['serie'] . '-' . $comprobante['correlativo'];

				if ($comprobante['tipodoc'] == '01' || $comprobante['tipodoc'] == '03') {
					$generadoXML->CrearXMLFactura($ruta . $nombre, $emisor, $cliente, $comprobante, $detalle);
				}

				$response = $api->EnviarComprobanteElectronico($emisor, $nombre, "../", "../" . $emisor['ruc'] . "/xml/", "../" . $emisor['ruc'] . "/cdr/");

				$enviador 		= $response['status'];
				$code 			= $response['ResponseCode'];
				$description 	= $response['Description'];
				$hash 			= $response['hash'];
				$description = str_replace("'", "", $description);
				if ($enviador > 0 and $code == '0') {
					$fenvio 	= date('Y-m-d H:i:s');
					$enviado 	= 1;
				} else {
					$fenvio 	= '0000-00-00';
					$enviado 	= 0;
				}
				$description = str_replace("'", "", $description);
				mysqli_query($conexion, "UPDATE venta SET sunat_fenvio = '$fenvio', sunat_enviado = '$enviado', sunat_respuesta_codigo = '$code', sunat_respuesta_descripcion = '$description', sunat_hash = '$hash',sisFacturacion='$enviado' WHERE invnum = '$id'");
			}

			break;

		case "ENVIO_RESUMEN":

			$date = addslashes($_POST['date']);
			$sucursal = addslashes($_POST['sucursal']);

			$serie = date('Ymd');

			$now = date('Y-m-d');
			//$sql = mysqli_query($conexion, "SELECT resumen_id FROM venta_resumen WHERE resumen_fecha = '$now'");
			$sql = mysqli_query($conexion, "SELECT resumen_id FROM venta_resumen WHERE resumen_generacion = '$now'");
			$n = mysqli_num_rows($sql);
			$n++;
			$n = str_pad($n, 3, '0', STR_PAD_LEFT);
			$resumen_boleta = 'RC-' . str_replace('-', '', $now) . '-' . $n;



			$sqlemisor = "SELECT * FROM emisor where id = $sucursal";
			$resultemisor = mysqli_query($conexion, $sqlemisor);
			if (mysqli_num_rows($resultemisor)) {
				$emisor = mysqli_fetch_array($resultemisor);
			}


			$cabecera = array(
				"tipodoc"		=> "RC",
				"serie"			=> $serie,
				"correlativo"	=> $n,
				"fecha_emision" => $date,
				"fecha_envio"	=> date('Y-m-d')
			);


			$items = array();
			$k = 0;
			$sql3 = mysqli_query($conexion, "SELECT v.*, c.dnicli, c.ruccli, c.dircli, c.descli FROM venta AS v LEFT JOIN cliente AS c ON v.cuscod = c.codcli WHERE v.invfec = '$date' AND v.nrofactura LIKE 'B%' AND v.sunat_enviado = 0 AND LENGTH(v.nrofactura) > 0 AND v.sucursal = '$sucursal' ORDER BY v.correlativo ASC");
			while ($key3 = mysqli_fetch_array($sql3, MYSQLI_ASSOC)) {
				$k++;
				$doc = explode('-', trim($key3['nrofactura']));
				$serie = $doc[0];
				$numero = str_pad($doc[1], 8, '0', STR_PAD_LEFT);
				$serienumero = $serie . '-' . $numero;
				$total = ($key3['invtot'] < 0) ? 0 : $key3['invtot'];
				$opgravadas = ($key3['gravado'] < 0) ? 0 : $key3['gravado'];
				$opinafectas = ($key3['inafecto'] < 0) ? 0 : $key3['inafecto'];
				$opexoneradas = 0;
				$igv = ($key3['igv'] < 0) ? 0 : $key3['igv'];
				$tipodoc = '03';
				$clitipo = '1';
				$clinro = trim($key3['dnicli']);
				if ($total > 0) {

					$items[] = array(
						"item"				=> $k,
						"invnum"			=> $key3['invnum'],
						"tipodoc"			=> $tipodoc,
						"serie"				=> $serie,
						"correlativo"		=> $numero,
						"condicion"			=> 1, //1->Registro, 2->Actuali, 3->Bajas
						"moneda"			=> 'PEN',
						"importe_total"		=> round($total, 2),
						"valor_total"		=> round($opgravadas, 2),
						"igv_total"			=> round($igv, 2),
						"tipo_total"		=> "01", //GRA->01, EXO->02, INA->03
						"codigo_afectacion"	=> "1000",
						"nombre_afectacion"	=> "IGV",
						"tipo_afectacion"	=> "VAT",
						"serienumero"	=> $serienumero
					);
				}
			}

			$resumen_documentos = '';
			foreach ($items  as $key) {
				$resumen_documentos .= $key['serienumero'] . ', ';
			}
			$resumen_documentos = substr($resumen_documentos, 0, -2);
			// echo 'resumen_documentos = ' . $resumen_documentos;
			// print_r($resumen_documentos);

			$ruta = "../" . $emisor['ruc'] . "/xml/";
			$nombrexml = $emisor['ruc'] . '-' . $cabecera['tipodoc'] . '-' . $cabecera['serie'] . '-' . $cabecera['correlativo'];

			$generadoXML->CrearXMLResumenDocumentos($emisor, $cabecera, $items, $ruta . $nombrexml);


			$ticket = $api->EnviarResumenComprobantes($emisor, $nombrexml, "../", "../" . $emisor['ruc'] . "/xml/");

			$response = $api->ConsultarTicket($emisor, $cabecera, $ticket, "../" . $emisor['ruc'] . "/cdr/");
			// print_r($ticket);
			// print_r($response);

			$enviador 			= $response['status'];
			$code 				= $response['ResponseCode'];
			$resumen_resumen 	= $response['ReferenceID'];
			$description 		= $response['Description'];
			// $hash 				= $ticket['hash_cpe'];
			$hash 				= '';
			$resumen_fecha 		= $date;
			$description = str_replace("'", "", $description);
			if ($enviador > 0 and $code == '0') {
				$resumen_generacion 	= date('Y-m-d');
				$enviado 	= 1;
			} else {
				$resumen_generacion 	= '0000-00-00';
				$enviado 	= 0;
			}
			if ($enviado 	== 1) {
				$insert = mysqli_query($conexion, "INSERT INTO venta_resumen (resumen_fecha, resumen_generacion, resumen_resumen, resumen_documentos, resumen_respuesta_codigo, resumen_respuesta_descripcion, resumen_hash, resumen_ticket, sucursal) VALUES ('$resumen_fecha', '$resumen_generacion', '$resumen_resumen', '$resumen_documentos', '$code', '$description', '$hash', '$ticket', '$sucursal')");
				if ($insert) {
					$rd_id = mysqli_insert_id($conexion);
					foreach ($items  as $key) {
						$boleta = $key['invnum'];
						$fenvio = date('Y-m-d H:i:s');
						mysqli_query($conexion, "UPDATE venta SET sunat_fenvio = '$fenvio', sunat_enviado = 1, sunat_respuesta_codigo = '$code', sunat_respuesta_descripcion = '$description', sunat_hash = '$hash',sisFacturacion='$enviado' WHERE invnum = '$boleta'");
					}
				}
			}
			
			/*else {

				foreach ($items  as $key) {
					$boleta = $key['invnum'];
					$fenvio = date('Y-m-d H:i:s');
					mysqli_query($conexion, "UPDATE venta SET sunat_fenvio = '$fenvio', sunat_respuesta_codigo = '$code', sunat_respuesta_descripcion = '$description', sunat_hash = '$hash',sisFacturacion='$enviado' WHERE invnum = '$boleta'");
				}
			}*/
			
			
			break;

		case "ENVIO_BAJAS_BOLETA":

			$tipo 				= addslashes($_POST['tipo']);
			$date 				= addslashes($_POST['date']);
			$sucursal 			= addslashes($_POST['sucursal']);

			if ($tipo == 1) {
				$tipodoc = 'RA';
			} else {
				$tipodoc = 'RC';
			}

			$sqlemisor 			= "SELECT * FROM emisor where id = '$sucursal'";
			$resultemisor 		= mysqli_query($conexion, $sqlemisor);
			if (mysqli_num_rows($resultemisor)) {
				$emisor = mysqli_fetch_array($resultemisor);
			}
			$serie 				= date('Ymd');
			$now 				= date('Y-m-d');
			$sql 				= mysqli_query($conexion, "SELECT resumen_id FROM venta_resumen WHERE resumen_generacion = '$now'");
			$n 					= mysqli_num_rows($sql);
			$n++;
			$n 					= str_pad($n, 3, '0', STR_PAD_LEFT);
			$resumen_factura 	= 'RA-' . str_replace('-', '', $now) . '-' . $n;
			$resumen_boleta 	= 'RC-' . str_replace('-', '', $now) . '-' . $n;



			$cabecera = array(
				"tipodoc"		=> $tipodoc,
				"serie"			=> $serie,
				"correlativo"	=> $n,
				"fecha_emision" => $date,
				"fecha_envio"	=> date('Y-m-d')
			);


			$items = array();
			$k = 0;
			$sql3 = mysqli_query($conexion, "SELECT v.*  FROM venta AS v  WHERE v.invfec = '$date' AND (v.nrofactura LIKE 'B%' OR v.nrofactura LIKE 'F%') AND LENGTH(v.nrofactura) > 0 AND v.sunat_enviado > 0 AND v.val_habil > 0 AND v.sucursal = '$sucursal' and v.tipdoc='$tipo' ORDER BY v.nrofactura ASC");
			while ($factura = mysqli_fetch_array($sql3, MYSQLI_ASSOC)) {
				$k++;
				$doc 			= explode('-', trim($factura['nrofactura']));
				$serie1 		= $doc[0];
				$numero 		= str_pad($doc[1], 8, '0', STR_PAD_LEFT);
				$serienumero 	= $serie . '-' . $numero;
				$total 			= ($factura['invtot'] < 0) ? 0 : $factura['invtot'];
				$opgravadas 	= ($factura['gravado'] < 0) ? 0 : $factura['gravado'];
				$opinafectas 	= ($factura['inafecto'] < 0) ? 0 : $factura['inafecto'];
				$opexoneradas 	= 0;
				$igv 			= ($factura['igv'] < 0) ? 0 : $factura['igv'];			 
				$tipodoc2 		= ($factura['tipdoc'] == 1)  ? '01' : '03';
				$clitipo 		= '1';
 
				if ($total > 0) {

					$items[] = array(
						"item"				=> $k,
						"invnum"			=> $factura['invnum'],
						"tipodoc"			=> $tipodoc2,
						"serie"				=> $serie1,
						"correlativo"		=> $numero,
						"condicion"			=> 3, //1->Registro, 2->Actuali, 3->Bajas
						"moneda"			=> 'PEN',
						"importe_total"		=> round($total, 2),
						"valor_total"		=> round($opgravadas, 2),
						"igv_total"			=> round($igv, 2),
						"tipo_total"		=> "01", //GRA->01, EXO->02, INA->03
						"codigo_afectacion"	=> "1000",
						"nombre_afectacion"	=> "IGV",
						"tipo_afectacion"	=> "VAT",
						"serienumero"	    => $serienumero
					);
				}
			}

			$resumen_documentos = '';
			foreach ($items  as $key) {
				$resumen_documentos .= $key['serienumero'] . ', ';
			}
			$resumen_documentos = substr($resumen_documentos, 0, -2);
			$ruta 				= "../" . $emisor['ruc'] . "/xml/";
			$nombrexml 			= $emisor['ruc'] . '-' . $cabecera['tipodoc'] . '-' . $cabecera['serie'] . '-' . $cabecera['correlativo'];
			$generadoXML->CrearXMLResumenDocumentos($emisor, $cabecera, $items, $ruta . $nombrexml);
			$ticket 			= $api->EnviarResumenComprobantes($emisor, $nombrexml, "../", "../" . $emisor['ruc'] . "/xml/");
			$response 			= $api->ConsultarTicket($emisor, $cabecera, $ticket, "../" . $emisor['ruc'] . "/cdr/");
			$enviador 			= $response['status'];
			$code 				= $response['ResponseCode'];
			$resumen_resumen 	= $response['ReferenceID'];
			$description 		= $response['Description'];
			$hash 				= '';
			$resumen_fecha 		= $date;
			$description 		= str_replace("'", "", $description);
			
			if ($enviador > 0 and $code == '0') {
				$resumen_generacion 	= date('Y-m-d');
				$enviado 	= 1;
			} else {
				$resumen_generacion 	= '0000-00-00';
				$enviado 	= 0;
			}
			if ($enviado == 1) {
				$insert = mysqli_query($conexion, "INSERT INTO venta_resumen (resumen_fecha,resumen_generacion, resumen_resumen, resumen_documentos, resumen_respuesta_codigo, resumen_respuesta_descripcion, resumen_hash, resumen_ticket, sucursal,cBaja) VALUES ('$resumen_fecha', '$resumen_generacion', '$resumen_resumen', '$resumen_documentos', '$code', '$description', '$hash', '$ticket', '$sucursal','1')");
			} 
			break;
		default:
			# code...
			break;
	}
}
