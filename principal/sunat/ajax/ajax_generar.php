<?php

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

include_once('../../../conexion.php');
include_once('funciones.php');
if (isset($_POST['action'])) {
	switch ($_POST['action']) {
		case 'resumen':
			$date = addslashes($_POST['date']);
			$sucursal = addslashes($_POST['sucursal']);
			// $type = addslashes($_POST['type']);
			$now = date('Y-m-d');
			$sql = mysqli_query($conexion, "SELECT resumen_id FROM venta_resumen WHERE resumen_fecha = '$now'");
			$n = mysqli_num_rows($sql);
			$n++;
			$n = str_pad($n, 3, '0', STR_PAD_LEFT);
			$resumen_factura = 'RA-' . str_replace('-', '', $now) . '-' . $n;
			$resumen_boleta = 'RC-' . str_replace('-', '', $now) . '-' . $n;
			$sql2 = mysqli_query($conexion, "SELECT   usuario_sol as sucursal_usuario_secundario, clave_sol as sucursal_usuario_password, ruc as sucursal_ruc, nombre_comercial as  sucursal_nombre_comercial,razon_social as sucursal_nombre,ubigeo as sucursal_ubigueo, distrito as sucursal_distrito,provincia as sucursal_provincia,provincia as sucursal_departamento, direccion as  sucursal_direccion  FROM emisor WHERE id = '$sucursal' LIMIT 1");
			while ($key = mysqli_fetch_array($sql2, MYSQLI_ASSOC)) {
				$comuser = $key['sucursal_usuario_secundario'];
				$compass = $key['sucursal_usuario_password'];
				$compruc = $key['sucursal_ruc'];
				$compnomcomercial = $key['sucursal_nombre_comercial'];
				$comprznsocial = $key['sucursal_nombre'];
				$compubigueo = $key['sucursal_ubigueo'];
				$compdistrito = $key['sucursal_distrito'];
				$compprovincia = $key['sucursal_provincia'];
				$compdepartamento = $key['sucursal_departamento'];
				// $compurbanizacion = $key['sucursal_urbanizacion'];
				// $compcodlocal = $key['sucursal_codigo'];
				$compdireccion = $key['sucursal_direccion'];
			}
			$data = array(
				'sucursal' => $sucursal,
				'comuser' => $comuser,
				'compass' => $compass,
				'resumen_factura' => $resumen_factura,
				'resumen_boleta' => $resumen_boleta,
				'generacion' => $date, //FECHA DE LOS DOCUMENTOS
				'fecha' => $now, //FECHA DEL RESUMEN
				'correlativo' => $n,
				'compruc' => $compruc,
				'compnomcomercial' => htmlspecialchars(trim($compnomcomercial)),
				'comprznsocial' => htmlspecialchars(trim($comprznsocial)),
				'compubigueo' => $compubigueo,
				'compdistrito' => htmlspecialchars(trim($compdistrito)),
				'compprovincia' => htmlspecialchars(trim($compprovincia)),
				'compdepartamento' => htmlspecialchars(trim($compdepartamento)),
				// 'compurbanizacion' => mb_strtoupper(trim($compurbanizacion)),
				// 'compcodlocal' => mb_strtoupper(trim($compcodlocal)),
				'compdireccion' => htmlspecialchars(trim($compdireccion)),
				'items_boleta' => array(),
				'items_factura' => array()
			);
			$items_boleta = $items_factura = array();
			$sql3 = mysqli_query($conexion, "SELECT v.*, c.dnicli, c.ruccli, c.dircli FROM venta AS v LEFT JOIN cliente AS c ON v.cuscod = c.codcli WHERE v.invfec = '$date' AND (v.nrofactura LIKE 'B%' OR v.nrofactura LIKE 'F%') AND LENGTH(v.nrofactura) > 0 AND v.sunat_enviado > 0 AND v.val_habil > 0 AND v.sucursal = '$sucursal' ORDER BY v.nrofactura ASC");
			while ($key3 = mysqli_fetch_array($sql3, MYSQLI_ASSOC)) {
				$doc = explode('-', trim($key3['nrofactura']));
				$serie = $doc[0];
				$numero = str_pad($doc[1], 8, '0', STR_PAD_LEFT);
				$serienumero = $serie . '-' . $numero;
				$total = $key3['invtot'];
				$opgravadas = $key3['gravado'];
				$opinafectas = $key3['inafecto'];
				$opexoneradas = 0;
				$igv = $key3['igv'];
				if (substr($serie, 0, 1) == 'B') {
					$tipodoc = '03';
					$clitipo = '1';
					$clinro = trim($key3['dnicli']);
					$items_boleta[] = array(
						'tipodoc' => $tipodoc,
						'serienumero' => $serienumero,
						'estado' => '3', //1 = agregar, 3 = anular
						'clitipo' => $clitipo,
						'clinro' => $clinro,
						'total' => round($total, 2),
						'opgravadas' => round($opgravadas, 2),
						'opinafectas' => round($opinafectas, 2),
						'opexoneradas' => round($opexoneradas, 2),
						'otroscargos' => 0,
						'igv' => round($igv, 2)
					);
				} else {
					$tipodoc = '01';
					$clitipo = '6';
					$clinro = trim($key3['ruccli']);
					$items_factura[] = array(
						'tipodoc' => $tipodoc,
						'serienumero' => $serienumero,
						'estado' => '3', //1 = agregar, 3 = anular
						'clitipo' => $clitipo,
						'clinro' => $clinro,
						'total' => round($total, 2),
						'opgravadas' => round($opgravadas, 2),
						'opinafectas' => round($opinafectas, 2),
						'opexoneradas' => round($opexoneradas, 2),
						'otroscargos' => 0,
						'igv' => round($igv, 2)
					);
				}
			}
			$data['items_boleta'] = $items_boleta;
			$data['items_factura'] = $items_factura;
			$status = 'OK';
			$response = array('status' => $status, 'data' => $data);
			exit(json_encode($response, JSON_UNESCAPED_UNICODE));
			break;

		case 'guardar_resumen':
			$json = json_decode($_POST['json'], true);
			$resumen_fecha = $json['fecha'];
			$resumen_generacion = $json['generacion'];
			if ($_POST['type'] == 'FACTURA') {
				$resumen_resumen = $json['resumen_factura'];
				$resumen_documentos = '';
				foreach ($json['items_factura'] as $key) {
					$resumen_documentos .= $key['serienumero'] . ', ';
				}
			} else if ($_POST['type'] == 'BOLETA') {
				$resumen_resumen = $json['resumen_boleta'];
				$resumen_documentos = '';
				foreach ($json['items_boleta'] as $key) {
					$resumen_documentos .= $key['serienumero'] . ', ';
				}
			}
			$sucursal = $json['sucursal'];
			$resumen_documentos = substr($resumen_documentos, 0, -2);
			$enviado = addslashes($_POST['enviado']);
			$code = addslashes($_POST['code']);
			$description = addslashes($_POST['description']);
			$hash = addslashes($_POST['hash']);
			$ticket = addslashes($_POST['ticket']);
			$data = '';
			$insert = mysqli_query($conexion, "INSERT INTO venta_resumen (resumen_fecha, resumen_generacion, resumen_resumen, resumen_documentos, resumen_respuesta_codigo, resumen_respuesta_descripcion, resumen_hash, resumen_ticket, sucursal) VALUES ('$resumen_fecha', '$resumen_generacion', '$resumen_resumen', '$resumen_documentos', '$code', '$description', '$hash', '$ticket', '$sucursal')");
			$id = mysqli_insert_id($conexion);
			$sql = mysqli_query($conexion, "SELECT r.*, t.linea1, t.linea7, t.sucursal_codigo, t.sucursal_ruc FROM venta_resumen AS r LEFT JOIN ticket AS t ON r.sucursal = t.sucursal WHERE r.resumen_id = '$id'");
			while ($key = mysqli_fetch_array($sql, MYSQLI_ASSOC)) {
				$id = $key['resumen_id'];
				$sucursalname = trim($key['sucursal_ruc']) . '-' . trim($key['linea7']) . '-' . trim($key['linea1']);
				$generacion = date('d/m/Y', strtotime($key['resumen_generacion']));
				$fecha = date('d/m/Y', strtotime($key['resumen_fecha']));
				$resumen = trim($key['resumen_resumen']);
				/*$explode = explode(',', $key['resumen_documentos']);
            		$documentos = trim($explode[0]).'<br>'.trim(end($explode));*/
				$codigo = trim($key['resumen_respuesta_codigo']);
				$respuesta = trim($key['resumen_respuesta_descripcion']);
				$codigo = trim($key['resumen_ticket']);
				$cdr = '<button type="button" class="btn-envio text-small" onclick="download_file(' . $id . ', 1)" title="CDR"><i class="far fa-file-archive"></i> CDR</button>';
				$xml = '<button type="button" class="btn-envio text-small" onclick="download_file(' . $id . ', 2)" title="XML"><i class="far fa-file-code"></i> XML</button>';
				$data .= '<tr>
								<td>' . $sucursalname . '</td>
								<td>' . $generacion . '</td>
								<td>' . $fecha . '</td>
								<td>' . $resumen . '</td>
								<td>' . $codigo . '</td>
								<td>' . $respuesta . '</td>
								<td>' . $ticket . '</td>
								<td align="center">' . $cdr . '</td>
								<td align="center">' . $xml . '</td>
						      </tr>';
			}
			$response = array('row' => $data);
			exit(json_encode($response));
			break;

		case 'guardar_rd':
			$json = json_decode($_POST['json'], true);
			$resumen_fecha = $json['fecha'];
			$resumen_generacion = $json['generacion'];
			$resumen_resumen = $json['resumen_boleta'];
			$resumen_documentos = '';
			foreach ($json['items_boleta'] as $key) {
				$resumen_documentos .= $key['serienumero'] . ', ';
			}
			$sucursal = $json['sucursal'];
			$resumen_documentos = substr($resumen_documentos, 0, -2);
			$code = addslashes($_POST['code']);
			$description = addslashes($_POST['description']);
			$hash = addslashes($_POST['hash']);
			$ticket = addslashes($_POST['ticket']);

			$insert = mysqli_query($conexion, "INSERT INTO venta_resumen (resumen_fecha, resumen_generacion, resumen_resumen, resumen_documentos, resumen_respuesta_codigo, resumen_respuesta_descripcion, resumen_hash, resumen_ticket, sucursal) VALUES ('$resumen_fecha', '$resumen_generacion', '$resumen_resumen', '$resumen_documentos', '$code', '$description', '$hash', '$ticket', '$sucursal')");
			if ($insert) {
				$rd_id = mysqli_insert_id($conexion);
				foreach ($json['items_boleta'] as $key) {
					$boleta = $key['id'];
					$fenvio = date('Y-m-d H:i:s');
					mysqli_query($conexion, "UPDATE venta SET sunat_fenvio = '$fenvio', sunat_enviado = 1, sunat_respuesta_codigo = '$code', sunat_respuesta_descripcion = '$description', sunat_hash = '$hash' WHERE invnum = '$boleta'");
				}
				$respuesta = $description;
			} else {
				$respuesta = 'El resumen diario fue enviado con exito pero no se pudo guardar en la base de datos, consulte los documentos enviados en el portal de sunat o vuelva a generar otro resumen, gracias.';
			}
			exit($respuesta);
			break;

		case 'download':
			$id = addslashes($_POST['id']);
			$type = addslashes($_POST['type']);
			$sql = mysqli_query($conexion, "SELECT r.resumen_resumen, t.sucursal_ruc FROM venta_resumen AS r LEFT JOIN ticket AS t ON r.sucursal = t.sucursal WHERE r.resumen_id = '$id' LIMIT 1");
			$key = mysqli_fetch_array($sql, MYSQLI_ASSOC);
			$file = $key['sucursal_ruc'] . '-' . $key['resumen_resumen'];
			switch ($type) {
				case 1:
					$name = 'R-' . $file . '.zip';
					break;
				case 2:
					$name = $file . '.xml';
					break;
				default:
					$name = $file . '.xml';
					break;
			}
			$path = '../../greenter/files/' . $key['sucursal_ruc'] . '/' . $name;
			$response = array(
				'path' => $path,
				'name' => $name
			);
			exit(json_encode($response));
			break;

		case 'consultar':
			$from = addslashes($_POST['from']);
			$to = addslashes($_POST['to']);
			$sucursal = addslashes($_POST['sucursal']);
			$data = '';
			$sql = mysqli_query($conexion, "SELECT r.*, t.linea1, t.linea7, t.sucursal_codigo, t.sucursal_ruc FROM venta_resumen AS r LEFT JOIN ticket AS t ON r.sucursal = t.sucursal WHERE r.resumen_fecha BETWEEN '$from' AND '$to' ORDER BY t.sucursal, r.resumen_fecha DESC");
			while ($key = mysqli_fetch_array($sql, MYSQLI_ASSOC)) {
				$id = $key['resumen_id'];
				$sucursal = $key['sucursal_ruc'] . '-' . $key['linea7'] . '-' . $key['linea1'];
				$generacion = date('d/m/Y', strtotime($key['resumen_generacion']));
				$fecha = date('d/m/Y', strtotime($key['resumen_fecha']));
				$resumen = trim($key['resumen_resumen']);
				/*$explode = explode(',', $key['resumen_documentos']);
		            $documentos = trim($explode[0]).'<br>'.trim(end($explode));*/
				$codigo = trim($key['resumen_respuesta_codigo']);
				$respuesta = trim($key['resumen_respuesta_descripcion']);
				$ticket = trim($key['resumen_ticket']);
				$cdr = '<button type="button" class="btn-envio text-small" onclick="download_file(' . $id . ', 1)" title="CDR"><i class="far fa-file-archive"></i> CDR</button>';
				$xml = '<button type="button" class="btn-envio text-small" onclick="download_file(' . $id . ', 2)" title="XML"><i class="far fa-file-code"></i> XML</button>';
				$data .= '<tr>
			                    <td>' . $sucursal . '</td>
			                    <td>' . $generacion . '</td>
			                    <td>' . $fecha . '</td>
			                    <td>' . $resumen . '</td>
			                    <td>' . $codigo . '</td>
			                    <td>' . $respuesta . '</td>
			                    <td>' . $ticket . '</td>
			                    <td align="center">' . $cdr . '</td>
			                    <td align="center">' . $xml . '</td>
			                  </tr>';
			}
			$response = array('data' => $data);
			exit(json_encode($response));
			break;
	}
}
