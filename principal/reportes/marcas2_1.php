<?php
require_once('../../conexion.php');    //CONEXION A BASE DE DATOS
//require_once("../../funciones/calendar.php");
require_once('../../funciones/highlight.php');
require_once("../../funciones/functions.php");    //DESHABILITA TECLAS
require_once("../../funciones/funct_principal.php");    //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
require_once("../../funciones/botones.php");    //COLORES DE LOS BOTONES
require_once("local.php");    //OBTENGO EL NOMBRE Y CODIGO DEL LOCAL
require_once("local.php");    //OBTENGO EL NOMBRE Y CODIGO DEL LOCAL


require_once('../../titulo_sist.php');
require_once('../../convertfecha.php');    //CONEXION A BASE DE DATOS




$sqlP = "SELECT precios_por_local FROM datagen";
$resultP = mysqli_query($conexion, $sqlP);
if (mysqli_num_rows($resultP)) {
    while ($row = mysqli_fetch_array($resultP)) {
        $precios_por_local = $row['precios_por_local'];
    }
}
if ($precios_por_local  == 1) {
    require_once '../../precios_por_local.php';
}





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
    <style type="text/css">
        body,
        table {
            line-height: 80%
        }

        .letras {
            font-size: 21px;
            font-weight: 900px;
        }

        .letras1 {
            font-size: 12px;
            font-weight: 900px;
        }

        .letras12 {
            font-size: 17px;

            font-weight: 700px;

        }

        .letras121 {
            font-size: 15px;

            font-weight: 500px;

        }
    </style>
    <style>
        body,
        table {
            font-family: courier;
            font-size: 6px;
            font-weight: normal;
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

    <script>
        function printLayer(Layer) {
            var generator = window.open(",'name,'");
            var layertext = document.getElementById(Layer);
            generator.document.write(layertext.innerHTML.replace("Print Me"));
            generator.document.close();
            generator.print();
            generator.close();



        }
    </script>
    <?php
    $sql = "SELECT nomusu FROM usuario where usecod = '$usuario'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $user    = $row['nomusu'];
        }
    }
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
    $val    = $_REQUEST['val'];
    $tipo   = $_REQUEST['tipo'];
    $tipo1  = $_REQUEST['tipo1'];
    $ltdgen = $_REQUEST['ltdgen'];
    $local  = $_REQUEST['local'];
    $inicio = $_REQUEST['inicio'];
    $pagina = $_REQUEST['pagina'];
    $tot_pag = $_REQUEST['tot_pag'];
    $tot_pag2 = $_REQUEST['total_paginas'];
    $registros  = $_REQUEST['registros'];
    $marca1     = $_REQUEST['marca1'];
    $marca2     = $_REQUEST['marca2'];

    /*
echo $val. "       "."val"."<br>";
echo $tipo. "      "."tipo"."<br>";
echo $tipo1. "  "."tipo1"."<br>";
echo $ltdgen. "     "."ltdgen"."<br>";
echo $local. "     "."local"."<br>";
echo $inicio. "     "."inicio"."<br>";
echo $pagina. "    "."pagina"."<br>";
echo $tot_pag. "    "."tot_pag"."<br>";
echo $tot_pag2. "     "."tot_pag2"."<br>";
echo $registros. "    "."registros"."<br>";
echo $marca1. "        "."marca1"."<br>";
echo $marca2. "           "."marca2"."<br>";
echo $tabla. "           "."tabla"."<br>";

*/

    if ($pagina == 1) {
        $i = 0;
    } else {
        $t = $pagina - 1;
        $i = $t * $registros;
    }
    //if ($local <> 'all')
    //{
    //require_once("datos_generales.php");	//COGE LA TABLA DE UN LOCAL
    //}
    if ($tipo == 1) {
        $t = "L. DE PRECIOS";
    }
    if ($tipo == 2) {
        $t = "L. DE STOCKS";
    }
    if ($tipo == 3) {
        $t = "FOR DE INVENTARIOS";
    }


    if ($tipo1 == 1) {
        $t1 = "TODOS LOS PRODUCTOS";
    }
    if ($tipo1 == 2) {
        $t1 = "SOLO PRODUCTOS CON STOCK";
    }
    if ($tipo1 == 3) {
        $t1 = "PRODUCTOS CON STOCK MINIMO";
    }
    if ($tipo1 == 4) {
        $t1 = "PRODUCTOS SIN STOCK MINIMO";
    }
    if ($tipo1 == 5) {
        $t1 = "PRODUCTOS CON STOCK Y CON STOCK MINIMO";
    }
    if ($tipo1 == 6) {
        $t1 = "PRODUCTOS CON STOCK Y SIN STOCK MINIMO";
    }
    if ($tipo1 == 7) {
        $t1 = "SOLO PRODUCTOS SIN STOCK";
    }



    $hour  = date(G);
    //$hour   = CalculaHora($hour);
    $min    = date(i);
    if ($hour <= 12) {
        $hor    = "am";
    } else {
        $hor    = "pm";
    }
    if ($local <> 'all') {
        $sql = "SELECT nomloc,nombre FROM xcompa where codloc = '$local'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $nomloc    = $row["nomloc"];
                $nombre    = $row["nombre"];
                if ($nombre == '') {
                    $locals = $nloc;
                } else {
                    $locals = $nombre;
                }
            }
            if ($nomloc == "LOCAL0") {
                $tabla = 's000';
            }
            if ($nomloc == "LOCAL1") {
                $tabla = 's001';
            }
            if ($nomloc == "LOCAL2") {
                $tabla = 's002';
            }
            if ($nomloc == "LOCAL3") {
                $tabla = 's003';
            }
            if ($nomloc == "LOCAL4") {
                $tabla = 's004';
            }
            if ($nomloc == "LOCAL5") {
                $tabla = 's005';
            }
            if ($nomloc == "LOCAL6") {
                $tabla = 's006';
            }
            if ($nomloc == "LOCAL7") {
                $tabla = 's007';
            }
            if ($nomloc == "LOCAL8") {
                $tabla = 's008';
            }
            if ($nomloc == "LOCAL9") {
                $tabla = 's009';
            }
            if ($nomloc == "LOCAL10") {
                $tabla = 's010';
            }
            if ($nomloc == "LOCAL11") {
                $tabla = 's011';
            }
            if ($nomloc == "LOCAL12") {
                $tabla = 's012';
            }
            if ($nomloc == "LOCAL13") {
                $tabla = 's013';
            }
            if ($nomloc == "LOCAL14") {
                $tabla = 's014';
            }
            if ($nomloc == "LOCAL15") {
                $tabla = 's015';
            }
            if ($nomloc == "LOCAL16") {
                $tabla = 's016';
            }
            if ($nomloc == "LOCAL17") {
                $tabla = 's017';
            }
            if ($nomloc == "LOCAL18") {
                $tabla = 's018';
            }
            if ($nomloc == "LOCAL19") {
                $tabla = 's019';
            }
            if ($nomloc == "LOCAL20") {
                $tabla = 's020';
            }
        }
    }
    $dat1 = $date1;
    $dat2 = $date2;
    $date1 = fecha1($dat1);
    $date2 = fecha1($dat2);




    ?>


    <div class="pagina">
        <table width="100%" border="0" align="center">
            <tr>
                <td>

                    <table width="100%" height="50" border="0">
                        <tr class="letras12">
                            <td class="letras12" align="center" height="20"><strong>
                                    <pre><?php echo $desemp ?></pre>
                                </strong></td>

                            <td class="letras12">
                                <div class="letras12" align="center">
                                    <strong>
                                        <pre>FECHA </pre>
                                    </strong>

                                    <strong>
                                        <pre> <?php echo date('d/m/Y'); ?></pre>
                                    </strong>

                                </div>
                            </td>
                        </tr>
                        <tr>

                            <td colspan="2" class="letras121" height="70">
                                <div align="center" class="letras121">
                                    <strong>REPORTE DE MARCAS</strong>
                                </div>
                                <div class="letras121">
                                    <strong>
                                        <pre><?php echo $t ?> - <?php echo $t1 ?> - <?php if ($local == 'all') {
                                                                                        echo 'TODOS LOS LOCALES';
                                                                                    } else {
                                                                                        echo $nomloc;
                                                                                    } ?></pre>
                                    </strong>
                                </div>
                            </td>
                        </tr>


                    </table>
                </td>

            </tr>
        </table>

        <?php if ($val == 1) {
            if ($local <> 'all') {
        ?>

                <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <?php
                            if ($tipo1 == 1) {
                                //$sql="SELECT desprod,codmar,stopro,prevta,$tabla,factor FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where destab between '$marca1' and '$marca2' order by codpro LIMIT $inicio, $registros";
                                $sql = "SELECT codpro,desprod,codmar,stopro,prevta,$tabla as stoprotab,factor FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where destab between '$marca1' and '$marca2' and producto.eliminado='0' order by abrev,desprod,codpro";
                            }
                            if ($tipo1 == 2) {
                                //$sql="SELECT desprod,codmar,stopro,prevta,$tabla,factor FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla > 0 and destab between '$marca1' and '$marca2' order by codpro LIMIT $inicio, $registros";
                                $sql = "SELECT codpro,desprod,codmar,stopro,prevta,$tabla as stoprotab,factor FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla > 0 and destab between '$marca1' and '$marca2' and producto.eliminado='0' order by abrev,desprod,codpro";
                            }
                            if ($tipo1 == 3) {
                                //$sql="SELECT desprod,codmar,stopro,prevta,$tabla,factor FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla1 > 0 and destab between '$marca1' and '$marca2' order by desprod LIMIT $inicio, $registros";
                                $sql = "SELECT codpro,desprod,codmar,stopro,prevta,$tabla as stoprotab,factor FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla1 > 0 and destab between '$marca1' and '$marca2' and producto.eliminado='0' order by abrev,desprod,codpro";
                            }
                            if ($tipo1 == 4) {
                                //$sql="SELECT desprod,codmar,stopro,prevta,$tabla,factor FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla1 = 0 and destab between '$marca1' and '$marca2' order by desprod LIMIT $inicio, $registros";
                                $sql = "SELECT codpro,desprod,codmar,stopro,prevta,$tabla as stoprotab,factor FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla1 = 0 and destab between '$marca1' and '$marca2' and producto.eliminado='0' order by abrev,desprod,codpro";
                            }
                            if ($tipo1 == 5) {
                                //$sql="SELECT desprod,codmar,stopro,prevta,$tabla,factor FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla > 0 and $tabla1 > 0 and destab between '$marca1' and '$marca2' order by codpro LIMIT $inicio, $registros";
                                $sql = "SELECT codpro,desprod,codmar,stopro,prevta,$tabla as stoprotab,factor FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla > 0 and $tabla1 > 0 and destab between '$marca1' and '$marca2' and producto.eliminado='0' order by abrev,desprod,codpro";
                            }
                            if ($tipo1 == 6) {
                                //$sql="SELECT desprod,codmar,stopro,prevta,$tabla,factor FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla > 0 and $tabla1 = 0 and destab between '$marca1' and '$marca2' order by codpro LIMIT $inicio, $registros";
                                $sql = "SELECT codpro,desprod,codmar,stopro,prevta,$tabla as stoprotab,factor FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla > 0 and $tabla1 = 0 and destab between '$marca1' and '$marca2' and producto.eliminado='0' order by abrev,desprod,codpro";
                            }
                            if ($tipo1 == 7) {
                                //$sql="SELECT desprod,codmar,stopro,prevta,$tabla,factor FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla > 0 and destab between '$marca1' and '$marca2' order by codpro LIMIT $inicio, $registros";
                                $sql = "SELECT codpro,desprod,codmar,stopro,prevta,$tabla as stoprotab,factor FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla > 0 and stopro<=0 and destab between '$marca1' and '$marca2' and producto.eliminado='0' order by abrev,desprod,codpro";
                            }
                            //echo $tipo1.$sql;
                            $result = mysqli_query($conexion, $sql);
                            if (mysqli_num_rows($result)) {
                            ?>
                                <table width="100%" border="0" align="center">
                                    <tr height="25" style="border: 1px; ">

                                        <th colspan="3" class="letras">
                                            <div align="center" style="border: 1px; "><strong>PRODUCTO</strong></div>
                                        </th>


                                        <!-- <th   style="border: 1px; " class="letras" ><div align="center"><strong>Cajas/Sueltas</strong></div></th>-->




                                    </tr>

                                    <?php while ($row = mysqli_fetch_array($result)) {
                                        $codpro    = $row['codpro'];
                                        $producto    = $row['desprod'];
                                        $marca       = $row['codmar'];
                                        $stopro      = $row['stopro'];

                                        $factor      = $row['factor'];
                                        //		$codcatp     = $row['codcatp'];
                                        $stopro      = $row['5'];
                                        $stopro      = $row['stoprotab'];



                                        if (($zzcodloc == 1) && ($precios_por_local == 1)) {
                                            $prevta      = $row['prevta'];
                                        } elseif ($precios_por_local == 0) {
                                            $prevta      = $row['prevta'];
                                        }

                                        if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                                            $sql_precio = "SELECT $prevta_p  FROM precios_por_local where codpro = '$codpro'";
                                            $result_precio = mysqli_query($conexion, $sql_precio);
                                            if (mysqli_num_rows($result_precio)) {
                                                while ($row_precio = mysqli_fetch_array($result_precio)) {
                                                    $prevta      = $row_precio[0];
                                                }
                                            }
                                        }


                                        if ($tipo == 3) {
                                            $calc1 = $stopro / $factor;
                                            $calc2 = $stopro % $factor;
                                            $calc1 = explode(".", $calc1);
                                            $calc1 = $calc1[0];
                                        }

                                        $convert1 = $stopro / $factor;
                                        $caja = ((int) ($convert1));
                                        $unidad = ($stopro - ($caja * $factor));



                                        if ($tipo == 2) {
                                            if ($factor > 1) {
                                                $convert1       = $stopro / $factor;
                                                $div1           = floor($convert1);
                                                $mult1          = $factor * $div1;
                                                $tot1           = $stopro - $mult1;
                                                $stopro         = $div1 . ' F ' . $tot1;
                                            }
                                        }
                                        ///////MARCA
                                        ///////MARCA
                                        $sql1 = "SELECT destab,abrev FROM titultabladet where codtab = '$marca'";
                                        $result1 = mysqli_query($conexion, $sql1);
                                        if (mysqli_num_rows($result1)) {
                                            while ($row1 = mysqli_fetch_array($result1)) {
                                                $destab = $row1['destab'];
                                                $abrev = $row1['abrev'];
                                                if ($abrev <> '') {
                                                    $destab = $abrev;
                                                }
                                            }
                                        }
                                        $i++;
                                    ?>
                                        <tr class="letras1">

                                            <td colspan='3' style="line-height: normal"><strong><?php echo   $producto; ?></strong> </td>

                                        </tr>
                                        <tr height="40" class="letras1">

                                            <td><?php echo $abrev; ?></td>
                                            <td>C-<?php echo $caja . "________"; ?></td>
                                            <td>S-<?php echo $unidad . "________"; ?></td>
                                            <?php
                                            /* if ($tipo == 3)
            {
            ?>
        	    <td><?php echo $calc2."________";?></td>
         <?php 
            }*/
                                            ?>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <hr>

                                            </td>

                                        </tr>
                                    <?php }
                                    ?>
                                </table>
                            <?php } else {
                            ?>
                                <center>No se logro encontrar informacion con los datos ingresados</center>
                            <?php }
                            ?>
                        </td>
                    </tr>
                </table>
        <?php }            //////cierro si el reporte es de un determinado local
        }            //////cierro el if (val)
        ?>
        <?php

        ?>
    </DIV>
</body>

</html>