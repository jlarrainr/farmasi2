<?php
include('../session_user.php');
require_once('../../conexion.php');
require_once('../../titulo_sist.php');
require_once('../../convertfecha.php'); //CONEXION A BASE DE DATOS
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php 

    $fecha = DateTime::createFromFormat('d/m/Y', $_REQUEST["date1"]);
    $fechaIniciod = $fecha->format('Y-m-d');

    $fecha2 = DateTime::createFromFormat('d/m/Y', $_REQUEST["date2"]);
    $fechaFind = $fecha2->format('Y-m-d');

?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?php echo $desemp ?></title>
    <link href="css/style1.css" rel="stylesheet" type="text/css" />
    <link href="css/tablas.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .Estilo1 {
            color: #ffffff;
            font-weight: bold;
        }

        .Estilo2 {
            color: #ff0000;
            font-weight: bold;
        }

        .Estilo3 {
            font-style: italic;
            font-weight: bold;
            font-size: 2em;
            /* font-color: #ffffff; */
            font-family: 'Helvetica', 'Verdana', 'Monaco', sans-serif;
        }

        input {
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            background-color: white;
            background-position: 3px 3px;
            background-repeat: no-repeat;
            padding: 2px 1px 2px 5px;

        }


        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;

        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 3px;

        }

        #customers td a {
            color: #4d9ff7;
            font-weight: bold;
            font-size: 15px;
            text-decoration: none;

        }

        #customers #total {

            text-align: center;
            background-color: #9ebcc1;
            color: white;
            font-size: 14px;
            font-weight: 900;
        }

        #customers #total2 {

            text-align: center;
            background-color: #ff6c52;
            color: white;
            font-size: 14px;
            font-weight: 900;
        }

        #customers tr:nth-child(even) {
            background-color: #f0ecec;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {

            text-align: center;
            background-color: #50ADEA;
            color: white;
            font-size: 12px;
            font-weight: 900;
        }
    </style>
</head>
<?php
//    require_once("../../funciones/functions.php"); //DESHABILITA TECLAS
require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUME
$sql = "SELECT nomusu FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $user = $row['nomusu'];
    }
}
$hour = date('G') - 5;
$date = CalculaFechaHora($hour);
$hour = CalculaHora($hour);
$min = date('i');
if ($hour <= 12) {
    $hor = "am";
} else {
    $hor = "pm";
}
$nro = $_REQUEST['nro'];
$val = $_REQUEST['val'];
$tipo = $_REQUEST['tipo'];
$local = $_REQUEST['local'];
$ccc = explode(",", $nro);
$contador = count($ccc);
$rr = 0;

////////////////////////////////////////////////////////

function limpia_espacios($cadena)
{
    $cadena = str_replace(' ', '', $cadena);
    return $cadena;
}

function redondear_dos_decimal($valor)
{
    $float_redondeado = round($valor * 100) / 100;
    return $float_redondeado;
}
?>

