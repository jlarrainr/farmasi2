<?php

include('../../session_user.php');
require_once ('../../../conexion.php');
require_once ('../../../convertfecha.php');

function convertir_a_numero($str) {
    $legalChars = "%[^0-9\-\. ]%";

    $str = preg_replace($legalChars, "", $str);
    return $str;
}

$date1 = fecha1($_REQUEST['date1']);
$date2 = fecha1($_REQUEST['date2']);
$codloc = $_REQUEST['local'];

$date = date('Y-m-d H:i:s');
$sqlInsert = "INSERT INTO `prepedido`
    (`idusuario`, `codloc`, `fecha`, `estado`, `fechaini`, `fechafin`) 
    VALUES ('$usuario', '$codloc', '$date', '0', '$date1', '$date2')";
error_log($sqlInsert);
$result = mysqli_query($conexion, $sqlInsert);
$last_id = mysqli_insert_id($conexion);
$numPagina = 0;

$numpagpreped = 1000000000;
$sql1 = "SELECT numpagpreped FROM datagen";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $numpagpreped = $row1['numpagpreped'];
    }
}
$numpagpreped = 1000000000;
if (isset($_SESSION['datosPrepedido'])) {
    $datosPrepedido = $_SESSION['datosPrepedido'];
    usort($datosPrepedido, function($a, $b) {
        return strcmp($a["destab"], $b["destab"]);
        ;
    });
    $codigos = array();
    $primCodigo = 0;
    foreach ($datosPrepedido as $datos) {
        $codpro = $datos['codprod'];
        $sumcantidadAux = $datos['unidades'];
        $StockActualAux = $datos['stock'];
        $stockCentral = $datos['stockCentral'];
        $fraccionpre = $datos['fraccion'];
        $factorpre = $datos['factor'];
        $blisterpre = $datos['blister'];
         $utlcosALM = $datos['utlcos'];
        


if($stockCentral<=0){
    $stockCentral=1;
}
        $contador = floor($numPagina / $numpagpreped);

        $solicitado = $sumcantidadAux;

        if ($fraccionpre == 1) {
            $sumcantidadAux1 = convertir_a_numero($sumcantidadAux);
            $stockCentral = $stockCentral;
        } else {
            $sumcantidadAux1 = $sumcantidadAux * $factorpre;
            $stockCentral1 = ($stockCentral );
            $stockCentral2 = ((int) ($stockCentral1));
            $stockCentral = $stockCentral2;
        }

       // if ($stockCentral < $sumcantidadAux1) {

//            $solicitado = $stockCentral;



            if ($fraccionpre == 1) {
                $solicitado = $sumcantidadAux;

//                if (($factorpre > 1) && ($blisterpre > 0)) {
//                    $solicitado = round($solicitado / $blisterpre) * $blisterpre;
//                } else {
//                    $solicitado = $solicitadox;
//                }
            } else {
                $stockCentral1 = $sumcantidadAux / $factorpre;
                $stockCentral2 = ((int) ($stockCentral1));
                $solicitado = $stockCentral2;


//                if (($factorpre > 1) && ($blisterpre > 0)) {
//                    $solicitado = round($solicitado / $blisterpre) * $blisterpre;
//                } else {
//                    $solicitado = $solicitadox;
//                }
            }
       // }


//        echo 'codpro'."####################".$codpro."##########################"."<br>";
//        echo '$stockCentral'."-..".$stockCentral."<br>";
//        echo '$sumcantidadAux1'."-..".$sumcantidadAux1."<br>";
//        echo '$solicitado'."-..".$solicitado."<br>";
//        echo '----------------------------'."<br>";



       // if (($utlcosALM > 0)){
            //$codigoNuevo = ($last_id * 100) + $contador;
            $codigoNuevo = ($last_id * 1) + $contador;
            if ($primCodigo == 0) {
                $primCodigo = $codigoNuevo;
            }
            if ($fraccionpre == 1) {
                $sqlInsertDetalle = "INSERT INTO detalle_prepedido(idprepedido, idprod,idcantidad,solicitado,stockprod,numpagina,fraccion,factor,control) VALUES ('$last_id', '$codpro', 'F$sumcantidadAux', 'F$solicitado', '$StockActualAux', '$codigoNuevo','$fraccionpre','$factorpre','$stockCentral')";
            } else {
                $sqlInsertDetalle = "INSERT INTO detalle_prepedido(idprepedido, idprod,idcantidad,solicitado,stockprod,numpagina,fraccion,factor,control) VALUES ('$last_id', '$codpro', '$sumcantidadAux', '$solicitado', '$StockActualAux', '$codigoNuevo','$fraccionpre','$factorpre','$stockCentral')";
            }
            error_log($sqlInsertDetalle);
            mysqli_query($conexion, $sqlInsertDetalle);
            $numPagina++;
            if (!in_array($codigoNuevo, $codigos)) {
                $codigos[] = $codigoNuevo;
            }
        //}
    }
    $textoCodigos = implode(",", $codigos);
    unset($_SESSION['datosPrepedido']);
    echo'<script type="text/javascript">
            alert("Se ha generado el Prepedido Numero: ' . $textoCodigos . '");
            window.location.href="prepedido.php?idpreped=' . $last_id . '&numpagina=' . $primCodigo . '";
            </script>';
            
            
}
