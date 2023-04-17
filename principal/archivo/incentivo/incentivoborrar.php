<?php

include('../../session_user.php');
require_once('../../../conexion.php');

if(!empty($_GET))
{
    // $invnum = $_GET["invnum"];

    // $sql = "SELECT codpro FROM incentivadodet where invnum = '$invnum'";
    // $result = mysqli_query($conexion, $sql);
    // if (mysqli_num_rows($result)) {
    //     while ($row = mysqli_fetch_array($result)) {
    //         $codpro = $row['codpro'];
    //     }
    // }

    

    $sql1 = "UPDATE incentivado SET esta_desa = 1 , estado = 0 WHERE invnum = '$invnum'";
    mysqli_query($conexion, $sql1);

    $sql2 = "UPDATE incentivadodet SET estado = 0 WHERE invnum = '$invnum'";
    mysqli_query($conexion, $sql2);

    // $sql3 = "UPDATE producto SET incentivado = 0 WHERE codpro = '$codpro'";
    // mysqli_query($conexion, $sql3);
}



header("Location: incentivo.php");
exit;

?>