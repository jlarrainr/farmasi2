<?php 
require_once('../../session_user.php');
$tventa   = $_SESSION['tventa'];
require_once('../../../conexion.php');
require_once('funciones_temp/datos_generales.php'); //////CODIGO Y NOMBRE DEL LOCAL
$cod	 = $_REQUEST['cod'];		///CODIGO DEL TEMPORAL UTILIZADO PARA ELIMINAR
$sql="SELECT codpro,canpro,fraccion FROM detalle_venta2 where codtemp = '$cod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$codpro        = $row['codpro'];		/////CODIGO DE LA RELACION ENTRE LOCAL Y PRODUCTO
	$canpro        = $row['canpro'];		////CODIGO DEL PRODUCTO
	$fraccion      = $row['fraccion'];
	/////////////DATOS DEL PRODUCTO
	$sql1="SELECT stopro,factor,$tabla,codprobonif FROM producto where codpro = '$codpro'";
	$result1 = mysqli_query($conexion,$sql1);
	if (mysqli_num_rows($result1)){
	while ($row1 = mysqli_fetch_array($result1)){
			$stopro     = $row1['stopro'];	
			$factor     = $row1['factor'];
                        $codprobonif= $row1['codprobonif'];
			$cant_loc   = $row1[2];
	}
	}
	$sql1="SELECT codpro,codkey,cajas FROM temp_vent_bonif where invnum = '$tventa' and codprobonif = '$codpro'";
	$result1 = mysqli_query($conexion,$sql1);
	if (mysqli_num_rows($result1)){
	while ($row1 = mysqli_fetch_array($result1)){
			$codprox   = $row1['codpro'];
			$codkey    = $row1['codkey'];
			$cajas     = $row1['cajas'];
			$sql2="SELECT cajas,unid FROM ventas_bonif_unid where codkey = '$codkey'";
			$result2 = mysqli_query($conexion,$sql2);
			if (mysqli_num_rows($result2)){
			while ($row2 = mysqli_fetch_array($result2)){
					$cajas1    = $row2['cajas'];
					$unid1     = $row2['unid'];	
			}
			}
			$sql2="SELECT stopro,$tabla FROM producto where codpro = '$codprox'";
			$result2 = mysqli_query($conexion,$sql2);
			if (mysqli_num_rows($result2)){
			while ($row2 = mysqli_fetch_array($result2)){
					$stockx    = $row2['stopro'];
					$locx      = $row2[1];	
			}
			}
			$totcaja = $cajas + $cajas1;
			$unidadesx = $cajas * $unid1;
			$stockxx   = $stockx + $unidadesx;
			$locxx     = $locx + $unidadesx;
			//----mysqli_query($conexion, "UPDATE ventas_bonif_unid set cajas = '$totcaja' where codkey = '$codkey'");
			//----mysqli_query($conexion, "UPDATE producto set stopro = '$stockxx',$tabla = '$locxx' where codpro = '$codprox'");
	}
	}
	if ($fraccion == "F")
	{
	$canpro = $canpro * $factor;
	}
	$total_general = $stopro + $canpro;
	$total_local	= $cant_loc + $canpro;
	//-------mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', $tabla = '$total_local' where codpro = '$codpro'");
}
}
mysqli_query($conexion, "DELETE from detalle_venta2 where codtemp = '$cod'");
mysqli_query($conexion, "DELETE from detalle_venta2 where codpro = '$codprobonif' AND invnum = $tventa AND bonif2 = 1");
mysqli_query($conexion, "DELETE from temp_venta_bonif where invnum = '$venta' and codprobonif = '$codpro'");
header("Location: venta_index_t1.php");
?>