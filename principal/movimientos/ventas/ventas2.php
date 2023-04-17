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
    $invnum = $_REQUEST['invnum'];
	$sql="SELECT codpro,canpro,fraccion,prisal,pripro,idlote FROM detalle_venta where invnum = '$invnum'";
	$result = mysqli_query($conexion,$sql);
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
			$codpro         = $row['codpro'];
			$canpro         = $row['canpro'];	
			$fraccion       = $row['fraccion'];
			$prisal         = $row['prisal'];	
			$pripro         = $row['pripro'];	
			 $idlote        = $row['idlote'];
			
			$numlote = "......";
            $vencim = "";
            $sqlLote = "SELECT numlote,vencim FROM movlote where idlote = '$idlote'";
            $resulLote = mysqli_query($conexion, $sqlLote);
             if (mysqli_num_rows($resulLote))
            {
                while ($row1 = mysqli_fetch_array($resulLote))
                {
                   $numlote    = $row1['numlote'];
                   $vencim     = $row1['vencim'];
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
			$sql1="SELECT desprod,codmar,factor FROM producto where codpro = '$codpro'";
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
		<?php echo $codpro?>
            </td>
            <td width="425" valign="bottom">
		<a title="EL FACTOR ES <?php echo $factor?>"><?php echo $desprod?></a>
            </td>
            <!--<td width="59" valign="bottom"><div align="right"><?php if ($fraccion == "F"){echo $canpro;}else{ echo "0";}?></div></td>-->
            <td width="59" valign="bottom" align="center">
                <div align="center">
                <?php  echo $canpro
                ?>
                </div>
            </td>
            <td width="282" align="center" valign="bottom"><?php echo $marca?></td>
            <?php if($drogueria == 1){ ?>
            <td align="center" valign="bottom"><?php echo $numlote?></td>
            <td align="center" valign="bottom"><?php echo $vencim?></td>
            <?php } ?>
            <td width="78" valign="bottom"><div align="right"><?php echo $prisal;?></div></td>
      <td width="71" valign="bottom"><div align="right"><?php echo $pripro;?></div></td>
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
