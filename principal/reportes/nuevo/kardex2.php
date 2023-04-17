<?php 
include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
require_once('../../../convertfecha.php');	//CONEXION A BASE DE DATOS
$val   			= isset($_REQUEST['val'])? ($_REQUEST['val']) : ""; 
$country_ID             = isset($_REQUEST['country_ID'])? ($_REQUEST['country_ID']) : "";
$country		= isset($_REQUEST['country'])? ($_REQUEST['country']) : "";
$date1 			= isset($_REQUEST['date1'])? ($_REQUEST['date1']) : "";
$date2 			= isset($_REQUEST['date2'])? ($_REQUEST['date2']) : "";
$report			= isset($_REQUEST['report'])? ($_REQUEST['report']) : "";
$inicio 		= isset($_REQUEST['inicio'])? ($_REQUEST['inicio']) : "";
$pagina 		= isset($_REQUEST['pagina'])? ($_REQUEST['pagina']) : "";
$tot_pag 		= isset($_REQUEST['tot_pag'])? ($_REQUEST['tot_pag']) : "";
$registros              = isset($_REQUEST['registros'])? ($_REQUEST['registros']) : "";
$local 			= isset($_REQUEST['local'])? ($_REQUEST['local']) : "";
$SoloCompras            = isset($_REQUEST['SoloCompras']) ? ($_REQUEST['SoloCompras']) : "";


$de="De Local";
$a="A Local";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $desemp?></title>
<link href="../css/style1.css" rel="stylesheet" type="text/css" /></head>
<?php 
require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUME
$sql="SELECT nomusu FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result))
{
    while ($row = mysqli_fetch_array($result))
    {
        $user    = $row['nomusu'];
    }
}
$date   = date('d/m/Y');
$hour   = date("G");   
$min    = date("i");
if ($hour <= 12)
{
    $hor    = "am";
}
else
{
    $hor    = "pm";
}
$dat1       = $date1;
$dat2       = $date2;
if (strlen($date1)>0)
{
$date1                  = fecha1($date1);
}
if (strlen($date2)>0)
{
$date2                  = fecha1($date2);
}
if ($pagina == 1)
{
$i=0;
}
else
{
$t = $pagina - 1;
$i = $t * $registros;
}
function formato($c) {
printf("%06d",$c);
} 
function convertir_a_numero($str)
{
	  $legalChars = "%[^0-9\-\. ]%";
	  $str=preg_replace($legalChars,"",$str);
	  return $str;
}
?>
<body>
<table width="930" border="0">
  <tr>
    <td width="1120">
        <table width="924" border="0">
            <tr>
                <td width="278"><strong><?php echo $desemp?> </strong></td>
                <td width="563"><div align="center"><strong>REPORTE DE KARDEX DE PRODUCTOS</strong></div></td>
                <td width="278"><div align="right"><strong>FECHA: <?php echo date('d/m/Y');?> - HORA : <?php echo $hour;?>:<?php echo $min;?> <?php echo $hor?></strong></div></td>
            </tr>
        </table>
        <table width="924" border="0">
            <tr>
                <td width="278"><strong>PAGINA <?php echo $pagina;?> de <?php echo $tot_pag?></strong></td>
                <td width="565"><div align="center"><b><?php if ($val == 1){ echo $country; }?></b></div></td>
                <td width="276"><div align="right">USUARIO:<span class="text_combo_select"><?php echo $user?></span></div></td>
            </tr>
        </table>
        <table width="924" border="0">
            <tr>
                <td>
                    <div align="center"><b>
                    <?php if ($val == 1){echo "FECHAS ENTRE :"; echo $dat1; echo " AL "; echo $dat2;}?>
                    </b>
                    </div>
                </td>
            </tr>
        </table>
        <div align="left"><img src="../../images/line2.png" width="920" height="4" /></div>
    </td>
  </tr>
</table>
<?php if ($val == 1)
{ 
    $sql="SELECT * FROM kardex where fecha between '$date1' and '$date2' and codpro = '$country_ID' and sucursal = '$local' order by fecha,codkard";

$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
$tipmovm     = $row['tipmov'];
$tipdocm     = $row['tipdoc'];

}}
?>
    
<table width="930" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td>
        <table width="924" border="0">

            <tr>
                <td width="100"><strong>FECHA</strong></td>
                <td width="65"><div align="LEFT"><strong>HORA VTA </strong></div></td>
                <td width="90"><div align="LEFT"><strong>N&ordm; INT </strong></div></td>
                <td width="220"><div align="LEFT"><strong>TIPO DE MOV </strong></div></td>
                <td width="110"><div align="LEFT"><strong>N&ordm; DOC </strong></div></td>
                <td width="220"><div align="LEFT"><strong>PROVEEDOR/CLIENTE</strong></div></td>
                
