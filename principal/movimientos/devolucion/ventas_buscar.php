<?php include('../../session_user.php');
$venta   = $_SESSION['venta'];
require_once('../../../conexion.php');
$sql1 = "SELECT * FROM usuario where usecod = '$usuario'";	////CODIGO DEL LOCAL DEL USUARIO
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
	while ($row1 = mysqli_fetch_array($result1)) {
		$codloc    = $row1['codloc'];
	}
}
$sql = "SELECT * FROM xcompa where codloc = '$codloc'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
	while ($row = mysqli_fetch_array($result)) {
		$nomloc    = $row['nomloc'];
	}
}
$sql = "SELECT * FROM temp_venta where invnum = '$venta'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
	while ($row = mysqli_fetch_array($result)) {
		$codpro        = $row['codpro'];		/////CODIGO DE LA RELACION ENTRE LOCAL Y PRODUCTO
		$canpro        = $row['canpro'];		////CODIGO DEL PRODUCTO
		$fraccion      = $row['fraccion'];
		/////////////DATOS DEL PRODUCTO
		$sql1 = "SELECT * FROM producto where codpro = '$codpro'";
		$result1 = mysqli_query($conexion, $sql1);
		if (mysqli_num_rows($result1)) {
			while ($row1 = mysqli_fetch_array($result1)) {
				$stopro    = $row1['stopro'];
				$factor    = $row1['factor'];
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
			}
		}
		if ($nomloc == "LOCAL0") {
			$cant_loc = $s000;
		}
		if ($nomloc == "LOCAL1") {
			$cant_loc = $s001;
		}
		if ($nomloc == "LOCAL2") {
			$cant_loc = $s002;
		}
		if ($nomloc == "LOCAL3") {
			$cant_loc = $s003;
		}
		if ($nomloc == "LOCAL4") {
			$cant_loc = $s004;
		}
		if ($nomloc == "LOCAL5") {
			$cant_loc = $s005;
		}
		if ($nomloc == "LOCAL6") {
			$cant_loc = $s006;
		}
		if ($nomloc == "LOCAL7") {
			$cant_loc = $s007;
		}
		if ($nomloc == "LOCAL8") {
			$cant_loc = $s008;
		}
		if ($nomloc == "LOCAL9") {
			$cant_loc = $s009;
		}
		if ($nomloc == "LOCAL10") {
			$cant_loc = $s010;
		}
		if ($nomloc == "LOCAL11") {
			$cant_loc = $s011;
		}
		if ($nomloc == "LOCAL12") {
			$cant_loc = $s012;
		}
		if ($nomloc == "LOCAL13") {
			$cant_loc = $s013;
		}
		if ($nomloc == "LOCAL14") {
			$cant_loc = $s014;
		}
		if ($nomloc == "LOCAL15") {
			$cant_loc = $s015;
		}
		if ($nomloc == "LOCAL16") {
			$cant_loc = $s016;
		}
		if ($fraccion == "F") {
			$canpro = $canpro * $factor;
		}
		$total_general = $stopro + $canpro;
		$total_local   = $cant_loc + $canpro;
		if ($nomloc == "LOCAL0") {
			mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s000 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL1") {
			mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s001 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL2") {
			mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s002 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL3") {
			mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s003 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL4") {
			mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s004 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL5") {
			mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s005 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL6") {
			mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s006 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL7") {
			mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s007 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL8") {
			mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s008 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL9") {
			mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s009 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL10") {
			mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s010 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL11") {
			mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s011 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL12") {
			mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s012 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL13") {
			mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s013 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL14") {
			mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s014 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL15") {
			mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s015 = '$total_local' where codpro = '$codpro'");
		}
		if ($nomloc == "LOCAL16") {
			mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', s016 = '$total_local' where codpro = '$codpro'");
		}
	}
}
mysqli_query($conexion, "DELETE from temp_venta where invnum = '$venta'");
mysqli_query($conexion, "DELETE from detalle_venta where invnum = '$venta'");
mysqli_query($conexion, "DELETE from venta where invnum = '$venta'");
header("Location: ventas.php");
