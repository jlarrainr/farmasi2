<?php //defino fecha 1
$ano1 = 2008;
$mes1 = 12;
$dia1 = 03;
//defino fecha 2
$ano2 = 2008;
$mes2 = 12;
$dia2 = 05;
//calculo timestam de las dos fechas
$timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1);
$timestamp2 = mktime(4,12,0,$mes2,$dia2,$ano2);
//resto a una fecha la otra
$segundos_diferencia = $timestamp1 - $timestamp2;
//echo $segundos_diferencia;
//convierto segundos en días
$dias_diferencia = $segundos_diferencia / (60 * 60 * 24);
//obtengo el valor absoulto de los días (quito el posible signo negativo)
$dias_diferencia = abs($dias_diferencia);
//quito los decimales a los días de diferencia
$dias_diferencia = floor($dias_diferencia);
echo $dias_diferencia;
?>