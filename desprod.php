<?php
require_once('conexion.php');
require_once 'convertfecha.php';


$sql = "SELECT codpro,desprod FROM producto  where codpro='6738 ' order by codpro";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codpro    = $row['codpro'];
        $desprod    = $row['desprod'];


        $desprod = remplazar_string($desprod);

        mysqli_query($conexion, "UPDATE producto set desprod = '$desprod' where codpro='$codpro ' ");
    }
}
