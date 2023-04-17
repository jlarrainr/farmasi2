<?php include('../../session_user.php');
?>
<?php

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">



  <title>Documento sin t&iacute;tulo</title>
  <link href="../css/style.css" rel="stylesheet" type="text/css" />
  <link href="../css/tablas.css" rel="stylesheet" type="text/css" />
  <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
  <?php require_once('../../../conexion.php');  //CONEXION A BASE DE DATOS
  require_once('../../../convertfecha.php');  //CONEXION A BASE DE DATOS
  require_once("../../../funciones/highlight.php");  //ILUMINA CAJAS DE TEXTOS
  require_once("../../../funciones/functions.php");  //DESHABILITA TECLAS
  require_once("../../../funciones/botones.php");  //COLORES DE LOS BOTONES
  require_once("../../../funciones/funct_principal.php");  //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
  require_once("../funciones/devolucion.php");  //FUNCIONES DE ESTA PANTALLA
  require_once("../../local.php");  //LOCAL DEL USUARIO
  $date     = date("Y-m-d");
  $num = "";
  $sql1 = "SELECT nomusu,codloc FROM usuario where usecod = '$usuario'";
  $result1 = mysqli_query($conexion, $sql1);
  if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
      $user    = $row1['nomusu'];
      $codloc   = $row1['codloc'];
    }
  }
  $sql = "SELECT invnum FROM movmae where usecod = '$usuario' and proceso = '1' and tipmov ='1' and tipdoc='3' and sucursal='$codloc'";
  $result = mysqli_query($conexion, $sql);
  if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
      $invnummovmae          = $row["invnum"];    //codigo de movmae
    }
  }
  $_SESSION['nota_credito']  = $invnummovmae;
  $num  = $_REQUEST['num'];

  ///////CONTADOR PARA CONTROLAR LOS TOTALES
  $sql = "SELECT count(*) FROM temp_venta2 where ((nrofactura LIKE '$num') or( nrovent='$num')  )  and estado = '0' and usecod='$usuario' and sucursal ='$codloc' and val_habil = '0' and tipdoc <> 4 ";
  $result = mysqli_query($conexion, $sql);
  if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
      $count2        = $row[0];
    }
  } else {
    $count2 = 0;
  }


  if (($num <> "") && ($count2 == 0)) {
    function numberOfWeek($dia, $mes, $ano)
    {
      $Hora = date("H");
      $Min  = date("i");
      $Sec  = date("s");
      $fecha = mktime($Hora, $Min, $Sec, $mes, 1, $ano);
      $numberOfWeek = ceil(($dia + (date("w", $fecha) - 1)) / 7);
      return $numberOfWeek;
    }
    //// Tomar datos para la venta (local, cliente, numero de venta, correlativo)
    $sql = "SELECT codloc,nomusu FROM usuario where usecod = '$usuario'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
      if ($row = mysqli_fetch_array($result)) {
        $codloc    = $row['codloc'];
        $nomusu    = $row['nomusu'];
      }
    }
    $sql = "SELECT codcli FROM cliente where descli = 'PUBLICO EN GENERAL'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
      if ($row = mysqli_fetch_array($result)) {
        $codcli    = $row['codcli'];
      }
    }
    $date       = date("Y-m-d");
    $fecha      = explode("-", $date);
    $daysem     = $fecha[2];
    $messem     = $fecha[1];
    $yearsem    = $fecha[0];


    $semana = numberOfWeek($daysem, $messem, $yearsem);
    //    mysqli_query($conexion, "INSERT INTO venta (invfec,usecod,estado,sucursal,tipdoc,semana) values "
    //      . "                                       ('$date','$usuario','1','$codloc','5','$semana')");



    $sql1 = "SELECT * FROM venta where ((nrofactura LIKE '$num') or (nrovent='$num')  ) and estado = '0' and val_habil = '0' and sucursal='$codloc' and tipdoc <> 4 and activoNotaCredito = '0' ";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
      while ($row = mysqli_fetch_array($result1)) {
        $invnum       = $row['invnum'];   
        $numdoc       = $row['nrovent'];
        $invfec       = $row['invfec'];
        $cuscod       = $row['cuscod'];
        $usecod       = $row['usecod'];
        $codven       = $row['codven'];
        $bruto        = $row['bruto'];
        $valven       = $row['valven'];
        $invtot       = $row['invtot'];
        $igv          = $row['igv'];
        $forpag       = $row['forpag'];
        $saldo        = $row['saldo'];
        $fecven       = $row['fecven'];
        $estado       = $row['estado'];
        $val_habil    = $row['val_habil'];
        $sucursal     = $row['sucursal'];
        $cosvta       = $row['cosvta'];
        $hora         = $row['hora'];
        $codtab       = $row['codtab'];
        $redondeo     = $row['redondeo'];
        $numtarjet    = $row['numtarjet'];
        $descflat     = $row['descflat'];
        $tipvta       = $row['tipvta'];
        $montext      = $row['montext'];
        $correlativo  = $row['correlativo'];
        $tipdoc       = $row['tipdoc'];
        $ndias        = $row['ndias'];
        $impreso      = $row['impreso'];
        $nomcliente   = $row['nomcliente'];
        $pagacon      = $row['pagacon'];
        $vuelto       = $row['vuelto'];
        $semana       = $row['semana'];
        $nrofactura   = $row['nrofactura'];
        $codmed       = $row['codmed'];
        $inafecto     = $row['inafecto'];
        $gravado      = $row['gravado'];
        $anotacion    = $row['anotacion'];
      }
      mysqli_query($conexion, "INSERT INTO temp_venta2 
              (invnum,nrovent,invfec,cuscod,usecod,codven,bruto,valven,invtot,igv,forpag,saldo,fecven,estado,val_habil,sucursal,cosvta,hora,codtab,redondeo,numtarjet,descflat,tipvta,montext,correlativo,tipdoc,ndias,impreso,nomcliente,pagacon,vuelto,semana,nrofactura,codmed,inafecto, gravado,anotacion) values "
        . "   ('$invnum','$numdoc','$invfec','$cuscod','$usuario','$codven','$bruto','$valven','$invtot','$igv','$forpag','$saldo','$fecven','$estado','$val_habil', '$sucursal','$cosvta','$hora','$codtab','$redondeo','$numtarjet','$descflat','$tipvta','$montext','$correlativo','$tipdoc','$ndias','$impreso'   ,'$nomcliente','$pagacon','$vuelto','$semana','$nrofactura','$codmed','$inafecto','$gravado','$anotacion'   )");
   
        $noSeEcontro='1';
    }else{
        $noSeEcontro='2';
        
         echo '<script type="text/javascript">
                                    alert("Este documento puede estar en estado ANULADO Oya se ha generado una NOTA DE CREDITO anteriormente.");
                                    window.location.href="devolucion1.php";
                    </script>';


                return;
                
    }

 if($noSeEcontro=='1'){
    $sqlPRODT       = "SELECT codtemp FROM temp_venta2  WHERE  invnum='$invnum' ORDER BY codtemp DESC LIMIT 1  ";
    $resultPRODT    = mysqli_query($conexion, $sqlPRODT);
    if (mysqli_num_rows($resultPRODT)) {
      while ($row = mysqli_fetch_array($resultPRODT)) {
        $codtemp      = $row['codtemp'];
      }
    }

    $sql1 = "SELECT invnum, invfec, cuscod, usecod, codven, codpro,canpro, fraccion, factor, prisal, pripro, cospro, costpr, codmar, incentivo, bonif, ultcos, idlote FROM detalle_venta where invnum = '$invnum' ORDER BY invnum";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
      while ($row = mysqli_fetch_array($result1)) {
        $invnum         = $row['invnum'];
        $invfec         = $row['invfec'];
        $cuscod         = $row['cuscod'];
        $usecod         = $row['usecod'];
        $codven         = $row['codven'];
        $codpro         = $row['codpro'];
        $canpro         = $row['canpro'];
        $fraccion       = $row['fraccion'];
        $factor         = $row['factor'];
        $prisal         = $row['prisal'];
        $pripro         = $row['pripro'];
        $cospro         = $row['cospro'];
        $costpr         = $row['costpr'];
        $codmar         = $row['codmar'];
        $incentivo      = $row['incentivo'];
        $bonif          = $row['bonif'];
        $ultcos         = $row['ultcos'];
        $idlote         = $row['idlote'];

        mysqli_query($conexion, "INSERT INTO temp_detalle_venta (codtemp,invnum, invfec, cuscod, usecod, codven, codpro, canpro, fraccion, factor, prisal, pripro, cospro, costpr, codmar, incentivo, bonif, ultcos, idlote) values "
          . "   ('$codtemp','$invnum ','$invfec','$cuscod','$usuario','$codven','$codpro','$canpro','$fraccion','$factor','$prisal','$pripro','$cospro','$costpr','$codmar','$incentivo','$bonif','$ultcos','$idlote')");
      }
    }
 }
    
  }
  $invnummovmae = $_SESSION['nota_credito'];
  ?>
  <style>
    .botones2 {
      width: 99%;
      height: auto;
      padding: 5px;
      overflow: hidden;
      border: 1px solid #ccc;
      background: #FFFFFF;
    }

    .table {
      border: 1px solid #b4afad;
      border-collapse: collapse;
      height: 40px;
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
  </style>
</head>

<body onload="fc();">
  <form name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)">
    <table width="100%" border="0">
      <tr>
        <td>
          <table width="100%" border="0" style="margin-top: -25px">
            <tr>
              <td width="115" class="LETRA">
                <h3>NUMERO DE DOCUMENTO</h3>
              </td>
              <td width="496">
                <!-- <input name="num" type="text" id="num" size="20" value="<?php echo $num ?>" onKeyPress="return ent1(event),this.value = this.value.toUpperCase();" onclick="this.value=''" /> -->
               <!-- <input name="num" type="text" id="num" size="20" value="<?php echo $num ?>" onKeyPress="return ent1(event),this.value = this.value.toUpperCase();" />-->
                 <input name="num" type="text" id="num" size="20" value="<?php echo $num 
                                                                              ?>" <?php if ($numdoc <> "") {   ?> onKeyPress="return ent12(event),this.value = this.value.toUpperCase();" <?php } else { ?> onKeyPress="return ent1(event),this.value = this.value.toUpperCase();" <?php } ?> />
                <!--<input name="num" type="text" id="num" size="15"  onkeypress="this.value = this.value.toUpperCase();"/>-->
                <input name="tip" type="hidden" id="tip" value="1" />
                <img style="margin-bottom: -3px;" width="2.5%" height="2.5%" src="question.svg" title="Para buscar un comprobante, escribir la serie(exactamente igual ) y correlativo(este ultimo obviando los ceros restantes de izquierda), ejemplo: para buscar B000-0000001 escribir B000-1 (la primera letra indica si es ticket, boleta o factura), o por numero interno">
                &nbsp;&nbsp;
                &nbsp;&nbsp;
                <input type="button" name="Submit" value="BUSCAR" class="buscar" <?php if ($numdoc <> "") {   ?> onclick="buscar_venta_no()" <?php } else { ?> onclick="buscar_venta()" <?php } ?> />
              </td>
              <td width="314">
                <div align="right" class="text_combo_select">USUARIO : <img src="../../../images/user.gif" width="15" height="16" /><?php echo $user ?></div>
              </td>
            </tr>
          </table>
          <?php

          $num  = $_REQUEST['num'];
          $tip  = $_REQUEST['tip'];
          
          if($noSeEcontro=='1'){
          /////////////////////////////////
          if ($tip == 1) {
            $sql = "SELECT * FROM temp_venta2 where ((nrofactura LIKE '$num' )or (nrovent='$num')  ) and estado = '0' and val_habil = '0' and sucursal='$codloc' and tipdoc <> 4 ";
          }
          //          else {
          //            $sql = "SELECT * FROM temp_venta2 where val_habil = '0' and estado = '0' and tipdoc <> 4  limit 1";
          //          }
          $result = mysqli_query($conexion, $sql);
          if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
              $invnum         = $row['invnum'];    //codigo
              $invfec         = $row['invfec'];
              $cuscod         = $row['cuscod'];
              $usecod         = $row['usecod'];
              $numdoc         = $row['nrovent'];
              $bruto          = $row['bruto'];
              $valvennota         = $row['valven'];
              $invtotnota         = $row['invtot'];
              $igvnota            = $row['igv'];
              $forpag         = $row['forpag'];
              $val_habil      = $row['val_habil'];
              $estado         = $row['estado'];
              $encontrado     = 1;
              $tipdoc         = $row['tipdoc'];
              $nrofactura     = $row['nrofactura'];
              $codtempid     = $row['codtemp'];
              // }5555
              $sql1 = "SELECT nomusu FROM usuario where usecod = '$usuario'";
              $result1 = mysqli_query($conexion, $sql1);
              if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                  $user_venta    = $row1['nomusu'];
                }
              }
              $sql1 = "SELECT descli FROM cliente where codcli = '$cuscod'";
              $result1 = mysqli_query($conexion, $sql1);
              if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                  $cliente_venta  = $row1['descli'];
                }
              }
              ///FORMA DE PAGO
              if ($forpag == "E") {
                $fpag = "EFECTIVO";
              }
              if ($forpag == "T") {
                $fpag = "TARJETA";
              }
              if ($forpag == "C") {
                $fpag = "CREDITO";
              }
              
              

              if ($tip == 1) {

          ?>
                <table class="table" width="100%" border="0" style="margin-top: -10px">
                  <tr bgcolor="#ececec" height="30">
                    <td width="58" class="LETRA">NUMERO</td>
                    <td width="140"><input name="textfield" type="text" size="15" disabled="disabled" value="<?php echo $numdoc ?>" /></td>
                    <td width="37" class="LETRA">FECHA</td>
                    <td width="158"><input name="textfield2" type="text" size="15" disabled="disabled" value="<?php echo fecha($invfec) ?>" /></td>
                    <td width="85" class="LETRA">CLIENTE</td>
                    <td width="329"><input name="textfield23" type="text" size="50" disabled="disabled" value="<?php echo $cliente_venta ?>" /></td>
                    <td width="117" colspan="2">
                      <div align="center" class="text_combo_select"><strong>LOCAL: <?php echo $nombre_local ?></strong></div>
                    </td>
                  </tr>

                  <tr bgcolor="#ececec" height="30">
                    <td width="58" class="LETRA">VENDEDOR</td>
                    <td width="341" colspan="3"><input name="textfield232" type="text" size="60" disabled="disabled" value="<?php echo $user_venta ?>" /></td>
                    <td width="97" class="LETRA">FORMA DE PAGO</td>
                    <td width="150"><input name="textfield22" type="text" size="20" disabled="disabled" value="<?php echo $fpag ?>" /></td>
                    <td width="296">
                      <div align="center"><strong>
                        </strong>
                        <?php
                        if ($tipdoc == 1) {
                          echo "<span style='color:red;font-size: 18px;'><b>$nrofactura</b></span>";
                        } else {
                          echo "<span style='color:blue;font-size: 18px;'><b>$nrofactura</b></span>";
                        } ?>
                      </div>
                    </td>

                    <td align="right">
                      <?php
                      if ($tipdoc == 1) {
                        echo "<span style='color:red;font-size: 18px;'><b>FACTURA</b></span>";
                      } else {
                        if ($tipdoc == 4) {
                          echo "<span style='color:green;font-size: 18px;'><b>TICKET</b></span>";
                        } else {
                          echo "<span style='color:blue;font-size: 18px;'><b>BOLETA</b></span>";
                        }
                      }
                      ?>

                    </td>
                  </tr>
                </table>

          <?php }
            }
          }
          }
          ?>

          <div align="center"><img src="../../../images/line2.png" width="100%" height="4" /></div>
          <?php if ($tip == 1) { ?>
            <table width="100%" border="0">
              <tr>
                <td width="955">
                  <iframe src="devolucion2.php?invnum=<?php echo $invnum ?>" name="iFrame2" width="100%" height="430" scrolling="Automatic" frameborder="0" id="iFrame2" allowtransparency="0"> </iframe>
                </td>
              </tr>
            </table>
            <div align="center"><img src="../../../images/line2.png" width="100%" height="4" /></div>
          <?php } else { ?>
            <table width="100%" border="0">
              <tr>
                <td width="955">
                  <iframe src="devolucion3.php" name="iFrame2" width="100%" height="590" scrolling="Automatic" frameborder="0" id="iFrame2" allowtransparency="0"> </iframe>
                </td>
              </tr>
            </table>
            <div align="center"><img src="../../../images/line2.png" width="100%" height="4" /></div>
          <?php }
          ?>
          
          <div class="botones2">
            <table width="100%" border="0">
              <tr>
                <td width="321">&nbsp;</td>
                <td width="17">&nbsp;</td>
                <td width="580">
                  <label>
                    <div align="right">
                      <!-- <input name="printer" type="button" id="printer" value="Imprimir" class="imprimir" onclick="imprimir()" disabled="disabled"/>-->
                      <input name="cod" type="hidden" id="cod" value="<?php echo $invnum ?>" />
                      <input name="codtempid" type="hidden" id="codtempid" value="<?php echo $codtempid ?>" />
                      <input name="usuario" type="hidden" id="usuario" value="<?php echo $usuario ?>" />
                      <!--<input name="invnumMd" type="hidden" id="invnumMd" value="<?php echo $invnumMd ?>" />-->
                      <input name="count2" type="hidden" id="count2" value="<?php echo $count2 ?>" />
                      <input name="save" type="button" id="save" value="Grabar" onclick="grabar1()" class="grabar" title="<?php echo $invnumMd ?>" />
                      <input name="ext" type="button" id="ext" value="Cancelar" onclick="cancelar()" class="cancelar" <?php if ($numdoc == "") {   ?> disabled="disabled" title="No se encuentra cargada ningun documento operacion imposible" <?php } ?> />
                      <input name="exit" type="button" id="exit" value="Salir" onclick="salir()" class="salir" />
                    </div>

                  </label></td>
              </tr>
            </table>
          </div>
        </td>
      </tr>
    </table>
  </form>
</body>

</html>