<?php include('../../session_user.php');
include('../../../convertfecha.php');
require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
$localrecargado = isset($_REQUEST['localrecargado']) ? ($_REQUEST['localrecargado']) : "";


$sql = "SELECT drogueria FROM datagen_det";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
	while ($row = mysqli_fetch_array($result)) {
		$drogueria = $row['drogueria'];
	}
}

$sql = "SELECT invnum FROM movmae where usecod = '$usuario' and proceso = '1'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
	while ($row = mysqli_fetch_array($result)) {
		$invnum          = $row["invnum"];		//codigo
	}
}
$_SESSION['transferencia_sal']	= $invnum;
//echo $invnum."<br>";
$sql = "SELECT numdoc FROM movmae where invnum = '$invnum'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
	while ($row = mysqli_fetch_array($result)) {
		$numdoc    = $row['numdoc'];
	}
}



//echo $numdoc;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Documento sin t&iacute;tulo</title>
	<link href="../css/style.css" rel="stylesheet" type="text/css" />
	<link href="../css2/tablas.css" rel="stylesheet" type="text/css" />
	<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
	<link href="../css/select.css" rel="stylesheet" type="text/css" />

	<link href="../../select2/css/select2.min.css" rel="stylesheet" />
	<script src="../../select2/jquery-3.4.1.js"></script>
	<script src="../../select2/js/select2.min.js"></script>


	<script>
		function combo() {
			alert('Submit');
			var f = document.form1;
			f.action = "transferencia_sal_val.php";
			f.method = "post";
			f.submit();
		}

		function prepedido1() {
			if (document.getElementById("prepedido").value) {
				var f = document.form1;
				f.action = "transferencia1_sal_preped.php";
				f.method = "post";
				f.submit();
			} else {
				alert('Ingrese un número de prepedido');
			}

		}


		function verPrepedido() {
			var popUpWin = 0;
			var left = 300;
			var top = 120;
			var width = 1200;
			var height = 280;
			if (popUpWin) {
				if (!popUpWin.closed)
					popUpWin.close();
			}
			popUpWin = window.open('pendientes.php', 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width=' + width + ',height=' + height + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
		}

		function cancelar() {
			var f = document.form1;
			f.method = "POST";
			f.target = "_top";
			f.action = "transferencia1_sal_del.php";
			f.submit();
		}

		function compras1(e) {
			tecla = e.keyCode;
			var f = document.form1;
			var a = f.carcount.value;
			var b = f.carcount1.value;
			if (tecla == 119) {
				if ((a == 0) || (b > 0)) {
					alert('No se puede grabar este Documento');
				} else {
					var f = document.form1;
					if (f.referencia.value == "") {
						alert("Debe ingresar el nombre del transportista");
						f.referencia.focus();
						return;
					}
					/* if (f.vendedor.value == 0)
					 {
					 alert("Seleccione un Vendedor"); f.vendedor.focus(); return; 
					 }*/
					if (f.local.value == 0) {
						alert("Seleccione un Local");
						f.local.focus();
						return;
					}
					if (f.mont2.value == "") {
						alert("El sistema arroja un TOTAL = a 0. Revise por Favor!");
						f.mont2.focus();
						return;
					}
					if (confirm("�Desea Grabar esta informacion?")) {
						alert("EL NUMERO REGISTRADO ES " + <?php echo $numdoc ?>);
						f.method = "POST";
						f.target = "_top";
						f.action = "transferencia1_sal_reg.php";
						f.submit();
					}
				}
			}
			/*if(tecla==120)
  	 {
		 if ((a == 0)||(b>0))
		 {
		 alert('No se puede realizar la impresi�n de este Documento');
		 }
		 else
		 {
		 	 var f = document.form1;
			  if (f.referencia.value == "")
			  { alert("Debe ingresar el nombre del transportista"); f.referencia.focus(); return; }
			  if (f.vendedor.value == 0)
			  {
			  alert("Seleccione un Vendedor"); f.vendedor.focus(); return; 
			  }
			  if (f.local.value == 0)
			  {
			  alert("Seleccione un Local"); f.local.focus(); return; 
			  }
			  if (f.mont2.value == "")
			  { alert("El sistema arroja un TOTAL = a 0. Revise por Favor!"); f.mont2.focus(); return; }
			  f.method = "POST";
			  f.target = "_top";
			  f.action ="transferencia1_sal_op_reg.php";
			  f.submit();
		 }
	 }*/

			if (tecla == 120) {
				//alert("eduardo11111111")
			}
		}

		function imprimirdoc() {
			var f = document.form1;
			var a = f.carcount.value;
			var b = f.carcount1.value;
			if ((a == 0) || (b > 0)) {
				alert('No se puede realizar la impresi�n de este Documento');
			} else {
				var f = document.form1;
				if (f.referencia.value == "") {
					alert("Debe ingresar el nombre del transportista");
					f.referencia.focus();
					return;
				}
				/*if (f.vendedor.value == 0)
				{
				alert("Seleccione un Vendedor"); f.vendedor.focus(); return; 
				}*/
				if (f.local.value == 0) {
					alert("Seleccione un Local");
					f.local.focus();
					return;
				}
				if (f.mont2.value == "") {
					alert("El sistema arroja un TOTAL = a 0. Revise por Favor!");
					f.mont2.focus();
					return;
				}

				ventana = confirm("Desea Grabar estos datos");
				if (ventana) {

					f.method = "POST";
					f.target = "_top";
					// f.action ="transferencia1_sal_op_reg.php";
					f.action = "transferencia1_sal_reg.php";
					f.submit();
				}


			}
		}

		function grabardoc() {
			var f = document.form1;
			var a = f.carcount.value;
			var b = f.carcount1.value;
			if ((a == 0) || (b > 0)) {
				alert('No se puede grabar este Documento');
			} else {
				var f = document.form1;
				if (f.referencia.value == "") {
					alert("Debe ingresar el nombre del transportista");
					f.referencia.focus();
					return;
				}
				if (f.vendedor.value == 0) {
					/*alert("Seleccione un Vendedor"); f.vendedor.focus(); return; */
				}
				if (f.local.value == 0) {
					alert("Seleccione un Local");
					f.local.focus();
					return;
				}
				if (f.mont2.value == "") {
					alert("El sistema arroja un TOTAL = a 0. Revise por Favor!");
					f.mont2.focus();
					return;
				}
				if (confirm("�Desea Grabar esta informacion?")) {
					alert("EL NUMERO REGISTRADO ES " + <?php echo $numdoc ?>);
					f.method = "POST";
					f.target = "_top";
					f.action = "transferencia1_sal_reg.php";
					f.submit();
				}
			}
		}


		function grabarventa() {
			var f = document.form1;

			var doc = document.form1.doc.value;

			var cod = document.form1.cod.value;
			var referencia = document.form1.referencia.value;
			var local = document.form1.local.value;
			var vendedor = document.form1.vendedor.value;
			var mont2 = document.form1.mont2.value;
			if (f.local.value == 0) {
				alert("Seleccione un Local Destino");
				f.local.focus();
				return;
			}
			/*if (f.vendedor.value == 0)
			{
			alert("Seleccione un Vendedor Destino"); f.vendedor.focus(); return; 
			}*/
			if (f.referencia.value == "") {
				alert("Debe ingresar el nombre del transportista");
				f.referencia.focus();
				return;
			}
			if (f.mont2.value == "") {
				alert("El sistema arroja un TOTAL = a 0. Revise por Favor!");
				f.mont2.focus();
				return;
			}
			//alert("wwwwwwwwww");
			window.open('preimprimir.php?numdocreg=' + doc + '&referencia=' + referencia + '&local=' + local + '&vendedor=' + vendedor + '&mont2=' + mont2 + '&cod=' + cod, 'PopupName', 'toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=60,left=120,width=885,height=560');
		}
	</script>
	<?php require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
	require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
	require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
	require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
	require_once("../funciones/transferencia.php");	//FUNCIONES DE ESTA PANTALLA
	require_once("ajax_transferencia.php");	//FUNCIONES DE AJAX PARA COMPRAS Y SUMAR FECHAS
	require_once("../../local.php");	//LOCAL DEL USUARIO
	////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////

	$sql = "SELECT nlicencia FROM datagen ";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$nlicencia = $row['nlicencia'] - 1;
		}
	}


	$sql = "SELECT invnum,invfec,numdoc,refere,codusu,sucursal1,cargaprepedido FROM movmae where invnum = '$invnum'";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$cod          = $row['invnum'];		//codgio
			$fecha        = $row['invfec'];
			$numdoc       = $row['numdoc'];
			$refere       = $row['refere'];
			$codusu       = $row['codusu'];
			$sucursal1    = $row['sucursal1'];
			$cargaprepedido    = $row['cargaprepedido'];
		}
	}

	if ($localrecargado == "") {
		$localrecargado = $sucursal1;
	}


	$sql = "SELECT linea1,linea2,linea5 FROM `ticket` WHERE sucursal='$localrecargado'";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$linea1     = $row['linea1'];		//RAZON SOCIAL
			$linea2     = $row['linea2']; //DIRECION
			$linea5     = $row['linea5']; //RUC

		}
	}
	$sql = "SELECT nombre FROM xcompa where codloc = '$localrecargado' and habil = '1' order by nombre, nomloc";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$nombredestino     = $row['nombre'];		//nombre destino


		}
	}

	function formato($c)
	{
		printf("%08d",  $c);
	}
	function formato1($c)
	{
		printf("%06d",  $c);
	}
	?>
	<?php $sql = "SELECT count(*) FROM tempmovmov where invnum = '$invnum'";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$count        = $row[0];	////CANTIDAD DE REGISTROS EN EL GRID
		}
	} else {
		$count = 0;	////CUANDO NO HAY NADA EN EL GRID
	}
	///////CUENTA CUANTOS REGISTROS NO SE HAN LLENADO
	$sql = "SELECT count(*) FROM tempmovmov where invnum = '$invnum' and qtypro = '0' and qtyprf = ''";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$count1        = $row[0];	////CUANDO HAY UN GRID PERO CON DATOS VACIOS
		}
	} else {
		$count1 = 0;	////CUANDO TODOS LOS DATOS ESTAN CARGADOS EN EL GRID
	}
	///////CONTADOR PARA CONTROLAR LOS TOTALES
	$sql = "SELECT count(*) FROM tempmovmov where invnum = '$invnum' and qtypro <> '0' or qtyprf <> ''";
	$result = mysqli_query($conexion, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result)) {
			$count2        = $row[0];
		}
	} else {
		$count2 = 0;
	}
	$sql1 = "SELECT nomusu FROM usuario where usecod = '$usuario'";
	$result1 = mysqli_query($conexion, $sql1);
	if (mysqli_num_rows($result1)) {
		while ($row1 = mysqli_fetch_array($result1)) {
			$user    = $row1['nomusu'];
		}
	}
	$sql1 = "SELECT codpro,pripro,costre FROM tempmovmov where invnum = '$invnum'";
	$result1 = mysqli_query($conexion, $sql1);
	if (mysqli_num_rows($result1)) {
		while ($row1 = mysqli_fetch_array($result1)) {
			$codpro    = $row1['codpro'];
			$pripro    = $row1['pripro'];
			$costre    = $row1['costre'];
			$sum1	   = $sum1 + $pripro;
			$sum2	   = $sum2 + $costre;
		}
		$sum1 			=  $numero_formato_frances = number_format($sum1, 2, '.', ',');
		$sum2 			=  $numero_formato_frances = number_format($sum2, 2, '.', ',');
	} else {
	}
	require_once("../funciones/call_combo.php");	//LLAMA A generaSelect
	?>
	<script type="text/javascript" src="../funciones/select_2_niveles.js"></script>

	<style>
		.table {
			border: 1px solid black;
			border-collapse: collapse;
		}

		.LETRA {
			font-family: Tahoma;
			font-size: 11px;
			line-height: normal;
			color: '#5f5e5e';
			font-weight: bold;
		}

		input {
			box-sizing: border-box;
			border: 1px solid #ccc;
			border-radius: 4px;
			font-size: 12px;
			background-color: white;
			background-position: 3px 3px;
			background-repeat: no-repeat;
			padding: 2px 1px 2px 5px;

		}

		.LETRA2 {
			background: #d7d7d7
		}

		#datos {
			font-family: Tahoma;
			border: 1px solid #f3a95e;
			border-collapse: collapse;


		}
	</style>
