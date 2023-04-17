<?php
require_once('../session_user.php');
require_once('../../conexion.php');
require_once('../../titulo_sist.php');
require_once('../../convertfecha.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $desemp ?></title>
        <link href="css/style1.css" rel="stylesheet" type="text/css" />
        <link href="css/tablas.css" rel="stylesheet" type="text/css" />
        <style>

            #customers {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;

            }

            #customers td, #customers th {
                border: 1px solid #ddd;
                padding: 3px;

            }

            #customers tr:nth-child(even){background-color: #f0ecec;}

            #customers tr:hover {background-color: #ddd;}

            #customers th {

                text-align: center;
                background-color: #50ADEA;
                color: white;
                font-size:12px;
                font-weight: 900;
            }
        </style>
    </head>
    <?php
    require_once("../../funciones/functions.php"); //DESHABILITA TECLAS
    require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUME
    $sql = "SELECT nomusu FROM usuario where usecod = '$usuario'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $user = $row['nomusu'];
        }
    }
    $hour = date(G);
//$date	= CalculaFechaHora($hour);
    $date = date("Y-m-d");
//$hour   = CalculaHora($hour);
    $min = date(i);
    if ($hour <= 12) {
        $hor = "am";
    } else {
        $hor = "pm";
    }
    ?>
    <body>
        <table width="100%" border="0" align="center">
            <tr>
                <td>
                    <table width="100%" border="0">
                        <tr>
                            <td width="377"><strong><?php echo $desemp ?></strong></td>
                            <td width="235"><strong>REPORTE DE PRODUCTOS SIN MARCAS</strong></td>
                            <td width="284"><div align="right"><strong>FECHA: <?php echo date('Y-m-d'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div></td>
                        </tr>
                    </table>
                    <table width="100%" border="0">
                        <tr>
                          <!--<td ></td>-->
                            <td ></td>
                            <td ><div align="right">USUARIO:<span class="text_combo_select"><?php echo $user ?></span></div></td>
                        </tr>
                    </table>

                </td>
            </tr>
        </table>

        <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">

            <tr>
                <td>
                    <?php
                    $sql = "SELECT codpro,desprod FROM producto where NOT EXISTS (SELECT * FROM titultabladet where tiptab = 'M' and titultabladet.codtab = producto.codmar) and eliminado='0' order by codpro";
                    $result = mysqli_query($conexion, $sql);
                    if (mysqli_num_rows($result)) {
                        ?>
                        <table width="100%" border="0" align="center" id="customers">
                            <tr>
                                <th ><strong>N&ordm;</strong></th>
                                <th ><div align="left"><strong>CODIGO</strong></div></th>
                                <th ><div align="left"><strong>PRODUCTO</strong></div></th>
                            </tr>
                            <?php
                            while ($row = mysqli_fetch_array($result)) {
                                $producto = $row['desprod'];
                                $marca = $row['codmar'];
                                $stopro = $row['stopro'];
                                $prevta = $row['prevta'];
                                $factor = $row['factor'];
                                $stopro = $row[4];
                                $codpro = $row['codpro'];
                                $i++;
                                ?>
                                <tr height="25"  <?php if ($datDSDe2) { ?> bgcolor="#ff0000"<?php } else { ?>onmouseover="this.style.backgroundColor = '#FFFF99';this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '#ffffff';"<?php } ?>>
                                    <td ><?php echo $i ?>-</td>
                                    <td ><?php echo $codpro ?></td>
                                    <td ><?php echo $producto ?></td>
                                </tr>
                            <?php }
                            ?>
                        </table>
                        <?php
                    } else {
                        ?>
                        <center>No se logro encontrar informacion</center>
                    <?php }
                    ?>
                </td>
            </tr>
        </table>
    </body>
</html>
