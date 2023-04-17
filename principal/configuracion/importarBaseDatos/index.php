<?php
 error_reporting(E_ALL);
 ini_set('display_errors', '1');
include('../../session_user.php');
require_once('../../../conexion.php');



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>MANTENIMIENTO DE INFORMACION</title>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/select.css" rel="stylesheet" type="text/css" />
    <style>
        input.bt {
            font-size: 9px;
            font-weight: bold;
            font-family: Verdana, Helvetica;
            height: 20px;
            width: 65px;
        }
    </style>
    <script>
        function validar() {
            var f = document.form1;
            // var t1 = f.b1.value;
            // var t2 = f.b2.value;
            // if (t1 == t2) {
            //     alert("UD DEBE SELECCIONAR BASE DE DATOS DIFERENTES");
            //     return;
            // }
            f.method = "post";
            f.action = "importador.php";
            f.submit();
        }

        function sal() {
            var f = document.form1;
            f.target = "_top";
            f.action = "../../index.php"
            f.submit();
        }
    </script>
    <style>
        table.tabla2 {
            color: #404040;
            background-color: #FFFFFF;
            border: 1px #CDCDCD solid;
            border-collapse: collapse;
            border-spacing: 0px;
        }

        .LETRA {
            font-family: Tahoma;
            font-size: 11px;
            line-height: normal;
            color: '#5f5e5e';
            font-weight: bold;
        }

        input {
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 12px;
            background-color: white;
            background-position: 3px 3px;
            background-repeat: no-repeat;
            padding: 2px 1px 2px 5px;

        }

        .LETRA2 {
            background: #d7d7d7
        }

        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;

        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 3px;

        }
#customers td a {
        color: #4d9ff7;
        font-weight: bold;
        font-size: 15px;
        text-decoration: none;

    }
        #customers tr:nth-child(even) {
            background-color: #f0ecec;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {

            text-align: center;
            background-color: #50ADEA;
            color: white;
            font-size: 12px;
            font-weight: 900;
        }
    </style>
</head>

<body>
    <form id="form1" name="form1">
        <p>&nbsp;</p>
        <center>
            <font color="#0066CC"><strong>IMPORTAR INFORMACI&Oacute;N DE BASE DE DATOS </strong></font>
        </center>
        <br />
        <table width="100%" height="180" border="0" align="center" class="tabla2">
            <tr>
                <td width="605" valign="top">
                    <div align="center">
                        <br /><br />
                        <table width="575" border="0">
                            <tr>
                                <td><strong><u>SELECCIONAR BASE DE DATOS </u></strong></td>
                            </tr>
                        </table>
                        <br />
                        <table width="575" border="0">
                            <tr>
                                <td>Seleecionar la base de datos de la cual se desea extraer su informacion</td>
                            </tr>
                        </table>
                        <table width="575" border="0">
                            <tr>
                                <td width="58">ORIGEN</td>
                                <td width="202"><select id="b1" name="b1">

                                        <option value="<?php echo $db  ?>"><?php echo strtoupper($db) ?></option>

                                    </select>
                                </td>
                                <td width="298"><input name="Submit3" type="button" onclick="validar()" value="Exportar" class="bt" />
                                    <input name="Submit22" type="button" onclick="sal()" value="Salir" class="bt" />
                                </td>
                                
                            </tr>
                        </table>
                        <br />
                       
                    </div>
                </td>
            </tr>
        </table>
         <table width="100%" border="0" align="center" id="customers">
            <tr>
                <th>#</th>
                <th>Nombre Archivo</th>
                <th>Download</th>
                <th width="20%">Fecha/ Hora </th>
            </tr>
            <?php
            $directorio2 = "./respaldos/";
            $archivos2 = glob("$directorio2/{*.sql}", GLOB_BRACE);
            foreach ($archivos2 as $key2 => $archivo2) {
            $nombre2 = pathinfo($archivo2, PATHINFO_FILENAME);
            $extension2 = pathinfo($archivo2, PATHINFO_EXTENSION);
                echo    '<tr> 
                             <td> ' . ++$key2 . '</a></td>
                             <td><a href="' . $archivo2 . '"  download="' . $nombre2 . '"  >'   . $nombre2 . '.' . $extension2 . '</a></td>
                             <td align="center"><a href="' . $archivo2 . '" target="_blank" rel="noopener noreferrer"> <img src="sql.svg" alt="Girl in a jacket" width="40%" height="40%">  </a></td>                                        
                             <td>'. date ("Y/m/d H:i:s", filemtime($archivo2)).'</td>                                        
                         </tr>';
            }
            ?>

        </table>
    </form>
</body>

</html>