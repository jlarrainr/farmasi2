<?php require_once('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>Documento sin t&iacute;tulo</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../css/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../../../funciones/alertify/alertify.min.css" rel="stylesheet" />
    <script src="../../../funciones/alertify/alertify.min.js"></script>
    <?php require_once('../../../conexion.php');    //CONEXION A BASE DE DATOS
    require_once('../../../convertfecha.php');    //CONEXION A BASE DE DATOS
    require_once('../../../funciones/highlight.php');    //ILUMINA CAJAS DE TEXTOS
    require_once('../../../funciones/functions.php');    //DESHABILITA TECLAS
    require_once('../../../funciones/botones.php');    //COLORES DE LOS BOTONES
    require_once('../../../funciones/funct_principal.php');    //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    require_once('../funciones/guiaremision.php');    //FUNCIONES DE ESTA PANTALLA
    require_once('../../local.php');    //LOCAL DEL USUARIO
    $sql1 = "SELECT nomusu,codgrup,codloc FROM usuario where usecod = '$usuario'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $user       = $row1['nomusu'];
            $codgrup    = $row1['codgrup'];
            $codloc    = $row1['codloc'];
        }
    }


    $sql = "SELECT anular_venta_vendedor FROM datagen";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $anular_venta_vendedor = $row['anular_venta_vendedor'];
        }
    }
    if ($anular_venta_vendedor == 1) {
        $sql1X = "SELECT codgrup FROM grupo_user where codgrup = '$codgrup' AND (NOMGRUP LIKE '%ADMINISTRADOR%' OR NOMGRUP LIKE '%SUPERVISOR%' OR NOMGRUP LIKE '%VENDEDO%')";
    } else {
        $sql1X = "SELECT codgrup FROM grupo_user where codgrup = '$codgrup' AND (NOMGRUP LIKE '%ADMINISTRADOR%' OR NOMGRUP LIKE '%SUPERVISOR%')";
    }
    $result1X = mysqli_query($conexion, $sql1X);
    if (mysqli_num_rows($result1X)) {
        $PermisoDEL = 1; //PERMISO PARA BORRAR
    } else {
        $PermisoDEL = 0; //NO TIENE PERMISO PARA BORRAR
    }

    $pag = $_REQUEST['pageno'];
    if (isset($_REQUEST['pageno'])) {
        $pageno = $_REQUEST['pageno'];
    } else {
        $pageno = 1;
    }
    $sql = "SELECT count(*) FROM sd_despatch where  sucursal = '$codloc'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $numrows             = $row[0];
        }
    }


    $num  = $_REQUEST['num'];
    $tip  = $_REQUEST['tip'];
    $retorno     = $_REQUEST['retorno'];


    if ($retorno <> "") {
        $tip = 1;
    }

    if ($num == "") {
        $num = $retorno;
    } else {
        $num = $num;
    }
    if ($tip == 1) {
        $sql = "SELECT count(*) FROM sd_despatch where   despatch_uid <= '$num'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $pageno             = $row[0];
            }
        }
    }
    ?>
    <script language="javascript">
        function salirx() {
            var f = document.form1;
            //alert("hola");
            f.method = "POST";
            f.target = "_top";
            f.action = "../../index.php";
            f.submit();
        }
    </script>
    <style>
        .botones {
            width: 100%;
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
    </style>
</head>

<body>
    <form name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)">
        <table width="100%" border="0">
            <tr>
                <td width="938">
                    <table width="100%" border="0">
                        <tr>
                            <td width="130" class="LETRA">NUMERO DE DOCUMENTO </td>

                            <td width="610">
                                <input name="num" type="text" id="num" size="15" onkeypress="return ent1(event),this.value = this.value.toUpperCase();" />
                                <input name="tip" type="hidden" id="tip" value="1" />
                                <img style="margin-bottom: -3px;" width="2.5%" height="2.5%" src="question.svg" title="Para buscar una Guia de Remision, escribir la serie(exactamente igual) y correlativo(este ultimo obviando los ceros restantes de izquierda), ejemplo: para buscar T000-0000001 escribir T000-1  o por numero interno.">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="button" name="Submit" value="BUSCAR" class="buscar" onclick="buscar_venta()" />
                            </td>



                            <td width="314">
                                <div align="right" class="text_combo_select">USUARIO : <img src="../../../images/user.gif" width="15" height="16" /><?php echo $user ?></div>
                            </td>
                        </tr>
                    </table>
                    <?php /////////////////////////////////
                    $rows_per_page = 1;
                    $lastpage      = ceil($numrows / $rows_per_page);
                    $pageno        = (int)$pageno;
                    if ($pageno > $lastpage) {
                        $pageno = $lastpage;
                    } // if
                    if ($pageno < 1) {
                        $pageno = 1;
                    } // if

                    $limit = 'LIMIT ' . ($pageno - 1) * $rows_per_page . ',' . $rows_per_page;




                    //echo '   $limit ' .   $limit . '<br>';

                    if ($tip == 1) {
                        if (!is_numeric($num[0])) {
                            $sql = "SELECT despatch_id,despatch_uid,issueDate,note,partyIdentification,partyName,deliveryCustomerAccountID,deliveryName,information,grossWeightMeasure,unitCodeWeightMeasure,totalUnitQuantity,transportModeCode,startDate,carrierPartyID,carrierPartyName,deliveryAddressId,deliveryStreetName,transportEquipmentId,originAddressId,originAddressStreetName,sucursal,invnumold,serie_doc,issuetime,tipo_afectacion FROM sd_despatch where (despatch_id = '$num' or despatch_uid = '$num' )  and sucursal = '$codigo_local'";
                        } elseif ($nombre_local == 'LOCAL0') {
                            $sql = "SELECT despatch_id,despatch_uid,issueDate,note,partyIdentification,partyName,deliveryCustomerAccountID,deliveryName,information,grossWeightMeasure,unitCodeWeightMeasure,totalUnitQuantity,transportModeCode,startDate,carrierPartyID,carrierPartyName,deliveryAddressId,deliveryStreetName,transportEquipmentId,originAddressId,originAddressStreetName,sucursal,invnumold,serie_doc,issuetime,tipo_afectacion  FROM sd_despatch where (despatch_id = '$num' or despatch_uid = '$num')  and sucursal = '$codigo_local'";
                        } else {
                            $sql = "SELECT despatch_id,despatch_uid,issueDate,note,partyIdentification,partyName,deliveryCustomerAccountID,deliveryName,information,grossWeightMeasure,unitCodeWeightMeasure,totalUnitQuantity,transportModeCode,startDate,carrierPartyID,carrierPartyName,deliveryAddressId,deliveryStreetName,transportEquipmentId,originAddressId,originAddressStreetName,sucursal,invnumold,serie_doc,issuetime,tipo_afectacion FROM sd_despatch where (despatch_id = '$num' or despatch_uid = '$num')  and sucursal = '$codigo_local'";
                        }
                    } else {
                        if ($nombre_local == 'LOCAL0') {
                            $sql = "SELECT despatch_id,despatch_uid,issueDate,note,partyIdentification,partyName,deliveryCustomerAccountID,deliveryName,information,grossWeightMeasure,unitCodeWeightMeasure,totalUnitQuantity,transportModeCode,startDate,carrierPartyID,carrierPartyName,deliveryAddressId,deliveryStreetName,transportEquipmentId,originAddressId,originAddressStreetName,sucursal,invnumold,serie_doc,issuetime,tipo_afectacion  FROM sd_despatch where sucursal = '$codigo_local' order by despatch_uid asc $limit";
                        } else {
                            $sql = "SELECT despatch_id,despatch_uid,issueDate,note,partyIdentification,partyName,deliveryCustomerAccountID,deliveryName,information,grossWeightMeasure,unitCodeWeightMeasure,totalUnitQuantity,transportModeCode,startDate,carrierPartyID,carrierPartyName,deliveryAddressId,deliveryStreetName,transportEquipmentId,originAddressId,originAddressStreetName,sucursal,invnumold,serie_doc,issuetime,tipo_afectacion FROM sd_despatch where sucursal = '$codigo_local' order by despatch_uid asc $limit";
                        }
                    }

                    $result = mysqli_query($conexion, $sql);
                    if (mysqli_num_rows($result)) {
                        while ($row = mysqli_fetch_array($result)) {


                            $despatch_id                    = $row['despatch_id'];
                            $despatch_uid                   = $row['despatch_uid'];        //codigo
                            $issueDate                      = $row['issueDate'];
                            $note                           = $row['note'];
                            $partyIdentification            = $row['partyIdentification'];
                            $partyName                      = $row['partyName'];
                            $deliveryCustomerAccountID      = $row['deliveryCustomerAccountID'];
                            $deliveryName                   = $row['deliveryName'];
                            $information                    = $row['information'];
                            $grossWeightMeasure             = $row['grossWeightMeasure'];
                            $unitCodeWeightMeasure          = $row['unitCodeWeightMeasure'];
                            $totalUnitQuantity              = $row['totalUnitQuantity'];
                            $transportModeCode              = $row['transportModeCode'];
                            $startDate                      = $row['startDate'];
                            $carrierPartyID                 = $row['carrierPartyID'];
                            $carrierPartyName               = $row['carrierPartyName'];
                            $deliveryAddressId              = $row['deliveryAddressId'];
                            $deliveryStreetName             = $row['deliveryStreetName'];
                            $transportEquipmentId           = $row['transportEquipmentId'];
                            $originAddressId                = $row['originAddressId'];
                            $originAddressStreetName        = $row['originAddressStreetName'];
                            $sucursal                       = $row['sucursal'];
                            $invnumold                      = $row['invnumold'];
                            $serie_doc                      = $row['serie_doc'];
                            $issuetime                      = $row['issuetime'];
                            $tipo_afectacion                = $row['tipo_afectacion'];



                            $encontrado      = 1;
                            $dctos           = $bruto - $valven;


                        
                        }

                        $sqlCalculo = "SELECT deliveredQuantity,unitCode,nameProduct,amountPrice,amountTotal,amountTaxted,igvTax  FROM sd_despatch_line  WHERE despatch_uid = '$despatch_uid'";
                        $resultCalculo = mysqli_query($conexion, $sqlCalculo);
                        if (mysqli_num_rows($resultCalculo)) {
                             while ($row = mysqli_fetch_array($resultCalculo)) {
                                
                                $deliveredQuantity  = $row['deliveredQuantity'];
                                $unitCode           = $row['unitCode'];
                                $nameProduct        = $row['nameProduct'];
                                $amountPrice        = $row['amountPrice'];
                                $amountTotal        = $row['amountTotal'];
                                $amountTaxted       = $row['amountTaxted'];
                                $igvTax             = $row['igvTax'];

                                $sumaTotal = $deliveredQuantity * $amountPrice;
                                

                            }
                        }

                        $sql = "SELECT sum(amountTotal),sum(amountTaxted),sum(igvTax)  FROM sd_despatch_line where despatch_uid = '$despatch_uid'";

                            $result = mysqli_query($conexion, $sql);
                            if (mysqli_num_rows($result)) {
                                while ($row = mysqli_fetch_array($result)) {
                                    $tot = $row[0];
                                    $tot1 = $row[1];
                                    $totigv = $row[2];
                                }
                            }

                        

                        
                        $sql1 = "SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $nomloc1    = $row1['nomloc'];
                                $nomloc2    = $row1['nombre'];
                            }
                        }
                        if ($nomloc2 == "") {
                            $nomloc = $nomloc1;
                        } else {
                            $nomloc = $nomloc2;
                        }
                        $sql1 = "SELECT descli,email FROM cliente where codcli = '$cuscod'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $cliente_venta  = $row1['descli'];
                                $email  = $row1['email'];
                            }
                        }
                        if ($email == "") {
                            $correo = '';
                        } else {
                            $correo = $email;
                            $ncorreo = '   correo = ' . $correo;
                        }



                        $sql = "SELECT nommedico,codcolegiatura FROM medico  WHERE codmed = '$codmed'";
                        $result = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($result)) {
                            while ($row = mysqli_fetch_array($result)) {
                                $nommedico2     = $row['nommedico'];
                                $codcolegiatura2   = $row['codcolegiatura'];
                            }
                        }

                        

                        $sql3 = "SELECT invnum,forpag,usecod,cuscod,val_habil FROM venta  WHERE invnum = '$invnumold'";
                        $result3 = mysqli_query($conexion, $sql3);
                        if (mysqli_num_rows($result3)) {
                             while ($row = mysqli_fetch_array($result3)) {
                                $invnum   = $row['invnum'];
                                $forpag   = $row['forpag'];
                                $usecod   = $row['usecod'];
                                $cuscod   = $row['cuscod'];
                                $val_habil   = $row['val_habil'];

                            }
                        }

                       



                        $sql1 = "SELECT nomusu FROM usuario where usecod = '$usecod'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $user_venta    = $row1['nomusu'];
                            }
                        }

                        ///FORMA DE PAGO
                        if ($forpag == 'E') {
                            $fpag = 'EFECTIVO';
                        }
                        if ($forpag == 'T') {
                            $fpag = 'TARJETA';
                        }
                        if ($forpag == 'C') {
                            $fpag = 'CREDITO';
                        }
                        if ($forpag == 'M') {
                            $fpag = 'MULTIPLE';
                        }

                       

                    }

                   // echo $usecod;
                   // echo $user_venta;
                    

                    
                    function formato($c)
                    {
                        printf("%08d",  $c);
                    }
                    function formato1($c)
                    {
                        printf("%06d",  $c);
                    }

                    if ($encontrado == 1) {

                    ?>
                        <table width="100%" border="0">
                            <tr>
                                <td class="LETRA">N. I.</td>
                                <td><input name="textfield" type="text" size="15" disabled="disabled" value="<?php echo formato($despatch_uid) ?>" /></td>
                                <td class="LETRA">N. DOC/FACTURA AFECTADO</td>
                                <td><input name="textfield" type="text" size="15" disabled="disabled" value="<?php echo $serie_doc ?>" /></td>
                                <td align="left" class="LETRA">FECHA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
                                <td><input name="textfield2" type="text" size="12" disabled="disabled" value="<?php echo fecha($issueDate) ?>" /></td>
                                <td class="LETRA">CLIENTE</td>
                                <td><input name="textfield23" type="text" size="25" disabled="disabled" value="<?php echo $deliveryName ?>" /></td>
                                

                                <td align="right" class="text_combo_select"><strong>LOCAL: <?php echo $nombre_local ?></strong></div>
                                </td>
                            </tr>
                            <tr>
                                <td class="LETRA">VENDEDOR</td>
                                <td><input name="textfield232" type="text" size="20" disabled="disabled" value="<?php echo $user_venta ?>" /></td>
                                <td align="left" class="LETRA">INFORMACION&nbsp;&nbsp;&nbsp;</td>
                                <td><input name="textfield23" type="text" size="30" disabled="disabled" value="<?php echo $note ?>" /></td>

                                <td align="left" class="LETRA">DOC. TRANSPORTISTA&nbsp;&nbsp;&nbsp;</td>
                                <td><input name="textfield23" type="text" size="12" disabled="disabled" value="<?php echo $deliveryCustomerAccountID ?>" /></td>


                                <td class="LETRA"> DATOS TRANSPORTISTA</td>
                                <td colspan="4"><input name="textfield22" type="text" size="25" disabled="disabled" value="<?php echo $carrierPartyName?>" /></td>
                               

                                
                                
                                
                                

                                

                            </tr>
                            <tr>
                                <td width="158" class="LETRA">FORMA DE PAGO</td>
                                <td><input name="textfield22" type="text" size="15" disabled="disabled" value="<?php echo $fpag ?>" /></td>
                                <td class="LETRA" align="left">HORA &nbsp; &nbsp;&nbsp;&nbsp; </td>
                                <td><input name="textfield222" type="text" size="16" disabled="disabled" value="<?php echo $issuetime ?>" /></td>
                                <td class="LETRA" align="left">DIR. DE DESTINO &nbsp; &nbsp;&nbsp;&nbsp; </td>
                                <td><input name="textfield222" type="text" size="20" disabled="disabled" value="<?php echo $deliveryStreetName ?>" /></td>
                                <td class="LETRA">
                                    <div align="left">SUCURSAL</div>
                                </td>
                                <td colspan="4">

                                    <input name="textfield2222" type="text" disabled="disabled" value="<?php echo $nomloc ?>" size="12" />
                                </td>
                            </tr>
                            <tr>

                                <td class="LETRA">N&ordm;DOC</td>
                                <td>
                                    <?php



                                    
                                        echo "<span style='color:green;font-size: 28px;'><b>$despatch_id</b></span>";
                                    
                                    // echo "<span style='color:blue;font-size: 28px;'><b>$nrofactura</b></span>";
                                    ?>

                                    <?php
                             
                                        echo "<span style='color:red;font-size: 24px;'><b>&nbsp;&nbsp;   GUIA DE REMISIÓN</b></span>";
                                    
                                    ?>

                                </td>
                                <td class="LETRA" align="left">ESTADO &nbsp;</td>
                                <td>
                                    <div align="LEFT"><strong>

                                            <?php if ($val_habil == 1) {
                                            ?>


                                                <!--<span class="login">ANULADO</span>-->
                                                <span class="login" style='font-size: 28px;'><b>ANULADO</b></span>
                                            <?php } else {
                                            ?>

                                                <span style='color:BLUE;font-size: 28px;'><b>ACTIVO</b></span>
                                                <!--<span class="login">ACTIVADO</span>-->
                                            <?php }
                                            ?>
                                        </strong></div>
                                </td>
                                <td colspan="5">
                                    <div align="LEFT"><strong>

                                           
                                    <?php if ($tipo_afectacion == 1) {
                                            ?>


                                                <!--<span class="login">ANULADO</span>-->
                                                <span class="login" style='color:Green;font-size: 28px;'><b>LA GUIA SE REALIZO POR UNA VENTA</b></span>
                                            <?php } else {
                                            ?>

                                                <span style='color:BLUE;font-size: 28px;'><b>LA GUIA SE REALIZO POR UNA TRANSFERENCIA</b></span>
                                                <!--<span class="login">ACTIVADO</span>-->
                                            <?php }
                                            ?>

                                         
                                          
                                        </strong></div>
                                </td>

                                <!--<td  class="LETRA">TIPO DE VENTA</td>
            <td  align="left">
               
                
            </td>-->
                            </tr>
                        </table>

                    <?php }
                    ?>

                    <div align="center"><img src="../../../images/line2.png" width="100%" height="4" /></div>
                    <?php
                    if ($encontrado == 1) {
                    ?>
                        <table width="100%" border="0">
                            <tr>
                                <td width="955">
                                    <iframe src="ventas2.php?despatch_uid=<?php echo $despatch_uid ?> " name="iFrame2" width="100%" height="290" scrolling="Automatic" frameborder="0" id="iFrame2" allowtransparency="0"> </iframe>
                                </td>
                            </tr>
                        </table>
                        <div align="center"><img src="../../../images/line2.png" width="100%" height="4" /></div>
                    <?php
                    } else {
                    ?>
                        <table width="100%" border="0">
                            <tr>
                                <td>
                                    <iframe src="ventas3.php" name="iFrame2" width="100%" height="420" scrolling="Automatic" frameborder="0" id="iFrame2" allowtransparency="0"> </iframe>
                                </td>
                            </tr>
                        </table>
                        <div align="center"><img src="../../../images/line2.png" width="100%" height="4" /></div>
                    <?php
                    }
                    ?>
                    <table width="100%" border="0" align="center">
                        <tr>
                            <!--<td width="73"><div align="right">V. BRUTO </div></td>
                  <td width="132">
                  <input name="mont1" class="sub_totales" type="text" id="mont1" onclick="blur()" size="15" value="<?php if ($bruto > 0) { ?> <?php echo $bruto ?> <?php } else { ?>0.00<?php } ?>" />              </td>
                  <td width="50"><div align="right">DCTOS</div></td>
                  <td width="132">
                              <input name="mont2" class="sub_totales" type="text" id="mont2" onclick="blur()" size="15"  value="<?php if ($dctos > 0) { ?> <?php echo $dctos ?> <?php } else { ?>0.00<?php } ?>">			  </td>-->
                            <td width="50">
                                <div align="right">V. VENTA </div>
                            </td>
                            <td width="132">
                                <input name="mont3" class="sub_totales" type="text" id="mont3" onclick="blur()" size="15" value="<?php if ($tot1 > 0) { ?> <?php echo $tot1 ?> <?php } else { ?>0.00<?php } ?>" />
                            </td>
                            <td width="50">
                                <div align="right">IGV</div>
                            </td>
                            <td width="132">
                                <input name="mont4" class="sub_totales" type="text" id="mont4" onclick="blur()" size="15" value="<?php if ($totigv > 0) { ?> <?php echo $totigv ?> <?php } else { ?>0.00<?php } ?>" />
                            </td>
                            <td width="50">
                                <div align="right">TOTAL</div>
                            </td>
                            <td width="112">
                                <input name="mont5" class="sub_totales" type="text" id="mont5" onclick="blur()" size="15" value="<?php if ($tot > 0) { ?> <?php echo $tot; ?> <?php } else { ?>0.00<?php } ?>" />
                            </td>
                        </tr>
                    </table>
                    <div align="center"><img src="../../../images/line2.png" width="100%" height="4" /> </div>
                    <br>
                    <div class="botones">
                        <table width="100%" border="0">
                            <tr>
                                <td width="321">
                                    <div align="left">
                                        <?php
                                        $firstpage = 1;
                                        $prevpage = $pageno - 1;
                                        $nextpage = $pageno + 1;
                                        $lastpage = $lastpage;
                                        ?>
                                        <input name="firstpage" type="hidden" id="firstpage" value="<?php echo $firstpage ?>" />
                                        <input name="nextpage" type="hidden" id="nextpage" value="<?php echo $nextpage ?>" />
                                        <input name="prevpage" type="hidden" id="prevpage" value="<?php echo $prevpage ?>" />
                                        <input name="lastpage" type="hidden" id="lastpage" value="<?php echo $lastpage ?>" />
                                        <input name="pageno" type="hidden" id="pageno" />
                                        <input name="first" type="button" id="first" value="Primero" <?php /*if (($pageno == 1)||($tip == 1))*/ if (($pageno == 1) || ($numrows == 0) || ($encontrado <> 1)) { ?> disabled="disabled" <?php } ?> class="primero" onclick="primero()" />
                                        <input name="prev" type="button" id="prev" value="Anterior" <?php /*if (($pageno == 1) ||($tip == 1))*/ if (($pageno == 1) || ($numrows == 0) || ($encontrado <> 1)) { ?> disabled="disabled" <?php } ?> class="anterior" onclick="anterior()" />
                                        <input name="next" type="button" id="next" value="Siguiente" <?php /*if (($pageno == $lastpage) ||($tip == 1) ||($numrows == 0))*/ if (($pageno == $lastpage) || ($numrows == 0) || ($encontrado <> 1)) { ?> disabled="disabled" <?php } ?> class="siguiente" onclick="siguiente()" />
                                        <input name="fin" type="button" id="fin" value="Ultimo" <?php if (($pageno == $lastpage) || ($numrows == 0) || ($encontrado <> 1)) { ?> disabled="disabled" <?php } ?> class="ultimo" onclick="ultimo()" />
                                        <input name="cod" type="hidden" id="cod" value="<?php echo $despatch_uid ?>" />
                                    </div>
                                </td>
                                <td width="17">&nbsp;</td>

                                <td width="580">
                                    <div align="right">
                                        <?php
                                        if ($transferenciaVenta == 0) {
                                            if ($activoNotaCredito == '0') {
                                                if ($val_habil == 1) {
                                        ?>
                                                    <!--    <input tabindex="14" name="del" type="button" id="del" value="Recuperar" title="CLIC HABILITAR LA VENTA, OPCION UNICAMENTE PARA ADMINISTARDORES O SUPERVISORES" class="eliminar" <?php if (($encontrado <> 1) or ($PermisoDEL == 0)) { ?>disabled="disabled" <?php } ?> onclick="eliminar()" />-->
                                                <?php
                                                } else {

                                                ?>
                                                    <input tabindex="15" name="del1" type="button" id="del1" value="Anular" title="CLIC ANULAR LA VENTA, OPCION UNICAMENTE PARA ADMINISTARDORES O SUPERVISORES" class="eliminar" <?php if (($encontrado <> 1) or ($PermisoDEL == 0)) { ?> disabled="disabled" <?php } ?> onclick="eliminar1()" />
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <!-- <input type="button" class="eliminar" value='Nota de Credito' title='se hizo una nota de credito ya no puede anular ni recuperar' disabled="disabled" /> -->
                                        <?php }
                                        } ?>
                                        <!--<input tabindex="16" name="descargarpdf" type="button" id="descargarpdf" value="Descargar en PDF" class="nuevo" onclick="descargar_venta(<?php echo $invnum; ?>)"/>-->
                                        <!-- <input tabindex="16" name="nuevo" type="button" id="nuevo" value="Nueva Venta" class="nuevo" onclick="nueva_venta()" /> -->
                                        <!-- <input tabindex="17" name="modif" type="button" id="modif" value="Modificar" class="modificar" disabled="disabled" onclick="modificar()"/>
                            <input tabindex="18" name="save" type="button" id="save" value="Grabar" onclick="grabar1()" class="grabar" <?php if (($count == 0) || ($count1 > 0)) { ?>disabled="disabled" <?php } ?>/>
                            <input tabindex="19" name="ext" type="button" id="ext" value="Cancelar" onclick="cancelar_consult()" class="cancelar"  <?php if ($find <> 1) { ?>disabled="disabled" <?php } ?>/>-->
                                        <input tabindex="20" name="exit" type="button" id="exit" value="Salir" onclick="salirx()" class="salir" />
                                        <!--<input tabindex="21" name="printer" type="button" id="printer" value="Reimprimir" class="imprimir" onClick="self.location.href='ventas2_1.php?invnum=<?php echo $despatch_uid ?>'"/>-->
                                        <input tabindex="21" name="printer" type="button" id="printer" value="Reimprimir" class="imprimir" onclick="prints(<?php echo $despatch_uid; ?>)" ; />
                                        <input tabindex="21" name="printeremail" type="button" id="printeremail" value="Reenviar Email" title="Se le enviara el comprobante al correo electronico proporcionado por el cliente" class="grabarventa" onClick="email('<?php echo $correo; ?>');" />
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="botones">
                        <table width="100%" border="0">
                            <tr>
                                <td colspan="3">
                                    <div align="right">
                                        <!-- <input tabindex="21" name="printer" type="button" id="printer1" value="Imprimir como Boleta" class="imprimir" onclick="imprimir()"/>
                                <input tabindex="21" name="printer" type="button" id="printer2" value="Imprimir como Factura" class="imprimir" onclick="imprimir()"/>-->
                                        <!-- <input tabindex="21" name="printer" type="button" id="printer3" value="Imprimir como Guía" class="imprimir" onClick="self.location.href='guia_1.php?invnum=<?php echo $despatch_uid ?>'" /> -->
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </form>
    <?php mysqli_free_result($result);
    mysqli_free_result($result1);
    mysqli_close($conexion);
    ?>
</body>

</html>