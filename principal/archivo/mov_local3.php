<?php include('../session_user.php');
require_once("../../conexion.php");
		$btn	= $_POST['btn'];
		$desc	= $_POST['desc'];
		function quitar($mensaje)
					{
					$mensaje = str_replace("<","&lt;",$mensaje);
					$mensaje = str_replace(">","&gt;",$mensaje);
					$mensaje = str_replace("\'","&#39;",$mensaje);
					$mensaje = str_replace('\"',"&quot;",$mensaje);
					$mensaje = str_replace("\\\\","&#92;",$mensaje);
					return $mensaje;
					}
		////////////////////////////////////////////////////////////REGISTRO
		if ($btn == 1)
		{
		   			
					$sql = "SELECT nomloc FROM local WHERE nomloc='".quitar($HTTP_POST_VARS["desc"])."'";
					$result = mysqli_query($conexion,$sql);
					if($row = mysqli_fetch_array($result))
					{
					//header("Location: mov_prod.php?error=2");
					header("Location: mov_local1.php?error=1");
					}
					else
					{
			mysqli_query($conexion,"INSERT INTO local (nomloc) values ('$desc')")	;
			header("Location: mov_local1.php?ok=1");
					}
		}
		////////////////////////////////////////////////////////////MODIFICO
		if ($btn == 2)
		{
			$codloc	= $_POST['codloc'];
			$sql="SELECT nomloc FROM local where codloc = '$codloc'";
			$result = mysqli_query($conexion,$sql);
			if (mysqli_num_rows($result) ){
			while ($row = mysqli_fetch_array($result)){
				 $nomloc                 = $row["nomloc"];
			}
			}
			if ($desc == $tranom)
			{
			mysqli_query($conexion,"UPDATE local set nomloc = '$desc' where codloc = '$codloc'")	;
			header("Location: mov_local1.php?up=1");
			}
			else
			{
					$sql = "SELECT nomloc FROM local WHERE nomloc='".quitar($HTTP_POST_VARS["desc"])."'";
					$result = mysqli_query($conexion,$sql);
					if($row = mysqli_fetch_array($result))
					{
					//header("Location: mov_prod.php?error=2");
					header("Location: mov_local1.php?error=1");
					}
					else
					{
					mysqli_query($conexion,"UPDATE local set nomloc = '$desc' where codloc = '$codloc'")	;
					header("Location: mov_local1.php?up=1");
					}
			}
		}
		///////////////////////////////////////////////////////////ELIMINO
		if ($btn == 3)
		{
		$codloc	= $_POST['codloc'];
		mysqli_query($conexion,"DELETE from local where codloc = '$codloc'")	;
		header("Location: mov_local1.php?del=1");
		}
?>