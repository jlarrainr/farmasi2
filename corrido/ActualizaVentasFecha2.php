<?php
require_once('conexion.php');
$sql= "SELECT invnum,hora,invfec FROM venta2 where invnum <= 1681 order by invnum";
$result = mysqli_query($conexion,$sql);	
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    $invnum = $row['invnum'];
    $Hora   = $row['hora'];
    $Invfec = $row['invfec'];
    /*$sqlx= "SELECT invnum,hora,invfec FROM venta where invnum = $invnum order by invnum";
    $resultx = mysqli_query($conexion,$sqlx);	
    if (mysqli_num_rows($resultx)){
    while ($rowx = mysqli_fetch_array($resultx)){
        $invnumX = $rowx['invnum'];
        //$HoraX   = $rowx['hora'];
        //$InvfecX = $rowx['invfec'];
    }
    }*/
    mysqli_query($conexion,"UPDATE venta set hora = '$Hora',invfec = '$Invfec' where invnum = '$invnum'");
    //echo $invnum." - ".$Invfec." - ".$InvfecX." - ".$Hora." - ".$HoraX."<br>";
}
}
?>
