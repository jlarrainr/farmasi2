<?php

$sql = "SELECT desemp FROM datagen";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $desemp = $row['desemp'];
    }
}
$sqluniversal = "SELECT nmensaje,letra,color,alerta_masiva,mensaje_masiva FROM datagenuniversal";
$resultuniversal = mysqli_query($conexion2, $sqluniversal);
if (mysqli_num_rows($resultuniversal)) {
    while ($row = mysqli_fetch_array($resultuniversal)) {
        $nmensajeuniversal = $row['nmensaje'];
        $letrauniversal = $row['letra'];
        $coloruniversal = $row['color'];
        $alerta_masiva_universal = $row['alerta_masiva'];
        $mensaje_masiva_universal = $row['mensaje_masiva'];
    }
}

$mensaje_masiva_universal = trim($mensaje_masiva_universal);

$sql = "SELECT nomusu,codloc FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $zznombre = $row['nomusu'];
        $zzcodloc = $row['codloc'];
    }
}

$sql = "SELECT nombre FROM xcompa where codloc = '$zzcodloc'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $zznomloc = $row['nombre'];
    }
}

 

$sql1_datagen = "SELECT nopaga,fechavenci,vencipro,fecha_mensaje,alerta_masiva_sistema,telefonoemp,arqueo_caja,usuariosEspeciales_ArqueoCaja FROM datagen";
$result1_datagen = mysqli_query($conexion, $sql1_datagen);
if (mysqli_num_rows($result1_datagen)) {
    while ($row1 = mysqli_fetch_array($result1_datagen)) {
        $nopaga = $row1['nopaga'];
        $fechavenci = $row1['fechavenci'];
        $vencipro = $row1['vencipro'];
        $fecha_mensaje = $row1['fecha_mensaje'];
        $alerta_masiva_sistema = $row1['alerta_masiva_sistema'];
        $telefonoemp = $row1['telefonoemp'];
        $arqueo_caja = $row1['arqueo_caja'];
        $usuariosEspeciales_ArqueoCaja = $row1['usuariosEspeciales_ArqueoCaja'];
    }
}

if($nopaga == 0){
   $sqlalertaPago = "SELECT alertaPago,smspagoLocal FROM xcompa where codloc = '$zzcodloc'";
    $resultalertaPago = mysqli_query($conexion, $sqlalertaPago);
    if (mysqli_num_rows($resultalertaPago)) {
        while ($rowalertaPago = mysqli_fetch_array($resultalertaPago)) {
            $alertaPagoPorLocal = $rowalertaPago['alertaPago'];
            $smspagoLocal = $rowalertaPago['smspagoLocal'];
        }
    } 
}


// if (($alerta_masiva_universal == 0) && ($alerta_masiva_sistema == 1)) {
//     mysqli_query($conexion, "UPDATE datagen set alerta_masiva_sistema = '0' ");
// }

$sql1 = "SELECT smspago FROM datagen_det";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $smspago = $row1['smspago'];
    }
}
$smspago = trim($smspago);


//echo SEG_RAIZ;


//require_once('gestionAlertas.php');



