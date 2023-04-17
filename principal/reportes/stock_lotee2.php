<link href="css/style1.css" rel="stylesheet" type="text/css" />
<link href="css/tablas.css" rel="stylesheet" type="text/css" />

<style type="text/css">
    .Estilo1 {
        color: #333c87;
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

 <script>
        function editar_lote(valor) {
            var valor;

            //alert(valor); return; 
            var f = document.form1;
            ventana = confirm("Se editara el registro de este lote y no podra ser recuperado (No afectar\u00E1 el stock actual)");
            if (ventana) {
                f.method = "post";
                f.target = "_top";
                f.action = "reset_movlote.php?codigo=" + valor;
                f.submit();
            }
        }
    </script>
<?php
$hour = date('G');
//$hour   = CalculaHora($hour);
$min = date('i');
if ($hour <= 12) {
    $hor = "am";
} else {
    $hor = "pm";
}
if ($local <> 'all') {
    $sql = "SELECT nomloc,nombre FROM xcompa where codloc = '$local'";
    $result = mysqli_query($conexion, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $nloc = $row["nomloc"];
        $nombre = $row["nombre"];
        if ($nombre == '') {
            $locals = $nloc;
        } else {
            $locals = $nombre;
        }
    }
}
$dat1 = $date1;
$dat2 = $date2;
$date1 = fecha1($dat1);
$date2 = fecha1($dat2);
$doc = $_REQUEST['doc'];
$desc = $_REQUEST['desc'];  //descripcion de
if ($doc == 3) {
    $desc_tipo = "TODOS LOS PRODUCTOS";
}
if ($doc == 2) {
    $desc_tipo = "MARCA";
}
if ($doc == 1) {
    $desc_tipo = "PRODUCTO";
}


///modifcar lotes y vencimiento
$codpros = isset($_REQUEST['codpros']) ? ($_REQUEST['codpros']) : "";
$valform = isset($_REQUEST['valform']) ? ($_REQUEST['valform']) : "";
$country_ID = isset($_REQUEST['country_ID']) ? ($_REQUEST['country_ID']) : "";
$country = isset($_REQUEST['country']) ? ($_REQUEST['country']) : "";


// echo $country_ID;
// echo $country;

if ($valform == 1) {
    $colspan = '2';
    $accion = 'GRABAR / CANCELAR';
} else {
    $colspan = '1';
    $accion = 'MODIFICAR';
}
?>


<table width="930" border="0" align="center">
    <tr>
        <td>

            <body>
                <table width="100%" border="0" align="center">
                    <tr>
                        <td>
                            <table width="100%" border="0">
                                <tr>
                                    <td width="260"><strong><?php echo $desemp ?></strong></td>
                                    <td width="380">
                                        <div align="center"><strong>REPORTE DE STOCK POR LOTES </strong></div>
                                    </td>
                                    <td width="260">
                                        <div align="right"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div>
                                    </td>
                                </tr>

                            </table>
                            <table width="100%" border="0">
                                <tr>
                                    <td width="134"><strong> </strong></td>
                                    <td width="633">
                                        <div align="center"><b>REPORTE POR <?php echo $desc_tipo ?> - <?php echo $desc ?></b></div>
                                    </td>
                                    <td width="133">
                                        <div align="right">USUARIO:<span class="text_combo_select"><?php echo $user ?></span></div>
                                    </td>
                                </tr>
                            </table>
                            <div align="center"><img src="../../images/line2.png" width="100%" height="4" /></div>
                        </td>
                    </tr>
                </table>

    </tr>
</table>
<?php
if ($ckprod == 1) {
?>

    <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table width="100%" border="0" align="center">
                                <TR>
                                    <center>
                                        <h2>PRODUCTOS POR REVISAR </h2>
                                    </center>
                                </TR>
                            </table>

                        </td>
                    </tr>
                </table>

                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="customers">


                    <tr>
                        <td>
                            <?php
                            $zz = 0;
                            if ($vals == 2) {
                                if ($local == 'all') {
                                    $sql = "SELECT ML.idlote,ML.vencim,P.factor,P.stopro,P.codpro,P.stopro AS STOCKPRO,P.desprod,t.destab AS MARCA,ML.vencim,ML.codloc,ML.stock as stocklote,ML.numlote, ML.codloc, P.s000 AS sttotal from movlote AS ML  INNER JOIN producto AS  P  ON ML.codpro=P.codpro INNER JOIN titultabladet t on P.codmar = t.codtab  where  P.stopro<>ML.stock   and  P.stopro>0   and  ML.stock>0  order by ML.vencim ";
                                 
                                } else {
                                    $sql = "SELECT ML.idlote,ML.vencim,P.factor,P.stopro,P.codpro,P.stopro AS STOCKPRO,P.desprod,t.destab AS MARCA,ML.vencim,ML.codloc,ML.stock as stocklote,ML.numlote, ML.codloc, P.s000 AS sttotal from movlote AS ML  INNER JOIN producto AS  P  ON ML.codpro=P.codpro INNER JOIN titultabladet t on P.codmar = t.codtab  where  P.stopro<>ML.stock   and  P.stopro>0   and  ML.stock>0  AND ML.codloc='$local' order by ML.vencim ";    
                                
                                  
                                }
                            }

                           


                    
                           

                            $result = mysqli_query($conexion, $sql);
                            if (mysqli_num_rows($result)) {
                            ?>
                                <table width="100%" border="0" align="center">
                                    <tr>
                                        <th width="40">
                                            <div align="left"><strong>SUCURSAL </strong></div>
                                        </th>
                                        <th width="50">
                                            <div align="left"><strong>COD. PRODUCTO </strong></div>
                                        </th>
                                        <th width="70">
                                            <div align="left"><strong>PRODUCTO</strong></div>
                                        </th>
                                        <th width="55">
                                            <div align="left"><strong>MARCA</strong></div>
                                        </th>
                                           <th width="55">
                                            <div align="left"><strong>PROVEEDOR</strong></div>
                                        </th>
                                           <th width="55">
                                            <div align="left"><strong>Nº DOCUMENTO</strong></div>
                                        </th>
                                        <!--<th width="50"><div align="left"><strong>FECHA</strong></div></th>-->
                                        <th>
                                            <div align="left"><strong>STOCK</strong></div>
                                        </th>
                                        <th>
                                            <div align="left"><strong>N. LOTE</strong></div>
                                        </th>
                                        <th>
                                            <div align="left"><strong>FEVen</strong></div>
                                        </th>
                                     

                                    </tr>
                                    <?php
                                    while ($row = mysqli_fetch_array($result)) {
                                        $codpro = $row['codpro'];
                                        $STOCKPRO = $row['STOCKPRO'];
                                        $producto = $row['desprod'];
                                        $marca = $row['MARCA'];
                                        $venc = $row['vencim'];
                                        $codloc = $row['codloc'];
                                        $stocklote = $row['stocklote']; //$stocklote
                                        $numlote = $row['numlote'];
                                        $factor = $row['factor'];
                                        $idlote = $row['idlote'];
                                        $sttotal = $row['sttotal'];
                                        $stopro = $row['stopro'];

                                        $convert1 = $stocklote / $factor; //PRODUCTO
                                        $convert2 = $stopro / $factor; //MVLOTE
                                        $div1 = floor($convert1); //PRODUCTO
                                        $div2 = floor($convert2); //MVLOTE

                                        $UNI1 = ($stocklote - ($div1 * $factor));
                                        $UNI2 = ($stopro - ($div2 * $factor));

                                        $sql3 = "SELECT nomloc,nombre FROM xcompa where codloc = '$codloc'";
                                        $result3 = mysqli_query($conexion, $sql3);
                                        while ($row3 = mysqli_fetch_array($result3)) {
                                            $nloc = $row3["nomloc"];
                                            $nombre = $row3["nombre"];
                                            if ($nombre == '') {
                                                $sucur = $nloc;
                                            } else {
                                                $sucur = $nombre;
                                            }
                                            
                                        }
                                        
                                        
                                        
                                        
                                        $sql4 = "SELECT MA.cuscod,P.despro,MA.numero_documento,MA.numero_documento1 FROM `movmov` as MV INNER JOIN movmae MA ON MA.invnum=MV.invnum INNER JOIN proveedor AS P ON P.codpro=MA.cuscod where MV.numlote='$idlote' group by MV.numlote ";
                                        $result4 = mysqli_query($conexion, $sql4);
                                        while ($row4 = mysqli_fetch_array($result4)) {
                                            $cuscod = $row4["cuscod"];
                                            $despro = $row4["despro"];
                                            $numero_documento = $row4["numero_documento"];
                                            $numero_documento1 = $row4["numero_documento1"];
                                        }
                                    ?>
                                        <tr height="25" <?php if ($datDSDe2) { ?> bgcolor="#ff0000" <?php } else { ?>onmouseover="this.style.backgroundColor = '#FFFF99';this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '#ffffff';" <?php } ?>>
                                            <td width="150"><?php echo $sucur; ?></td>
                                            <td width="120"><?php echo $codpro; ?></td>
                                            <td width="160">
                                                <div align="left"><?php echo $producto; ?></div>
                                            </td>
                                            <td width="150">
                                                <div align="left"><?php echo $marca; ?></div>
                                            </td>
                                             <td width="150">
                                                <div align="left"><?php echo $cuscod; ?></div>
                                            </td>
                                             <td width="150">
                                                <div align="left"><?php echo $numero_documento . " " . $numero_documento1 ; ?></div>
                                            </td>
                                            <!--<td  width="120"><div align="center"><?php echo $venc; ?></div></td>-->
                                            <td width="134" align="left"><?php echo $div2 . "C" . " " . $UNI2 . " " . "unid"; ?></td>
                                            <td width="134"><?php echo $numlote; ?></td>
                                            <td width="134"><?php echo $venc; ?></td>
                                            
                                       

                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </table>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>


    <!--nooo-->
    <?php
} else {
    if (($ck == '') && ($ck1 == '')) {
        if (($val == 1) || ($vals == 2)) {

            $doc = $_REQUEST['doc'];
            if ($doc == 3) {
                $desc_tipo = "TODOS LOS PRODUCTOS";
            }
            if ($doc == 2) {
                $desc_tipo = "MARCA";
            }
            if ($doc == 1) {
                $desc_tipo = "PRODUCTO";
            }
    ?>
            <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <table width="100%" border="0" align="center">
                            <TR>
                                <center>
                                    <h2>BUSQUEDA POR <?php echo $desc_tipo ?> </h2>
                                </center>


                            </TR>
                        </table>

                    </td>
                </tr>
            </table>

            <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td>


                        <?php
                        if ($vals == 2) {
                            if ($local == 'all') {
                                if ($doc == 1) {
                                    $sql = "SELECT ML.idlote,ML.vencim,P.factor,P.stopro,P.codpro,P.stopro AS STOCKPRO,P.desprod,t.destab AS MARCA,ML.vencim,ML.codloc,ML.stock as stock,ML.numlote, ML.codloc,P.s000 AS sttotal from movlote AS ML  INNER JOIN producto AS  P  ON ML.codpro=P.codpro INNER JOIN titultabladet t on P.codmar = t.codtab  where  ((desprod like '$country%')||(P.codpro='$country_ID')||(P.codbar='%$desc%'))  AND  P.stopro>0  AND ML.stock > 0 order by ML.codpro ";
                                    //  echo $sql;
                                }
                                if ($doc == 2) {
                                    $sql = "SELECT ML.idlote,ML.vencim,P.factor,P.stopro,P.codpro,P.stopro AS STOCKPRO,P.desprod,t.destab AS MARCA,ML.vencim,ML.codloc,ML.stock as stock,ML.numlote, ML.codloc, P.s000 AS sttotal from movlote AS ML  INNER JOIN producto AS  P  ON ML.codpro=P.codpro INNER JOIN titultabladet t on P.codmar = t.codtab  where  tiptab = 'M' and destab like '$desc%'  and  P.stopro>0  AND ML.stock > 0 order by ML.codpro";
                             
                                    // echo $sql;
                                }
                                if ($doc == 3) {
                                    $sql = "SELECT  idlote,codpro,codloc,stock,numlote,vencim from movlote where stock >0  order by  codpro ";
                                    // echo $sql;
                                }
                            } else {
                                if ($doc == 1) {
                                    $sql = "SELECT ML.idlote,ML.vencim,P.factor,P.stopro,P.codpro,P.stopro AS STOCKPRO,P.desprod,t.destab AS MARCA,ML.vencim,ML.codloc,ML.stock as stock,ML.numlote, ML.codloc, P.s000 AS sttotal from movlote AS ML  INNER JOIN producto AS  P  ON ML.codpro=P.codpro INNER JOIN titultabladet t on P.codmar = t.codtab  where  desprod like '$desc%'  and  P.stopro>0 AND ML.stock > 0  AND ML.codloc='$local' and ML.codpro='$country_ID' order by ML.codpro ";
                                    echo $sql;
                                }
                                if ($doc == 2) {
                                    $sql = "SELECT ML.idlote,ML.idlote,ML.vencim,P.factor,P.stopro,P.codpro,P.stopro AS STOCKPRO,P.desprod,t.destab AS MARCA,ML.vencim,ML.codloc,ML.stock as stock,ML.numlote, ML.codloc, P.s000 AS sttotal from movlote AS ML  INNER JOIN producto AS  P  ON ML.codpro=P.codpro INNER JOIN titultabladet t on P.codmar = t.codtab  where  tiptab = 'M' and destab like '$desc%'  and  P.stopro>0 AND ML.stock > 0  AND ML.codloc='$local'   order by ML.codpro";
                                   // echo $sql;
                                    
                                }
                                if ($doc == 3) {
                                    $sql = "SELECT ML.idlote,ML.vencim,P.factor,P.stopro,P.codpro,P.stopro AS STOCKPRO,P.desprod,t.destab AS MARCA,ML.vencim,ML.codloc,ML.stock as stock,ML.numlote, ML.codloc, P.s000 AS sttotal from movlote AS ML  INNER JOIN producto AS  P  ON ML.codpro=P.codpro INNER JOIN titultabladet t on P.codmar = t.codtab  where  P.stopro>0 AND ML.stock > 0  AND ML.codloc='$local' and ML.codpro='$country_ID' order by ML.codpro ";
                                    // echo $sql;
                                }
                            }
                        }

                        

                        $zz = 0;
                        $i = 0;
                        $result = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($result)) {
                        ?>
                            <table width="100%" border="1" align="center" id="customers">
                                <thead>
                                <tr>
                                    <th width="5%">
                                        <div align="left"><strong>SUCURSAL </strong></div>
                                    </th>
                                    <th width="10%">
                                        <div align="left"><strong>CODIGO PRO</strong></div>
                                    </th>
                                    <th width="10%">
                                        <div align="center"><strong>PRODUCTO</strong></div>
                                    </th>
                                    <th width="10%">
                                        <div align="center"><strong>MARCA</strong></div>
                                    </th>
                                        <th width="55">
                                            <div align="left"><strong>PROVEEDOR</strong></div>
                                        </th>
                                           <th width="55">
                                            <div align="left"><strong>Nº DOCUMENTO</strong></div>
                                        </th>
                                                <th width="10%">
                                        <div align="center"><strong> STOCK (POR LOTE) </strong></div>
                                    </th>
                                    <th width="10%">
                                        <div align="center"><strong> FECHA VENCI. </strong></div>
                                    </th>
                                    
                                    <th width="10%">
                                        <div align="center"><strong>N&ordm;  LOTE</strong></div>
                                    </th>
                                    
                                 <!--    <th width="10%">
                                        <div align="center"><strong>EDITAR</strong></div>
                                    </th>-->
                                    
                                </tr>
                                
                                 </thead>
                                <tbody>
                                <?php
                                while ($row = mysqli_fetch_array($result)) {
                                    
                                    $i++;
                                    $codpro     = $row['codpro'];
                                    $codloc     = $row['codloc'];
                                    $stock      = $row['stock'];
                                    $numlote    = $row['numlote'];
                                    $venc       = $row['vencim'];
                                    $idlote       = $row['idlote'];
                                    
                                  
                                    $sql3 = "SELECT nomloc,nombre FROM xcompa where codloc = '$codloc'";
                                    $result3 = mysqli_query($conexion, $sql3);
                                    while ($row3 = mysqli_fetch_array($result3)) {
                                        $nloc = $row3["nomloc"];
                                        $nombre = $row3["nombre"];
                                        if ($nombre == '') {
                                            $sucur = $nloc;
                                        } else {
                                            $sucur = $nombre;
                                        }
                                    }
                                    
                                    $sql2 = "SELECT desprod,codmar,factor FROM producto WHERE codpro='$codpro'  ";
                                    $result1 = mysqli_query($conexion, $sql2);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $producto = $row1['desprod'];
                                            $codmar = $row1['codmar'];
                                            $factor = $row1['factor'];
                                        }
                                    }
                                    $sql2titultabladet = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar'";
                                            $result2titultabladet = mysqli_query($conexion, $sql2titultabladet);
                                            if (mysqli_num_rows($result2titultabladet)) {
                                                while ($row2 = mysqli_fetch_array($result2titultabladet)) {
                                                    $marca = $row2['destab'];
                                                    $abrev = $row2['abrev'];
                                                    if ($abrev <> '') {
                                                        $marca = $abrev;
                                                    }
                                                }
                                            }
                                            
                                            $despro='';
                                            $numero_documento='';
                                            $numero_documento1='';
                                                 $sql5 = "SELECT MA.cuscod,P.despro,MA.numero_documento,MA.numero_documento1 FROM `movmov` as MV INNER JOIN movmae MA ON MA.invnum=MV.invnum INNER JOIN proveedor AS P ON P.codpro=MA.cuscod where MV.numlote='$idlote' group by MV.numlote ";
                                        $result5 = mysqli_query($conexion, $sql5);
                                         if (mysqli_num_rows($result5)) {
                                        while ($row5 = mysqli_fetch_array($result5)) {
                                            $cuscod = $row5["cuscod"];
                                            $despro = $row5["despro"];
                                            $numero_documento = $row5["numero_documento"];
                                            $numero_documento1 = $row5["numero_documento1"];
                                         }
                                        } 
                                            
                                            
                           
                                    ?>
                                    
                                    <tr >
                                        <td><?php   echo $sucur.'--'.$idlote; ?></td>
                                        <td ><?php echo $codpro; ?></td>
                                        <td >
                                            <div align="left"><?php echo $producto; ?></div>
                                        </td>
                                        <td >
                                            <div align="left"><?php echo $marca; ?></div>
                                        </td>
                                          <td width="150">
                                                <div align="left"><?php echo $despro; ?></div>
                                            </td>
                                             <td width="150">
                                                <div align="left"><?php echo $numero_documento . " " . $numero_documento1 ; ?></div>
                                            </td>
                                        <td align="left"> <?php echo stockcaja($stock,$factor); ;?></td>
                                        <!--<td  align="left"> <?php echo $venc; ?></td>-->
                                        <td width="30">
                                            <div align="center">
                                                <input size='10'  class="Estilo1" type="readonly" name="vencimiento" id="vencimiento<?php echo $i; ?>" value=" <?php echo $venc ?>" onkeyup="cargarContenido(<?php echo $i ?>);"> 
                                                <input type="hidden" id="idlote<?php echo $i; ?>" value=" <?php echo $idlote; ?>" >
                                            </div>
                                        </td>
                                        <td width="30">
                                            <div align="center">
                                                <input size='10'  class="Estilo1" type="readonly" name="numeroLote" id="numeroLote<?php echo $i; ?>" value=" <?php echo $numlote ?>" onkeyup="cargarContenido(<?php echo $i ?>);"> 
                                                 <input type="hidden" id="idlote<?php echo $i; ?>" value=" <?php echo $idlote; ?>" >
                                            </div>
                                        </td>
                                        <!--<td  align="left"><?php  echo $numlote; ?></td>
                                              <td>
                                            <div align="center">

                                                <img src="editar.svg" width="25" height="25" onclick="editar_lote('<?php echo $idlote; ?>')" ; />

                                            </div>
                                        </td>-->
                                         
                                    </tr>



                                <?php } ?>
                                 <tbody>
                            </table>
                        <?php } else { ?>
                            <div class="siniformacion">
                                <center>
                                    No se logro encontrar informacion con los datos ingresados
                                </center>
                            </div>
                        <?php } ?>
                    </td>
                </tr>




            </table>
    <?php
        }
    }
   

    
}
?>

<script>
  $('#customers').DataTable({
       "pageLength": 100,
            language: {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "NingÃºn dato disponible en esta tabla =(",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Ãltimo",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                },
                "buttons": {
                    "copy": "Copiar",
                    "colvis": "Visibilidad"
                }
            }
        });
</script>
