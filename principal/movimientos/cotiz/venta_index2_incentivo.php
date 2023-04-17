<?php
require_once('../../session_user.php');
$venta = $_SESSION['venta'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <style>
        a:link,
        a:visited {
            color: #0066CC;
            border: 0px solid #e7e7e7;
        }

        a:hover {
            background: #fff;
            border: 0px solid #ccc;
        }

        a:focus {
            background-color: #FFFF99;
            color: #0066CC;
            border: 0px solid #ccc;
        }

        a:active {
            background-color: #FFFF99;
            color: #0066CC;
            border: 0px solid #ccc;
        }
    </style>
    <style type="text/css">
        .Estilo1 {
            color: #ffffff;
            font-weight: bold;
        }

        .Estilo2 {
            color: #ff0000;
            font-weight: bold;
        }

        .Estilo3 {
            font-style: italic;
            font-weight: bold;
            font-size: 2em;
            font-color: #ffffff;
            font-family: 'Helvetica', 'Verdana', 'Monaco', sans-serif;
        }

        input {
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            background-color: white;
            background-position: 3px 3px;
            background-repeat: no-repeat;
            padding: 2px 1px 2px 5px;

        }


        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;

        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 1px;

        }

        #customers td a {
            color: #4d9ff7;
            font-weight: bold;

            text-decoration: none;

        }

        #customers #total {

            text-align: center;
            background-color: #9ebcc1;
            color: white;
            font-size: 14px;
            font-weight: 900;
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
            font-size: 10px;
            font-weight: 900;
        }
    </style>
    <?php
    require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS
    //require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
    require_once('funciones/datos_generales.php'); //////CODIGO Y NOMBRE DEL LOCAL
    require_once('../../../funciones/botones.php'); //COLORES DE LOS BOTONES
    require_once('../../local.php'); //LOCAL DEL USUARIO
    ?>
    <script>
        function getfocus1() {
            document.getElementById('l1').focus();
        }

        function cerrar(e) {
            tecla = e.keyCode
            if (tecla == 27) {
                window.close();
            }
        }

        function cerrar_popup(valor) {
            //ventana=confirm("Desea Grabar este Cliente");
            var prod = valor;
            document.form1.target = "venta_principal";
            window.opener.location.href = "salir.php?prod=" + prod;
            self.close();
        }
    </script>
    <title>LISTADO DE PRODUCTOS INCENTIVADOS</title>
    <link href="../css/tablas.css" rel="stylesheet" type="text/css" />
    <!-- style type="text/css">
                .Estilo2 {color: #FFFFFF; font-weight: bold; }
                .Estilo3 {color: #FFFFFF}
        </style -->
</head>

<body onload="getfocus1()" onkeyup="cerrar(event)">
    <form name="form1">
        <table width="80%" border="0" id="customers">
            <tr>

                <th><span class="Estilo3">INCENTIVO</span></th>
                <th><span class="Estilo3">CODIGO</span></th>
                <th><span class="Estilo3">PRODUCTO</span></th>
                <th><span class="Estilo3">MARCA</span></th>
                <th><span class="Estilo3">LINEA DE PRODUCTO</span></th>
                <th>
                    <div align="center"><span class="Estilo3">CANTIDAD</span></div>
                </th>
                <th>
                    <div align="center"><span class="Estilo3">MONTO</span></div>
                </th>
                <th>
                    <div align="center"><span class="Estilo3">P. MINIMO</span></div>
                </th>
                <th>
                    <div align="center"><span class="Estilo3">CUOTA</span></div>
                </th>
            </tr>
            <?php
            $i = 1;

            function formato($s)
            {
                printf('%05d', $s);
            }

            $sql1 = "SELECT codloc FROM xcompa where nomloc = 'LOCAL0'";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $localp = $row1['codloc'];
                }
            }
            $sqlss = "SELECT invnum FROM incentivado where estado = '1'";
            $resultss = mysqli_query($conexion, $sqlss);
            if (mysqli_num_rows($resultss)) {
                while ($rowss = mysqli_fetch_array($resultss)) {
                    $invnum = $rowss['invnum'];
                    $sql = "SELECT producto.codpro,producto.factor,desprod,canprocaj,canprounid,pripro,pripromin,cuota,codloc,codmar,codfam FROM producto inner join incentivadodet on producto.codpro = incentivadodet.codpro where invnum = '$invnum' and ((codloc = '$codigo_local') or (codloc = '$localp')) and incentivadodet.estado = '1' order by desprod";
                    $result = mysqli_query($conexion, $sql);
                    if (mysqli_num_rows($result)) {
                        while ($row = mysqli_fetch_array($result)) {
                            $codpro = $row['codpro'];
                            $factor = $row['factor'];
                            $desprod = $row['desprod'];
                            $canprocaj = $row['canprocaj'];
                            $canprounid = $row['canprounid'];
                            $pripro = $row['pripro'];
                            $pripromin = $row['pripromin'];
                            $cuota = $row['cuota'];
                            $codloc = $row['codloc'];
                            $codmar = $row['codmar'];
                            $codfam = $row['codfam'];
                            $sql1 = "SELECT nomloc FROM xcompa where codloc = '$codloc'";
                            $result1 = mysqli_query($conexion, $sql1);
                            if (mysqli_num_rows($result1)) {
                                while ($row1 = mysqli_fetch_array($result1)) {
                                    $nomloc = $row1['nomloc'];
                                }
                            }
                            $sql1 = "SELECT destab FROM titultabladet where codtab = '$codmar'";
                            $result1 = mysqli_query($conexion, $sql1);
                            if (mysqli_num_rows($result1)) {
                                while ($row1 = mysqli_fetch_array($result1)) {
                                    $mark = $row1['destab'];
                                }
                            }
                            $sql1 = "SELECT destab FROM titultabladet where codtab = '$codfam'";
                            $result1 = mysqli_query($conexion, $sql1);
                            if (mysqli_num_rows($result1)) {
                                while ($row1 = mysqli_fetch_array($result1)) {
                                    $class = $row1['destab'];
                                }
                            }
                            if ($canprocaj == 0) {
                                $cantt = $canprounid;
                                $desc = "Unid";
                            } else {
                                $cantt = $canprocaj;
                                $desc = "Cajas";
                            }
            ?>
                            <tr onmouseover="this.style.backgroundColor = '#FFFF99';this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '#ffffff';">
                                <td><a id="l1" href="javascript:cerrar_popup(<?php echo $codpro ?>)"><?php echo formato($invnum) ?></a></td>
                                <td align="center">
                                    <div><?php echo $codpro; ?></div>
                                </td>
                                <td><a id="l1" href="javascript:cerrar_popup(<?php echo $codpro ?>)"><?php echo $desprod ?></a></td>

                                <td>
                                    <div><?php echo substr($mark, 0, 40); ?></div>
                                </td>
                                <td>
                                    <div align="center"><?php echo substr($class, 0, 50); ?></div>
                                </td>
                                <td>
                                    <div align="center"><?php echo $cantt;
                                                        echo " ";
                                                        echo $desc; ?></div>
                                </td>
                                <td>
                                    <div align="center"><?php echo $pripro ?></div>
                                </td>
                                <td>
                                    <div align="center"><?php echo $pripromin ?></div>
                                </td>
                                <td>
                                    <div align="center"><?php echo $cuota ?></div>
                                </td>
                            </tr>
            <?php
                            ++$i;
                        }
                    }
                }
            }
            ?>
        </table>
    </form>
    <?php
    mysqli_free_result($result);
    mysqli_free_result($result1);
    mysqli_free_result($resultss);
    mysqli_close($conexion);
    ?>
</body>

</html>