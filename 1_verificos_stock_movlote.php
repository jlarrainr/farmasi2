
<?php

require_once('conexion.php');

$codloc = '4';

$sql2 = "SELECT nomloc FROM xcompa where codloc = '$codloc'";
$result2 = mysqli_query($conexion, $sql2);
if (mysqli_num_rows($result2)) {
    while ($row2 = mysqli_fetch_array($result2)) {
        $nomlocalG = $row2['nomloc'];
    }
}

$numero_xcompa = substr($nomlocalG, 5, 2);
$tabla = "s" . str_pad($numero_xcompa, 3, "0", STR_PAD_LEFT);



$sql1 = "SELECT codpro,$tabla FROM `producto`   ORDER by codpro ";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $codpro_p = $row1['codpro'];
        $stock_p = $row1[1];




        $sql13 = "SELECT  SUM(stock) as suma,idlote FROM movlote WHERE   codloc='$codloc' and stock>0  and codpro='$codpro_p'  ORDER by codpro   ";
        $result13 = mysqli_query($conexion, $sql13);
        if (mysqli_num_rows($result13)) {
            while ($row13 = mysqli_fetch_array($result13)) {
                //$codpro_lote = $row13[0];
                $suma_lote = $row13['suma'];
                $idlote = $row13['idlote'];

                $sql13 = "SELECT    COUNT(stock) FROM movlote WHERE   codloc='$codloc' and stock>0 and codpro='$codpro_p'  ORDER by codpro   ";
                $result13 = mysqli_query($conexion, $sql13);
                if (mysqli_num_rows($result13)) {
                    while ($row13 = mysqli_fetch_array($result13)) {
                        $count_lote = $row13[0];
                    }
                }

                if( ($suma_lote <> $stock_p)&&($suma_lote <>'')) {
                    if ($count_lote == 1) {
                         echo 'son diferentes 1111111= ' . $codpro_p.' //////// / $idlote = '  . $idlote.' //////// / $stock_p = ' . $stock_p . ' ////////  $suma_lote = ' . $suma_lote . ' //////// $count_lote = ' . $count_lote . "<br>";
                    
                       // mysqli_query($conexion, "UPDATE movlote set stock = '$stock_p' where codpro = '$codpro_p' and idlote = '$idlote' and codloc= '$codloc'");
                    }elseif ($count_lote == 2){
                       echo 'son diferentes 22222222222= ' . $codpro_p.' //////// / $idlote = '  . $idlote.' //////// / $stock_p = ' . $stock_p . ' ////////  $suma_lote = ' . $suma_lote . ' //////// $count_lote = ' . $count_lote . "<br>";  
                    }elseif ($count_lote == 0)  {
                         echo 'son diferentes 00000000000= ' . $codpro_p.' //////// / $idlote = '  . $idlote.' //////// / $stock_p = ' . $stock_p . ' ////////  $suma_lote = ' . $suma_lote . ' //////// $count_lote = ' . $count_lote . "<br>";  
                  
                           $numlote = 'LI' .$codpro_p . 'L' . $codloc;
                            $vencimi = '07/2021';



                            //mysqli_query($conexion, "INSERT INTO movlote (codpro,numlote,vencim,stock, codloc) values ('$codpro_p ','$numlote','$vencimi','$stock_p', '$codloc')");
                    }else{
                     echo 'son diferentes xxxxxxxxxx = ' . $codpro_p.' //////// / $idlote = '  . $idlote.' //////// / $stock_p = ' . $stock_p . ' ////////  $suma_lote = ' . $suma_lote . ' //////// $count_lote = ' . $count_lote . "<br>";  
                    }
                }  
            }
        }else{
            echo 'no hay'.$codpro_p."<br>";
        }
    }
}
