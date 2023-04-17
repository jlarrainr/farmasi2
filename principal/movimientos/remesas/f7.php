<?php include('../../session_user.php');
$remesa   	  = $_SESSION['remesa'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>GASTOS VARIOS</title>
<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
require_once("../../local.php");	//LOCAL DEL USUARIO
?>
<script>
var nav4 = window.Event ? true : false;
function moneda(evt){
// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
var key = nav4 ? evt.which : evt.keyCode;
//alert(key);
return (key <= 13 || key == 100 || key == 115);
}
function ventana(e) {
tecla=e.keyCode;
  if (tecla == 27)
  {
    //window.close();
	document.form1.target = "principal";
	window.opener.location.href="salir.php";
	self.close();
  }
  if (tecla == 45)
  {
  var f = document.form1;
  document.form1.val.value = 1;
  f.method = "post";
  f.submit();
  }
  if (tecla == 13)
  {
      var f = document.form1;
      document.form1.val.value = "";
	  if ((document.form1.m.value == "") || (document.form1.monto.value == ""))
	  {
	  }
	  else
	  {
	  f.action = "f7_1.php";
	  f.method = "post";
	  f.submit();
	  }
  }
}
function sf()
{
document.form1.ingreso.focus();
}
</script>
<style type="text/css">
<!--
.Estilo1 {color: #990000}
-->
</style>
</head>
<?php $val = $_REQUEST['val'];
?>
<body onkeyup="ventana(event)" <?php if (($val == 1) || ($val == 2)){?> onload="sf();"<?php }?>>
<table width="688" border="0" align="center" class="tabla2">
  <tr>
    <td width="680"><table width="406" border="0" align="center">
      <tr>
        <td width="400"><div align="center"><strong>GASTOS VARIOS</strong></div></td>
      </tr>
    </table>
      <div align="center"><img src="../../../images/line2.png" width="660" height="4" /></div>
      <table width="672" border="0" align="center">
        <tr>
          <td width="54"><span class="text_combo_select"><strong>NUMERO</strong></span></td>
          <td width="179"><span class="text_combo_select"><strong>GASTO</strong></span></td>
          <td width="230"><span class="text_combo_select"><strong>REFERENCIA</strong></span></td>
          <td width="45"><span class="text_combo_select"><strong><div align="center">M</div></strong></span></td>
          <td width="60"><span class="text_combo_select"><strong><div align="right">MONTO</div></strong></span></td>
          <td width="78"><span class="text_combo_select"><strong><div align="center">ESTADO</div></strong></span></td>
        </tr>
      </table>
      <div align="center"><img src="../../../images/line2.png" width="660" height="4" /></div>
      <form name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)">
	  <?php if (($val == 1) || ($val == 2))
	  {
		  $codtips = $_REQUEST['cod'];
		  $sql1="SELECT codtab,refere,moneda,monto,estado FROM gasres where codtab = '$codtips' and tiptab = 'G'";
		  $result1 = mysqli_query($conexion,$sql1);
		  if (mysqli_num_rows($result1)){
		  while ($row1 = mysqli_fetch_array($result1)){ 
			$c1 = $row1["codtab"];
			$c2 = $row1["refere"];
			$c3 = $row1["moneda"];
			$c4 = $row1["monto"];
			$c5 = $row1["estado"];
		  }
		  }
	  ?>
	  <table width="672" border="0" align="center" bgcolor="#FFFF66">
        <tr>
          <td width="54" valign="top"><?php echo $c1;?></td>
          <td width="179" valign="top">
            <?php if ($val == 1)
			{
			?>
			<select name="ingreso" id="ingreso">
            <?php 
			$sql = "SELECT codtab,destab FROM titultabladet where tiptab = 'GAST' order by destab"; 
			$result = mysqli_query($conexion,$sql); 
			while ($row = mysqli_fetch_array($result)){ 
			$codtabs = $row["codtab"] ;
				$sql1="SELECT codtab FROM gasres where codtab = '$codtabs' and invnum = '$remesa'";
				$result1 = mysqli_query($conexion,$sql1);
				if (mysqli_num_rows($result1)){
					$yes =1;
				}
				else
				{
				$yes = 0;
				}
				if ($yes == 0)
				{
			?>
              <option value="<?php echo $row["codtab"] ?>" ><?php echo strtoupper($row["destab"]) ?></option>
			  <?php }
			  ?>
              <?php } ?>
            </select>
			<?php }
			if ($val == 2)
			{
			?>
			<select name="ingreso" id="ingreso">
            <?php 
			$sql = "SELECT codtab,destab FROM titultabladet where tiptab = 'GAST' order by destab"; 
			$result = mysqli_query($conexion,$sql); 
			while ($row = mysqli_fetch_array($result)){ 
			$codtabs = $row["codtab"] ;
			?>
              <option value="<?php echo $row["codtab"] ?>" <?php if ($c1 == $codtabs){?>selected="selected"<?php }?>><?php echo strtoupper($row["destab"]) ?></option>
            <?php } ?>
            </select>
			<?php }
			?>
          </td>
          <td width="230" valign="top">
            <textarea name="referencia" cols="40" rows="2" id="referencia" onKeyUp="this.value = this.value.toUpperCase();"><?php echo $c2;?></textarea>
          </td>
          <td width="45" valign="top">
		  <div align="center">
            <input name="t" type="hidden" id="t" value="<?php echo $val;?>" />
            <input name="codt" type="hidden" id="codt" value="<?php echo $c1;?>" />
            <input name="m" type="text" id="m" size="4" maxlength="1" onKeyUp="this.value = this.value.toUpperCase();" onkeypress="return moneda(event);" value="<?php echo $c3;?>"/>
          </div>
		  </td>
          <td width="60" valign="top">
		  <div align="right">
            <input name="monto" type="text" id="monto" size="6" onkeypress="return decimal(event);" value="<?php echo $c4;?>"/>
          </div>
		  </td>
          <td width="78" valign="top">
		  <div align="center">
            <input name="state" type="text" id="state" size="6" maxlength="1" onKeyUp="this.value = this.value.toUpperCase();" value="<?php echo $c5;?>"/>
          </div>
		  </td>
        </tr>
      </table>
	  <?php }
	  ?>
	  <table width="672" border="0" align="center">
        <?php $sql="SELECT codtab,refere,moneda,monto,estado FROM gasres where invnum = '$remesa' and tiptab = 'G'";
		$result = mysqli_query($conexion,$sql);
		if (mysqli_num_rows($result)){
		while ($row = mysqli_fetch_array($result)){
			$codtip     = $row['codtab'];
			$referencia = $row['refere'];
			$moneda     = $row['moneda'];
			$estado 	= $row['estado'];
			$monto     	= $row['monto'];
			$sql1="SELECT destab FROM titultabladet where codtab = '$codtip'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
			    $destab     	= $row1['destab'];
			}
			}
		?>
		 <tr onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
          <td width="54"><?php echo $codtip?></td>
          <td width="179"><?php echo $destab?></td>
          <td width="230"><?php echo $referencia?></td>
          <td width="45"><div align="center"><?php echo $moneda?></div></td>
          <td width="60"><div align="right"><?php echo $monto?></div></td>
          <td width="28"><div align="right"><?php echo $estado?></div></td>
		  <td width="19"><div align="center">
		  <a href="f7.php?cod=<?php echo $codtip?>&val=2">
		  <img src="../../../images/edit_16.png" width="16" height="16" border="0"/>
		  </a></div>
		  </td>
		  <td width="23"><div align="center">
		  <a href="f7_del.php?cod=<?php echo $codtip?>">
		  <img src="../../../images/del_16.png" width="16" height="16" border="0"/></a></div>
		  </td>
        </tr>
		<?php }
		}
		?>
      </table>
	  <input name="val" type="hidden" id="val" />
      </form>
    </td>
  </tr>
</table>
<table width="688" border="0" align="center" class="tabla2">
  <tr>
    <td width="680"><table width="672" border="0" align="center">
      <tr>
        <td width="520"><div align="right" class="Estilo1"><?php if ($val == 1){?> PRESIONAR ENTER PARA GRABAR<?php }?></div></td>
        <td width="142"><div align="right" class="Estilo1">INS = AGREGAR </div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>