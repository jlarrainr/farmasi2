<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once('../../../conexion.php');
include_once('funciones.php');
require_once('xml.php');
require_once("ApiFacturacion.php");

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'consultar':
            $date = addslashes($_POST['date']);
            $sucursal = addslashes($_POST['sucursal']);
            $anulados = 0;
            $data = '';
            $totalcpe = $sent = $pending = 0;
            $sql = mysqli_query($conexion, "SELECT v.*, c.dnicli, c.ruccli, c.dircli, c.descli FROM venta AS v LEFT JOIN cliente AS c ON v.cuscod = c.codcli WHERE v.invfec = '$date' AND (v.nrofactura LIKE 'F%' OR v.nrofactura LIKE 'B%') AND LENGTH(v.nrofactura) > 0 AND v.sucursal = '$sucursal' ORDER BY v.correlativo ASC");
            while ($key = mysqli_fetch_array($sql, MYSQLI_ASSOC)) {
                $id = $key['invnum'];
                $type = ($key['tipdoc'] == 1) ? 'Factura' : 'Boleta';
                $typef = ($key['tipdoc'] == 1) ? "'F'" : "'B'";
                $doc = explode('-', $key['nrofactura']);
                $serie = $doc[0];
                $correlativo = str_pad($doc[1], 8, '0', STR_PAD_LEFT);
                $date = date('d/m/Y', strtotime($key['invfec']));
                $rucdni = ($key['tipdoc'] == 1) ? $key['ruccli'] : $key['dnicli'];
                $val_habil = $key['val_habil'];
                $customer = $key['descli'];
                $gravado = number_format($key['gravado'], 2);
                $inafecto = number_format($key['inafecto'], 2);
                $igv = number_format($key['igv'], 2);
                $total = number_format($key['invtot'], 2);
                $enviado = ($key['sunat_enviado'] > 0) ? date('d/m/Y', strtotime($key['sunat_fenvio'])) : 'No enviado';
                $respuestacod = $key['sunat_respuesta_codigo'];
                $respuestadesc = $key['sunat_respuesta_descripcion'];
                $anull_sistema = $key['val_habil'];
                $anull_sunat = $key['sunat_voided'];

                if ($val_habil == 1) {
                    $cssTachado = 'class="strikeout"';
                } else {
                    $cssTachado = '';
                }

                $option = ($key['sunat_enviado'] > 0) ? '<input type="button" class="btn-envio enviado" value="Enviar" style="color:#A4A4A4" disabled>' : '<input type="button" class="btn-envio" value="Enviar" onclick="enviar_documento_sunat(' . $id . ', ' . $typef . ');">';
                $data .= '<tr ' . $cssTachado . '   id="row-' . $id . '">
								<td>' . $type . '</td>
								<td>' . $serie . '</td>
								<td>' . $correlativo . '</td>
								<td>' . $date . '</td>
								<td>' . $rucdni . '</td>
								<td>' . $customer . '</td>//	
								<td align="right">' . $gravado . '</td>
								<td align="right">' . $inafecto . '</td>
								<td align="right">' . $igv . '</td>
								
								<td align="right">' . $total . '</td>
								<td>' . $enviado . '</td>
								<td>' . $respuestacod . '</td>
								<td>' . $respuestadesc . '</td>
								
								<td>' . $anull_sunat . '</td>
								<td align="center">' . $option . '</td>
							  </tr>';
                $totalcpe++;
                if ($key['sunat_enviado'] > 0) {
                    $sent++;
                }

                if ($key['val_habil'] > 0) {
                    $anulados++;
                }
            }
            $pending = $totalcpe - $sent;
            $response = array('data' => $data, 'total' => $totalcpe, 'sent' => $sent, 'pending' => $pending, 'anulados' => $anulados);
            exit(json_encode($response, JSON_UNESCAPED_UNICODE));
            break;

        case 'consultar_rd':
            $date = addslashes($_POST['date']);
            $sucursal = addslashes($_POST['sucursal']);
            $data = '';
            $totalcpe = $sent = $pending = 0;
            $sql = mysqli_query($conexion, "SELECT v.*, c.dnicli, c.ruccli, c.dircli, c.descli FROM venta AS v LEFT JOIN cliente AS c ON v.cuscod = c.codcli WHERE v.invfec = '$date' AND v.nrofactura LIKE 'B%' AND v.sunat_enviado = 0 AND LENGTH(v.nrofactura) > 0 AND v.sucursal = '$sucursal' ORDER BY v.correlativo ASC");
            while ($key = mysqli_fetch_array($sql, MYSQLI_ASSOC)) {
                $id = $key['invnum'];
                $type = 'Boleta';
                $typef = "'B'";
                $doc = explode('-', $key['nrofactura']);
                $serie = $doc[0];
                $correlativo = str_pad($doc[1], 8, '0', STR_PAD_LEFT);
                $date = date('d/m/Y', strtotime($key['invfec']));
                $rucdni = ($key['tipdoc'] == 1) ? $key['ruccli'] : $key['dnicli'];
                $customer = utf8_encode($key['descli']);
                $total = number_format($key['invtot'], 2);
                $data .= '<tr id="row-' . $id . '">
								<td>' . $serie . '</td>
								<td>' . $correlativo . '</td>
								<td>' . $date . '</td>
								<td>' . $rucdni . '</td>
								<td>' . $customer . '</td>
								<td align="right">' . $total . '</td>
							  </tr>';
                $totalcpe++;
                if ($key['sunat_enviado'] > 0) {
                    $sent++;
                }
            }
            $pending = $totalcpe - $sent;
            $response = array('data' => $data, 'total' => $totalcpe, 'sent' => $sent, 'pending' => $pending);
            exit(json_encode($response, JSON_UNESCAPED_UNICODE));
            break;

        case 'consultar_nc':
            $date = addslashes($_POST['date']);
            $sucursal = addslashes($_POST['sucursal']);
            $data = '';
            $totalcpe = $sent = $pending = 0;
            $sql = mysqli_query($conexion, "SELECT n.*, c.dnicli, c.ruccli, c.dircli, c.descli FROM nota AS n LEFT JOIN cliente AS c ON n.cuscod = c.codcli WHERE n.invfec = '$date' AND LENGTH(n.nrofactura) > 0 AND n.sucursal = '$sucursal' ORDER BY n.correlativo ASC");
            while ($key = mysqli_fetch_array($sql, MYSQLI_ASSOC)) {
                $id = $key['invnum'];
                $doc = explode('-', $key['nrofactura']);
                $serie = $doc[0];
                $correlativo = str_pad($doc[1], 8, '0', STR_PAD_LEFT);
                $date = date('d/m/Y', strtotime($key['invfec']));
                $anotacion = $key['anotacion'];
                $docafectado = explode('-', $key['serie_doc']);
                $afectado = $docafectado[0] . '-' . str_pad($docafectado[1], 8, '0', STR_PAD_LEFT);
                $rucdni = ($key['tipdoc'] == 6) ? $key['ruccli'] : $key['dnicli'];
                $customer = utf8_encode($key['descli']);
                $total = number_format($key['invtot'], 2);
                $enviado = ($key['sunat_enviado'] > 0) ? date('d/m/Y', strtotime($key['sunat_fenvio'])) : 'No enviado';
                $respuestacod = $key['sunat_respuesta_codigo'];
                $respuestadesc = $key['sunat_respuesta_descripcion'];
                $option = ($key['sunat_enviado'] > 0) ? '<input type="button" class="btn-envio enviado" value="Enviar" style="color:#A4A4A4" disabled>' : '<input type="button" class="btn-envio" value="Enviar" onclick="enviar_documento_sunat(' . $id . ');">';
                $data .= '<tr id="row-' . $id . '">
								<td>' . $serie . '-' . $correlativo . '</td>
								<td>' . $date . '</td>
								<td>' . $anotacion . '</td>
								<td>' . $afectado . '</td>
								<td>' . $rucdni . '</td>
								<td>' . $customer . '</td>
								<td align="right">' . $total . '</td>
								<td>' . $enviado . '</td>
								<td>' . $respuestacod . '</td>
								<td>' . $respuestadesc . '</td>
								<td align="center">' . $option . '</td>
							  </tr>';
                $totalcpe++;
                if ($key['sunat_enviado'] > 0) {
                    $sent++;
                }
            }
            $pending = $totalcpe - $sent;
            $response = array('data' => $data, 'total' => $totalcpe, 'sent' => $sent, 'pending' => $pending);
            exit(json_encode($response, JSON_UNESCAPED_UNICODE));
            break;

        case 'limpiar_enviados':
            $now = date('Y-m-d H:i:s');
            $date = addslashes($_POST['date']);
            $sucursal = addslashes($_POST['sucursal']);
            $data = '';
            $update = mysqli_query($conexion, "UPDATE venta SET sunat_respuesta_codigo = 0, sunat_enviado = 1, sunat_fenvio = '$now', sunat_respuesta_descripcion = IF(SUBSTRING(nrofactura, 1, 1)='F', CONCAT('La Factura numero ', nrofactura, ', ha sido aceptada'), CONCAT('La Boleta numero ', nrofactura, ', ha sido aceptada')) WHERE invfec = '$date' AND (nrofactura LIKE 'F%' OR nrofactura LIKE 'B%') AND LENGTH(nrofactura) > 0 AND sucursal = '$sucursal' AND (sunat_respuesta_descripcion LIKE 'El comprobante fue registrado previamente con otros datos%' OR sunat_respuesta_descripcion LIKE 'Existe documento ya informado anteriormente%' OR sunat_respuesta_descripcion LIKE 'El archivo ya fue presentado anteriormente%')");

            $sql = mysqli_query($conexion, "SELECT v.*, c.dnicli, c.ruccli, c.dircli, c.descli FROM venta AS v LEFT JOIN cliente AS c ON v.cuscod = c.codcli WHERE v.invfec = '$date' AND (v.nrofactura LIKE 'F%' OR v.nrofactura LIKE 'B%') AND LENGTH(v.nrofactura) > 0 AND v.sucursal = '$sucursal' ORDER BY v.correlativo ASC");
            while ($key = mysqli_fetch_array($sql, MYSQLI_ASSOC)) {
                $id = $key['invnum'];
                $type = ($key['tipdoc'] == 1) ? 'Factura' : 'Boleta';
                $typef = ($key['tipdoc'] == 1) ? "'F'" : "'B'";
                $doc = explode('-', $key['nrofactura']);
                $serie = $doc[0];
                $correlativo = str_pad($doc[1], 8, '0', STR_PAD_LEFT);
                $date = date('d/m/Y', strtotime($key['invfec']));
                $rucdni = ($key['tipdoc'] == 1) ? $key['ruccli'] : $key['dnicli'];
                $customer = utf8_encode($key['descli']);
                $total = number_format($key['invtot'], 2);
                $enviado = ($key['sunat_enviado'] > 0) ? date('d/m/Y', strtotime($key['sunat_fenvio'])) : 'No enviado';
                $respuestacod = $key['sunat_respuesta_codigo'];
                $respuestadesc = $key['sunat_respuesta_descripcion'];
                $option = ($key['sunat_enviado'] > 0) ? '<input type="button" class="btn-envio enviado" value="Enviar" style="color:#A4A4A4" disabled>' : '<input type="button" class="btn-envio" value="Enviar" onclick="enviar_documento_sunat(' . $id . ', ' . $typef . ');">';
                $data .= '<tr id="row-' . $id . '">
								<td>' . $type . '</td>
								<td>' . $serie . '</td>
								<td>' . $correlativo . '</td>
								<td>' . $date . '</td>
								<td>' . $rucdni . '</td>
								<td>' . $customer . '</td>
								<td align="right">' . $total . '</td>
								<td>' . $enviado . '</td>
								<td>' . $respuestacod . '</td>
								<td>' . $respuestadesc . '</td>
								<td align="center">' . $option . '</td>
							  </tr>';
            }
            $response = array('data' => $data);
            exit(json_encode($response, JSON_UNESCAPED_UNICODE));
            break;

        case 'limpiar_enviados_nc':
            $now = date('Y-m-d H:i:s');
            $date = addslashes($_POST['date']);
            $sucursal = addslashes($_POST['sucursal']);
            $data = '';
            $update = mysqli_query($conexion, "UPDATE nota SET sunat_enviado = 1, sunat_fenvio = '$now', sunat_respuesta_descripcion = CONCAT('La Nota de credito numero ', nrofactura, ', ha sido aceptada') WHERE invfec = '$date' AND LENGTH(nrofactura) > 0 AND sucursal = '$sucursal' AND (sunat_respuesta_descripcion LIKE 'El comprobante fue registrado previamente con otros datos%' OR sunat_respuesta_descripcion LIKE 'Existe documento ya informado anteriormente%' OR sunat_respuesta_descripcion LIKE 'El archivo ya fue presentado anteriormente%')");
            $response = array('status' => true);
            exit(json_encode($response, JSON_UNESCAPED_UNICODE));
            break;

        case 'consultar-masa':
            $date = addslashes($_POST['date']);
            $sucursal = addslashes($_POST['sucursal']);
            $data = '';
            $sql = mysqli_query($conexion, "SELECT v.*, c.dnicli, c.ruccli, c.dircli FROM venta AS v LEFT JOIN cliente AS c ON v.cuscod = c.codcli WHERE v.invfec = '$date' AND (v.nrofactura LIKE 'F%' OR v.nrofactura LIKE 'B%') AND LENGTH(v.nrofactura) > 0 AND v.sunat_enviado = 0 AND v.sucursal = '$sucursal' ORDER BY v.nrofactura ASC");
            $items = array();
            while ($key = mysqli_fetch_array($sql, MYSQLI_ASSOC)) {
                $type = ($key['tipdoc'] == 1) ? 'F' : 'B';
                $items[] = array(
                    'id' => $key['invnum'],
                    'type' => $type
                );
            }
            exit(json_encode($items, JSON_UNESCAPED_UNICODE));
            break;

        case 'consultar-masa-nc':
            $date = addslashes($_POST['date']);
            $sucursal = addslashes($_POST['sucursal']);
            $data = '';
            $sql = mysqli_query($conexion, "SELECT n.*, c.dnicli, c.ruccli, c.dircli FROM nota AS n LEFT JOIN cliente AS c ON n.cuscod = c.codcli WHERE n.invfec = '$date' AND LENGTH(n.nrofactura) > 0 AND n.sunat_enviado = 0 AND n.sucursal = '$sucursal' ORDER BY n.nrofactura ASC");
            $items = array();
            while ($key = mysqli_fetch_array($sql, MYSQLI_ASSOC)) {
                $items[] = array(
                    'id' => $key['invnum'],
                );
            }
            exit(json_encode($items, JSON_UNESCAPED_UNICODE));
            break;

        case 'crear_json':
            $id = addslashes($_POST['id']);
            $header = mysqli_query($conexion, "SELECT v.*, c.dnicli, c.ruccli, c.dircli, c.descli, t.sucursal_usuario_secundario, t.sucursal_usuario_password, t.sucursal_ruc, t.sucursal_nombre_comercial, t.sucursal_nombre, t.sucursal_ubigueo, t.sucursal_distrito, t.sucursal_provincia, t.sucursal_departamento, t.sucursal_urbanizacion, t.sucursal_codigo, t.sucursal_direccion FROM venta AS v LEFT JOIN cliente AS c ON v.cuscod = c.codcli LEFT JOIN ticket AS t ON v.sucursal = t.sucursal WHERE v.invnum = '$id' LIMIT 1");
            $header_key = mysqli_fetch_array($header, MYSQLI_ASSOC);
            $doc = explode('-', $header_key['nrofactura']);
            $serie = $doc[0];
            $correlativo = str_pad($doc[1], 8, '0', STR_PAD_LEFT);
            $femision = $header_key['invfec'];
            $clirucdni = ($header_key['tipdoc'] == 1) ? $header_key['ruccli'] : $header_key['dnicli'];
            $clirznsocial = utf8_encode($header_key['descli']);
            $clidireccion = utf8_encode($header_key['dircli']);
            $montogravado = $header_key['gravado'];
            $montoexonerado = $header_key['inafecto'];
            $montoigv = $header_key['igv'];
            $totalimpuesto = $header_key['igv'];
            $valorventa = $header_key['valven'];
            $montoventa = $header_key['invtot'];
            $comuser = $header_key['sucursal_usuario_secundario'];
            $compass = $header_key['sucursal_usuario_password'];
            $compruc = $header_key['sucursal_ruc'];
            $compnomcomercial = $header_key['sucursal_nombre_comercial'];
            $comprznsocial = $header_key['sucursal_nombre'];
            $compubigueo = $header_key['sucursal_ubigueo'];
            $compdistrito = $header_key['sucursal_distrito'];
            $compprovincia = $header_key['sucursal_provincia'];
            $compdepartamento = $header_key['sucursal_departamento'];
            $compurbanizacion = $header_key['sucursal_urbanizacion'];
            $compcodlocal = $header_key['sucursal_codigo'];
            $compdireccion = $header_key['sucursal_direccion'];

            if ($montogravado < 0) {
                $montogravado = 0;
            }
            if ($montoexonerado < 0) {
                $montoexonerado = 0;
            }
            if ($montoigv < 0) {
                $montoigv = 0;
            }
            if ($totalimpuesto < 0) {
                $totalimpuesto = 0;
            }
            if ($valorventa < 0) {
                $valorventa = 0;
            }
            if ($montoventa < 0) {
                $montoventa = 0;
            }

            $son = convertNumberToWord($montoventa, 'PEN');

            $response = array(
                'serie' => trim($serie),
                'correlativo' => trim($correlativo),
                'femision' => trim($femision),
                'moneda' => 'PEN',
                'clirucdni' => trim($clirucdni),
                'clirznsocial' => mb_strtoupper(trim($clirznsocial), 'UTF-8'),
                'clidireccion' => mb_strtoupper(trim($clidireccion), 'UTF-8'),
                'montogravado' => number_format($montogravado, 2, '.', ''),
                'montoexonerado' => number_format($montoexonerado, 2, '.', ''),
                'montoigv' => number_format($montoigv, 2, '.', ''),
                'totalimpuesto' => number_format($totalimpuesto, 2, '.', ''),
                'valorventa' => number_format($valorventa, 2, '.', ''),
                'montoventa' => number_format($montoventa, 2, '.', ''),
                'compruc' => trim($compruc),
                'compnomcomercial' => mb_strtoupper(trim($compnomcomercial), 'UTF-8'),
                'comprznsocial' => mb_strtoupper(trim($comprznsocial), 'UTF-8'),
                'compubigueo' => trim($compubigueo),
                'compdistrito' => mb_strtoupper(trim($compdistrito), 'UTF-8'),
                'compprovincia' => mb_strtoupper(trim($compprovincia), 'UTF-8'),
                'compdepartamento' => mb_strtoupper(trim($compdepartamento), 'UTF-8'),
                'compurbanizacion' => mb_strtoupper(trim($compurbanizacion), 'UTF-8'),
                'compcodlocal' => mb_strtoupper(trim($compcodlocal), 'UTF-8'),
                'compdireccion' => mb_strtoupper(trim($compdireccion), 'UTF-8'),
                'son' => trim($son),
                'comuser' => trim($comuser),
                'compass' => trim($compass),
                'items' => array()
            );
            $items = array();
            $porcentajeigv = 0;
            $igvtabla = mysqli_query($conexion, "SELECT porcent FROM datagen ORDER BY cdatagen DESC LIMIT 1");
            while ($rowigvtabla = mysqli_fetch_array($igvtabla, MYSQLI_ASSOC)) {
                $porcentajeigv = (float) $rowigvtabla['porcent'];
                $porcentajeigv = $porcentajeigv / 100;
            }
            $detail = mysqli_query($conexion, "SELECT d.*, p.desprod, p.igv AS igvpro FROM detalle_venta AS d LEFT JOIN producto AS p ON d.codpro = p.codpro WHERE d.invnum = '$id'");
            while ($detail_key = mysqli_fetch_array($detail, MYSQLI_ASSOC)) {
                $porcentaje = $porcentajeigv;
                if ($detail_key['igvpro'] > 0) {
                    $afectaigv = '10'; //GRAVADO - OPERACION ONEROSA
                } else {
                    $porcentaje = 0;
                    $afectaigv = '20'; //EXONERADO - OPERACION ONEROSA
                }
                $codproducto = $detail_key['codpro'];
                $unidad = 'NIU';
                $descripcion = mb_strtoupper($detail_key['desprod'], 'UTF-8');
                $cantidad = $detail_key['canpro'];
                $valunitario = ($detail_key['prisal'] / (1 + $porcentaje));
                $valventa = ($detail_key['pripro'] / (1 + $porcentaje));
                $baseigv = $valventa;
                $pcntjeigv = $porcentaje * 100;
                $valigv = $baseigv * $porcentaje;
                $totalimpuesto = $valigv;
                $preciounitario = $detail_key['prisal'];
                if ($valventa > 0) {
                    $items[] = array(
                        'codproducto' => trim($codproducto),
                        'unidad' => trim($unidad),
                        'descripcion' => trim($descripcion),
                        'cantidad' => number_format($cantidad, 2, '.', ''),
                        'valunitario' => number_format($valunitario, 2, '.', ''),
                        'valventa' => number_format($valventa, 2, '.', ''),
                        'baseigv' => number_format($baseigv, 2, '.', ''),
                        'pcntjeigv' => number_format($pcntjeigv, 2, '.', ''),
                        'valigv' => number_format($valigv, 2, '.', ''),
                        'afectaigv' => $afectaigv,
                        'totalimpuesto' => number_format($totalimpuesto, 2, '.', ''),
                        'preciounitario' => number_format($preciounitario, 2, '.', '')
                    );
                }
            }
            $response['items'] = $items;
            exit(json_encode($response, JSON_UNESCAPED_UNICODE));
            break;

        case 'crear_json_nc':
            /* $id = addslashes($_POST['id']);
              $header = mysqli_query($conexion, "SELECT n.*, c.dnicli, c.ruccli, c.dircli, c.descli, t.sucursal_usuario_secundario, t.sucursal_usuario_password, t.sucursal_ruc, t.sucursal_nombre_comercial, t.sucursal_nombre, t.sucursal_ubigueo, t.sucursal_distrito, t.sucursal_provincia, t.sucursal_departamento, t.sucursal_urbanizacion, t.sucursal_codigo, t.sucursal_direccion FROM nota AS n LEFT JOIN cliente AS c ON n.cuscod = c.codcli LEFT JOIN ticket AS t ON n.sucursal = t.sucursal WHERE n.invnum = '$id' LIMIT 1");
              $header_key = mysqli_fetch_array($header, MYSQLI_ASSOC);
              $tipodocafectado = $header_key['tipdoc_afec'];
              $docafectado = explode('-', $header_key['serie_doc']);
              $afectado = $docafectado[0] . '-' . str_pad($docafectado[1], 8, '0', STR_PAD_LEFT);
              $codnc = $header_key['codnc'];
              $anotacion = $header_key['anotacion'];
              $doc = explode('-', $header_key['nrofactura']);
              $serie = $doc[0];
              $correlativo = str_pad($doc[1], 8, '0', STR_PAD_LEFT);
              $femision = $header_key['invfec'];

              if ($header_key['tipdoc'] == 6) {
              $clirucdni = $header_key['ruccli'];
              $tipoclienteafectado = 6;
              } else {
              $clirucdni = $header_key['dnicli'];
              $tipoclienteafectado = 1;
              }

              $clirznsocial = utf8_encode($header_key['descli']);
              $clidireccion = utf8_encode($header_key['dircli']);
              $montogravado = $header_key['gravado'];
              $montoexonerado = $header_key['inafecto'];
              $montoigv = $header_key['igv'];
              $totalimpuesto = $header_key['igv'];
              $valorventa = $header_key['valven'];
              $montoventa = $header_key['invtot'];

              $comuser = $header_key['sucursal_usuario_secundario'];
              $compass = $header_key['sucursal_usuario_password'];
              $compruc = $header_key['sucursal_ruc'];
              $compnomcomercial = $header_key['sucursal_nombre_comercial'];
              $comprznsocial = $header_key['sucursal_nombre'];
              $compubigueo = $header_key['sucursal_ubigueo'];
              $compdistrito = $header_key['sucursal_distrito'];
              $compprovincia = $header_key['sucursal_provincia'];
              $compdepartamento = $header_key['sucursal_departamento'];
              $compurbanizacion = $header_key['sucursal_urbanizacion'];
              $compcodlocal = $header_key['sucursal_codigo'];
              $compdireccion = $header_key['sucursal_direccion'];

              if ($montogravado < 0) {
              $montogravado = 0;
              }
              if ($montoexonerado < 0) {
              $montoexonerado = 0;
              }
              if ($montoigv < 0) {
              $montoigv = 0;
              }
              if ($totalimpuesto < 0) {
              $totalimpuesto = 0;
              }
              if ($valorventa < 0) {
              $valorventa = 0;
              }
              if ($montoventa < 0) {
              $montoventa = 0;
              }

              $son = convertNumberToWord($montoventa, 'PEN');

              $response = array(
              'tipodocafectado' => trim($tipodocafectado),
              'afectado' => trim($afectado),
              'codnc' => trim($codnc),
              'anotacion' => trim($anotacion),
              'serie' => trim($serie),
              'correlativo' => trim($correlativo),
              'femision' => trim($femision),
              'moneda' => 'PEN',
              'tipoclienteafectado' => trim($tipoclienteafectado),
              'clirucdni' => trim($clirucdni),
              'clirznsocial' => mb_strtoupper(trim($clirznsocial), 'UTF-8'),
              'clidireccion' => mb_strtoupper(trim($clidireccion), 'UTF-8'),
              'montogravado' => number_format($montogravado, 2, '.', ''),
              'montoexonerado' => number_format($montoexonerado, 2, '.', ''),
              'montoigv' => number_format($montoigv, 2, '.', ''),
              'totalimpuesto' => number_format($totalimpuesto, 2, '.', ''),
              'valorventa' => number_format($valorventa, 2, '.', ''),
              'montoventa' => number_format($montoventa, 2, '.', ''),
              'compruc' => trim($compruc),
              'compnomcomercial' => mb_strtoupper(trim($compnomcomercial), 'UTF-8'),
              'comprznsocial' => mb_strtoupper(trim($comprznsocial), 'UTF-8'),
              'compubigueo' => trim($compubigueo),
              'compdistrito' => mb_strtoupper(trim($compdistrito), 'UTF-8'),
              'compprovincia' => mb_strtoupper(trim($compprovincia), 'UTF-8'),
              'compdepartamento' => mb_strtoupper(trim($compdepartamento), 'UTF-8'),
              'compurbanizacion' => mb_strtoupper(trim($compurbanizacion), 'UTF-8'),
              'compcodlocal' => mb_strtoupper(trim($compcodlocal), 'UTF-8'),
              'compdireccion' => mb_strtoupper(trim($compdireccion), 'UTF-8'),
              'son' => trim($son),
              'comuser' => trim($comuser),
              'compass' => trim($compass),
              'items' => array()
              );
              $items = array();
              $porcentajeigv = 0;
              $igvtabla = mysqli_query($conexion, "SELECT porcent FROM datagen ORDER BY cdatagen DESC LIMIT 1");
              while ($rowigvtabla = mysqli_fetch_array($igvtabla, MYSQLI_ASSOC)) {
              $porcentajeigv = (float)$rowigvtabla['porcent'];
              $porcentajeigv = $porcentajeigv / 100;
              }
              $detail = mysqli_query($conexion, "SELECT d.*, p.desprod, p.igv AS igvpro FROM detalle_nota AS d LEFT JOIN producto AS p ON d.codpro = p.codpro WHERE d.invnum = '$id'");
              while ($detail_key = mysqli_fetch_array($detail, MYSQLI_ASSOC)) {
              $porcentaje = $porcentajeigv;
              if ($detail_key['igvpro'] > 0) {
              $afectaigv = '10'; //GRAVADO - OPERACION ONEROSA
              } else {
              $porcentaje = 0;
              $afectaigv = '20'; //EXONERADO - OPERACION ONEROSA
              }
              $codproducto = $detail_key['codpro'];
              $unidad = 'NIU';
              $descripcion = mb_strtoupper($detail_key['desprod'], 'UTF-8');
              $cantidad = $detail_key['canpro'];
              $valunitario = ($detail_key['prisal'] / (1 + $porcentaje));
              $valventa = ($detail_key['pripro'] / (1 + $porcentaje));
              $baseigv = $valventa;
              $pcntjeigv = $porcentaje * 100;
              $valigv = $baseigv * $porcentaje;
              $totalimpuesto = $valigv;
              $preciounitario = $detail_key['prisal'];
              if ($valventa > 0) {
              $items[] = array(
              'codproducto' => trim($codproducto),
              'unidad' => trim($unidad),
              'descripcion' => trim($descripcion),
              'cantidad' => number_format($cantidad, 2, '.', ''),
              'valunitario' => number_format($valunitario, 2, '.', ''),
              'valventa' => number_format($valventa, 2, '.', ''),
              'baseigv' => number_format($baseigv, 2, '.', ''),
              'pcntjeigv' => number_format($pcntjeigv, 2, '.', ''),
              'valigv' => number_format($valigv, 2, '.', ''),
              'afectaigv' => $afectaigv,
              'totalimpuesto' => number_format($totalimpuesto, 2, '.', ''),
              'preciounitario' => number_format($preciounitario, 2, '.', '')
              );
              }
              }

              $response['items'] = $items; */




            //nuevo codigo para nota de credito
            $id = addslashes($_POST['id']);
            $header = mysqli_query($conexion, "SELECT n.*, c.dnicli, c.ruccli, c.dircli, c.descli, t.sucursal_usuario_secundario, t.sucursal_usuario_password, t.sucursal_ruc, t.sucursal_nombre_comercial, t.sucursal_nombre, t.sucursal_ubigueo, t.sucursal_distrito, t.sucursal_provincia, t.sucursal_departamento, t.sucursal_urbanizacion, t.sucursal_codigo, t.sucursal_direccion FROM nota AS n LEFT JOIN cliente AS c ON n.cuscod = c.codcli LEFT JOIN ticket AS t ON n.sucursal = t.sucursal WHERE n.invnum = '$id' LIMIT 1");
            $header_key = mysqli_fetch_array($header, MYSQLI_ASSOC);

            $sucursal = $header_key['sucursal'];

            $sqlemisor = "SELECT * FROM emisor where id = $sucursal";
            $resultemisor = mysqli_query($conexion, $sqlemisor);
            if (mysqli_num_rows($resultemisor)) {
                $emisor = mysqli_fetch_array($resultemisor);
            }

            $idcliente = $header_key['cuscod'];
            $sqlcodcli = "SELECT * FROM cliente where codcli = '$idcliente'";
            $resultcodcli = mysqli_query($conexion, $sqlcodcli);
            if (mysqli_num_rows($resultcodcli)) {
                $datosCliente = mysqli_fetch_array($resultcodcli);
            }

            $tipdoc = $header_key['tipdoc'];
            $tipodocCliente = ($tipdoc == 1) ? '6' : '1';
            $nrodocCliente = ($tipdoc == 1) ? $datosCliente['ruccli'] : $datosCliente['dnicli'];

            $cliente = array(
                'tipodoc' => $tipodocCliente, //6->ruc, 1-> dni 
                'ruc' => $nrodocCliente,
                'razon_social' => $datosCliente['descli'],
                'direccion' => $datosCliente['dircli'],
                'pais' => 'PE'
            );

            $detalle = array();
            $igv_porcentaje = 0.18;

            $sqldetalle_nota = "SELECT * FROM detalle_nota where invnum = '$id'";
            $resultdetalle_nota = mysqli_query($conexion, $sqldetalle_nota);

            while ($v = mysqli_fetch_array($resultdetalle_nota, MYSQLI_ASSOC)) {
                //foreach ($carrito as $k => $v) {

                $codigoProducto = $v['codpro'];
                $sqlproducto = "SELECT * FROM producto where codpro = '$codigoProducto'";
                $resultproducto = mysqli_query(
                        $conexion,
                        $sqlproducto
                );
                if (mysqli_num_rows($resultproducto)) {
                    $producto = mysqli_fetch_array($resultproducto);
                }

                $productoCodigoafectacion = ($producto['igv'] == 1) ? '10' : '20';

                $sqlafectacion = "SELECT * FROM tipo_afectacion where codigo = '$productoCodigoafectacion'";
                $resultafectacion = mysqli_query($conexion, $sqlafectacion);
                if (mysqli_num_rows($resultafectacion)) {
                    $afectacion = mysqli_fetch_array($resultafectacion);
                }

                $igv_detalle = 0;
                $factor_porcentaje = 1;
                /* 	if ($producto['codigoafectacion'] == 10) {
                  $igv_detalle = $v['precio'] * $v['cantidad'] * $igv_porcentaje;
                  $factor_porcentaje = 1 + $igv_porcentaje;
                  } */

                if ($productoCodigoafectacion == 10) {
                    $igv_detalle = $v['prisal'] * $v['canpro'] * $igv_porcentaje;
                    $factor_porcentaje = 1 + $igv_porcentaje;
                }

                $codproducto = $producto['codpro'];
                $unidad = 'NIU';
                $descripcion = mb_strtoupper($producto['desprod'], 'UTF-8');
                $cantidad = $v['canpro'];
                $valunitario = ($v['prisal'] / ($factor_porcentaje));
                $valventa = ($v['pripro'] / ($factor_porcentaje));
                $baseigv = $valventa;
                $pcntjeigv = $factor_porcentaje * 100;
                $valigv = $baseigv * $factor_porcentaje;
                $totalimpuesto = $valigv;
                $preciounitario = $v['prisal'];
                $itemx = array(
                    'item' => $k,
                    'codigo' => trim($codproducto),
                    'descripcion' => trim($descripcion),
                    'cantidad' => number_format(
                            $cantidad,
                            2,
                            '.',
                            ''
                    ),
                    'valor_unitario' => number_format($valunitario, 2, '.', ''),
                    'precio_unitario' => number_format($valventa, 2, '.', ''),
                    'tipo_precio' => '01', //ya incluye igv
                    'igv' => number_format($igv_detalle, 2, '.', ''),
                    'porcentaje_igv' => number_format($igv_porcentaje * 100, 2, '.', ''),
                    'valor_total' => number_format($v['prisal'] * $v['canpro'], 2, '.', ''),
                    'importe_total' => number_format($v['pripro'] * $v['canpro'] * $factor_porcentaje, 2, '.', ''),
                    'unidad' => $unidad, //unidad,
                    'codigo_afectacion_alt' => $productoCodigoafectacion,
                    'codigo_afectacion' => $afectacion['codigo_afectacion'],
                    'nombre_afectacion' => $afectacion['nombre_afectacion'],
                    'tipo_afectacion' => $afectacion['tipo_afectacion']
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

            $sqlnota = "SELECT * FROM nota where invnum = '$id'";
            $resultnota = mysqli_query($conexion, $sqlnota);
            if (mysqli_num_rows($resultnota)) {
                $nota = mysqli_fetch_array($resultnota);
            }

            $tipodocVenta = ($nota['tipdoc '] == 1) ? '01' : '03';
            $idserie = ($nota['tipdoc '] == 1) ? '1' : '3';
            $doc = explode('-', $nota['nrofactura']);
            $serie_doc = explode('-', $nota['serie_doc']);
            $serie = $doc[0];
            $correlativo = str_pad($doc[1], 8, '0', STR_PAD_LEFT);

            $serieOLD = $serie_doc[0];
            $correlativoOLD = str_pad($serie_doc[1], 8, '0', STR_PAD_LEFT);

            $comprobante = array(
                'tipodoc' => $tipodocVenta,
                'idserie' => $idserie,
                'serie' => $serie,
                'correlativo' => $correlativo,
                'fecha_emision' => $nota['invfec'],
                'moneda' => 'PEN', //PEN->SOLES; USD->DOLARES
                'total_opgravadas' => number_format($op_gravadas, 2, '.', ''),
                'igv' => number_format($igv, 2, '.', ''),
                'total_opexoneradas' => number_format($op_exoneradas, 2, '.', ''),
                'total_opinafectas' => number_format($op_inafectas, 2, '.', ''),
                'total' => number_format($total, 2, '.', ''),
                'total_texto' => convertNumberToWord($total, 'PEN'),
                'codcliente' => $nota['cuscod'],
                'tipodoc_ref' => $nota['tipdoc_afec'],
                'serie_ref' => $serieOLD,
                'correlativo_ref' => $correlativoOLD,
                'codmotivo' => $nota['codnc'],
                'descripcion' => $nota['anotacion'],
            );

            /* echo '<pre>';
              print_r($comprobante);
              echo '</pre>'; */


            $ruta = "./xml/";
            $nombre = $emisor['ruc'] . '-' . $comprobante['tipodoc'] . '-' . $comprobante['serie'] . '-' . $comprobante['correlativo'];
            $generadoXML = new GeneradorXML();
            $generadoXML->CrearXMLNotaCredito($ruta . $nombre, $emisor, $cliente, $comprobante, $detalle);
            $api = new ApiFacturacion();
            $api->EnviarComprobanteElectronico($emisor, $nombre, "./", "./xml/", "./cdr/");

            /* exit(json_encode($comprobante, JSON_UNESCAPED_UNICODE)); */
            break;

        case 'crear_json_rd':
            $date = addslashes($_POST['date']);
            $sucursal = addslashes($_POST['sucursal']);

            $serie = date('Ymd');

            $now = date('Y-m-d');
            $sql = mysqli_query($conexion, "SELECT resumen_id FROM venta_resumen WHERE resumen_fecha = '$now'");
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
                "tipodoc" => "RC",
                "serie" => $serie,
                "correlativo" => $correlativo,
                "fecha_emision" => $date,
                "fecha_envio" => date('Y-m-d')
            );

            $items = array();
            $sql3 = mysqli_query($conexion, "SELECT v.*, c.dnicli, c.ruccli, c.dircli, c.descli FROM venta AS v LEFT JOIN cliente AS c ON v.cuscod = c.codcli WHERE v.invfec = '$date' AND v.nrofactura LIKE 'B%' AND v.sunat_enviado = 0 AND LENGTH(v.nrofactura) > 0 AND v.sucursal = '$sucursal' ORDER BY v.correlativo ASC");
            while ($key3 = mysqli_fetch_array($sql3, MYSQLI_ASSOC)) {
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
                        "item" => $key3['invnum'],
                        "tipodoc" => $tipodoc,
                        "serie" => $serie,
                        "correlativo" => $numero,
                        "condicion" => 1, //1->Registro, 2->Actuali, 3->Bajas
                        "moneda" => 'PEN',
                        "importe_total" => round($total, 2),
                        "valor_total" => round($opgravadas, 2),
                        "igv_total" => round($igv, 2),
                        "tipo_total" => "01", //GRA->01, EXO->02, INA->03
                        "codigo_afectacion" => "1000",
                        "nombre_afectacion" => "IGV",
                        "tipo_afectacion" => "VAT"
                    );
                }
            }
            $response['items_boleta'] = $items;

            exit(json_encode($response, JSON_UNESCAPED_UNICODE));

            break;

        case 'actualizar':
            $id = addslashes($_POST['id']);
            $enviado = addslashes($_POST['enviado']);
            $code = addslashes($_POST['code']);
            $description = addslashes($_POST['description']);
            $hash = addslashes($_POST['hash']);
            $data = '';
            if ($enviado > 0 and $code == '0') {
                $fenvio = date('Y-m-d H:i:s');
                $enviado = 1;
            } else {
                $fenvio = '0000-00-00 00:00:00';
                $enviado = 0;
            }
            $update = mysqli_query($conexion, "UPDATE venta SET sunat_fenvio = '$fenvio', sunat_enviado = '$enviado', sunat_respuesta_codigo = '$code', sunat_respuesta_descripcion = '$description', sunat_hash = '$hash' WHERE invnum = '$id'");
            $sql = mysqli_query($conexion, "SELECT v.*, c.dnicli, c.ruccli, c.dircli, c.descli FROM venta AS v LEFT JOIN cliente AS c ON v.cuscod = c.codcli WHERE v.invnum = '$id' LIMIT 1");
            while ($key = mysqli_fetch_array($sql, MYSQLI_ASSOC)) {
                $id = $key['invnum'];
                $type = ($key['tipdoc'] == 1) ? 'Factura' : 'Boleta';
                $typef = ($key['tipdoc'] == 1) ? "'F'" : "'B'";
                $doc = explode('-', $key['nrofactura']);
                $serie = $doc[0];
                $correlativo = str_pad($doc[1], 8, '0', STR_PAD_LEFT);
                $date = date('d/m/Y', strtotime($key['invfec']));
                $rucdni = ($key['tipdoc'] == 1) ? $key['ruccli'] : $key['dnicli'];
                $customer = utf8_encode($key['descli']);
                $total = number_format($key['invtot'], 2);
                $enviado = ($key['sunat_enviado'] > 0) ? date('d/m/Y', strtotime($key['sunat_fenvio'])) : 'No enviado';
                $respuestacod = $key['sunat_respuesta_codigo'];
                $respuestadesc = $key['sunat_respuesta_descripcion'];
                $option = ($key['sunat_enviado'] > 0) ? '<input type="button" class="btn-envio enviado" value="Enviar" disabled>' : '<input type="button" class="btn-envio" value="Enviar" onclick="enviar_documento_sunat(' . $id . ', ' . $typef . ');">';
                $data = '<tr id="row-' . $id . '">
								<td>' . $type . '</td>
								<td>' . $serie . '</td>
								<td>' . $correlativo . '</td>
								<td>' . $date . '</td>
								<td>' . $rucdni . '</td>
								<td>' . $customer . '</td>
								<td align="right">' . $total . '</td>
								<td>' . $enviado . '</td>
								<td>' . $respuestacod . '</td>
								<td>' . $respuestadesc . '</td>
								<td align="center">' . $option . '</td>
							 </tr>';
            }
            $response = array('data' => $data);
            exit(json_encode($response, JSON_UNESCAPED_UNICODE));
            break;

        case 'actualizar_nc':
            $id = addslashes($_POST['id']);
            $enviado = addslashes($_POST['enviado']);
            $code = addslashes($_POST['code']);
            $description = addslashes($_POST['description']);
            $hash = addslashes($_POST['hash']);
            $data = '';
            if ($enviado > 0 and $code == '0') {
                $fenvio = date('Y-m-d H:i:s');
                $enviado = 1;
            } else {
                $fenvio = '0000-00-00 00:00:00';
                $enviado = 0;
            }
            $update = mysqli_query($conexion, "UPDATE nota SET sunat_fenvio = '$fenvio', sunat_enviado = '$enviado', sunat_respuesta_codigo = '$code', sunat_respuesta_descripcion = '$description', sunat_hash = '$hash' WHERE invnum = '$id'");
            $sql = mysqli_query($conexion, "SELECT n.*, c.dnicli, c.ruccli, c.dircli, c.descli FROM nota AS n LEFT JOIN cliente AS c ON n.cuscod = c.codcli WHERE n.invnum = '$id' LIMIT 1");
            while ($key = mysqli_fetch_array($sql, MYSQLI_ASSOC)) {
                $id = $key['invnum'];
                $doc = explode('-', $key['nrofactura']);
                $serie = $doc[0];
                $correlativo = str_pad($doc[1], 8, '0', STR_PAD_LEFT);
                $date = date('d/m/Y', strtotime($key['invfec']));
                $anotacion = $key['anotacion'];
                $docafectado = explode('-', $key['serie_doc']);
                $afectado = $docafectado[0] . '-' . str_pad($docafectado[1], 8, '0', STR_PAD_LEFT);
                $rucdni = ($key['tipdoc'] == 1) ? $key['ruccli'] : $key['dnicli'];
                $customer = utf8_encode($key['descli']);
                $total = number_format($key['invtot'], 2);
                $enviado = ($key['sunat_enviado'] > 0) ? date('d/m/Y', strtotime($key['sunat_fenvio'])) : 'No enviado';
                $respuestacod = $key['sunat_respuesta_codigo'];
                $respuestadesc = $key['sunat_respuesta_descripcion'];
                $option = ($key['sunat_enviado'] > 0) ? '<input type="button" class="btn-envio enviado" value="Enviar" style="color:#A4A4A4" disabled>' : '<input type="button" class="btn-envio" value="Enviar" onclick="enviar_documento_sunat(' . $id . ');">';
                $data = '<tr id="row-' . $id . '">
								<td>' . $serie . '-' . $correlativo . '</td>
								<td>' . $date . '</td>
								<td>' . $anotacion . '</td>
								<td>' . $afectado . '</td>
								<td>' . $rucdni . '</td>
								<td>' . $customer . '</td>
								<td align="right">' . $total . '</td>
								<td>' . $enviado . '</td>
								<td>' . $respuestacod . '</td>
								<td>' . $respuestadesc . '</td>
								<td align="center">' . $option . '</td>
							  </tr>';
            }
            $response = array('data' => $data);
            exit(json_encode($response, JSON_UNESCAPED_UNICODE));
            break;

        case 'enviar_nota_credito':
            $date = addslashes($_POST['date']);
            $sucursal = addslashes($_POST['sucursal']);
            $data = '';
            $sql = mysqli_query($conexion, "SELECT n.*, c.dnicli, c.ruccli, c.dircli FROM nota AS n LEFT JOIN cliente AS c ON n.cuscod = c.codcli WHERE n.invfec = '$date' AND LENGTH(n.nrofactura) > 0 AND n.sunat_enviado = 0 AND n.sucursal = '$sucursal' ORDER BY n.nrofactura ASC");
            $items = array();
            while ($key = mysqli_fetch_array($sql, MYSQLI_ASSOC)) {
                $items[] = array(
                    'id' => $key['invnum'],
                );
            }
            exit(json_encode($items, JSON_UNESCAPED_UNICODE));
            break;
    }
}
