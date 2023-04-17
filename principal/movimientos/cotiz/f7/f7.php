<?php include('../../../session_user.php');
$venta   = $_SESSION['cotiz'];
require_once('../../../../conexion.php');  //CONEXION A BASE DE DATOS
require_once('../../../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title><?php echo $desemp ?></title>
  <link href="../../../../css/style.css" rel="stylesheet" type="text/css" />
  <link href="css/autocomplete.css" rel="stylesheet" type="text/css" />
  <?php require_once("../../../../funciones/funct_principal.php");
  require_once("../../../../funciones/highlight.php");  //ILUMINA CAJAS DE TEXTOS
  require_once("../../../../funciones/botones.php");  //COLORES DE LOS BOTONES
  ?>
  <script type="text/javascript" src="funciones/ajax.js"></script>
  <script type="text/javascript" src="funciones/ajax-dynamic-list.js"></script>
  <style type="text/css">
    body {
      background-color: #FFFFCC;
    }
  </style>
</head>
<?php $cod = $_REQUEST['cod'];
if ($cod <> "") {
  $sql = "SELECT desprod,s000,s001,s002,s003,s004,s005,s006,s007,s008,s009,s010,s011,s012,s013,s014,s015,s016 FROM producto where codpro = '$cod'";
  $result = mysqli_query($conexion, $sql);
  if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
      $desprod         = $row["desprod"];
      $s000           = $row["s000"];
      $s001           = $row["s001"];
      $s002           = $row["s002"];
      $s003           = $row["s003"];
      $s004           = $row["s004"];
      $s005           = $row["s005"];
      $s006           = $row["s006"];
      $s007           = $row["s007"];
      $s008           = $row["s008"];
      $s009           = $row["s009"];
      $s010           = $row["s010"];
      $s011           = $row["s011"];
      $s012           = $row["s012"];
      $s013           = $row["s013"];
      $s014           = $row["s014"];
      $s015           = $row["s015"];
      $s016           = $row["s016"];
    }
  }
  function formato($c)
  {
    printf("%08d",  $c);
  }
?>
  </head>

  <body>
    <form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">
      <div align="center"><img src="../../../../images/line2.png" width="580" height="4" /></div>
      <div align="center">
        <table width="565" border="0">
          <tr>
            <td width="74" valign="top">NRO DE VENTA </td>
            <td width="481" valign="top">
              <input type="text" name="textfield" disabled="disabled" value="<?php echo formato($venta) ?>" /> </td>
          </tr>
          <tr>
            <td valign="top">PRODUCTO</td>
            <td valign="top">
              <input name="nom2" type="text" id="nom2" size="60" value="<?php echo $desprod ?>" disabled="disabled" /></td>
          </tr>
        </table>
        <img src="../../../../images/line2.png" width="570" height="4" />
        <table width="565" border="0">
          <tr>
            <td width="61"><strong>LOCAL</strong></td>
            <td width="494">
              <div align="right"><strong>STOCK</strong></div>
            </td>
          </tr>
        </table>
        <table width="565" border="0">
          <tr>
            <td width="471">LOCAL 0 </td>
            <td width="84">
              <div align="right"><?php echo $s000 ?></div>
            </td>
          </tr>
          <tr>
            <td>LOCAL 1 </td>
            <td>
              <div align="right"><?php echo $s001 ?></div>
            </td>
          </tr>
          <tr>
            <td>LOCAL 2 </td>
            <td>
              <div align="right"><?php echo $s002 ?></div>
            </td>
          </tr>
          <tr>
            <td>LOCAL 3 </td>
            <td>
              <div align="right"><?php echo $s003 ?></div>
            </td>
          </tr>
          <tr>
            <td>LOCAL 4 </td>
            <td>
              <div align="right"><?php echo $s004 ?></div>
            </td>
          </tr>
          <tr>
            <td>LOCAL 5 </td>
            <td>
              <div align="right"><?php echo $s005 ?></div>
            </td>
          </tr>
          <tr>
            <td>LOCAL 6 </td>
            <td>
              <div align="right"><?php echo $s006 ?></div>
            </td>
          </tr>
          <tr>
            <td>LOCAL 7 </td>
            <td>
              <div align="right"><?php echo $s007 ?></div>
            </td>
          </tr>
          <tr>
            <td>LOCAL 8 </td>
            <td>
              <div align="right"><?php echo $s008 ?></div>
            </td>
          </tr>
          <tr>
            <td>LOCAL 9 </td>
            <td>
              <div align="right"><?php echo $s009 ?></div>
            </td>
          </tr>
          <tr>
            <td>LOCAL 10 </td>
            <td>
              <div align="right"><?php echo $s010 ?></div>
            </td>
          </tr>
          <tr>
            <td>LOCAL 11 </td>
            <td>
              <div align="right"><?php echo $s011 ?></div>
            </td>
          </tr>
          <tr>
            <td>LOCAL 12 </td>
            <td>
              <div align="right"><?php echo $s012 ?></div>
            </td>
          </tr>
          <tr>
            <td>LOCAL 13 </td>
            <td>
              <div align="right"><?php echo $s013 ?></div>
            </td>
          </tr>
          <tr>
            <td>LOCAL 14 </td>
            <td>
              <div align="right"><?php echo $s014 ?></div>
            </td>
          </tr>
          <tr>
            <td>LOCAL 15 </td>
            <td>
              <div align="right"><?php echo $s015 ?></div>
            </td>
          </tr>
          <tr>
            <td>LOCAL 16 </td>
            <td>
              <div align="right"><?php echo $s016 ?></div>
            </td>
          </tr>
        </table>
      </div>
      <div align="center"><br>
      </div>
    </form>
  <?php } else {
  ?>
    <center>UD DEBE INDICAR UN PRODUCTO PARA REALIZAR ESTA FUNCION</center>
  <?php }
  ?>
  </body>

</html>