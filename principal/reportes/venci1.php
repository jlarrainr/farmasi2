<?php 



include('../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>Documento sin t&iacute;tulo</title>
  <link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="css/tablas.css" rel="stylesheet" type="text/css" />
  <link href="../../css/style.css" rel="stylesheet" type="text/css" />
  <link href="../../css/calendar/calendar.css" rel="stylesheet" type="text/css">

  <link href="../select2/css/select2.min.css" rel="stylesheet" />
  <script src="../select2/jquery-3.4.1.js"></script>
  <script src="../select2/js/select2.min.js"></script>
  <?php require_once('../../conexion.php');  //CONEXION A BASE DE DATOS
  ?>
  <?php require_once("../../funciones/calendar.php"); ?>
  <?php require_once("../../funciones/functions.php");  //DESHABILITA TECLAS
  ?>
  <?php require_once("../../funciones/functions.php");  //DESHABILITA TECLAS
  ?>
  <?php require_once("../../funciones/funct_principal.php");  //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
  ?>
  <?php require_once("../../funciones/botones.php");  //COLORES DE LOS BOTONES
  ?>
  <?php require_once("local.php");  //OBTENGO EL NOMBRE Y CODIGO DEL LOCAL
  ?>
  <script language="JavaScript">
    function validar1() {
      var f = document.form1;
      if (f.mes.value == "") {
        alert("Ingrese un Mes");
        f.mes.focus();
        return;
      }
      if (f.year.value == "") {
        alert("Ingrese un A���o");
        f.year.focus();
        return;
      }
      var tip = document.form1.report.value;
      if (tip == 1) {
        f.action = "venci1.php";
      } else {
        f.action = "venci_prog.php";
      }
      f.submit();
    }

    function salir() {
      var f = document.form1;
      f.method = "POST";
      f.target = "_top";
      f.action = "../index.php";
      f.submit();
    }

    function printer() {
      window.marco.print();
    }
  </script>
</head>
<?php $date    = date('Y/m/d');
$val     = $_REQUEST['val'];
$val = $_REQUEST['val'];
$mes = $_REQUEST['mes'];
$year = $_REQUEST['year'];
$ckvencidos = $_REQUEST['ckvencidos'];
$report  = $_REQUEST['report'];
$local   = $_REQUEST['local'];
$resumen = $_REQUEST['resumen'];
$sql = "SELECT export FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
  while ($row = mysqli_fetch_array($result)) {
    $export    = $row['export'];
  }
}
$sql = "SELECT nlicencia FROM datagen ";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
  while ($row = mysqli_fetch_array($result)) {
    $nlicencia       = $row['nlicencia'];
  }
}
////////////////////////////
$registros = 40;
$pagina = $_REQUEST["pagina"];
if (!$pagina) {
  $inicio = 0;
  $pagina = 1;
} else {
  $inicio = ($pagina - 1) * $registros;
}
if ($local <> 'all') {
  require_once("datos_generales.php");  //COGE LA TABLA DE UN LOCAL
}
////////////////////////////
$mes1 = date("m");
$a���o1 = date("Y");
$feca1 = $mes1 . '/' . $a���o1;
?>

