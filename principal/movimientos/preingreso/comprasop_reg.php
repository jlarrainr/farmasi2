<?php include('../../session_user.php');
require_once ('../../../conexion.php');
$cod    		= $_POST['cod'];			///invnum
$date1  		= $_POST['date1'];			///cantidad ingresada
$date2  		= $_POST['date2'];			///precio sin descuentos y sin igv
$n1     		= $_POST['n1'];				///num documento1
$n2     		= $_POST['n2'];				///num documento2
$plazo  		= $_POST['plazo'];			///plazo
$moneda 		= $_POST['moneda'];			///moneda
$mont1  		= $_POST['mont_bruto'];		///precio bruto
$mont2  		= $_POST['total_des'];		///descuentos
$mont3  		= $_POST['valor_vent1'];	///precio venta
$mont4  		= $_POST['sum_igv'];		///igv
$mont5  		= $_POST['monto_total'];	///total
$sum33  		= $_POST['sum33'];			///total
$ncompra  		= $_POST['ncompra'];		///numero interno de compra
$cant_registros = $_POST['cant_registros'];	///CANTIDAD DE REGISTROS DE LA COMPRA
/////////////////////////////////////////////////////////////////////////////////
$sql="SELECT count(invnum) FROM templote where invnum = '$cod' and vencim <> ''";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$count        = $row[0];	////CANTIDAD DE REGISTROS EN EL GRID
}	
}
else
{
$count = 0;	////CUANDO NO HAY NADA EN EL GRID
}
/////////////////////////////////////////////////////////////////////////////////
$date = date("Y-m-d");
//$hour   = date(G);
//$date	= CalculaFechaHora($hour);
$sql="SELECT codloc FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
			$codloc    = $row['codloc'];
}
}
$sql="SELECT nomloc FROM xcompa where codloc = '$codloc'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    		$nomloc    = $row['nomloc'];
}
}
require_once('../tabla_local.php');
///FUNCION PARA CONVERTIR EL FACTOR A NUMERO
function convertir_a_numero($str)
{
	  $legalChars = "%[^0-9\-\. ]%";
	  $str=preg_replace($legalChars,"",$str);
	  return $str;
}		
$sql="SELECT numdoc,invfec,tipmov,tipdoc,usecod FROM movmae where invnum = '$cod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    	$numdoc    = $row['numdoc'];
		$invfec    = $row['invfec'];
		$tipmov    = $row['tipmov'];
		$tipdoc    = $row['tipdoc'];
		$usecod    = $row['usecod'];
}
}
$sql="SELECT porcent FROM datagen";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$porcent    = $row['porcent'];
}
}
$porcentaje = (1+($porcent/100));
$sql="SELECT * FROM tempmovmov where invnum = '$cod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    	$codtemp   = $row['codtemp'];
		$codpro    = $row['codpro'];
		$qtypro    = $row['qtypro'];
		$qtyprf    = $row['qtyprf'];
		$pripro    = $row['pripro'];	//precio incluyendo el descuento e igv
		$prisal    = $row['prisal'];	//precio sin igv ni descuento
		$costre    = $row['costre'];	//costo real del producto. el pripro * la cantidad
		$desc1     = $row['desc1'];
		$desc2     = $row['desc2'];
		$desc3     = $row['desc3'];
		$costpr    = $row['costpr'];
		$canbon    = $row['canbon'];	//cantidad bonificada
		$tipbon    = $row['tipbon'];	//tipo de bonificacion
		$stopro    = 0;
		$cant_loc  = 0;
		////veo los datos del producto
		$sqlx="SELECT tcosto,tmargene,tprevta,tpreuni FROM producto where codpro = '$codpro'";
		$resultx = mysqli_query($conexion,$sqlx);
		if (mysqli_num_rows($resultx) ){
		while ($rowx = mysqli_fetch_array($resultx)){
				$tcosto          = $rowx["tcosto"];			//codigo
				$tmargene        = $rowx["tmargene"];		//codigo
				$tprevta         = $rowx["tprevta"];		//codigo
				$tpreuni         = $rowx["tpreuni"];		//codigo
		}
		}
		if (($tmargene <> 0) && ($tprevta <> 0) && ($tpreuni <> 0))
		{
		////////////mysqli_query($conexion,"UPDATE producto set margene = '$tmargene',tmargene = '0',prevta= '$tprevta',tprevta= '0',preuni = '$tpreuni',tpreuni = '0',tcosto = '0' where codpro = '$codpro'");
		}
		////SI HAY CANTIDAD BONIFICABLE EN EL TEMPORAL
		//----------------------------------------------------
		if ($canbon <> 0)
		{
			////COMPRUEBO QUE SE HAYA REGISTRADO EL PRODUCTO BONIFICABLE
			$sqlq="SELECT codpro,canbon,tipbon,costo_real FROM tempmovmov_bonif where codtemp = '$codtemp' and invnum = '$cod'";
			$resultq = mysqli_query($conexion,$sqlq);
			if (mysqli_num_rows($resultq))
			{
				while ($rowq = mysqli_fetch_array($resultq)){
    			$codprobon   = $rowq['codpro'];			/////el codigo del producto que se esta bonificando
				$canbon1     = $rowq['canbon'];
				$tipbon1     = $rowq['tipbon'];
				$pripro1     = $rowq['costo_real'];		/////nuevo precio de compra calculado
				}
			}
			else
			{
			$nohay     = 1;	////quiere decir que no se ha registrado nada de bonificaciones, por tanto sale del sist a compras1
			$codprobon = 0;
			$canbon1   = 0;
			$tipbon1   = 0;
			$pripro1   = 0;
			}
		}
		else
		{
		$codprobon = 0;
		$canbon1 = 0;
		$tipbon1 = 0;
		$pripro1 = 0;
		}
		//--------------------------------------------------
		if ($nohay <> 1)	/////PREGUNTO SI EL PRODUCTO ES BONIFICABLE O SI ESTE NO TIENE VINCULO CON BONIFICACION
		{
			//----------------------------AQUI EMPIEZO $NOHAY = 1 ------------------------------////
			//-------------SELECCIONO EL PRODUCTO Y VEO SU FACTOR Y STOCK EN GENERAL------------////
			$sql1="SELECT factor,stopro,preuni,margene,igv,$tabla,pcostouni FROM producto where codpro = '$codpro'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
					$factor       = $row1['factor'];
					$stopro       = $row1['stopro'];
					$preuni       = $row1['preuni'];
					$margene      = $row1['margene'];
					$igv          = $row1['igv'];
					$cant_loc     = $row1[5];
					$ultpcostouni = $row1['pcostouni'];
//					$sactual	  = $stopro;
                                        $sactual	  = $cant_loc;
			}
			}
			//////CALCULO DEL PRECIO REFERENCIAL
			if ($igv == 1)
			{
			$referencial = $prisal * $porcentaje;
			}
			else
			{
			$referencial = $prisal;
			}
			if ($qtyprf <> "") ///// EN UNIDADES
			{
				$text_char = convertir_a_numero($qtyprf);
				$cant_unid = $text_char;				////cantidad ingresada en unidades
				if ($pripro1 == 0)						////si el costo bonificable es igual a 0
				{
				$pcostouni  = $costre/$cant_unid;		/////costo real/unidades ingresantes
				}
				else
				{
				$pcostouni  = $pripro1 * $factor;		/////costo real del producto
				}
			}
			else			//// EN CAJAS
			{
				$cant_unid = $qtypro * $factor;			////cantidad ingresada en unidades
				if ($pripro1 == 0)						////si el costo bonificable es igual a 0
				{
				$pcostouni  = $costre/$qtypro;			/////costo real/caja
				}
				else
				{
				$pcostouni  = $pripro1 * $factor;		/////costo real del producto
				}
			}
			////////LOTES Y VENCIMIENTOS DE LA TABLA TEMPORAL///////////////////////////////////////
			$sql1="SELECT numerolote,vencim FROM templote where invnum = '$cod' and codpro = '$codpro'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1))
			{
				$numlote        = $row1['numerolote'];
				$vencimi        = $row1['vencim'];
			}
			}
			$stocklote = 0;
			///////REVISO SI EL NUMERO DEL TEMPORAL EXISTE EN MI TABLA ORIGINAL
			if ($numlote <> "")
			{
				$sql1="SELECT numlote,vencim,stock FROM movlote where numlote = '$numlote'";
				$result1 = mysqli_query($conexion,$sql1);
				if (mysqli_num_rows($result1)){
				while ($row1 = mysqli_fetch_array($result1))
				{
					$numerolote     = $row1['numlote'];
					$fvencimi       = $row1['vencim'];
					$stocklote      = $row1['stock'];
					$stocklote		= $stocklote + $cant_unid;
				}
				///mysqli_query($conexion,"UPDATE movlote set stock = '$stocklote' where codpro = '$codpro' and numlote = '$numerolote'");
				}
				else
				{
				//mysqli_query($conexion,"INSERT INTO movlote (codpro,numlote,vencim,stock) values ('$codpro','$numlote','$vencimi','$cant_unid')");
				}
			}
			/////////////////////////////////////////////////////////////
			//----si ay bonificacion y es por el mismo producto en cajas
			if (($codprobon == $codpro) && ($codprobon <> 0) && ($tipbon1 == "C"))
			{
				$frac_canbon= $canbon1;							/////CANTIDAD BONIFICADA POR CAJA
				$canbon1    = $canbon1 * $factor;				/////CANTIDAD BONIFICADA EN UNIDADES
				$cant_local	= $cant_unid + $cant_loc + $canbon1;/////STOCK LOCAL INCL BONIFICACION
				$stopro     = $cant_unid + $stopro + $canbon1;	/////NUEVO STOCK INCL BONIFICACION
				$prevta1    = $pripro1 * (($margene/100) + 1);	/////NUEVO PRECIO DE VENTA INCL BONIFICACION DEL PROD GENERAL
				$preciounit = $prevta1/$factor;					/////NUEVO PRECIO UNITARIO INCL BONIFICACION DEL PROD GENERAL
				//////TIPMOV Y TIPDOC = 11 CUANDO ES BONIFICACION
				////////////mysqli_query($conexion,"INSERT INTO kardex (nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,fraccion,factor,invnum,usecod,sactual) values ('$numdoc','$codprobon','$invfec','11','11','$frac_canbon','','$factor','$cod','$usuario','$sactual')");
				mysqli_query($conexion,"INSERT INTO movmov (invnum,invfec,codpro,qtypro,qtyprf,pripro,prisal,costre,desc1,desc2,desc3,costpr) values ('$cod','$date','$codprobon','$frac_canbon','','0','0','0','0','0','0','0')");
			}
			else
			{
				//----si es bonificacion pero con otro producto en cajas
				if (($codprobon <> $codpro) && ($codprobon <> 0) && ($tipbon1 == "C"))
				{
					$sqlc="SELECT factor,stopro,$tabla FROM producto where codpro = '$codprobon'";
					$resultc = mysqli_query($conexion,$sqlc);
					if (mysqli_num_rows($resultc)){
					while ($rowc = mysqli_fetch_array($resultc)){
							$factores    = $rowc['factor'];
							$stoproes    = $rowc['stopro'];
							$cant_loces  = $rowc[2];
							//$sactual	 = $stoproes;
                                                        $sactual	 = $cant_loces;
					}
					}
					$frac_canbon= $canbon1;					/////CANTIDAD BONIFICADA POR CAJA
					$canbon1    = $canbon1 * $factores;		/////CANTIDAD BONIFICADA EN UNIDADES
					$stoproes   = $stoproes + $canbon1;		/////STOCK GENERAL DEL PRODUCTO BONIFICADO
					$cant_loces = $cant_loces + $canbon1;	/////STOCK LOCAL DEL PRODUCTO BONIFICADO
					$cant_local	= $cant_unid + $cant_loc;	/////STOCK LOCAL DEL PRODUCTO PRINCIPAL
					$stopro     = $cant_unid + $stopro;		/////STOCK GENERAL DEL PRODUCTO PRINCIPAL
					$prevta1    = $pripro1 * (($margene/100) + 1); ////NUEVO PRECIO DE VENTA DEL PRODUCTO GENERAL
					$preciounit = $prevta1/$factor;			/////NUEVO PRECIO UNITARIO DE VENTA DEL PRODUCTO GENERAL
					////////////mysqli_query($conexion,"UPDATE producto set stopro = '$stoproes', $tabla = '$cant_loces' where codpro = '$codprobon'");
					//////TIPMOV Y TIPDOC = 11 CUANDO ES BONIFICACION
					////////////mysqli_query($conexion,"INSERT INTO kardex (nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,fraccion,factor,invnum,usecod,sactual) values ('$numdoc','$codprobon','$invfec','11','11','$frac_canbon','','$factor','$cod','$usuario','$sactual')");
					mysqli_query($conexion,"INSERT INTO movmov (invnum,invfec,codpro,qtypro,qtyprf,pripro,prisal,costre,desc1,desc2,desc3,costpr) values ('$cod','$date','$codprobon','$frac_canbon','','0','0','0','0','0','0','0')");
				}
				else
				{
					//-----si hay bonificacion con otro producto pero en unidades
					if (($codprobon <> 0) && ($tipbon1 == "U"))
					{
						$sqlc="SELECT stopro,$tabla FROM producto where codpro = '$codprobon'";
						$resultc = mysqli_query($conexion,$sqlc);
						if (mysqli_num_rows($resultc)){
						while ($rowc = mysqli_fetch_array($resultc)){
								$stoproes    = $rowc['stopro'];
								$cant_loces  = $rowc[1];
								//$sactual	 = $stoproes;
                                                                $sactual	 = $cant_loces;
						}
						}
						$frac_canbon= "f".$canbon1;						/////CANTIDAD BONIFICADA CON EL CARACTER F - UNID
						if ($codprobon == $codpro)						/////SI ES BNIFICACION CON EL MISMO PROD
						{
						$cant_local	= $cant_unid + $cant_loc + $canbon1;/////STOCK LOCAL INCL BONIFICACION DEL PROD GENERAL
						$stopro     = $cant_unid + $stopro + $canbon1;	/////NUEVO STOCK INCL BONIFICACION DEL PROD GENERAL
						$prevta1    = $pripro1 * (($margene/100) + 1);	/////NUEVO PRECIO DE VENTA INCL BONIFICACION DEL PROD GEN
						$preciounit = $prevta1/$factor;					/////NUEVO PRECIO UNITARIO INCL BONIFICACION
						}
						else											/////SI ES BNIFICACION CON OTRO PROD
						{
						$stoproes   = $stoproes + $canbon1;				/////STOCK GENERAL DEL PROD BONIFICABLE
						$cant_loces = $cant_loces + $canbon1;			/////STOCK LOCAL DEL PROD BONIFICABLE
						$cant_local	= $cant_unid + $cant_loc;			/////STOCK LOCAL DEL PROD GENERAL
						$stopro     = $cant_unid + $stopro;				/////STOCK GENERAL DEL PROD GENERAL
						$prevta1    = $pripro1 * (($margene/100) + 1);	/////NUEVO PRECIO DE VENTA DEL PRODUCTO GENERAL
						$preciounit = $prevta1/$factor;
						////////////mysqli_query($conexion,"UPDATE producto set stopro = '$stoproes', $tabla = '$cant_loces' where codpro = '$codprobon'");
						}
						////////////mysqli_query($conexion,"INSERT INTO ventas_bonif_unid (codpro,codprobonif,cajas,unid) values ('$codpro','$codprobon','$qtypro','$canbon1')");
						//////TIPMOV Y TIPDOC = 11 CUANDO ES BONIFICACION
						////////////mysqli_query($conexion,"INSERT INTO kardex (nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,fraccion,factor,invnum,usecod,sactual) values ('$numdoc','$codprobon','$invfec','11','11','','$frac_canbon','$factor','$cod','$usuario','$sactual')");
						mysqli_query($conexion,"INSERT INTO movmov (invnum,invfec,codpro,qtypro,qtyprf,pripro,prisal,costre,desc1,desc2,desc3,costpr) values ('$cod','$date','$codprobon','','$frac_canbon','0','0','0','0','0','0','0')");
					}
					//// no ay bonificaciones
					else
					{
						$cant_local = $cant_unid + $cant_loc;
						$stopro     = $cant_unid + $stopro;
						$prevta1    = $pripro * (($margene/100) + 1);
						$preciounit = $prevta1/$factor;
					}
				}
			}
			//////MODIFICAR LA TABLA ORDMOV
			if ($costre <> 0)
			{
			mysqli_query($conexion,"UPDATE ordmov set canate = '$cant_unid' where invnum = '$ncompra' and codpro = '$codpro' and mont_total <> '0'");
				if ($tipbon1 == "C") 
				{
				$tx = $factor * $canbon1;
				mysqli_query($conexion,"UPDATE ordmov set codpro = '$codprobon',canate = '$tx' where invnum = '$ncompra' and codprobon = '$codpro' and mont_total = '0'");
				}
				else
				{
				$cant_unidxxx = $canbon1;
				mysqli_query($conexion,"UPDATE ordmov set codpro = '$codprobon',canate = '$cant_unidxxx' where invnum = '$ncompra' and codprobon = '$codpro'  and mont_total = '0'");
				}
			}
			else
			{
				if ($tipbon1 == "C") 
				{
				$tx = $factor * $canbon1;
				mysqli_query($conexion,"UPDATE ordmov set codpro = '$codprobon',canate = '$tx' where invnum = '$ncompra' and codprobon = '$codpro' and mont_total = '0'");
				}
				else
				{
				$cant_unidxxx = $canbon1;
				mysqli_query($conexion,"UPDATE ordmov set codpro = '$codprobon',canate = '$cant_unidxxx' where invnum = '$ncompra' and codprobon = '$codpro'  and mont_total = '0'");
				}
			}
			/*echo "PRECIO REFERENCIAL: ";echo $referencial; echo '<br>';
			echo "PRIPRO: ";echo $pripro; echo '<br>';
			echo "Pcostouni: ";echo $pcostouni; echo '<br>';
			echo "Prisal: ";echo $prisal; echo '<br>';
			echo "PRIPRO1: ";echo $pripro1; echo '<br>';
			*/
			$sql1="SELECT stopro,$tabla FROM producto where codpro = '$codpro'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
