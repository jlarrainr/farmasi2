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
<form name="form1" id="form1">
<table width="570" align="center" class="demoTable">
      <caption>
        <span class="Estilo1">REGISTRO  DE TRANSPORTISTAS        </span>
      </caption>
      <thead>
        <tr>
		  <th width="113"><div align="left"></div></th>
		  <th width="445"><div align="left"></div></th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="2"><div align="center">
            
              <div align="right">
                <input name="btn" type="hidden" id="btn" value="1"/>
                <input type="button" name="print" value="Imprimir" onclick="imprimir()" class="imprimir"/>
                <input type="reset" name="limp"  id="limp" value="Limpiar" class="limpiar"/>
                <input type="submit" name="back" value="Regresar" onClick="atras_movtransp2()" class="regresar"/>
                <input type="button" name="exit" value="Salir" onClick="salir1()" class="salir"/>
            </div>
            
          </div></td>
        </tr>
      </tfoot>
      <tbody>

        <tr>
		  <td><div align="right"><strong>NOMBRE</strong>
	      </div></td>
		  <td><center>

		    <div align="right">
		      
              <input name="desc" type="text" id="desc" size="70" onKeyUp="this.value = this.value.toUpperCase();"/>
		      <input type="button" name="Submit" value="Grabar" onclick="save_movtransp2()" class="grabar"/>
            </div>
		  </center></td>
        </tr>
	
      </tbody>
  </table>
	</form>
</body>
</html>