<?php

require_once('../../../session_user.php');
$venta = $_SESSION['venta'];
require_once ('../../../../conexion.php');
require_once ('../../../../convertfecha.php');

$nom = $_REQUEST['nom'];
$dni = $_REQUEST['dni'];
$ruc = $_REQUEST['ruc'];
$fono = $_REQUEST['fono'];
$fono1 = $_REQUEST['fono1'];
$mail = $_REQUEST['mail'];
$direc = $_REQUEST['direc'];
$departamento = $_POST['departamento'];
$provincia = $_POST['provincia'];
$distrito = $_POST['distrito'];
//$limiteCredito = $_POST['limiteCredito'];

$nom=remplazar_string($nom);
$direc=remplazar_string($direc);

if ($dni <> '') {
    $filtrante = $dni;
    $campo = 'dnicli';
    $error = '1';
} else {
    $filtrante = $ruc;
    $campo = 'ruccli';
    $error = '2';
}

$sql1 = "SELECT codcli FROM cliente order by codcli desc limit 1";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $codcli = $row1['codcli'];
    }
    ++$codcli;
} else {
    $codcli = 1;
}

$sql = "SELECT * FROM cliente where $campo = '$filtrante'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {

    header("Location: f2.php?error=$error");
} else {

    //mysqli_query($conexion, "INSERT INTO cliente (codcli,descli,dnicli,ruccli,telcli,telcli1,email,codusu,dircli,dptcli,procli,discli,limiteCredito) values ('$codcli','$nom','$dni','$ruc','$fono','$fono1','$mail','$usuario','$direc','$departamento','$provincia','$distrito','$limiteCredito')");
    mysqli_query($conexion, "INSERT INTO cliente (codcli,descli,dnicli,ruccli,telcli,telcli1,email,codusu,dircli,dptcli,procli,discli) values ('$codcli','$nom','$dni','$ruc','$fono','$fono1','$mail','$usuario','$direc','$departamento','$provincia','$distrito')");
    mysqli_query($conexion, "UPDATE venta set cuscod = '$codcli' where invnum = '$venta'");

    if (isset($_SESSION['arr_detalle_venta'])) {
        $arr_detalle_venta = $_SESSION['arr_detalle_venta'];
    } else {
        $arr_detalle_venta = array();
    }
    $arrAux = array();
    foreach ($arr_detalle_venta as $detalle) {
        $detalle['cuscod'] = $codcli;
        $arrAux[] = $detalle;
    }
    $_SESSION['arr_detalle_venta'] = $arrAux;

    header("Location: f2.php?close=2");
}
?>