<?php 
require_once('../../session_user.php');
require_once('../../../conexion.php');

$venta                  = $_SESSION['venta'];
$date                   = date("Y-m-d");
$t1                     = $_REQUEST['t1'];	////CANTIDAD
$t2                     = $_REQUEST['t22'];	////PRECIO
$t3                     = $_REQUEST['t33'];	////SUBTOTAL
$number                 = $_REQUEST['number'];	////SI ES NUMERO O NO
$factor                 = $_REQUEST['factor'];
$codpro                 = $_REQUEST['codpro'];	/////CODIGO DE LA RELACION ENTRE LOCAL Y PRODUCTO
$codtemp                = $_REQUEST['codtemp'];

require_once('funciones_temp/datos_generales.php'); //////CODIGO Y NOMBRE DEL LOCAL

$cantventaparabonificar = "";
$codprobonif            = "";
$cantbonificable        = "";

/////FUNCION PARA CONVERTIR CADENA A NUMERO
function convertir_a_numero($str)
{
    $legalChars = "%[^0-9\-\. ]%";
    return preg_replace($legalChars,"",$str);
}	

///////////ACTUALIZO LA DATA HASTA ANTES DE HACER LA OPERACION
//$sqlTV="SELECT canpro,fraccion FROM temp_venta where codtemp = '$codtemp'";
$sqlTV="SELECT canpro,fraccion FROM detalle_venta2 where codtemp = '$codtemp'";
$resultTV = mysqli_query($conexion,$sqlTV);
if (mysqli_num_rows($resultTV)){
    while ($row = mysqli_fetch_array($resultTV))
    {
        $canpro         = $row['canpro'];		////GENERAL
        $fraccion       = $row['fraccion'];
    }
}

$sqlPRODT       = "SELECT $tabla FROM producto where codpro = '$codpro'";
$resultPRODT    = mysqli_query($conexion,$sqlPRODT);
if (mysqli_num_rows($resultPRODT)){
    while ($row = mysqli_fetch_array($resultPRODT))
    {
        $cant_prod      = $row[0];
    }
}

/*if ($fraccion == "F")						////INGRESO DE CAJAS
{	
    $canpro 	    = convertir_a_numero($canpro) * $factor;	////CANTIDAD A SUMAR EN UNIDADES
    $total_general  = $stopro + $canpro;
    $total_local    = $cant_loc + $canpro;
}
else
{
    $total_general  = $stopro + $canpro;
    $total_local    = $cant_loc + $canpro;
}*/

////NO ES NUMERO - ESTOY INGRESANDO CAJAS --- LETRA C
if ($number == 1)					
{
    $t1 		= convertir_a_numero($t1);
    $caja_bonifi        = $t1;		/////CAJAS QUE DESEO VENDER
    $cantreal 		= $t1;
    $t1 		= $t1 * $factor;
    $cantidades         = $t1;
    $tt 		= 1;
}
else
{
    $cantidades         = $t1;
}


