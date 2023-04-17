<?php
/*function round_to($number, $increments) {
$increments = 1 / $increments;
return (round($number * $increments) / $increments);
}*/

?>
<?php
/*$n = 9.30;
$t = 0.1;
//echo round_to($n, 0.6); // 5.5
$n = (floor($n*10)/10); 
$tot = $n + $t;
//echo (floor($tot*10)/10);
echo (floor($tot*10)/10);
*/
$letters = '.shdfh';
$t = is_numeric($letters);
if($t == 0)
{
	/*$caracter = ".";
	if (strpos($letters,$caracter)!== false) 
	{
	echo $letters;
	echo 'POR CODIGO';
	}
	else
	{
	*/
	echo 'POR PRODUCTO';
	//}
}
else
{
echo 'POR CODIGO 2';
}
?>