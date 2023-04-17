<?php $sql="SELECT invnum,nrovent,invfec,cuscod,usecod,codven,forpag,fecven FROM venta where invnum = '$venta'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$invnum       = $row['invnum'];
		$nrovent      = $row['nrovent'];
		$invfec       = $row['invfec'];
		$cuscod       = $row['cuscod'];
		$usecod       = $row['usecod'];
		$codven       = $row['codven'];
		$forpag       = $row['forpag'];
		$fecven       = $row['fecven'];
}
}
$sql="SELECT count(*) FROM detalle_venta where invnum = '$invnum'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$count        = $row[0];
}	
}
else
{
$count = 0;
}
$sql="SELECT count(*) FROM detalle_venta where invnum = '$invnum' and canpro = '0'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$count1        = $row[0];
}	
}
else
{
$count1 = 0;
}
$sql="SELECT count(*) FROM detalle_venta where invnum = '$invnum' and canpro <> '0'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$count2        = $row[0];	
}	
}
else
{
$count2 = 0;
}
$sql1="SELECT porcent FROM datagen";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
			$porcent    = $row1['porcent'];
}
}
$sql1="SELECT nomusu FROM usuario where usecod = '$usuario'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
			$user    = $row1['nomusu'];
}
}
$sql1="SELECT descli FROM cliente where codcli = '$cuscod'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
			$descli  = $row1['descli'];
}
}
$sql1="SELECT codpro,canpro,fraccion,factor,prisal,pripro,costpr,codmar,bonif FROM detalle_venta where invnum = '$invnum'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
	    $codpro    = $row1['codpro'];
		$canpro    = $row1['canpro'];
		$fraccion  = $row1['fraccion'];
		$factor    = $row1['factor'];
		$prisal    = $row1['prisal'];
		$pripro    = $row1['pripro'];
		$costpr    = $row1['costpr'];
		$codmar    = $row1['codmar'];
		$bonif     = $row1['bonif'];
		if ($bonif <> 1)
		{
			$sql2="SELECT igv,prelis,factor,prevta,preuni,margene FROM producto where codpro = '$codpro'";
			$result2 = mysqli_query($conexion,$sql2);
			if (mysqli_num_rows($result2)){
			while ($row2 = mysqli_fetch_array($result2)){
					$igv        	= $row2['igv'];
					$referencial  	= $row2['prelis'];
					$factor      	= $row2['factor'];
					$prevta			= $row2['prevta'];
					$preuni     	= $row2['preuni'];
					$margene     	= $row2['margene'];
			}
			}
			if (($referencial <> 0) and ($referencial <> $prevta))
			{
				$margenes       = ($margene/100)+1;
				$precio_ref     = $referencial/$factor;
				$precio_ref		= $precio_ref * $margenes;
			}
			else
			{
				$precio_ref		= $preuni;
			}
			if ($fraccion =='T')			
			{
				$cantidad_comp = $canpro;
			}
			else
			{
				$cantidad_comp = $canpro * $factor;
			}
			$sum_mont1 = $precio_ref * $cantidad_comp;
			$mont_bruto= $mont_bruto + $sum_mont1;
			if ($igv == 1)
			{
			$valor_vent		= ($prisal/(($porcent/100)+1))*$cantidad_comp;
			$valor_vent1	= $valor_vent1 + $valor_vent;
			}
			else
			{
			$valor_vent     = ($prisal * $cantidad_comp);
			$valor_vent1	= $valor_vent1 + $valor_vent;
			}
			$monto_total	= $monto_total + $pripro;
		}
}	
}
else
{

}
$t = 0.1;
$r = $monto_total;
$nnn = $monto_total;
$nnn = $numero_formato_frances = number_format($nnn, 2, '.', ' ');
$aux = (string)$nnn;
$decimal = substr($aux, strpos($aux,"."));
$decimal  = explode(".",$nnn);
$decimal  = $decimal[1];
$n = (floor($monto_total*10)/10); 
$rr= $valor_vent1;
$nn= (floor($valor_vent1*10)/10); 
if (($decimal%10) <> 0)
{
$monto_total    = $n + $t;
$valor_vent1    = $nn + $t;
}
else
{
$monto_total    = $n;
$valor_vent1    = $nn;
}
$total_des		= $mont_bruto - $valor_vent1;
$sum_igv		= ($monto_total - $valor_vent1);
$redondeo		= $monto_total - $r;
?>