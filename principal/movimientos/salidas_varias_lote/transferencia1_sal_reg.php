<?php

include('../../session_user.php');
require_once('../../../conexion.php');
$cod = $_POST['cod'];   ///invnum
$referencia = $_POST['referencia']; ///referencia
$mont2 = $_POST['mont2'];   ///monto total
$hoy = date('Y-m-d H:i:s');





function convertir_a_numero($str)
{
    $legalChars = "%[^0-9\-\. ]%";
    $str = preg_replace($legalChars, "", $str);
    return $str;
}

////VERIFICO LOS DATOS DEL DOCUMENTO Y ESCOGO EL USUARIO Y SU LOCAL
$sql = "SELECT numdoc,invfec,tipmov,tipdoc,usecod FROM movmae where invnum = '$cod'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $numdoc = $row['numdoc'];
        $invfec = $row['invfec'];
        $tipmov = $row['tipmov'];
        $tipdoc = $row['tipdoc'];
        $usecod = $row['usecod'];
    }
}
$sql = "SELECT codloc FROM usuario where usecod = '$usecod'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codloc = $row['codloc'];
    }
}
$sql = "SELECT nomloc FROM xcompa where codloc = '$codloc'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nomloc = $row['nomloc'];
    }
}
require_once('../tabla_local.php');
$sql = "SELECT codpro,qtypro,qtyprf,pripro,costre,costpr,numlote,idlote_salida FROM tempmovmov where invnum = '$cod' ORDER BY codtemp";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    $i = 0;
    while ($row = mysqli_fetch_array($result)) {
        $i++;
        $codpro = $row['codpro'];
        $qtypro = $row['qtypro'];
        $qtyprf = $row['qtyprf'];
        $pripro = $row['pripro'];
        $costre = $row['costre'];
        $costpr = $row['costpr'];
        $numlote = $row['numlote'];
        $idlote_salida = $row['idlote_salida'];


        $sql_movlote = "SELECT  stock FROM  movlote where idlote ='$idlote_salida'";
        $result_movlote = mysqli_query($conexion, $sql_movlote);
        if (mysqli_num_rows($result_movlote)) {
            while ($row_movlote = mysqli_fetch_array($result_movlote)) {

                $cant_loc = $row_movlote['stock'];
            }
        }


        $sql1 = "SELECT factor,stopro,$tabla FROM producto where codpro = '$codpro'";
        $result1 = mysqli_query($conexion, $sql1);
        if (mysqli_num_rows($result1)) {
            while ($row1 = mysqli_fetch_array($result1)) {
                $factor = $row1['factor'];
                $stopro = $row1['stopro'];
                $sotck_producto = $row1[2];
                //				$sactual   = $stopro;
                $sactual = $sotck_producto;
            }
        }


        if ($qtyprf <> "") {
            $text_char = convertir_a_numero($qtyprf);
            $cant_unid = $text_char;
        } else {
            $cant_unid = $qtypro * $factor;
        }

        if ($cant_loc < $cant_unid) {
            echo '<script type="text/javascript">
                                alert("Eliminar de la lista los productos que no cuentan con stock disponible en el lote(fondo rojo)  ");
                                window.location.href="salidas_varias_lote.php";
                                </script>';
            return;
        }

        if ($cant_loc >= $cant_unid) {
            //echo "existe este producto";
            $cant_local = $sotck_producto - $cant_unid;
            $cant_loc_lote = $cant_loc - $cant_unid;
            $stopro = $stopro - $cant_unid;
            $stocklote = 0;




            /////////////////////////////////////////////////////////////////////
            /////////////////////////////////////////////////////////////
            mysqli_query($conexion, "UPDATE producto set stopro = '$stopro',$tabla = '$cant_local' where codpro = '$codpro'");
            mysqli_query($conexion, "UPDATE movlote set stock = '$cant_loc_lote' where idlote = '$idlote_salida'");
            mysqli_query($conexion, "INSERT INTO kardex (nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,fraccion,factor,invnum,usecod,sactual,sucursal,numlote) values ('$numdoc','$codpro','$invfec','$tipmov','$tipdoc','$qtypro','$qtyprf','$factor','$cod','$usuario','$sactual','$codloc','$idlote_salida')");
            $last_idKardex = mysqli_insert_id($conexion);
            /////////////////////////////////////////////////
            mysqli_query($conexion, "INSERT INTO movmov (invnum,invfec,codpro,qtypro,qtyprf,pripro,costre,costpr,numlote,orden) values ('$cod','$invfec','$codpro','$qtypro','$qtyprf','$pripro','$costre','$costpr','$idlote_salida','$i')");
        }
    }
}
$sql = "SELECT correlativo FROM movmae order by correlativo desc limit 1";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $correlativo = $row[0];        //codigo
    }
    $correlativo    = $correlativo + 1;
}
mysqli_query($conexion, "DELETE from tempmovmov where invnum = '$cod'");
mysqli_query($conexion, "UPDATE movmae set invtot  = '$mont2', monto = '$mont2',refere = '$referencia', estado = '0', proceso = '0',correlativo='$correlativo',hora='$hoy' where invnum = '$cod'");
mysqli_query($conexion, "UPDATE kardex set nrodoc = $correlativo  where invnum = '$cod'");
//header("Location: ../ing_salid.php"); 
//header("Location: generaImpresion.php?Compra=$cod");

echo "<script>if(confirm('DESEA IMPRIMIR ESTA SALIDA')){document.location='generaImpresion.php?Compra=$cod';}else{ alert(document.location='../ing_salid.php');}</script>";
