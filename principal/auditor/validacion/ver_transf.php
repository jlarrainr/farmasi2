<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="../css/style1.css" rel="stylesheet" type="text/css" />
<?php
require_once('../../../conexion.php');  //CONEXION A BASE DE DATOS
require_once('../../../convertfecha.php');  //CONEXION A BASE DE DATOS
require_once("../../../funciones/functions.php");  //DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");  //IMPRIMIR-NUME
function formato($c)
{
  printf("%08d",  $c);
}
$invnum = $_REQUEST['invnum'];
$sql = "SELECT invnum,invfec,numdoc,invtot,sucursal,sucursal1,estado,usecod, TIME(hora) as hora  FROM movmae where invnum = '$invnum'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
  while ($row = mysqli_fetch_array($result)) {
    $invnum         = $row['invnum'];
    $invfec         = $row['invfec'];
    $numdoc         = $row['numdoc'];
    $invtot         = $row['invtot'];
    $sucursal       = $row['sucursal'];
    $sucursal1      = $row['sucursal1'];
    $estado         = $row['estado'];
    $usecodEnvio         = $row['usecod'];
    $hora =    $row['hora'];
    if ($estado == 1) {
      $desc = "TRANSFERENCIA RECIBIDA";
    } else {
      $desc = "TRANSFERENCIA AUN NO RECIBIDA";
    }
  }
}
$sql = "SELECT nomusu FROM usuario where usecod = '$usecodEnvio'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
  while ($row = mysqli_fetch_array($result)) {
    $descli    = $row['nomusu'];
  }
}
$sql1 = "SELECT nomloc FROM xcompa where codloc = '$sucursal'";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
  while ($row1 = mysqli_fetch_array($result1)) {
    $localorig         = $row1['nomloc'];
  }
}
$sql1 = "SELECT nomloc FROM xcompa where codloc = '$sucursal1'";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
  while ($row1 = mysqli_fetch_array($result1)) {
    $localdest        = $row1['nomloc'];
  }
}
?>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title></title>
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
</head>

