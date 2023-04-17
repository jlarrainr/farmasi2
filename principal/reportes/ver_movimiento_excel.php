<?php
include('../session_user.php');
?>
<?php
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=SIST_EXPORT_DATA.xls");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  
<!-- <link href="css/style1.css" rel="stylesheet" type="text/css" /> -->
<!-- <link href="css/tablas.css" rel="stylesheet" type="text/css" /> -->
<style type="text/css">
  .Estilo1 {
    color: #FF0000;
    font-weight: bold;
  }

  .Estilo2 {
    color: #FF0000
  }

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

  #customers td a {
    color: #4d9ff7;
    font-weight: bold;
    font-size: 15px;
    text-decoration: none;

  }

  #customers #total {

    text-align: center;
    background-color: #fe5050;
    color: white;
    font-size: 16px;
    font-weight: 900;
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
<?php require_once('../../conexion.php');  //CONEXION A BASE DE DATOS
require_once('../../titulo_sist.php');
require_once("../../funciones/functions.php");  //DESHABILITA TECLAS
require_once('../../convertfecha.php');  //CONEXION A BASE DE DATOS
require_once("../../funciones/funct_principal.php");  //IMPRIMIR-NUME
function convertir_a_numero($str)
{
  $legalChars = "%[^0-9\-\. ]%";

  $str = preg_replace($legalChars, "", $str);
  return $str;
}
$sql = "SELECT * FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
  while ($row = mysqli_fetch_array($result)) {
    $users    = $row['nomusu'];
  }
}
$hour   = date('G');
//$date	= CalculaFechaHora($hour);
$date = date("Y-m-d");
//$hour   = CalculaHora($hour);
$min     = date('i');
if ($hour <= 12) {
  $hor    = "am";
} else {
  $hor    = "pm";
}
$mov    = $_REQUEST['mov'];
$user   = $_REQUEST['user'];
$local  = $_REQUEST['local'];
$invnum = $_REQUEST['invnum'];
$desc_mov = $_REQUEST['tex'];

// echo $desc_mov;
function formato($c)
{
  printf("%08d",  $c);
}
function formato1($c)
{
  printf("%06d",  $c);
}
////////////////////////////

