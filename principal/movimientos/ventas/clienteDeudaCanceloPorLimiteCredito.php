<?php
require_once('../../session_user.php');
$venta = $_SESSION['venta'];
require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS



$sql = "SELECT * FROM cliente where descli like '%PUBLICO EN GENERAL%'";
//error_log($sql);
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codcli = $row["codcli"];
        $descli = $row["descli"];
        $dnicli = $row["dnicli"];
        mysqli_query($conexion, "UPDATE venta set cuscod = '$codcli',forpag='E',numeroCuota='0', ventaDiasCuotas='0' where invnum = '$venta'");

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
    }
}
?>
<script>
    location.href = 'venta_index2.php';
</script>