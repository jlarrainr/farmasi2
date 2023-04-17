<?php
date_default_timezone_set("America/Lima");
//ini_set("session.cookie_lifetime","86400");
$dbhost     = '3.237.52.136:3308';	//host del Mysql 
$dbUsuario  = 'root';	//En este caso el servidor no tiene valor para usuario para acceder a la base
$dbpassword = 'SharedABC2023';	//Aqui tambien no hay un valor especifico
$db         ='farmasi2_bfamifarma';		// Nombre de la Base Datos



$conexion = mysqli_connect($dbhost, $dbUsuario, $dbpassword, $db);



/////////////////////////////////////////////////SEGUNDA CONEXION///////////////////////////////////////////////////////////////////////////////////////
$dbhost2     = '3.237.52.136:3308';	//host del Mysql 
$dbUsuario2  = 'root';	//En este caso el servidor no tiene valor para usuario para acceder a la base
$dbpassword2 = 'SharedABC2023';	//Aqui tambien no hay un valor especifico
$db2         ='farmasi2_bfamifarma';		// Nombre de la Base Datos
$conexion2 = mysqli_connect($dbhost2, $dbUsuario2, $dbpassword2, $db2) or die ("No se ha podido conectar al servidor de Base de datos");
/////////////////////////////////////////////////SEGUNDA CONEXION///////////////////////////////////////////////////////////////////////////////////////






//$mysqli_instance = new mysqli($dbhost, $dbUsuario, $dbpassword, $db);



//$result = mysqli_select_db($db, $conexion);

//echo "Result:" . $result . "<p>";
//ini_set('max_execution_time', 9000);

//farmasi1_kasuri - user
//kasuri$2013 - clave
//farmasi1_kasuri - db

//farmasi1_jhosaro - user
//jhosaro$2013 - clave
//farmasi1_jhosaro - db
function CalculaHora($hora)
{
    if ($hora < 0)
    {
        /*if ($hora == -5)
        {
            $Valor = 19;
        }
        else
        {
            if ($hora == -4)
            {
                $Valor = 20;
            }
            else
            {
                if ($hora == -3)
                {
                    $Valor = 21;
                }
                else
                {
                    if ($hora == -2)
                    {
                        $Valor = 22;
                    }
                    else
                    {
                        if ($hora == -1)
                        {
                            $Valor = 23;
                        }
                        else
                        {*/
                            $HorasCalcular = $hora * -1;
                            $Valor = intval(24 - $HorasCalcular);
                        /*}
                    }
                }
            }
        }*/
        return $Valor;
    }
    else
    {
        return $hora;
    }
}
function CalculaFechaHora($hora)
{
    if ($hora < 0)
    {
        //DIA ANTERIOR
        $fecha = date("m-d-Y");
        return resta1dia($fecha);
    }
    else
    {
        //DIA NORMAL
        $fecha = date("Y-m-d");
        return $fecha;
    }
}

function resta1dia($fechaValor)
{
    $fechaValor = explode("-",$fechaValor); 
    $Fecha = mktime(0,0,0,$fechaValor[0], $fechaValor[1] - 1, $fechaValor[2]);
    return date("Y-m-d", $Fecha);exit;
}
