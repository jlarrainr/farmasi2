<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
  <?php
  require_once('../../../conexion.php');  //CONEXION A BASE DE DATOS
  require_once('../../../titulo_sist.php');
  require_once("../../../funciones/functions.php");  //DESHABILITA TECLAS

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

  ?>
  <?php $cod   = $_REQUEST['cod'];
  $invnum  = $_REQUEST['invnum'];
  $sql = "SELECT desprod,codmar,factor,margene,costre,prevta,preuni,codpro FROM producto where codpro = '$cod'";
  $result = mysqli_query($conexion, $sql);
  if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
      $desprod        = $row['desprod'];
      $codmar         = $row['codmar'];
      $factor         = $row['factor'];
      $codpro         = $row['codpro'];




      if (($zzcodloc == 1) && ($precios_por_local == 1)) {

        $margene        = $row['margene'];
        $costre         = $row['costre'];
        $prevta         = $row['prevta'];
        $preuni         = $row['preuni'];
      } elseif ($precios_por_local == 0) {

        $margene        = $row['margene'];
        $costre         = $row['costre'];
        $prevta         = $row['prevta'];
        $preuni         = $row['preuni'];
      }

      if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

        $sql_precio = "SELECT $margene_p,$costre_p,$prevta_p,$preuni_p FROM precios_por_local where codpro = '$codpro'";
        $result_precio = mysqli_query($conexion, $sql_precio);
        if (mysqli_num_rows($result_precio)) {
          while ($row_precio = mysqli_fetch_array($result_precio)) {
            $margene        = $row_precio[0];
            $costre         = $row_precio[1];
            $prevta         = $row_precio[2];
            $preuni         = $row_precio[3];
          }
        }
      }


      if (($zzcodloc == 1) && ($precios_por_local == 1)) {
        $costpr = $row1['pcostouni'];  ///COSTO PROMEDIO
      } elseif ($precios_por_local == 0) {
        $costpr = $row1['pcostouni'];  ///COSTO PROMEDIO
      }

      if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

        $sql_precio = "SELECT $costpr_p FROM precios_por_local where codpro = '$codpro'";
        $result_precio = mysqli_query($conexion, $sql_precio);
        if (mysqli_num_rows($result_precio)) {
          while ($row_precio = mysqli_fetch_array($result_precio)) {
            $costpr = $row_precio[0];  ///COSTO PROMEDIO
          }
        }
      }

      $sql1 = "SELECT destab FROM titultabladet where tiptab = 'M' and codtab = '$codmar'";
      $result1 = mysqli_query($conexion, $sql1);
      if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
          $marca        = $row1['destab'];
        }
      }
      $sql1 = "SELECT prisal,costre,pripro FROM tempmovmov where invnum = '$invnum' and codpro = '$cod'";
      $result1 = mysqli_query($conexion, $sql1);
      if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
          $prisal        = $row1['prisal'];
          $costre1       = $row1['costre'];
          $pripro        = $row1['pripro'];
        }
      }
      $prevta1 = $pripro * (($margene / 100) + 1);
      if ($preuni == 0) {
        $preciounit = $prevta1 / $factor;
      } else {
        $preciounit = $preuni * ($pripro / $costre);
      }
    }
  }
  ?>
  <title><?php echo $desprod ?></title>
  <link href="../css/tablas.css" rel="stylesheet" type="text/css" />
  <style type="text/css">
    <!--
    .Estilo1 {
      color: #FFFFFF
    }

    .Estilo2 {
      color: #FF0000
    }
    -->
  </style>
</head>

<body>
  <table class="tabla2" width="548" border="0">
    <tr>
      <td width="540">
        <table width="521" border="0" align="center">
          <tr>
            <td width="73" class="main1_text">DESCRIPCION</td>
            <td width="438"><?php echo $desprod ?></td>
          </tr>
          <tr>
            <td class="main1_text">MARCA</td>
            <td><?php echo $marca ?></td>
          </tr>
          <tr>
            <td class="main1_text">FACTOR</td>
            <td><?php echo $factor ?></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <table width="548" border="0" bgcolor="#50ADEA">
    <tr>
      <td width="69">
        <div align="center" class="Estilo1">COSTO</div>
      </td>
      <td width="68">
        <div align="center" class="Estilo1">MARGEN</div>
      </td>
      <td width="68">
        <div align="center" class="Estilo1">PRECIO VTA </div>
      </td>
      <td width="37">&nbsp;</td>
      <td width="68">
        <div align="center" class="Estilo1">COSTO</div>
      </td>
      <td width="68">
        <div align="center" class="Estilo1">MARGEN</div>
      </td>
      <td width="68">
        <div align="center" class="Estilo1">PRECIO VTA </div>
      </td>
      <td width="68">
        <div align="center" class="Estilo1">PRECIO UNIT </div>
      </td>
    </tr>
  </table>
  <table width="548" border="0">
    <tr>
      <td width="69">
        <div align="center" class="Estilo2"><?php echo $costre ?></div>
      </td>
      <td width="68">
        <div align="center" class="Estilo2"><?php echo $margene ?> %</div>
      </td>
      <td width="68">
        <div align="center" class="Estilo2"><?php echo $prevta ?></div>
      </td>
      <td width="37">
        <div align="center" class="Estilo2"></div>
      </td>
      <td width="68">
        <div align="center" class="Estilo2"><?php echo $pripro ?></div>
      </td>
      <td width="68">
        <div align="center" class="Estilo2"><?php echo $margene ?> %</div>
      </td>
      <td width="68">
        <div align="center" class="Estilo2"><?php echo $numero_formato_frances = number_format($prevta1, 2, '.', ',') ?></div>
      </td>
      <td width="68">
        <div align="center" class="Estilo2"><?php echo $numero_formato_frances = number_format($preciounit, 2, '.', ',') ?></div>
      </td>
    </tr>
  </table>
</body>

</html>