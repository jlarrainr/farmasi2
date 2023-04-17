<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
///////////////////////////////
require_once('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
require_once('../../../convertfecha.php');    //CONEXION A BASE DE DATOS
require_once('MontosText.php');
require_once('../../../funciones/highlight.php');    //ILUMINA CAJAS DE TEXTOS
require_once('../../../funciones/functions.php');    //DESHABILITA TECLAS
require_once('../../../funciones/botones.php');    //COLORES DE LOS BOTONES
require_once('../../../funciones/funct_principal.php');    //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
require_once('../funciones/venta.php');    //FUNCIONES DE ESTA PANTALLA
require_once('../../local.php');    //LOCAL DEL USUARIO
//require_once('calcula_monto2.php');
//$venta     = $_SESSION['venta'];
//////////////////////////////


$venta = $_REQUEST['invnum'];

function pintaDatos($Valor)
{
    if ($Valor <> "") {
        return "<tr><td style:'text-align:center'><center>" . $Valor . "</center></td></tr>";
    }
}
function pintaDatosTitle($Valor)
{
    if ($Valor <> "") {
        return $Valor;
    } else {
        return "------ . ------";
    }
}

function zero_fill($valor, $long = 0)
{
    return str_pad($valor, $long, '0', STR_PAD_LEFT);
}
?>


<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <!-- <script>
        function imprimir() {
            //alert("consult_compras1.php?pageno=<?php echo $pag ?>&numero=<?php echo $numerox ?>");
            
            var f = document.form1;
            window.print();
            self.close();
            <?php
             echo "parent.opener.location='ventas1.php';";
            ?>
            //  window.close();
        
       
        }
    </script> -->

    <script>
         
             
         function imprimir() {
        var f = document.form1;
        window.print();
        //self.close();
        <?php
        echo "parent.opener.location='ventas1.php?val=0';";
        
        ?>
        
       window.onafterprint = function(){
               self.close();
            }
        
    }
    
</script>
    <link href="css/css_bodyimprimeA4.css" rel="stylesheet" type="text/css" />
</head>
<?php

function cambiarFormatoFecha($fecha)
{
    list($anio, $mes, $dia) = explode("-", $fecha);
    return $dia . "/" . $mes . "/" . $anio;
}

$PNG_TEMP_DIR = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR;

$PNG_WEB_DIR = 'temp/';

include "../../phpqrcode/qrlib.php";

$filename = $PNG_TEMP_DIR . 'ventas.png';

$matrixPointSize = 3;
$errorCorrectionLevel = 'L';
$framSize = 3; //TamaÃ¯Â¿Â½Ã¯Â¿Â½Ã¯Â¿Â½Ã¯Â¿Â½Ã¯Â¿Â½o en blanco

$seriebol = "B001";
 $seriefac = "F001";
 $serietic = "T001";
// $filename = $PNG_TEMP_DIR . 'test' . $venta . md5($_REQUEST['data'] . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) . '.png';


$sqlV = "SELECT invnum,nrovent,invfec,invfec,cuscod,usecod,codven,forpag,fecven,sucursal,correlativo,nomcliente,pagacon,vuelto,bruto,hora,invtot,igv,valven,tipdoc,tipteclaimpresa,anotacion,nrofactura,icbpertotal,numeroCuota,val_habil FROM venta where invnum = '$venta'";
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
        $val_habil = $row['val_habil'];
        $hora = $row['hora'];
        $tipdoc = $row['tipdoc'];
        $tipteclaimpresa = $row['tipteclaimpresa'];
        $anotacion = $row['anotacion'];
        $nrofactura = $row['nrofactura'];
        $icbper_total = $row['icbpertotal'];
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
        $nomusu = $row['abrev'];
        $nomusu2 = $row['nomusu'];
    }
}

