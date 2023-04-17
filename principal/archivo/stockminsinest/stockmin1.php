<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="css/style1.css" rel="stylesheet" type="text/css" />
<link href="../../../css/autocomplete.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="JavaScript1.2" src="/comercial/funciones/control.js"></script>
<link href="css/tabla2.css" rel="stylesheet" type="text/css" />
<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
//require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUME
require_once("../../local.php");	//LOCAL DEL USUARIO
require_once("funciones/minimo.php");
?>
<script type="text/javascript" src="../../../funciones/ajax.js"></script>
<script type="text/javascript" src="../../../funciones/ajax-dynamic-list.js"></script>
<?php $sql="SELECT nomusu FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$user    = $row['nomusu'];
}
}
$val    = $_REQUEST['val'];
$marca  = $_REQUEST['country_ID'];
$codpro = $_REQUEST['codpro'];
$cr     = $_REQUEST['cr'];
?>
</head>
<body <?php if (($val==0)&&($marca=="")){?>onload="sf()"<?php }?>>
<form name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)">
  <table width="950" border="0">
    <tr>
      <td width="944"><table width="943" border="0">
          <tr>
            <td width="58">MARCA</td>
            <td>
			<input name="country" type="text" id="country" onkeyup="ajax_showOptions(this,'getCountriesByLetters',event)" size="100" onclick="this.value=''"/>
			<input name="val" type="hidden" id="val" value="1"/>
			<input type="hidden" id="country_hidden" name="country_ID" />
			<input name="search" type="button" id="search" value="Buscar" onclick="buscar()" class="buscar"/>
			<input name="exit" type="button" id="exit" value="Salir"  onclick="salir()" class="salir"/></td>
            <td width="189"><div align="right"><span class="blues"><strong>LOCAL:</strong> <?php echo $nombre_local?></span></div></td>
          </tr>
        </table>
          
          <table width="943" border="0">
            <tr>
              <td><?php /*if ($val == 1){?>MARCA BUSCADA POR: <b><u><?php echo $marca;?></u></b><?php }*/?></td>
              <td width="189">
			  <div align="right"><span class="blues"><b>USUARIO:</b> <?php echo $user?></span></div>			  </td>
            </tr>
        </table>
          <div align="center"><img src="../../../images/line2.png" width="935" height="4" /></div>
      </td>
    </tr>
  </table>
  <table width="953" border="0" class="tabla2">
    <tr>
      <td width="954"><iframe src="stockmin2.php?val=<?php echo $val?>&marca=<?php echo $marca?>&codpro=<?php echo $codpro?>&cr=<?php echo $cr?>" name="iFrame1" width="944" height="525" scrolling="Automatic" frameborder="0" id="iFrame1" allowtransparency="0"> </iframe></td>
    </tr>
  </table>
</form>
</body>
</html>