<!--    
                <td  width="<?php if ($tipmov == 2){?>100<?php }else{?>0<?php }?>"><div align="center"><?php if ($tipmov == 2){echo "<strong>DE LOCAL</strong>";}?></div></td>
                <td  width="<?php if ($tipmov == 2){?>100<?php }else{?>0<?php }?>"><div align="center"><?php if ($tipmov == 2){echo "<strong>A LOCAL</strong>";}?></div></td>
  -->
                
                <td width="100"><div align="LEFT"><strong>DE LOCAL</strong></div></td>
                <td width="100"><div align="LEFT"><strong>A LOCAL</strong></div></td>
                <td width="170"><div align="LEFT"><strong>USUARIO</strong></div></td>
                <td width="50"><div align="left"><strong>CANT</strong></div></td>
                <td width="50"><div align="right"><strong>P.COSTO</strong></div></td>
                <td width="70"><div align="right"><strong>HISTOR. STOCK </strong></div></td>
            </tr>
        </table>
    </td>
  </tr>
</table>
<table width="930" border="1" cellpadding="0" cellspacing="0">
<?php
if ($SoloCompras == 1)
{
    $sql="SELECT * FROM kardex where fecha between '$date1' and '$date2' and codpro = '$country_ID' and sucursal = '$local' and tipmov = 1 and tipdoc = 1 order by fecha,codkard";
}
else
{
    $sql="SELECT * FROM kardex where fecha between '$date1' and '$date2' and codpro = '$country_ID' and sucursal = '$local' order by fecha,codkard";
}
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    $fecha      = $row['fecha'];
    $nrodoc     = $row['nrodoc'];
    $tipmov     = $row['tipmov'];
    $tipdoc     = $row['tipdoc'];
    $qtypro     = $row['qtypro'];
    $fraccion   = $row['fraccion'];
    $factor     = $row['factor'];
    $sactual    = $row['sactual'];
     $nsactual    = $row['nsactual'];
    $invnum     = $row['invnum'];
    $preciocompra     = $row['preciocompra'];
    $eliminado     = $row['eliminado'];
    $ver	= 0;
    $car	= 0;
    //$saldoactual = 0;
    ///////////////////////////////////////////////////////////////////////////////////
    if ($tipmov == 1)
    {
        $signo = "+ ";
        $sig   = 'mas';
        if ($tipdoc == 1)
        {
        $desctip = "INGRESO POR COMPRA";
        }
        if ($tipdoc == 2)
        {
        $desctip = "INGRESO POR TRANSF DE SUCURSAL";
        }
        if ($tipdoc == 3)
        {
        $desctip = "DEVOLUCION EN BUEN ESTADO";
        }
        if ($tipdoc == 4)
        {
        $desctip = "CANJE AL LABORATORIO";
        }
        if ($tipdoc == 5)
        {
        $desctip = "OTROS INGRESOS";
        }
    }
    if ($tipmov == 2)
    {
        $signo = "- ";
        $sig   = 'menos';
        if ($tipdoc == 1)
        {
        $desctip = "SALIDAS VARIAS";
        }
        if ($tipdoc == 2)
        {
        $desctip = "GUIAS DE REMISION";
        }
        if ($tipdoc == 3)
        {
        $desctip = "SALIDA POR TRANSFERENCIA DE SUCURSAL ";
        }
        if ($tipdoc == 4)
        {
        $desctip = "CANJE PROVEEDOR ";
        }
        if ($tipdoc == 5)
        {
        $desctip = "PRESTAMOS CLIENTE ";
        }
    }
    
    ///////////////////////////////////////////////////////////////////////////////////
    if (($tipmov == 1) || ($tipmov == 2))
    {
        //$sql1="SELECT invnum,usecod,cuscod FROM movmae where invfec = '$fecha' and numdoc = '$nrodoc' and tipmov = '$tipmov' and tipdoc = '$tipdoc'";
        $sql1="SELECT invnum,invnumrecib,usecod,cuscod,tipmov,tipdoc,sucursal,sucursal1 FROM movmae where invfec = '$fecha' and invnum = '$invnum' and tipmov = '$tipmov' and tipdoc = '$tipdoc'";
        $result1 = mysqli_query($conexion,$sql1);
        if (mysqli_num_rows($result1)){
        while ($row1 = mysqli_fetch_array($result1)){
        $invnum     = $row1['invnum'];
        $invnumrecib = $row1['invnumrecib'];
        $usecod     = $row1['usecod'];
        $cuscod     = $row1['cuscod'];
       $tipmovm     = $row1['tipmov'];
       $tipdocm     = $row1['tipdoc'];
        $sucursal   = $row1['sucursal'];
        $sucursal1  = $row1['sucursal1'];
        }
        }
    }
    if ($tipmovm == 1)    
    {
     if  ($tipdocm == 2)    
     {   $sql1="SELECT sucursal FROM movmae where  invnum = '$invnumrecib' ";
        $result1 = mysqli_query($conexion,$sql1);
        if (mysqli_num_rows($result1)){
        while ($row1 = mysqli_fetch_array($result1)){
        $sucursalenv  = $row1['sucursal'];
        }
        }  
       
         
     }
    }
    if ($tipmovm == 1){
        if  ($tipdocm == 2)
            { 
            $lo1=$sucursalenv;
            }
        }else{
           $lo1=" " ;
        }
     
    if ($tipmovm == 2)    
    {
     if  ($tipdocm == 3)    
     { 
         
         $lo1=$sucursal;
     }
     }
