<?php

include('../../session_user.php');
require_once('../../../conexion.php');
//--------------------------------------------------------------------//
$val = $_REQUEST['val'];
$p1 = $_REQUEST['p1'];
$ord = $_REQUEST['ord'];
$codpro = $_REQUEST['codpro'];
$cant = $_REQUEST['cant'];
$cant2 = $_REQUEST['cant2'];
$monto = $_REQUEST['monto'];
$price = $_REQUEST['price'];
$cuota = $_REQUEST['cuota'];
$inicio = $_REQUEST['inicio'];
$pagina = $_REQUEST['pagina'];
$tot_pag = $_REQUEST['tot_pag'];
$factor = $_REQUEST['factor'];
$codloc = $_REQUEST['local'];
//$state      = $_REQUEST['state'];
$invnum = $_REQUEST['incent'];
//$hour   = date(G);
$date = date('Y-m-d');
//$date	= CalculaFechaHora($hour);
$registros = $_REQUEST['registros'];


$sqldet = "SELECT COUNT(*) FROM incentivadodet where codpro = '$codpro' and invnum = '$invnum' and estado='1' ";
$resultdet = mysqli_query($conexion, $sqldet);
if (mysqli_num_rows($resultdet)) {
    while ($rowdet = mysqli_fetch_array($resultdet)) {
        $contador_de_productos = $rowdet[0];
    }
}

if ($contador_de_productos  <> 0) {

    $sqldet = "SELECT COUNT(*) FROM incentivadodet where codpro = '$codpro' and invnum <> '$invnum' and estado='1'";
    $resultdet = mysqli_query($conexion, $sqldet);
    if (mysqli_num_rows($resultdet)) {
        while ($rowdet = mysqli_fetch_array($resultdet)) {
            $contador_de_productos_2 = $rowdet[0];
        }
    }

    if ($contador_de_productos_2 <> 0) {


        $sqlcomparacion = "SELECT dateini FROM incentivado where invnum = '$invnum' and estado='1' and esta_desa=0 ";
        $resultcomparacion = mysqli_query($conexion, $sqlcomparacion);
        if (mysqli_num_rows($resultcomparacion)) {
            while ($row = mysqli_fetch_array($resultcomparacion)) {
                $dateinicomparacion = $row[0];
            }
        }
        $sqlfiltro = "SELECT I.datefin FROM incentivado as I inner join incentivadodet as ID ON ID.invnum=I.invnum where   ID.codpro = '$codpro'  
        and I.estado='1' and I.esta_desa = 0 and I.invnum <> '$invnum' ";
        $resultfiltro = mysqli_query($conexion, $sqlfiltro);
        if (mysqli_num_rows($resultfiltro)) {
            while ($row = mysqli_fetch_array($resultfiltro)) {
                $datefinfiltro = $row[0];
            }
        }
    }
}


 //echo 'dateinicomparacion ' . $dateinicomparacion . "<br>";
 //echo 'datefinfiltro ' . $datefinfiltro . "<br>";


if (($contador_de_productos <> 0)) {
    header("Location: incentivo1.php?cod=$codpro&p1=$p1&val=$val&inicio=$inicio&pagina=$pagina&tot_pag=$tot_pag&registros=$registros&incent=$invnum&local=$codloc&valform=1&mensaje=4");
} else {

    if (($dateinicomparacion <= $datefinfiltro && $contador_de_productos  <> 0) ){
        header("Location: incentivo1.php?cod=$codpro&p1=$p1&val=$val&inicio=$inicio&pagina=$pagina&tot_pag=$tot_pag&registros=$registros&incent=$invnum&local=$codloc&valform=1&mensaje=3");
    } else {

        $sql = "SELECT codpro FROM incentivadodet where codpro = '$codpro' and invnum = '$invnum' and codloc = '$codloc'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            $sihay = 1;
        } else {
            $sihay = 0;
        }
        //--------------------------------------------------------------------//
        if ($sihay == 1) {
            mysqli_query($conexion, "UPDATE incentivadodet set canprocaj = '$cant',canprounid = '$cant2',pripro = '$monto',pripromin = '$price', cuota = '$cuota',factor = '$factor' where codpro = '$codpro' and invnum = '$invnum' and codloc = '$codloc'");
        } else {
            $sql = "SELECT estado,dateini,datefin FROM incentivado where invnum = '$invnum'";
            $result = mysqli_query($conexion, $sql);
            if (mysqli_num_rows($result)) {
                while ($row = mysqli_fetch_array($result)) {
                    $state = $row[0];
                    $date1 = $row[1];
                    $date2 = $row[2];
                }
            }
            
            mysqli_query($conexion, "INSERT INTO incentivadodet (invnum,codpro,canprocaj,canprounid,pripro,pripromin,cuota,estado,factor,codloc) values ('$invnum','$codpro','$cant','$cant2','$monto','$price','$cuota','$state','$factor','$codloc')");


            $sqlX = "SELECT invnum FROM detalle_venta where codpro = $codpro and invfec between '$date1' and '$date2'";
            $resultX = mysqli_query($conexion, $sqlX);
            if (mysqli_num_rows($resultX)) {
                while ($rowX = mysqli_fetch_array($resultX)) {
                    $invnumVent = $rowX['invnum'];
                    mysqli_query($conexion, "UPDATE detalle_venta set incentivo = '$invnum' where invnum = '$invnumVent' and codpro = $codpro");
                }
            }
        }
        //--------------------------------------------------------------------//
        $sql = "SELECT sum(codpro) FROM incentivadodet where codpro = '$codpro' and invnum = '$invnum' and estado = '1' ";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $sumcodes = $row[0];
            }
        }
        //--------------------------------------------------------------------//
        if ($sumcodes == 0) {
            mysqli_query($conexion, "UPDATE producto set incentivado = '0' where codpro = '$codpro'");
        } else {
            mysqli_query($conexion, "UPDATE producto set incentivado = '1' where codpro = '$codpro'");
        }

        //header("Location: incentivo1.php?cod=$codpro&p1=$p1&val=$val&inicio=$inicio&pagina=$pagina&tot_pag=$tot_pag&registros=$registros&incent=$invnum&local=$codloc&valform=1&mensaje=2");

        header("Location: incentivo1.php?valform=1&mensaje=2");
    }
}