//					$sactual       = $row1['stopro'];
                                        $sactual       = $row1[1];
			}
			}
			//mysqli_query($conexion,"UPDATE movlote set stock = '$cant_unid' where invnum = '$cod' and codpro = '$codpro'");
			////////////mysqli_query($conexion,"UPDATE producto set stopro = '$stopro', prelis = '$referencial',costpr = '$costpr',costre = '$pripro',$tabla = '$cant_local',pcostouni = '$pcostouni',fecord = '0000-00-00',ultpcostouni = '$ultpcostouni',modifpcosto = '0' where codpro = '$codpro'");
			/////////////////////////////////////////////////////////////
			mysqli_query($conexion,"INSERT INTO movmov (invnum,invfec,codpro,qtypro,qtyprf,pripro,prisal,costre,desc1,desc2,desc3,costpr,codprobon,canbon,tipbon,priprobon) values ('$cod','$date','$codpro','$qtypro','$qtyprf','$pripro','$prisal','$costre','$desc1','$desc2','$desc3','$costpr','$codprobon','$canbon1','$tipbon1','$pripro1')");
			////////////mysqli_query($conexion,"INSERT INTO kardex (nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,fraccion,factor,invnum,usecod,sactual) values ('$numdoc','$codpro','$invfec','$tipmov','$tipdoc','$qtypro','$qtyprf','$factor','$cod','$usuario','$sactual')");
			//----------------------------AQUI TERMINO $NOHAY = 1 ------------------------------/////
		}
}
}
if ($nohay <> 1)
{
//mysqli_query($conexion,"DELETE from tempmovmov where invnum = '$cod'")	;
//mysqli_query($conexion,"DELETE from tempmovmov_bonif where invnum = '$cod'")	;
//mysqli_query($conexion,"DELETE from templote where invnum = '$cod'")	;
mysqli_query($conexion,"UPDATE movmae set usecod  = '$usuario',fecdoc = '$date1',numero_documento = '$n1', numero_documento1 = '$n2',plazo = '$plazo',moneda = '$moneda',invtot = '$mont5',destot = '$mont2', valven = '$mont3',fecven = '$date2',monto = '$sum33',costo = '$mont1',igv = '$mont4', estado = '1', proceso = '0',sucursal = '$codloc' where invnum = '$cod'");
mysqli_query($conexion,"UPDATE ordmae set pendiente = '1', confirmado = '1',altpreingreso = '1' where invnum = '$ncompra'")	;
header("Location: comprasop_reg1.php");
}
else
{
header("Location: compras.php?msg=2"); 
}
?>