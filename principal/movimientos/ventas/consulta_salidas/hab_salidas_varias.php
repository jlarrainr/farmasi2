<?php include('../../session_user.php');
require_once ('../../../conexion.php');
$cod	 = $_REQUEST['cod'];		///CODIGO UTILIZADO PARA ELIMINAR
$sql="SELECT * FROM venta where invnum = '$cod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    	$numdoc    = $row['numdoc'];
		$invfec    = $row['invfec'];
		$tipmov    = $row['tipmov'];
		$tipdoc    = $row['tipdoc'];
		$usecod    = $row['usecod'];
}
}
$sql="SELECT * FROM usuario where usecod = '$usecod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    	$codloc    = $row['codloc'];
}
}
$sql="SELECT * FROM xcompa where codloc = '$codloc'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    		$nomloc    = $row['nomloc'];
}
}
$sql="SELECT * FROM detalle_venta where invnum = '$cod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
			$codpro         = $row['codpro'];
			$canpro         = $row['canpro'];	
			$fraccion       = $row['fraccion'];
			$factor         = $row['factor'];
		if ($factor == "F")
		{
		$cantidad = $canpro * $factor;
		}
		else
		{
		$cantidad = $canpro;
		}
		$sql1="SELECT * FROM producto where codpro = '$codpro'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
				$stopro    = $row1['stopro'];
				$s000      = $row1['s000'];
				$s001      = $row1['s001'];
				$s002      = $row1['s002'];
				$s003      = $row1['s003'];
				$s004      = $row1['s004'];
				$s005      = $row1['s005'];
				$s006      = $row1['s006'];
				$s007      = $row1['s007'];
				$s008      = $row1['s008'];
				$s009      = $row1['s009'];
				$s010      = $row1['s010'];
				$s011      = $row1['s011'];
				$s012      = $row1['s012'];
				$s013      = $row1['s013'];
				$s014      = $row1['s014'];
				$s015      = $row1['s015'];
				$s016      = $row1['s016'];
				$s017      = $row1['s017'];
				$s018      = $row1['s018'];
				$s019      = $row1['s019'];
				$s020      = $row1['s020'];

		}
		}
		    if ($nomloc == "LOCAL0")
			{
				$cant_loc = $s000;
			}
			if ($nomloc == "LOCAL1")
			{
				$cant_loc = $s001;
			}
			if ($nomloc == "LOCAL2")
			{
				$cant_loc = $s002;
			}
			if ($nomloc == "LOCAL3")
			{
				$cant_loc = $s003;
			}
			if ($nomloc == "LOCAL4")
			{
				$cant_loc = $s004;
			}
			if ($nomloc == "LOCAL5")
			{
				$cant_loc = $s005;
			}
			if ($nomloc == "LOCAL6")
			{
				$cant_loc = $s006;
			}
			if ($nomloc == "LOCAL7")
			{
				$cant_loc = $s007;
			}
			if ($nomloc == "LOCAL8")
			{
				$cant_loc = $s008;
			}
			if ($nomloc == "LOCAL9")
			{
				$cant_loc = $s009;
			}
			if ($nomloc == "LOCAL10")
			{
				$cant_loc = $s010;
			}
			if ($nomloc == "LOCAL11")
			{
				$cant_loc = $s011;
			}
			if ($nomloc == "LOCAL12")
			{
				$cant_loc = $s012;
			}
			if ($nomloc == "LOCAL13")
			{
				$cant_loc = $s013;
			}
			if ($nomloc == "LOCAL14")
			{
				$cant_loc = $s014;
			}
			if ($nomloc == "LOCAL15")
			{
				$cant_loc = $s015;
			}
			if ($nomloc == "LOCAL16")
			{
				$cant_loc = $s016;
			}
			if ($nomloc == "LOCAL17")
			{
				$cant_loc = $s017;
			}
			if ($nomloc == "LOCAL18")
			{
				$cant_loc = $s018;
			}
			if ($nomloc == "LOCAL19")
			{
				$cant_loc = $s019;
			}
			if ($nomloc == "LOCAL20")
			{
				$cant_loc = $s020;
			}
			
		$total_local =  $cant_loc - $cantidad;
		$total_general = $stopro - $cantidad;
		if ($nomloc == "LOCAL0")
		{
		mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s000 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL1")
		{
		mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s001 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL2")
		{
		mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s002 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL3")
		{
		mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s003 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL4")
		{
		mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s004 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL5")
		{
		mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s005 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL6")
		{
		mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s006 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL7")
		{
		mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s007 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL8")
		{
		mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s008 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL9")
		{
		mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s009 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL10")
		{
		mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s010 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL11")
		{
		mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s011 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL12")
		{
		mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s012 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL13")
		{
		mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s013 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL14")
		{
		mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s014 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL15")
		{
		mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s015 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL16")
		{
		mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s016 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL17")
		{
		mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s017 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL18")
		{
		mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s018 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL19")
		{
		mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s019 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL20")
		{
		mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s020 = '$total_local' where codpro = '$codpro'");
		}
		
		/////////////////////////////////////////////////////////////
}
}
mysqli_query($conexion, "UPDATE venta set val_habil = '0' where invnum = '$cod'");
header("Location: consult_salid_varias.php"); 
?>