</head>

<body onkeyup="compras1(event)">
	<form name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)">
		<table width="100%" border="0">
			<tr>
				<td width="958">
					<table width="100%" border="0">
						<tr>
							<td width="157" class="LETRA" align="left">CARGAR PREPEDIDO</td>
							<td width="276">
								<input name="prepedido" type="text" id="prepedido" size="17" value="<?php echo $idpreped; ?>" />
								<input type="submit" name="Prepedido" value="Buscar" onclick="prepedido1()" />
								<input type="submit" name="VerPrepedido" value="Ver" onclick="verPrepedido()" />
							</td>
							<td width="132" class="LETRA">NUMERO INTERNO<?php echo $lastVentaId ?></td>
							<td width="250"><input name="textfield" type="text" size="26" disabled="disabled" value="<?php echo formato($numdoc) ?>" /></td>
							<td width="60" class="LETRA">
								<div align="left">FECHA</div>
							</td>
							<td width="200"><input name="textfield2" type="text" size="22" disabled="disabled" value="<?php echo fecha($fecha) ?>" /></td>

							<td>
								<div align="right">

									<!--<input name="nuevo" type="button" id="nuevo" value="Nuevo" class="nuevo" disabled="disabled"/>
              <input name="modif" type="button" id="modif" value="Modificar" class="modificar" disabled="disabled"/>-->
									<input name="cod" type="hidden" id="cod" value="<?php echo $invnum ?>" />
									<input name="sum33" type="hidden" id="sum33" value="<?php echo $sum33 ?>" />
									<input name="carcount" type="hidden" id="carcount" value="<?php echo $count ?>" />
									<input name="carcount1" type="hidden" id="carcount1" value="<?php echo $count1 ?>" />


									<input name="save" type="button" id="save" value="Grabar" <?php if ($drogueria == 1) { ?> onclick="grabarventa()" <?php } else { ?> onclick="imprimirdoc()" <?php } ?>class="grabar" <?php if (($count == 0) || ($count1 > 0)) { ?>disabled="disabled" <?php } ?> />
									<!--<input name="printer" type="button" id="printer" value="Grabar e Imprimir" class="imprimir" onclick="imprimirdoc()" <?php if (($count == 0) || ($count1 > 0)) { ?>disabled="disabled" <?php } ?>/>-->
									<input name="ext" type="button" id="ext" value="Cancelar" onclick="cancelar()" class="cancelar" />
								</div>
							</td>

						</tr>
					</table>

					<table width="100%" border="0">
						<tr>
							<td width="176" class="LETRA">LOCAL DE DESTINO</td>
							<td width="250">
								<input type="hidden" id="localrecargado" name="localrecargado" value="<?php echo $localrecargado; ?>" />
								<select id="local" name="local" onchange="searchs2();">
									<option value="0">Seleccione un Local...</option>
									<?php
									if (($cargaprepedido <> 0) && ($count2 <> 0)) {
										$sql = "SELECT * FROM xcompa where codloc <> '$codigo_local' and habil = '1' and codloc = '$localrecargado' order by codloc ";
									} else {
										$sql = "SELECT * FROM xcompa where codloc <> '$codigo_local' and habil = '1' order by codloc ASC LIMIT $nlicencia";
									}
									$result = mysqli_query($conexion, $sql);
									while ($row = mysqli_fetch_array($result)) {
										$loc    = $row["codloc"];
										$nloc   = $row["nomloc"];
										$nombre = $row["nombre"];
									?>
										<option value="<?php echo $row["codloc"] ?>" <?php if ($localrecargado == $row["codloc"]) { ?> selected="selected" <?php } ?>>
											<?php if ($row["nombre"] <> "") {
												echo $row["nombre"];
											} else {
												echo $row["nomloc"];
											} ?>
										</option>
									<?php } ?>
								</select>
								<script>
									var z = dhtmlXComboFromSelect("local");
									z.enableFilteringMode(true);
								</script>
							</td>
							<td width="176">
								<div align="center" class="LETRA">USUARIO DESTINO</div>
							</td>
							<td width="255">
								<select name="vendedor" id="vendedor" onchange="cargarContenido()">
									<option value="0">Seleccione un usuario...</option>
									<?php $sql = "SELECT * FROM usuario where estado = '1' and usecod <> '$usuario' and codloc='$localrecargado' order by nomusu";
									$result = mysqli_query($conexion, $sql);
									while ($row = mysqli_fetch_array($result)) {
									?>
										<option value="<?php echo $row["usecod"] ?>" <?php if ($codusu == $row["usecod"]) { ?> selected="selected" <?php } ?>> <?php echo $row["nomusu"] ?> </option>
									<?php
									}
									?>
								</select>
								<!-- <input type="submit" name="Submit" value="Actualizar" onclick="combo()"/></td>-->
							<td width="350">
								<div align="left" class="text_combo_select"><strong>USUARIO EMISOR :</strong> <img src="../../../images/user.gif" width="15" height="16" /> <?php echo $user ?></div>
							</td>
							<td width="134">
								<div align="right"><span class="text_combo_select"><strong>LOCAL EMISOR :</strong> <?php echo $nombre_local ?></span> </div>
							</td>
						</tr>
						<tr>
							<td width="76" class="LETRA">REFERENCIA O TRANSPORTISTA</td>
							<td width="868" colspan="5">
								<input name="referencia" type="text" id="referencia" size="139" onkeyup="cargarContenido()" value="<?php echo $refere; ?>" placeholder="Debe ingresar el nombre del transportista ...." />
							</td>
							<input type="hidden" id="doc" name="doc" value="<?php echo $numdoc; ?>" />
						</tr>
					</table>
					<?php //if($localrecargado <> 0){ 
					?>
					<!--<div align="center"><img src="../../../images/line2.png" width="100%" height="4" /></div>
          <table width="55%" border="1" bgcolor="#fde5d2"align="center" id="datos" >
              <tr>
                  <th colspan="6" align="center" >INFORMACION DE LOCAL DESTINO <?php echo $nombredestino; ?></th>
              </tr>
              <tr>
                  <th width="90" class="LETRA">RAZON SOCIAL:</th>
                    <td><?php echo  $linea1 ?></td>
                    <th width="30" class="LETRA">DIRECCION:</th>
                    <td><?php echo  $linea2 ?></td>
                  <th width="30" class="LETRA">RUC:</th>
                    <td><?php echo  $linea5 ?></td>
                  
                  
              </tr>
          </table>-->
					<?php //} 
					?>
					<!-- <table width="100%" border="0">
            <tr>
              <td width="76" class="LETRA">CARGAR PREPEDIDO</td>
              <td width="30">
			  				<input name="prepedido" type="text" id="prepedido" size="20" value="<?php echo $idpreped; ?>"/></td>
							<td>
								<input type="submit" name="Prepedido" value="Buscar" onclick="prepedido1()"/>
							</td>
            </tr>
          </table>-->

					<div align="center"><img src="../../../images/line2.png" width="100%" height="4" /></div>
					<table width="100%" border="0">
						<tr>
							<td width="948">
								<iframe src="transferencia2_sal.php" name="iFrame1" width="100%" height="170" scrolling="Automatic" frameborder="0" id="iFrame1" allowtransparency="0">
								</iframe>
							</td>
						</tr>
					</table>
					<div align="center"><img src="../../../images/line2.png" width="100%" height="4" /></div>
					<table width="100%" border="0">
						<tr>
							<td width="955">
								<iframe src="transferencia3_sal.php" name="iFrame2" width="100%" height="208" scrolling="Automatic" frameborder="0" id="iFrame2" allowtransparency="0"> </iframe>
							</td>
						</tr>
					</table>
					<div align="center"><img src="../../../images/line2.png" width="100%" height="4" /> </div>
					<table width="100%" border="0" align="center">
						<tr>
							<td width="72">
								<div align="right"></div>
							</td>
							<td width="130">&nbsp;</td>
							<td width="49">
								<div align="right"></div>
							</td>
							<td width="130">&nbsp;</td>
							<td width="49">
								<div align="right"></div>
							</td>
							<td width="80">&nbsp;</td>
							<td width="125">
								<div align="right" class="LETRA">PRECIO DE SALIDA </div>
							</td>
							<td width="113">
								<div align="right">
									<input name="mont1" class="sub_totales" type="text" id="mont1" onclick="blur()" size="10" value="<?php if ($count > 0) { ?> <?php echo $sum1 ?> <?php } else { ?>0.00<?php } ?>" />
								</div>
							</td>
							<td width="57">
								<div align="right" class="LETRA">TOTAL</div>
							</td>
							<td width="108">
								<div align="right">
									<input name="mont2" class="sub_totales" type="text" id="mont2" onclick="blur()" size="10" value="<?php if ($count > 0) { ?> <?php echo $sum2 ?> <?php } else { ?>0.00<?php } ?>" />
								</div>
							</td>
						</tr>
					</table>
					<div align="center"><img src="../../../images/line2.png" width="100%" height="4" /> </div>
					<br>
				</td>
			</tr>
		</table>
	</form>
</body>

</html>
<script>
	$('#local').select2();
	$('#vendedor').select2();
</script>