$MarcaImpresion = 0;
$sqlDataGen = "SELECT desemp,rucemp,telefonoemp,MarcaImpresion,diasCuotasVentas FROM datagen";
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
$sqlCli = "SELECT descli,dircli,ruccli,dptcli,procli,discli,puntos,dnicli FROM cliente where codcli = '$cuscod'";
$resultCli = mysqli_query($conexion, $sqlCli);
if (mysqli_num_rows($resultCli)) {
    while ($row = mysqli_fetch_array($resultCli)) {
        $descli = $row['descli'];
        $dnicli = $row['dnicli'];
        $dircli = $row['dircli'];
        $ruccli = $row['ruccli'];
        $dptcli = $row['dptcli'];
        $procli = $row['procli'];
        $discli = $row['discli'];
        $pstcli = $row['puntos'];
    }
    if (strlen($dircli) > 0) {
        //VERIFICO LOS DPTO, PROV Y DIST
        if (strlen($dptcli) > 0) {
            //                $sqlDPTO = "SELECT destab FROM titultabladet where codtab = '$dptcli'";
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
        }
    }
}
$SumGrabado = $invtot - ($igv + $SumInafectos);
$SumGrabado = $SumGrabado - $icbper_total;
mysqli_query($conexion, "UPDATE venta set gravado = '$SumGrabado',inafecto = '$SumInafectos' where invnum = '$venta'");
/* echo pintaDatos($linea1);
      echo pintaDatos($linea2);
      echo pintaDatos($linea3);
      echo pintaDatos($linea4);
      if($tipdoc <> 4)
      {
      echo pintaDatos($linea5);
      }
      echo pintaDatos($linea6);
      echo pintaDatos($linea7);
      echo pintaDatos($linea8);
      echo pintaDatos($linea9); */





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
        $val_habil = $row['val_habil'];
        // $serie_doc = $row['serie_doc'];
        //  $fecha_old = cambiarFormatoFecha($row['fecha_old']);


        // $docafectado = $serie_doc . " FECHA :" . $fecha_old;

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


$sqlUsu = "SELECT logo FROM xcompa where codloc = '$sucursal'";
$resultUsu = mysqli_query($conexion, $sqlUsu);
if (mysqli_num_rows($resultUsu)) {
    while ($row = mysqli_fetch_array($resultUsu)) {
        $logo = $row['logo'];
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
if ($tipdoc == 6) {
    $serie = "C" . $serienot;
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
    $TextDoc = "Factura electronica";
}
if ($tipdoc == 2) {
    $TextDoc = "Boleta de Venta electronica";
}
if ($tipdoc == 4) {
    $TextDoc = "";
}
if ($tipdoc == 6) {
    $TextDoc = "Nota de credito";
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
        $nomusu2 = $row['abrev'];
        $nomusu = $row['nomusu'];
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
$sqlCli = "SELECT descli,dircli,ruccli,dptcli,procli,discli,puntos,dnicli FROM cliente where codcli = '$cuscod'";
$resultCli = mysqli_query($conexion, $sqlCli);
if (mysqli_num_rows($resultCli)) {
    while ($row = mysqli_fetch_array($resultCli)) {
        $descli = $row['descli'];
        $dnicli = $row['dnicli'];
        $dircli = $row['dircli'];
        $ruccli = $row['ruccli'];
        $dptcli = $row['dptcli'];
        $procli = $row['procli'];
        $discli = $row['discli'];
        $pstcli = $row['puntos'];
    }
    if (strlen($dircli) > 0) {
        //VERIFICO LOS DPTO, PROV Y DIST
        if (strlen($dptcli) > 0) {
            //                $sqlDPTO = "SELECT destab FROM titultabladet where codtab = '$dptcli'";
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


$SumInafectos = 0;

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
        $sqlProdDet = "SELECT igv FROM producto where codpro = '$codproDet' and eliminado='0'";
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
$SumGrabado = $SumGrabado - $icbper_total;
mysqli_query($conexion, "UPDATE venta set gravado = '$SumGrabado',inafecto = '$SumInafectos' where invnum = '$venta'");
if ($val_habil == 1) {
    $anulado = "ANULADO";
}
?>


<body onload="imprimir()">

    <?php
    require_once('bodyimprime.php');
    ?>

</body>

</html>