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
<?php require_once("../../conexion.php");?>
<?php require_once("funciones/mov_transporte.php");?>
<?php require_once("../../funciones/functions.php");?>
<?php require_once("../../funciones/funct_principal.php");?>
<?php require_once("../../funciones/botones.php");	//COLORES DE LOS BOTONES?>
<style type="text/css">
<!--
.Estilo1 {font-size: 11px}
-->
</style>
</head>
<body onLoad="st();">
<br>
<?php $tracli	= $_REQUEST['cod'];	
$sql="SELECT tracli,tranom FROM transporte where tracli = '$tracli'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result) ){
while ($row = mysqli_fetch_array($result)){
 		 $tracli                 = $row["tracli"];
		 $tranom                 = $row["tranom"];
		 
 }
 }
?>
<form name="form1" id="form1">
<table width="570" align="center" class="demoTable">
      <caption>
        <span class="Estilo1">MODIFICAR  TRANSPORTISTA        </span>
      </caption>
      <thead>
        <tr>
		  <th width="77"><div align="left"></div></th>
		  <th width="481"><div align="left"></div></th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="2"><div align="center">
            
              <div align="right">
                <input name="btn" type="hidden" id="btn" value="2"/>
                <input name="tracli" type="hidden" id="tracli" value="<?php echo $tracli?>"/>
                <input type="button" name="print" value="Imprimir" onclick="imprimir()" class="imprimir"/>
                <input type="button" name="back" value="Regresar" onClick="atras_movtransp4()" class="regresar"/>
                <input type="button" name="exit" value="Salir" onClick="salir1()" class="salir"/>
            </div>
            
          </div></td>
        </tr>
      </tfoot>
      <tbody>

        <tr>
		  <td>
		  <div align="right"><strong>NOMBRE</strong>
	      </div>
		  </td>
		  <td>
		  <center>
	        <div align="right">
              <input name="desc" type="text" id="desc" size="75" onKeyUp="this.value = this.value.toUpperCase();" value="<?php echo $tranom?>"/>
	          <input type="button" name="Submit" value="Grabar" onclick="save_movtransp4()" class="grabar"/>
            </div>
		  </center></td>
        </tr>
	
      </tbody>
  </table>
</form>
</body>
</html>
