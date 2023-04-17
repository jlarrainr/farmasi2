<?php

require_once("../../conexion.php");
include('../session_user.php');
$codnuevo = $_REQUEST['codnuevo'];
$codbar = $_REQUEST['codbar'];


if (($codbar <> "") && ($codnuevo <> "")) {
    // echo $codbar . "--" . $codnuevo;
    $sql = "SELECT codpro FROM producto WHERE codbar like '$codbar%'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row  = mysqli_fetch_array($result)) {
            $codpro_obtengo        = $row[0];
        }
        // echo $codpro_obtengo . " + " . $codnuevo;

        if ($codpro_obtengo == $codnuevo) {
            echo '<a style="color:red;">Es el Mismo Producto con el Mismo Codigo de Barras.</a>';
        } else {
            echo '<a style="color:red;">Ya Existe un Producto con el Mismo Codigo de Barras.</a>';
        }
    } else {
        echo '<a style="color:blue;">Codigo de Barras Disponible</a>';
    }
}
