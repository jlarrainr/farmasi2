<?php 
include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
$ct = 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $desemp?></title>
<link href="../css/css/style1.css" rel="stylesheet" type="text/css" />
<link href="../css/css/tablas.css" rel="stylesheet" type="text/css" />
<style>
#boton { background:url('../../../images/save_16.png') no-repeat; border:none; width:16px; height:16px; }
#boton1 { background:url('../../../images/icon-16-checkin.png') no-repeat; border:none; width:16px; height:16px; }
a:link,
a:visited {
color: #0066CC;
border: 0px solid #e7e7e7;
}
a:hover {
background: #fff;
border: 0px solid #ccc;
}
a:focus {
background-color: #FFFF66;
color: #0066CC;
border: 0px solid #ccc;
}
a:active {
background-color: #FFFF66;
color: #0066CC;
border: 0px solid #ccc;
} 
</style>
<?php $cr = isset($_REQUEST['cr']) ? ($_REQUEST['cr']) : "";
?>
<script>
function validar_grid()
{
document.form1.method = "post";
document.form1.submit();
}
function validar_prod()
{
var f = document.form1;
f.method = "post";
f.action="grabar_datos.php";
f.submit();
}
function sf()
{
document.form1.p2.focus();
}
var nav4 = window.Event ? true : false;
function ent(evt)
{
	var key = nav4 ? evt.which : evt.keyCode;
	if (key == 13)
	{
		    var f = document.form1;
			f.method = "post";
			f.action="grabar_datos.php";
			f.submit();
	}
	else
	{
	return (key <= 13 || key == 46 || key == 37 || key == 39 || (key >= 48 && key <= 57));
	}
}
/*function precio()
{
	var f 		= document.form1;
	var v1 		= parseFloat(document.form1.p2.value);			//PRECIO VENTA
	var factor      = parseFloat(document.form1.factor.value);		//FACTOR
	var pcu         = parseFloat(document.form1.pcostouni.value);   //PCOSTO
	var t		= v1/pcu;
	var tt		= (t * 100)-100; 	
	var pvu		= v1/factor;
	tt  = Math.round(tt*Math.pow(10,2))/Math.pow(10,2); 
	pvu = Math.round(pvu*Math.pow(10,2))/Math.pow(10,2); 
	document.form1.p1.value = tt;
	document.form1.margene1.value = tt;
	document.form1.p3.value = pvu;
}*/
function precio()
{
	var f 		= document.form1;
        //var v1 		= parseFloat(document.form1.p1.value);			//PRECIO COSTO
	var v1 		= parseFloat(document.form1.p2.value);			//PRECIO VENTA
	var factor      = parseFloat(document.form1.factor.value);		//FACTOR
	//var pcu         = parseFloat(document.form1.pcostouni.value);           //PCOSTO
        var pcu         = parseFloat(document.form1.p1.value);                  //PCOSTO
        if (factor === 0)
        {
            factor  = 1;
        }
	var t		= v1/pcu;
	var tt		= (t * 100)-100; 	
	//var pvu		= v1/factor;
        var rpc         = ((v1 - pcu)/pcu)*100;
        var rpu1        = (pcu/factor);
        var rpu         = ((pvu - rpu1)/rpu1)*100;
	tt  = Math.round(tt*Math.pow(10,2))/Math.pow(10,2); 
	pvu = Math.round(pvu*Math.pow(10,2))/Math.pow(10,2); 
        rpc = Math.round(rpc*Math.pow(10,2))/Math.pow(10,2); 
        rpu = Math.round(rpu*Math.pow(10,2))/Math.pow(10,2); 
	document.form1.margene1.value = tt;                                     //MARGEN DE UTIIDAD?
	document.form1.p3.value = pvu;                                          //PRECIO VTA UNITARIO
        //CALCULO LA RENT POR PRECIO VTA CAJA
        document.form1.pCaja.value = rpc;  
        //CALCULO LA RENT POR PRECIO VTA UNIDAD
        document.form1.pUNI.value = rpu;  
}
function precio1()
{
	var f 		= document.form1;
	var v1 		= parseFloat(document.form1.p3.value);			//PRECIO VENTA UNITARIO
	var factor      = parseFloat(document.form1.factor.value);		//FACTOR
	//var pcu         = parseFloat(document.form1.pcostouni.value);           //PCOSTO
        var pcu         = parseFloat(document.form1.p1.value);                  //PCOSTO
        if (factor === 0)
        {
            factor  = 1;
        }
        var rpu1        = (pcu/factor);
        var rpu         = ((v1 - rpu1)/rpu1)*100;
        rpu = Math.round(rpu*Math.pow(10,2))/Math.pow(10,2); 
	//document.form1.margene1.value = tt;                                     //MARGEN DE UTIIDAD?
	//document.form1.p3.value = pvu;                                          //PRECIO VTA UNITARIO
        //CALCULO LA RENT POR PRECIO VTA CAJA
        //document.form1.pCaja.value = rpc;  
        //CALCULO LA RENT POR PRECIO VTA UNIDAD
        document.form1.pUNI.value = rpu;  
}
</script>
</head>
<?php 
function tablaslocal($nomloc)
{
	if ($nomloc == "LOCAL0")
	{
		$tabla = 's000';
	}
	if ($nomloc == "LOCAL1")
	{
		$tabla = 's001';
	}
	if ($nomloc == "LOCAL2")
	{
		$tabla = 's002';
	}
	if ($nomloc == "LOCAL3")
	{
		$tabla = 's003';
	}
	if ($nomloc == "LOCAL4")
	{
		$tabla = 's004';
	}
	if ($nomloc == "LOCAL5")
	{
		$tabla = 's005';
	}
	if ($nomloc == "LOCAL6")
	{
		$tabla = 's006';
	}
	if ($nomloc == "LOCAL7")
	{
		$tabla = 's007';
	}
	if ($nomloc == "LOCAL8")
	{
		$tabla = 's008';
	}
	if ($nomloc == "LOCAL9")
	{
		$tabla = 's009';
	}
	if ($nomloc == "LOCAL10")
	{
		$tabla = 's010';
	}
	if ($nomloc == "LOCAL11")
	{
		$tabla = 's011';
	}
	if ($nomloc == "LOCAL12")
	{
		$tabla = 's012';
	}
	if ($nomloc == "LOCAL13")
	{
		$tabla = 's013';
	}
	if ($nomloc == "LOCAL14")
	{
		$tabla = 's014';
	}
	if ($nomloc == "LOCAL15")
	{
		$tabla = 's015';
	}
	if ($nomloc == "LOCAL16")
	{
		$tabla = 's016';
	}
	return $tabla;
}
$sql1="SELECT codloc FROM usuario where usecod = '$usuario'";	////CODIGO DEL LOCAL DEL USUARIO
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
	$codloc    = $row1['codloc'];
}
}
$sql="SELECT nomloc FROM xcompa where habil = '1' and codloc = '$codloc'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    $nomloc    = $row['nomloc'];
}
}
$Tabla = tablaslocal($nomloc);
require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUME
require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
require_once("tabla_local.php");	//LOCAL DEL USUARIO
require_once("../../local.php");	//LOCAL DEL USUARIO
$search = isset($_REQUEST['search']) ? ($_REQUEST['search']) : "";
$val    = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";
$sql="SELECT nomusu FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$user    = $row['nomusu'];
}
}
function formato($c) {
printf("%08d",$c);
} 
$codpros = isset($_REQUEST['codpros']) ? ($_REQUEST['codpros']) : "";	
$valform = isset($_REQUEST['valform']) ? ($_REQUEST['valform']) : "";
?>
<body <?php if ($valform==1){ ?>onload="sf();"<?php }else{?> onload="getfocus();"<?php }?> id="body">
<form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">
<table width="932" border="0" class="tabla2">
  <tr>
    <td width="951"><table width="99%" border="0" align="center">
      <tr>
	  <td width="9"></td>
	  <td width="116">&nbsp;</td>
	  <td width="10">	  </td>
	  <td width="191">&nbsp;</td>
        <td width="300"><div align="right"><span class="text_combo_select"><strong> LOCAL:</strong> <img src="../../../images/controlpanel.png" width="16" height="16" /> <?php echo $nombre_local?></span></div></td>
        <td width="263"><div align="right"><span class="text_combo_select"><strong>USUARIO :</strong> <img src="../../../images/user.gif" width="15" height="16" /> <?php echo $user?></span></div></td>
      </tr>
    </table>
	<img src="../../../images/line2.png" width="920" height="4" />
      <table width="915" border="0" align="center">
      <tr>
        <td width="305"><strong>PRODUCTO</strong></td>
        <td width="130"><div align="left"><strong>MARCA</strong></div></td>
        <td width="50"><div align="left"><strong>STOCK</strong></div></td>
	<td width="69"><div align="right"><strong>P. COSTO</strong></div></td>
        <td width="67"><div align="right"><strong>P. VENTA </strong></div></td>
        <td width="83"><div align="right"><strong>P. VENTA UNIT </strong></div></td>
        <td width="60"><div align="right"><strong>% UT X CAJA </strong></div></td>
        <td width="60"><div align="right"><strong>% UT X UNI </strong></div></td>
	<td width="65"><div align="center"><strong>MODIFICAR</strong></div></td>
    </tr>
    </table>
      <div align="center"><img src="../../../images/line2.png" width="920" height="4" />
	  <?php 
	    $sqlP="SELECT Preciovtacostopro FROM datagen";
        $resultP = mysqli_query($conexion,$sqlP);
        if (mysqli_num_rows($resultP))
        {
        while ($row = mysqli_fetch_array($resultP))
        {
            $tipocosto= $row['Preciovtacostopro'];
        }
        }
        // tipocosto=1 costo promedio (costpr), 0=costre
        if ( $tipocosto=1)
        {
            $campo='costpr';
            $tituloc='Costo Promedio';
        
                }
        else
        {
            $campo='costre';
            $tituloc='Costo Real';
            
        }
        
        echo " XXXXXXX          ",$tituloc,"          XXXXXXX";
        if ($val <> "")
	    {
      

	  if ($val == 1)
	  {
	  $sql="SELECT codpro,desprod,pcostouni,$campo,margene,prevta,preuni,factor,codmar,stopro,$Tabla FROM producto where desprod like '$search%'";
	  }
	  if ($val == 2)
	  {
	  $sql="SELECT codpro,desprod,pcostouni,$campo,margene,prevta,preuni,factor,codmar,stopro,$Tabla FROM producto where codmar = '$search'";
	  }
	  if ($val == 3)
	  {
	  $sql="SELECT codpro,desprod,pcostouni,$campo,margene,prevta,preuni,factor,codmar,stopro,$Tabla FROM producto where $tabla > 0";
	  }
	  $result = mysqli_query($conexion,$sql);
	  if (mysqli_num_rows($result)){
	  ?>
        <table width="915" border="0" align="center" id="myTab">
          <?php $cr = 1;
		  	$cont = 1;
			while ($row = mysqli_fetch_array($result)){
				
				$codpro         = $row['codpro'];
				$desprod        = $row['desprod'];
				$pcostouni      = $row['pcostouni'];
				$campo          = $row[4];
				$margene        = $row['margene'];
				$prevta         = $row['prevta'];
				$preuni         = $row['preuni'];
				$factor         = $row['factor'];
				$codmar         = $row['codmar'];
                $stopro         = $row['stopro'];
                $stoproLoc      = $row[10];
				$sql1="SELECT destab FROM titultabladet where tiptab = 'M' and codtab = '$codmar'";
				$result1 = mysqli_query($conexion,$sql1);
				if (mysqli_num_rows($result1)){
				while ($row1 = mysqli_fetch_array($result1)){
					$destab    = $row1['destab'];
				}
				}
				if ($ct == 1)
				{
					$color = "#99CCFF";	
				}
				else
				{
					$color = "#FFFFFF";
				}
				$t = $cont % 2;
				if ($t == 1) {
					$color = "#D2E0EC";
				} else {
					$color = "#ffffff";
				}
				$cont++;
		  ?>
		  <tr bgcolor="<?php echo $color;?>" onmouseover=this.style.backgroundColor='#FFFF99';this.style.cursor='hand'; onmouseout=this.style.backgroundColor="<?php echo $color;?>";>
                        <td width="315"><a id="l<?php echo $cr;?>" href="precios2.php?val=<?php echo $val?>&search=<?php echo $search?>&valform=1&codpros=<?php echo $codpro?>"><?php echo $desprod?></a></td>
                        <td width="130">
			<div align="left"><?php echo $destab?></div>
			</td>
                        <td width="50">
			<div align="left"><?php echo $stopro?></div>
			</td>
			<td width="69">
			<div align="right">
			<?php if (($valform == 1) and ($codpros == $codpro)){/*?>
			<input name="p1" type="text" id="p1" size="8" value="<?php echo $pcostouni?>" onkeypress="return decimal(event);" disabled="disabled"/>*/ ?>
			<input name="p1" type="text" id="p1" size="8" value="<?php echo $costre?>" onkeypress="return decimal(event);"/>
			<?php }
			else
			{
			echo $costre;
			}
			?>
			</div>
                        </td>
                        <td width="67">
			<div align="right">
			<?php
                        //PRECIO DE VENTA POR CAJA
                        if (($valform == 1) and ($codpros == $codpro)){?>
			    <input name="p2" type="text" id="p2" size="8" value="<?php echo $prevta?>" onkeypress="return ent(event);" onkeyup="precio()"/>
			<?php }
			else
			{
			echo $prevta;
			}
			?>
			</div>			
                        </td>
			<td width="83">
			<div align="right">
			<?php
                        //PRECIO DE VENTA POR UNIDAD
                        if (($valform == 1) and ($codpros == $codpro)){
			?>
			    <input name="p3" type="text" id="p3" size="8" value="<?php echo $preuni?>" onkeypress="return ent(event);" onkeyup="precio1();" <?php if ($factor == 1){ ?>readonly<?php } ?> />
			<?php 
			}
			else
			{
			echo $preuni;
			}
			?>
			</div>			</td>
                        <td width="60">
                        <div align="right">
			<?php 
                        if ($pcostouni == 0)
                        {
                            $pcostouni = 1;
                        }
                        if ($factor == 0)
                        {
                            $factor = 1;
                        }
                        if ($costre<> 0)
                        {
                            
    
                        $pC = (($prevta - $campo)/$campo)*100;
                        $pC = number_format($pC, 2, '.', ' ');
                        }
                        else 
                        {
                        
                            $pc=0;
                        }
			
                        
                        ////PORCENTAJE DE RENTABILIDAD POR CAJA
                        if (($valform == 1) and ($codpros == $codpro))
                        {
                            
			?>
			    <input name="pCaja" type="text" id="pCaja" size="8" value="<?php echo $pC?>" readonly/>
			<?php 
			}
			else
			{
                            echo $pC;
			}
			?>
			</div>
                        </td>
                        <td width="60">
                        <div align="right">
			<?php 
                        ////PORCENTAJE DE RENTABILIDAD POR UNIDAD
                        if ( $costre <> 0 )
                        {
                        $pU = (($preuni - ($campo/$factor))/($campo/$factor))*100;
                        $pU = number_format($pU, 2, '.', ' ');
                        }
                        
                        else
                        
                        {
                            $pu=0 ;
			            }
             //echo $factor;
                        if (($valform == 1) and ($codpros == $codpro))
                        {
			?>
                            <input name="pUNI" type="text" id="pUNI" size="8" value="<?php echo $pU?>" readonly/>
			<?php 
			}
			else
			{
                            echo $pU;
			}
			?>
			</div>
                        </td>
                        <td width="65"><div align="center">
                        <?php if (($valform == 1) and ($codpros == $codpro)){?>
                        <input name="factor" type="hidden" id="factor" value="<?php echo $factor?>" />
                        <input name="val" type="hidden" id="val" value="<?php echo $val?>" />
                        <input name="margene1" type="hidden" id="margene1" value=""/>
                        <input name="pcostouni" type="hidden" id="pcostouni" value="<?php echo $pcostouni?>" />
                        <input name="search" type="hidden" id="search" value="<?php echo $search?>" />
                        <input name="codpro" type="hidden" id="codpro" value="<?php echo $codpro?>" />
                        <input name="button" type="button" id="boton" onclick="validar_prod()" alt="GUARDAR"/>
                        <input name="button2" type="button" id="boton1" onclick="validar_grid()" alt="ACEPTAR"/>
                        <?php }
                                    else
                                    {
                                    ?>
                        <a href="precios2.php?val=<?php echo $val?>&search=<?php echo $search?>&valform=1&codpros=<?php echo $codpro?>">
                          <img src="../../../images/add1.gif" width="14" height="15" border="0"/>			  </a>
                        <?php }
                                    ?>
                        </div>
                        </td>
                </tr>
		  <?php }
		  ?>
        </table>
      <?php $cr++;
	  }
	  }
	  ?>
    </div></td>
  </tr>
</table>
</form>
</body>
</html>
