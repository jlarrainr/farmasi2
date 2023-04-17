<?php $fecha = "21-06-2009"; //5 agosto de 2004 por ejemplo 

$fechats = strtotime($fecha); //a timestamp

//el parametro w en la funcion date indica que queremos el dia de la semana
//lo devuelve en numero 0 domingo, 1 lunes,....
switch (date('w', $fechats)){
    case 0: echo "Domingo"; break;
    case 1: echo "Lunes"; break;
    case 2: echo "Martes"; break;
    case 3: echo "Miercoles"; break;
    case 4: echo "Jueves"; break;
    case 5: echo "Viernes"; break;
    case 6: echo "Sabado"; break;
}
?>