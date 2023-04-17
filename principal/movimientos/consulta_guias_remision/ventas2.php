<?php require_once('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>Documento sin t&iacute;tulo</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once('../funciones/consulta_compras.php');	//FUNCIONES DE ESTA PANTALLA
require_once('../../../funciones/highlight.php');	//ILUMINA CAJAS DE TEXTOS
require_once('../../../funciones/functions.php');	//DESHABILITA TECLAS
require_once('../../../funciones/funct_principal.php');	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
?>
</head>
<!--<body onload="fc()">-->
<body>
<?php

    $sqlP_drogueria = "SELECT  drogueria  FROM datagen_det";
    $resultP_drogueria = mysqli_query($conexion, $sqlP_drogueria);
    if (mysqli_num_rows($resultP_drogueria)) {
        while ($row_drogueria = mysqli_fetch_array($resultP_drogueria)) {
            $drogueria = $row_drogueria['drogueria'];
        }
    }

 
    $sql1 = "SELECT nomusu,codgrup,codloc FROM usuario where usecod = '$usuario'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $user       = $row1['nomusu'];
            $codgrup    = $row1['codgrup'];
            $codloc    = $row1['codloc'];
        }
    }


    $despatch_uid = $_REQUEST['despatch_uid'];
    

    //echo $despatch_uid;

	$sql="SELECT deliveredQuantity,unitCode,nameProduct,amountPrice,amountTotal,amountTaxted,igvTax,codProducto  FROM sd_despatch_line  WHERE despatch_uid = '$despatch_uid'";
	$result = mysqli_query($conexion,$sql);


    //echo $sql;
	if (mysqli_num_rows($result)){
?>
<form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">

  <table class="celda2" width="100%">
  <tr height="20">
      <th width="5" align="left" bgcolor="#50ADEA" class="titulos_movimientos" style="font-size: 13px;">CODIGO</th>
      <th width="425" align="left" bgcolor="#50ADEA" class="titulos_movimientos" style="font-size: 13px;">DESCRIPCION</th>
	  <th width="59" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center" style="font-size: 13px;">CANTIDAD</div></th>
	  <!--<th width="59" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">UNID</div></th>-->
	  <th width="282" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center" style="font-size: 13px;">MARCA</div></th>
	  <?php if($drogueria == 1){ ?>
	  <th bgcolor="#50ADEA" class="titulos_movimientos"><div align="center" style="font-size: 13px;">LOTE</div></th>
	  <th bgcolor="#50ADEA" class="titulos_movimientos"><div align="center" style="font-size: 13px;">VENCIMIENTO</div></th>
	  <?php } ?>
	  <th width="78" align="right" bgcolor="#50ADEA" class="titulos_movimientos"><div align="right" style="font-size: 13px;">PRECIO</div></th>
	  <th width="71" align="right" bgcolor="#50ADEA" class="titulos_movimientos"><div align="right" style="font-size: 13px;">SUB TOT</div></th>
	  
    </tr>
    <?php $i = 0;
	while ($row = mysqli_fetch_array($result)){
			++$i;
			$codProducto        = $row['codProducto'];
            $deliveredQuantity  = $row['deliveredQuantity'];
            $unitCode           = $row['unitCode'];
            $nameProduct        = $row['nameProduct'];
            $amountPrice        = $row['amountPrice'];
            $amountTotal        = $row['amountTotal'];
            $amountTaxted       = $row['amountTaxted'];
            $igvTax             = $row['igvTax'];

            $vencimnnn = "";
            $numlote = "";
            $sql1_movlote = "SELECT numlote,vencim FROM movlote where codpro = '$codProducto'  and codloc= '$codloc'  and stock <> 0 and date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d') >= NOW() ORDER BY date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d') limit 1";
            $result1_movlote = mysqli_query($conexion, $sql1_movlote);
            if (mysqli_num_rows($result1_movlote)) {
                while ($row1_movlote = mysqli_fetch_array($result1_movlote)) {
                    $numlote = $row1_movlote['numlote'];
                    $vencimnnn = $row1_movlote['vencim'];
                }
            }

			
			if ($fraccion == "T")
                {
                    $canpro= 'F'.$canpro;
                }
                else
                { 
                    $canpro= 'C'.$canpro;
                }
			$sql1="SELECT porcent FROM datagen";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$porcent    = $row1['porcent'];
			}
			}
			$sql1="SELECT desprod,codmar,factor FROM producto where codpro = '$codProducto'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$desprod    = $row1['desprod'];
				$codmar     = $row1['codmar'];
				$factor     = $row1['factor'];	
			}
			}
			$sql1="SELECT ltdgen FROM titultabla where dsgen = 'MARCA'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$ltdgen     = $row1['ltdgen'];	
			}
			}
			$sql1="SELECT destab FROM titultabladet where codtab = '$codmar' and tiptab = '$ltdgen'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$marca     = $row1['destab'];	
			}
			}
			$valform = $_REQUEST['valform'];
			$cod     = $_REQUEST['cod'];
	?>
	 <tr height="20" onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';" style="font-size: 12px;padding: 10px;" >
            <td width="5" valign="bottom">
		<?php echo $codProducto?>
            </td>
            <td width="425" valign="bottom">
		<a title="EL FACTOR ES <?php echo $factor?>"><?php echo $nameProduct?></a>
            </td>
            <!--<td width="59" valign="bottom"><div align="right"><?php if ($fraccion == "F"){echo $deliveredQuantity;}else{ echo "0";}?></div></td>-->
            <td width="59" valign="bottom" align="center">
                <div align="center">
                <?php  echo $deliveredQuantity
                ?>
                </div>
            </td>
            <td width="282" align="center" valign="bottom"><?php echo $marca?></td>
            <?php if($drogueria == 1){ ?>
            <td align="center" valign="bottom"><?php echo $numlote?></td>
            <td align="center" valign="bottom"><?php echo $vencimnnn?></td>
            <?php } ?>
            <td width="78" valign="bottom"><div align="right"><?php echo $amountPrice;?></div></td>
      <td width="71" valign="bottom"><div align="right"><?php echo $amountTotal;?></div></td>
     </tr>
	<?php }
	?>
  </table>
  <?php 
  mysqli_free_result($result);
mysqli_free_result($result1);
mysqli_close($conexion); 
          }
  else
  {
  ?>
  <br><br><br><br><br><br><br><br><center>NO EXISTEN PRODUCTOS PARA ESTE DOCUMENTO</center>
  <?php }
  ?> 
</form>
<?php 

?>
</body>
</html>
