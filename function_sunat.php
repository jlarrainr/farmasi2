<?php

$BASE_PATCH = __DIR__;
$BASE_PATCH_SUNAT = $BASE_PATCH . "/principal/sunat/ApiFacturacion/";

require_once($BASE_PATCH_SUNAT . "xml.php");
require_once($BASE_PATCH_SUNAT . "ApiFacturacion.php");
require_once($BASE_PATCH_SUNAT . "funciones.php");

/**
 * 
 * @param type $id
 * @param type $conexion
 * @param type $send
 */
function FnGenerateXmlAndSendNc($id = 0, $conexion, $send = true) {
    $BASE_PATCH = __DIR__;
    $BASE_PATCH_SUNAT = $BASE_PATCH . "/principal/sunat/ApiFacturacion/";
    $generadoXML = new GeneradorXML();
    $api = new ApiFacturacion();
    //==================================================================

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

    $tipdoc_afec = $nota['tipdoc_afec'];
    $tipodocCliente = ($tipdoc_afec == '01') ? '6' : '1';
    $nrodocCliente = ($tipdoc_afec == '01') ? $datosCliente['ruccli'] : $datosCliente['dnicli'];

    $cliente = array(
        'tipodoc' => $tipodocCliente, //6->ruc, 1-> dni 
        'ruc' => $nrodocCliente,
        'razon_social' => $datosCliente['descli'],
        'direccion' => $datosCliente['dircli'],
        'pais' => 'PE'
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

        $productoCodigoafectacion = ($producto['igv'] == 1) ? '10' : '20';

        $sqlafectacion = "SELECT * FROM tipo_afectacion where codigo = '$productoCodigoafectacion'";
        $resultafectacion = mysqli_query($conexion, $sqlafectacion);
        if (mysqli_num_rows($resultafectacion)) {
            $afectacion = mysqli_fetch_array($resultafectacion);
        }

        $igv_detalle = 0;
        $factor_porcentaje = 1;

        if ($productoCodigoafectacion == 10) {
            $igv_detalle = ($v['prisal'] * $v['canpro']) - (($v['prisal'] * $v['canpro'])/1.18);
            //$igv_detalle = $v['prisal'] * $v['canpro'] * $igv_porcentaje;
            $factor_porcentaje = 1 + $igv_porcentaje;
        }

        $codproducto = $producto['codpro'];
        $unidad = 'NIU';
        $descripcion = (($producto['desprod']));
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
            'precio_unitario' => number_format($preciounitario, 2, '.', ''),
            'tipo_precio' => '01', //ya incluye igv
            'igv' => number_format($igv_detalle, 2, '.', ''),
            'porcentaje_igv' => number_format($igv_porcentaje * 100, 2, '.', ''),
            'valor_total_sigv' => number_format($valunitario * $v['canpro'], 2, '.', ''),
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
            //$op_gravadas = $op_gravadas + $itemx['valor_total'];
            $op_gravadas+= $valunitario* $v['canpro'];
        }

        if ($itemx['codigo_afectacion_alt'] == 20) {
            $op_exoneradas = $op_exoneradas + $itemx['valor_total'];
        }

        if ($itemx['codigo_afectacion_alt'] == 30) {
            $op_inafectas = $op_inafectas + $itemx['valor_total'];
        }

        $igv+=$igv_detalle;
    }

    $total = $op_gravadas + $op_exoneradas + $op_inafectas + $igv;

    $tipodocVenta = '07';
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

    $ruta = $BASE_PATCH_SUNAT . $emisor['ruc'] . '/xml/';
    $nombre = $emisor['ruc'] . '-' . $comprobante['tipodoc'] . '-' . $comprobante['serie'] . '-' . $comprobante['correlativo'];

    $generadoXML->CrearXMLNotaCredito(
            $ruta . $nombre,
            $emisor,
            $cliente,
            $comprobante,
            $detalle
    );

    if ($send) {
        $response = $api->EnviarComprobanteElectronico(
                $emisor,
                $nombre,
                $BASE_PATCH_SUNAT,
                $BASE_PATCH_SUNAT . $emisor['ruc'] . "/xml/",
                $BASE_PATCH_SUNAT . $emisor['ruc'] . "/cdr/"
        );
        //var_dump($response);
        $enviador = $response['status'];
        $code = $response['ResponseCode'];
        $description = $response['Description'];
        $hash = $response['hash'];
        $description = str_replace("'", "", $description);
        if ($enviador > 0 and $code == '0') {
            $fenvio = date('Y-m-d H:i:s');
            $enviado = 1;
        } else {
            $fenvio = '0000-00-00';
            $enviado = 0;
        }

        mysqli_query($conexion, "UPDATE nota SET sunat_fenvio = '$fenvio', sunat_enviado = '$enviado', sunat_respuesta_codigo = '$code', sunat_respuesta_descripcion = '$description', sunat_hash = '$hash' WHERE invnum = '$id'");
    }


    //print_r($response);
}