////////////////////////////
$sql = "SELECT * FROM movmae where invnum = '$invnum'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
  while ($row = mysqli_fetch_array($result)) {
    $invnum = $row['invnum'];
    $invnumrecib = $row['invnumrecib'];
    $nro_compra = $row['nro_compra'];
    $invfec = $row['invfec'];
    $usecod = $row['usecod'];   //usuario
    $cuscod = $row['cuscod'];  //proveedor
    $numdoc = $row['numdoc'];
    $numdocD1 = $row['numero_documento'];
    $numdocD2 = $row['numero_documento1'];
    $fecdoc = $row['fecdoc'];
    $plazo = $row['plazo'];
    $forpag = $row['forpag'];
    //            $invtot = $row['invtot'];
    $destot = $row['destot'];
    $valven = $row['valven'];
    $tipmov = $row['tipmov'];
    $tipdoc = $row['tipdoc'];
    $refere = $row['refere'];
    $fecven = $row['fecven'];
     
    //            $monto = $row['monto'];
    $hora = date("g:i a", strtotime($row['hora']));
    $saldo = $row['saldo'];
    $moneda = $row['moneda'];
    $suspendido = $row['suspendido'];
    $costo = $row['costo'];
    $igv = $row['igv'];
    $codanu = $row['codanu'];
    $codrec = $row['codrec'];
    $orden = $row['orden'];
    $sucursal = $row['sucursal'];   //sucursal origen
    $sucursal1 = $row['sucursal1']; //sucursal destino
    $incluidoIGV_n = $row['incluidoIGV'];
    $dafecto = $row['dafecto'];
    $dinafecto = $row['dinafecto'];
    $digv = $row['digv'];
    $dtotal = $row['dtotal'];
    $monto = $row['invtot'];


    // echo $tipdoc;
    // echo $tipmov;
    
    
    $forpagTexto='';
if($forpag =='F'){
    $forpagTexto="Factura";
}elseif($forpag =='B'){
     $forpagTexto="Boleta";
}elseif($forpag =='G'){
     $forpagTexto="Guia";
}elseif($forpag =='O'){
     $forpagTexto="Otros";
}


// if (($tipdoc =='1') && ($tipdoc == '1')){
//   $desc_mov="INGRESO POR COMPRA";
// }elseif (($tipdoc == '3') && ($tipmov == '2')) {
//   $desc_mov="SALIDA POR TRANSF";
// }elseif (($tipdoc == '2') && ($tipmov == '1')) {
//   $desc_mov="INGRESO POR TRANSF";
// }elseif (($tipdoc == '1') && ($tipmov == '2')) {
//   $desc_mov="SALIDAS VARIAS";
// }elseif (($tipdoc == '5') && ($tipmov == '1')) {
//   $desc_mov="OTROS INGRESOS";
// }

if ($tipmov == 1) {
  if ($tipdoc == 1) {
      $desc_mov = "INGRESO POR COMPRA";
  }
  if ($tipdoc == 2) {
      $desc_mov = "INGRESO POR TRANSF";
  }
  if ($tipdoc == 3) {
      $desc_mov = "DEVOLUCI�N";
  }
  if ($tipdoc == 4) {
      $desc_mov = "CANJE AL LABORATORIO";
  }
  if ($tipdoc == 5) {
      $desc_mov = "OTROS INGRESOS";
  }
}
if ($tipmov == 2) {
  if ($tipdoc == 1) {
      $desc_mov = "SALIDAS VARIAS";
  }
  if ($tipdoc == 2) {
      $descdesc_movtip = "GUIAS DE REMISION";
  }
  if ($tipdoc == 3) {
      $desc_mov = "SALIDA POR TRANSF";
  }
  if ($tipdoc == 4) {
      $desc_mov = "CANJE PROVEEDOR ";
  }
  if ($tipdoc == 5) {
      $desc_mov = "PRESTAM CLIENTE ";
  }
}


    
    $sql = "SELECT * FROM usuario where usecod = '$usecod'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
      while ($row = mysqli_fetch_array($result)) {
        $users2    = $row['nomusu'];
      }
    }
    $sqlProv = "SELECT despro FROM proveedor where codpro = '$cuscod'";
    $resultProv = mysqli_query($conexion, $sqlProv);
    if (mysqli_num_rows($resultProv)) {
      while ($row = mysqli_fetch_array($resultProv)) {
        $Proveedor = $row['despro'];
      }
    }
    $sqlSuc = "SELECT nombre FROM xcompa where codloc = '$sucursal1'";
    $resultSuc = mysqli_query($conexion, $sqlSuc);
    if (mysqli_num_rows($resultSuc)) {
      while ($row = mysqli_fetch_array($resultSuc)) {
        $sucursal_destino = $row['nombre'];
      }
    }
    $sqlSuc = "SELECT nombre FROM xcompa where codloc = '$sucursal'";
    $resultSuc = mysqli_query($conexion, $sqlSuc);
    if (mysqli_num_rows($resultSuc)) {
      while ($row = mysqli_fetch_array($resultSuc)) {
        $Sucursal = $row['nombre'];
      }
    }
    if ($incluidoIGV_n == 1) {
      $incluidoIGV = "SI";
    } else {
      $incluidoIGV = "NO";
    }

    if ($tipmov == 1) {
      $desctip_mov = "INGRESO";
    } else {
      $desctip_mov = "SALIDA";
    }

    if (($desc_mov == 'INGRESO POR COMPRA')) {
      $filtro_compra = '1';
    } else {
      $filtro_compra = '0';
    }
    if (($desc_mov == 'INGRESO POR TRANSF')) {
      $filtro_transferencia = '1';
    } else {
      $filtro_transferencia = '0';
    }

    if ($desc_mov == 'SALIDA POR TRANSF') {
      $filtro_salida_transferencia = '1';
    } else {
      $filtro_salida_transferencia = '0';
    }

    if ($desc_mov == 'OTROS INGRESOS') {
      $filtro_otros_ingresos = '1';
    } else {
      $filtro_otros_ingresos = '0';
    }
  }
}
?>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title><?php echo $desemp ?></title>
</head>

