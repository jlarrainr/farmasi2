
<?php

require_once('conexion.php');

$sql1 = "SELECT codpro,SUM(stock) as suma ,codloc FROM movlote WHERE stock <>0 GROUP BY codpro,codloc ORDER by codpro ";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $codpro = $row1['codpro'];
        $suma_lote = $row1['suma'];
        $codloc = $row1['codloc'];


        $sql2 = "SELECT nomloc FROM xcompa where codloc = '$codloc'";
        $result2 = mysqli_query($conexion, $sql2);
        if (mysqli_num_rows($result2)) {
            while ($row2 = mysqli_fetch_array($result2)) {
                $nomlocalG = $row2['nomloc'];
            }
        }

        $numero_xcompa = substr($nomlocalG, 5, 2);
        $tabla = "s" . str_pad($numero_xcompa, 3, "0", STR_PAD_LEFT);


        $sql13 = "SELECT  $tabla FROM producto WHERE codpro='$codpro' ";
        $result13 = mysqli_query($conexion, $sql13);
        if (mysqli_num_rows($result13)) {
            while ($row13 = mysqli_fetch_array($result13)) {
                $stock_p = $row13[0];
                //  if($suma_lote<> $stock_p ){
                echo ' $codpro = ' . $codpro . ' =  $suma_lote = ' . $suma_lote . ' $stock_p = ' . $stock_p . ' $codloc = ' . $codloc . "<br>";

                echo "-----------------" . "<br>";
                //}
            }
        }
    }
}
