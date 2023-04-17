<?php
require_once('conexion.php');
$usuario = isset($_REQUEST['usu']) ? ($_REQUEST['usu']) : "";
// $suma = 0;
$sql = "SELECT ingreso2 FROM usuario where ingreso = 1 and usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $ingreso2 = $row['ingreso2'];
        $existe = 1;
        $suma = $ingreso2 + 1;
        if ($ingreso2 >= 3) {
            mysqli_query($conexion, "UPDATE usuario set ingreso = '0',ingreso2='0' where usecod = '$usuario'");
        } else {
            mysqli_query($conexion, "UPDATE usuario set ingreso = '0',ingreso2='$suma' where usecod = '$usuario'");
        }
    }
} else {
    $existe = 0;
}

if ($existe == 1) {

    session_start();
    $_SESSION = array();
    session_destroy();
    header("Location: index.php");
    // header("Location: principal/index.php?entra=1");
}
