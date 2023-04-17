<?php

include('../../session_user.php');
require_once ('../../../conexion.php');
$transferencia_ing = $_SESSION['transferencia_ing'];
$sql = "SELECT invfec,tipmov,tipdoc,usecod FROM movmae where invnum = '$transferencia_ing'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
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
$cod = $_POST['movmae'];  ///INVNUM
///CALCULO DEL LOCAL DESTINO Y EL USUARIO ORIGEN
$sql = "SELECT numdoc FROM movmae where invnum = '$cod'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $numdoc = $row['numdoc'];
    }
}

function convertir_a_numero($str) {
    $legalChars = "%[^0-9\-\. ]%";
    $str = preg_replace($legalChars, "", $str);
    return $str;
}

///CALCULO DEL LOCAL ORIGEN
///BUCLE PARA ACTUALIZAR LA INFORMACION
$sql = "SELECT * FROM tempmovmov where invnum = '$transferencia_ing'";   /////CARGO LA DATA DE LA TRANSFERENCIA
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codpro = $row['codpro'];
        $qtypro = $row['qtypro'];
        $qtyprf = $row['qtyprf'];
        $pripro = $row['pripro'];
        $costre = $row['costre'];
        $costpr = $row['costpr'];
        $numlote = $row['numlote'];
        $cant_local = 0;
        /////////////////////////////////////////////////////////////
        $sql1 = "SELECT factor,stopro,$tabla FROM producto where codpro = '$codpro'";
        $result1 = mysqli_query($conexion, $sql1);
        if (mysqli_num_rows($result1)) {
            while ($row1 = mysqli_fetch_array($result1)) {
                $factor = $row1['factor'];
                $stopro = $row1['stopro'];
                $cant_loc = $row1[2];
//				$sactual   = $stopro;
                $sactual = $cant_loc;
            }
        }
        if ($qtyprf <> "") {
            $text_char = convertir_a_numero($qtyprf);
            $cant_unid = $text_char;
        } else {
            $cant_unid = $qtypro * $factor;
        }
        $cant_local = $cant_loc + $cant_unid;
        $stopro = $stopro + $cant_unid;

        $sql1 = "UPDATE producto set stopro = '$stopro',$tabla = '$cant_local' where codpro = '$codpro'";
        mysqli_query($conexion, $sql1);
//		if (mysqli_errno($conexion))
//			error_log("Actualiza producto SQL(".$sql1.")\nError(".mysqli_error($conexion).")");

        $sql1 = "INSERT INTO kardex (nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,fraccion,factor,invnum,usecod,sactual,sucursal) values ('$numdoc','$codpro','$invfec','$tipmov','$tipdoc','$qtypro','$qtyprf','$factor','$transferencia_ing','$usuario','$sactual','$codloc')";
        mysqli_query($conexion, $sql1);
//		if (mysqli_errno($conexion))
//			error_log("Agrega kardex SQL(".$sql1.")\nError(".mysqli_error($conexion).")");

        $sql1 = "SELECT * FROM tempmovmov where invnum = '$transferencia_ing' and codpro = '$codpro'";
        $result1 = mysqli_query($conexion, $sql1);
        if (mysqli_num_rows($result1)) {
            while ($row1 = mysqli_fetch_array($result1)) {
                $temporal = $row1['codtemp'];
                $qtypro2 = $row1['qtypro'];
                $qtyprf2 = $row1['qtyprf'];
                $pripro2 = $row1['pripro'];
                $costre2 = $row1['costre'];
                $sql1 = "INSERT INTO movmov (invnum,invfec,codpro,qtypro,qtyprf,pripro,costre,numlote,costpr) values ('$transferencia_ing','$invfec','$codpro','$qtypro2','$qtyprf2','$pripro2','$costre2','$numlote','$costpr')";
                mysqli_query($conexion, $sql1);
//				if (mysqli_errno($conexion))
//					error_log("Agrega Linea Mov SQL(".$sql1.")\nError(".mysqli_error($conexion).")");
                $sql1 = "DELETE from tempmovmov where codtemp = '$temporal'";
                mysqli_query($conexion, $sql1);
//				if (mysqli_errno($conexion))
//					error_log("Elimina Linea Temp SQL(".$sql1.")\nError(".mysqli_error($conexion).")");
            }
        }
    }
}
/////////////////////////////////////////////////////////
$sql1 = "UPDATE movmae set estado = '1', proceso = '0' where invnum = '$cod'";
mysqli_query($conexion, $sql1);
//if (mysqli_errno($conexion))
//	error_log("Actualiza Estado Mae SQL(".$sql1.")\nError(".mysqli_error($conexion).")");
$sql1 = "UPDATE movmae set estado = '1', proceso = '0' where invnum = '$transferencia_ing'";
mysqli_query($conexion, $sql1);
//if (mysqli_errno($conexion))
//	error_log("Actualiza Estado Mae SQL(".$sql1.")\nError(".mysqli_error($conexion).")");
header("Location: transferencia1_ing_op_reg1.php");
?>