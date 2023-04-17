<?php
require_once('../conexion.php');


//yyyy-mm-dd
$nuevaFecha='2021-12-30';
//yyyy-mm-dd

//select de datos
$date1  ='2021-12-29';

$date2  ='2021-12-29';

$tipdoc ='4';

$sucursal='1';
//select de datos


$sql1 = "SELECT invnum FROM venta WHERE invfec BETWEEN '$date1' and  '$date2'  and estado='0' and tipdoc='$tipdoc'  and sucursal='$sucursal' ";
        $result1 = mysqli_query($conexion, $sql1);
        if (mysqli_num_rows($result1)) {
            while ($row1 = mysqli_fetch_array($result1)) {
                $invnum = $row1['invnum'];
                 
                 
                 
                 
            $sql_venta = "UPDATE venta set invfec  = '$nuevaFecha'   where invnum = '$invnum'";
            mysqli_query($conexion, $sql_venta);
            
            $sql_D_venta = "UPDATE detalle_venta set invfec  = '$nuevaFecha'   where invnum = '$invnum'";
            mysqli_query($conexion, $sql_D_venta);
            
            $sql_D_venta = "UPDATE kardex set fecha  = '$nuevaFecha'   where invnum = '$invnum' and tipmov='9' and tipdoc='9' ";
            mysqli_query($conexion, $sql_D_venta);
            
        
            }
        }