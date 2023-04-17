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
<body>
<br>
<?php $cod = $_REQUEST['cod'];
$error = $_REQUEST['error'];
$del = $_REQUEST['del'];
$up  = $_REQUEST['up'];
$ok  = $_REQUEST['ok'];
?>
<table width="570" align="center" class="demoTable">
        <caption>
        <span class="Estilo1">LISTADO DE TRANSPORTISTAS
		<b>
		<?php if ($error == '1')
		{ 
		?>
		<font color="#FF0000">ERROR!</font><font color="#FFFF66"> - NO SE PUDO GRABAR!. LOS DATOS INGRESADOS YA SE ENCUENTRAN REGISTRADOS.</font>
		<?php } 
		If ($ok == 1)
		{ 
		?>
		<font color="#FFFF66">- SE LOGRO GRABAR EXITOSAMENTE LOS DATOS</font>
		<?php } 
		If ($up ==1)
		{ 
		?>
		<font color="#FFFF66">- SE LOGRO ACTUALIZAR EL TRANSPORTISTA SELECCIONADO</font>
		<?php } 
		If ($del ==1)
		{ 
		?>
		<font color="#FFFF66">- SE LOGRO ELIMINAR EL TRANSPORTISTA INDICADO</font>
		<?php } 
		?>
		</b>        </span>
        </caption>
      <thead>
        <tr>
          <th width="34"><div align="center">N&ordm;</div></th>
          <th width="453"><div align="left">Nombre </div></th>
		  <th width="32"><div align="left"></div></th>
		  <th width="31"><div align="left"></div></th>

        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="4"><div align="center">
            <form method="post" name="form1" id="form1">
              <div align="right">
                
                <input type="button" name="print" value="Imprimir" onclick="imprimir()" class="imprimir"/>
                <input type="submit" name="nuevo2" value="Regresar" onclick="back_movtransp1()" class="regresar"/>
                <input type="submit" name="nuevo" value="Nuevo" onClick="nuevo_movtransp1()" class="nuevo"/>
                <input type="button" name="exit" value="Salir" onClick="salir1()" class="salir"/>
              </div>
            </form>
          </div></td>
        </tr>
      </tfoot>
      <tbody>
	  <?php $i=0;
	  $sql="SELECT tracli,tranom FROM transporte order by tranom";
      $result = mysqli_query($conexion,$sql);
      if (mysqli_num_rows($result) ){
	  while ($row = mysqli_fetch_array($result)){
	  		 $i++;
             $tracli                 = $row["tracli"];
			 $tranom                 = $row["tranom"];
			  
	  ?>
        <tr>
          <td><div align="left"><?php echo $i?> -</div></td>
          <td><?php echo $tranom?></td>
		  <td><center>
		  <a href="mov_transp4.php?cod=<?php echo $tracli?>"><img src="../../images/edit_16.png" border="0" height="14" width="14"/></a>
		  </center></td>
		  <td><center>
		  <a href="mov_transp5.php?cod=<?php echo $tracli?>"><img src="../../images/del_16.png" border="0" width="14" height="14" /></a>
		  </center></td>
        </tr>
	  <?php }
      } 
	  ?>
      </tbody>
</table>
</body>
</html>
