<?php include('../session_user.php');
?>
<?php require_once("../../conexion.php");
		$abrev	= $_POST['abrev'];
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
		$sql = "SELECT ltdgen, dsgen FROM titultabla WHERE ltdgen='".quitar($HTTP_POST_VARS["abrev"])."' or dsgen='".quitar($HTTP_POST_VARS["desc"])."'";
		$result = mysqli_query($conexion,$sql);
		if($row = mysqli_fetch_array($result))
		{
		//header("Location: mov_prod.php?error=2");
		header("Location: mov_tablas1.php?error=1");
		}
		else
		{
		mysqli_query($conexion,"INSERT INTO titultabla (ltdgen, dsgen) values ('$abrev','$desc')")	;
		header("Location: mov_tablas1.php?ok=1");
		}
?>