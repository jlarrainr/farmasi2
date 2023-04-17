<?php include('../../session_user.php');
require_once('../../../conexion.php');
$p1       = $_REQUEST['p1'];
$p2       = $_REQUEST['p2'];
$codpro   = $_REQUEST['codpro'];
$val      = $_REQUEST['val'];
$search   = $_REQUEST['search'];
$factor   = $_REQUEST['factor'];
$margene1   = $_REQUEST['margene1'];
/*if ($factor == 1)
{
$p3		  = $p2; 
}
else
{*/
$p3       = $_REQUEST['p3'];

	    $sqlP="SELECT Preciovtacostopro FROM datagen";
        $resultP = mysqli_query($conexion,$sqlP);
        if (mysqli_num_rows($resultP))
        {
        while ($row = mysqli_fetch_array($resultP))
        {
            $tipocosto= $row['Preciovtacostopro'];
        }
        }
        // tipocosto=1 costo promedio (costpr), 0=costre
        if ( $tipocosto=1)
        {
            $campo='costpr';

                }
        else
        {
            $campo='costre';

        }

//}
//mysqli_query($conexion,"UPDATE producto set pcostouni = '$p1', prevta = '$p2',preuni = '$p3' where codpro = '$codpro'");
mysqli_query($conexion,"UPDATE producto set $campo= '$p1', prevta = '$p2',preuni = '$p3', margene = '$margene1' where codpro = '$codpro'");
header("Location: precios2.php?search=$search&val=$val");
?>