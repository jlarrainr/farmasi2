<?php include('../../../session_user.php');
$invnum  = $_SESSION['compras'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <link href="../../../../css/style.css" rel="stylesheet" type="text/css" />
  <link href="autocomplete.css" rel="stylesheet" type="text/css" />
  <?php require_once('../../../../conexion.php');  //CONEXION A BASE DE DATOS
  require_once("../../../../funciones/functions.php");  //DESHABILITA TECLAS
  require_once("../../../../funciones/botones.php");  //COLORES DE LOS BOTONES
  $cod              = $_REQUEST['cod'];
  $codtempfiltro    = $_REQUEST['codtempfiltro'];
  $close    = $_REQUEST['close'];
  $sql = "SELECT desprod,codmar,factor FROM producto where codpro = '$cod'";
  $result = mysqli_query($conexion, $sql);
  if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
      $desprod        = $row['desprod'];
      $codmar         = $row['codmar'];
      $factor         = $row['factor'];
      $sql1 = "SELECT destab FROM titultabladet where tiptab = 'M' and codtab = '$codmar'";
      $result1 = mysqli_query($conexion, $sql1);
      if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
          $marca        = $row1['destab'];
        }
      }
    }
  }
  $sql1 = "SELECT numerolote,vencim FROM templote where invnum = '$invnum' and codpro = '$cod' and codtemp ='$codtempfiltro'";
  $result1 = mysqli_query($conexion, $sql1);
  if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
      $numlote        = $row1['numerolote'];
      $vencimi        = $row1['vencim'];
      //list($m,$ycar) = split( '[/.-]',$vencimi);

      $fechavencimiento = explode("/", $vencimi);
      $m = $fechavencimiento[0]; // PARA ARREGLAR PROBLEMAS EN ACTUALIZAR FECHA EN COMPRAS
      $ycar = $fechavencimiento[1]; // 
    }
    $sql2 = "SELECT numlote,vencim FROM movlote where numlote = '$numlote'";
    $result2 = mysqli_query($conexion, $sql2);
    if (mysqli_num_rows($result2)) {
      $search = 0;
    } else {
      $search = 1;
    }
  } else {
    $search = 1;
  }
  ?>
  <script type="text/javascript" src="../../../../funciones/ajax.js"></script>
  <script type="text/javascript" src="../../../../funciones/ajax-dynamic-list.js"></script>
  <script>
    function sf() {
      document.form1.country.focus();
    }

    function verifica() {
      var f = document.form1;
      if (f.country.value == "") {
        alert("Ingrese el Numero de Lote");
        f.country.focus();
        return;
      }
      f.method = "post";
      f.action = "verifica.php";
      f.submit();
    }

    function grabar() {
      var f = document.form1;
      if (f.country.value == "") {
        alert("Ingrese el Numero de Lote");
        f.country.focus();
        return;
      }
      if (f.years.value == "") {
        alert("Ingrese el A�o");
        f.years.focus();
        return;
      }
      var cadena = f.years.value;
      var cadena_mes = f.mes.value;
      var longitud = cadena.length;
      if (f.mes.value > 12) {
        alert("Ingrese un Mes valido");
        f.mes.focus();
        return;
      }
      if (longitud < 3) {
        alert("Ingrese un A�o valido");
        f.years.focus();
        return;
      }
      var fecha = new Date();
      var ano = fecha.getFullYear();
      var mess = fecha.getMonth() + 1;
      cadena = parseInt(cadena);
      cadena_mes = parseInt(cadena_mes);
      ano = parseInt(ano);
      mess = parseInt(mess);
      if (ano > cadena) {
        alert("Ingrese un A�o posterior al A�o Actual");
        f.years.focus();
        return;
      } else {
        if (ano == cadena) {
          if (mess > cadena_mes) {
            alert("Ingrese un Mes posterior o igual al Mes Actual");
            f.mes.focus();
            return;
          }
        }
      }
      f.method = "post";
      f.action = "lote_reg.php";
      f.submit();
    }

    function cerrar(e) {
      tecla = e.keyCode
      if (tecla == 27) {
        window.close();
      }
    }

    function cerrar_popup() {
      // document.form1.target = "venta_principal";
      // // window.opener.location.href = "salir1.php";
      self.close();
    }
  </script>
  <title><?php echo $desprod ?></title>
  <link href="../../css/tablas.css" rel="stylesheet" type="text/css" />
  <style type="text/css">
    .Estilo1 {
      color: #FFFFFF
    }

    .Estilo2 {
      color: #FF0000
    }

    .LETRA {
      font-family: Tahoma;
      font-size: 11px;
      line-height: normal;
      color: #5f5e5e;
      font-weight: bold;
    }

    input {
      box-sizing: border-box;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 12px;
      background-color: white;
      background-position: 3px 3px;
      background-repeat: no-repeat;
      padding: 2px 1px 2px 5px;

    }

    .LETRA2 {
      background: #d7d7d7
    }

    body {
      background: #f6f1f1;
    }
  </style>
