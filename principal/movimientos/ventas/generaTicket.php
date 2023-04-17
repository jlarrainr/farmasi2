<?php

// error_reporting(E_ALL);
//  ini_set('display_errors', '1');
require_once('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
require_once('../../../convertfecha.php');    //CONEXION A BASE DE DATOS
require_once('MontosText.php');


 require_once '../../../function_sunat.php';
// require('../../session_filtro.php');
$rd = $_REQUEST['rd'];
$venta = $_REQUEST['vt'];

$numCopias = isset($_REQUEST['numCopias']) ? $_REQUEST['numCopias'] : 1;

function pintaDatos($Valor) {
    if ($Valor <> "") {
        return "<tr><td style:'text-align:center'><center>" . $Valor . "</center></td></tr>";
    }
}

function zero_fill($valor, $long = 0) {
    return str_pad($valor, $long, '0', STR_PAD_LEFT);
}

$sql1 = "SELECT nopaga FROM datagen";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $nopaga = $row1['nopaga'];
    }
}
$sql = "SELECT ingreso2 FROM usuario where usecod = '$usuario'  ";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $ingreso2 = $row['ingreso2'];
    }
}
?>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
        <script>
            function imprimir() {
                console.log("Imprimiendo");
                var f = document.form1;
                window.focus();
                window.print();
                //f.action = "venta_index.php";
<?php if (($numCopias == 2) || ($numCopias == 3) || ($numCopias == 4)) { ?>
                    f.action = "generaTicket_copy.php?<?php echo ("rd=$rd&vt=$venta&numCopias=$numCopias") ?>";
                    f.method = "post";
                    f.submit();
    <?php
} else {
    if (($nopaga == 2) || ($alertaPagoPorLocal == 2)) {
        ?>
                        var f = document.form1;
                        f.action = "logout.php";
                        f.method = "post";
                        f.submit();
        <?php
    } else {
        ?>
                        //                    $.ajax({
                        //                    type: 'POST',
                        //                    url: 'ApiFacturacion/controlador/controlador.php',
                        //                    data: {
                        //                        action: 'GUARDAR_VENTA',
                        //                        id: <?php echo $venta; ?>
                        //                    },
                        //                    success: async function (data) {
                        //                       
                        //                    }
                        //                }).fail(function (jqXHR, textStatus, errorThrown) {
                        //                   
                        //                });    
                        var f = document.form1;
                        f.action = "ventas_registro.php";
                        f.method = "post";
                        f.submit();
        <?php
    }
}
?>
            }
        </script>

        <link href="css/css_bodyimprime.css" rel="stylesheet" type="text/css" />
        <link href="css/css_bodyimprimeA4.css" rel="stylesheet" type="text/css" />
    </head>

    <?php

    function cambiarFormatoFecha($fecha) {
        list($anio, $mes, $dia) = explode("-", $fecha);
        return $dia . "/" . $mes . "/" . $anio;
    }

//set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR;

//html PNG location prefix
    $PNG_WEB_DIR = 'temp/';

    include "../../phpqrcode/qrlib.php";

    $filename = $PNG_TEMP_DIR . 'ventas.png';

    $matrixPointSize = 3;
    $errorCorrectionLevel = 'L';
    $framSize = 3; //TamaÃÂ¯ÃÂ¿ÃÂ½ÃÂ¯ÃÂ¿ÃÂ½ÃÂ¯ÃÂ¿ÃÂ½ÃÂ¯ÃÂ¿ÃÂ½ÃÂ¯ÃÂ¿ÃÂ½o en blanco
