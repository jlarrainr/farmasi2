<?php include('../../session_user.php');
$ord_compra   = $_SESSION['ord_compra'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>Documento sin t&iacute;tulo</title>
  <link href="css/style1.css" rel="stylesheet" type="text/css" />
  <link href="css/tabla2.css" rel="stylesheet" type="text/css" />
  <?php require_once('../../../conexion.php');  //CONEXION A BASE DE DATOS
  require_once("../../../funciones/highlight.php");  //ILUMINA CAJAS DE TEXTOS
  //require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
  require_once("../../../funciones/botones.php");  //COLORES DE LOS BOTONES
  require_once("../../../funciones/funct_principal.php");  //IMPRIMIR-NUME
  require_once("funciones/compra.php");  //IMPRIMIR-NUME
  require_once("../../local.php");  //LOCAL DEL USUARIO
  $sql = "SELECT nomusu FROM usuario where usecod = '$usuario'";
  $result = mysqli_query($conexion, $sql);
  if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
      $user    = $row['nomusu'];
    }
  }
  $codpro = $_REQUEST['codpro'];
  $val    = $_REQUEST['val'];
  $cr     = $_REQUEST['cr'];
  ?>
  <style type="text/css">
    .Estilo8 {
      color: #666666;
      font-weight: bold;
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
      background-color: #50adea;
      color: white;
      font-size: 12px;
      font-weight: 900;
    }
  </style>
</head>

<body>
  <form name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)">
    <table width="100%" border="0">
      
    </table>

    <table width="100%" border="0" class="tabla2">
      <tr>
        <td>
          <center>
            <iframe src="productos1.php?codpro=<?php echo $codpro ?>&val=<?php echo $val ?>&cr=<?php echo $cr ?>" name="productos" width="100%" height="245" scrolling="Automatic" frameborder="0" id="productos" allowtransparency="0"> </iframe>
          </center>
        </td>
      </tr>
    </table>
    <table width="100%" border="0" class="tabla2">
      <tr>
        <td>
          <center>
            <iframe src="montos.php" name="productos" width="100%" height="45" scrolling="No" frameborder="0" id="productos" allowtransparency="0"> </iframe>
          </center>
        </td>
      </tr>
    </table>
    <table width="100%" border="0">
      <tr>
        <td width="80%">
          <table width="100%" border="0" class="tabla2" style='width:99%;'>
            <tr>
              <td>
                <b>ESTADISTICAS DE VENTAS</b>
                <iframe src="sucursal.php?codpro=<?php echo $codpro ?>" name="sucursal" width="100%" height="80" scrolling="Automatic" frameborder="0" id="sucursal" allowtransparency="0"> </iframe></td>
            </tr>
          </table>
          <table width="100%" border="0" class="tabla2" style='width:99%;'>
            <tr>
              <td>
                <b>VENTAS FALLIDAS POR FALTA DE STOCK</b>
                <iframe src="ventas_fallidas.php?codpro=<?php echo $codpro ?>" name="sucursal1" width="100%" height="70" scrolling="Automatic" frameborder="0" id="sucursal1" allowtransparency="0"> </iframe></td>
            </tr>
          </table>
        </td>
        <td width="20%">
          <table width="100%" border="0" class="tabla2" style='width:99%;'>
            <tr>
              <td><iframe src="ult_compra.php?codpro=<?php echo $codpro ?>" name="ultimas" width="100%" height="180" scrolling="Automatic" frameborder="0" id="ultimas" allowtransparency="0"> </iframe></td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </form>
</body>

</html>