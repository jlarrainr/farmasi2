<?php
function generaSelect()
{
	include '../../../conexion.php';
	conectar();
	$sql="SELECT codtab, destab FROM titultabladet where tiptab = 'D'";
	$result = mysqli_query($conexion,$sql); 
	// Voy imprimiendo el primer select compuesto por los paises
	echo "<select name='departamento' id='departamento' onChange='cargaContenido(this.id)'>";
	echo "<option value='0'>Elige</option>";
	while($registro=mysqli_fetch_array($result))
	{
		echo "<option value='".$registro[0]."'>".$registro[1]."</option>";
	}
	echo "</select>";
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<!-- 



Este contenido es de libre uso y modificaci�n bajo la siguiente licencia: http://creativecommons.org/licenses/by-nc-sa/2.5/deed.es

Sobre el reconocimiento:
Todos los c�digos han sido realizados con la idea de que sirvan para colaborar con el aprendizage de aquellos que se est�n introduciendo
en estas tecnolog�as y no con el objetivo de que sean utilizados directamente en sitios web. No obstante si utilizas alg�n c�digo en tu sitio 
(ya sea sin modificar o modificado), o si ofreces los fuentes para descargar o si bien decides publicar alguno de los art�culos debes cumplir con:
-Colocar un link a http://www.formatoweb.com.ar/ajax/ visible por tus usuarios como forma de menci�n a la fuente original del contenido.
-Enviar un correo a edanps@gmail.com informando la URL donde el contenido se ha publicado o se va a publicar en un futuro.
-Si publicas los fuentes para descargar este texto no debe ser eliminado ni alterado.

M�s ejemplos y material sobre AJAX en: http://www.formatoweb.com.ar/ajax/
Cualquier sugerencia, cr�tica o comentario son bienvenidos.
Contacto: edanps@gmail.com



-->

<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>AJAX, Ejemplos: Combos (select) dependientes de 3 niveles, codigo fuente - ejemplo</title>
<link rel="stylesheet" type="text/css" href="../../../css/select.css">
<script type="text/javascript" src="funciones/select_3_niveles.js"></script>
</head>

<body>

			
				
				
				<div id="demoIzq"><?php generaSelect(); ?></div>
				<div id="demoMed">
					<select disabled="disabled" name="provincia" id="provincia">
						<option value="0">Selecciona Provincia...</option>
					</select>
				</div>
				<div id="demoDer">
					<select disabled="disabled" name="distrito" id="distrito">
						<option value="0">Selecciona Distrito...</option>
					</select>
				</div>
				
				


</body>
</html>