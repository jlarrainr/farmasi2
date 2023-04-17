<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

  <title>Documento sin t&iacute;tulo</title>
  <link href="../css2/css/style.css" rel="stylesheet" type="text/css" />
  <link href="../css2/css/tablas.css" rel="stylesheet" type="text/css" />
  <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
  <link href="../../select2/css/select2.min.css" rel="stylesheet" />
  <script src="../../select2/jquery-3.4.1.js"></script>
  <script src="../../select2/js/select2.min.js"></script>
  <link href="../../../funciones/alertify/alertify.min.css" rel="stylesheet" />
  <script src="../../../funciones/alertify/alertify.min.js"></script>
  <?php require_once('../../../conexion.php');  //CONEXION A BASE DE DATOS
  ?>
  <?php //require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
  ?>
  <?php require_once("../../../funciones/funct_principal.php");  //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
  ?>
  <?php require_once("../../../funciones/botones.php");  //COLORES DE LOS BOTONES
  ?>
  <?php
  require_once("../../local.php");  //LOCAL DEL USUARIO
  require_once("ajax_digemid.php");  //LOCAL DEL USUARIO

  $sql = "SELECT nomusu FROM usuario where usecod = '$usuario'";
  $result = mysqli_query($conexion, $sql);
  if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
      $user    = $row['nomusu'];
    }
  }
  $val1    = isset($_REQUEST['val1']) ? ($_REQUEST['val1']) : "";
  $val2    = isset($_REQUEST['val2']) ? ($_REQUEST['val2']) : "";
  $val3    = isset($_REQUEST['val3']) ? ($_REQUEST['val3']) : "";
  $produc  = isset($_REQUEST['country']) ? ($_REQUEST['country']) : "";
  //$local   = isset($_REQUEST['local']) ? ($_REQUEST['local']) : "";
  $marca   = isset($_REQUEST['marca']) ? ($_REQUEST['marca']) : "";
  $ckdigemid   = isset($_REQUEST['ckdigemid']) ? ($_REQUEST['ckdigemid']) : "";
  if ($val1 == 1) {

    //    selecionar nombre y digemid
    $sql = "SELECT desprod,digemid FROM producto where stopro>0 and desprod like '$produc%' and eliminado='0'  ";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
      while ($row = mysqli_fetch_array($result)) {
        $desprod    = $row['desprod'];
        $digemid   = $row['digemid'];
      }
    }
    $val = $val1;
    $search = $produc;
  }
  if ($val2 == 2) {
    $sql = "SELECT destab FROM titultabladet where codtab = '$marca1'  ";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
      while ($row = mysqli_fetch_array($result)) {
        $destab    = $row['destab'];
      }
    }
    $val = $val2;
    $search = $marca;
  }
  if ($val3 == 3) {
    $val = $val3;
  }

  $sql1 = "SELECT CodEstab FROM datagen";
  $result1 = mysqli_query($conexion, $sql1);
  if (mysqli_num_rows($result1)) {
    while ($row = mysqli_fetch_array($result1)) {
      $CodEstab    = $row['CodEstab'];
    }
  }

  $CodEstab = ($CodEstab <> 0) ? $CodEstab : '';
  ?>
  <script type="text/javascript" language="JavaScript1.2" src="/comercial/funciones/control.js"></script>
  <script>
    function salir() {
      var f = document.form1;
      f.method = "POST";
      f.target = "_top";
      f.action = "../../index.php";
      f.submit();
    }

    function buscar() {
      var f = document.form1;
      if (f.country.value == "") {
        alert("Ingrese el Producto para iniciar la Busqueda");
        f.country.focus();
        return;
      }
      f.val3.value = 0;
      f.val2.value = 0;
      f.submit();
    }

    function TODOS() {
      var f = document.form1;
      //  f.val1.value=0;
      //  f.buscar.value=0;
      f.submit();
    }



    function lp1() {
      var f = document.form1;
      f.val1.value = 0;
      f.val3.value = 0;
      f.submit();
    }

    function lp2() {
      var f = document.form1;
      f.val1.value = 0;
      f.val2.value = 0;
      f.submit();
    }

    function sf() {
      document.form1.country.focus();
    }

    function sf2() {
      document.form1.CodEstab.focus();
    }
    var nav4 = window.Event ? true : false;

    function covid() {

      var f = document.form1;
      f.method = "post";
      f.action = "digemid1.php";
      f.ckdigemid3.value = 1;
      f.val1.value = 0;
      f.val2.value = 0;
      f.val3.value = 0;


      f.submit();
    }

    function ent(evt) {
      var key = nav4 ? evt.which : evt.keyCode;
      if (key == 13) {
        var f = document.form1;
        if (f.country.value == "") {
          alert("Ingrese el Producto para iniciar la Busqueda");
          f.country.focus();
          return;
        }
        f.val3.value = 0;
        f.val2.value = 0;
        f.submit();
      }
    }
  </script>
  <script>
    function popUpWindow(URLStr, left, top, width, height) {
      if (popUpWin) {
        if (!popUpWin.closed) popUpWin.close();
      }
      popUpWin = open('exdigimed.php', 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width=355,height=150,left=100,top=10,screenX=' + left + ',screenY=' + top + '');
    }
  </script>
</head>

<body <?php if ($ckdigemid == 1) {   ?>onload="sf2();" <?php } else { ?> onload="sf();" <?php } ?>>
  <table width="100%" border="0">
    <tr>
      <td width="100%"><b><u>DIGEMID: </u></b>: Se mostraran los Productos para ingresar el codigo de digemid... </td>

    </tr>
  </table>
  <table width="100%" border="0">
    <tr>
      <td width="944">
        <form id="form1" name="form1">

          <!--	  <table width="943" border="0">
           
            <tr>
               
                <td width="150">
                    <div align="right">
                      <input name="excel" type="button"  value="GENERA ARCHIVO EXCEL" onclick="popUpWindow()" class="buscar"/>
                      <input name="excel" type="button"  value="GENERA ARCHIVO EXCEL" onclick="location.href='exdigimed2.php'" class="buscar"/>
                      <input name="excel" type="button"  value="GENERA ARCHIVO EXCEL" onclick="location.href='exdigimed2.php'" class="buscar"/>
                    </div>
               </td>
               
            </tr>
              
         </table>-->

          <table width="100%" border="0">

            <tr>
              <td width="5%" class="LETRA">PRODUCTO</td>
              <td width="25%">
                <input name="country" type="text" id="country" size="40" value="<?php echo $produc ?>" onkeypress="return ent(event);" onKeyUp="this.value = this.value.toUpperCase();" />
              </td>
              <td width="15%">

                <input name="CodEstab" type="text" id="CodEstab" size="8" value="<?php echo $CodEstab ?>" <?php if ($ckdigemid <> 1) { ?> disabled="disabled" <?php } ?> onkeyup="cargarContenido()" /> <b>COD. ESTABLECIMIENTO</b>
              </td>
              <td width="15%">
                <div align="right">
                  <!--<input name="excel" type="button"  value="GENERA ARCHIVO EXCEL" onclick="popUpWindow()" class="buscar"/>-->
                  <!--<input name="excel" type="button"  value="GENERA ARCHIVO EXCEL" onclick="location.href='exdigimed2.php'" class="buscar"/>-->
                  <input tabindex="1" name="ckdigemid3" type="hidden" id="ckdigemid3" value="1" />
                  <input name="excel" type="button" title="Solo se se mostraran los producto que tengas C.DIGEMID Y STOCK > 0" value="GENERA ARCHIVO EXCEL" onclick="location.href='exdigimed2.php?ckdigemid3=<?php echo $ckdigemid; ?>'" class="imprimir" />
                </div>
              </td>
              <td width="15%">
                <div align="right">
                  <input tabindex="1" name="val1" type="hidden" id="val1" value="1" />
                  <input type="hidden" id="country_hidden" name="country_ID" value="<?php echo $codpro ?>" />
                  <input name="search" type="button" id="search" value="Buscar" onclick="buscar()" class="buscar" />
                  <input name="exit" type="button" id="exit" value="Salir" onclick="salir()" class="salir" />
                </div>
              </td>
            </tr>
            <tr>
              <td class="LETRA">MARCA</td>
              <td>
                <select name="marca" id="marca">
                  <?php
                  $sql = "SELECT codtab,destab FROM titultabladet where tiptab = 'M'  ORDER BY destab";
                  $result = mysqli_query($conexion, $sql);
                  while ($row = mysqli_fetch_array($result)) {
                  ?>
                    <option value="<?php echo $row["codtab"] ?>" <?php if ($marca == $row["codtab"]) { ?>selected="selected" <?php } ?>><?php echo $row["destab"] ?></option>
                  <?php } ?>
                </select>
              </td>
              <td>
                <input name="ckdigemid" type="checkbox" id="ckdigemid" value="1" onclick="covid();" <?php if ($ckdigemid == 1) { ?>checked="checked" <?php } ?> />
                <label for="ckdigemid" class="LETRA"> Productos COVID-19 </label>
              </td>
              <td>
                <div align="right">
                  <input name="val3" type="hidden" id="val3" value="3" />
                  <input name="search" type="button" id="search" value="TODOS LOS PRODUCTOS" onclick="TODOS()" class="imprimir" />
                </div>
              </td>
              <td>
                <div align="right">
                  <input name="val2" type="hidden" id="val2" value="2" />
                  <input name="search222" type="submit" id="search222" value="Buscar" class="buscar" onclick="lp1()" />
                  <input name="exit222" type="button" id="exit222" value="Salir" onclick="salir()" class="salir" />
                </div>
              </td>
            </tr>
          </table>







          <!--	  <div align="center"><img src="../../../images/line2.png" width="920" height="4" /> </div>-->


        </form>
        <table width="100%" border="0">
          <tr>
            <td><?php /*if ($val == 1){?>MARCA BUSCADA POR: <b><u><?php echo $marca;?></u></b><?php }*/ ?></td>
            <td width="189">
              <div align="right"></div>
            </td>
          </tr>
        </table>
        <div align="center"><img src="../../../images/line2.png" width="100%" height="4" /></div>
      </td>
    </tr>
  </table>
  <iframe src="digemid2.php?search=<?php echo $search ?>&val=<?php echo $val ?>&ckdigemid=<?php echo $ckdigemid ?>" name="marco" id="marco" width="100%" height="450" scrolling="Automatic" frameborder="0" allowtransparency="0">
  </iframe>
</body>

</html>
<script>
  $('#marca').select2();
</script>