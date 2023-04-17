<?php
include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
require_once('../../../convertfecha.php'); //CONEXION A BASE DE DATOS
require_once('../ventas/MontosText.php');
include "../../phpqrcode/qrlib.php";

$venta = $_SESSION['venta'];

require_once('../ventas/calcula_monto2.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head><meta charset="gb18030">

            <title><?php echo $desemp ?> - SALIDA POR TRANSFERENCIA DE SUCURSAL</title>
            <script>
                function imprimir()
                {
                    
                    console.log("Imprimiendo");
                    var f = document.form1;
                    window.focus();
                    window.print();
                   
                    f.action = "../ing_salid.php";
                    f.method = "post";
                    f.submit();
                }
            </script>
            <style>
                body {
                    font-family: "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
                }

                section {
                    padding: 5px;
                    border: 2px solid #0a6fc2;
                    width: 95%;
                    border-radius: 15px;
                }

                .bodyy {


                    overflow: hidden;
                    width: 75%;
                    height: 10%;
                    margin-bottom: 10px;
                }

                .title {
                    text-align: left;
                    float: left;
                    width: 30%;
                    font-size: 75%;
                    height: 95%;
                    margin-left: -5px;

                }

                .title2 {

                    float: left;
                    width: 30%;
                    height: 95%;

                    margin-left: -2px;

                }

                .div_ruc {
                    float: right;
                    width: 35%;
                    height: 55%;
                    border: 2px solid #0a6fc2;
                    border-radius: 10px;
                    margin-top: 25px;
                    margin-right: 10px;
                    text-align: center;

                }

                .title_div {
                    display: flex;

                    /*background: #930;*/
                    padding: 15px;
                    overflow: hidden;
                    margin-bottom: 10px;
                    width: 100%;
                    height: 150px;

                }

                .data_cliente {
                    float: left;
                    width: 50%;
                    border: 2px solid#0a6fc2;
                    border-radius: 5px;
                    padding: 5px 12px;
                    margin-right: 20px;
                    border-radius: 15px;
                }

                .data_cliente2 {
                    width: 90%;
                    padding: 6px 20px;

                }

                .div_ruc p {
                    font-size: 16px;
                }

                .boleta22 {

                    border: solid 1px #000000;
                }

                .letra {
                    font-size: 18px;
                }

                .letra2 {
                    font-size: 22px;
                }

                .table_1,
                p {
                    margin: 1px;
                    font-size: 87.5%;
                }

                .table_2,
                p {
                    margin: 1px;
                    font-size: 87.5%;

                }




                .table_1 {

                    width: 100%;

                    border-collapse: collapse;
                    border: none;
                }

                /*
        .table_1 th, td{
            
            border: 1px solid #000;
           padding: 5px;
           border: 1.5px solid #0a6fc2;
        }
        .table_2 th, td{
            
            border: 1px solid #000;
           padding: 5px;
           border: 1.5px solid #0a6fc2;
        }
        .table_2X th, td{
            
           border: 1px solid #000;
           padding: 5px;
           border: 1.5px solid #0a6fc2;
        }
                */

                .tdra {

                    border: 1px solid #000;
                    padding: 5px;
                    border: 1.5px solid #0a6fc2;
                }

                .thra {

                    border: 1px solid #000;
                    padding: 5px;
                    border: 1.5px solid #0a6fc2;
                }



                .table_1 th:first-child {
                    font-size: 0.875em;
                }

                .table_1 th:nth-child(2) {
                    font-size: 0.875em;
                }

                .table_1 th:nth-child(3) {
                    font-size: 0.875em;
                }

                .table_1 th:nth-child(4) {
                    font-size: 0.875em;
                }

                .table_1 th:nth-child(5) {
                    font-size: 0.875em;
                }

                .table_1 td:first-child {
                    width: 17%;
                }

                .table_1 td:nth-child(2) {
                    width: 17%;
                }

                .table_1 td:nth-child(3) {
                    width: 17%;
                }

                .table_1 td:last-child(4) {
                    width: 17%;
                }

                .table_1 td:last-child(5) {
                    width: 17%;
                }

                .table_2 {
                    width: 100%;
                    border-collapse: collapse;
                    border: none;

                }

                .table_2 th {
                    font-size: 14px;
                    background: black;
                    color: white;
                }

                .table_2x {
                    width: 100%;
                    border-collapse: collapse;
                    border: none;
                }

                .table_2x td:first-child {
                    width: 50px;

                    font-size: 11px;

                }

                .table_2x td:nth-child(2) {
                    width: 50px;

                    font-size: 11px;
                }

                .table_2x td:nth-child(3) {

                    width: 200px;

                    font-size: 11px;
                }

                .table_2x td:nth-child(4) {
                    width: 80px;

                    font-size: 11px;
                }

                .table_2x td:nth-child(5) {
                    width: 80px;

                    font-size: 11px;
                }

                .table_2x td:nth-child(6) {
                    width: 70px;

                    font-size: 11px;
                }

                .table_2x td:nth-child(7) {
                    width: 70px;

                    font-size: 11px;
                }

                .table_2 th:first-child {
                    background: black;
                    color: white;
                    font-size: 1em;
                }

                .table_2 th:nth-child(2) {
                    background: black;
                    color: white;
                    font-size: 1em;
                }

                .table_2 th:nth-child(3) {
                    background: black;
                    color: white;
                    font-size: 1em;
                }

                .table_2 th:nth-child(4) {
                    background: black;
                    color: white;
                    font-size: 1em;
                }

                .table_2 th:nth-child(5) {
                    background: black;
                    color: white;
                    font-size: 1em;
                }

                .table_2 th:nth-child(6) {
                    background: black;
                    color: white;
                    font-size: 1em;
                }

                .table_2 th:nth-child(7) {
                    background: black;
                    color: white;
                    font-size: 1em;
                }

                /*
        .div_end{
            display: grid;
            grid-template-columns: 34% 22% 22% 22%;
            width: 90%;: 800px;
            color:#e03232;
            font-size: 14px;
        }
        .div_end p{
            font-weight: 700;
        }*/


                .div_end {

                    padding: 10px;
                    overflow: hidden;
                    margin-bottom: 10px;
                    width: 100%;
                    height: 100px;
                }

                .f1 {
                    float: left;
                    width: 42%;

                    margin-right: 5px;
                    margin-left: -10px;
                }

                .f2 {
                    float: left;
                    width: 22%;

                    margin-right: 5px;
                }

                .f3 {
                    float: left;
                    width: 15%;

                    margin-right: 5px;
                }

                .f4 {

                    float: left;
                    width: 20%;



                }

                .money {
                    font-weight: 800;
                    padding-left: 65%;
                }



                .table_T {
                    line-height: 100%;
                    font-family: times;
                    font-size: 11px;
                    font-weight: normal;
                }

                .table_T2 {
                    line-height: 100%;
                    font-family: times;
                    font-size: 11px;
                    font-weight: normal;
                }
            </style>
            <?php
            $invnum = $_SESSION['transferencia_sal'];

            function pintaDatos($Valor) {
                if ($Valor <> "") {
                    return "<tr><td style:'text-align:center'><center>" . $Valor . "</center></td></tr>";
                }
            }

            function zero_fill($valor, $long = 0) {
                return str_pad($valor, $long, '0', STR_PAD_LEFT);
            }

            function cambiarFormatoFecha($fecha) {
                list($anio, $mes, $dia) = explode("-", $fecha);
                return $dia . "/" . $mes . "/" . $anio;
            }

            //set it to writable location, a place for temp generated PNG files
            $PNG_TEMP_DIR = dirname(__FILE__) . DIRECTORY_SEPARATOR . '../ventas/temp' . DIRECTORY_SEPARATOR;

            //html PNG location prefix
            $PNG_WEB_DIR = '../ventas/temp/';

            $filename = $PNG_TEMP_DIR . 'ventas.png';

            $matrixPointSize = 3;
            $errorCorrectionLevel = 'L';
            $framSize = 3;

            $seriefac = "F001";
            $filename = $PNG_TEMP_DIR . 'test' . $venta . md5($_REQUEST['data'] . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) . '.png';

            $sqlV = "SELECT invnum,nrovent,invfec,invfec,cuscod,usecod,codven,forpag,fecven,sucursal,correlativo,nomcliente,pagacon,vuelto,bruto,hora,invtot,igv,valven,tipdoc,tipteclaimpresa,anotacion,nrofactura FROM venta where invnum = '$venta'";
            $resultV = mysqli_query($conexion, $sqlV);
            if (mysqli_num_rows($resultV)) {
                while ($row = mysqli_fetch_array($resultV)) {
                    $invnum = $row['invnum'];
                    $nrovent = $row['nrovent'];
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
                    $hora = $row['hora'];
                    $tipdoc = $row['tipdoc'];
                    $tipteclaimpresa = $row['tipteclaimpresa'];
                    $anotacion = $row['anotacion'];
                    $nrofactura = $row['nrofactura'];

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
                $forma = "EFECTIVO";
            }
            if ($forpag == "C") {
                $forma = "CREDITO";
            }
            if ($forpag == "T") {
                $forma = "TARJETA";
            }

            if ($tipdoc == 1) {
                $serie = "F" . $seriefac;
                $TextDoc = "Factura electr&oacute;nica";
            }
            if ($tipdoc == 2) {
                $serie = "B" . $seriebol;
                $TextDoc = "Boleta de Venta electr&oacute;nica";
            }
            if ($tipdoc == 4) {
                $serie = "T" . $serietic;
                $TextDoc = "";
            }
            $SerieQR = $serie;

            //TOMO LOS PATRAMETROS DEL TICKET
            $sqlTicket = "SELECT linea1,linea2,linea3,linea4,linea5,linea6,linea7,linea8,linea9,pie1,pie2,pie3,pie4,pie5,pie6,pie7,pie8,pie9 FROM ticket where sucursal = '$sucursal'";
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
                $sqlTicket = "SELECT linea1,linea2,linea3,linea4,linea5,linea6,linea7,linea8,linea9,pie1,pie2,pie3,pie4,pie5,pie6,pie7,pie8,pie9 FROM ticket where sucursal = '1'";
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
                    $nomusu = $row['abrev'];
                    $nomusu2 = $row['nomusu'];
                }
            }

            $MarcaImpresion = 0;
            $sqlDataGen = "SELECT desemp,rucemp,telefonoemp,MarcaImpresion FROM datagen";
            $resultDataGen = mysqli_query($conexion, $sqlDataGen);
            if (mysqli_num_rows($resultDataGen)) {
                while ($row = mysqli_fetch_array($resultDataGen)) {
                    $desemp = $row['desemp'];
                    $rucemp = $row['rucemp'];
                    $telefonoemp = $row['telefonoemp'];
                    $MarcaImpresion = $row["MarcaImpresion"];
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
                        $sqlDPTO = "SELECT destab FROM titultabladet where codtab = '$dptcli'";
                        $resultDPTO = mysqli_query($conexion, $sqlDPTO);
                        if (mysqli_num_rows($resultDPTO)) {
                            while ($row = mysqli_fetch_array($resultDPTO)) {
                                $departamento = $row['destab'];
                            }
                        }
                    }
                    if (strlen($procli) > 0) {
                        $sqlDPTO = "SELECT destab FROM titultabladet where codtab = '$procli'";
                        $resultDPTO = mysqli_query($conexion, $sqlDPTO);
                        if (mysqli_num_rows($resultDPTO)) {
                            while ($row = mysqli_fetch_array($resultDPTO)) {
                                $provincia = " | " . $row['destab'];
                            }
                        }
                    }

                    if (strlen($discli) > 0) {
                        $sqlDPTO = "SELECT destab FROM titultabladet where codtab = '$discli'";
                        $resultDPTO = mysqli_query($conexion, $sqlDPTO);
                        if (mysqli_num_rows($resultDPTO)) {
                            while ($row = mysqli_fetch_array($resultDPTO)) {
                                $distrito = " | " . $row['destab'];
                            }
                        }
                    }
                    $Ubigeo = $departamento . $provincia . $distrito;
                    if (strlen($Ubigeo) > 0) {
                        $dircli = $dircli . "  - " . $Ubigeo;
                    }
                }
            }

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
                    }
                }
            }
            $SumGrabado = $invtot - ($igv + $SumInafectos);
            ?>
    </head>
    <body onLoad="imprimir();">
        <?php
        require_once('bodyimprime.php');
        ?>
    </body>
</html>