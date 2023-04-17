<?php include('../../session_user.php');
$venta   = $_SESSION['cotiz'];
require_once ('../../../conexion.php');
require_once ('funciones/datos_generales.php'); //////CODIGO Y NOMBRE DEL LOCAL
$sql="SELECT codpro,canpro,fraccion,bonif FROM cotizacion_det where invnum = '$venta'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$codpro        = $row['codpro'];		/////CODIGO DE LA RELACION ENTRE LOCAL Y PRODUCTO
	$canpro        = $row['canpro'];		////CODIGO DEL PRODUCTO
	$fraccion      = $row['fraccion'];
	$bonif         = $row['bonif'];
	/////////////DATOS DEL PRODUCTO
	$sql1="SELECT stopro,factor,$tabla FROM producto where codpro = '$codpro'";
	$result1 = mysqli_query($conexion,$sql1);
	if (mysqli_num_rows($result1)){
	while ($row1 = mysqli_fetch_array($result1)){
			$stopro    = $row1['stopro'];	
			$factor    = $row1['factor'];	
			$cant_loc  = $row1[2];
	}
	}
	if ($bonif == 1)
	{
		$sql1="SELECT codkey,cajas FROM temp_vent_bonif where invnum = '$venta' and codpro = '$codpro'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
				$codkey    = $row1['codkey'];
				$cajas     = $row1['cajas'];
				$sql2="SELECT cajas FROM ventas_bonif_unid where codkey = '$codkey'";
				$result2 = mysqli_query($conexion,$sql2);
				if (mysqli_num_rows($result2)){
				while ($row2 = mysqli_fetch_array($result2)){
						$cajas1    = $row2['cajas'];	
				}
				}
				$totcaja = $cajas + $cajas1;
				//mysqli_query($conexion,"UPDATE ventas_bonif_unid set cajas = '$totcaja' where codkey = '$codkey'");
		}
		}
	}
	if ($fraccion == "F")
	{
	$canpro = $canpro * $factor;
	}
	$total_general = $stopro + $canpro;
	$total_local   = $cant_loc + $canpro;
	//mysqli_query($conexion,"UPDATE producto set stopro = '$total_general', $tabla = '$total_local' where codpro = '$codpro'");
}
}
mysqli_query($conexion,"DELETE from cotizacion_det where invnum = '$venta'");
//mysqli_query($conexion,"DELETE from temp_vent_bonif where invnum = '$venta'");
//mysqli_query($conexion,"DELETE from detalle_venta where invnum = '$venta'");
mysqli_query($conexion,"DELETE from cotizacion where invnum = '$venta'");
header("Location: ../../index.php");
?>