/**
 * 
 * @param type $id
 * @param type $conexion
 */
function FnGenerateXmlAndSend($id = 0, $conexion, $send = true) {
    $BASE_PATCH = __DIR__;
    $BASE_PATCH_SUNAT = $BASE_PATCH . "/principal/sunat/ApiFacturacion/";
    $generadoXML = new GeneradorXML();
    $api = new ApiFacturacion();
    //==================================================================
    $sqlboleta = "SELECT * FROM venta where invnum = '$id'";
    //echo "$sqlboleta";
    $resultboleta = mysqli_query($conexion, $sqlboleta);
    if (mysqli_num_rows($resultboleta)) {
        $boleta = mysqli_fetch_array($resultboleta);
    }

    //==================================================================
    $sqldatagen = "SELECT * FROM datagen  ";
    $resultdatagen = mysqli_query($conexion, $sqldatagen);
    if (mysqli_num_rows($resultdatagen)) {
        $datagen = mysqli_fetch_array($resultdatagen);
    }
    $sucursal = $boleta['sucursal'];

    //==================================================================
    //obtenemos los datos del emisor de la BD
    $sqlemisor = "SELECT * FROM emisor where id = '$sucursal'";
    //echo $sqlemisor; 
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

    $tipodocCliente = ($boleta['tipdoc'] == 1) ? '6' : '1';
    $nrodocCliente = ($boleta['tipdoc'] == 1) ? $datosCliente['ruccli'] : $datosCliente['dnicli'];

    $cliente = array(
        'tipodoc' => $tipodocCliente, //6->ruc, 1-> dni 
        'ruc' => $nrodocCliente,
        'razon_social' => $datosCliente['descli'],
        'direccion' => $datosCliente['dircli'],
        'pais' => 'PE'
    );

    $detalle = array();

    $porcentajeigv = 0;
    $igvtabla = mysqli_query($conexion, "SELECT porcent FROM datagen ORDER BY cdatagen DESC LIMIT 1");
    while ($rowigvtabla = mysqli_fetch_array($igvtabla, MYSQLI_ASSOC)) {
        $porcentajeigv = (float) $rowigvtabla['porcent'];
        $porcentajeigv = $porcentajeigv / 100;
    }

    $op_gravadas = 0.00;
    $op_exoneradas = 0.00;
    $op_inafectas = 0.00;
    $igv = 0;
    $total = 0;

    //==================================================================
    $total_gravada = 0.00;
    $total_inafecta = 0.00;
    $total_gratuita = 0.00;
    $total_exonerada = 0.00;

    $sqldetalle_venta = "SELECT * FROM detalle_venta where invnum = '$id' and canpro >'0'";
    $resultdetalle_venta = mysqli_query($conexion, $sqldetalle_venta);

    $k = 0;
    //==================================================================
    while ($v = mysqli_fetch_array($resultdetalle_venta, MYSQLI_ASSOC)) {

        $k++;
        $porcentaje = $porcentajeigv;
        //==================================================================
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
            //$productoCodigoafectacion = '20'; //EXONERADO - OPERACION ONEROSA
            $productoCodigoafectacion = '30'; //EXONERADO - OPERACION INAFECTO
        }

        //==================================================================
        $sqlafectacion = "SELECT * FROM tipo_afectacion where codigo = '$productoCodigoafectacion'";
        $resultafectacion = mysqli_query($conexion, $sqlafectacion);
        if (mysqli_num_rows($resultafectacion)) {
            $afectacion = mysqli_fetch_array($resultafectacion);
        }

        $factor_porcentaje = 1;

        //==================================================================
        //ROMMEL MERCADO
        //18-12-2021
        //==================================================================                
        $tipo_precio = "01";
        $is_gratuito = false;
        if ($v['prisal'] <= 0) {
            $v['prisal'] = 0.25 * $v['canpro'];
            $v['pripro'] = 0.25 * $v['canpro'];
            $afectacion['codigo_afectacion'] = "9996";
            $afectacion['nombre_afectacion'] = "GRA";
            $afectacion['tipo_afectacion'] = "FRE";
            $total_gratuita += $v['pripro'];
            $tipo_precio = "02";
            $is_gratuito = true;
        } else {
            $total_gravada += $v['pripro'] / (1 + $porcentaje);
        }

        //==================================================================
        $codproducto = $producto['codpro'];
        $unidad = 'NIU';
        $descripcion = ($producto['desprod']);
        $cantidad = $v['canpro'];
        $valunitario = ($v['pripro']);
        $valor_total = $valunitario / (1 + $porcentaje);
        $pcntjeigv = $porcentaje;
        $valventa = ($v['prisal']);
        $igv_detalle = $valunitario - $valor_total;
        $valunitarioPor = $valventa / (1 + $porcentaje);

        $baseigv = $valventa;
        $valigv = $baseigv * $factor_porcentaje;
        $totalimpuesto = $valigv;
        $preciounitario = $v['prisal'];

        $op = ($v['prisal'] * $v['canpro'] * $factor_porcentaje);

        //==================================================================
        if ($is_gratuito == true) {
            $valunitarioPor = 0.00;
            $valor_total = $valunitario;
            $igv_detalle = 0.00;
            $pcntjeigv = 0.00;
            $productoCodigoafectacion = "21";
            $valventa = 0.25;
        }
        //==================================================================
        $itemx = array(
            'item' => $k,
            'codigo' => trim($codproducto),
            'descripcion' => utf8_encode(trim($descripcion)),
            'cantidad' => number_format($cantidad, 2, '.', ''),
            'valor_unitario' => number_format($valunitarioPor, 4, '.', ''),
            'precio_unitario' => number_format($valventa, 2, '.', ''),
            'tipo_precio' => $tipo_precio, //ya incluye igv
            'igv' => number_format($igv_detalle, 2, '.', ''),
            'porcentaje_igv' => number_format($pcntjeigv * 100, 2, '.', ''),
            'valor_total' => number_format($valor_total, 2, '.', ''),
            'importe_total' => number_format($op, 2, '.', ''),
            'unidad' => $unidad, //unidad,
            'codigo_afectacion_alt' => $productoCodigoafectacion,
            'codigo_afectacion' => $afectacion['codigo_afectacion'],
            'nombre_afectacion' => $afectacion['nombre_afectacion'],
            'tipo_afectacion' => $afectacion['tipo_afectacion']
        );
        //var_dump($itemx);

        $detalle[] = $itemx;
    }
    //==================================================================
    //ROMMEL MERCADO
    //18-12-2021
    //==================================================================
    $igv = $boleta['igv'];
    $total = $boleta['invtot'];
    $op_gravadas = $boleta['gravado'];
    $op_inafectas = $boleta['inafecto'];
    $tipodocVenta = ($boleta['tipdoc'] == 1) ? '01' : '03';
    $idserie = ($boleta['tipdoc'] == 1) ? '1' : '3';
    $doc = explode('-', $boleta['nrofactura']);
    $serie = $doc[0];
    $correlativo = str_pad($doc[1], 8, '0', STR_PAD_LEFT);

    $formaPagoActivo = ($boleta['numeroCuota'] > 0) ? '1' : '0';
    if ($boleta['numeroCuota'] > 0) {
        $formaPagoMontoApagarPorMes = $total / $boleta['numeroCuota'];
    } else {

        $formaPagoMontoApagarPorMes = 0;
    }


    //==================================================================
    //ROMMEL MERCADO
    //18-12-2021
    //==================================================================
    $comprobante = array(
        'tipodoc' => $tipodocVenta,
        'idserie' => $idserie,
        'serie' => $serie,
        'correlativo' => $correlativo,
        'fecha_emision' => $boleta['invfec'],
        'moneda' => 'PEN', //PEN->SOLES; USD->DOLARES
        'total_opgravadas' => number_format($op_gravadas, 2, '.', ''),
        'total_opgratuita' => number_format($total_gratuita, 2, '.', ''),
        'igv' => number_format($igv, 2, '.', ''),
        'total_opexoneradas' => number_format($op_exoneradas, 2, '.', ''),
        'total_opinafectas' => number_format($op_inafectas, 2, '.', ''),
        'total' => number_format($total, 2, '.', ''),
        'total_texto' => convertNumberToWord($total, 'PEN'),
        'codcliente' => $boleta['cuscod'],
        'numeroCuota' => $boleta['numeroCuota'],
        'formaPagoActivo' => $formaPagoActivo,
        'formaPagoMontoApagarPorMes' => number_format($formaPagoMontoApagarPorMes, 2, '.', ''),
        'diasCuotasVentas' => $datagen['diasCuotasVentas']
    );
    //==================================================================
    //$ruta = "../" . $emisor['ruc'] . "/xml/";
    $ruta = $BASE_PATCH_SUNAT . $emisor['ruc'] . "/xml/";
    $nombre = $emisor['ruc'] . '-' . $comprobante['tipodoc'] . '-' . $comprobante['serie'] . '-' . $comprobante['correlativo'];

    //==================================================================
    if ($comprobante['tipodoc'] == '01' ||
            $comprobante['tipodoc'] == '03'
    ) {
        $generadoXML->CrearXMLFactura(
                $ruta . $nombre,
                $emisor,
                $cliente,
                $comprobante,
                $detalle
        );
    }

    //==================================================================
    //ROMMEL MERCADO
    //19-12-2021
    if ($send) {


        $response = $api->EnviarComprobanteElectronico(
                $emisor,
                $nombre,
                $BASE_PATCH_SUNAT,
                $BASE_PATCH_SUNAT . $emisor['ruc'] . "/xml/",
                $BASE_PATCH_SUNAT . $emisor['ruc'] . "/cdr/"
        );
        //==================================================================


        $enviador = $response['status'];
        $code = $response['ResponseCode'];
        $description = $response['Description'];
        $hash = $response['hash'];

        // $description1 = str_replace("El comprobante fue registrado previamente con otros datos -", "", $description);
        $description = str_replace("'", "", $description);

        if ($enviador > 0 and $code == '0') {
            $fenvio = date('Y-m-d H:i:s');
            $enviado = 1;
        } else {
            $fenvio = '0000-00-00';
            $enviado = 0;
        }

        //==================================================================
        //UPDATE STATUS
        mysqli_query($conexion, "UPDATE venta SET sunat_fenvio = '$fenvio',sunat_enviado = '$enviado',sunat_respuesta_codigo = '$code',sunat_respuesta_descripcion = '$description',sunat_hash = '$hash',sisFacturacion='$enviado' WHERE invnum = '$id'");
        //==================================================================        
    }
}

