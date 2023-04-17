<?php
require_once('../conexion.php');
function convertir_a_numero($str)
{
	  $legalChars = "%[^0-9\-\. ]%";
	  return preg_replace($legalChars,"",$str);
}

$sucursalFinal = '6';
$codProFinal = '3072';
$startDate = '2023-03-01';
$endDate = '2023-03-01';

$sql= "SELECT codpro,sucursal FROM kardex where sucursal = '$sucursalFinal' and codpro='$codProFinal' GROUP BY codpro,sucursal ORDER BY sucursal,codpro";
$result = mysqli_query($conexion,$sql);	
if (mysqli_num_rows($result))
{
    while ($row = mysqli_fetch_array($result)){
        $codpro   = $row['codpro'];
        $sucursal = $row['sucursal'];
        $i           = 0;
        $saldoactual = 0;
        $sactual     = 0;
        $sqlXY= "SELECT nomloc from xcompa where codloc = $sucursal";
        $resultXY = mysqli_query($conexion,$sqlXY);	
        if (mysqli_num_rows($resultXY))
        {
            while ($rowXY = mysqli_fetch_array($resultXY)){
                $nomloc   = $rowXY['nomloc'];
            }
            
            if ($nomloc == "LOCAL0")
            {
                $tabla = 's000';
            }
            if ($nomloc == "LOCAL1")
            {
                $tabla = 's001';
            }
            if ($nomloc == "LOCAL2")
            {
                $tabla = 's002';
            }
            if ($nomloc == "LOCAL3")
            {
                $tabla = 's003';
            }
            if ($nomloc == "LOCAL4")
            {
                $tabla = 's004';
            }
            if ($nomloc == "LOCAL5")
            {
                $tabla = 's005';
            }
            if ($nomloc == "LOCAL6")
            {
                $tabla = 's006';
            }
            if ($nomloc == "LOCAL7")
            {
                $tabla = 's007';
            }
            if ($nomloc == "LOCAL8")
            {
                $tabla = 's008';
            }
            if ($nomloc == "LOCAL9")
            {
                $tabla = 's009';
            }
            if ($nomloc == "LOCAL10")
            {
                $tabla = 's010';
            }
            if ($nomloc == "LOCAL11")
            {
                $tabla = 's011';
            }
            if ($nomloc == "LOCAL12")
            {
                $tabla = 's012';
            }
            if ($nomloc == "LOCAL13")
            {
                $tabla = 's013';
            }
            if ($nomloc == "LOCAL14")
            {
                $tabla = 's014';
            }
            if ($nomloc == "LOCAL15")
            {
                $tabla = 's015';
            }
            if ($nomloc == "LOCAL16")
            {
                $tabla = 's016';
            }
            if ($nomloc == "LOCAL17")
            {
                $tabla = 's017';
            }
            if ($nomloc == "LOCAL18")
            {
                $tabla = 's018';
            }
            if ($nomloc == "LOCAL19")
            {
                $tabla = 's019';
            }
            if ($nomloc == "LOCAL20")
            {
                $tabla = 's020';
            }
        }
       // $tabla = call_tabla($nomloc);
        $sqlX= "SELECT codkard,tipmov,eliminado,tipdoc,qtypro,fraccion,factor,sactual 
                FROM kardex where fecha between '$startDate' and '$endDate' and codpro = $codpro and sucursal = $sucursal ORDER BY fecha, codkard";
        $resultX = mysqli_query($conexion,$sqlX);	
        if (mysqli_num_rows($resultX))
        {
            while ($rowX = mysqli_fetch_array($resultX)){
                $i++;
                $codkard   = $rowX['codkard'];
                $tipmov    = $rowX['tipmov'];
		$tipdoc    = $rowX['tipdoc'];
		$qtypro    = $rowX['qtypro'];
		$fraccion  = $rowX['fraccion'];
		$factor    = $rowX['factor'];
		$sactual   = $rowX['sactual'];
		$eliminado   = $rowX['eliminado'];
                //INGRESOS
                if ($tipmov == 1)
		{
                    $sig   = 'mas';
		}
                //SALIDAS
		if ($tipmov == 2)
		{
                    $sig   = 'menos';
		}
		
		
                
            if (($tipmov == 9) && ($tipdoc == 9) && ($eliminado == 0))
			{
				$sig   	 = 'menos';
			}
			if (($tipmov == 10) && ($tipdoc == 9) && ($eliminado == 0))
			{
				$sig   = 'mas';
			}
			if (($tipmov == 10) && ($tipdoc == 10) && ($eliminado == 0))
			{
				$sig   	 = 'menos';
			}
			if (($tipmov == 11) && ($tipdoc == 11) && ($eliminado == 0))
			{
				$sig   = 'mas';
			}
			if (($tipmov == 9) && ($tipdoc == 11) && ($eliminado == 0))
			{
				$sig   	 = 'menos';
			}
                          /////////desde aqui
                        
			if (($tipmov == 1) && ($tipdoc == 1) && ($eliminado == 0))
			{
				$sig   	 = 'mas';
			}
                        
                      
			if (($tipmov == 1) && ($tipdoc == 2) && ($eliminado == 0))
			{
				$sig   	 = 'mas';
			}
			if (($tipmov == 1) && ($tipdoc == 2) && ($eliminado == 0))
			{
				$sig   	 = 'mas';
			}
			if (($tipmov == 1) && ($tipdoc == 3) && ($eliminado == 0))
			{
				$sig   	 = 'mas';
			}
			if (($tipmov == 1) && ($tipdoc == 4) && ($eliminado == 0))
			{
				$sig   	 = 'mas';
			}
			if (($tipmov == 1) && ($tipdoc == 5) && ($eliminado == 0))
			{
				$sig   	 = 'mas';
			}
			if (($tipmov == 2) && ($tipdoc == 1) && ($eliminado == 0))
			{
				$sig   	 = 'menos';
			}
		    if (($tipmov == 1) && ($tipdoc == 1) && ($eliminado == 2))
			{
				$sig   	 = 'menos';
			}
			if (($tipmov == 2) && ($tipdoc == 2) && ($eliminado == 0))
			{
				$sig   	 = 'menos';
			}
			if (($tipmov == 2) && ($tipdoc == 3) && ($eliminado == 0))
			{
				$sig   	 = 'menos';
			}
			if (($tipmov == 2) && ($tipdoc == 4) && ($eliminado == 0))
			{
				$sig   	 = 'menos';
			}
			if (($tipmov == 2) && ($tipdoc == 5) && ($eliminado == 0))
			{
				$sig   	 = 'menos';
			}
			if (($tipmov == 1) && ($tipdoc == 1) && ($eliminado == 1))
			{
				$sig   	 = 'menos';
			}
			if (($tipmov == 1) && ($tipdoc == 5) && ($eliminado == 1))
			{
				$sig   	 = 'menos';
			}
			if (($tipmov == 1) && ($tipdoc == 1) && ($eliminado == 3))
			{
				$sig   	 = 'mas';
			}
			if (($tipmov == 1) && ($tipdoc == 5) && ($eliminado == 3))
			{
				$sig   	 = 'mas';
			}
			if (($tipmov == 2) && ($tipdoc == 1) && ($eliminado == 1))
			{
				$sig   	 = 'mas';
			}
			if (($tipmov == 2) && ($tipdoc == 3) && ($eliminado == 1))
			{
				$sig   	 = 'mas';
			}
		
		
		
		
		
                
                if ($factor == 1)
		{
                    if ($qtypro <> "")
                    {
                        $cant      = $qtypro;
                        $descuenta = $cant * $factor;
                        $car       = $descuenta;
                    }
                    if ($fraccion <> "")
                    {
                        $cant      = convertir_a_numero($fraccion);
                        $descuenta = $cant;
                        $car       = $descuenta;
                    }
		}
		else
		{
                    if ($qtypro <> "")
                    {
                        $cant      = $qtypro;
                        $descuenta = $cant * $factor;
                        $car       = $descuenta;
                    }
                    if ($fraccion <> "")
                    {
                        $cant      = convertir_a_numero($fraccion);
                        $descuenta = $cant;
                        $car       = $descuenta;
                    }
		}
                
                if ($sig == 'mas')
		{
                    //LO CORRO CUANDO ES PRIMERA CORRIDA
                    if ($i == 1)
                    {
                        //SI ES EL PRIMER REGISTRO COO EL SACTUAL Y A PARTIR DE AQUI ARMO LA DATA
                        $saldoactual = $car + $sactual;
                    }
                    else
                    {
                        //ACTUALIZO EL SACTUAL DEL KARDEX Y LUEGO SUMO LA CANTIDAD
                       mysqli_query($conexion,"UPDATE kardex set sactual = '$saldoactual' where codkard = '$codkard'");
                        $saldoactual = $saldoactual + $car;
                    }
		}
		else
		{
                    //LO CORRO CUANDO ES PRIMERA CORRIDA
                    if ($i == 1)
                    {
                        //SI ES EL PRIMER REGISTRO COO EL SACTUAL Y A PARTIR DE AHY ARMO LA DATA
                        $saldoactual = $sactual - $car;
                    }
                    else
                    {
                        //ACTUALIZO EL SACTUAL DEL KARDEX Y LUEGO SUMO LA CANTIDAD
                        mysqli_query($conexion,"UPDATE kardex set sactual = '$saldoactual' where codkard = '$codkard'");
                        $saldoactual = $saldoactual - $car;
                    }
		}
            }
            
            //echo $tabla.$saldoactual;
            mysqli_query($conexion,"UPDATE producto set $tabla = '$saldoactual' where codpro = '$codpro'");
        }
    }
}
$sqlP= "SELECT s000,s001,s002,s003,s004,s005,s006,s007,s008,s009,s010,s011,s012,s013,s014,s015,s016,s017,s018,s019,s020,codpro,stoini FROM producto where codpro='$codProFinal' order by codpro";
$resultP = mysqli_query($conexion,$sqlP);	
if (mysqli_num_rows($resultP))
{
    while ($row = mysqli_fetch_array($resultP))
    {
        $codpro = $row['codpro'];
        $s000   = $row['s000'];
        $s001   = $row['s001'];
        $s002   = $row['s002'];
        $s003   = $row['s003'];
        $s004   = $row['s004'];
        $s005   = $row['s005'];
        $s006   = $row['s006'];
        $s007   = $row['s007'];
        $s008   = $row['s008'];
        $s009   = $row['s009'];
        $s010   = $row['s010'];
        $s011   = $row['s011'];
        $s012   = $row['s012'];
        $s013   = $row['s013'];
        $s014   = $row['s014'];
        $s015   = $row['s015'];
        $s016   = $row['s016'];
        $s017   = $row['s017'];
        $s018   = $row['s018'];
        $s019   = $row['s019'];
        $s020   = $row['s020'];
        $stoini = $row['stoini'];
        $Stotal = $s000 + $s001 + $s002 + $s003 + $s004 + $s005 + $s006 + $s007 + $s008 + $s009 + $s010 + $s011 + $s012 + $s013 + $s014 + $s015 + $s016 + $s017 + $s018 + $s019 + $s020 + $stoini;
        mysqli_query($conexion,"UPDATE producto set stopro = $Stotal where codpro = $codpro");
    }
}

echo "HECHO" . '-' . $codProFinal;

?>
