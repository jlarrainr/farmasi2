<?php
include('../../../session_user.php');
$invnum  = $_SESSION['compras'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <link href="../../../../css/style.css" rel="stylesheet" type="text/css" />
  <link href="autocomplete.css" rel="stylesheet" type="text/css" />
  <?php
  require_once('../../../conexion.php');
  require_once('../../../titulo_sist.php');
  require_once("../../../../funciones/functions.php");  //DESHABILITA TECLAS
  require_once("../../../../funciones/funct_principal.php");  //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
  require_once("../../../../funciones/botones.php");  //COLORES DE LOS BOTONES
  $cod    = $_REQUEST['cod'];
  $costo    = $_REQUEST['costo'];
  //echo $costo;
  $sqlP = "SELECT precios_por_local FROM datagen";
  $resultP = mysqli_query($conexion, $sqlP);
  if (mysqli_num_rows($resultP)) {
    while ($row = mysqli_fetch_array($resultP)) {
      $precios_por_local = $row['precios_por_local'];
    }
  }
  if ($precios_por_local  == 1) {
    require_once '../../../precios_por_local.php';
  }

  $sqlDG = "SELECT Preciovtacostopro FROM datagen";
  $resultDG = mysqli_query($conexion, $sqlDG);
  if (mysqli_num_rows($resultDG)) {
    while ($row = mysqli_fetch_array($resultDG)) {
      $Preciovtacostopro = $row['Preciovtacostopro'];
    }
  }

  $sql = "SELECT codpro,desprod,factor,margene,prevta,preuni,tcosto,tmargene,tprevta,tpreuni,costpr FROM producto where codpro = '$cod'";
  $result = mysqli_query($conexion, $sql);
  if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
      $codpro        = $row['codpro'];
      $desprod        = $row['desprod'];
      $factor         = $row['factor'];


      if (($zzcodloc == 1) && ($precios_por_local == 1)) {
        $margene        = $row['margene'];
        $prevta         = $row['prevta'];
        $preuni         = $row['preuni'];
        $tmargene       = $row['tmargene'];
        $tprevta        = $row['tprevta'];
        $tpreuni        = $row['tpreuni'];
        $tcosto         = $row['tcosto'];
        $costpr         = $row['costpr'];
      } elseif ($precios_por_local == 0) {
        $margene        = $row['margene'];
        $prevta         = $row['prevta'];
        $preuni         = $row['preuni'];
        $tmargene       = $row['tmargene'];
        $tprevta        = $row['tprevta'];
        $tpreuni        = $row['tpreuni'];
        $tcosto         = $row['tcosto'];
        $costpr         = $row['costpr'];
      }


      if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

        $sql_precio = "SELECT $margene_p,$prevta_p,$preuni_p,$tmargene_p,$tprevta_p,$tpreuni_p,$tcosto_p,$costpr_p FROM precios_por_local where codpro = '$codpro'";
        $result_precio = mysqli_query($conexion, $sql_precio);
        if (mysqli_num_rows($result_precio)) {
          while ($row_precio = mysqli_fetch_array($result_precio)) {
            $margene        = $row_precio[0];
            $prevta         = $row_precio[1];
            $preuni         = $row_precio[2];
            $tmargene       = $row_precio[3];
            $tprevta        = $row_precio[4];
            $tpreuni        = $row_precio[5];
            $tcosto         = $row_precio[6];
            $costpr         = $row_precio[7];
          }
        }
      }
    }
    if ($Preciovtacostopro == 1) {
      $costo          = $costpr;
    }
    if ($preuni == "") {
      $preuni = $prevta / $factor;
    }
  }
  ?>
  <script>
    function sf() {
      document.form1.price.focus();
      var f = document.form1;
      var v1 = parseFloat(document.form1.price.value); //precio
      var v2 = parseFloat(document.form1.price1.value); //margen
      var v3 = parseFloat(document.form1.factor.value); //factor
      if (document.form1.price1.value === "") {
        document.form1.price1.value = 0;
        v2 = 0;
      }
      a = parseFloat(1 + (v2 / 100));
      pventa = parseFloat(v1 * a);
      pventa = Math.round(pventa * Math.pow(10, 2)) / Math.pow(10, 2);
      pventaunit = parseFloat(pventa / v3);
      pventaunit = Math.round(pventaunit * Math.pow(10, 2)) / Math.pow(10, 2);
      f.price2.value = pventa;
      f.price3.value = pventaunit;
    }

    function cerrar(e) {
      tecla = e.keyCode
      if (tecla == 27) {
        window.close();
      }
    }

    function validar() {
      var f = document.form1;
      /*if (f.price.value == "")
      { alert("DEBE INGRESAR UN PRECIO");f.price.focus(); return;}
      */
      f.method = "post";
      f.action = "price1.php";
      f.submit();
      /*var f = document.form1;
      if (f.price.value == "")
      { alert("DEBE INGRESAR UN PRECIO");f.price.focus(); return;}
      var p = f.price.value;
      var q = f.price1.value;
      var r = f.price2.value;
      var s = f.price3.value;
      var t = f.cod.value;
      //window.close();
      */
    }

    function precio() {
      var f = document.form1;
      var v1 = parseFloat(document.form1.price.value); //precio
      var v2 = parseFloat(document.form1.price1.value); //margen caja
      var v3 = parseFloat(document.form1.factor.value); //factor
      if (document.form1.price1.value === "") {
        document.form1.price1.value = 0;
        v2 = 0;
      }
      a = parseFloat(1 + (v2 / 100));
      pventa = parseFloat(v1 * a);
      pventa = Math.round(pventa * Math.pow(10, 2)) / Math.pow(10, 2);
      pventaunit = parseFloat(pventa / v3);
      pventaunit = Math.round(pventaunit * Math.pow(10, 2)) / Math.pow(10, 2);
      f.price2.value = pventa; //precio de venta uni caja
      f.price3.value = pventaunit; //precio de venta uni
    }

    function precio1() {
      var f = document.form1;
      var v1 = parseFloat(document.form1.price.value); //precio costo
      var v2 = parseFloat(document.form1.price2.value); //precio caja
      var v3 = parseFloat(document.form1.factor.value); //factor
      if (v3 === 0) {
        v3 = 1;
      }
      var rpc = 0;
      rpc = ((v2 - v1) / v1) * 100;
      rpc = Math.round(rpc * Math.pow(10, 2)) / Math.pow(10, 2);
      f.price1.value = rpc;
      /*if (document.form1.price1.value === "")
      {
          document.form1.price1.value = 0;
          v2=0;
      }
      a = parseFloat(1 + (v2/100));
      pventa = parseFloat(v1 * a);
      pventa = Math.round(pventa*Math.pow(10,2))/Math.pow(10,2); 
      pventaunit = parseFloat(pventa / v3);
      pventaunit = Math.round(pventaunit*Math.pow(10,2))/Math.pow(10,2); 
      f.price2.value = pventa;                                    //precio de venta uni caja
      f.price3.value = pventaunit;                                //precio de venta uni*/
    }

    function precioUni() {
      var f = document.form1;
      var v1 = parseFloat(document.form1.price.value); //precio
      var v2 = parseFloat(document.form1.priceU.value); //margen unidad
      var v3 = parseFloat(document.form1.factor.value); //factor
      if (document.form1.price1.value === "") {
        document.form1.price1.value = 0;
        v2 = 0;
      }
      a = parseFloat(1 + (v2 / 100));
      pventa = parseFloat(v1 * a);
      pventa = Math.round(pventa * Math.pow(10, 2)) / Math.pow(10, 2);
      pventaunit = parseFloat(pventa / v3);
      pventaunit = Math.round(pventaunit * Math.pow(10, 2)) / Math.pow(10, 2);
      //f.price2.value = pventa;
      f.price3.value = pventaunit; //precio de venta uni
    }

    function precioUni1() {
      var f = document.form1;
      var v1 = parseFloat(document.form1.price.value); //precio
      var v2 = parseFloat(document.form1.priceU.value); //margen unidad
      var v3 = parseFloat(document.form1.factor.value); //factor
      if (document.form1.price1.value === "") {
        document.form1.price1.value = 0;
        v2 = 0;
      }
      a = parseFloat(1 + (v2 / 100));
      pventa = parseFloat(v1 * a);
      pventa = Math.round(pventa * Math.pow(10, 2)) / Math.pow(10, 2);
      pventaunit = parseFloat(pventa / v3);
      pventaunit = Math.round(pventaunit * Math.pow(10, 2)) / Math.pow(10, 2);
      //f.price2.value = pventa;
      f.price3.value = pventaunit; //precio de venta uni
    }
  </script>
  <title><?php echo $desprod ?></title>
  <link href="../../css/tablas.css" rel="stylesheet" type="text/css" />
  <style type="text/css">
    <!--
    .Estilo5 {
      color: #0066CC
    }

    .Estilo6 {
      color: #006699
    }
    -->
  </style>
