<?php
require_once('conexion.php');
function convertir_a_numero($str)
{
	  $legalChars = "%[^0-9\-\. ]%";
	  $str=preg_replace($legalChars,"",$str);
	  return $str;
}

///1- CONSULTAR LA TABLA MOVMOV
///2- CONSULTAR LA TABLA KARDEX
///3- SI NO COINCIDEN LOS MONTOS GENERALES PROCEDER A ACTUALIZAR

$sql = "SELECT qtypro, qtyprf, pripro, costre, movmae.tipmov, movmae.tipdoc, movmae.invnum, codpro
        FROM movmov
        INNER JOIN movmae ON movmae.invnum = movmov.invnum
        ORDER BY movmae.invnum";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)) {
while ($row = mysqli_fetch_array($result)) 
{
        $qtypro    = $row['qtypro'];
        $qtyprf    = $row['qtyprf'];
        $pripro    = $row['pripro'];
        $costre    = $row['costre'];
        $tipmov    = $row['tipmov'];
        $tipdoc    = $row['tipdoc'];
        //$fecha     = $row['invfec'];
        $invnum    = $row['invnum'];
        $codpro    = $row['codpro'];
        $factor    = 0;
        if ($qtyprf <> "")
        {
            //CONSULTO EL KARDEX PARA ENCONTRAR EL FACTOR
            $sqlx = "SELECT factor
                    FROM kardex
                    where tipmov= '$tipmov' and tipdoc= '$tipdoc' and codpro = '$codpro' and invnum = '$invnum'
                    ";
            $resultx = mysqli_query($conexion,$sqlx);
            if (mysqli_num_rows($resultx)) {
            while ($rowx = mysqli_fetch_array($resultx)) 
            {
                $factor    = $rowx['factor'];
            }
            }
            $text_char =  convertir_a_numero($qtyprf);
            $cant_unid = $text_char/$factor;
        }
        else
        {
            $cant_unid = $qtypro;
        }
        $Mont_RecaudadoX = $cant_unid * $pripro;
        $Mont_Recaudado = number_format($Mont_RecaudadoX,2,'.','');
        if ($costre <> $Mont_Recaudado)
        {
            echo 'COD='.$invnum.' - CODPRO='.$codpro.' - TIPMOV='.$tipmov.' - TIPDOC='.$tipdoc.' - CANT CAJ='.$qtypro.' - CANT UNID='.$qtyprf.' - FACTOR='.$factor.' - PRECIO='.$pripro.' - MONTO CALC='.$Mont_Recaudado.' - MONTO SIST.'.$costre;
            //echo ''.$invnum.','.$codpro.','.$tipmov.','.$tipdoc.','.$qtypro.','.$qtyprf.','.$factor.','.$pripro.','.$Mont_Recaudado.','.$costre;
            mysqli_query($conexion,"UPDATE movmov set costre  = '$Mont_Recaudado' where invnum = '$invnum' and codpro = '$codpro' and qtypro = '$qtypro' and qtyprf = '$qtyprf' and pripro = '$pripro'");
            //echo "<br>";
            //echo $sql;
            echo "<br>";
            
        }
}
}
?>