if ($cantidades <> 0)
{
    if ($cantidades > $cant_prod) ////NO HAY STOCK PARA ESTE PRODUCTO
    {
        $agotado        = $cantidades - $cant_prod;
        $agot           = 1;

    }
    else /////HAY STOCK PARA ESTE PRODUCTO
    {
        $agot = 0;
    }
    
    $sql="SELECT codpro,stopro,codmar,costpr,codmar,codfam,coduso,$tabla,cantventaparabonificar,codprobonif,cantbonificable,factor FROM producto where codpro = '$codpro'";
    $result = mysqli_query($conexion,$sql);
    if (mysqli_num_rows($result)){
    while ($row = mysqli_fetch_array($result)){
        $codpro                 = $row['codpro'];
        $stopro                 = $row['stopro'];
        $codmar                 = $row['codmar'];
        $costpr                 = $row['costpr'];
        $codfam                 = $row['codfam'];
        $coduso                 = $row['coduso'];
        $factor                 = $row['factor'];
        $cant_loc               = $row[7];
        $cantventaparabonificar = $row['cantventaparabonificar'];
        $codprobonif            = $row['codprobonif'];
        $cantbonificable        = $row['cantbonificable'];
        if (($codprobonif <> 0) || ($codprobonif <> ""))
        {
            if (!is_numeric($cantventaparabonificar))
            {
                $cantventaparabonificar = convertir_a_numero($cantventaparabonificar) * $factor;
            }
        }

    }
    }
    //ES CAJAS
    if ($number == 1)					
    {
    }
    else
    {
        //FRACCION
        if ($factor > 1)
        {
            $costpr = $costpr/$factor;
        }
    }
    
    if ($agot == 0) /////HAY STOCK PARA ESTE PRODUCTO
    {
        if ($number == 1) ///// NO ES NUMERO ES UNA LETRA 
        {
            $permitido       = $cantreal;
            $strFactor       = "F";
        }
        else
        {
            $permitido       = $cantidades;
            $strFactor       = "T";
            $pcostouni       = $pcostouni/($factor * $cantidades);
        }
        
        $total_local        = $cant_loc - $cantidades;
        $total_general      = $stopro - $cantidades;
    }
    else
    {
        $permitido          = $cant_loc;
        $strFactor          = "T";
        $pc                 = ($t2*$cant_loc)/$factor;
        if ($cant_loc <> 0)
        {
            $pcunit         = $pc/$cant_loc;
        }
        else
        {
            $pcunit         = 0;
        }
        $total_local        = $cant_loc - $cant_loc;
        $total_general      = $stopro - $cant_loc;
        $ppc                = $agotado * $pcunit;
    }
    
    if (($cantidades <> "") || ($cantidades <> 0))
    {
        //ES NUMERO -> T
        if ($cant_prod <> 0)
        {
            //mysqli_query($conexion, "UPDATE temp_venta set canpro = '$permitido',fraccion = '$strFactor',prisal = '$t2',pripro = '$t3', costpr = '$costpr' where codtemp = '$codtemp'");
            mysqli_query($conexion, "UPDATE detalle_venta2 set canpro = '$permitido',fraccion = '$strFactor',prisal = '$t2',pripro = '$t3', costpr = '$costpr' where codtemp = '$codtemp'");
            //BONIFICADO****************************************
            //PERMITIDO ES LA CANTIDAD
            if (strlen($codprobonif)>0)
            {
                if ($permitido >= $cantventaparabonificar)
                {
                    //INSERTA UN DETALLE PARA BONIFICADO
                    $sqlB="SELECT codpro,stopro,$tabla,factor,codmar FROM producto where codpro = '$codprobonif'";
                    $resultB = mysqli_query($conexion,$sqlB);
                    if (mysqli_num_rows($resultB)){
                    while ($rowB = mysqli_fetch_array($resultB)){
                        $codproB                = $rowB['codpro'];
                        $stoproB                = $rowB['stopro'];	
                        $cant_locB              = $rowB[2];
                        $factorB                = $rowB['factor'];
                        $codmarB                = $rowB['codmar'];
                        if (!is_numeric($cantbonificable))
                        {
                            $cantbonificable        = convertir_a_numero($cantbonificable) * $factorB;
                        }

                        //SI HAY STOCK PARA LA BONIFICACION
                        if ($cantbonificable <= $cant_locB)
                        {
                            $cantDescontar = $cant_locB - $cantbonificable;
                            
                            //mysqli_query($conexion,"INSERT INTO temp_venta (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr,bonif2) values ('$venta','$date','$cuscod','$usuario','$codprobonif','$cantbonificable','T','$factorB','0','0','$codmarB','0','0','1')");
                            mysqli_query($conexion,"INSERT INTO detalle_venta2 (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr,bonif2) values ('$venta','$date','$cuscod','$usuario','$codprobonif','$cantbonificable','T','$factorB','0','0','$codmarB','0','0','1')");
                        }
                    }
                    }
                }
            }
        }
    }
    
    
    
    
}

mysqli_close($conexion);
header("Location: venta_index_t2.php");
?>