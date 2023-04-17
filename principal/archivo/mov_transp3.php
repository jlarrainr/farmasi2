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
		   			
					$sql = "SELECT tranom FROM transporte WHERE tranom='".quitar($HTTP_POST_VARS["desc"])."'";
					$result = mysqli_query($conexion,$sql);
					if($row = mysqli_fetch_array($result))
					{
					//header("Location: mov_prod.php?error=2");
					header("Location: mov_transp1.php?error=1");
					}
					else
					{
			mysqli_query($conexion,"INSERT INTO transporte (tranom) values ('$desc')")	;
			header("Location: mov_transp1.php?ok=1");
					}
		}
		////////////////////////////////////////////////////////////MODIFICO
		if ($btn == 2)
		{
			$tracli	= $_POST['tracli'];
			$sql="SELECT tranom FROM transporte where tracli = '$tracli'";
			$result = mysqli_query($conexion,$sql);
			if (mysqli_num_rows($result) ){
			while ($row = mysqli_fetch_array($result)){
				 $tranom                 = $row["tranom"];
			}
			}
			if ($desc == $tranom)
			{
			mysqli_query($conexion,"UPDATE transporte set tranom = '$desc' where tracli = '$tracli'")	;
			header("Location: mov_transp1.php?up=1");
			}
			else
			{
					$sql = "SELECT tranom FROM transporte WHERE tranom='".quitar($HTTP_POST_VARS["desc"])."'";
					$result = mysqli_query($conexion,$sql);
					if($row = mysqli_fetch_array($result))
					{
					//header("Location: mov_prod.php?error=2");
					header("Location: mov_transp1.php?error=1");
					}
					else
					{
					mysqli_query($conexion,"UPDATE transporte set tranom = '$desc' where tracli = '$tracli'")	;
					header("Location: mov_transp1.php?up=1");
					}
			}
		}
		///////////////////////////////////////////////////////////ELIMINO
		if ($btn == 3)
		{
		$codtab	= $_POST['codtab'];
		mysqli_query($conexion,"DELETE from transporte where tracli = '$tracli'")	;
		header("Location: mov_transp1.php?del=1");
		}
?>