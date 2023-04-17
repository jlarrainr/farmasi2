<?php
include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<?php
require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once('../../../titulo_sist.php');
include('../../local.php');
 $limpiacadena= $_REQUEST['lim'];
?>
<script>
// Si usuario pulsa tecla ESC, cierra ventana
function getfocus1(){
document.getElementById('l1').focus();
}
function cerrar(e){
tecla=e.keyCode
	if (tecla == 27)
	{
	window.close();
	}
}
function cerrar_popup(valor)
{
//ventana=confirm("Desea Grabar este Cliente"+valor);
var pactivo = valor;

document.form1.target = "venta_principal";
window.opener.location.href="salirprinac.php?pactivo="+pactivo;
self.close();
}
</script>
<?php
	function formato($c) {
		printf("%08d",$c);
	} 
?>
<title>PRINCIPIO ACTIVO</title>
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
</head>

<body onload="getfocus1()" onkeyup="cerrar(event)">
<form name="form1">
    <table width="442" border="0" align="center" bordercolor="#FFCC00" bgcolor="#CCFF33">
					<tr>
                                            <td width="40" align="center"><strong><H1>PRINCIPIO ACTIVO</H1></strong></td>
					</tr>
				</table>
    <br></br>
	<table class="tabla2" width="442" border="0">
            
		<tr>
			<td width="540">
				
				<table width="438" border="0" align="center" bordercolor="#FFCC00" bgcolor="#CCFF33">
					<tr>
						<td width="40"><strong>CODIGO</strong></td>
						<td width="191"><strong>DESCRIPCION</strong></td>
					</tr>
				</table>
				<div align="center"><img src="../../../images/line2.jpg" width="438" height="4" /></div>
				<?php

				$sql="SELECT codtab,destab FROM titultabladet where tiptab = 'F' and destab LIKE '$limpiacadena%' order by destab";
				$result = mysqli_query($conexion,$sql);
				if (mysqli_num_rows($result)){
				?>
					<table width="438" border="0" align="center">
						<?php
						while ($row = mysqli_fetch_array($result)){
							$codigo         = $row['codtab'];
							$destab         = $row['destab'];
						?>
							<tr height="20" onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
								<td width="65"><a href="javascript:cerrar_popup(<?php echo $codigo?>)"><?php echo $codigo?></a></td>
                                                                <td width="356">
                                                                        <a id="l1" href="javascript:cerrar_popup(<?php echo $codigo?>)">
                                                                          <?php echo $destab;?>
                                                                        </a>		
                                                                        </td>
							</tr>
					<?php 
						}
					?>
					</table>
				<?php
				}
				?>
			</td>
		</tr>
	</table>
</form>
    <?php /*mysqli_free_result($result);
mysqli_free_result($result1);
mysqli_close($conexion); */
?>
</body>
</html>
