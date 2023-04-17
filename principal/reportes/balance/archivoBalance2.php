<link href="../css/style1.css" rel="stylesheet" type="text/css" />
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />

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
</style>
<?php
$sql = "SELECT nomusu,codloc FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $user = $row['nomusu'];
        $codloc = $row['codloc'];
    }
}
$hour = date('G');
//$date	= CalculaFechaHora($hour);
$date = date("Y-m-d");
//$hour   = CalculaHora($hour);
$min = date('i');
if ($hour <= 12) {
    $hor = "am";
} else {
    $hor = "pm";
}


function convertir_a_numero($str)
{
    $legalChars = "%[^0-9\-\. ]%";
    $str = preg_replace($legalChars, "", $str);
    return $str;
}

?>

<body>
    <table width="100%" border="0" align="center">
        <tr>
            <td>
                <table width="100%" border="0">
                    <tr>
                        <td width="377"><strong><?php echo $desemp ?></strong></td>
                        <td width="205"><strong>REPORTE DE INGRESOS Y EGRESOS</strong></td>
                        <td width="284">
                            <div align="center"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <div align="center"><b> <?php
                                                    if ($local == 'all') {
                                                        echo 'TODOS LOS LOCALES';
                                                    } else {
                                                        echo $nomloc;
                                                    }
                                                    ?></b></div>
                        </td>
                        <td>
                            <div align="center">USUARIO:<span class="text_combo_select"><?php echo $user ?></span></div>
                        </td>
                    </tr>
                </table>

                <div align="center"><img src="../../../images/line2.png" width="100%" height="4" /></div>
            </td>
        </tr>
    </table>
    <?php
    if ($val == 1) {
    ?>
         
            <table width="100%" border="1" cellpadding="0" cellspacing="0" id="customers">
            <tr>
                      <th>CODIGO PRODUCTO</th>
                                     <th>DESCRIPCION</th>
                                     <th>MARCA/LABORATORIO</th>
                                     <th>FACTOR</th>
                                     <th>CANTIDAD INGRESO</th>
                                     <th>CANTIDAD SALIDA</th>
                                     <th>COMPARATIVA</th>
            </tr>
            <?php
            
            $date1 = fecha1($date1);
                        $date2 = fecha1($date2);
            $sumaIngresos='0';
            $sumaSalida='0';
           if($todo == 1){
           
            $sqlCodprod = "SELECT  codpro,sucursal,tipdoc,tipmov  FROM `kardex` WHERE  sucursal='$local' GROUP BY codpro,sucursal ";
           }else{
            $sqlCodprod = "SELECT  codpro,sucursal,tipdoc,tipmov  FROM `kardex` WHERE fecha BETWEEN '$date1' and '$date2' and sucursal='$local' GROUP BY codpro,sucursal ";
           }
         
            $resultCodprod = mysqli_query($conexion, $sqlCodprod);
            if (mysqli_num_rows($resultCodprod)) {
                while ($rowCodprod = mysqli_fetch_array($resultCodprod)) {
                    $codpro     = $rowCodprod['codpro'];
                    $sucursal   = $rowCodprod['sucursal'];
                    $tipmov     = $rowCodprod['tipmov'];
                    $tipdoc     = $rowCodprod['tipdoc'];
                    
                        $sql1 = "SELECT desprod,destab,factor FROM producto inner join titultabladet on codmar = codtab where codpro = '$codpro' ";
                                        $result1 = mysqli_query($conexion, $sql1);
                                        if (mysqli_num_rows($result1)) {
                                            while ($row1 = mysqli_fetch_array($result1)) {
                                                $desprod = $row1['desprod'];
                                                $destab = $row1['destab'];
                                                $factor = $row1['factor'];
                                                
                                            }
                                        }
                   
                   if($todo == 1){
                        $sqlIngreso = "SELECT codpro,sucursal,tipdoc,tipmov,qtypro,fraccion,factor FROM kardex WHERE  sucursal='$local'  and codpro='$codpro' and tipmov = '1'";
                   }else{
                       
                        $sqlIngreso = "SELECT codpro,sucursal,tipdoc,tipmov,qtypro,fraccion,factor FROM kardex WHERE fecha BETWEEN '$date1' and '$date2' and sucursal='$local'  and codpro='$codpro' and tipmov = '1'";
                   }
                        
                        $resultIngreso = mysqli_query($conexion, $sqlIngreso);
                        if (mysqli_num_rows($resultIngreso)) {
                            while ($rowIngreo = mysqli_fetch_array($resultIngreso)) {
                                        $codpro        = $rowIngreo['codpro'];
                                        $sucursal      = $rowIngreo['sucursal'];
                                        $tipdoc        = $rowIngreo['tipdoc'];
                                        $tipmov        = $rowIngreo['tipmov'];
                                        $qtypro        = $rowIngreo['qtypro'];
                                        $fraccion      = $rowIngreo['fraccion'];
                                        $factor        = $rowIngreo['factor'];
                                        
                                        
                                        if ($qtypro <>''){
                                            $cantidad= $qtypro * $factor;
                                        }else{
                                            $cantidad=  convertir_a_numero($fraccion);
                                        }
                                        
                                        $sumaIngresos +=$cantidad;
                                    }
                        }
                        if($todo == 1){
                        $sqlSalida = "SELECT codpro,sucursal,tipdoc,tipmov,qtypro,fraccion,factor FROM kardex WHERE  sucursal='$local'  and codpro='$codpro' and tipmov <> '1'";
                        }else{
                        $sqlSalida = "SELECT codpro,sucursal,tipdoc,tipmov,qtypro,fraccion,factor FROM kardex WHERE fecha BETWEEN '$date1' and '$date2' and sucursal='$local'  and codpro='$codpro' and tipmov <> '1'";
                        }
                        $resultSalida = mysqli_query($conexion, $sqlSalida);
                        if (mysqli_num_rows($resultSalida)) {
                            while ($rowSalida = mysqli_fetch_array($resultSalida)) {
                                        $codpro        = $rowSalida['codpro'];
                                        $sucursal      = $rowSalida['sucursal'];
                                        $tipdoc        = $rowSalida['tipdoc'];
                                        $tipmov        = $rowSalida['tipmov'];
                                        $qtypro        = $rowSalida['qtypro'];
                                        $fraccion      = $rowSalida['fraccion'];
                                        $factor        = $rowSalida['factor'];
                                        
                                        
                                        if ($qtypro <>'0'){
                                            $cantidad2= $qtypro * $factor;
                                        }else{
                                            $cantidad2=  convertir_a_numero($fraccion);
                                        }
                                        
                                        $sumaSalida +=$cantidad2;
                                    }
                        }
                   
                   
                    
                
            ?>
                   <tr>
                        <td><?php echo $codpro?></td>
                        <td><?php echo $desprod ?></td>
                        <td><?php echo $destab ?></td>
                        <td><?php echo $factor ?></td>
                        <td><?php echo stockcaja($sumaIngresos,$factor); ?></td>
                        <td><?php echo stockcaja($sumaSalida,$factor); ?></td>
                        <td><?php echo stockcaja(($sumaIngresos-$sumaSalida),$factor) ?></td>
                    </tr>
                <?php

                }
            } else {
                ?>
                <td colspan="14">
                    <center>
                        <h2>NO SE PUDO ENCONTRAR INFORMACION CON LOS DATOS INGRESADOS</h2>
                    </center>
                </td>
            <?php
            }

            ?>
        </table>



    <?php
    }
    ?>
</body>

</html>