/**
 * 
 * @param type $date
 * @param type $sucursal
 * @param type $tiposummary
 * @return type
 */
function FnQuerySummary($date, $sucursal, $tiposummary = 'boleta') {
    $val_habil = "";
    if ($tiposummary == 'boleta') {
        $tipdoc = "'2'";
        $sunat_enviado = '0';
    }
    if ($tiposummary == 'anullboleta') {
        $tipdoc = "'2'";
        $sunat_enviado = '1';
        $val_habil = " AND LENGTH(IFNULL(v.sunat_voided,''))=0 and v.val_habil='1' ";
    }
    if ($tiposummary == 'notasboleta') {
        $tipdoc = "'6'";
        $sunat_enviado = '0';
    }
    if ($tiposummary == 'anullnotasboleta') {
        $tipdoc = "'6'";
        $sunat_enviado = '1';
        $val_habil = " AND LENGTH(IFNULL(v.sunat_voided,''))=0 and v.val_habil='1' ";
    }
    if ($tiposummary == 'anullfactura') {
        $tipdoc = "'1'";
        $sunat_enviado = '1';
        $val_habil = " AND LENGTH(IFNULL(v.sunat_voided,''))=0 and v.val_habil='1' ";
    }

    $query_doc = "
                            SELECT 
                                  v.*,
                                  c.dnicli,
                                  c.ruccli,
                                  c.dircli,
                                  c.descli 
                            FROM
                                  venta AS v 
                                  LEFT JOIN cliente AS c 
                                        ON v.cuscod = c.codcli 
                            WHERE v.invfec = '$date' 
                                  AND v.tipdoc IN($tipdoc) " . $val_habil;

    $query_doc .= "               AND v.sunat_enviado = '$sunat_enviado' 
                                  AND v.sucursal = '$sucursal' 
                                  AND v.estado='0'
                            ORDER BY v.correlativo ASC  LIMIT 500";
    return $query_doc;
}

