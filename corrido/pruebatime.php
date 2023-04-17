<?php 
require_once('conexion.php');
$hour  = 3-5;
/*
$min   = date(i);
$hora  = $hour.":".$min;
//$hora  = date('h:i');
$ddate = strlen($hora) + 1;
echo "<br>".$ddate;*/
echo $hour."<br>"; 
echo CalculaHora($hour)."<br>";

/*if ($hour < 0)
{
    //DIA ANTERIOR
    //echo resta1dia($fecha);
    echo $fecha;
}
else
{
    //DIA NORMAL
    //echo $fecha;
    echo resta1dia($fecha);
}*/
?>