//error_log("Num copias: " . $_REQUEST['numCopias']);
//error_log("Num copias: " . $_REQUEST['numCopias']);
    $seriebol = "B001";
    $seriefac = "F001";
    $serietic = "T001";
    $filename = $PNG_TEMP_DIR . 'test' . $venta . md5($_REQUEST['data'] . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) . '.png';

    require_once('calcula_monto2.php');
    $sqlV = "SELECT invnum,nrovent,invfec,invfec,cuscod,usecod,codven,forpag,fecven,sucursal,correlativo,nomcliente,pagacon,vuelto,bruto,hora,invtot,igv,valven,tipdoc,tipteclaimpresa,anotacion,nrofactura,icbpertotal,numeroCuota FROM venta where invnum = '$venta'";
    $resultV = mysqli_query($conexion, $sqlV);
    if (mysqli_num_rows($resultV)) {
        while ($row = mysqli_fetch_array($resultV)) {
            $invnum = $row['invnum'];
            $nrovent = $row['nrovent'];
            $invfecS = $row['invfec'];
            $invfec = cambiarFormatoFecha($row['invfec']);
            $cuscod = $row['cuscod'];
            $usecod = $row['usecod'];
            $codven = $row['codven'];
            $forpag = $row['forpag'];
            $fecven = $row['fecven'];
            $sucursal = $row['sucursal'];
            $correlativo = $row['correlativo'];
            $nomcliente = $row['nomcliente'];
            $pagacon = $row['pagacon'];
            $vuelto = $row['vuelto'];
            $valven = $row['valven'];
            $igv = $row['igv'];
            $invtot = $row['invtot'];
            $icbper_total = $row['icbpertotal'];
            $hora = $row['hora'];
            $tipdoc = $row['tipdoc'];
            $tipteclaimpresa = $row['tipteclaimpresa'];
            $anotacion = $row['anotacion'];
            $nrofactura = $row['nrofactura'];
            $numeroCuota = $row['numeroCuota'];

            $sqlXCOM = "SELECT seriebol,seriefac,serietic FROM xcompa where codloc = '$sucursal'";
            $resultXCOM = mysqli_query($conexion, $sqlXCOM);
            if (mysqli_num_rows($resultXCOM)) {
                while ($row = mysqli_fetch_array($resultXCOM)) {
                    $seriebol = $row['seriebol'];
                    $seriefac = $row['seriefac'];
                    $serietic = $row['serietic'];
                }
            }
        }
    }


    if ($forpag == "E") {
        $forma = "CONTADO";
    }
    if ($forpag == "C") {
        $forma = "CREDITO";
    }
    if ($forpag == "T") {
        $forma = "CONTADO";
    }
    if ($forpag == "M") {
        $forma = "CONTADO";
    }
//F9
    if ($tipteclaimpresa == "2") {
        if ($tipdoc == 1) {
            $serie = "F" . $seriefac;
        }
        if ($tipdoc == 2) {
            $serie = "B" . $seriebol;
        }
        if ($tipdoc == 4) {
            $serie = "T" . $serietic;
        }
    } else { //F8
        $serie = $correlativo;
    }

    if ($tipdoc == 1) {
        $TextDoc = "Factura electr&oacute;nica";
    }
    if ($tipdoc == 2) {
        $TextDoc = "Boleta de Venta electr&oacute;nica";
    }
    if ($tipdoc == 4) {
        $TextDoc = "";
    }
    $SerieQR = $serie;

