<?php include('../../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>Documento sin t&iacute;tulo</title>
  <link href="../../../../css/style.css" rel="stylesheet" type="text/css" />
  <link href="../css/tablas.css" rel="stylesheet" type="text/css" />
  <link href="autocomplete.css" rel="stylesheet" type="text/css" />
  <?php require_once("../../../../conexion.php");
  require_once("../../../../funciones/botones.php"); //COLORES DE LOS BOTONES
  require_once("../../../../funciones/highlight.php");  //ILUMINA CAJAS DE TEXTOS
  $sql = "SELECT nomusu FROM usuario where usecod = '$usuario'";
  $result = mysqli_query($conexion, $sql);
  if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
      $user    = $row['nomusu'];
    }
  }
  $val    = $_REQUEST['val'];
  $codpro = $_REQUEST['country_ID'];
  ?>
  <script>
    function busca() {
      var f = document.form1;
      if (f.country.value == "") {
        alert("Ingrese el nombre del Proveedor");
        f.country.focus();
        return;
      }
      f.target = "_top";
      f.method = "post";
      f.action = "../mov_proveedor.php";
      f.submit();
    }
  </script>
  <script type="text/javascript" src="../../../../funciones/ajax.js"></script>
  <script type="text/javascript" src="../../../../funciones/ajax-dynamic-list.js"></script>
  <style>
    #country {
      width: 70%;
      box-sizing: border-box;
      border: 2px solid #ccc;
      border-radius: 2px;
      font-size: 12px;
      background-color: white;
      background-image: url('../../../movimientos/compras/buscador.png');
      background-position: 3px 3px;
      background-repeat: no-repeat;
      padding: 5px 5px 3px 35px;
    }
  </style>
</head>

<body>
  <table class="tabla2" width="100%" border="0" bgcolor="#FFFFCC" cellpadding="0" cellspacing="0">
    <tr>
      <td>
        <form id="form1" name="form1" onkeyup="highlight(event)" onclick="highlight(event)" method="post" target="_top" action="../mov_proveedor.php">
          <div>
            <input height="100%" name="country" type="text" id="country" onkeyup="ajax_showOptions(this,'getCountriesByLetters',event)" size="80%" onclick="this.value=''" placeholder="Buscar proveedor . . ." />
            <input height="100%" name="search" type="hidden" id="search" value="1" />
            <input height="100%" type="hidden" id="country_hidden" name="country_ID" />
            <input height="100%" name="Submit" type="button" value="BUSCAR" onclick="busca()" class="buscar" />
            <div class="contenedor">
              <div id="lista" class="fill">
              </div>
            </div>
          </div>
        </form>
      </td>
    </tr>
  </table>
  <?php $search  = $_REQUEST['search'];
  $val  = $_POST['val'];
  if (($val == 1) || ($search == 1)) {
    $buscar = $_POST['buscar'];
    $proveedor = $_REQUEST['proveedor'];
  ?>
    <table width="100%" border="0" class="tabla2" cellpadding="0" cellspacing="0">
      <?php if ($val == 1) {
        $sql = "SELECT codpro,despro FROM proveedor where despro like '%$buscar%'";
      } else {
        $sql = "SELECT codpro,despro FROM proveedor where despro like '%$proveedor%'";
      }
      $result = mysqli_query($conexion, $sql);
      if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
          $codpro         = $row["codpro"];
          $despro         = $row["despro"];
      ?>
          <tr onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
            <td width="307"><?php echo $despro ?></td>
            <td width="41"><a href="mov_proveedor.php?codproveedor=<?php echo $codpro ?>&search=1&word=<?php echo $buscar ?>" target="_top"><img src="../../images/lens.gif" width="15" height="16" border="0" /></a></td>
          </tr>
    <?php }
      }
    }
    ?>
    </table>
</body>

</html>