/**
 * 
 * @param type $typesummary
 * @param type $ticket
 * @param type $summary
 * @return type
 */
function FnQueryUpdateTicket($typesummary, $ticket, $summary) {
    $query = "";
    if ($typesummary == 'boleta') {

        $query .= " sunat_ticket = '$ticket', ";
        $query .= " sunat_summary = '$summary', ";
    }
    if ($typesummary == 'anullboleta') {

        $query .= " sunat_ticket_voided = '$ticket', ";
        $query .= " sunat_voided = '$summary', ";
    }
    if ($typesummary == 'notasboleta') {

        $query .= " sunat_ticket = '$ticket', ";
        $query .= " sunat_summary = '$summary', ";
    }
    if ($typesummary == 'anullnotasboleta') {

        $query .= " sunat_ticket_voided = '$ticket', ";
        $query .= " sunat_voided = '$summary', ";
    }
    if ($typesummary == 'anullfactura') {

        $query .= " sunat_ticket_voided = '$ticket', ";
        $query .= " sunat_voided = '$summary', ";
    }
    return $query;
}

/**
 * 
 * @param type $date
 * @param type $sucursal
 */
function FnDeclaracionMasivaFactura($date, $sucursal, $conexion) {
    $sqldetalle_ventaMasiva = "SELECT invnum FROM venta  as v  WHERE v.invfec = '$date' AND tipdoc IN('1','2') AND LENGTH(v.nrofactura) > 0 AND v.sucursal = '$sucursal'  and v.sunat_enviado=0  and v.sunat_respuesta_descripcion=''  ORDER BY v.correlativo ASC";
    $resultdetalle_ventaMasiva = mysqli_query($conexion, $sqldetalle_ventaMasiva);
    while ($ventaMasiva = mysqli_fetch_array($resultdetalle_ventaMasiva, MYSQLI_ASSOC)) {

        $id = $ventaMasiva['invnum'];
        FnGenerateXmlAndSend($id, $conexion);
    }
}

