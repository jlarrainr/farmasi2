<?php


//require_once 'principal/session_user.php';


//echo basename(__DIR__);
 
$nombreSistema = 'prueba';

/////////////////////////////////////////////////SEGUNDA CONEXION///////////////////////////////////////////////////////////////////////////////////////
$dbhost3     = 'localhost';    //host del Mysql 
$dbUsuario3  = 'farmasi2_mariros';    //En este caso el servidor no tiene valor para usuario para acceder a la base
$dbpassword3 = 'mariarosa2';    //Aqui tambien no hay un valor especifico
$db3         = 'farmasi2_bdsisreg';        // Nombre de la Base Datos
$conexion3 = mysqli_connect($dbhost3, $dbUsuario3, $dbpassword3, $db3) or die("No se ha podido conectar al servidor de Base de datos");
/////////////////////////////////////////////////SEGUNDA CONEXION///////////////////////////////////////////////////////////////////////////////////////
if ($nombreSistema == 'prueba') {
    $nombreSistema = 'farmasisPrueba2';
}
// ────────────────────────────────────────────────────────────────────────────────
//!ALERTA PAGO INICIO
// ────────────────────────────────────────────────────────────────────────────────

$sqlAlertaPago = "SELECT * FROM alertamasiva  as A INNER JOIN alertamasivadetalle AS AD ON A.id=AD.idMasivo  INNER JOIN cliente AS C ON C.id=AD.idSistema  WHERE  AD.estadoActivo= '1' AND C.nombreSistema = '$nombreSistema' and  AD.idMasivo = '3' and idLocalSistema='$zzcodloc' ";
$resultAlertaPago = mysqli_query($conexion3, $sqlAlertaPago);
if (mysqli_num_rows($resultAlertaPago)) {
    while ($rowAlertaPago = mysqli_fetch_array($resultAlertaPago)) {
        $smspago =   mb_strtoupper($rowAlertaPago["mensajePantalla"], 'UTF-8');
        $nopaga  =   $rowAlertaPago["estadoIntensidad"];
    }
} else {
    $smspago = "";
    $nopaga  = 0;
}
// ────────────────────────────────────────────────────────────────────────────────
//!ALERTA PAGO FIN
// ────────────────────────────────────────────────────────────────────────────────
//////////////////////////////ALERTA MASIVA/////////////////////////////////////
//////////////////////////////ALERTA MASIVA/////////////////////////////////////
//////////////////////////////ALERTA MASIVA/////////////////////////////////////
//////////////////////////////ALERTA MASIVA/////////////////////////////////////
// ────────────────────────────────────────────────────────────────────────────────
//TODO:ALERTA HOSTING INICIO
// ────────────────────────────────────────────────────────────────────────────────

$sqlHosting = "SELECT * FROM alertamasiva  as A INNER JOIN alertamasivadetalle AS AD ON A.id=AD.idMasivo  INNER JOIN cliente AS C ON C.id=AD.idSistema  WHERE  AD.estadoActivo= '1' AND C.nombreSistema = '$nombreSistema' and  AD.idMasivo = '2' and idLocalSistema='$zzcodloc' ";
$resultHosting = mysqli_query($conexion3, $sqlHosting);
if (mysqli_num_rows($resultHosting)) {
    while ($rowHosting = mysqli_fetch_array($resultHosting)) {
        $smsHosting     =   mb_strtoupper($rowHosting["mensajePantalla"], 'UTF-8');
        $estadoActivoHosting   =   $rowHosting["estadoActivo"];
    }
}
// ────────────────────────────────────────────────────────────────────────────────
//TODO:ALERTA HOSTING FIN
// ────────────────────────────────────────────────────────────────────────────────
//////////////////////////////ALERTA MASIVA/////////////////////////////////////
//////////////////////////////ALERTA MASIVA/////////////////////////////////////
//////////////////////////////ALERTA MASIVA/////////////////////////////////////
//////////////////////////////ALERTA MASIVA/////////////////////////////////////
// ────────────────────────────────────────────────────────────────────────────────
//? ALERTA MASIVA INICIO
// ────────────────────────────────────────────────────────────────────────────────

$sqlMasiva = "SELECT * FROM alertamasiva  as A INNER JOIN alertamasivadetalle AS AD ON A.id=AD.idMasivo  INNER JOIN cliente AS C ON C.id=AD.idSistema  WHERE  AD.estadoActivo= '1' AND C.nombreSistema = '$nombreSistema' and  AD.idMasivo = '1'  ";
$resultMasiva = mysqli_query($conexion3, $sqlMasiva);
if (mysqli_num_rows($resultMasiva)) {
    while ($rowMasiva = mysqli_fetch_array($resultMasiva)) {
        $smsMasiva     =   mb_strtoupper($rowMasiva["texto"], 'UTF-8');
        $estadoActivoMasiva   =   $rowMasiva["estadoActivo"];
    }
}
// ────────────────────────────────────────────────────────────────────────────────
//? ALERTA MASIVA FIN
// ────────────────────────────────────────────────────────────────────────────────
