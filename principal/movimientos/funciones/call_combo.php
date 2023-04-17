<?php function generaSelect()
{
	//session_start();
	//include '../../../conexion.php';
	$usuario = $_SESSION['codigo_user'];
	$sql1="SELECT * FROM usuario where usecod = '$usuario'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$codloc  = $row1['codloc'];
	}
	}
	$sql="SELECT codloc, nomloc FROM xcompa where codloc <> '$codloc' order by codloc";
	$result = mysqli_query($conexion,$sql); 
	// Voy imprimiendo el primer select compuesto por los paises
	echo "<select name='local' id='local' onChange='cargaContenido(this.id)'>";
	echo "<option value='0'>Seleccione un Local</option>";
	while($row=mysqli_fetch_array($result))
	{
		echo "<option value='".$row[0]."'>".$row[1]."</option>";
	}
	echo "</select>";
}
?>