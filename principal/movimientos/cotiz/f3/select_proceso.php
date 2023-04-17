<?php
// Array que vincula los IDs de los selects declarados en el HTML con el nombre de la tabla donde se encuentra su contenido
$listadoSelects=array(
"departamento"=>"titultabladet",
"provincia"=>"titultabladet",
"distrito"=>"titultabladet"
);

function validaSelect($selectDestino)
{
	// Se valida que el select enviado via GET exista
	global $listadoSelects;
	if(isset($listadoSelects[$selectDestino])) return true;
	else return false;
}

function validaOpcion($opcionSeleccionada)
{
	// Se valida que la opcion seleccionada por el usuario en el select tenga un valor numerico
	if(is_numeric($opcionSeleccionada)) return true;
	else return false;
}

$selectDestino=$_REQUEST["select"]; $opcionSeleccionada=$_REQUEST["opcion"];

if(validaSelect($selectDestino) && validaOpcion($opcionSeleccionada))
{
	$tabla=$listadoSelects[$selectDestino];
	include '../../../../conexion.php';
	$sql="SELECT codtab, destab FROM $tabla WHERE cdgen='$opcionSeleccionada'";
	$result = mysqli_query($conexion,$sql); 
	// Comienzo a imprimir el select
	echo "<select name='".$selectDestino."' id='".$selectDestino."' onChange='cargaContenido(this.id)'>";
	echo "<option value='0'>Elige</option>";
	while($row=mysqli_fetch_array($result))
	{
		// Convierto los caracteres conflictivos a sus entidades HTML correspondientes para su correcta visualizacion
		$row[1]=htmlentities($row[1]);
		// Imprimo las opciones del select
		echo "<option value='".$row[0]."'>".$row[1]."</option>";
	}			
	echo "</select>";
}
?>