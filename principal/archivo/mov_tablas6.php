<?php include('../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <link href="css/body.css" rel="stylesheet" type="text/css" />
  <link href="css/tablas.css" rel="stylesheet" type="text/css" />
  <link href="../../css/tables_consult.css" rel="stylesheet" type="text/css" />
  <link href="../../css/style.css" rel="stylesheet" type="text/css" />
  <title>Documento sin t&iacute;tulo</title>
  <script type="text/javascript" language="JavaScript1.2" src="/comercial/funciones/control.js"></script>
  <?php require_once("../../conexion.php"); ?>
  <?php require_once("funciones/mov_tablas.php"); ?>
  <?php require_once("../../funciones/functions.php"); ?>
  <?php require_once("../../funciones/funct_principal.php"); ?>
  <?php require_once("../../funciones/botones.php");  //COLORES DE LOS BOTONES
  ?>
  <style type="text/css">
    /* <!--
.Estilo1 {font-size: 11px}
--> */
  </style>
</head>

<body onLoad="st();">
  <br>
  <?php $codtab  = $_REQUEST['cod'];
  $sql = "SELECT tiptab,destab FROM titultabladet where codtab = '$codtab'";
  $result = mysqli_query($conexion, $sql);
  if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
      $tiptab                 = $row["tiptab"];
      $destab                 = $row["destab"];
    }
  }
  $sql = "SELECT cdgen,dsgen FROM titultabla where ltdgen = '$tiptab'";
  $result = mysqli_query($conexion, $sql);
  if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
      $cdgen                 = $row["cdgen"];
      $dsgen                 = $row["dsgen"];
    }
  }
  ?>
  <form name="form1" id="form1">
    <table width="100%" align="center" class="demoTable">
      <caption>
        <span class="Estilo1">ELIMINAR - <?php echo $dsgen ?> </span>
      </caption>
      <thead>
        <tr>

          <th width="93">
            <div align="left">ABREVIATURA </div>
          </th>
          <th width="404">
            <div align="left">DESCRIPCION </div>
          </th>
          <th width="57">
            <div align="left"></div>
          </th>

        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="3">
            <div align="center">

              <div align="right">
                <input name="codtab" type="hidden" id="codtab" value="<?php echo $codtab ?>" />
                <input name="btn" type="hidden" id="btn" value="3" />
                <input name="cod" type="hidden" id="cod" value="<?php echo $cdgen ?>" />
                <input name="tipo" type="hidden" id="tipo" value="<?php echo $tiptab ?>" />
                <input type="button" name="print" value="Imprimir" onclick="imprimir()" class="imprimir" />
                <input type="button" name="back" value="Regresar" onClick="back_movtabla5()" class="regresar" />
                <input type="button" name="exit" value="Salir" onClick="salir1()" class="salir" />
              </div>

            </div>
          </td>
        </tr>
      </tfoot>
      <tbody>

        <tr>
          <td><b>
              <center>"<?php echo $tiptab ?>"</center>
            </b></td>
          <td>

            <div align="left">
              <?php echo $destab ?>


            </div>

          </td>
          <td>
            <center>

              <input type="button" name="Submit" value="Eliminar" onclick="del_movtabla6()" class="eliminar" />

            </center>
          </td>
        </tr>

      </tbody>
    </table>
  </form>
</body>

</html>