////////////////////////////////////////////////////////
     if($lo1==0){
         $lo11="";
     }
     if($lo1==1){
         $lo11="LOCAL0";
     }
     if($lo1==2){
         $lo11="LOCAL1";
     }
     if($lo1==3){
         $lo11="LOCAL2";
     }
     if($lo1==4){
         $lo11="LOCAL3";
     }
     if($lo1==5){
         $lo11="LOCAL4";
     }
     if($lo1==6){
         $lo11="LOCAL5";
     }
     if($lo1==7){
         $lo11="LOCAL6";
     }
     if($lo1==8){
         $lo11="LOCAL7";
     }
     if($lo1==9){
         $lo11="LOCAL8";
     }
     if($lo1==10){
         $lo11="LOCAL9";
     }
     if($lo1==11){
         $lo11="LOCAL10";
     }
     if($lo1==12){
         $lo11="LOCAL11";
     }
     if($lo1==13){
         $lo11="LOCAL12";
     }
     if($lo1==14){
         $lo11="LOCAL13";
     }
     if($lo1==15){
         $lo11="LOCAL14";
     }
     if($lo1==16){
         $lo11="LOCAL15";
     }
     if($lo1==17){
         $lo11="LOCAL16";
     }
     if($lo1==18){
         $lo11="LOCAL17";
     }
     if($lo1==19){
         $lo11="LOCAL18";
     }
     if($lo1==20){
         $lo11="LOCAL19";
     }
     if($lo1==21){
         $lo11="LOCAL20";
     }
     /////////////////////////////////////
     if($sucursal1==0){
         $SU="";
     }
     if($sucursal1==1){
         $SU="LOCAL0";
     }
     if($sucursal1==2){
         $SU="LOCAL1";
     }
     if($sucursal1==3){
         $SU="LOCAL2";
     }
     if($sucursal1==4){
         $SU="LOCAL3";
     }
     if($sucursal1==5){
         $SU="LOCAL4";
     }
     if($sucursal1==6){
         $SU="LOCAL5";
     }
     if($sucursal1==7){
         $SU="LOCAL6";
     }
     if($sucursal1==8){
         $SU="LOCAL7";
     }
     if($sucursal1==9){
         $SU="LOCAL8";
     }
     if($sucursal1==10){
         $SU="LOCAL9";
     }
     if($sucursal1==11){
         $SU="LOCAL10";
     }
     if($sucursal1==12){
         $SU="LOCAL11";
     }
     if($sucursal1==13){
         $SU="LOCAL12";
     }
     if($sucursal1==14){
         $SU="LOCAL13";
     }
     if($sucursal1==15){
         $SU="LOCAL14";
     }
     if($sucursal1==16){
         $SU="LOCAL15";
     }
     if($sucursal1==17){
         $SU="LOCAL16";
     }
     if($sucursal1==18){
         $SU="LOCAL17";
     }
     if($sucursal1==19){
         $SU="LOCAL18";
     }
     if($sucursal1==20){
         $SU="LOCAL19";
     }
     if($sucursal1==21){
         $SU="LOCAL20";
     }
     
     
     
     
    
  
        $sql1="SELECT nomloc FROM xcompa WHERE codloc='$lo1'";
        $result1 = mysqli_query($conexion,$sql1);
        if (mysqli_num_rows($result1)){
        while ($row1 = mysqli_fetch_array($result1)){
       $lo1q   = $row1['nomloc'];

        }
        }
    $sql1="SELECT nomloc FROM xcompa WHERE codloc='$sucursal1'";
        $result1 = mysqli_query($conexion,$sql1);
        if (mysqli_num_rows($result1)){
        while ($row1 = mysqli_fetch_array($result1)){
        $nomloc2   = $row1['nomloc'];

        }
        }
        
    if (($tipmov == 9) || ($tipmov == 10))
    {
        //$sql1="SELECT invnum,usecod,cuscod FROM venta where invfec = '$fecha' and nrovent = '$nrodoc'";
        $sql1="SELECT invnum,usecod,cuscod,hora FROM venta where invfec = '$fecha' and invnum = '$invnum'";
        $result1 = mysqli_query($conexion,$sql1);
        if (mysqli_num_rows($result1)){
        while ($row1 = mysqli_fetch_array($result1)){
        $invnum     = $row1['invnum'];
        $usecod     = $row1['usecod'];
        $cuscod     = $row1['cuscod'];
        $hora       = $row1['hora'];
        }
        }
    }
    if (($tipmov == 11) || ($tipmov == 11))
    {
        //$sql1="SELECT invnum,usecod,cuscod FROM movmae where invfec = '$fecha' and numdoc = '$nrodoc'";
        //$sql1="SELECT invnum,usecod,cuscod FROM movmae where invfec = '$fecha' and numdoc = '$nrodoc'";
        $sql1="SELECT invnum,usecod,cuscod,sucursal,sucursal1 FROM movmae where invfec = '$fecha' and invnum = '$invnum' and tipmov = '$tipmov' and tipdoc = '$tipdoc'";
        $result1 = mysqli_query($conexion,$sql1);
        if (mysqli_num_rows($result1)){
        while ($row1 = mysqli_fetch_array($result1)){
        $invnum     = $row1['invnum'];
        $usecod     = $row1['usecod'];
        $cuscod     = $row1['cuscod'];
         $hora       = $row1['hora'];
     
        }
        }
    }
    
    

   
  
    $sql1="SELECT nomusu FROM usuario where usecod = '$usecod'";
    $result1 = mysqli_query($conexion,$sql1);
    if (mysqli_num_rows($result1))
    {
    while ($row1 = mysqli_fetch_array($result1))
    {
        $user     = $row1['nomusu'];
    }
    }
    if ($cuscod <> 0)
    {
        $sql1="SELECT descli FROM cliente where codcli = '$cuscod'";
        $result1 = mysqli_query($conexion,$sql1);
        if (mysqli_num_rows($result1)){
        while ($row1 = mysqli_fetch_array($result1)){
            $descli   = $row1['descli'];
        }
        }
    }
    else
    {
        $cudcod = 0;
        $descli ="";
    }
  ///////////////////////////////////////////////////////////////////////////////////
    if (($tipmov == 1) && ($tipdoc == 1) && ($eliminado == 1))
    {
            $signo   = "- ";
            $sig   	 = 'menos';
            $desctip = "ANULACION DE COMPRA";
            $ver	 = 1;
    }  
    if (($tipmov == 2) && ($tipdoc == 1) && ($eliminado == 1))
    {
            $signo   = "+ ";
            $sig   	 = 'mas';
            $desctip = "ANULACION DE SALIDAS VARIAS";
            $ver	 = 1;
    } 
    if (($tipmov == 2) && ($tipdoc == 3) && ($eliminado == 1))
    {
            $signo   = "+ ";
            $sig   	 = 'mas';
            $desctip = "ANULACION SALIDA POR TRANSFERENCIA";
            $ver	 = 1;
    } 
    if (($tipmov == 1) && ($tipdoc == 5) && ($eliminado == 1))
    {
            $signo   = "- ";
            $sig   	 = 'menos';
            $desctip = "ANULACION OTROS INGRESOS";
            $ver	 = 1;
    }
    if (($tipmov == 1) && ($tipdoc == 1) && ($eliminado == 3))
    {
            $signo   = "+ ";
            $sig   	 = 'mas';
            $desctip = "ACTIVACION DE COMPRA";
            $ver	 = 1;
    }  
    if (($tipmov == 1) && ($tipdoc == 5) && ($eliminado == 3))
    {
            $signo   = "+ ";
            $sig   	 = 'mas';
            $desctip = "ACTIVACION OTROS INGRESOS";
            $ver	 = 1;
    }  
    if (($tipmov == 9) && ($tipdoc == 9))
    {
            $signo   = "- ";
            $sig   	 = 'menos';
            $desctip = "VENTA";
            $ver	 = 1;
    }
    if (($tipmov == 10) && ($tipdoc == 9))
    {
            $signo = "+ ";
            $sig   = 'mas';
            $desctip = "VENTA DESHABILITADA";
            $ver	 = 1;
    }
    if (($tipmov == 10) && ($tipdoc == 10))
    {
            $signo 	 = "- ";
            $sig   	 = 'menos';
            $desctip = "VENTA HABILITADA";
            $ver	 = 1;
    }
    ////si cambia esto ojo en reporte de kardex por marca
    if (($tipmov == 11) && ($tipdoc == 11))
    {
            $signo = "+ ";
            $sig   = 'mas';
            $desctip = "INGRESO DE BONIF";
    }
    if (($tipmov == 9) && ($tipdoc == 11))
    {
            $signo   = "- ";
            $sig   	 = 'menos';
            $desctip = "VENTAS POR BONIF";
            $ver	 = 1;
    }
    error_log("Contadores: ".$factor ." " .$qtypro ." " . $descuenta ." Car: ".$car ." ".$sactual  );
    if ($factor == 1)
    {
            if ($qtypro <> "")
            {
                $cant      = $qtypro;
                $descuenta = $cant * $factor;
                $car	   = $descuenta;
                $cant_desc = "C".$cant;
            }
            //echo $qtypro;
            if ($fraccion <> "")
            {
                $cant      = convertir_a_numero($fraccion);
                $descuenta = $cant;
                $car	   = $descuenta;
                $cant_desc = "C".$cant;
            }
    }
    else
    {
        if ($qtypro <> "")
        {
            $cant      = $qtypro;
            $descuenta = $cant * $factor;
            $car	   = $descuenta;
            $cant_desc = "C".$cant;
        }
        //echo $qtypro;
        if ($fraccion <> "")
        {
            $cant      = convertir_a_numero($fraccion);
            $descuenta = $cant;
            $car	   = $descuenta;
            $cant_desc = "f".$cant;
        }
    }
    error_log("Contadores: ".$factor ." " .$qtypro ." " . $descuenta ." Car: ".$car ." ".$sactual  );
    if ($sig == 'mas')
    {
        //$saldoactual = $car + $saldoactual;
        $saldoactual = $car + $sactual;
    }
    else
    {
        //$saldoactual = $saldoactual - $car;
        $saldoactual = $sactual - $car;
    }
    if ($ver == 1)
    {
        $dir = 'ver_venta_usu.php?invnum='.$invnum;
    }
    else
    {
        $dir = 'ver_movimiento1.php?invnum='.$invnum;
    }
    
    $convert1 = $saldoactual/$factor;
    $div1    	= floor($convert1);
    $UNI1 = ($saldoactual-($div1*$factor));
    
    
    $convert2 = $nsactual/$factor;
    $div2    	= floor($convert2);
    $UNI2 = ($nsactual-($div2*$factor));
