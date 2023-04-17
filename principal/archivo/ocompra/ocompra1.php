<?php include('../../session_user.php');
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
  $rd = isset($_REQUEST['rd']) ? ($_REQUEST['rd']) : "2";
  $sql = "SELECT nomusu FROM usuario where usecod = '$usuario'";
  $result = mysqli_query($conexion, $sql);
  if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
      $user    = $row['nomusu'];
    }
  }
  ?>
  <style type="text/css">
    .todas {
      color: #2980b9;
      font-family: Georgia, 'Times New Roman', serif;
      font-size: 16px;
      font-weight: bold;
    }

    .borradas {
      color: #c0392b;
      font-family: Georgia, 'Times New Roman', serif;
      font-size: 16px;
      font-weight: bold;
    }

    .pendientes {
      color: #9b59b6;
      font-family: Georgia, 'Times New Roman', serif;
      font-size: 16px;
      font-weight: bold;
    }

    .atendidas {
      color: #27ae60;
      font-family: Georgia, 'Times New Roman', serif;
      font-size: 16px;
      font-weight: bold;

    }


    .Estilo4 {
      color: #0066CC;
      font-weight: bold;
      font-family: Georgia, 'Times New Roman', serif;
      /* font-size: 16px; */
    }

    .Estilo5 {
      color: #666666;
      font-weight: bold;
      font-family: Georgia, 'Times New Roman', serif;
      /* font-size: 16px; */

    }
  </style>
  <script>
    function validar() {
      var f = document.form1;
      var i;
      var c;
      for (i = 0; i < document.form1.rd.length; i++) {
        if (document.form1.rd[i].checked) {
          f.method = "post";
          f.action = "ocompra1.php";
          f.submit();
        }
      }
    }
  </script>
</head>

<body>
  <form name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)">
    <table width="100%" border="0" style="background-color: #d6d6d6;">
      <tr>
        <td width="100%">
          <table width="100%" border="0">
            <tr>
              <td width="13%" class="Estilo4"><u>ORDENES DE COMPRA</u></td>
              <td width="13%">
                <div align="center">
                  <input name="rd" id="todas" type="radio" value="4" <?php if ($rd == 4) { ?>checked="checked" <?php } ?>onclick="validar()" />
                  <span class="todas"><label for="todas">Todas</label></span>
                </div>
              </td>
              <td width="13%">
                <div align="center">
                  <input name="rd" id="borradas" type="radio" value="1" <?php if ($rd == 1) { ?>checked="checked" <?php } ?> onclick="validar()" />
                  <span class="borradas"><label for="borradas">Borradas</label></span>
                </div>
              </td>
              <td width="13%">
                <div align="center">
                  <input name="rd" id="pendeintes" type="radio" value="2" <?php if ($rd == 2) { ?>checked="checked" <?php } ?> onclick="validar()" />
                  <span class="pendientes"><label for="pendeintes"> Pendientes</label></span>
                </div>
              </td>
              <td width="13%">
                <div align="center">
                  <input name="rd" id="atendidas" type="radio" value="3" <?php if ($rd == 3) { ?>checked="checked" <?php } ?> onclick="validar()" />
                  <span class="atendidas"><label for="atendidas">Atendidas </label></span>
                </div>
              </td>
              <td width="15%">
                <div align="center"><span class="blues"><b>USUARIO:</b> <?php echo $user ?></span></div>
              </td>
              <td width="5%">
                <div align="right">
                  <input name="exit" type="button" id="exit" value="Salir" onclick="salir()" class="salir" />
                </div>
              </td>


            </tr>
          </table>

          <table width="961" border="0" align="center" class="tabla2" style="width: 99%;">
            <tr>
              <td>
                <iframe src="ocompra2.php?rd=<?php echo $rd ?>" name="ocompra2" width="100%" height="240" scrolling="Automatic" frameborder="0" id="ocompra2" allowtransparency="0">
                </iframe>
              </td>
            </tr>
          </table>
          <BR>
          <!-- <img src="../../../images/line2.png" width="950" height="4" /><br /> -->
          <?php $invnum = $_REQUEST['invnum'];
          ?>
          <table width="961" border="0" align="center" class="tabla2" style="width: 99%;">
            <tr>
              <td>
                <iframe src="ocompra3.php?invnum=<?php echo $invnum ?>" name="ocompra3" width="100%" height="195" scrolling="Automatic" frameborder="0" id="ocompra3" allowtransparency="0"> </iframe>
              </td>
            </tr>
          </table>
          <!-- <br> -->
          <!-- <img src="../../../images/line2.png" width="100%" height="4" /><br /> -->
          <br>
          <table width="100%" border="0" align="center" class="tabla2" style="width: 99%;">
            <tr>
              <td>
                <table width="100%" border="0" align="center">
                  <tr>
                    <td width="100%">
                      <div align="right">
                        <input name="printer" type="button" id="printer" value="Imprimir" class="imprimir" onclick="imprimir()" />
                        <input name="nuevo" type="button" id="nuevo" value="Nuevo" class="nuevo" onclick="news()" />
                        <input name="modif" type="button" id="modif" value="Modificar" class="modificar" disabled="disabled" />
                        <input name="exit2" type="button" id="exit2" value="Salir" onclick="salir()" class="salir" />
                      </div>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </form>
</body>

</html>