<body>
    <table width="100%" border="0" align="center">
        <tr>
            <td>
                <table width="100%" border="0">
                    <tr>
                        <td width="271"><strong><?php echo $desemp ?></strong></td>
                        <td width="358" style="font-size:14px;">
                            <div align="center"><strong>REPORTE DE PRODUCTOS INCENTIVADOS</strong></div>
                        </td>
                        <td width="271">
                            <div align="right"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div>
                        </td>
                    </tr>

                    <tr>
                        <td width="271"><strong></strong></td>
                        <?php if ($val == 1) { ?>

                            <td width="358">
                                <div align="center">NRO DE INCENTIVO CONSULTADO: <?php echo $nro ?></div>
                            </td>
                        <?php } else { ?>
                            <td width="500">
                                <div align="center" class="Estilo3">LISTA DE PRODUCTOS INCENTIVADOS</div>
                            </td>
                        <?php } ?>


                        <td width="271">
                            <div align="right">USUARIO: <span class="text_combo_select"><?php echo $user ?></span></div>
                        </td>
                    </tr>
                </table>

                <div align="center"><img src="../../images/line2.png" width="100%" height="4" /></div>
            </td>
        </tr>
    </table>
    
    <?php 

    if($val == 1)
    {
        echo '<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>';
        


            $arraySurcursal = array();

            $sqlSurcursal = "SELECT xcompa.codloc, xcompa.nombre FROM xcompa";
            $resultSucursal = mysqli_query($conexion, $sqlSurcursal);

            if (mysqli_num_rows($resultSucursal)) 
            {
                while ($rowSucursal = mysqli_fetch_array($resultSucursal)) 
                {
                    $arraySurcursal[$rowSucursal["codloc"]] = $rowSucursal["nombre"];
                }
            }

            $arrayUsuario = array();
            $sqlUsuario = "SELECT usuario.usecod, usuario.nomusu FROM usuario";
            $resultUsuario = mysqli_query($conexion, $sqlUsuario);

            if (mysqli_num_rows($resultUsuario)) 
            {
                while ($rowUsuario = mysqli_fetch_array($resultUsuario)) 
                {
                    $arrayUsuario[$rowUsuario["usecod"]] = $rowUsuario["nomusu"];
                }
            }

            $arrayIncentivos = array();
            
            $sqlIncentivo = "SELECT incentivadodet.codpro, incentivadodet.canprocaj, incentivadodet.canprounid, 
            incentivadodet.factor AS factorIncentivodet, incentivadodet.pripro AS priproIncentivodet,
            detalle_venta.factor, detalle_venta.canpro, detalle_venta.pripro, detalle_venta.usecod, detalle_venta.invfec, detalle_venta.fraccion,
            venta.nrofactura, venta.nrovent, venta.sucursal,
            producto.desprod, producto.codmar,
            titultabladet.destab
            FROM incentivadodet
            INNER JOIN incentivado ON incentivadodet.invnum = incentivado.invnum
            INNER JOIN detalle_venta ON incentivadodet.codpro = detalle_venta.codpro
            INNER JOIN venta ON detalle_venta.invnum = venta.invnum
            INNER JOIN producto ON incentivadodet.codpro = producto.codpro
            INNER JOIN titultabladet ON producto.codmar = titultabladet.codtab
            WHERE venta.val_habil = 0 AND venta.estado = 0 AND incentivado.invnum = '$nro' AND incentivado.esta_desa = 0 
            AND (detalle_venta.invfec >= incentivado.dateini) AND (detalle_venta.invfec <= incentivado.datefin)
            AND (detalle_venta.invfec BETWEEN '$fechaIniciod' AND '$fechaFind')";

            if($local != "all")
            {
                $sqlIncentivo .= " AND venta.sucursal = '$local'";
            }   

            if($tipo == 1)
            {
                $sqlIncentivo .= " ORDER BY incentivadodet.codpro";
            }
            else if($tipo == 5)
            {
                $sqlIncentivo .= "  ORDER BY venta.usecod, incentivadodet.codpro";
            }
            else if($tipo == 6)
            {
                $sqlIncentivo .= "  ORDER BY venta.sucursal, incentivadodet.codpro";
            }
            else if($tipo == 7)
            {
                $sqlIncentivo .= "  ORDER BY venta.sucursal, detalle_venta.usecod, venta.nrovent, incentivadodet.codpro";
            }
            else
            {
                $sqlIncentivo .= " ORDER BY venta.sucursal,venta.nrovent, incentivadodet.codpro";
            }

            //echo $sqlIncentivo;

            $resultIncentivo = mysqli_query($conexion, $sqlIncentivo);
            if (mysqli_num_rows($resultIncentivo)) 
            {
                while ($rowIncentivo = mysqli_fetch_array($resultIncentivo)) 
                {
                    $obj = new stdClass;

                    $obj->codpro = $rowIncentivo["codpro"];
                    $obj->canprocaj = $rowIncentivo["canprocaj"];
                    $obj->canprounid = $rowIncentivo["canprounid"];
                    $obj->factorIncentivodet = $rowIncentivo["factorIncentivodet"];
                    $obj->priproIncentivodet = $rowIncentivo["priproIncentivodet"];
                    $obj->factor = $rowIncentivo["factor"];
                    $obj->canpro = $rowIncentivo["canpro"];
                    $obj->pripro = $rowIncentivo["pripro"];
                    $obj->usecod = $rowIncentivo["usecod"];
                    $obj->invfec = $rowIncentivo["invfec"];
                    $obj->fraccion = $rowIncentivo["fraccion"];
                    $obj->nrofactura = $rowIncentivo["nrofactura"];
                    $obj->nrovent = $rowIncentivo["nrovent"];
                    $obj->sucursal = $rowIncentivo["sucursal"];
                    $obj->desprod = $rowIncentivo["desprod"];
                    $obj->codmar = $rowIncentivo["codmar"];
                    $obj->destab = $rowIncentivo["destab"];

                    // T unidad F caja
                    $obj->cantidadTexto = (($obj->fraccion == "T") ? "UNID " : "CAJA ") . $obj->canpro;

                    $obj->pincentivoCaja = ($obj->canprocaj > 0) ? ($obj->priproIncentivodet/$obj->canprocaj) : ($obj->priproIncentivodet/$obj->canprounid) * $obj->factor ; 
                    $obj->pincentivoUnidad = ($obj->canprocaj > 0) ? ($obj->priproIncentivodet/$obj->canprocaj) / $obj->factor : ($obj->priproIncentivodet/$obj->canprounid) ;

                    if($obj->fraccion == "T")
                    {
                        $obj->cantidadTexto = "UNID ". $obj->canpro;
                        $obj->incentivoPagar = $obj->pincentivoUnidad * $obj->canpro;
                    }
                    else 
                    {
                        $obj->cantidadTexto = "CAJA ". $obj->canpro;
                        $obj->incentivoPagar = $obj->pincentivoCaja * $obj->canpro;
                    }

                    

                    $obj->cantidadIncentivado = ($obj->canprocaj > 0) ? $obj->canprocaj . " CAJA"  : $obj->canprounid . " UNID";

                    array_push($arrayIncentivos,$obj);
                }

                if($tipo == 1)
                {

                    echo '<table width="100%" border="0" align="center" id="customers">
                            <tr>
                                <th><strong>LOCAL</strong></th>
                                <th>
                                    <div align="center"><strong>N&ordm; VENTA</strong></div>
                                </th>
                                <th>
                                    <div align="center"><strong>N&ordm; DOCUMENTO</strong></div>
                                </th>
                                <th>
                                    <div align="center"><strong>FECHA</strong></div>
                                </th>

                                <th>
                                    <div align="center"><strong>CODIGO PRODUCTO</strong></div>
                                </th>
                                <th>
                                    <div align="left"><strong>PRODUCTO</strong></div>
                                </th>
                                <th>
                                    <div align="center"><strong>MARCA</strong></div>
                                </th>
                                <th>
                                    <div align="center"><strong>FACTOR</strong></div>
                                </th>
                                <th width="350">
                                    <div align="left"><strong>VENDEDOR</strong></div>
                                </th>
                                <th>
                                    <div align="CENTER"><strong>CANTIDAD VENDIDA</strong></div>
                                </th>
                                <th>
                                    <div align="CENTER"><strong>MONTO VENTA</strong></div>
                                </th>
                                <th>
                                    <div align="right"><strong>MONTO INCENTIVO</strong></div>
                                </th>
                            </tr>';

                    $sumatoria = 0;

                    foreach($arrayIncentivos as $key=>$value)
                    {
                        echo    '<tr>
                                    <td>
                                        <div align="">' . $arraySurcursal[$value->sucursal] . '</div>
                                    </td>
                                    <td>
                                        <div align="">' . $value->nrovent . '</div>
                                    </td>
                                    <td>
                                        <div align="">' . $value->nrofactura . '</div>
                                    </td>
                                    <td>
                                        <div align="">' . $value->invfec . '</div>
                                    </td>
                                    <td>
                                        <div align="">' . $value->codpro . '</div>
                                    </td>
                                    <td>
                                        <div align="">' . $value->desprod . '</div>
                                    </td>
                                    <td>
                                        <div align="">' . $value->destab . '</div>
                                    </td>
                                    <td>
                                        <div align="">' . $value->factor . '</div>
                                    </td>
                                    <td>
                                        <div align="">' . $arrayUsuario[$value->usecod] . '</div>
                                    </td>
                                    <td>
                                        <div align="">' . $value->cantidadTexto . '</div>
                                    </td>
                                    <td>
                                        <div align="">' . number_format($value->pripro, 2, '.', '') . '</div>
                                    </td>
                                    <td>
                                        <div align="">' . number_format($value->incentivoPagar, 2, '.', '') . '</div>
                                    </td>
                                </tr>';

                                $sumatoria += $value->incentivoPagar;
                    }

                        echo '<tr id="total">                 
                            <td height="25" colspan="11" width="76">
                                <div align="center"><strong>TOTAL</strong></div>
                            </td>
                            <td width="84">
                                <div align="right">' . number_format($sumatoria, 2, '.', '') . '</div>
                            </td>
                        </tr>';

                    echo '</table>';
                }
                else if($tipo == 2)
                {
                    $arrayResumidoProducto = array();

                    foreach($arrayIncentivos as $key=>$value)
                    {

                        if(!array_key_exists($value->codpro, $arrayResumidoProducto))
                        {
                            $objUnico = new stdClass;
                            $objUnico->sucursal = ($local == "all") ? 'TODOS' : $arraySurcursal[$value->sucursal];
                            //$objUnico->codpro = $value->codpro;
                            $objUnico->producto = $value->desprod;
                            $objUnico->marca = $value->destab;
                            $objUnico->factor = $value->factor;
                            $objUnico->cantidad = $value->canpro;
                            $objUnico->montov = $value->pripro;
                            $objUnico->montoi = $value->incentivoPagar;

                            $arrayResumidoProducto[$value->codpro] = $objUnico;

                            //array_push($arrayResumidoProducto,$objUnico);
                        }
                        else 
                        {
                            $arrayResumidoProducto[$value->codpro]->montov+= $value->pripro;
                            $arrayResumidoProducto[$value->codpro]->montoi+= $value->incentivoPagar;
                        }

                    }

                    echo '<table width="100%" border="0" align="center" id="customers">
                            <tr>
                                <th width="87" align="center"><strong>SUCURSAL</strong></th>
                                <th width="87" align="center"><strong>CODIGO PRODUCTO</strong></th>
                                <th width="375">
                                    <div align="left"><strong>PRODUCTO</strong></div>
                                </th>
                                <th width="177">
                                    <div align="center"><strong>MARCA</strong></div>
                                </th>
                                <th width="177">
                                    <div align="center"><strong>FACTOR</strong></div>
                                </th>
                                <th width="87">
                                    <div align="center"><strong>CANTIDAD VENDIDA</strong></div>
                                </th>
                                <th width="87">
                                    <div align="center"><strong>MONTO VEND</strong></div>
                                </th>
                                <th width="87">
                                    <div align="right"><strong>MONTO INCENTIVO</strong></div>
                                </th>
                            </tr>';

                        $sumatoria = 0;

                        foreach($arrayResumidoProducto as $key=>$value)
                        {
                            echo    '<tr>
                                        <td>
                                            <div align="">' . $value->sucursal . '</div>
                                        </td>
                                        <td>
                                            <div align="">' . $key . '</div>
                                        </td>
                                        <td>
                                            <div align="">' . $value->producto . '</div>
                                        </td>
                                        <td>
                                            <div align="">' . $value->marca . '</div>
                                        </td>
                                        <td>
                                            <div align="">' . $value->factor . '</div>
                                        </td>
                                        <td>
                                            <div align="">' . $value->cantidad . '</div>
                                        </td>
                                        <td>
                                            <div align="">' . number_format($value->montov, 2, '.', '') . '</div>
                                        </td>
                                        <td>
                                            <div align="">' . number_format($value->montoi, 2, '.', '') . '</div>
                                        </td>
                                    </tr>';

                                    $sumatoria += $value->montoi;
                        }

                        echo '<tr id="total">                 
                            <td height="25" colspan="7" width="76">
                                <div align="center"><strong>TOTAL</strong></div>
                            </td>
                            <td width="84">
                                <div align="right">' . number_format($sumatoria, 2, '.', '') . '</div>
                            </td>
                        </tr>';

                        //print_r(json_encode($arrayResumidoProducto));

                    echo '</table>';
                }
                else if($tipo == 3)
                {
                    $arrayResumidoVendedor = array();

                    foreach($arrayIncentivos as $key=>$value)
                    {

                        if(!array_key_exists($value->usecod, $arrayResumidoVendedor))
                        {
                            $objUnico = new stdClass;
                            $objUnico->sucursal = ($local == "all") ? 'TODOS' : $arraySurcursal[$value->sucursal];

                            $objUnico->montov = $value->pripro;
                            $objUnico->montoi = $value->incentivoPagar;

                            $arrayResumidoVendedor[$value->usecod] = $objUnico;
                        }
                        else 
                        {
                            $arrayResumidoVendedor[$value->usecod]->montov+= $value->pripro;
                            $arrayResumidoVendedor[$value->usecod]->montoi+= $value->incentivoPagar;
                        }
                    }

                    echo '<table width="100%" border="0" align="center" id="customers">
                        <tr>
                            <th align="center"><strong>SUCURSAL</strong></th>
                            <th align="center"><strong>CODIGO VENDEDOR</strong></th>
                            <th width="520">
                                <div align="left"><strong>VENDEDOR</strong></div>
                            </th>
                            <th>
                                <div align="center"><strong>P. VENTA</strong></div>
                            </th>
                            <th>
                                <div align="right"><strong>MONTO INCENT</strong></div>
                            </th>
                        </tr>';

                        $sumatoria = 0;

                        foreach($arrayResumidoVendedor as $key=>$value)
                        {
                            echo    '<tr>
                                        <td>
                                            <div align="">' . $value->sucursal . '</div>
                                        </td>
                                        <td>
                                            <div align="">' . $key . '</div>
                                        </td>
                                        <td>
                                            <div align="">' . $arrayUsuario[$key] . '</div>
                                        </td>
                                        <td>
                                            <div align="">' . number_format($value->montov, 2, '.', '') . '</div>
                                        </td>
                                        <td>
                                            <div align="">' . number_format($value->montoi, 2, '.', '') . '</div>
                                        </td>
                                    </tr>';

                                    $sumatoria += $value->montoi;
                        }

                        echo '<tr id="total">                 
                            <td height="25" colspan="4" width="76">
                                <div align="center"><strong>TOTAL</strong></div>
                            </td>
                            <td width="84">
                                <div align="right">' . number_format($sumatoria, 2, '.', '') . '</div>
                            </td>
                        </tr>';

                    echo '</table>';
                }
                else if($tipo == 4)
                {
                    $arrayResumidoSucursal = array();

                    foreach($arrayIncentivos as $key=>$value)
                    {

                        if(!array_key_exists($value->sucursal, $arrayResumidoSucursal))
                        {
                            $objUnico = new stdClass;

                            $objUnico->montov = $value->pripro;
                            $objUnico->montoi = $value->incentivoPagar;

                            $arrayResumidoSucursal[$value->sucursal] = $objUnico;
                        }
                        else 
                        {
                            $arrayResumidoSucursal[$value->sucursal]->montov+= $value->pripro;
                            $arrayResumidoSucursal[$value->sucursal]->montoi+= $value->incentivoPagar;
                        }
                    }

                    echo '<table width="100%" border="0" align="center" id="customers">
                            <tr>
                                <th width="92">
                                    <div align="left"><strong>SUCURSAL</strong></div>
                                </th>
                                <th width="91">
                                    <div align="right"><strong>MONTO VENTAS</strong></div>
                                </th>
                                <th width="91">
                                    <div align="right"><strong>MONTO INCENT</strong></div>
                                </th>
                            </tr>';

                        $sumatoria = 0;

                        foreach($arrayResumidoSucursal as $key=>$value)
                        {
                            echo    '<tr>
                                        <td>
                                            <div align="">' . $arraySurcursal[$key] . '</div>
                                        </td>
                                        <td>
                                            <div align="">' . number_format($value->montov, 2, '.', '') . '</div>
                                        </td>
                                        <td>
                                            <div align="">' . number_format($value->montoi, 2, '.', '') . '</div>
                                        </td>
                                    </tr>';

                                    $sumatoria += $value->montoi;
                        }

                        echo '<tr id="total">                 
                            <td height="25" colspan="2" width="76">
                                <div align="center"><strong>TOTAL</strong></div>
                            </td>
                            <td width="84">
                                <div align="right">' . number_format($sumatoria, 2, '.', '') . '</div>
                            </td>
                        </tr>';

                    echo '</table>';

                }
                else if($tipo == 5)
                {
                    echo '<table width="100%" border="0" align="center" id="customers">
                            <tr>
                                <th><strong>N</strong></th>
                                <th><strong>VENDEDOR</strong></th>
                                <th>
                                    <div align="left"><strong>PRODUCTO</strong></div>
                                </th>
                                <th>
                                    <div align="center"><strong>MARCA</strong></div>
                                </th>
                                <th>
                                    <div align="center"><strong>FACTOR</strong></div>
                                </th>
                                <th>
                                    <div align="center"><strong>CANTIDAD VENDIDA</strong></div>
                                </th>
                                <th>
                                    <div align="center"><strong> X CANTIDAD INCENTIVADA</strong></div>
                                </th>
                                <th>
                                    <div align="center"><strong> X PRECIO INCENTIVADA</strong></div>
                                </th>
                                <th>
                                    <div align="center"><strong> X PRECIO INCENTIVADA UNIDAD</strong></div>
                                </th>
                                <th>
                                    <div align="right"><strong>MONTO INCENT</strong></div>
                                </th>
                            </tr>';

                        $sumatoria = 0;
                        $contador = 1;
                        $sumatoriaVendedor = 0;
                        $usecodCheck = $arrayIncentivos[1]->usecod;

                        foreach($arrayIncentivos as $key=>$value)
                        {

                            if($usecodCheck != $value->usecod)
                            {
                                echo '<tr id="total">                 
                                    <td height="25" colspan="9" width="76">
                                        <div align="center"><strong>TOTAL</strong></div>
                                    </td>
                                    <td width="84">
                                        <div align="right">' . number_format($sumatoriaVendedor, 2, '.', '') . '</div>
                                    </td>
                                </tr>';

                                $sumatoriaVendedor = 0;

                                $usecodCheck = $value->usecod;
                            }
                            

                            echo    '<tr>
                                        <td>
                                            <div align="">' . $contador . '</div>
                                        </td>
                                        <td>
                                            <div align="">' . $arrayUsuario[$value->usecod] . '</div>
                                        </td>
                                        <td>
                                            <div align="">' . $value->desprod . '</div>
                                        </td>
                                        <td>
                                            <div align="">' . $value->destab . '</div>
                                        </td>
                                        <td>
                                            <div align="">' . $value->factor . '</div>
                                        </td>
                                        <td>
                                            <div align="">' . $value->cantidadTexto . '</div>
                                        </td>
                                        <td>
                                            <div align="">' . $value->cantidadIncentivado . '</div>
                                        </td>
                                        <td>
                                            <div align="">' . number_format($value->pincentivoCaja, 2, '.', '') . '</div>
                                        </td>
                                        <td>
                                            <div align="">' . number_format($value->pincentivoUnidad, 2, '.', '') . '</div> 
                                        </td>
                                        <td>
                                            <div align="">' . number_format($value->incentivoPagar, 2, '.', '') . '</div>
                                        </td>
                                    </tr>';

                                    
                                    $sumatoriaVendedor+= $value->incentivoPagar;
                                    //($value->canprocaj > 0) ? $value->canprocaj . ' F' : $value->canprounid $value->canprocaj . ' T'
        
                                    $sumatoria += $value->incentivoPagar;
                                    $contador++;
                        }

                        echo '<tr id="total">                 
                            <td height="25" colspan="9" width="76">
                                <div align="center"><strong>TOTAL</strong></div>
                            </td>
                            <td width="84">
                                <div align="right">' . number_format($sumatoriaVendedor, 2, '.', '') . '</div>
                            </td>
                        </tr>';

                        echo '<tr id="total2">                 
                            <td height="25" colspan="9" width="76">
                                <div align="center"><strong>TOTAL FINAL</strong></div>
                            </td>
                            <td width="84">
                                <div align="right">' . number_format($sumatoria, 2, '.', '') . '</div>
                            </td>
                        </tr>';

        
                            

                    echo '</table>';

                }
                else if($tipo == 6)
                {
                    echo '<table width="100%" border="0" align="center" id="customers">
                            <tr>
                                <th align="center"><strong>SUCURSAL</strong></th>
                                
                                <th width="520">
                                    <div align="left"><strong>VENDEDOR</strong></div>
                                </th>
                                <th>
                                    <div align="center"><strong>PRODUCTO</strong></div>
                                </th>
                                <th>
                                    <div align="center"><strong>MARCA</strong></div>
                                </th>
                                <th>
                                    <div align="center"><strong>FACTOR</strong></div>
                                </th>
                                <th>
                                    <div align="center"><strong>CANTIDAD VENDIDA</strong></div>
                                </th>
                                <th>
                                    <div align="right"><strong>MONTO INCENT</strong></div>
                                </th>
                            </tr>';

                            $sumatoria = 0;

                            foreach($arrayIncentivos as $key=>$value)
                            {
                                echo    '<tr>
                                            <td>
                                                <div align="">' . $arraySurcursal[$value->sucursal] . '</div>
                                            </td>
                                            <td>
                                                <div align="">' . $arrayUsuario[$value->usecod] . '</div>
                                            </td>
                                            <td>
                                                <div align="">' . $value->desprod . '</div>
                                            </td>
                                            <td>
                                                <div align="">' . $value->destab . '</div>
                                            </td>
                                            <td>
                                                <div align="">' . $value->factor . '</div>
                                            </td>
                                            <td>
                                                <div align="">' . $value->cantidadTexto . '</div>
                                            </td>
                                            <td>
                                                <div align="">' . number_format($value->incentivoPagar, 2, '.', '') . '</div>
                                            </td>
                                        </tr>';
            
                                        $sumatoria += $value->incentivoPagar;
                            }
            
                                echo '<tr id="total">                 
                                    <td height="25" colspan="6" width="76">
                                        <div align="center"><strong>TOTAL</strong></div>
                                    </td>
                                    <td width="84">
                                        <div align="right">' . number_format($sumatoria, 2, '.', '') . '</div>
                                    </td>
                                </tr>';

                    echo '</table>';
                }
                else if($tipo == 7)
                {

                    echo '<table width="100%" border="0" align="center" id="customers">
                            <tr>
                                <th width="96"><strong>SUCURSAL</strong></th>
                                <th width="151">
                                    <div align="left"><strong>VENDEDOR</strong></div>
                                </th>
                                <th width="76">
                                    <div align="CENTER"><strong>NRO VENTA</strong></div>
                                </th>
                                <th width="418">
                                    <div align="left"><strong>PRODUCTO</strong></div>
                                </th>
                                <th width="418">
                                    <div align="CENTER"><strong>MARCA</strong></div>
                                </th>
                                <th width="418">
                                    <div align="CENTER"><strong>FACTOR</strong></div>
                                </th>
                                <th width="72">
                                    <div align="CENTER"><strong>CANTIDAD VENDIDA</strong></div>
                                </th>
                                <th width="87">
                                    <div align="right"><strong>MONTO INCENTIVO</strong></div>
                                </th>
                            </tr>';

                        $sumatoria = 0;

                        foreach($arrayIncentivos as $key=>$value)
                        {
                            echo    '<tr>
                                        <td>
                                            <div align="">' . $arraySurcursal[$value->sucursal] . '</div>
                                        </td>
                                        <td>
                                            <div align="">' . $arrayUsuario[$value->usecod] . '</div>
                                        </td>
                                        <td>
                                            <div align="">' . $value->nrovent . '</div>
                                        </td>
                                        <td>
                                            <div align="">' . $value->desprod . '</div>
                                        </td>
                                        <td>
                                            <div align="">' . $value->destab . '</div>
                                        </td>
                                        <td>
                                            <div align="">' . $value->factor . '</div>
                                        </td>
                                        <td>
                                            <div align="">' . $value->cantidadTexto . '</div>
                                        </td>
                                        <td>
                                            <div align="">' . number_format($value->incentivoPagar, 2, '.', '') . '</div>
                                        </td>
                                    </tr>';
        
                                    $sumatoria += $value->incentivoPagar;
                        }
        
                            echo '<tr id="total">                 
                                <td height="25" colspan="7" width="76">
                                    <div align="center"><strong>TOTAL</strong></div>
                                </td>
                                <td width="84">
                                    <div align="right">' . number_format($sumatoria, 2, '.', '') . '</div>
                                </td>
                            </tr>';

                    echo '</table>';
                }
            }
            else 
            {
                echo '<div class="siniformacion">
                        <center>
                            No se logro encontrar informacion con los datos ingresados
                        </center>
                    </div>';
            }

        

        echo '      </td>
                </tr>
            </table>';
    }

    ?>
</body>

</html>