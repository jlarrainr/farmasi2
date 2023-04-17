<?php include('../../../session_user.php');
$ord_compra   = $_SESSION['ord_compra'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>Documento sin t&iacute;tulo</title>
  <link href="../css/style1.css" rel="stylesheet" type="text/css" />
  <link href="../css/tabla2.css" rel="stylesheet" type="text/css" />
  <link href="../../../../css/autocomplete.css" rel="stylesheet" type="text/css" />
  <?php require_once('../../../../conexion.php');  //CONEXION A BASE DE DATOS
  require_once("../../../../funciones/highlight.php");  //ILUMINA CAJAS DE TEXTOS
  //require_once("../../../../funciones/functions.php");	//DESHABILITA TECLAS
  require_once("../../../../funciones/botones.php");  //COLORES DE LOS BOTONES
  require_once("../../../../funciones/funct_principal.php");  //IMPRIMIR-NUME
  require_once("../funciones/compra.php");  //IMPRIMIR-NUME
  require_once("../../../local.php");  //LOCAL DEL USUARIO
  $sql = "SELECT nomusu FROM usuario where usecod = '$usuario'";
  $result = mysqli_query($conexion, $sql);
  if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
      $user    = $row['nomusu'];
    }
  }
  ?>
  <script type="text/javascript" src="../../../../funciones/ajax.js"></script>
  <script type="text/javascript" src="../../../../funciones/ajax-dynamic-list.js"></script>
  <style type="text/css">
    .Estilo5 {
      color: #666666;
      font-weight: bold;
    }

    #country {
      width: 70%;
      box-sizing: border-box;
      border: 2px solid #ccc;
      border-radius: 5px;
      font-size: 14px;
      background-color: white;
      background-image: url('../../../movimientos/compras/buscador.png');
      background-position: 3px 3px;
      background-repeat: no-repeat;
      padding: 5px 15px 3px 35px;
    }
  </style>
  <script>
    function agregar() {
      var f = document.form1;
      if (document.form1.country.value == "") {
        alert("Ingrese el nombre del Proveedor");
        f.country.focus();
        return;
      }
      f.submit();
    }
  </script>
</head>

<body onload="barra()">
  <form name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)" method="post" action="add_proveedor1.php" target="compra_index">
    <table width="100%" border="0" align="center">
      <tr>
        <td width="100%">
          <table width="100%" border="0" align="center">
            <tr>
              <!-- <td width="69"><span class="Estilo5">PROVEEDOR</span></td> -->
              <td width="80%"><input name="country" type="text" id="country" onkeyup="ajax_showOptions(this,'getCountriesByLetters',event)" size="100" onclick="this.value=''" placeholder="Buscar Proveedor....." />
                <input name="val" type="hidden" id="val" value="1" />
                <input type="hidden" id="country_hidden" name="country_ID" /></td>
              <td width="20%" align="right">
                <input name="search" type="button" id="search" value="Agregar" onclick="agregar()" class="buscar" />
              </td>
            </tr>
          </table>
          <div align="center">
            <img src="../../../../images/j_border.png" width="100%" height="1" />
          </div>
          <iframe src="proveedor1.php" name="proveedor" width="100%" height="450" scrolling="Automatic" frameborder="0" id="proveedor" allowtransparency="0">
          </iframe>
        </td>
      </tr>
    </table>
  </form>
</body>

</html>