<?php include('../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="css/style1.css" rel="stylesheet" type="text/css" />
<link href="css/tablas.css" rel="stylesheet" type="text/css" />
<?php require_once('../../conexion.php');    //CONEXION A BASE DE DATOS
require_once("../../funciones/functions.php");    //DESHABILITA TECLAS
require_once("../../funciones/funct_principal.php");    //IMPRIMIR-NUME
require_once('../../convertfecha.php');    //CONEXION A BASE DE DATOS
$hour   = date(G);
//$date	= CalculaFechaHora($hour);
$date = date("Y-m-d");
//$hour   = CalculaHora($hour);
$min    = date(i);
if ($hour <= 12) {
    $hor    = "am";
} else {
    $hor    = "pm";
}
$codpro = $_REQUEST['codp'];
$date1 = $_REQUEST['date1'];
$date2 = $_REQUEST['date2'];
$d1 = fecha1($_REQUEST['date1']);
$d2 = fecha1($_REQUEST['date2']);
$local = $_REQUEST['local'];
function formato($c)
{
    printf("%08d",  $c);
}
function formato1($c)
{
    printf("%06d",  $c);
}
$date = date('d/m/Y');
$hour = date("G") - 5;
$hour = CalculaHora($hour);

$sql = "SELECT desprod,codmar FROM producto where codpro = '$codpro' and eliminado='0'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $desprod    = $row['desprod'];
        $codmar    = $row['codmar'];
    }
}
  $sql2 = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar'";
                $result2 = mysqli_query($conexion,$sql2);
                if (mysqli_num_rows($result2)) {
                    while ($row2 = mysqli_fetch_array($result2)) {
                        $destab = $row2['destab'];
                        $abrev = $row2['abrev'];
                        if ($abrev <> '') {
                            $destab = $abrev;
                        }
                    }
                }
$sql = "SELECT nomusu,codloc,usecod FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nomusu    = $row['nomusu'];
        $codloc    = $row['codloc'];
        $usecod    = $row['usecod'];
    }
}
$sql = "SELECT nomloc,nombre FROM xcompa where codloc = '$codloc'";
$result = mysqli_query($conexion, $sql);
while ($row = mysqli_fetch_array($result)) {
    $nloc    = $row["nomloc"];
    $nombre    = $row["nombre"];
    if ($nombre == '') {
        $locals = $nloc;
    } else {
        $locals = $nombre;
    }
}

?>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;

        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 3px;

        }

        #customers tr:nth-child(even) {
            background-color: #f0ecec;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {

            text-align: center;
            background-color: #50ADEA;
            color: white;
            font-size: 12px;
            font-weight: 900;
        }
    </style>
    <title>RENTABILIDAD DE VENTA</title>

</head>

