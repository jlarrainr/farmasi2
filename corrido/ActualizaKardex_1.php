<?php
require_once('conexion.php');
$sqlX= "SELECT codpro FROM kardex GROUP BY codpro";
$resultX = mysqli_query($conexion,$sqlX);	
if (mysqli_num_rows($resultX))
{
    
    while ($rowX = mysqli_fetch_array($resultX))
    {
        $codpro   = $rowX['codpro'];
        $sqlXY= "SELECT s000,s001,s002,s003,s004,s005,s006,s007,s008,s009,s010,s011,s012,s013,s014,s015,s016
            from producto where codpro = '$codpro'";
        $resultXY = mysqli_query($conexion,$sqlXY);	
        if (mysqli_num_rows($resultXY))
        {
            while ($rowXY = mysqli_fetch_array($resultXY)){
                //$SumTotal = 0;
                $s000   = $rowXY['s000'];
                $s001   = $rowXY['s001'];
                $s002   = $rowXY['s002'];
                $s003   = $rowXY['s003'];
                $s004   = $rowXY['s004'];
                $s005   = $rowXY['s005'];
                $s006   = $rowXY['s006'];
                $s007   = $rowXY['s007'];
                $s008   = $rowXY['s008'];
                $s009   = $rowXY['s009'];
                $s010   = $rowXY['s010'];
                $s011   = $rowXY['s011'];
                $s012   = $rowXY['s012'];
                $s013   = $rowXY['s013'];
                $s014   = $rowXY['s014'];
                $s015   = $rowXY['s015'];
                $s016   = $rowXY['s016'];
                $SumTotal = $s000 + $s001 + $s002 + $s003 + $s004 + $s005 + $s006 + $s007 + $s008 + $s009 + $s010 + $s011 + $s012 + $s013 + $s014 + $s015 + $s016;
                mysqli_query($conexion,"UPDATE producto set stopro = '$SumTotal' where codpro = '$codpro'");
            }
        }
    }
}
?>
