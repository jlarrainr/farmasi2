<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<script type="text/javascript" language="JavaScript1.2" src="menu/stmenu.js"></script>
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/select_pro.css" rel="stylesheet" type="text/css" />
<link href="./css/tablas.css" rel="stylesheet" type="text/css" />
<?php require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
?>
<script>
function salir()
{
	 var f = document.form1;
	 f.target ="_top";
	 f.action ="../../index.php";
	 f.submit();
}
</script>
</head>
<?php $local 	 	 = $_REQUEST['local'];
$tip		 = $_REQUEST['tip'];
$tipdocu	 = $_REQUEST['tipdocu'];
$val	 	 = $_REQUEST['val'];

$sql="SELECT nlicencia FROM datagen ";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	   $nlicencia       = $row['nlicencia'];
}
}

?>
<body onload="sf();">
<div class="mask1">
  <div class="mask2">
    <div class="mask3">
      <table width="100%" border="0">
        <tr>
          <td width="766"><span class="text_combo_select"><strong>FORMATEADOR DE DOCUMENTOS </strong></span><img src="../../../images/line2.jpg" width="760" height="4" /></td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr>
          <td width="760"><form id="form1" name="form1" method = "post" action="" onkeyup="highlight(event)" onclick="highlight(event)">
            <table width="100%" border="0" align="center">
              <tr>
                <td>LOCAL</td>
                <td><div id="demoMed">
                  <select name="local" class="Estilodany" id="local">
                    <?php 
					$sql = "SELECT codloc,nomloc,nombre FROM xcompa order by codloc ASC LIMIT $nlicencia"; 
					$result = mysqli_query($conexion,$sql); 
					while ($row = mysqli_fetch_array($result)){ 
					?>
                    <option value="<?php echo $row["codloc"] ?>" <?php if ($local == $row["codloc"]){?>selected="selected"<?php }?>>
					<?php if ($row["nombre"] <> ''){ echo strtoupper($row["nombre"]); } else{echo strtoupper($row["nomloc"]);} ?></option>
                    <?php } ?>
                  </select>
                </div></td>
                <td><div align="right"></div></td>
              </tr>
              <tr>
                <td>TIPO CONTENIDO </td>
                <td><div id="demoMed">
                  <select name="tip" id="tip">
                    <option value="1" <?php if ($tip == 1){?>selected="selected"<?php }?>>PIE DE PAGINA Y CABECERA</option>
                    <option value="2" <?php if ($tip == 2){?>selected="selected"<?php }?>>CONTENIDO DEL DOCUMENTO</option>
                  </select>
                </div></td>
                <td><div align="right"></div></td>
              </tr>
              <tr>
                <td width="106">TIPO DOCUMENTO</td>
                <td width="484"><div id="demoMed">
                  <label>
                    <select name="tipdocu" id="tipdocu">
                      <option value="2" <?php if ($tipdocu == 2){?>selected="selected"<?php }?>>BOLETA</option>
                      <option value="1" <?php if ($tipdocu == 1){?>selected="selected"<?php }?>>FACTURA</option>
					  <option value="3" <?php if ($tipdocu == 3){?>selected="selected"<?php }?>>GUIA</option>
					  <option value="4" <?php if ($tipdocu == 4){?>selected="selected"<?php }?>>TICKET</option>
                    </select>
                    </label>
                </div></td>
                <td width="138"><div align="right">
                  <input name="val" type="hidden" id="val" value="1" />
                  <input type="submit" name="Submit" value="Mostrar" class="grabar"/>
                  <input type="button" name="exit" value="Salir" onclick="salir()" class="salir"/>
                </div></td>
              </tr>
            </table>
          </form></td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr>
          <td width="766"><img src="../../../images/line2.jpg" width="100%" height="4" /></td>
        </tr>
      </table>
      <iframe src="local2.php?val=<?php echo $val?>&local=<?php echo $local?>&tip=<?php echo $tip?>&tipdocu=<?php echo $tipdocu?>" name="main" width="100%" height="460" scrolling="Automatic" frameborder="No" id="main" allowtransparency="True"></iframe>
    </div>
  </div>
</div>
</body>
</html>