<body>
  <table width="100%" border="0" align="center">
    <tr>
      <td>
        <table width="100%" border="0">
          <tr>
            <td width="260"><strong><?php echo $desemp ?> </strong></td>
            <td width="380">
              <div align="center"><strong>REPORTE DE INGRESOS Y SALIDAS -
                  <?php if ($local == 'all') {
                    echo 'TODAS LAS SUCURSALES';
                  } else {
                    echo $nomloc;
                  } ?>
                </strong></div>
            </td>
            <td width="260">
              <div align="right"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div>
            </td>
            <!-- <td rowspan="2" width="26">
              <a href="ver_movimiento_excel.php?invnum=<?php echo $invnum; ?>&mov=<?php echo $mov; ?>&user=<?php echo $user; ?>&local=<?php echo $local; ?>&desc_mov=<?php echo $desc_mov; ?>">
                <img src="excel.svg" alt="descargar en excel" width="50" height="50" id="Tres" />
              </a>
            </td> -->
          </tr>
          <tr>
            <td width="267"><strong><?php echo $desc_mov ?></strong></td>
            <td width="366">
              <div align="center"><b>
                  <?php if ($val == 1) { ?>
                    NRO DE DOCUMENTO ENTRE EL <?php echo $desc; ?> Y EL <?php echo $desc1;
                                                                      }
                                                                      if ($vals == 2) { ?> FECHAS ENTRE EL <?php echo $date1; ?> Y EL <?php echo $date2;
                                                                                                                                    } ?></b></div>
            </td>
            <td width="267">
              <div align="right">USUARIO:<span class="text_combo_select"><?php echo $users ?></span></div>
            </td>

          </tr>
        </table>

        <div align="center"><img src="../../images/line2.png" width="100%" height="4" /></div>
      </td>
    </tr>
  </table>
  <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td>
        <table width="100%" border="0" align="center" style="background:#f0f0f0;border: 1px solid #cdcdcd;border-spacing:0;border-collapse: collapse;" class="no-spacing" cellspacing="0">
          <tr>
            <td style="text-align: left;width:20%"><b>FECHA/HORA : </b><?php echo fecha($invfec).' - '.$hora ?></td>
            <td style="text-align: left;width:20%"><b>INTERNO : </b><?php echo formato($invnum) ?></td>
            <td style="text-align: left;width:20%"><b>TIPO MOV : </b><?php echo $desc_mov ?></td>
            <td style="text-align: left;width:20%"><?php if (($desc_mov <> 'INGRESO POR COMPRA')) { ?><b>N&ordm; DOCUMENTO : </b><?php echo formato($numdoc);
                                                                                                                                } ?></td>
            <td style="text-align: left;width:20%;"><b>MONTO : </b><?php echo $valor_compra_unitario = number_format($monto, 2, '.', ' '); ?></td>
          </tr>
          <?php if ($Sucursal <> '') { ?>
            <tr>
              <td colspan="3">
                <b>REFERENCIA / TRANSPORTISTA : </b>
                <?php
                echo $refere;
                echo "...";
                ?>
              </td>
              <?php if ($filtro_transferencia == 1) { ?>
                <td style="text-align: left;"> <b>LOCAL DE ENVIO : </b><?php echo $sucursal_destino; ?> </td>
              <?php } else { ?>
                <td style="text-align: left;"> <b>LOCAL ORIGEN : </b><?php echo $Sucursal; ?> </td>
              <?php } ?>
              <?php if ($filtro_transferencia == 1) { ?>
                <td style="text-align: left;"> <b>LOCAL DE INGRESO : </b><?php echo $Sucursal; ?> </td>
              <?php } else { ?>
                <td style="text-align: left;"> <b>LOCAL DESTINO : </b><?php echo $sucursal_destino; ?> </td>
              <?php } ?>

              <td style="text-align: left;">
                <b>USUARIO : </b><?php echo $users2; ?>
              </td>
            </tr>
          <?php } ?>


          <?php if (($desc_mov == 'INGRESO POR COMPRA')) { ?>
            <tr>
              <td style="text-align: left;background:#1384a0;color:#ffffff;"><b>PROVEEDOR : </b><?php echo $Proveedor; ?></td>
              <td style="text-align: left;background:#1384a0;color:#ffffff;"><b>N&ordm; DOC : </b><?php echo $numdocD1 . '-' . $numdocD2; ?> </td>
              <td style="text-align: left;"><b>TIPO. DOC : </b><?php echo $forpagTexto; ?></td>
              <td style="text-align: left;"><b>INGRESO CON IGV : </b> <?php echo $incluidoIGV; ?></td>
              <td style="text-align: left;"><b>LOCAL : </b><?php echo $Sucursal; ?></td>
            </tr>


            <?php if ($plazo > 0) { ?>
              <tr>
                <td colspan="2" style="text-align: left;width:50%"><b>Plazo : </b><?php echo $plazo; ?></td>
                <td colspan="3 " style="text-align: left;width:50%"><b>Fecha. P : </b><?php echo fecha($fecven); ?></td>
              </tr>
            <?php } ?>
            <tr>
              <td style="text-align: left;"><b>AFECTO :</b> <?php echo number_format($dafecto, 2, '.', ' '); ?></td>
              <td style="text-align: left;"><b>INAFECTO :</b> <?php echo number_format($dinafecto, 2, '.', ' '); ?></td>
              <td style="text-align: left;"><b>IGV :</b> <?php echo number_format($digv, 2, '.', ' '); ?></td>
              <td style="text-align: left;"><b>TOTAL : </b><?php echo number_format($dtotal, 2, '.', ' '); ?></td>
              <td style="text-align: left;"><b>USUARIO : </b><?php echo $users2; ?></td>

            </tr>

          <?php } ?>
        </table>

      </td>
    </tr>
  </table>

  <?php
  if ($tipmov == 1) {
    if ($tipdoc == 2) {
  ?>
      <!-- <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>
            <table width="100%" border="0" align="center">
              <tr>
                <td width="150"><strong>DE LOCAL:</strong> <?php echo $nombre1 ?></td>
                <td width="150"><strong>A LOCAL:</strong> <?php echo $nombre ?></td>
                <td width="310"><strong>USUARIO ORIG: </strong> <?php echo $nomusuorig; ?></td>
                <td width="316"><strong>USUARIO DEST: </strong><?php echo $nomusudest; ?></td>
              </tr>
            </table>
          </td>
        </tr>
      </table> -->
    <?php
    }
  }
  if ($tipmov == 2) {
    if ($tipdoc == 3) {
    ?>
      <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>
            <table width="100%" border="0" align="center">
              <tr>
                <td width="150"><strong>DE LOCAL:</strong> <?php echo $nombre ?></td>
                <td width="150"><strong>A LOCAL:</strong> <?php echo $nombre1 ?></td>
                <td width="310"><strong>USUARIO ORIG: </strong> <?php echo $nomusudest; ?></td>
                <td width="316"><strong>USUARIO DEST: </strong><?php echo $nomusuorig; ?></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
  <?php
    }
  }
  ?>
  <div align="center"><img src="../../images/line2.png" width="910" height="4" /></div>

  <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td>
        <?php $sql = "SELECT * FROM movmov where invnum = '$invnum' ";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
        ?>
          <table width="100%" border="1" align="center" id="customers">
            <tr>
              <th width="2%"><strong>CODIGO</strong></th>
              <th width="5%">
                <div align="right"><strong>CANTIDAD </strong></div>
              </th>
              <th width="25%"><strong>
                  <div align="left"> PRODUCTO</div>
                </strong></th>
              <th width="10%"><strong>MARCA/LABORATORIO</strong></th>
              <?php if ($filtro_transferencia == 0) { ?>
                <th width="4%"><strong>LOTE</strong></th>
                <th width="5%"><strong>VENCIMIENTO</strong></th>
              <?php } ?>
              <?php if ($incluidoIGV == 'SI') { ?>
                <th width="10%">
                  <div align="center"><strong>VALOR DE COMPRA UNITARIO </strong></div>
                </th>
              <?php } else { ?>
                <th width="10%">
                  <div align="center"><strong>VALOR DE COMPRA UNITARIO </strong></div>
                </th>
              <?php } ?>
              <?php if ($filtro_compra == 1) { ?>
                <th width="5%">
                  <div align="right"><strong>DESC 1 </strong></div>
                </th>
                <th width="5%">
                  <div align="right"><strong>DESC 2 </strong></div>
                </th>
                <th width="5%">
                  <div align="right"><strong>DESC 3 </strong></div>
                </th>
              <?php } ?>
              <th width="5%">
                <div align="center"><strong>VALOR COMPRA </strong></div>
              </th>
              <th width="5%">
                <div align="center"><strong>IGV(18%) </strong></div>
              </th>
              <th width="10%">
                <div align="center"><strong>PRECIO DE COMPRA UNITARIO </strong></div>
              </th>
              <th width="10%">
                <div align="right"><strong> PRECIO DE COMPRA </strong></div>
              </th>
            </tr>
            <?php while ($row = mysqli_fetch_array($result)) {
              $codpro    = $row['codpro'];
              $qtypro    = $row['qtypro'];
              $qtyprf    = $row['qtyprf'];
              $pripro    = $row['pripro'];
              $prisal    = $row['prisal'];
              $costre    = $row['costre'];
              $desc1     = $row['desc1'];
              $desc2     = $row['desc2'];
              $desc3     = $row['desc3'];
              $numlotereg     = $row['numlote'];

              $precio_compra = $costre;
             // echo $precio_compra;
              $sql1 = "SELECT desprod,factor,codmar FROM producto where codpro = '$codpro'  ";
              $result1 = mysqli_query($conexion, $sql1);
              if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                  $desprod    = $row1['desprod'];
                  $factor     = $row1['factor'];
                  $codmar     = $row1['codmar'];
                }
              }
              $numlote2 = '';
              $vencim = '';
              $codkard = '';
              $idlote = '';

              $numlote = "";
              $vencim = "";
              $sqlProd = "SELECT numlote,vencim from  movlote WHERE codpro = '$codpro' and idlote ='$numlotereg'";

              $resultProd = mysqli_query($conexion, $sqlProd);
              if (mysqli_num_rows($resultProd)) {
                while ($row = mysqli_fetch_array($resultProd)) {
                  $numlote = $row['numlote'];
                  $vencim = $row['vencim'];
                }
              }
              $sql1 = "SELECT destab,abrev FROM titultabladet  where codtab = '$codmar'";
              $result1 = mysqli_query($conexion, $sql1);
              if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                  $destab = $row1['destab'];
                  $abrev = $row1['abrev'];
                  
                
                }
              }

              if ($qtyprf == "") {
                $cantidad = $qtypro;
                $cantidad2 = $qtypro;
              } else {
                $cantidad = $qtyprf;
                $cantidad2 = convertir_a_numero($qtyprf);
              }
              /*if ($filtro_salida_transferencia == 1) {
                //salida de tranferecia de sucursales

                $valor_compra_unitario = number_format($pripro / 1.18, 2, '.', ' ');
                $valor_compra = number_format($cantidad2 * $valor_compra_unitario, 2, '.', ' ');
                $igv = number_format($precio_compra - $valor_compra, 2, '.', ' ');
                $precio_compra_unitario = $pripro;
              } else if ($filtro_compra == 1) {
                // para compras
                if ($incluidoIGV_n == 1) {
                  $valor_compra_unitario = number_format($prisal / 1.18, 2, '.', ' ');
                  $prisal = $prisal;
                  $prisal = number_format($prisal, 2, '.', ' ');
                  $igv_con = number_format($precio_compra / 1.18, 2, '.', ' ');
                  $igv = number_format($precio_compra - $igv_con, 2, '.', ' ');
                  $precio_compra_unitario = $prisal;
                  $valor_compra = number_format($cantidad2 * $valor_compra_unitario, 2, '.', ' ');
                } else {
                  $valor_compra_unitario = number_format($prisal / 1.18, 2, '.', ' ');
                  $prisal = $prisal * 1.18;
                  $prisal = number_format($prisal, 2, '.', ' ');
                  $igv_con = number_format($precio_compra / 1.18, 2, '.', ' ');
                  $igv = number_format($precio_compra - $igv_con, 2, '.', ' ');
                  $precio_compra_unitario = $prisal;
                  $valor_compra = number_format($cantidad2 * $valor_compra_unitario, 2, '.', ' ');
                }
              } else if ($filtro_otros_ingresos == 1) {
                // filtro para ver otros ingresos 
                $valor_compra_unitario = number_format($prisal / 1.18, 2, '.', ' ');
                $prisal = number_format($prisal, 2, '.', ' ');
                // $igv = number_format($prisal - $valor_compra_unitario, 2, '.', ' ');
                $precio_compra_unitario = $prisal;
                // $valor_compra = number_format(($cantidad2 * ($precio_compra / 1.18)), 2, '.', ' ');
                $valor_compra = number_format($cantidad2 * $valor_compra_unitario, 2, '.', ' ');
                $igv = number_format($precio_compra - $valor_compra, 2, '.', ' ');
              } else if ($filtro_transferencia  == 1) {

                $valor_compra_unitario = number_format($pripro / 1.18, 2, '.', ' ');
                $valor_compra = number_format($cantidad2 * $valor_compra_unitario, 2, '.', ' ');
                $igv = number_format($precio_compra - $valor_compra, 2, '.', ' ');
                $precio_compra_unitario = $pripro;
              }*/

  if ($filtro_salida_transferencia == 1) {
                //salida de tranferecia de sucursales

                $valor_compra_unitario = number_format($pripro / 1.18, 2, '.', ' ');
                $valor_compra = number_format($cantidad2 * $valor_compra_unitario, 2, '.', ' ');
                $igv = number_format($precio_compra - $valor_compra, 2, '.', ' ');
                $precio_compra_unitario = $pripro;
              } else if ($filtro_compra == 1) {
                // para compras
              //  echo '$filtro_compra = '.$filtro_compra;
                if ($incluidoIGV_n == 1) {
                  $valor_compra = number_format($precio_compra / 1.18, 2, '.', ' '); 
                  $valor_compra_unitario =number_format( $valor_compra /$cantidad2 , 2, '.', ' '); 
                  $precio_compra_unitario=number_format( $precio_compra / $cantidad2 , 2, '.', ' ');  
                  $precio_compra_unitario=number_format( $precio_compra / $cantidad2 , 2, '.', ' ');  
                  $igv = number_format( $precio_compra - $valor_compra  , 2, '.', ' ');   
                  //$igv = number_format($precio_compra - $igv_con, 2, '.', ' ');
                 
                   
                } else {
                  $valor_compra = number_format($precio_compra / 1.18, 2, '.', ' '); 
                  $valor_compra_unitario =number_format( $valor_compra /$cantidad2 , 2, '.', ' '); 
                  $precio_compra_unitario=number_format( $precio_compra / $cantidad2 , 2, '.', ' ');  
                  $igv = number_format( $precio_compra - $valor_compra  , 2, '.', ' ');   
                }
              } else if ($filtro_otros_ingresos == 1) {
                // filtro para ver otros ingresos 
                $valor_compra = number_format($precio_compra / 1.18, 2, '.', ' '); 
                  $valor_compra_unitario =number_format( $valor_compra /$cantidad2 , 2, '.', ' '); 
                  $precio_compra_unitario=number_format( $precio_compra / $cantidad2 , 2, '.', ' ');  
                  $igv = number_format( $precio_compra - $valor_compra  , 2, '.', ' ');   
              } else if ($filtro_transferencia  == 1) {
                // filtro para ver otras salidas 
           $valor_compra = number_format($precio_compra / 1.18, 2, '.', ' '); 
                  $valor_compra_unitario =number_format( $valor_compra /$cantidad2 , 2, '.', ' '); 
                  $precio_compra_unitario=number_format( $precio_compra / $cantidad2 , 2, '.', ' ');  
                  $igv = number_format( $precio_compra - $valor_compra  , 2, '.', ' ');   
                  //$igv = number_format($precio_compra - $igv_con, 2, '.', ' ');
                 
              }




              $suma_igv += $igv;
              $suma_total += $precio_compra;
              $suma_valor_compra_unitario += $valor_compra_unitario;
              $suma_valor_compra += $valor_compra;

            ?>
              <tr>
                <td><?php echo $codpro; ?></td>
                <td>
                  <div align="center"><?php echo $cantidad ?></div>
                </td>
                <td><?php echo $desprod;
                    echo " "; /*if ($pripro == 0){?>(BONIF)<?php }*/ ?></td>
                <td><?php echo $destab; ?></td>
                <?php if ($filtro_transferencia == 0) { ?>
                  <td>
                    <div align="center"><?php echo $numlote; ?></div>
                  </td>
                  <td>
                    <div align="center"><?php echo $vencim; ?></div>
                  </td>
                <?php } ?>
                <td>
                  <div align="right"><?php echo $valor_compra_unitario;  ?></div>
                </td>
                <?php if ($filtro_compra == 1) { ?>
                  <td>
                    <div align="right"><?php echo $desc1; ?></div>
                  </td>
                  <td>
                    <div align="right"><?php echo $desc2; ?></div>
                  </td>
                  <td>
                    <div align="right"><?php echo $desc3; ?></div>
                  </td>
                <?php } ?>
                <td>
                  <div align="center"><?php echo $valor_compra; ?></div>
                </td>
                <td>
                  <div align="center"><?php echo $igv; ?></div>
                </td>
                <td>
                  <div align="center"><?php echo $precio_compra_unitario ?></div>
                </td>
                <td>
                  <div align="right"><?php echo $precio_compra; ?></div>
                </td>
              </tr>
            <?php }
            ?>

          </table>

        <?php }
        ?>
      </td>
    </tr>

  </table>


  <table width="100%" border="0" bgcolor="#d9d9d9">
    <tr>
      <td colspan="7">
        <div>
          <img src="../../../images/line2.png" width="100%" height="4" />
        </div>
      </td>
    </tr>
    <tr>
      <td width="33%">
        <div align="center">
          <strong>VALOR COMPRA : </strong><?php echo $suma_valor_compra; ?> 
        </div>
      </td>
      <td width="33%">
        <div align="center">
          <strong>IGV : </strong><?php echo $suma_igv; ?> 
        </div>
      </td>
      <td width="33%">
        <div align="center">
          <strong>TOTAL : </strong><?php echo $suma_total; ?>
        </div>
      </td>
    </tr>
  </table>
</body>

</html>