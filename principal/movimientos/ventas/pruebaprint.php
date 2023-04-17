<?php
$archivo = file("B4788.txt");
$lineas = count($archivo);

for($i=0; $i < $lineas; $i++){
echo "" . $archivo[$i] . "</br>\n";
//echo mb_convert_encoding($archivo[$i], 'HTML-ENTITIES', 'UTF-8');
}
/*
?>
<html>
<head>
<script>
function imprimir()
{
window.print('B4787.txt');
}
</script>
</head>
<body onLoad="imprimir();">
</body>
</html>
<?php 
*/
?>