?>
    <tr>
        <td width="50"><?php echo fecha($fecha)?></td>
        <td width="74"><?php echo $hora?></td>
        <td width="60">
            <a href="javascript:popUpWindow('<?php echo $dir?>', 10, 50, 1000, 350)">
            <?php echo formato($invnum);?></a>
        </td>
        <td width="125"><div align="left"><?php echo $desctip?></div></td>
        <td width="85"><div align="left"><?php echo formato($nrodoc);?></div></td>
        <td width="190"><div align="left"><?php echo substr($descli,0,70);?></div></td>
   
              
        <td width="100"><div align="left"><?php   if ($tipmovm == 1){
        if  ($tipdocm == 2)
            { echo $lo11;}}if ($tipmovm == 2){
        if  ($tipdocm == 3)
            { echo $lo11;}}?></div></td>
        <td width="100"><div align="left"><?php if ($tipmovm == 2){
        if  ($tipdocm == 3)
            { echo $SU;}}?></div></td>
        
        
        <td width="140"><div align="left"><?php echo substr($user,0,70)?></div></td>
        <td width="55"><div align="right"><?php echo $signo; echo $cant_desc?></div></td>
        <td width="70"><div  align="right"><?php echo $preciocompra;?></div></td>
       <td width="75"><div align="right"><?php echo $div1."C" ." ". $UNI1;?></div></td>
       <!--<td width="75"><div align="right"><?php echo $div2."C" ." ". $UNI2;?></div></td>-->
        
    </tr>
    <?php 
        }
    }
    else
    {
    ?>
        <center><br /><br /><br /><br />NO SE PUDO ENCONTRAR INFORMACION CON LOS DATOS INGRESADOS</center>
    <?php 
    }
    ?>
</table>
<?php 
}
?>
</body>
</html>
