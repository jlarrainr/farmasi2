<?php

require_once("../../../conexion.php");
include('../../session_user.php');
$clave = $_REQUEST['clave'];
$grupo = $_REQUEST['grupo'];
$usecod = $_REQUEST['usecod'];
$codgrup = $_REQUEST['codgrup'];
$excel = $_REQUEST['excel'];
$local = $_REQUEST['local'];
$claveventa = "c" . $_REQUEST['claveventa'];


$sqlx = "SELECT pasusu,logusu,codgrup,codloc,export FROM usuario  where usecod = '$usecod'";
$resultx = mysqli_query($conexion, $sqlx);
if (mysqli_num_rows($resultx)) {
    while ($row = mysqli_fetch_array($resultx)) {
        $pasusu_filtro = $row[0];
        $logusu_filtro = $row[1];
        $codgrup_filtro = $row[2];
        $local_filtro = $row[3];
        $export_filtro = $row[4];
    }
}

// echo '$usecod' . $usecod . "<br>";
// echo '$pasusu_filtro' . $pasusu_filtro . "<br>";
// echo '$clave' . $clave . "<br>";
// echo '$codgrup_filtro' . $codgrup_filtro . "<br>";
// echo '$$grupo' . $grupo . "<br>";
// echo '$$local_filtro' . $local_filtro . "<br>";
// echo '$$local' . $local . "<br>";
if (($pasusu_filtro == $clave) && ($codgrup_filtro == $grupo) && ($local_filtro == $local)&&($export_filtro == $excel)) {
    header("Location: acceso_user_listado.php?contrasena=1&val=1&codgrup=$codgrup");
} else {
    //    $sql = "SELECT logusu,nomusu FROM usuario WHERE (claveventa = '$claveventa')";
    $sql = "SELECT logusu,nomusu FROM usuario WHERE pasusu = '$clave' and logusu = '$logusu_filtro' and codgrup='$grupo'and codloc='$local' and export='$excel' ";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_fetch_array($result)) {
        header("Location: acceso_user_listado.php?error=1&val=1&codgrup=$codgrup");
    } else {
        mysqli_query($conexion, "UPDATE usuario set claveventa = '$claveventa',pasusu = '$clave', codgrup = '$grupo', export = '$excel',codloc = '$local' where usecod = '$usecod'");
        header("Location: acceso_user_listado.php?codgrup=$codgrup");
    }
}
