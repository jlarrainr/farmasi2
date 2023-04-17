<?php

require_once('conexion.php');
$sql = "SELECT incentivado.invnum,dateini,datefin,codpro 
	FROM incentivado 
    inner join incentivadodet on incentivado.invnum = incentivadodet.invnum 
	where incentivado.estado = '1'
    order by incentivado.invnum";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $invnumIncentivo = $row['invnum'];
        $dateini = $row['dateini'];
        $datefin = $row['datefin'];
        $codpro = $row['codpro'];
        $sqlX = "SELECT invnum FROM detalle_venta where codpro = $codpro and invfec between '$dateini' and '$datefin'";
        $resultX = mysqli_query($conexion, $sqlX);
        if (mysqli_num_rows($resultX)) {
            while ($rowX = mysqli_fetch_array($resultX)) {
                $invnum = $rowX['invnum'];
                mysqli_query($conexion, "UPDATE detalle_venta set incentivo = '$invnumIncentivo' where invnum = '$invnum'");
            }
        }
    }
}
echo "Se finalizó el script";
?>