//TOMO LOS PATRAMETROS DEL TICKET
    $sqlTicket = "SELECT linea1,linea2,linea3,linea4,linea5,linea6,linea7,linea8,linea9,pie1,pie2,pie3,pie4,pie5,pie6,pie7,pie8,pie9 "
            . "FROM ticket where sucursal = '$sucursal'";
    $resultTicket = mysqli_query($conexion, $sqlTicket);
    if (mysqli_num_rows($resultTicket)) {
        while ($row = mysqli_fetch_array($resultTicket)) {
            $linea1 = $row['linea1'];
            $linea2 = $row['linea2'];
            $linea3 = $row['linea3'];
            $linea4 = $row['linea4'];
            $linea5 = $row['linea5'];
            $linea6 = $row['linea6'];
            $linea7 = $row['linea7'];
            $linea8 = $row['linea8'];
            $linea9 = $row['linea9'];
            $pie1 = $row['pie1'];
            $pie2 = $row['pie2'];
            $pie3 = $row['pie3'];
            $pie4 = $row['pie4'];
            $pie5 = $row['pie5'];
            $pie6 = $row['pie6'];
            $pie7 = $row['pie7'];
            $pie8 = $row['pie8'];
            $pie9 = $row['pie9'];
        }
    } else {
        $sqlTicket = "SELECT linea1,linea2,linea3,linea4,linea5,linea6,linea7,linea8,linea9,pie1,pie2,pie3,pie4,pie5,pie6,pie7,pie8,pie9 "
                . "FROM ticket where sucursal = '1'";
        $resultTicket = mysqli_query($conexion, $sqlTicket);
        if (mysqli_num_rows($resultTicket)) {
            while ($row = mysqli_fetch_array($resultTicket)) {
                $linea1 = $row['linea1'];
                $linea2 = $row['linea2'];
                $linea3 = $row['linea3'];
                $linea4 = $row['linea4'];
                $linea5 = $row['linea5'];
                $linea6 = $row['linea6'];
                $linea7 = $row['linea7'];
                $linea8 = $row['linea8'];
                $linea9 = $row['linea9'];
                $pie1 = $row['pie1'];
                $pie2 = $row['pie2'];
                $pie3 = $row['pie3'];
                $pie4 = $row['pie4'];
                $pie5 = $row['pie5'];
                $pie6 = $row['pie6'];
                $pie7 = $row['pie7'];
                $pie8 = $row['pie8'];
                $pie9 = $row['pie9'];
            }
        }
    }
    $sqlUsu = "SELECT nomusu,abrev FROM usuario where usecod = '$usecod'";
    $resultUsu = mysqli_query($conexion, $sqlUsu);
    if (mysqli_num_rows($resultUsu)) {
        while ($row = mysqli_fetch_array($resultUsu)) {
            $nomusu = $row['nomusu'];
            $nomusu2 = $row['abrev'];
        }
    }

    $MarcaImpresion = 0;
    $sqlDataGen = "SELECT desemp,rucemp,telefonoemp,MarcaImpresion,diasCuotasVentas,porcent FROM datagen";
    $resultDataGen = mysqli_query($conexion, $sqlDataGen);
    if (mysqli_num_rows($resultDataGen)) {
        while ($row = mysqli_fetch_array($resultDataGen)) {
            $desemp = $row['desemp'];
            $rucemp = $row['rucemp'];
            $telefonoemp = $row['telefonoemp'];
            $MarcaImpresion = $row["MarcaImpresion"];
            $diasCuotasVentas = $row["diasCuotasVentas"];
           
        }
    }
    $departamento = "";
    $provincia = "";
    $distrito = "";
    $pstcli = 0;
    $sqlCli = "SELECT descli,dnicli,dircli,ruccli,puntos,dptcli,procli,discli FROM cliente where codcli = '$cuscod'";
    $resultCli = mysqli_query($conexion, $sqlCli);
    if (mysqli_num_rows($resultCli)) {
        while ($row = mysqli_fetch_array($resultCli)) {
            $descli = $row['descli'];
            $dnicli = $row['dnicli'];
            $dircli = $row['dircli'];
            $ruccli = $row['ruccli'];
            $pstcli = $row['puntos'];
            $dptcli = $row['dptcli'];
            $procli = $row['procli'];
            $discli = $row['discli'];
        }
        if (strlen($dircli) > 0) {
            //VERIFICO LOS DPTO, PROV Y DIST
            if (strlen($dptcli) > 0) {
                $sqlDPTO = "SELECT name FROM departamento where id = '$dptcli'";
                $resultDPTO = mysqli_query($conexion, $sqlDPTO);
                if (mysqli_num_rows($resultDPTO)) {
                    while ($row = mysqli_fetch_array($resultDPTO)) {
                        $departamento = $row['name'];
                    }
                }
            }
            if (strlen($procli) > 0) {
                $sqlDPTO = "SELECT name FROM provincia where id = '$procli'";
                $resultDPTO = mysqli_query($conexion, $sqlDPTO);
                if (mysqli_num_rows($resultDPTO)) {
                    while ($row = mysqli_fetch_array($resultDPTO)) {
                        $provincia = " | " . $row['name'];
                    }
                }
            }

            if (strlen($discli) > 0) {
                $sqlDPTO = "SELECT name FROM distrito where id = '$discli'";
                $resultDPTO = mysqli_query($conexion, $sqlDPTO);
                if (mysqli_num_rows($resultDPTO)) {
                    while ($row = mysqli_fetch_array($resultDPTO)) {
                        $distrito = " | " . $row['name'];
                    }
                }
            }
            $Ubigeo = $departamento . $provincia . $distrito;
            if (strlen($Ubigeo) > 0) {
                $dircli = $dircli . "  - " . $Ubigeo;
            }
        }
    }
    $i=0;
    $SumInafectos = 0;
    $sqlDetTot = "SELECT * FROM detalle_venta where invnum = '$venta' and canpro <> '0'";
    $resultDetTot = mysqli_query($conexion, $sqlDetTot);
    if (mysqli_num_rows($resultDetTot)) {
        while ($row = mysqli_fetch_array($resultDetTot)) {
          
            $igvVTADet = 0;
            $codproDet = $row['codpro'];
            $canproDet = $row['canpro'];
            $factorDet = $row['factor'];
            $prisalDet = $row['prisal'];
            $priproDet = $row['pripro'];
            $fraccionDet = $row['fraccion'];
            
            $sqlProdDet = "SELECT igv FROM producto where codpro = '$codproDet'";
            $resultProdDet = mysqli_query($conexion, $sqlProdDet);
            if (mysqli_num_rows($resultProdDet)) {
                while ($row1 = mysqli_fetch_array($resultProdDet)) {
                    $igvVTADet = $row1['igv'];
                }
            }
            if ($igvVTADet == 0) {
                $MontoDetalle = $prisalDet * $canproDet;
                $SumInafectos = $SumInafectos + $MontoDetalle;
                $SumInafectos = number_format($SumInafectos, 2, '.', '');
                $igvCod='2';
                
            } else {
                $igvCod='1';
            }
        }
    }
    $SumGrabado = $invtot - ($igv + $SumInafectos);
    $SumGrabado = $SumGrabado - $icbper_total;
    mysqli_query($conexion, "UPDATE venta set gravado = '$SumGrabado',inafecto = '$SumInafectos' where invnum = '$venta'");






        //=============================================================================
        // PARA CREAR UN TEXTO CON LOS MONTOS PARA FACTURACION (EFACTURANDO)

        // $fechaActual = date('Y-m-d');
       

        // $arr = explode("-",$fechaActual);
        // $str = implode("",$arr);

        // if ($tipdoc == 1) {
        //     $file_root = 'TXT_FACTURACION_ELECTRONICA/GENERACION/POR_PROCESAR/FACTURA/' . $str;
          
        // } else {
        //     $file_root = 'TXT_FACTURACION_ELECTRONICA/GENERACION/POR_PROCESAR/BOLETA/' . $str;

        // }


        
        // if (!file_exists($file_root)) {
        //     mkdir($file_root, 0777, true);
        // }



        // $sqlGenText = "SELECT ruc,razon_social,nombre_comercial,direccion,pais,departamento,provincia,distrito,ubigeo FROM emisor where id = '$sucursal'";
        // $resultGenText = mysqli_query($conexion, $sqlGenText);
        // if (mysqli_num_rows($resultGenText)) {
        //     while ($row = mysqli_fetch_array($resultGenText)) {
        //         $rucFac = $row['ruc'];
        //         $razon_social = $row['razon_social'];
        //         $nombre_comercial = $row['nombre_comercial'];
        //         $direccion = $row['direccion'];
        //         $pais = $row['pais'];
        //         $departamentoFac = $row['departamento'];
        //         $provinciaFac = $row['provincia'];
        //         $distritoFac = $row['distrito'];
        //         $ubigeo = $row['ubigeo'];
        //     }
        // }

        // if ($igv > 0) {
        //     $tipoAfectacion = 10;
        //     $codigoAfectacion = 1001;
        // } else {
        //     $tipoAfectacion = 30;
        //     $codigoAfectacion = 1002;
        // }

        // $sqlAfectacion = "SELECT descripcion,codigo_afectacion,nombre_afectacion,tipo_afectacion FROM tipo_afectacion where codigo = '$tipoAfectacion'";
        // $resultAfectacion = mysqli_query($conexion, $sqlAfectacion);
        // if (mysqli_num_rows($resultAfectacion)) {
        //     while ($row = mysqli_fetch_array($resultAfectacion)) {
        //         $descripcion = $row['descripcion'];
        //         $codigo_afectacion = $row['codigo_afectacion'];
        //         $nombre_afectacion = $row['nombre_afectacion'];
        //         $tipo_afectacion = $row['tipo_afectacion'];
        //     }
        // }


        // if ($tipdoc == 1) {
        //     $datoFactura = "FAC-" . "F" . $seriefac . "-" . zero_fill($correlativo, 8);
        //     $serieFactura = "F" . $seriefac . "-" . zero_fill($correlativo, 8);
        //     $documentoCliente = $ruccli;
        //     $tipoDocumentoCliente = 6;
        //     $tipoDocumentoFactura = 01;
        // }
        // if ($tipdoc == 2) {
        //     $datoFactura = "BOL-" . "B" . $seriebol . "-" . zero_fill($correlativo, 8);
        //     $serieFactura = "B" . $seriebol . "-" . zero_fill($correlativo, 8);
        //     $documentoCliente = $dnicli;
        //     $tipoDocumentoCliente = 1;
        //     $tipoDocumentoFactura = 03;
        // }

        // $moneda = 'PEN';

        // $detalle = array();


        // $porcentajeigv = 0;
        // $igvtabla = mysqli_query($conexion, "SELECT porcent FROM datagen ORDER BY cdatagen DESC LIMIT 1");
        // while ($rowigvtabla = mysqli_fetch_array($igvtabla, MYSQLI_ASSOC)) {
        //     $porcentajeigv = (float)$rowigvtabla['porcent'];
        //     $porcentajeigv = $porcentajeigv / 100;
        // }

        // $op_gravadas = 0.00;
        // $op_exoneradas = 0.00;
        // $op_inafectas = 0.00;
        // // $igv = 0;
        // $total = 0;
        // $i = 0;



        // $sqldetalle_venta = "SELECT * FROM detalle_venta where invnum = '$venta'";
        // $resultdetalle_venta = mysqli_query($conexion, $sqldetalle_venta);

        // $k = 0;
        // // foreach ($detalleVenta as $k => $v) {
        // while ($v = mysqli_fetch_array($resultdetalle_venta, MYSQLI_ASSOC)) {
        //     $k++;

        //     $porcentaje = $porcentajeigv;


        //     $codigoProducto = $v['codpro'];
        //     $sqlproducto = "SELECT * FROM producto where codpro = '$codigoProducto'";
        //     $resultproducto = mysqli_query($conexion, $sqlproducto);
        //     if (mysqli_num_rows($resultproducto)) {
        //         $producto = mysqli_fetch_array($resultproducto);
        //     }

        //     if ($producto['igv'] == 1) {
        //         $productoCodigoafectacion = '10'; //GRAVADO - OPERACION ONEROSA
        //         // $codigoTipoPrecioVenta = '1';

        //     } else {
        //         $porcentaje = 0;
        //         $productoCodigoafectacion = '20'; //EXONERADO - OPERACION ONEROSA
        //         // $codigoTipoPrecioVenta = '2';
        //     }


        //     $sqlafectacion = "SELECT * FROM tipo_afectacion where codigo = '$productoCodigoafectacion'";
        //     $resultafectacion = mysqli_query($conexion, $sqlafectacion);
        //     if (mysqli_num_rows($resultafectacion)) {
        //         $afectacion = mysqli_fetch_array($resultafectacion);
        //     }

        //     $factor_porcentaje = 1;

        //     $i++;
        //     $codproducto = $producto['codpro'];
        //     $unidad = 'NIU';
        //     $descripcion = remplazar_string(htmlspecialchars($producto['desprod']));
        //     $cantidad = $v['canpro'];
        //     $valunitario = ($v['pripro']);
        //     $valor_total = $valunitario / (1 + $porcentaje);
        //     $pcntjeigv = $porcentaje;
        //     $valventa = ($v['prisal']);
        //     $igv_detalle = $valunitario - $valor_total;
        //     $valunitarioPor = $valventa  / (1 + $porcentaje);

        //     $baseigv = $valventa;
        //     $valigv = $baseigv * $factor_porcentaje;
        //     $totalimpuesto = $valigv;
        //     $preciounitario = $v['prisal'];
        //     $montoBase = $valunitario  / (1 + $porcentaje);
        //     $montoBaseUnitario = $valventa  / (1 + $porcentaje);



        //     if ($producto['igv'] == 1) {
        //         $montobaseigv = $montoBase * $pcntjeigv;
        //         $montobaseunitarioigv = $montoBaseUnitario * $pcntjeigv;
        //         $precioUnitarioConIgv = $valventa * $pcntjeigv;
        //         $precioTotalConIgv = ($v['pripro'] * $pcntjeigv);
        //         $codigoTipoPrecioVenta = '01';
        //         $preciounitarioSuma = $valventa + $montobaseunitarioigv;
        //         $op11 = ($v['prisal'] * $v['canpro']);
        //         $op1 = $op11 / (1 + $porcentaje);

        //         $op2 = $valunitario;
        //     } else {
        //         $preciounitarioSuma = '0.00';
        //         $codigoTipoPrecioVenta = '02';
        //         $op1 = '0.00';
        //         $op2 = '0.00';
        //         $montobaseigv = '0.00';
        //     }


        //     $op = ($v['prisal'] * $v['canpro'] * $factor_porcentaje);
        //     $itemx = array(
        //         'item'                     => $k,
        //         'codigo'                => trim($codproducto),
        //         'descripcion'            => trim($descripcion),
        //         // 'cantidad'				=> number_format($cantidad, 2, '.', ''),
        //         'cantidad'                => $cantidad,
        //         'valor_unitario'        => number_format($valunitarioPor, 4, '.', ''),
        //         'precio_unitario'        => number_format($valventa, 2, '.', ''),
        //         'tipo_precio'            => '01', //ya incluye igv
        //         'igv'                    => number_format($igv_detalle, 2, '.', ''),
        //         'porcentaje_igv'        => number_format($pcntjeigv * 100, 2, '.', ''),
        //         'valor_total'            => number_format($valor_total, 2, '.', ''),
        //         'importe_total'            => number_format($op, 2, '.', ''),
        //         'unidad'                => $unidad, //unidad,
        //         'codigo_afectacion_alt'    => $productoCodigoafectacion,
        //         'codigo_afectacion'        => $afectacion['codigo_afectacion'],
        //         'nombre_afectacion'        => $afectacion['nombre_afectacion'],
        //         'tipo_afectacion'        => $afectacion['tipo_afectacion'],
        //         // 'calculoIgvPreuni'  	=> number_format($precioUnitarioConIgv, 2, '.', ''),
        //         'sumaPrecioUnitario'    => number_format($preciounitarioSuma, 2, '.', ''),
        //         'tipoPrecio'            => $codigoTipoPrecioVenta,
        //         'importe_total_sin_igv' => number_format($op1, 2, '.', ''),
        //         'importe_total_con_igv' => number_format($op2, 2, '.', ''),
        //         'total_igv'             => number_format($precioTotalConIgv, 2, '.', ''),
        //         'montobaseigv'             => number_format($montobaseigv, 2, '.', ''),





        //     );

        //     $itemx;

        //     $detalle[] = $itemx;
        // }






        // if ($tipdoc <> 4) {

        //     $descfile = "GENERAR-" . $datoFactura  . ".txt";

        //     if ($tipdoc == 1) {

        //         $generaTxt = fopen("TXT_FACTURACION_ELECTRONICA/GENERACION/POR_PROCESAR/FACTURA/$str/$descfile", "w") or die("Problemas al crear el archivo");
        //     } else {

        //         $generaTxt = fopen("TXT_FACTURACION_ELECTRONICA/GENERACION/POR_PROCESAR/BOLETA/$str/$descfile", "w") or die("Problemas al crear el archivo");
        //     }


        //     $emisorFact =   "DDE" . "|" . $razon_social . "|" . $nombre_comercial . "|" . $ubigeo . "|" . $direccion . "|" . $departamentoFac . "|" .
        //         $provinciaFac .  "|" . $distritoFac . "|" . $pais . "|" . $rucFac . "|" . zero_fill($sucursal, 4);
        //     fwrite($generaTxt, $emisorFact);
        //     fputs($generaTxt, "\n");

        //     $receptorFact = "DDR" . "|" . $documentoCliente . "|" . $tipoDocumentoCliente . "|" . $descli . "|" . $dircli;

        //     fwrite($generaTxt, $receptorFact);
        //     fputs($generaTxt, "\n");


        //     $cabezeraFact = "DFC" . "|" . $invfecS . "|" . $tipoDocumentoFactura . "|" . $serieFactura . "|" . "1001" . "|" . $SumGrabado . "|" .
        //         "1002" . "|" . number_format($SumInafectos, 2, '.', '') . "|" . "1003" . "|" . "0.00" . "|" . $igv . "|" . $codigo_afectacion . "|" .
        //         $nombre_afectacion . "|" . $tipo_afectacion . "|" . "0.00" . "|" . "2000" . "|" . "ISC" . "|" . "EXC" . "|" . $codigoAfectacion . "|" .
        //         "0.00" . "|" . $invtot . "|" . $moneda . "|" . "1000" . "|" . "MONTO EN LETRAS" . "|" . "2001" . "|" . "0.00" . "|" . "0.00" . "|" . "0.00"
        //         . "|" .
        //         $codigoAfectacion . "|" . "0.00" . "|" . "0.00" . "|" . "0.00"  . "|" . convertNumberToWord1($invtot, $moneda);

        //     fwrite($generaTxt, $cabezeraFact);
        //     fputs($generaTxt, "\n");

        //     foreach ($detalle as $k => $v) {

        //         $datosProductos = "DFD" . "|" . $v['item'] . "|" .  $v['codigo'] . "|" . $v['sumaPrecioUnitario'] . "|" .  $v['tipoPrecio'] . "|" . $v['importe_total_sin_igv'] . "|" . $v['unidad'] . "|" .  $v['cantidad'] . "|" .
        //             $v['descripcion'] . "|" . $v['precio_unitario'] . "|" .  $v['importe_total_con_igv'] . "|" .  $v['tipoPrecio'] . "|" .  $v['montobaseigv']  . "|" .  $v['codigo_afectacion_alt'] . "|" .
        //             $codigo_afectacion . "|" . $nombre_afectacion . "|" . $tipo_afectacion  . "|" .  "0.00" . "|" . "01" . "|" . "2000" . "|" . "ISC" . "|" . "EXC" . "|" . "UND"  . "|" .  "0.00";


        //         fwrite($generaTxt,  $datosProductos);
        //         fputs($generaTxt, "\n");
        //     }



        //     fclose($generaTxt);
        // }

     

        //=============================================================================
        //ENVIO DIRECTO DE FACTURA
        $sqlemisor = "SELECT * FROM emisor where id = $sucursal";
        $resultemisor = mysqli_query($conexion, $sqlemisor);
        if (mysqli_num_rows($resultemisor)) {
            $emisor = mysqli_fetch_array($resultemisor);
        }
        if ($emisor['send_invoice'] == 'automatic') {
            FnGenerateXmlAndSend($venta, $conexion);
        }
    ?>



    <body onload="imprimir()">


        <?php
        require_once('bodyimprime.php');
        ?>

    </body>

</html>