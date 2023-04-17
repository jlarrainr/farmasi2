<?php
include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $desemp?> - ORDENES DE COMPRA</title>
<?php 
  $invnum = $_REQUEST['invnum'];
  $sql="SELECT * FROM movmae where invnum = '$invnum'";
  $result = mysqli_query($conexion,$sql);
  if (mysqli_num_rows($result)){
    while ($row = mysqli_fetch_array($result)){
        $invnum       = $row['invnum'];		//codigo
        $fecha        = $row['invfec'];
        $fecdoc       = $row['fecdoc'];
        $fecven       = $row['fecven'];
        $numdoc       = $row['numdoc'];
        $ndoc         = $row['numero_documento'];
        $ndoc1        = $row['numero_documento1'];
        $plazo        = $row['plazo'];
        $val_habil    = $row['val_habil'];
        $invtot       = $row['invtot'];
        $destot       = $row['destot'];
        $valven       = $row['valven'];
        $costo        = $row['costo'];
        $igv          = $row['igv'];
    }
  }
  $sql1="SELECT * FROM movmov where invnum = '$invnum' order by orden";
  $result1 = mysqli_query($conexion,$sql1);
  if (mysqli_num_rows($result1)){
    while ($row1 = mysqli_fetch_array($result1)){
        $codpro    = $row1['codpro'];
      $qtypro    = $row1['qtypro'];	
      $qtyprf    = $row1['qtyprf'];
      $prisal    = $row1['prisal'];
      $pripro    = $row1['pripro'];
      $costre    = $row1['costre'];
      $d1        = $row1['desc1'];
      $d2        = $row1['desc2'];
      $d3        = $row1['desc3'];
    }
  }
?>
</head>

<body>
<table width="90%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="80%">&nbsp;</td>
    <td width="13%">Orden de compra : </td>
    <td width="7%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Fecha de emision : </td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="98%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="7%">Proveedor</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="60%">&nbsp;</td>
    <td width="33%">&nbsp;</td>
  </tr>
</table>
<table width="98%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="9%">Plazo y condición </td>
    <td width="48%">&nbsp;</td>
    <td width="9%">Fecha de Entrega </td>
    <td width="34%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
