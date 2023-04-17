<?php include('../../session_user.php');
require_once ('../../../conexion.php');
$invnum  = $_SESSION['compraspreg'];
$ncompra        = isset($_REQUEST['nrocompra']) ? ($_REQUEST['nrocompra']) : "";
$prov           = isset($_REQUEST['alfa1']) ? ($_REQUEST['alfa1']) : "";
$DatosProveedor = isset($_REQUEST['DatosProveedor']) ? ($_REQUEST['DatosProveedor']) : "";
$isnum   = is_numeric($ncompra);
if ($isnum == 1)
{
	mysqli_query($conexion,"delete from tempmovmov where invnum ='$invnum'");
	mysqli_query($conexion,"delete from tempmovmov_bonif where invnum ='$invnum'");
	$sql="SELECT invnum,preingreso FROM ordmae where nrocomp = '$ncompra' and pendiente = '1' and provee = '$prov' and borrada = '0' and confirmado = '0' and preingreso = '1'";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	while ($row = mysqli_fetch_array($result)){
		$nro_compra       = $row['invnum'];	
		$preingreso       = $row['preingreso'];	
		$sql1="SELECT codpro,canpro,canate,desc1,desc2,desc3,precio_ref,costod,mont_total,canbon,tipbon FROM ordmov where invnum = '$nro_compra' and confirmar = '0'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
			$codpro       = $row1['codpro'];
			$canpro       = $row1['canpro'];
			$canate       = $row1['canate'];
			$desc1        = $row1['desc1'];
			$desc2        = $row1['desc2'];
			$desc3        = $row1['desc3'];
			$canbon       = $row1['canbon'];
			$tipbon       = $row1['tipbon'];
			$precio_ref   = $row1['precio_ref'];
			$costod       = $row1['costod'];
			$mont_total   = $row1['mont_total'];
			$recibidos    = $canpro - $canate;
			if ($recibidos <> 0)	
			{
			$sql2="SELECT costpr,factor,stopro FROM producto where codpro = '$codpro'";
			$result2 = mysqli_query($conexion,$sql2);
			if (mysqli_num_rows($result2)){
			while ($row2 = mysqli_fetch_array($result2)){
				$costpr       = $row2['costpr'];
				$factor       = $row2['factor'];
				$stopro       = $row2['stopro'];
			}
			}
			$promedio = ((($stopro/$factor) * $costpr)+($canpro*$costod))/(($stopro/$factor)+$canpro);
			mysqli_query($conexion,"INSERT INTO tempmovmov (invnum,codpro,qtypro,pripro,prisal,costre,desc1,desc2,desc3,costpr,canbon,tipbon) values ('$invnum','$codpro','$canpro','$costod','$precio_ref','$mont_total','$desc1','$desc2','$desc3','$promedio','$canbon','$tipbon')");
			}
		}
		}
	}
	mysqli_query($conexion,"UPDATE movmae set nro_compra = '$nro_compra' where invnum = '$invnum'");
	header("Location: compras1.php?ok=1&busca_num=$ncompra&busca_prov=$prov&DatosProveedor=$DatosProveedor"); 
	}
	else
	{
	header("Location: compras1.php?ok=0&busca_num=$ncompra&busca_prov=$prov&DatosProveedor=$DatosProveedor"); 
	}
}
else
{
mysqli_query($conexion,"delete from tempmovmov where invnum ='$invnum'");
mysqli_query($conexion,"delete from tempmovmov_bonif where invnum ='$invnum'");
header("Location: compras1.php?ok=4&busca_num=$ncompra&busca_prov=$prov&DatosProveedor=$DatosProveedor"); 
}
?>