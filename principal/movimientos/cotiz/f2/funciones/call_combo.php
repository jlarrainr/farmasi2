<?php function generaSelect($conexion)
{
	//include '../../../../conexion.php';
	$sql="SELECT id,name FROM departamento order by name";
	$result = mysqli_query($conexion,$sql); 
	// Voy imprimiendo el primer select compuesto por los paises
	echo "<select name='departamento' id='departamento' onChange='cargaContenido(this.id)'>";
	echo "<option value='0'>Seleccione un Departamento</option>";
	while($row=mysqli_fetch_array($result))
	{
		echo "<option value='".$row[0]."'>".$row[1]."</option>";
	}
	echo "</select>";
}
?>