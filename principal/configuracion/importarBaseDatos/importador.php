<?php
require_once('../../../conexion.php');
/**
 * Respaldar base de datos de MySQL con PHP
 * Función modificada de: https://stackoverflow.com/a/21284229/5032550
 *
 * Visita: https://parzibyte.me/blog/2018/10/22/script-respaldar-base-de-datos-mysql-php/
 */

// Ejemplo de llamada: exportarTablas("localhost", "root", "123", "foo");

function exportarTablas($host, $usuario, $pasword, $nombreDeBaseDeDatos)
{
    set_time_limit(3000);
    $tablasARespaldar = [];
    $mysqli = new mysqli($host, $usuario, $pasword, $nombreDeBaseDeDatos);
    $mysqli->select_db($nombreDeBaseDeDatos);
    $mysqli->query("SET NAMES 'utf8'");
    $tablas = $mysqli->query('SHOW TABLES');
    while ($fila = $tablas->fetch_row()) {
        $tablasARespaldar[] = $fila[0];
    }
    $contenido = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n--\r\n-- Database: `" . $nombreDeBaseDeDatos . "`\r\n--\r\n\r\n\r\n";
    foreach ($tablasARespaldar as $nombreDeLaTabla) {
        if (empty($nombreDeLaTabla)) {
            continue;
        }
        $datosQueContieneLaTabla = $mysqli->query('SELECT * FROM `' . $nombreDeLaTabla . '`');
        $cantidadDeCampos = $datosQueContieneLaTabla->field_count;
        $cantidadDeFilas = $mysqli->affected_rows;
        $esquemaDeTabla = $mysqli->query('SHOW CREATE TABLE ' . $nombreDeLaTabla);
        $filaDeTabla = $esquemaDeTabla->fetch_row();
        $contenido .= "\n\n" . $filaDeTabla[1] . ";\n\n";
        for ($i = 0, $contador = 0; $i < $cantidadDeCampos; $i++, $contador = 0) {
            while ($fila = $datosQueContieneLaTabla->fetch_row()) {
                //La primera y cada 100 veces
                if ($contador % 100 == 0 || $contador == 0) {
                    $contenido .= "\nINSERT INTO " . $nombreDeLaTabla . " VALUES";
                }
                $contenido .= "\n(";
                for ($j = 0; $j < $cantidadDeCampos; $j++) {
                    $fila[$j] = str_replace("\n", "\\n", addslashes($fila[$j]));
                    if (isset($fila[$j])) {
                        $contenido .= '"' . $fila[$j] . '"';
                    } else {
                        $contenido .= '""';
                    }
                    if ($j < ($cantidadDeCampos - 1)) {
                        $contenido .= ',';
                    }
                }
                $contenido .= ")";
                # Cada 100...
                if ((($contador + 1) % 100 == 0 && $contador != 0) || $contador + 1 == $cantidadDeFilas) {
                    $contenido .= ";";
                } else {
                    $contenido .= ",";
                }
                $contador = $contador + 1;
            }
        }
        $contenido .= "\n\n\n";
    }
    $contenido .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";

    # Se guardará dependiendo del directorio, en una carpeta llamada respaldos
    $carpeta = __DIR__ . "/respaldos";
    if (!file_exists($carpeta)) {
        mkdir($carpeta);
    }

    # Calcular un ID único
    $id = uniqid();

    # También la fecha
    $fecha = date("Y-m-d");

    # Crear un archivo que tendrá un nombre como respaldo_2018-10-22_asd123.sql
    $nombreDelArchivo = sprintf('%s/respaldo_%s_%s.sql', $carpeta, $fecha, $id);

    #Escribir todo el contenido. Si todo va bien, file_put_contents NO devuelve FALSE
    return file_put_contents($nombreDelArchivo, $contenido) !== false;
}


exportarTablas($dbhost, $dbUsuario, $dbpassword, $db );

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .loading {
            position: fixed;
            z-index: 9999;
            background: rgba(17, 17, 17, 0.5);
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }

        .loading div {
            position: absolute;
            background-image: url('loading.gif');
            background-size: 60px 60px;
            top: 50%;
            left: 50%;
            width: 60px;
            height: 60px;
            margin-top: -30px;
            margin-left: -30px;
        }

        .Scroll {
            height: 640px;
            overflow-y: scroll;
        }
    </style>
    <script>
        function salir() {

            $(document.body).append('<span class="loading"><div></div></span>');
            setTimeout(function() {
                $('.loading').remove();
                alert('Respaldo Generado.');
                var f = document.form1;
                f.target = "_top";
                f.action = "../../configuracion/importarBaseDatos/importar.php";
                f.submit();
            }, 2000);
        }

        function salir2() {


            var f = document.form1;
            f.target = "_top";
            f.action = "../../configuracion/importarBaseDatos/importar.php";
            f.submit();

        }
    </script>
</head>



<body onload="salir()">
    <form id="form1" name="form1">
        <h1>Respaldo Generado</h1>
        <button onclick="salir2()">Regresar</button>
    </form>
</body>


</html>