</head>
<?php echo $close ?>

<body <?php if ($close == 1) { ?> onload="cerrar_popup();" <?php } else { ?> onload="sf();" <?php } ?> onkeyup="cerrar(event)">
  <table width="548" border="0" bgcolor="#FFFF99" class="tabla2">

    <tr>
      <td width="540">
        <table width="521" border="0" align="center" bgcolor="#FFFF99">
          <tr>
            <td width="73" class="LETRA">DESCRIPCION</td>
            <td width="438"><?php echo $desprod ?></td>
          </tr>
          <tr>
            <td class="LETRA">MARCA</td>
            <td><?php echo $marca ?></td>
          </tr>
          <tr>
            <td class="LETRA">FACTOR</td>
            <td><?php echo $factor ?></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <form id="form1" name="form1" method="post" action="verifica.php">


    <table class="tabla2" width="548" border="0">
      <tr>
        <td width="540">
          <table width="521" border="0" align="center">

          </table>
          <img src="../../../../images/line2.png" width="540" height="4" />

          <fieldset style="width:521px;">
            <legend> <strong>REGISTRO DE LOTE DE PRODUCTO</strong></legend>
            <table width="521" border="0" align="center" bgcolor="#f6f1f1">
              <tr>
                <td width="96" class="LETRA">NUMERO DE LOTE </td>
                <td width="415">

                  <!--<input name="country" type="text" id="country" onkeyup="ajax_showOptions(this,'getCountriesByLetters',event)" size="50" value="<?php echo $numlote ?>" onclick="limpia();"/>-->
                  <input name="country" type="text" id="country" onkeypress="this.value = this.value.toUpperCase();" size="50" value="<?php echo $numlote ?>" onclick="limpia();" />
                  <input name="codpro" type="hidden" id="codpro" value="<?php echo $cod ?>" />
                  <input type="hidden" id="country_hidden" name="country_ID" value="" />
                  <input type="hidden" id="codtempfiltro" name="codtempfiltro" value="<?php echo $codtempfiltro ?>" />
                  <!--<input name="save2" type="button" id="save2" value="Verificar" onclick="verifica()" class="grabar"/>-->
                </td>
              </tr>
              <tr>
                <td class="LETRA">VENCIMIENTO</td>
                <td><label>
                    <input name="mes" type="text" id="mes" size="4" maxlength="2" value="<?php echo $m ?>" />
                  </label>
                  /
                  <input name="years" type="text" id="years" size="10" maxlength="4" value="<?php echo $ycar ?>" />

                </td>
              </tr>
              <tr>
                <td align="center" colspan="2">
                  <input name="save" type="button" id="save" value="Actualizar" onclick="grabar()" class="grabar" <?php if ($search == 0) { ?> disabled="disabled" <?php } ?> />
                </td>
              </tr>
            </table>
          </fieldset>

        </td>
      </tr>
    </table>
  </form>
</body>

</html>