/**
 * 
 * @param type $date
 * @param type $sucursal
 */
function FnDeclaracionMasivaNCFactura($date, $sucursal, $conexion) {
    $sqldetalle_ventaMasiva = "SELECT invnum FROM nota  as v  WHERE v.invfec = '$date' AND v.tipdoc='6' AND LENGTH(v.serie_doc) > 0 AND v.sucursal = '$sucursal'  and v.sunat_enviado=0  and v.sunat_respuesta_descripcion=''  ORDER BY v.correlativo ASC";
    //echo $sqldetalle_ventaMasiva;
    $resultdetalle_ventaMasiva = mysqli_query($conexion, $sqldetalle_ventaMasiva);
    while ($ventaMasiva = mysqli_fetch_array($resultdetalle_ventaMasiva, MYSQLI_ASSOC)) {

        $id = $ventaMasiva['invnum'];
        FnGenerateXmlAndSendNc($id, $conexion);
    }
}

/**
 * 
 * @param type $date
 * @param type $sucursal
 * @param type $typesummary
 * @param type $conexion
 */
function FnSendGenerateSummary($date, $sucursal, $typesummary, $conexion) {
    $BASE_PATCH = __DIR__;
    $BASE_PATCH_SUNAT = $BASE_PATCH . "/principal/sunat/ApiFacturacion/";
    $generadoXML = new GeneradorXML();
    $api = new ApiFacturacion();
    if ($typesummary == 'boleta') {
        $prefix = "RC";
        $condition = "1";
        $tipodoc_rc = "03";
    }
    if ($typesummary == 'anullboleta') {
        $prefix = "RC";
        $condition = "3";
        $tipodoc_rc = "03";
    }
    if ($typesummary == 'notasboleta') {
        $prefix = "RC";
        $condition = "1";
        $tipodoc_rc = "07";
    }
    if ($typesummary == 'anullnotasboleta') {
        $prefix = "RC";
        $condition = "3";
        $tipodoc_rc = "07";
    }
    if ($typesummary == 'anullfactura') {
        $prefix = "RA";
        $tipodoc_rc = "01";
        $condition = "3";
    }
    if ($typesummary == 'anullncfactura') {
        $prefix = "RA";
        $tipodoc_rc = "07";
        $condition = "3";
    }



    //$now = date('Y-m-d');
    //$serie = date('Ymd');
    $now = $date;
    $serie = str_replace("-", "", $date);

    $query = "SELECT resumen_id FROM venta_resumen WHERE resumen_fecha = '$now'";
    //echo $query;
    $sql = mysqli_query($conexion, $query);
    $n = mysqli_num_rows($sql);
    $n++;
    //POR AHORA CON 100 LUEGO QUIARLOI
    $n = str_pad($n, 3, '0', STR_PAD_LEFT);
    $resumen_boleta = $prefix . '-' . str_replace('-', '', $now) . '-' . $n;

    //==================================================================
    //AUTOR ROMMEL MERCADO
    //FECHA: 19-12-2021
    //==================================================================
    $sqlemisor = "SELECT * FROM emisor where id = $sucursal";
    $resultemisor = mysqli_query($conexion, $sqlemisor);
    if (mysqli_num_rows($resultemisor)) {
        $emisor = mysqli_fetch_array($resultemisor);
    }

    //==================================================================
    //AUTOR ROMMEL MERCADO
    //FECHA: 19-12-2021
    //==================================================================
    $cabecera = array(
        "tipodoc" => $prefix,
        "serie" => $serie,
        "correlativo" => $n,
        "fecha_emision" => $date,
        "fecha_envio" => $date
    );

    $items = array();
    $k = 0;

    $query = FnQuerySummary($date, $sucursal, $typesummary);

    $sql3 = mysqli_query($conexion, $query);
    $row_cnt = $sql3->num_rows;

    if ($row_cnt > 0) {


        //==================================================================
        //AUTOR ROMMEL MERCADO
        //FECHA: 19-12-2021
        //==================================================================
        while ($key3 = mysqli_fetch_array($sql3, MYSQLI_ASSOC)) {
            FnGenerateXmlAndSend($key3['invnum'], $conexion, false);
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
            $tipodoc = $tipodoc_rc; //tipo de documento
            $clitipo = '1';
            $clinro = trim($key3['dnicli']);
            if ($total > 0) {

                $items[] = array(
                    "item" => $k,
                    "invnum" => $key3['invnum'],
                    "tipodoc" => $tipodoc,
                    "serie" => $serie,
                    "correlativo" => $numero,
                    "condicion" => $condition, //1->Registro, 2->Actuali, 3->Bajas
                    "moneda" => 'PEN',
                    "importe_total" => round($total, 2),
                    "valor_total" => round($opgravadas, 2),
                    "igv_total" => round($igv, 2),
                    "tipo_total" => "01", //GRA->01, EXO->02, INA->03
                    "codigo_afectacion" => "1000",
                    "nombre_afectacion" => "IGV",
                    "tipo_afectacion" => "VAT",
                    "serienumero" => $serienumero,
                    "motivo" => "ANULADO POR ERROR DEL SISTEMA",
                    "dnicli" => $key3['dnicli'],
                    "nomcli" => $key3['descli'],
                );
            }
        }

        $resumen_documentos = '';
        foreach ($items as $key) {
            $resumen_documentos .= $key['serienumero'] . ', ';
        }

        $resumen_documentos = substr($resumen_documentos, 0, -2);

        $ruta = $BASE_PATCH_SUNAT . $emisor['ruc'] . "/xml/";

        $nombrexml = $emisor['ruc'] . '-' . $cabecera['tipodoc'] . '-' . $cabecera['serie'] . '-' . $cabecera['correlativo'];
        //var_dump($nombrexml);
        //==================================================================
        //AUTOR ROMMEL MERCADO
        //FECHA: 19-12-2021
        //==================================================================
        if ($prefix == 'RC') {
            $generadoXML->CrearXMLResumenDocumentos(
                    $emisor,
                    $cabecera,
                    $items,
                    $ruta . $nombrexml
            );
        } else {
            $generadoXML->CrearXmlBajaDocumentos(
                    $emisor,
                    $cabecera,
                    $items,
                    $ruta . $nombrexml
            );
        }


        //==================================================================
        //AUTOR ROMMEL MERCADO
        //FECHA: 19-12-2021
        //==================================================================
        $ticket = $api->EnviarResumenComprobantes(
                $emisor,
                $nombrexml,
                $BASE_PATCH_SUNAT,
                $BASE_PATCH_SUNAT . $emisor['ruc'] . "/xml/"
        );
        //var_dump($ticket);
        sleep(4);

        //==================================================================
        //AUTOR ROMMEL MERCADO
        //FECHA: 19-12-2021
        //==================================================================
        $response = $api->ConsultarTicket(
                $emisor,
                $cabecera,
                $ticket,
                $BASE_PATCH_SUNAT . $emisor['ruc'] . "/cdr/"
        );
        //var_dump($response);
        //==================================================================
        //AUTOR ROMMEL MERCADO
        //FECHA: 19-12-2021
        //==================================================================
        $enviador = $response['status'];
        $code = ($response['ResponseCode']);
        $resumen_resumen = $response['ReferenceID'];
        $description = ($response['Description']);

        $description = str_replace("'", "", $description);
        $hash = '';
        $resumen_fecha = $date;
        //==================================================================
        //AUTOR ROMMEL MERCADO
        //FECHA: 19-12-2021
        //==================================================================
        $resumen_generacion = date('Y-m-d');
        if (intval($code) == 0) {
            $enviado = 1;
        } else {
            $enviado = 0;
        }

        //==================================================================
        //AUTOR ROMMEL MERCADO
        //FECHA: 19-12-2021
        //==================================================================

        $query_resumen = "INSERT INTO venta_resumen "
                . "(resumen_fecha, resumen_generacion, resumen_resumen, resumen_documentos, resumen_respuesta_codigo, resumen_respuesta_descripcion, resumen_hash, resumen_ticket, sucursal) "
                . "VALUES ('$resumen_fecha', "
                . "'$resumen_generacion', "
                . "'$resumen_boleta', "
                . "'$resumen_documentos', "
                . "'$code', "
                . "'$description', "
                . "'$hash', "
                . "'$ticket', "
                . "'$sucursal')";
        //echo $query_resumen;

        $insert = mysqli_query($conexion, $query_resumen);

        //==================================================================
        //AUTOR ROMMEL MERCADO
        //FECHA: 19-12-2021
        //==================================================================
        if ($insert) {
            $rd_id = mysqli_insert_id($conexion);
            foreach ($items as $key) {
                $boleta = $key['invnum'];
                $fenvio = date('Y-m-d H:i:s');
                $query_boleta = "UPDATE venta SET "
                        . "sunat_fenvio = '$fenvio', "
                        . "sunat_enviado = 1, "
                        . "sunat_respuesta_codigo = '$code', "
                        . "sunat_respuesta_descripcion = '$description', "
                        . "sunat_hash = '$hash',"
                        . FnQueryUpdateTicket($typesummary, $ticket, $resumen_boleta)
                        . "sisFacturacion='$enviado' "
                        . "WHERE invnum = '$boleta'";
                mysqli_query($conexion, $query_boleta);
            }
        }

        //==================================================================
    }
    //ok
}
/**
 * 
 * @param type $id
 * @param type $conexion
 * @param type $send
 */
