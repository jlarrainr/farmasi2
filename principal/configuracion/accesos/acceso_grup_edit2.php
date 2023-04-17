<?php

require_once ('../../../conexion.php');
include('../../session_user.php');
$codgrup = $_REQUEST['codgrup'];
$c = "c";
$x = 1;
$i = 0;
$sql = "SELECT idacceso FROM acceso order by nombre";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $idacceso = $row['idacceso'];
        $y = $c . $idacceso;
        $check = $_REQUEST[$y];
        if ($check == 1) {  ////SI ACTIVO
            $sql1 = "SELECT * FROM detalle_acceso where codgrup = '$codgrup' and idacceso = '$idacceso'";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                //echo $idacceso;
                //echo '<br>';
                //echo "SI - YA ESTA EN LA BASE DE DATOS NO HAGO NADA";
                //echo '<br>';
            } else {
                mysqli_query($conexion, "INSERT INTO detalle_acceso (codgrup,idacceso) values ('$codgrup','$idacceso')");
                //echo $idacceso;
                //echo '<br>';
                //echo "SI - REGISTRO EN LA DATA";
                //echo '<br>';
            }
        } else {
            $sql1 = "SELECT * FROM detalle_acceso where codgrup = '$codgrup' and idacceso = '$idacceso'";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                mysqli_query($conexion, "DELETE FROM detalle_acceso where codgrup = '$codgrup' and idacceso = '$idacceso'");
                //echo $idacceso;
                //echo '<br>';
                //echo "NO - PERO EXISTE EN LA DATA Y ELIMINO DE LA DATA";
                //echo '<br>';
            } else {
                //echo $idacceso;
                //echo '<br>';
                //echo "NO - NO EXISTE EN LA DATA";
                //echo '<br>';
            }
        }
    }
}
Header("Location: acceso_grup_edit1.php?codgrup=$codgrup");
?>