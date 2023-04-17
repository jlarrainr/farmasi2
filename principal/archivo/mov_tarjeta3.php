<?php include('../session_user.php');
?>
<?php require_once("../../conexion.php");
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
		   			
					$sql = "SELECT nombre FROM tarjeta WHERE nombre='".quitar($HTTP_POST_VARS["desc"])."'";
					$result = mysqli_query($conexion,$sql);
					if($row = mysqli_fetch_array($result))
					{
					//header("Location: mov_prod.php?error=2");
					header("Location: mov_tarjeta1.php?error=1");
					}
					else
					{
			mysqli_query($conexion,"INSERT INTO tarjeta (nombre) values ('$desc')")	;
			header("Location: mov_tarjeta1.php?ok=1");
					}
		}
		////////////////////////////////////////////////////////////MODIFICO
		if ($btn == 2)
		{
			$id	= $_POST['id'];
			$sql="SELECT nombre FROM tarjeta where id = '$id'";
			$result = mysqli_query($conexion,$sql);
			if (mysqli_num_rows($result) ){
			while ($row = mysqli_fetch_array($result)){
				 $nombre                 = $row["nombre"];
			}
			}
			if ($desc == $nombre)
			{
			mysqli_query($conexion,"UPDATE tarjeta set nombre = '$desc' where id = '$id'")	;
			header("Location: mov_tarjeta1.php?up=1");
			}
			else
			{
					$sql = "SELECT nombre FROM tarjeta WHERE nombre='".quitar($HTTP_POST_VARS["desc"])."'";
					$result = mysqli_query($conexion,$sql);
					if($row = mysqli_fetch_array($result))
					{
					//header("Location: mov_prod.php?error=2");
					header("Location: mov_tarjeta1.php?error=1");
					}
					else
					{
					mysqli_query($conexion,"UPDATE tarjeta set nombre = '$desc' where id = '$id'")	;
					header("Location: mov_tarjeta1.php?up=1");
					}
			}
		}
		///////////////////////////////////////////////////////////ELIMINO
		if ($btn == 3)
		{
		$id	= $_POST['id'];
		mysqli_query($conexion,"DELETE from tarjeta where id = '$id'")	;
		header("Location: mov_tarjeta1.php?del=1");
		}
?>