function FnGenerateGuiaXmlAndSend($id = 0, $conexion, $send = true) {
    $BASE_PATCH = __DIR__;
    $BASE_PATCH_SUNAT = $BASE_PATCH . "/principal/sunat/ApiFacturacion/";
    $generadoXML = new GeneradorXML();
    $api = new ApiFacturacion();
    //==================================================================
    $sqlboleta = "SELECT * FROM sd_despatch where despatch_uid = '$id'";
    //echo $sqlboleta;
    $resultboleta = mysqli_query($conexion, $sqlboleta);
    if (mysqli_num_rows($resultboleta)) {
        $guia = mysqli_fetch_array($resultboleta);
    }


    //==================================================================
    $sqldatagen = "SELECT * FROM datagen  ";
    $resultdatagen = mysqli_query($conexion, $sqldatagen);
    if (mysqli_num_rows($resultdatagen)) {
        $datagen = mysqli_fetch_array($resultdatagen);
    }


    //==================================================================
    //obtenemos los datos del emisor de la BD
    $sqlemisor = "SELECT * FROM emisor ";
    //echo $sqlemisor; 
    $resultemisor = mysqli_query($conexion, $sqlemisor);
    if (mysqli_num_rows($resultemisor)) {
        $emisor = mysqli_fetch_array($resultemisor);
    }
    //var_dump($emisor);



    $detalle = array();

    $sqldetalle_venta = "SELECT * FROM sd_despatch_line where despatch_uid = '$id'";
    $resultdetalle_venta = mysqli_query($conexion, $sqldetalle_venta);

    $k = 0;
    //==================================================================
    while ($v = mysqli_fetch_array($resultdetalle_venta, MYSQLI_ASSOC)) {

        //==================================================================
        $itemx = array(
            'despatch_id' => $v['despatch_id'],
            'lineId' => $v['lineId'],
            'deliveredQuantity' => $v['deliveredQuantity'],
            'unitCode' => $v['unitCode'],
            'nameProduct' => $v['nameProduct'],
            'sellersItemIdentification' => $v['sellersItemIdentification'],
            'partyIdentification' => $v['partyIdentification'],
            'amountPrice' => $v['amountPrice'],
            'amountTotal' => $v['amountTotal'],
            'codeCurrency' => $v['codeCurrency'],
            'taxReasonCode' => $v['taxReasonCode'],
            'amountTaxted' => $v['amountTaxted'],
            'igvTax' => $v['igvTax'],
            'despatch_uid' => $v['despatch_uid'],
        );

        $detalle[] = $itemx;
    }

    //==================================================================
    //ROMMEL MERCADO
    //18-12-2021
    //==================================================================
    //==================================================================
    $ruta = $BASE_PATCH_SUNAT . $emisor['ruc'] . "/xml/";
    $guia['tipodoc'] = "09";
    $nombre = $emisor['ruc'] . '-' . $guia['tipodoc'] . '-' . $guia['despatch_id'];

    //==================================================================
    //var_dump($guia);
    $generadoXML->CrearXMLGuiaRemision(
            $ruta . $nombre,
            $emisor,
            $cliente,
            $guia,
            $detalle
    );

    //==================================================================
    //ROMMEL MERCADO
    //19-12-2021
    if ($send) {


        $response = $api->EnviarGuiaElectronicaApi(
                $emisor,
                $nombre,
                $BASE_PATCH_SUNAT,
                $BASE_PATCH_SUNAT . $emisor['ruc'] . "/xml/",
                $BASE_PATCH_SUNAT . $emisor['ruc'] . "/cdr/"
        );
        //==================================================================


        $enviador = $response['status'];
        $code = $response['ResponseCode'];
        $description = $response['Description'];
        $hash = $response['hash'];

        // $description1 = str_replace("El comprobante fue registrado previamente con otros datos -", "", $description);
        $description = str_replace("'", "", $description);

        //var_dump($response);

        if ($code == '0') {
            $fenvio = date('Y-m-d H:i:s');
            $enviado = 1;
        } else {
            $fenvio = '0000-00-00';
            $enviado = 0;
        }

        //==================================================================
        //UPDATE STATUS
        $sqlupd = "UPDATE sd_despatch SET sunat_fenvio = '$fenvio',"
                . "sunat_enviado = '$enviado',"
                . "sunatCode= '$code',"
                . "sunatMessage = '$description',"
                . "sunatTicket = '$hash',"
                . "sunat_respuesta_codigo = '$code',"
                . "sunat_respuesta_descripcion = '$description',"
                . "sunat_hash = '$hash',"
                . "sisFacturacion='$enviado'"
                . "WHERE despatch_uid = '$id'";
        //var_dump($sqlupd);
        mysqli_query($conexion, $sqlupd);
        //==================================================================        
    }
}


