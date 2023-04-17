<?php 
	// Tomar los ultimos digitos de "nomloc" para construir el nombre de columna saldo de local
	$numero = substr($nomloc, 5, 2);
	$tabla = "s" . str_pad($numero, 3, "0", STR_PAD_LEFT);
?>