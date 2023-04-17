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

<?php
$hour = date(G);
//$hour   = CalculaHora($hour);
$min = date(i);
if ($hour <= 12) {
    $hor = "am";
} else {
    $hor = "pm";
}

function getMonthDays($Month, $Year) {
    //Si la extensi�n que mencion� est� instalada, usamos esa. 
    if (is_callable("cal_days_in_month")) {
        return cal_days_in_month(CAL_GREGORIAN, $Month, $Year);
    } else {
        //Lo hacemos a mi manera. 
        return date("d", mktime(0, 0, 0, $Month + 1, 0, $Year));
    }
}

if ($mes == 1) {
    $mesx = "ENERO";
}
if ($mes == 2) {
    $mesx = "FEBRERO";
}
if ($mes == 3) {
    $mesx = "MARZO";
}
if ($mes == 4) {
    $mesx = "ABRIL";
}
if ($mes == 5) {
    $mesx = "MAYO";
}
if ($mes == 6) {
    $mesx = "JUNIO";
}
if ($mes == 7) {
    $mesx = "JULIO";
}
if ($mes == 8) {
    $mesx = "AGOSTO";
}
if ($mes == 9) {
    $mesx = "SETIEMBRE";
}
if ($mes == 10) {
    $mesx = "OCTUBRE";
}
if ($mes == 11) {
    $mesx = "NOVIEMBRE";
}
if ($mes == 12) {
    $mesx = "DICIEMBRE";
}
?>
<body>
    <table width="100%" border="0" align="center">
        <tr>
            <td><table width="100%" border="0">
                    <tr>
                        <td width="260"><strong><?php echo $desemp ?></strong></td>
                        <td width="380"><div align="center"><strong>REPORTES MENSUALES</strong></div></td>
                        <td width="260"><div align="right"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div></td>
                    </tr>

                </table>
                <table width="100%" border="0">
                    <tr>
                        <td width="134"><strong>PAGINA <?php echo $pagina; ?> de <?php echo $tot_pag ?></strong></td>
                        <td width="633"><div align="center">
                                <b><?php if ($val == 1) { ?> <?php
                                        echo $mesx;
                                        echo " ";
                                        echo $year;
                                    }
                                    ?></b>
                            </div>
                        </td>
                        <td width="133"><div align="right">USUARIO:<span class="text_combo_select"><?php echo $user ?></span></div></td>
                    </tr>
                </table>
                <div align="center"><img src="../../images/line2.png" width="100%" height="4" /></div></td>
        </tr>
    </table>


    <?php
    if ($local == "all") {
        $sql1 = "SELECT * FROM reporteunico where mes = '$mes' and anio = '$year' order by codpro LIMIT $inicio, $registros";
    } else {
        $sql1 = "SELECT * FROM reporteunico where mes = '$mes' and anio = '$year' and codloc = '$local' order by codpro LIMIT $inicio, $registros";
    }
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        ?>
        <table width="100%" border="0" align="center" id="customers">
            <tr>
                <th width="130"><strong>LOCAL</strong></th>
                <th width="409"><strong>PRODUCTO</strong></th>
                <th width="126"><strong>MARCA</strong></th>
                <th width="94"><div align="right"><strong>INGRESOS</strong></div></th>
                <th width="74"><div align="right"><strong>SALIDAS</strong></div></th>
                <th width="71"><div align="right"><strong>FINAL</strong></div></th>
            </tr>
            <?php
            while ($row1 = mysqli_fetch_array($result1)) {
                $codpro = $row1['codpro'];
                $codmar = $row1['codmar'];
                $ingresos = $row1['ingresos'];
                $salidas = $row1['salidas'];
                $codloc = $row1['codloc'];
                $stockfinal = $row1['stockfinal'];
                $stockini = $row1['stockini'];
                $sql2 = "SELECT desprod FROM producto where codpro = '$codpro' and eliminado='0'";
                $result2 = mysqli_query($conexion, $sql2);
                if (mysqli_num_rows($result2)) {
                    while ($row2 = mysqli_fetch_array($result2)) {
                        $desprod = $row2['desprod'];
                    }
                }
                $sql2 = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar'";
                $result2 = mysqli_query($conexion, $sql2);
                if (mysqli_num_rows($result2)) {
                    while ($row2 = mysqli_fetch_array($result2)) {
                        $destab = $row2['destab'];
                        $abrev = $row2['abrev'];
                        if ($abrev <> '') {
                            $destab = $abrev;
                        }
                    }
                }
                $sql2 = "SELECT nomloc,nombre FROM xcompa where codloc = '$codloc'";
                $result2 = mysqli_query($conexion, $sql2);
                if (mysqli_num_rows($result2)) {
                    while ($row2 = mysqli_fetch_array($result2)) {
                        $nomloc = $row2['nomloc'];
                        $nombre = $row2['nombre'];
                    }
                }
                if ($nombre <> "") {
                    $nomloc = $nombre;
                }
                $stockfinal = ($stockini + $ingresos) - $salidas;
                ?>

                <tr height="25"  <?php if ($datDSDe2) { ?> bgcolor="#ff0000"<?php } else { ?>onmouseover="this.style.backgroundColor = '#FFFF99';this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '#ffffff';"<?php } ?>>
                    <td width="130"><?php echo $nomloc ?></td>
                    <td width="409"><?php echo $desprod ?></td>
                    <td width="126"><?php echo $destab ?></td>
                    <td width="94"><div align="right"><?php echo $ingresos ?></div></td>
                    <td width="74"><div align="right"><?php echo $salidas ?></div></td>
                    <td width="71"><div align="right"><?php echo $stockfinal ?></div></td>
                </tr>

            <?php }
            ?>
        </table>
        <?php
    } else {
        echo "<br><br><center><b>No se logr� encontrar informaci�n con los datos seleccionados</b></center>";
    }
    ?>
</body>
</html>