</head>

<body onload="sf();" onkeyup="cerrar(event)">
  <table width="450" border="0" bgcolor="#FFFF99" class="tabla2">
    <tr>
      <td width="477">
        <table width="444" border="0" align="center" bgcolor="#FFFF99">
          <tr>
            <td class="main1_text Estilo6">DESCRIPCION</td>
            <td><?php echo $desprod ?></td>
          </tr>
          <tr>
            <td width="69" class="main1_text Estilo6">FACTOR</td>
            <td width="365"><?php echo $factor ?></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <img src="../../../../images/line2.png" width="450" height="4" />
  <form id="form1" name="form1" method="post" action="verifica.php">
    <table class="tabla2" width="450" border="0">
      <tr>
        <td width="540">
          <table width="444" border="0" align="center">
            <tr>
              <td><span class="Estilo5">PRECIO VTA. ACTUAL </span></td>
              <td bgcolor="#FFFFCC"><?php echo $prevta; ?></td>
            </tr>
            <tr>
              <td width="122"><span class="Estilo5">PRECIO VTA. UNIT </span></td>
              <td width="312" bgcolor="#FFFFCC"><?php echo $preuni; ?></td>
            </tr>
            <tr>
              <td><span class="Estilo5"> COSTO DE COMPRA </span></td>
              <td bgcolor="#FFFFCC"><input name="price" type="text" id="price" onkeypress="return decimal(event)" onkeyup="precio();" value="<?php if ($costo <> 0) {
                                                                                                                                                echo $costo;
                                                                                                                                              } else {
                                                                                                                                                echo $tcosto;
                                                                                                                                              } ?>" />
                (Incluido IGV) </td>
            </tr>
            <tr>
              <td><span class="Estilo5"> MARGEN % POR CAJA </span></td>
              <td bgcolor="#FFFFCC">
                <input name="price1" type="text" id="price1" onkeypress="return decimal(event)" value="<?php if ($tmargene <> 0) {
                                                                                                          echo $tmargene;
                                                                                                        } else {
                                                                                                          echo $margene;
                                                                                                        } ?>" onkeyup="precio();" /></td>
            </tr>
            <tr>
              <td><span class="Estilo5"> MARGEN % POR UNIDAD </span></td>
              <td bgcolor="#FFFFCC">
                <input name="priceU" type="text" id="priceU" onkeypress="return decimal(event)" value="<?php if ($tmargene <> 0) {
                                                                                                          echo $tmargene;
                                                                                                        } else {
                                                                                                          echo $margene;
                                                                                                        } ?>" onkeyup="precioUni();" /></td>
            </tr>
            <tr>
              <td><span class="Estilo5"> PRECIO VTA. </span></td>
              <td bgcolor="#FFFFCC"><input name="price2" type="text" id="price2" onkeypress="return decimal(event)" value="<?php if ($tprevta <> 0) {
                                                                                                                              echo $tprevta;
                                                                                                                            } ?>" onkeyup="precio1();" /></td>
            </tr>
            <tr>
              <td><span class="Estilo5"> PRECIO VTA. UNIT </span></td>
              <td bgcolor="#FFFFCC">
                <input name="price3" type="text" id="price3" onkeypress="return decimal(event)" value="<?php if ($tpreuni <> 0) {
                                                                                                          echo $tpreuni;
                                                                                                        } ?>" onkeyup="precioUni1();" />
                <input name="factor" type="hidden" id="factor" value="<?php echo $factor ?>" />
                <input name="cod" type="hidden" id="cod" value="<?php echo $cod ?>" />
                <input type="button" name="Submit" value="Actualizar" onclick="validar();" /> </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </form>
</body>

</html>