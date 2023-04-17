<?php 
include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="css/style1.css" rel="stylesheet" type="text/css" />
<link href="css/tabla2.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="JavaScript1.2" src="/comercial/funciones/control.js"></script>
<?php 
require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUME
require_once("../../local.php");	//LOCAL DEL USUARIO
//require_once("call_combo.php");
$sql="SELECT nomusu FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$user    = $row['nomusu'];
}
}

$sql="SELECT nlicencia FROM datagen ";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	   $nlicencia       = $row['nlicencia'];
}
}
?>
<style type="text/css">
<!--
.Estilo1 {color: #FF0000}
.Estilo2 {color: #0066CC}
.Estilo3 {color: #009900}
.Estilo4 {color: #0066CC; font-weight: bold; }
.Estilo5 {	color: #666666;
	font-weight: bold;
}
-->
</style>
<script>
function sf(){
document.form1.factor.focus();
}
function salir()
{
	 var f = document.form1;
	 f.method = "POST";
	 f.target = "_top";
	 f.action ="../../index.php";
	 f.submit();
}
function validar(){
  var f = document.form1;
  if (f.factor.value == "")
  { alert("Ingrese el Factor de Reposicion"); f.factor.focus(); return; }
  if (f.local.value == 0)
  { alert("Seleccione un Local"); f.local.focus(); return; }
  f.method = "post";
  f.action ="reposicion_min2.php";
  f.submit();
}
</script>
</head>
<body onload="sf();">
<form name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)">
  <table width="568" border="0">
    <tr>
      <td width="562"><table width="552" border="0">
        <tr>
          <td width="177">FACTOR DE REPOSICION EN DIAS</td>
          <td width="365">
            <input name="factor" type="text" id="factor" maxlength="2" onkeypress="return acceptNum(event)"/>
            <input type="button" name="Submit" value="Actualizar" class="grabar" onclick="validar()"/>
            <input name="exit" type="button" id="exit" value="Salir" onclick="salir()" class="salir"/>		  </td>
        </tr>
        <tr>
          <td>LOCAL</td>
          <td>
                <?php 
                $usuario = $_SESSION['codigo_user'];
                $sql1="SELECT * FROM usuario where usecod = '$usuario'";
                $result1 = mysqli_query($conexion,$sql1);
                if (mysqli_num_rows($result1))
                {
                    while ($row1 = mysqli_fetch_array($result1))
                    {
                        $codloc  = $row1['codloc'];
                    }
                }
                $sql="SELECT codloc, nomloc, nombre FROM xcompa where habil = '1' and codloc <> '$codloc' order by codloc ASC LIMIT $nlicencia  ";
                $result = mysqli_query($conexion,$sql); 
                // Voy imprimiendo el primer select compuesto por los paises
                echo "<select name='local' id='local' onChange='cargaContenido(this.id)'>";
                echo "<option value='0'>Seleccione un Local</option>";
                while($row=mysqli_fetch_array($result))
                {
                        ?>
                        <option value="<?php echo $row[0]?>"><?php if ($row[2]<>''){echo $row[2];} else{echo $row[1];}?></option>
                        <?php
                }
                echo "</select>";
                ?>
          </td>
        </tr>
        <tr>
          <td>MARCA DE</td>
          <td><select name="marca" id="marca">
              <?php 
				$sql = "SELECT codtab,destab FROM titultabladet where tiptab = 'M' order by destab"; 
				$result = mysqli_query($conexion,$sql); 
				while ($row = mysqli_fetch_array($result)){ 
				$codtab	= $row["codtab"];
				$destab	= $row["destab"];
				?>
              <option value="<?php echo $row["destab"]?>"><?php echo $row["destab"] ?></option>
              <?php 
			} ?>
            </select>          </td>
        </tr>
        <tr>
          <td>MARCA A </td>
          <td><select name="marca1" id="marca1">
              <?php 
				$sql = "SELECT codtab,destab FROM titultabladet where tiptab = 'M' order by destab"; 
				$result = mysqli_query($conexion,$sql); 
				while ($row = mysqli_fetch_array($result)){ 
				$codtab	= $row["codtab"];
				$destab	= $row["destab"];
				?>
              <option value="<?php echo $row["destab"]?>"><?php echo $row["destab"] ?></option>
              <?php 
			} ?>
            </select>
          </td>
        </tr>
        <tr>
          <td>REPONER SOLO PRODUCTOS INCENTIVADOS </td>
          <td><label>
            <input name="repon" type="checkbox" id="repon" value="1" />
          </label></td>
        </tr>
      </table>
	   <br>
        <div align="left">
         
      <?php /* 
	    $sql="SELECT factorrepoc FROM datagen";
		$result = mysqli_query($conexion,$sql);
		if (mysqli_num_rows($result)){
		while ($row = mysqli_fetch_array($result)){
				$factorrepoc    = $row['factorrepoc'];
		}
		}
		else
		{
				$factorrepoc    = 0;
		}
	 */
	 $factorrepoc=1;
	  ?>
        </div>
      <?php /*
		?>
		<table width="552" border="0">
        <tr>
          <td><u><?php if ($factorrepoc == 0){?> NO SE HA CONFIGURADO EL FACTOR DE REPOSICION<?php } else{?>EL FACTOR DE REPOSICION REGISTRADO ES DE <?php echo $factorrepoc; echo " ";?>DIAS<?php }?></u></td>
        </tr>
      </table>
	  <?php */
	  ?>
	  </td>
    </tr>
  </table>
</form>
</body>
</html>
