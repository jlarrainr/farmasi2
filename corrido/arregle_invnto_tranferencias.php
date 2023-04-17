
<?php
require_once('conexion.php');
function convertir_a_numero($str)
{
    $legalChars = "%[^0-9\-\. ]%";
    return preg_replace($legalChars, "", $str);
}
// tranferencia de sucuarsal
// $variable = "and tipmov='2' and tipdoc='3'";
$sql = "SELECT invnum FROM `movmae` WHERE proceso='0' and tipmov='2' and tipdoc='3'  ORDER by invnum";
// $sql = "SELECT invnum,igv  FROM venta WHERE  estado=0 ORDER BY invnum ";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $invnum_movmae = $row['invnum'];


        //$venta = '17761';
        $n_invtot = 0;
        $sumatoria = 0;
        $cantidad = 0;
        $pripro_movmov = 0;



        $sqlDetTot = "SELECT codpro,qtypro,qtyprf,pripro FROM `movmov` WHERE invnum='$invnum_movmae'  ";
        $resultDetTot = mysqli_query($conexion, $sqlDetTot);
        if (mysqli_num_rows($resultDetTot)) {
            while ($row = mysqli_fetch_array($resultDetTot)) {
                $i++;
                $igvVTADet = 0;
                $codpro_movmov = $row['codpro'];
                $qtypro_movmov = $row['qtypro'];
                $qtyprf_movmov = $row['qtyprf'];
                $pripro_movmov = $row['pripro'];

                if ($qtyprf_movmov <> '') {

                    $cantidad = convertir_a_numero($qtyprf_movmov);
                } else {
                    $cantidad = $qtypro_movmov;
                }


                $n_invtot = $cantidad * $pripro_movmov;
                $sumatoria += $n_invtot;
            }
        }




        $sumatoria = round($sumatoria, 2);






        // $sql1 = "UPDATE movmae set invtot  = '$sumatoria', monto = '$sumatoria'  where invnum = '$invnum_movmae'";
        //mysqli_query($conexion, $sql1);




        echo  '----------------------------' . "<br>";
        echo  '$invnum_movmae          = ' . $invnum_movmae . "<br>";
        echo  '$sumatoria          = ' . $sumatoria . "<br>";
    }
}
