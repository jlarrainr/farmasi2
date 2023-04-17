<?php
 //error_reporting(E_ALL);
 //ini_set('display_errors', '1');
include('../../session_user.php');
require_once('../../../conexion.php');

function convertir_a_numero($str)
{
    $legalChars = "%[^0-9\-\. ]%";

    $str = preg_replace($legalChars, "", $str);
    return $str;
}

$prepedido = 0;
//if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_REQUEST['prepedido'])) {
        $prepedido = $_REQUEST['prepedido'];
    }
//}
$alertMensaje = 'No se encontro prepedido o ya fue registrado';
if ($prepedido > 0) {
    $invnum = $_SESSION['transferencia_sal'];
    error_log("se llama nuevamente al prepedido: ");
    error_log($invnum);

    //$sql = "SELECT DISTINCT idprod, solicitado, P.costpr,P.preuni,P.costre, PR.codloc,DP.factor,DP.fraccion,DP.numpagina FROM detalle_prepedido DP, producto P, prepedido PR ,titultabladet M  WHERE numpagina= '$prepedido'  and DP.solicitado<> '0' and DP.idprod=P.codpro and PR.idpreped = DP.idprepedido order by M.destab, P.desprod";
    $sql = "SELECT PRE.codloc,DP.idprod,DP.solicitado,DP.factor,DP.fraccion,DP.numpagina, P.costpr,P.preuni,P.costre,PRE.idpreped FROM prepedido as PRE INNER JOIN detalle_prepedido AS DP ON DP.idprepedido=PRE.idpreped INNER JOIN producto AS P ON DP.idprod=P.codpro INNER JOIN titultabladet AS M ON M.codtab=P.codmar WHERE DP.numpagina= '$prepedido' and DP.solicitado<> '0' and DP.solicitado<> '' and PRE.estado=0 order by P.desprod ASC";
    error_log($sql);
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $numpaginapre = $row['numpagina'];
            $idprod = $row['idprod'];
            $solicitado = $row['solicitado'];
            $solicitado22 = $row['solicitado'];
            $costpr = $row['costpr'];
            $preuni = $row['preuni'];
            $costre1 = $row['costre'];
            $codloc = $row['codloc'];
            $factor = $row['factor'];
            $fraccion = $row['fraccion'];
            $mardis = $row['mardis'];
            $idpreped = $row['idpreped'];


            $sql1xx = "SELECT s000 FROM producto where codpro = '$idprod'";
            $result1xx = mysqli_query($conexion, $sql1xx);
            if (mysqli_num_rows($result1xx)) {
                while ($row1xx = mysqli_fetch_array($result1xx)) {
                    $cant_loc = $row1xx[0];
                }
            }


            /* if (($costpr == 0) || ($costpr == "")) {
                $costpr = $costre1;
            }*/
            /*if ($mardis == 0) {
                                $costre2 = $costre1 * (1 + 5 / 100);
                            } else {
                                $costre2 = $costre1 * (1 + $mardis / 100);
                            }*/

            $costre2 = $costre1;

            $string = $solicitado22;
            $letraxx = $string[0];



            if ($letraxx == 'F') {
                $solicitadofiltro1 = convertir_a_numero($solicitado);
                $solicitado1 = convertir_a_numero($solicitado);
                $precio = ($costre2 / $factor);
                $costre = round($solicitado1 * $precio, 2);
            } else {
                $solicitadofiltro1 = $solicitado;
                $precio = ($costre2);
                $costre = round($solicitado * $precio, 2);
            }


            //if($cant_loc >= $solicitadofiltro1){

            if ($solicitadofiltro1 > 0) {
                $sqlVer = "SELECT * FROM tempmovmov WHERE invnum='$invnum' AND codpro='$idprod'";
                //                error_log($sqlVer);
                $resultVer = mysqli_query($conexion, $sqlVer);
                if (!mysqli_num_rows($resultVer)) {
                    if ($letraxx == 'F') {
                        $sqlInsert = "INSERT INTO tempmovmov (invnum,codpro,qtyprf,pripro,costre,costpr,reg_prepedido) values ('$invnum','$idprod','$solicitado',$precio,$costre,'$costpr','1')";
                    } else {
                        $sqlInsert = "INSERT INTO tempmovmov (invnum,codpro,qtypro,pripro,costre,costpr,reg_prepedido) values ('$invnum','$idprod','$solicitado',$precio,$costre,'$costpr','1')";
                    }
                    error_log($sqlInsert);
                    mysqli_query($conexion, $sqlInsert);
                }
            }
            //}
            $sqlUpdate = "UPDATE movmae SET sucursal1='$codloc',cargaprepedido='$numpaginapre' WHERE invnum='$invnum'";
            mysqli_query($conexion, $sqlUpdate);
            $alertMensaje = 'Prepedido cargado';
        }
    }
}

echo '<script type="text/javascript">
alert("' . $alertMensaje . '");
window.location.href="transferencia1_sal.php";
</script>';