<body>
    <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td width="922">
                <table width="100%" border="0" align="center">
                    <tr>
                        <td width="85"><strong>COD VENDEDOR </strong></td>
                        <td width="81"><?php echo formato1($usecod) ?></td>
                        <td width="65">
                            <div align="left"><strong>VENDEDOR</strong></div>
                        </td>
                        <td width="586"><?php echo $nomusu ?></td>
                        <td width="20"><strong>FECHA</strong></td>
                        <td width="78"><?php echo $date ?></td>
                        <td width="100" align="right"><strong>LOCAL</strong></td>
                        <td width="50"><?php echo $locals ?></td>
                    </tr>
                </table>
                <table width="100%" border="0">
                    <tr>
                        <td width="80">
                            <strong>
                                <H3>PRODUCTO :</H3>
                            </strong>
                        </td>
                        <td align="left">&nbsp;&nbsp;&nbsp;<?php echo $codpro."-- :".$desprod ?></td>
                        <td width="80">
                            <strong>
                                <H3>MARCA :</H3>
                            </strong>
                        </td>
                        <td align="left">&nbsp;&nbsp;&nbsp;<?php echo $destab ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>



    <?php $i = 0;
    $precio_costo = 0;
    $nrooperacion = 0;
    $canprod1 = 0;
    $canprod = 0;
    $tot = 0;
    $sumpripro = 0;
    $sumpcosto = 0.01;
    $rentabilidad = 0;
    $SumPorcent = 0;
    $pripro = 0;
    $sumcostpr = 0;
    $canprodsinfac = 0;
    //	$sql="SELECT codpro,canpro,fraccion,factor,prisal,pripro,cospro,codmar FROM detalle_venta where invnum = '$invnum'";
     if ($local == 'all') {
    $sql = "SELECT V.invnum,V.nrovent,V.invfec,V.nrofactura,V.valven,DV.canpro,DV.fraccion,DV.factor,DV.prisal,DV.costpr,DV.pripro,DV.cospro,DV.codmar FROM venta as V INNER JOIN detalle_venta AS DV  ON  DV.invnum=V.invnum  where  V.invfec between '$date1' and '$date2' AND DV.codpro = '$codpro' and V.val_habil='0' ";
     }else{
         $sql = "SELECT V.invnum,V.nrovent,V.invfec,V.nrofactura,V.valven,DV.canpro,DV.fraccion,DV.factor,DV.prisal,DV.costpr,DV.pripro,DV.cospro,DV.codmar FROM venta as V INNER JOIN detalle_venta AS DV  ON  DV.invnum=V.invnum  where  V.invfec between '$date1' and '$date2' AND DV.codpro = '$codpro'  and V.sucursal = '$local' and V.val_habil='0'";
     }
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        ?>
        <table width="100%" border="0" align="center" id="customers">
            <tr>
                <th width="34"><strong>N&ordm;</strong></th>
                <th><strong>INVNUM</strong></th>
                <th><strong>FECHA</strong></th>
                <th><strong>N&ordm; DOCUMENTO</strong></th>
                <th>
                    <div align="CENTER"><strong>CANTIDAD</strong></div>
                </th>
                <th width="70">
                    <div align="CENTER"><strong>PRECIO VENTA </strong></div>
                </th>
                <th width="70">
                    <div align="CENTER"><strong>COSTO PROMEDIO </strong></div>
                </th>
                <th width="70">
                    <div><strong>MONTO VENTA</strong></div>
                </th>
                <th>
                    <div align="right"><strong>UTILIDAD SOLES</strong></div>
                </th>
                <th width="100">
                    <div align="right"><strong>% UTILIDAD</strong></div>
                </th>
            </tr>
            <?php while ($row = mysqli_fetch_array($result)) {
                    $invnum     = $row['invnum'];
                    $nrovent    = $row['nrovent'];
                    $invfec     = $row['invfec'];
                    $nrofactura = $row['nrofactura'];
                    $canpro     = $row['canpro'];
                    $valven     = $row['valven'];
                    $fraccion   = $row['fraccion'];
                    $factor     = $row['factor'];
                    $prisal     = $row['prisal'];
                    //$pripro     = $row['pripro'];
                    $prispro2     += $row['pripro'];
                    $cospro     = $row['cospro'];
                    $codmar     = $row['codmar'];
                    $costpr     = $row['costpr'];
                    
                    $pripro = $prisal * $canpro;
                    $pripro2 = $pripro2 + $pripro;
                    
                    if ($factor <> 1){
                     if ($fraccion == "T") {
                         $canproTI=$canpro."U" ;
                     }else{
                         $canproTI=$canpro."C" ;
                     }
                    }else{
                        $canproTI=$canpro."C" ;
                    }
                    if ($costpr <= 0) {
                        $costpr = 0.01;
                    }
                    if ($factor <> 1) {
                        if ($fraccion == "T") {
                            $canprod        = $canpro;
                            $tot            = $canpro;
                            $precio_costo   = $costpr;
                        } else {
                            $canprod1       = $canpro;

                            $canpros        = $canpro * $factor;
                            $tot            = $canpros;
                            $precio_costo   = $costpr / $factor;
                        }
                    } else {

                        $canprodsinfac  =  $canpro;
                        $sumcostpr =  $costpr;
                    }
                    if ($factor <> 1) {
                        $c = $canprod1 * $factor;
                        $f = $canprod;
                        $suma = $canpro;
                        $sumpcosto = ($costpr * $suma);
                    } else {
                        
                        $sumpcosto = ($costpr * $canpro);
                    }
                    $prisalsum= $prisalsum +$prisal;
                   
                    $sumpripro = $pripro;
                    
                    $rentabilidad     = $prisal - $costpr;
                    if ($factor <> 1) {
                        if ($fraccion == "T") {
                            $canprod        = $canpro;
                            $rentabilidad2 = $rentabilidad * $canprod;
                            $costpr2= $costpr * $canprod;
                        }else{
                            $canprod        = $canpro * $factor;
                            $rentabilidad2 = $rentabilidad * $canprod;
                            $costpr2= $costpr * $canprod;
                        }
                        
                    }else{
                        $canprod        = $canpro;
                        $rentabilidad2 = $rentabilidad * $canprod;
                        $costpr2= $costpr * $canprod;
                    }    
                    
                     $costprsum= $costprsum +$costpr2;
                     
                    $porcentaje     = ($rentabilidad / $costpr) * 100;
                    
                    $sumgenpripro 	= $sumgenpripro + $pripro;
                    $sumgenpcosto 	= $sumgenpcosto + $sumpcosto;
                    $trentabilidad 	= $sumgenpripro - $sumgenpcosto;
                    
                    $trentabilidad2 = $trentabilidad2 + $rentabilidad2;
                    $tporcentaje 	= ($trentabilidad2 / $costprsum) * 100;
                             
                    $sql1 = "SELECT destab FROM titultabladet where codtab = '$codmar'";
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $destab    = $row1['destab'];
                        }
                    }
                    $i++;
                    ?>
                <tr height="25" <?php if ($datDSDe2) { ?> bgcolor="#ff0000" <?php } else { ?>onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';" <?php } ?>>
                    <td align="CENTER" width="34"><?php echo $i ?></td>
                    <td align="CENTER"><?php echo $invnum ?></td>
                    <td align="CENTER"><?php echo fecha($invfec) ?></td>
                    <td align="CENTER"><?php echo $nrofactura ?></td>
                    <td>
                        <div align="CENTER"><?php echo $canproTI ?></div>
                    </td>
                    <td>
                        <div align="CENTER"><?php echo $prisal ?></div>
                    </td>
                     <td  bgcolor="#fafafa">
                        <div align="right"><?php echo $numero_formato_frances = number_format($pripro, 2, '.', ' '); ?> </div>
                    </td>
                    <td>
                        <div align="CENTER"><?php echo $costpr2 ?></div>
                    </td>
                    
                    
                   
                    <td>
                        <div align="right"><?php echo $numero_formato_frances = number_format($rentabilidad2 , 2, '.', ' '); ?> </div>
                    </td>
                    <td>
                        <div align="right"><?php echo $numero_formato_frances = number_format($porcentaje, 2, '.', ' '); ?> %</div>
                    </td>
                </tr>
            <?php }

                ?>
            <tr bgcolor="#dedeca">
                <td width="150" COLSPAN="5" align="CENTER"><strong>TOTAL</strong></td>
                <td width="40">
                    <!--<div align="center"><?php echo $numero_formato_frances = number_format($prisalsum, 2, '.', ' '); ?></div>-->
                </td>
                 <td width="20">
                    <div align="right"><?php echo $numero_formato_frances = number_format($pripro2, 2, '.', ' '); ?></div>
                </td>
                <td width="40">
                    <div align="center"><?php echo $numero_formato_frances = number_format($costprsum, 2, '.', ' '); ?></div>
                </td>
               
                <td width="20">
                    <div align="right"><?php echo $numero_formato_frances = number_format($trentabilidad2, 2, '.', ' '); ?></div>
                </td>
                <td width="20">
                    <div align="right"><?php echo $numero_formato_frances = number_format($tporcentaje, 2, '.', ' ')."%"; ?></div>
                </td>
            </tr>
        </table>
    <?php }
    ?>


    <!--<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
        <table width="100%" border="0" align="center">
      <tr>
        <td width="150" align="CENTER"><strong>TOTAL</strong></td>
        <td width="20"><div align="right"><?php echo $numero_formato_frances = number_format($pripro2, 2, '.', ' '); ?></div></td>
      </tr>
    </table></td>
  </tr>
</table>-->
</body>

</html>