<body>
  <table width="968" border="0" align="center" bgcolor="#FFFFCC">
    <tr>
      <td>
        <table width="942" border="0" align="center">
          <tr>
            <td><strong>TRANSFERENCIA ENVIADA </strong></td>
          </tr>
        </table>
        <table width="942" border="1" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="922">
              <table width="935" border="0" align="center">
                <tr>
                  <td width="69"><strong>NUMERO</strong></td>
                  <td width="80"><?php echo formato($numdoc) ?></td>
                  <td width="43"><strong>FECHA</strong></td>
                  <td width="124"><?php echo fecha($invfec) ?></td>
                  <td width="43"><strong>HORA</strong></td>
                  <td width="124"><?php echo $hora ?></td>
                  <td width="597">
                    <div align="right"><?php echo $desc ?></div>
                  </td>
                </tr>
              </table>
              <table width="935" border="0" align="center">
                <tr>
                  <td width="108"><strong>SUCURSAL ORIG </strong></td>
                  <td width="315"><?php echo $localorig ?></td>
                  <td width="251">&nbsp;</td>
                  <td width="62">
                    <div align="left"><strong>USUARIO</strong></div>
                  </td>
                  <td width="177"><?php echo $descli ?></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <table width="942" border="1" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="937">


              <?php $i = 0;
              $sql1 = "SELECT codpro,qtypro,qtyprf,pripro,costre,numlote FROM movmov where invnum = '$invnum'";
              $result1 = mysqli_query($conexion, $sql1);
              if (mysqli_num_rows($result1)) {
              ?>
                <table width="935" border="0" align="center" id="customers">
                  <tr>
                    <th><strong>N&ordm;</strong></th>
                    <th><strong>CODIGO</strong></th>
                    <th><strong>PRODUCTO</strong></th>
                    <th><strong>FACTOR</strong></th>
                    <th><strong>MARCA</strong></th>
                    <th><strong>LOTE</strong></th>
                    <th><strong>VENCIMIENTO</strong></th>
                    <th>
                      <div align="right"><strong>CANTIDAD</strong></div>
                    </th>
                    <th>
                      <div align="right"><strong>PRECIO </strong></div>
                    </th>
                    <th>
                      <div align="right"><strong>SUB TOTAL </strong></div>
                    </th>
                  </tr>
                  <?php while ($row1 = mysqli_fetch_array($result1)) {
                    $codpro    = $row1['codpro'];
                    $qtypro    = $row1['qtypro'];
                    $qtyprf    = $row1['qtyprf'];
                    $pripro    = $row1['pripro'];
                    $costre    = $row1['costre'];
                    $numloteRegistro    = $row1['numlote'];
                    $sql2 = "SELECT desprod,codmar,factor FROM producto where codpro = '$codpro'";
                    $result2 = mysqli_query($conexion, $sql2);
                    if (mysqli_num_rows($result2)) {
                      while ($row2 = mysqli_fetch_array($result2)) {
                        $desprod    = $row2['desprod'];
                        $codmar    = $row2['codmar'];
                        $factor    = $row2['factor'];
                      }
                    }

                    // $numlote = "";
                    // $vencim = "";
                    $sqlProd = "SELECT numlote,vencim from  movlote WHERE  idlote ='$numloteRegistro'";
                    $resultProd = mysqli_query($conexion, $sqlProd);
                    if (mysqli_num_rows($resultProd)) {
                      while ($row = mysqli_fetch_array($resultProd)) {
                        $numlote = $row['numlote'];
                        $vencim = $row['vencim'];
                      }
                    }
                    $sqlCodmar = "SELECT destab,abrev FROM titultabladet  where codtab = '$codmar'";
                    $resultCodmar = mysqli_query($conexion, $sqlCodmar);
                    if (mysqli_num_rows($resultCodmar)) {
                      while ($rowCodmar = mysqli_fetch_array($resultCodmar)) {
                        $destab = $rowCodmar['destab'];
                        $abrev = $rowCodmar['abrev'];
                      }
                    }
                    if ($qtypro == 0) {
                      $cantidad = $qtyprf;
                    } else {
                      $cantidad = $qtypro;
                    }
                    $cantidad = strtoupper($cantidad);
                    $i++;
                  ?>
                    <tr>
                      <td><?php echo $i ?></td>
                      <td><?php echo $codpro ?></td>
                      <td><?php echo $desprod ?></td>
                      <td><?php echo $factor ?></td>
                      <td><?php echo $destab ?></td>
                      <td><?php echo $numlote ?></td>
                      <td><?php echo $vencim ?></td>
                      <td>
                        <div align="center"><?php echo $cantidad ?></div>
                      </td>
                      <td>
                        <div align="right"><?php echo $pripro ?></div>
                      </td>
                      <td>
                        <div align="right"><?php echo $costre ?></div>
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
        <table width="942" border="1" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td>
              <table width="935" border="0" align="center">
                <tr>
                  <td width="761">&nbsp;</td>
                  <td width="77"><strong>TOTAL</strong></td>
                  <td width="83">
                    <div align="right"><?php echo $numero_formato_frances = number_format($invtot, 2, '.', ' '); ?></div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <?php if ($estado == 1) {
    $sql1 = "SELECT invnum,invfec,numdoc,invtot,usecod, TIME(hora) as hora1  FROM movmae where invnumrecib = '$invnum'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
      while ($row1 = mysqli_fetch_array($result1)) {
        $invnum1         = $row1['invnum'];
        $invfec1         = $row1['invfec'];
        $numdoc1         = $row1['numdoc'];
        $invtot1         = $row1['invtot'];
        $usecod1         = $row1['usecod'];
        $hora1         = $row1['hora1'];
      }
    }
    $sql = "SELECT nomusu FROM usuario where usecod = '$usecod1'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
      while ($row = mysqli_fetch_array($result)) {
        $descli1    = $row['nomusu'];
      }
    }
  ?>
    <br>
    <hr />
    <br>
    <table width="968" border="0" align="center" bgcolor="#CCFFCC">
      <tr>
        <td>
          <table width="942" border="0" align="center">
            <tr>
              <td><strong>TRANSFERENCIA RECIBIDAD </strong></td>
            </tr>
          </table>
          <table width="942" border="1" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="922">
                <table width="935" border="0" align="center">
                  <tr>
                    <td width="69"><strong>NUMERO</strong></td>
                    <td width="80"><?php echo formato($numdoc1) ?></td>
                    <td width="43"><strong>FECHA</strong></td>
                    <td width="124"><?php echo $invfec1 ?></td>
                    <td width="43"><strong>HORA</strong></td>
                    <td width="124"><?php echo $hora1 ?></td>
                    <td width="597"></td>
                  </tr>
                </table>
                <table width="935" border="0" align="center">
                  <tr>
                    <td width="121"><strong>SUCURSAL DESTINO </strong></td>
                    <td width="316"><?php echo $localdest ?></td>
                    <td width="237">&nbsp;</td>
                    <td width="62">
                      <div align="left"><strong>USUARIO</strong></div>
                    </td>
                    <td width="177"><?php echo $descli1 ?></td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <table width="942" border="1" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="937">
                <table width="935" border="0" align="center">
                  <tr>
                    <td width="41"><strong>N&ordm;</strong></td>
                    <td width="603"><strong>PRODUCTO</strong></td>
                    <td width="110">
                      <div align="right"><strong>CANTIDAD</strong></div>
                    </td>
                    <td width="80">
                      <div align="right"><strong>PRECIO </strong></div>
                    </td>
                    <td width="79">
                      <div align="right"><strong>SUB TOTAL </strong></div>
                    </td>
                  </tr>
                </table>
                <hr />
                <?php $i = 0;
                $sql1 = "SELECT codpro,qtypro,qtyprf,pripro,costre FROM movmov where invnum = '$invnum1'";
                $result1 = mysqli_query($conexion, $sql1);
                if (mysqli_num_rows($result1)) {
                ?>
                  <table width="935" border="0" align="center">
                    <?php while ($row1 = mysqli_fetch_array($result1)) {
                      $codpro    = $row1['codpro'];
                      $qtypro    = $row1['qtypro'];
                      $qtyprf    = $row1['qtyprf'];
                      $pripro    = $row1['pripro'];
                      $costre    = $row1['costre'];
                      $sql2 = "SELECT desprod FROM producto where codpro = '$codpro'";
                      $result2 = mysqli_query($conexion, $sql2);
                      if (mysqli_num_rows($result2)) {
                        while ($row2 = mysqli_fetch_array($result2)) {
                          $desprod    = $row2['desprod'];
                        }
                      }
                      if ($qtypro == 0) {
                        $cantidad = $qtyprf;
                      } else {
                        $cantidad = $qtypro;
                      }
                      $cantidad = strtoupper($cantidad);
                      $i++;
                    ?>
                      <tr onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
                        <td width="41"><?php echo $i ?></td>
                        <td width="603"><?php echo $desprod ?></td>
                        <td width="110">
                          <div align="right"><?php echo $cantidad ?></div>
                        </td>
                        <td width="80">
                          <div align="right"><?php echo $pripro ?></div>
                        </td>
                        <td width="79">
                          <div align="right"><?php echo $costre ?></div>
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
          <table width="942" border="1" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td>
                <table width="935" border="0" align="center">
                  <tr>
                    <td width="761">&nbsp;</td>
                    <td width="77"><strong>TOTAL</strong></td>
                    <td width="83">
                      <div align="right"><?php echo $numero_formato_frances = number_format($invtot1, 2, '.', ' '); ?></div>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  <?php }
  ?>
</body>

</html>