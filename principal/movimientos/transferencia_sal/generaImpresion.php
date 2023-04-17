<?php 
include('../../session_user.php');
require_once ('../../../conexion.php');
$CCompra = $_REQUEST['Compra'];
?>
<html>
<head><meta charset="windows-1252"> 
<script>
function imprimir()
{
    var f = document.form1;
    window.print();
    f.action = "../ing_salid.php";
    f.method = "post";
    f.submit();
}
</script>
<style>
    body, table
    {
        font-size:12px;
        /*//font-weight: bold;*/
    }
</style>
</head>
<body onload="imprimir()">
    <form name="form1" id="form1">
    <?php 
    function cambiarFormatoFecha($fecha)
    {
        list($anio,$mes,$dia) = explode("-",$fecha);
        return $dia."-".$mes."-".$anio;
    }
    $HoraActual = DATE("H:i");
    $Usuario    = "";
    $Sucursal   = "";
    $Proveedor  = "";
    $sqlCompras = "SELECT numdoc,invfec,usecod,sucursal,sucursal1,refere,cuscod,forpag,numero_documento,numero_documento1,incluidoIGV,plazo,fecven,invtot,igv,valven,destot,costo FROM movmae where invnum = '$CCompra'";
    $resultCompras = mysqli_query($conexion, $sqlCompras);
    if (mysqli_num_rows($resultCompras)) 
    {
        while ($row = mysqli_fetch_array($resultCompras))
        {
            $invnum     = $row['numdoc'];
            $invfec     = $row['invfec'];
            $usecod     = $row['usecod'];
            $sucursal   = $row['sucursal'];
            $sucursal1  = $row['sucursal1'];
            $cuscod     = $row['cuscod'];
            $forpag     = $row['forpag'];
            $numdoc     = $row['numero_documento'];
            $numdoc1    = $row['numero_documento1'];
            $incluidoIGV= $row['incluidoIGV'];
            $plazo      = $row['plazo'];
            $fecven     = $row['fecven'];
            $invtot     = $row['invtot'];
            $igv        = $row['igv'];
            $valven     = $row['valven'];
            $destot     = $row['destot'];
            $costo      = $row['costo'];
            $refere     = $row['refere'];
            if ($incluidoIGV == 1)
            {
                $incluidoIGV = "SI";
            }
            else
            {
                $incluidoIGV = "NO";
            }
            $sqlUsu     = "SELECT nomusu FROM usuario where usecod = '$usecod'";
            $resultUsu = mysqli_query($conexion, $sqlUsu);
            if (mysqli_num_rows($resultUsu)) 
            {
                while ($row = mysqli_fetch_array($resultUsu))
                {
                    $Usuario     = $row['nomusu'];
                }
            }
            $sqlProv     = "SELECT despro FROM proveedor where codpro = '$cuscod'";
            $resultProv  = mysqli_query($conexion, $sqlProv);
            if (mysqli_num_rows($resultProv)) 
            {
                while ($row = mysqli_fetch_array($resultProv))
                {
                    $Proveedor     = $row['despro'];
                }
            }
            $sqlSuc     = "SELECT nomloc FROM xcompa where codloc = '$sucursal'";
            $resultSuc = mysqli_query($conexion, $sqlSuc);
            if (mysqli_num_rows($resultSuc)) 
            {
                while ($row = mysqli_fetch_array($resultSuc))
                {
                    $Sucursal     = $row['nomloc'];
                }
            }
            $sqlSuc1     = "SELECT nomloc FROM xcompa where codloc = '$sucursal1'";
            $resultSuc1 = mysqli_query($conexion, $sqlSuc1);
            if (mysqli_num_rows($resultSuc1)) 
            {
                while ($row = mysqli_fetch_array($resultSuc1))
                {
                    $Sucursal1     = $row['nomloc'];
                }
            }
        }
    ?>
        <table style="width: 100%">
            <tr>
                <th style="text-align:left">Tipo de Movimiento</th>
                <td colspan="9">SALIDA POR TRANSFERENCIA DE DROGUERIA A SUCURSAL</td>
            </tr>
            <tr>
                <th style="text-align:left">N°</th>
                <td><?php echo $invnum;?></td>
                <th style="text-align:left">Fecha</th>
                <td><?php echo $invfec;?></td>
                <th style="text-align:left">Hora</th>
                <td><?php echo $HoraActual;?></td>
                <th style="text-align:left">Res</th>
                <td><?php echo $Usuario;?></td>
                <th style="text-align:left">Local</th>
                <td><?php echo $Sucursal;?></td>
            </tr>
            <tr>
                <th style="text-align:left">Para</th>
                <td><?php echo $Sucursal1;?></td>
                <th style="text-align:left">Pedido por:</th>
                <td colspan="3"><?php echo $Usuario;?></td>
                <th style="text-align:left">Referencia</th>
                <td><?php echo $refere;?></td>
            </tr>
        </table>
        <br>
        <?php 
        $sqlComprasMov = "SELECT qtypro,codpro,prisal,desc1,desc2,desc3,pripro,costre FROM movmov where invnum = '$CCompra'";
        $resultComprasMov = mysqli_query($conexion, $sqlComprasMov);
        if (mysqli_num_rows($resultComprasMov)) 
        {
        ?>
        <hr>
        <hr>
        <table style="width: 100%">
            <tr>
                <th style="text-align:left">Cantidad</th>
                <th style="text-align:right">Producto</th>
                <th style="text-align:left">Laboratorio / Marca</th>
                <th style="text-align:right">Precio Unit</th>
                <th style="text-align:right">Sub Total</th>
            </tr>
        <?php
            while ($row = mysqli_fetch_array($resultComprasMov))
            {
                $qtypro     = $row['qtypro'];
                $codpro     = $row['codpro'];
                $prisal     = $row['prisal'];
                $desc1      = $row['desc1'];
                $desc2      = $row['desc2'];
                $desc3      = $row['desc3'];
                $pripro     = $row['pripro'];
                $costre     = $row['costre'];
                $Producto   = "";
                $Marca      = "";
                $sqlProd    = "SELECT P.desprod,M.destab FROM producto P LEFT JOIN titultabladet M ON M.codtab = P.codmar AND P.codpro = '$codpro'";
                $resultProd = mysqli_query($conexion, $sqlProd);
                if (mysqli_num_rows($resultProd)) 
                {
                    while ($row = mysqli_fetch_array($resultProd))
                    {
                        $Producto     = $row['desprod'];
                        $Marca        = $row['destab'];
                    }
                }
            ?>
            <tr>
                <td><?php echo $qtypro;?></td>
                <td style="text-align: right;"><?php echo $Producto;?></td>
                <td><?php echo $Marca;?></td>
                <td style="text-align: right;"><?php echo $pripro;?></td>
                <td style="text-align: right;"><?php echo $costre;?></td>
            </tr>
            <?php
            }
        ?>
        </table>
        <?php
        }
        ?>
    <?php 
    }
    ?>
    </form>
</body>
</html>