<?php

require('conexion.php');
require_once('convertfecha.php');
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=SIST_EXPORT_DATA.xls");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <title></title>

        <style type="text/css">
                .Estilo1 {
                        color: #FF0000;
                        font-weight: bold;
                }
        </style>
        <style>
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

                .campo {
                        font-size: 18px;
                        color: red;
                }
        </style>
</head>
<?php
/////////////////////////////7
$local = '7';
/////////////////////777

$sql = "SELECT nomloc,nombre FROM xcompa where codloc = '$local'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
                $nomlocalG = $row['nomloc'];
                $nombre = $row['nombre'];
        }
}


$numero_xcompa = substr($nomlocalG, 5, 2);
$tabla = "s" . str_pad($numero_xcompa, 3, "0", STR_PAD_LEFT);


?>

<body>

        <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
                <tr>
                        <td>
                                <table width="100%" border="0" align="center" id="customers">
                                        <tr>

                                                <td colspan="8" class="campo">
                                                        <div align="center"><strong>REPORTES DE POR MARCAS  </strong></div>
                                                </td>

                                        </tr>
                                        <tr>
                                                <th width="1%"><strong>N?</strong></th>
                                                <th width="5%">
                                                        <div align="center"><strong>CODIGO </strong></div>
                                                </th>
                                                <th width="45%">
                                                        <div align="center"><strong>PRODUCTO </strong></div>
                                                </th>
                                                <th width="5%">
                                                        <div align="center"><strong>FACTOR </strong></div>
                                                </th>
                                                <th width="14%">
                                                        <div align="center"><strong>MARCA/LABORATORIO</strong></div>
                                                </th>
                                                <th width="14%">
                                                        <div align="center"><strong>PRINCIPIO ACTIVO</strong></div>
                                                </th>
                                                <th width="15%">
                                                        <div align="center"><strong>ACCION TERAPEUTICA</strong></div>
                                                </th>
                                                <th width="15%">
                                                        <div align="center"><strong>PRESENTACION</strong></div>
                                                </th>
                                        </tr>
                                        <?php
                                        $sql = "SELECT codpro,desprod,codmar,$tabla,factor,codfam,coduso,codpres FROM producto where codmar ='423' ";
                                        $result = mysqli_query($conexion, $sql);
                                        if (mysqli_num_rows($result)) {
                                                while ($row = mysqli_fetch_array($result)) {
                                                        $i++;
                                                        $codpro = $row['codpro'];
                                                        $desprod = $row['desprod'];
                                                        $codmar = $row['codmar'];
                                                        $stock = $row[3];
                                                        $factor = $row['factor'];
                                                        
                                                        $codfam = $row['codfam'];
                                                        $coduso = $row['coduso'];
                                                        $codpres = $row['codpres'];
                                                        
                                                        $sql1 = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar'";
                                                        $result1 = mysqli_query($conexion, $sql1);
                                                        if (mysqli_num_rows($result1)) {
                                                                while ($row1 = mysqli_fetch_array($result1)) {
                                                                        $destab = $row1['destab'];
                                                                        $abrev = $row1['abrev'];
                                                                        $destab2 = $row1['destab'];
                                                                         
                                                                }
                                                        }
                                                        
                                                        $sql1 = "SELECT destab,abrev FROM titultabladet where codtab = '$codfam'";
                                                        $result1 = mysqli_query($conexion, $sql1);
                                                        if (mysqli_num_rows($result1)) {
                                                                while ($row1 = mysqli_fetch_array($result1)) {
                                                                        $princioActivo = $row1['destab'];
                                                                        
                                                                }
                                                        }
                                                        
                                                        $sql1 = "SELECT destab,abrev FROM titultabladet where codtab = '$coduso'";
                                                        $result1 = mysqli_query($conexion, $sql1);
                                                        if (mysqli_num_rows($result1)) {
                                                                while ($row1 = mysqli_fetch_array($result1)) {
                                                                        $accionTeraputica = $row1['destab'];
                                                                        
                                                                }
                                                        }
                                                        $sql1 = "SELECT destab,abrev FROM titultabladet where codtab = '$codpres'";
                                                        $result1 = mysqli_query($conexion, $sql1);
                                                        if (mysqli_num_rows($result1)) {
                                                                while ($row1 = mysqli_fetch_array($result1)) {
                                                                        $presentacion = $row1['destab'];
                                                                        
                                                                }
                                                        }
                                        ?>
                                                        <tr>
                                                                <td><div align="center"><?php echo $i; ?></div></td>
                                                                <td><div align="center"><?php echo $codpro; ?></div></td>
                                                                <td><div align="left"><?php echo $desprod; ?></div></td>
                                                                <td><div align="center"><?php echo $factor; ?></div></td>
                                                                <td><div align="left"><?php echo $destab; ?></div></td>
                                                                <td><div align="left"><?php echo $princioActivo; ?></div></td>
                                                                <td><div align="left"><?php echo $accionTeraputica; ?></div></td>
                                                                <td><div align="left"><?php echo $presentacion; ?></div></td>
                                                                 
                                                        </tr>
                                                <?php
                                                }
                                        } else {
                                                ?>
                                                <tr>
                                                        <td colspan="8" class="campo">
                                                                <div align="center"><strong>no se encontro ningun resultado</strong></div>
                                                        </td>
                                                </tr>
                                        <?php } ?>
                                </table>
                        </td>
                </tr>
        </table>
</body>

</html>