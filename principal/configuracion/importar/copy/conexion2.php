<?php $dbhost = 'localhost';	//host del Mysql 
$dbUsuario = 'root';	//En este caso el servidor no tiene valor para usuario para acceder a la base
$dbpassword = '';	//Aqui tambien no hay un valor especifico
$db='sistema';		// Nombre de la Base Datos
$conexion=mysqli_connect($dbhost, $dbUsuario, $dbpassword);
mysqli_select_db($db, $conexion);
?>
