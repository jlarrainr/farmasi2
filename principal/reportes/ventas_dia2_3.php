<?php
require_once('../../conexion.php');	//CONEXION A BASE DE DATOS
//require_once("../../funciones/calendar.php");
require_once('../../funciones/highlight.php');
require_once("../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
require_once("../../funciones/botones.php");	//COLORES DE LOS BOTONES
require_once("local.php");	//OBTENGO EL NOMBRE Y CODIGO DEL LOCAL


require_once('../../titulo_sist.php');
require_once('../../convertfecha.php');	//CONEXION A BASE DE DATOS








function pintaDatos($Valor)
{
	if ($Valor <> "") {
		return "<tr><td style:'text-align:center'><center>" . $Valor . "</center></td></tr>";
	}
}
function zero_fill($valor, $long = 0)
{
	return str_pad($valor, $long, '0', STR_PAD_LEFT);
}
?>

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<script>
		function imprimir() {

			window.print();
			window.history.go(-2)

			f.submit();
		}
	</script>
		<style>
		body,
		table {
			font-family: "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
			font-size:14px;
			/*font-weight: normal;*/
		}
		.letras121 {
			font-size: 10px;

			font-weight: 800px;

		}
	</style>
	<style type="text/css" media="print">
		div.page {
			writing-mode: tb-rl;
			height: 80%;
			margin: 10% 0%;
		}
	</style>
</head>

<body onload="imprimir()">
	<style type="text/css">
		.Estilo1 {
			color: #FF0000;
			font-weight: bold;
		}
	</style>
	<?php
	$desc = $_REQUEST['desc'];
	$desc1 = $_REQUEST['desc1'];
	$local = $_REQUEST['local'];
	$ck = $_REQUEST['ck'];
	$val = $_REQUEST['val'];
	$ckloc = $_REQUEST['ckloc'];

	$hour  = date('G');
	//$hour   = CalculaHora($hour);
	$min	= date('i');
	if ($hour <= 12) {
		$hor    = "am";
	} else {
		$hor    = "pm";
	}
	if ($local <> 'all') {
		$sql = "SELECT nomloc,nombre FROM xcompa where codloc = '$local'";
		$result = mysqli_query($conexion, $sql);
		while ($row = mysqli_fetch_array($result)) {
			$nloc	= $row["nomloc"];
			$nombre	= $row["nombre"];
			if ($nombre == '') {
				$locals = $nloc;
			} else {
				$locals = $nombre;
			}
		}
	}
	$dat1 = $date1;
	$dat2 = $date2;
	$date1 = fecha1($dat1);
	$date2 = fecha1($dat2);


	$val = 1;

	?>


	<div class="pagina">


		<table width="100%" height="50" border="0">
			<tr class="letras12">
				<td class="letras12" width="300" align="left" height="20"><strong>
						<?php echo $desemp ?></strong></td>

				<td class="letras12" width="260">
					<div class="letras12" align="right">
						<strong>
							FECHA </strong>

						<strong>
							<?php echo date('d/m/Y'); ?></strong>

					</div>
				</td>
			</tr>
			<tr>

				<td align="center" colspan="2" class="letras121" height="26">
					<div  class="letras121" >
						<strong>
							REPORTE DE CIERRE DEL DIA - <?php if ($local == 'all') {
																	echo 'TODAS LAS SUCURSALES';
																} else {
																	echo $locals;
																} ?></strong>
					</div>
				</td>

			</tr>

			<tr>

				<td class="letras121" height="23" colspan="2" width="633">
					<div class="letras121" align="center"><b> NUMERO INTERNO ENTRE EL </b></div>
				</td>


			</tr>
			<br>
			<tr>


				<td class="letras121" colspan="2" width="633">
					<div class="letras121" align="center"><b><?php echo $desc; 	?> Y EL <?php echo $desc1; ?></b></div>

					</b>
	</div>
	</td>

	</tr>
	</table>



	<?php
	if (($ck1 == '') && ($ck2 == '')) {
		if (($val == 1)) {
	?>
	
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<?php 
	$zz = 0;

	if ($val == 1) {
							if ($local == 'all') {
								if ($ckloc == 1) {
									$sql = "SELECT usecod,sucursal FROM venta where invnum between '$desc' and '$desc1' and estado = '0' and invtot <> '0'   group by usecod,sucursal";
								} else {
									$sql = "SELECT usecod FROM venta where invnum between '$desc' and '$desc1' and estado = '0' and invtot <> '0'   group by usecod";
								}
							} else {
								$sql = "SELECT usecod FROM venta where invnum between '$desc' and '$desc1' and sucursal = '$local' and invtot <> '0'  and estado = '0' group by usecod";
							}
						}	
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	?>
	<table width="100%" border="0" align="center" id="customers">
	    <thead>
	     <tr>
        <?php if ($local == 'all'){?>
		<th width="102"><strong>LOCAL</strong></th>
		<?php }?>
	    	<th width="<?php if ($local == 'all'){?>240<?php } else{?>342<?php }?>"><strong>VENDEDOR</strong></th>
    
        <th width="64"><div align="center"><strong>EFC</strong></div></th>
        <th width="68"><div align="center"><strong>TAR/OTROS</strong></div></th>
              <th width="61"><div align="center"><strong>TOTAL</strong></div></th>
      </tr>
      </thead>
      <?php while ($row = mysqli_fetch_array($result)){
		$usecod    = $row['usecod'];
		
		
		if ($local == 'all'){
			$sucurs    = $row['sucursal'];}
		///////USUARIO QUE REALIZA LA VENTA
		$sql1="SELECT nomusu FROM usuario where usecod = '$usecod'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
			$user    = $row1['nomusu'];}}
		$e = 0;
		$t = 0;
		$c = 0;
		$e_tot = 0;
		$t_tot = 0;
		$c_tot = 0;
		$deshabil 	  = 0;
		$deshabil_tot = 0;
		$habil_tot    = 0;
		$count = 0;
		$sumpripro = 0;
		$sumpcosto = 0;
		$porcentaje= 0;
		$Rentabilidad = 0;
		if ($val == 1) {
										if ($local == 'all') {
											if ($ckloc == 1) {
												$sql1 = "SELECT invnum,forpag,val_habil,invtot,sucursal,hora FROM venta where usecod = '$usecod' and invtot <> '0' and invnum between '$desc' and '$desc1' and estado = '0'  and sucursal = '$sucurs' order by sucursal";
											} else {
												$sql1 = "SELECT invnum,forpag,val_habil,invtot,sucursal,hora FROM venta where usecod = '$usecod' and invtot <> '0' and invnum between '$desc' and '$desc1' and estado = '0'  order by sucursal";
											}
										} else {
											$sql1 = "SELECT invnum,forpag,val_habil,invtot,sucursal,hora FROM venta where usecod = '$usecod' and invtot <> '0' and invnum between '$desc' and '$desc1' and sucursal = '$local'  and estado = '0'";
										}
									}

		    $result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$invnum    = $row1["invnum"];
				$forpag    = $row1["forpag"];
				$val_habil = $row1["val_habil"];
				$total     = $row1["invtot"];
				$sucursal  = $row1["sucursal"];
				$hora  = $row1["hora"];
				if ($ckloc == 1){
					if ($sucursal <> $suc[$zz]){
						$zz++;
						$suc[$zz] = $sucursal;
					}
				}
				else{
					if ($usecod <> $suc[$zz]){
						$zz++;
						$suc[$zz] = $usecod;
					}
				}
				$sql3="SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal'";
				$result3 = mysqli_query($conexion,$sql3); 
				while ($row3 = mysqli_fetch_array($result3)){ 
					$nloc	= $row3["nomloc"];
					$nombre	= $row3["nombre"];
					if ($nombre == ''){
						$sucur = $nloc;}
					else{
						$sucur = $nombre;
					}
				}
				if ($val_habil == 0){
					if ($forpag == "E"){
						$e = $e + 1;
						$e_tot = $e_tot + $total;
						$e_tot1[$zz] = $e_tot1[$zz] + $total;
					}
					if ($forpag == "T"){
						$t = $t + 1;
						$t_tot = $t_tot + $total;
						$t_tot1[$zz] = $t_tot1[$zz] + $total;
					}
					if ($forpag == "C"){
						$c = $c + 1;
						$c_tot = $c_tot + $total;
						$c_tot1[$zz] = $c_tot1[$zz] + $total;
					}
                                        
					$sql2="SELECT cospro,pripro,canpro,fraccion,factor,prisal,costpr FROM detalle_venta where invnum = '$invnum'";
					$result2 = mysqli_query($conexion,$sql2);
					if (mysqli_num_rows($result2)){
						while ($row2 = mysqli_fetch_array($result2)){
							$pcostouni    = $row2["cospro"]; //costo del producto x caja
							$pripro       = $row2['pripro']; //subtotal de venta precio unitario x cantidad vendida
							$canpro       = $row2['canpro'];
							$fraccion     = $row2['fraccion'];
							$factor       = $row2['factor'];
							$prisal       = $row2['prisal']; //precio de venta x unidad
							$costpr       = $row2['costpr']; //costo del producto x unidad
	
							if ($fraccion == "T")
							{
								$RentPorcent  = (($prisal-$costpr) * $canpro);
								$Rentabilidad = $Rentabilidad + $RentPorcent;
								
								//$precio_costo = $pcostouni;
							}
							else
							{
								$RentPorcent  = (($prisal-$costpr) * $canpro);
								$Rentabilidad = $Rentabilidad + $RentPorcent;
							}                                                
						 }
					}
				}
				if ($val_habil == 1)
				{
					$deshabil++;
					$deshabil_tot = $deshabil_tot + $total;
					$deshabil_tot1[$zz] = $deshabil_tot1[$zz] + $total;
				}
				else
				{
					$habil_tot = $habil_tot + $total;
					$habil_tot1[$zz] = $habil_tot1[$zz] + $total;
                                }
					$count++;    
				 }
			 }
			 $rentabilidad       = $Rentabilidad;			 
			 $rentabilidad1[$zz] = $rentabilidad1[$zz] + $Rentabilidad;
             
		  if (($suc[$zz-1] <> "") and ($suc[$zz-1] <> $suc[$zz])){
		  ?>
            <tr bgcolor="#CCCCCC" >
  			    <?php if ($local == 'all'){?><td width="102"></td><?php }?>
			
		        <td <?php if ($local == 'all'){?>colspan="2"<?php }?> width="407"><div align="center"><strong>TOTAL</strong></div></td>
				<td width="64"><div align="center"><?php echo $numero_formato_frances = number_format($e_tot1[$zz-1], 2, '.', ' ');?></div></td>
				<td width="68"><div align="center"><?php echo $numero_formato_frances = number_format($c_tot1[$zz-1], 2, '.', ' ') + number_format($t_tot1[$zz-1], 2, '.', ' ') + number_format($deshabil_tot1[$zz-1], 2, '.', ' ');?></div></td>
				<td bgcolor="#92c1e5" width="61"><div align="center"><?php echo $numero_formato_frances = number_format($habil_tot1[$zz-1], 2, '.', ' ');?></div></td>
				
            </tr>
	  <?php }?>
	  <tbody>
	   <tr >
        <?php if ($local == 'all'){?><td width="102" align="center"><?php echo $sucur?></td><?php }?>
		<td width="<?php if ($local == 'all'){?>240<?php } else{?>342<?php }?>">
		<?php echo $user?></td>
        
        <td width="64"><div align="center"><?php echo $numero_formato_frances = number_format($e_tot, 2, '.', ' ');?></div></td>
        <td width="68"><div align="center"><?php echo $numero_formato_frances = number_format($c_tot, 2, '.', ' ') + number_format($t_tot, 2, '.', ' ') + number_format($deshabil_tot, 2, '.', ' ');?></div></td>
        <td width="61"><div align="center"><?php echo $numero_formato_frances = number_format($habil_tot, 2, '.', ' ');?></div></td>
         </tr>
         </tbody>
	  <?php }?>
	  	<?php if ($zz == 1){?>
	  	 <tfoot>
		 <!-- <table width="100%" border="0" align="center">-->
			  <tr bgcolor="#CCCCCC">
				<td <?php if ($local == 'all'){?>colspan="2"<?php }?> width="407"><div align="center"><strong>TOTAL</strong></div></td>
				<td width="64"><div align="center"><?php echo $numero_formato_frances = number_format($e_tot1[$zz], 2, '.', ' ');?></div></td>
				<td width="68"><div align="center"><?php echo $numero_formato_frances = number_format($c_tot1[$zz], 2, '.', ' ') + number_format($t_tot1[$zz], 2, '.', ' ') + number_format($deshabil_tot1[$zz], 2, '.', ' ');?></div></td>
				<td bgcolor="#92c1e5" width="61"><div align="center"><?php echo $numero_formato_frances = number_format($habil_tot1[$zz], 2, '.', ' ');?></div></td>
					  </tr>
					   <tfoot>
		  <!--</table>-->
		<?php }else{
		?>
		<!--  <table width="100%" border="0" align="center">-->
		 <tfoot>
             <tr bgcolor="#CCCCCC">
              <th <?php if ($local == 'all'){?>colspan="2"<?php }?> width="407"><div align="center"><strong>TOTAL</strong></div></th>
              <th width="64"><div align="center"><?php echo $numero_formato_frances = number_format($e_tot1[$zz], 2, '.', ' ');?></div></th>
              <th width="68"><div align="center"><?php echo $numero_formato_frances = number_format($c_tot1[$zz], 2, '.', ' ') + number_format($t_tot1[$zz], 2, '.', ' ') + number_format($deshabil_tot1[$zz], 2, '.', ' ');?></div></th>
              <th bgcolor="#92c1e5" width="61"><div align="center"><?php echo $numero_formato_frances = number_format($habil_tot1[$zz], 2, '.', ' ');?></div></th>
    
            </tr>
             <tfoot>
          <!--</table>-->
		  <?php }?>
    </table>
	
	<?php }else{?>
	<center>No se logro encontrar informacion con los datos ingresados</center>
	<?php }?>
	</td>
  </tr>
</table>
<?php }}?>
	</DIV>
</body>

</html>