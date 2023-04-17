<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../css/css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/css/tablas.css" rel="stylesheet" type="text/css" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo1 {color: #0B55C4}
-->
</style>
<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS?>
<?php require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS?>
<?php require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES?>
<?php require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES?>
<?php require_once("../../local.php");	//LOCAL DEL USUARIO
$sql="SELECT nomusu FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$user    = $row['nomusu'];
}
}
$codpro = $_REQUEST['codpro'];
?>
<script language="JavaScript">
function salir()
{
	 var f = document.form1;
	 f.method = "POST";
	 f.target = "_top";
	 f.action ="../../index.php";
	 f.submit();
}
</script>
<script type="text/javascript" language="JavaScript1.2" src="/comercial/funciones/control.js"></script>
</head>
<body>
<form id="form1" name="form1" method = "post">
 <table width="965" border="0" class="tabla2">
    <tr>
      <td>
	  <b><u>PROVEEDOR - LABORATORIOS </u></b>
        <table width="955" border="0">
          <tr>
            <td width="644">
              <div align="left">
                <input name="nn" type="hidden" id="nn" />
                <input type="button" name="Submit322" value="Salir" onclick="salir()" class="salir"/>
              </div>
	        </td>
            <td width="301">
			<div align="right"> <span class="blues Estilo1"><strong>LOCAL:</strong> <?php echo $nombre_local?></span></div>
			</td>
          </tr>
        </table>
        <table width="955" border="0">
          <tr>
            <td width="644"><div align="left"></div></td>
			<td width="301"><div align="right"><span class="blues Estilo1"><b>USUARIO:</b> <?php echo $user?></span></div></td>
          </tr>
        </table>
      </td>
    </tr>
</table>
<br />
<img src="../../../images/line2.jpg" width="950" height="4" />
<br />
  <table width="965" border="0">
    <tr>
      <td width="396"><table width="393" border="0" class="tabla2">
        <tr>
          <td width="385"><iframe src="proveedorlist.php?cp=<?php echo $codpro?>" name="marco1" id="marco1" width="380" height="480" scrolling="Automatic" frameborder="0" allowtransparency="0"> </iframe></td>
        </tr>
      </table></td>
      <td width="559"><table width="555" border="0" class="tabla2">
        <tr>
          <td width="547"><iframe src="laboratioriolist.php?cp=<?php echo $codpro?>" name="marco1" id="marco1" width="540" height="480" scrolling="Automatic" frameborder="0" allowtransparency="0"> </iframe></td>
        </tr>
      </table></td>
    </tr>
  </table>
  </form>
</body>
</html>