<body>
  <link rel='STYLESHEET' type='text/css' href='../../css/calendar.css'>
  <table width="100%" border="0">
    <tr>
      <td><b><u>REPORTE DE PRODUCTOS POR VENCER </u></b>
        <form id="form1" name="form1" method="post" action="">
          <table width="100%" border="0" class="tablarepor">
            <tr>
              <td width="30" class="LETRA">SALIDA</td>
              <td width="100">
                <select name="report" id="report">
                  <option value="1">POR PANTALLA</option>
                  <?php if ($export == 1) { ?>
                    <option value="2">EN ARCHIVO XLS</option>
                  <?php } ?>
                </select> </td>
              <td width="70">
                <div align="right" class="LETRA">LOCAL</div>
              </td>
              <td width="161">
                <select style="width:150px" name="local" id="local">
                  <?php if ($nombre_local == 'LOCAL0') { ?>
                    <option value="all" <?php if ($local == 'all') { ?> selected="selected" <?php } ?>>TODOS LOS LOCALES</option>
                  <?php } ?>
                  <?php
                  if ($nombre_local == 'LOCAL0') {
                    $sql = "SELECT * FROM xcompa order by codloc ASC LIMIT $nlicencia";
                  } else {
                    $sql = "SELECT * FROM xcompa where codloc = '$codigo_local'";
                  }
                  $result = mysqli_query($conexion, $sql);
                  while ($row = mysqli_fetch_array($result)) {
                    $loc  = $row["codloc"];
                    $nloc  = $row["nomloc"];
                    $nombre  = $row["nombre"];
                    if ($nombre == '') {
                      $locals = $nloc;
                    } else {
                      $locals = $nombre;
                    }
                  ?>
                    <option value="<?php echo $row["codloc"] ?>" <?php if ($loc == $local) { ?> selected="selected" <?php } ?>><?php echo $locals ?></option>
                  <?php } ?>
                </select>
              </td>
              <td></td>
              <td></td>
              <td></td>
            </tr>

            <tr>
              <td width="30" class="LETRA" colspan="3">Productos con vencimiento hasta </td>
              <td width="250">
                <?php
                if ($mes == "") {
                  $mes = date('m');
                }
                $year_d = date('Y');
                ?>
                <select name="mes" class="Estilodany" id="mes" style="width:150px">
                  <option value="1" <?php if ($mes == 1) { ?>selected="selected" <?php } ?> class="Estilodany">Enero</option>
                  <option value="2" <?php if ($mes == 2) { ?>selected="selected" <?php } ?> class="Estilodany">Febrero</option>
                  <option value="3" <?php if ($mes == 3) { ?>selected="selected" <?php } ?> class="Estilodany">Marzo</option>
                  <option value="4" <?php if ($mes == 4) { ?>selected="selected" <?php } ?> class="Estilodany">Abril</option>
                  <option value="5" <?php if ($mes == 5) { ?>selected="selected" <?php } ?> class="Estilodany">Mayo</option>
                  <option value="6" <?php if ($mes == 6) { ?>selected="selected" <?php } ?> class="Estilodany">Junio</option>
                  <option value="7" <?php if ($mes == 7) { ?>selected="selected" <?php } ?> class="Estilodany">Julio</option>
                  <option value="8" <?php if ($mes == 8) { ?>selected="selected" <?php } ?> class="Estilodany">Agosto</option>
                  <option value="9" <?php if ($mes == 9) { ?>selected="selected" <?php } ?> class="Estilodany">Setiembre</option>
                  <option value="10" <?php if ($mes == 10) { ?>selected="selected" <?php } ?> class="Estilodany">Octubre</option>
                  <option value="11" <?php if ($mes == 11) { ?>selected="selected" <?php } ?> class="Estilodany">Noviembre</option>
                  <option value="12" <?php if ($mes == 12) { ?>selected="selected" <?php } ?> class="Estilodany">Diciembre</option>
                </select>
                &nbsp;&nbsp;
                <input name="year" type="text" class="Estilodany" id="year" size="6" maxlength="4" onkeypress="return acceptNum(event)" value="<?php
                                                                                                                                                if ($year == "") {
                                                                                                                                                  echo $year_d;
                                                                                                                                                } else {
                                                                                                                                                  echo $year;
                                                                                                                                                }
                                                                                                                                                ?>" />
              </td>
              <td colspan="2" align="right"><input name="ckvencidos" type="checkbox" id="ckvencidos" value="1" <?php if ($ckvencidos == 1) { ?>checked="checked" <?php } ?> />
                <label for="ckvencidos" class="LETRA"> Mostrar solo el mes seleccionado </label>
              </td>

              <td width="320" align="right" colspan="2"><input name="val" type="hidden" id="val" value="1" />
                <input type="button" name="Submit2" value="Buscar" onclick="validar1()" class="buscar" />
                <input type="button" name="Submit222" value="Imprimir" onclick="printer()" class="imprimir" />
                <input type="button" name="Submit3" value="Salir" onclick="salir()" class="salir" /></td>
            </tr>
          </table>
          <div align="left"><img src="../../images/line2.png" width="100%" height="4" /></div>
          <table width="100%" border="0">

          </table>
        </form>
        <div align="left"><img src="../../images/line2.png" width="100%" height="4" /></div>
      </td>
    </tr>
  </table>
  <br>
  <?php if (($val == 1)) {
  ?>
    <iframe src="venci2.php?val=<?php echo $val ?>&mes=<?php echo $mes ?>&year=<?php echo $year ?>&ckvencidos=<?php echo $ckvencidos ?>&resumen=<?php echo $resumen ?>&local=<?php echo $local ?>&inicio=<?php echo $inicio ?>&registros=<?php echo $registros ?>&pagina=<?php echo $pagina ?>&tot_pag=<?php echo $total_paginas ?>" name="marco" id="marco" width="100%" height="430" scrolling="Automatic" frameborder="0" allowtransparency="0">
    </iframe>
  <?php }
  ?>
</body>

</html>
<script>
  $('#local').select2();
  $('#mes').select2();
</script>