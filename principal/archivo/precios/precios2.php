<?php
include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../convertfecha.php');
require_once('../../../titulo_sist.php');

$ct = 0;
$sqlP = "SELECT porcent,Preciovtacostopro,precios_por_local,masPrecioVenta FROM datagen";
$resultP = mysqli_query($conexion, $sqlP);
if (mysqli_num_rows($resultP)) {
    while ($row = mysqli_fetch_array($resultP)) {
        $tipocosto = $row['Preciovtacostopro'];
        $precios_por_local = $row['precios_por_local'];
        $masPrecioVenta = $row['masPrecioVenta'];
        $quecosto = 'COSTO DE REPOSICION';
        if ($tipocosto >= 1) {
            $quecosto = ' COSTO PROMEDIO';
            $tipocosto = 1;
        }
    }
}
if ($precios_por_local  == 1) {
    require_once '../../../precios_por_local.php';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title><?php echo $desemp ?></title>
    <link href="../css/css/style1.css" rel="stylesheet" type="text/css" />
    <link href="../css/css/tablas.css" rel="stylesheet" type="text/css" />
    
     <link href="../../../funciones/datatable/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <script src="../../../funciones/datatable/jquery-3.3.1.js"></script>
    <script src="../../../funciones/datatable/jquery.dataTables.min.js"></script>
    
    <style>
        #boton {
            background: url('../../../images/save_16.png') no-repeat;
            border: none;
            width: 16px;
            height: 16px;
        }

        #boton1 {
            background: url('../../../images/x2.png') no-repeat;
            border: none;
            width: 26px;
            height: 26px;
        }

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

        .Estilo2fin {
            color: #f53c3c;
            font-size: 20px;
            margin-top: 10%;
            /* font-weight: bold; */
        }
    </style>
    <?php
    require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS
    require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    require_once("../../../funciones/highlight.php"); //ILUMINA CAJAS DE TEXTOS
    $cr = isset($_REQUEST['cr']) ? ($_REQUEST['cr']) : "";
    ?>
    <script>
        function validar_grid() {
            var f = document.form1;
            f.method = "POST";
            f.action = "precios2.php";
            f.submit();
        }

        function validar_prod() {
            var f = document.form1;
            var v1 = parseFloat(document.form1.p2.value); //PRECIO VENTA
            var p1 = parseFloat(document.form1.p1.value); //PRECIO VENTA COSTRE

            if ((f.p1.value == "") || (f.p1.value == 0)) {
                alert("Ingrese un costo ");
                f.p1.focus();
                return;
            }
            if (v1 < p1) {
                mensaje = confirm("El precio de caja es menor al costo de compra." + "\n\n" + " Estas seguro de continuar?");

                if (mensaje) {
                    f.method = "post";
                    f.action = "grabar_datos.php";
                    f.submit();
                } else {
                    f.p2.focus();
                    return;
                }
            } else {
                f.method = "post";
                f.action = "grabar_datos.php";
                f.submit();
            }
        }

        function sf() {
            document.form1.p1.focus();
        }
        var nav4 = window.Event ? true : false;

        function ent(evt) {

            var key = nav4 ? evt.which : evt.keyCode;
            if (key == 13) {
                //EDUARDO
                var f = document.form1;
                var v1 = parseFloat(document.form1.p2.value); //PRECIO VENTA
                var p1 = parseFloat(document.form1.p1.value); //PRECIO VENTA COSTRE
                if ((f.p1.value == "") || (f.p1.value == 0)) {
                    alert("Ingrese un costo ");
                    f.p1.focus();
                    return;
                }
                if (v1 < p1) {
                    mensaje = confirm("El precio de caja es menor al costo de compra." + "\n\n" + " Estas seguro de continuar?");

                    if (mensaje) {
                        f.method = "post";
                        f.action = "grabar_datos.php";
                        f.submit();
                    } else {
                        f.p2.focus();
                        return;
                    }
                } else {
                    f.method = "post";
                    f.action = "grabar_datos.php";
                    f.submit();
                }


            } else {
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
        function filtra() {
            var v1 = parseFloat(document.form1.p1.value); //PRECIO VENTA
            var v2 = parseFloat(document.form1.p2.value); //PRECIO VENTA
            if (v2 < v1) {
                document.getElementById("seguridad").innerHTML = 'Cuidado el precio de venta es menor que el <?php echo $quecosto; ?>, tendra perdidas  ';
                document.getElementById("seguridad").style.color = "red";
            } else {
                document.getElementById("seguridad").innerHTML = '';
                document.getElementById("seguridad").style.color = "#ffffff";
            }
        }

        function filtraOpcionesCaja() {

            var costoReposicion = parseFloat(document.form1.p1.value); //COSTO DE REPOSICION
            var factor = parseFloat(document.form1.factor.value); //FACTOR

            var opPrevta2 = parseFloat(document.form1.opPrevta2.value); //opPrevta2
            var opPrevta3 = parseFloat(document.form1.opPrevta3.value); //opPrevta3
            var opPrevta4 = parseFloat(document.form1.opPrevta4.value); //opPrevta4
            var opPrevta5 = parseFloat(document.form1.opPrevta5.value); //opPrevta4

            if ((opPrevta2 <= costoReposicion) && (opPrevta2 > 0)) {
                document.getElementById("seguridad").innerHTML = 'Cuidado el precio de venta opcion 2 es menor que el <?php echo $quecosto; ?>, tendra perdidas  ';
                document.getElementById("seguridad").style.color = "red";
            } else if ((opPrevta3 <= costoReposicion) && (opPrevta3 > 0)) {
                document.getElementById("seguridad").innerHTML = 'Cuidado el precio de venta opcion 3 es menor que el <?php echo $quecosto; ?>, tendra perdidas  ';
                document.getElementById("seguridad").style.color = "red";
            } else if ((opPrevta4 <= costoReposicion) && (opPrevta4 > 0)) {
                document.getElementById("seguridad").innerHTML = 'Cuidado el precio de venta opcion 4 es menor que el <?php echo $quecosto; ?>, tendra perdidas  ';
                document.getElementById("seguridad").style.color = "red";
            } else if ((opPrevta5 <= costoReposicion) && (opPrevta5 > 0)) {
                document.getElementById("seguridad").innerHTML = 'Cuidado el precio de venta opcion 4 es menor que el <?php echo $quecosto; ?>, tendra perdidas  ';
                document.getElementById("seguridad").style.color = "red";
            } else {
                document.getElementById("seguridad").innerHTML = '';
                document.getElementById("seguridad").style.color = "#ffffff";
            }
        }

        function filtraOpcionesUnidad() {
            var costoReposicionUnidad = parseFloat(document.form1.p1.value); //COSTO DE REPOSICION
            var factor = parseFloat(document.form1.factor.value); //FACTOR
            var costoReposicionUnidad = (costoReposicionUnidad / factor);
            var opPreuni2 = parseFloat(document.form1.opPreuni2.value); //opPrevta2
            var opPreuni3 = parseFloat(document.form1.opPreuni3.value); //opPrevta3
            var opPreuni4 = parseFloat(document.form1.opPreuni4.value); //opPrevta4
            var opPreuni5 = parseFloat(document.form1.opPreuni5.value); //opPrevta4

            if ((opPreuni2 <= costoReposicionUnidad) && (opPreuni2 > 0)) {
                document.getElementById("seguridad").innerHTML = 'Cuidado el precio de venta opcion 2 es menor que el <?php echo $quecosto; ?>, tendra perdidas  ';
                document.getElementById("seguridad").style.color = "red";
            } else if ((opPreuni3 <= costoReposicionUnidad) && (opPreuni3 > 0)) {
                document.getElementById("seguridad").innerHTML = 'Cuidado el precio de venta opcion 3 es menor que el <?php echo $quecosto; ?>, tendra perdidas  ';
                document.getElementById("seguridad").style.color = "red";
            } else if ((opPreuni4 <= costoReposicionUnidad) && (opPreuni4 > 0)) {
                document.getElementById("seguridad").innerHTML = 'Cuidado el precio de venta opcion 4 es menor que el <?php echo $quecosto; ?>, tendra perdidas  ';
                document.getElementById("seguridad").style.color = "red";
            } else if ((opPreuni5 <= costoReposicionUnidad) && (opPreuni5 > 0)) {
                document.getElementById("seguridad").innerHTML = 'Cuidado el precio de venta opcion 4 es menor que el <?php echo $quecosto; ?>, tendra perdidas  ';
                document.getElementById("seguridad").style.color = "red";
            } else {
                document.getElementById("seguridad").innerHTML = '';
                document.getElementById("seguridad").style.color = "#ffffff";
            }
        }

        function precio_caja_opcional() {
            var f = document.form1;
            var factor = parseFloat(document.form1.factor.value); //FACTOR
            var opPrevta2 = parseFloat(document.form1.opPrevta2.value); //opPrevta2
            var opPrevta3 = parseFloat(document.form1.opPrevta3.value); //opPrevta3
            var opPrevta4 = parseFloat(document.form1.opPrevta4.value); //opPrevta4
            var opPrevta5 = parseFloat(document.form1.opPrevta5.value); //opPrevta4

            if (factor == 1) {
                document.form1.opPreuni2.value = opPrevta2;
                document.form1.opPreuni3.value = opPrevta3;
                document.form1.opPreuni4.value = opPrevta4;
                document.form1.opPreuni5.value = opPrevta5;
            }
        }

        function precio_caja() {
            var f = document.form1;
            //var v1 		= parseFloat(document.form1.p1.value);			//PRECIO COSTO
            var v1 = parseFloat(document.form1.p2.value); //PRECIO VENTA
            var factor = parseFloat(document.form1.factor.value); //FACTOR
            //var pcu         = parseFloat(document.form1.pcostouni.value);           //PCOSTO
            var pcu = parseFloat(document.form1.p1.value); //PCOSTO
            if (factor === 0) {
                factor = 1;
            }
            var t = v1 / pcu;
            var tt = (t * 100) - 100;
            var pvu = v1 / factor;
            var rpc = ((v1 - pcu) / pcu) * 100;
            var rpu1 = (pcu / factor);
            var rpu = ((pvu - rpu1) / rpu1) * 100;
            tt = Math.round(tt * Math.pow(10, 2)) / Math.pow(10, 2);
            pvu = Math.round(pvu * Math.pow(10, 2)) / Math.pow(10, 2);
            rpc = Math.round(rpc * Math.pow(10, 2)) / Math.pow(10, 2);
            rpu = Math.round(rpu * Math.pow(10, 2)) / Math.pow(10, 2);
            if (factor == 1) {
                document.form1.margene1.value = tt; //MARGEN DE UTIIDAD?

                document.form1.p3.value = pvu; //PRECIO VTA UNITARIO
                //CALCULO LA RENT POR PRECIO VTA CAJA
                document.form1.pCaja.value = rpc;
                //CALCULO LA RENT POR PRECIO VTA UNIDAD
                document.form1.pUNI.value = rpu;
            } else {
                document.form1.margene1.value = tt; //MARGEN DE UTIIDAD?

                document.form1.p3.value = pvu; //PRECIO VTA UNITARIO
                //CALCULO LA RENT POR PRECIO VTA CAJA
                document.form1.pCaja.value = rpc;
                //CALCULO LA RENT POR PRECIO VTA UNIDAD
                document.form1.pUNI.value = rpu;
            }

        }

        function precio_unidad() {
            var f = document.form1;
            var v1 = parseFloat(document.form1.p3.value); //PRECIO VENTA UNITARIO
            var factor = parseFloat(document.form1.factor.value); //FACTOR
            //var pcu         = parseFloat(document.form1.pcostouni.value);           //PCOSTO
            var pcu = parseFloat(document.form1.p1.value); //PCOSTO
            if (factor === 0) {
                factor = 1;
            }
            var rpu1 = (pcu / factor);
            var rpu = ((v1 - rpu1) / rpu1) * 100;
            rpu = Math.round(rpu * Math.pow(10, 2)) / Math.pow(10, 2);
            //document.form1.margene1.value = tt;                                     //MARGEN DE UTIIDAD?
            //document.form1.p3.value = pvu;                                          //PRECIO VTA UNITARIO
            //CALCULO LA RENT POR PRECIO VTA CAJA
            //document.form1.pCaja.value = rpc;  
            //CALCULO LA RENT POR PRECIO VTA UNIDAD
            document.form1.pUNI.value = rpu;
        }


        function precio_porcentaje_caja() {
            //PRECIO DE COSTO           p1
            //PRECIO DE VENTA POR CAJA p2
            //PRECIO DE VENTA POR UNIDAD p3
            //PORCENTAJE DE RENTABILIDAD POR CAJA pCaja
            //PORCENTAJE DE RENTABILIDAD POR UNIDAD pUNI
            var f = document.form1;
            var p1 = parseFloat(document.form1.p1.value);
            var pCaja = document.form1.pCaja.value;
            var pUNI = document.form1.pUNI.value;
            var factor = parseFloat(document.form1.factorc.value); //FACTOR
            //alert("porcentaje "+por);
            if (factor === 0) {
                factor = 1;
            }
            if (factor > 1) {
                var uni = (p1 / factor);
            }
            if (pCaja == "") {
                //alert("vacio"+ p1 +"-"+factor);
                if (factor == 1) {
                    var porcen = (p1 * 5) / 100;
                    var pc = (p1 + porcen);
                    pc = Math.round(pc * Math.pow(10, 2)) / Math.pow(10, 2);
                    document.form1.p2.value = pc;
                    document.form1.p3.value = pc;
                    document.form1.pCaja.value = 5;
                    document.form1.pUNI.value = 5;
                } else {
                    var porcen = (p1 * 5) / 100;
                    var pc = (p1 + porcen);
                    var porcen2 = (uni * 5) / 100;
                    var pu = (uni + porcen2);
                    pc = Math.round(pc * Math.pow(10, 2)) / Math.pow(10, 2);
                    pu = Math.round(pu * Math.pow(10, 2)) / Math.pow(10, 2);
                    if (document.form1.pCaja.value != '') {
                        document.form1.p2.value = pc;
                        document.form1.p3.value = pu;
                        document.form1.pCaja.value = 5;
                        document.form1.pUNI.value = 5;
                    } else {
                        document.form1.p2.value = '0.00';
                        document.form1.p3.value = '0.00';
                        document.form1.pCaja.value = '';
                        document.form1.pUNI.value = '';
                    }
                }
            } else {
                //alert("lleno");
                if (factor == 1) {
                    var porcen = (p1 * pCaja) / 100;
                    var pc = (p1 + porcen);
                    pc = Math.round(pc * Math.pow(10, 2)) / Math.pow(10, 2);
                    if (document.form1.pCaja.value != '') {

                        document.form1.p2.value = pc;
                        document.form1.p3.value = pc;
                        document.form1.pCaja.value = pCaja;
                        document.form1.pUNI.value = pCaja;
                    } else {
                        document.form1.p2.value = '0.00';
                        document.form1.p3.value = '0.00';
                        document.form1.pCaja.value = '';
                        document.form1.pUNI.value = '';
                    }
                } else {
                    var porcen = (p1 * pCaja) / 100;
                    var pc = (p1 + porcen);
                    var porcen2 = (uni * pCaja) / 100;
                    var pu = (uni + porcen2);
                    pc = Math.round(pc * Math.pow(10, 2)) / Math.pow(10, 2);
                    pu = Math.round(pu * Math.pow(10, 2)) / Math.pow(10, 2);
                    if (document.form1.pCaja.value != '') {

                        document.form1.p2.value = pc;
                        //document.form1.p3.value = pu;
                        document.form1.pCaja.value = pCaja;
                        //document.form1.pUNI.value = pCaja;
                    } else {
                        document.form1.p2.value = '0.00';
                        // document.form1.p3.value = '0.00';
                        document.form1.pCaja.value = '';
                        //document.form1.pUNI.value = '';
                    }
                }
            }
        }


        function precio_porcentaje_unidad() {
            //PRECIO DE COSTO           p1
            //PRECIO DE VENTA POR CAJA p2
            //PRECIO DE VENTA POR UNIDAD p3
            //PORCENTAJE DE RENTABILIDAD POR CAJA pCaja
            //PORCENTAJE DE RENTABILIDAD POR UNIDAD pUNI
            var f = document.form1;
            var p1 = parseFloat(document.form1.p1.value);
            var p3 = parseFloat(document.form1.p3.value);
            var pCaja = document.form1.pCaja.value;
            var pUNI = document.form1.pUNI.value;



            var factor = parseFloat(document.form1.factorc.value); //FACTOR
            if (factor === 0) {
                factor = 1;
            }
            if (factor > 1) {
                var uni = (p1 / factor);
            }
            if (pCaja == "") {
                //alert("vacio"+ p1 +"-"+factor);
                if (factor == 1) {
                    var porcen = (p1 * 5) / 100;
                    var pc = (p1 + porcen);
                    pc = Math.round(pc * Math.pow(10, 2)) / Math.pow(10, 2);
                    document.form1.p2.value = pc;
                    document.form1.p3.value = pc;
                    document.form1.pCaja.value = 5;
                    document.form1.pUNI.value = 5;
                } else {
                    var porcen = (p1 * 5) / 100;
                    var pc = (p1 + porcen);
                    var porcen2 = (uni * 5) / 100;
                    var pu = (uni + porcen2);
                    pc = Math.round(pc * Math.pow(10, 2)) / Math.pow(10, 2);
                    pu = Math.round(pu * Math.pow(10, 2)) / Math.pow(10, 2);
                    document.form1.p2.value = pc;
                    document.form1.p3.value = pu;
                    document.form1.pCaja.value = 5;
                    document.form1.pUNI.value = 5;
                }
            } else {
                //alert("lleno");
                if (factor == 1) {
                    var porcen = (p1 * pUNI) / 100;
                    var pc = (p1 + porcen);
                    pc = Math.round(pc * Math.pow(10, 2)) / Math.pow(10, 2);
                    if (document.form1.pUNI.value != '') {
                        document.form1.p2.value = pc;
                        document.form1.p3.value = pc;
                        document.form1.pCaja.value = pUNI;
                        document.form1.pUNI.value = pUNI;
                    } else {
                        document.form1.p2.value = '0.00';
                        document.form1.p3.value = '0.00';
                        document.form1.pCaja.value = '';
                        document.form1.pUNI.value = '';
                    }

                } else {
                    var porcen = (p1 * pUNI) / 100;
                    var pc = (p1 + porcen);
                    var porcen2 = (uni * pUNI) / 100;
                    var pu = (uni + porcen2);
                    pc = Math.round(pc * Math.pow(10, 2)) / Math.pow(10, 2);
                    pu = Math.round(pu * Math.pow(10, 2)) / Math.pow(10, 2);
                    if (document.form1.pUNI.value != '') {
                        // document.form1.p2.value = pc;
                        document.form1.p3.value = pu;
                        // document.form1.pCaja.value = pUNI;
                        document.form1.pUNI.value = pUNI;
                    } else {
                        // document.form1.p2.value = '';
                        document.form1.p3.value = '';
                        // document.form1.pCaja.value = '';
                        document.form1.pUNI.value = '';
                    }
                }
            }
        }

        // function mensaje(valortext) {
        //     // onfocus="mensaje(1)"
        //     var valortext;
        //     if (valortext == 1) {
        //         document.getElementById("blister").innerHTML = 'Le recomendamos que su precio de blister sea menor al precio de unidad'
        //     } else if (valortext == 2) {
        //         document.getElementById("blister").innerHTML = 'Le recomendamos que su precio de blister sea menor al precio de unidad'
        //     } else {
        //         document.getElementById("blister").innerHTML = ''
        //     }
        // }
    </script>
    <style>
        table {
            width: 100%;
        }

        input {
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            background-color: white;
            background-position: 3px 3px;
            background-repeat: no-repeat;
            padding: 2px 1px 2px 5px;

        }


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

        #customers td a {
            color: #4d9ff7;
            font-weight: bold;
            font-size: 15px;
            text-decoration: none;

        }

        #customers #total {

            text-align: center;
            background-color: #9ebcc1;
            color: white;
            font-size: 14px;
            font-weight: 900;
        }

        #customers tr:nth-child(even) {
           
        }
        
        #customers #rojo tr:nth-child(even) {
            background-color: #fd7c7c;
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
</head>
<?php
$sql1 = "SELECT codloc FROM usuario where usecod = '$usuario'"; ////CODIGO DEL LOCAL DEL USUARIO
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $codloc = $row1['codloc'];
    }
}
//**CONFIGPRECIOS_PRODUCTO**//
$nomlocalG = "";
$sqlLocal = "SELECT nomloc, nombre FROM xcompa where habil = '1' and codloc = '$codloc'";
$resultLocal = mysqli_query($conexion, $sqlLocal);
if (mysqli_num_rows($resultLocal)) {
    while ($rowLocal = mysqli_fetch_array($resultLocal)) {
        $nomlocalG = $rowLocal['nomloc'];
        $nombre_local = $rowLocal['nombre'];
    }
}


$numero_xcompa = substr($nomlocalG, 5, 2);
$tabla = "s" . str_pad($numero_xcompa, 3, "0", STR_PAD_LEFT);




$search = isset($_REQUEST['search']) ? ($_REQUEST['search']) : "";
//echo $search;

$search=str_replace("@","&",$search);

//echo $search;
$val = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";
$ckM = isset($_REQUEST['ckM']) ? ($_REQUEST['ckM']) : "";
//$ckM='0';

$sql = "SELECT nomusu FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $user = $row['nomusu'];
    }
}

function formato($c)
{
    printf("%08d", $c);
}

$codpros = isset($_REQUEST['codpros']) ? ($_REQUEST['codpros']) : "";
$valform = isset($_REQUEST['valform']) ? ($_REQUEST['valform']) : "";



if ($valform == 1) {
    $colspan = '2';
    $accion = 'GRABAR / CANCELAR';
} else {
    $colspan = '1';
    $accion = 'MODIFICAR';
}
?>

<body <?php if ($valform == 1) { ?>onload="sf();" <?php } else { ?> onload="getfocus();" <?php } ?> id="body">
    <table border="0" align="center">
        <tr>

            <td width="70%">
                <div id="seguridad" style="font-size:20px;"><strong></strong></div>
                <div id="blister" style="font-size:20px;"><strong></strong></div>
            </td>

            <td width="10%">
                <div align="right"><span class="text_combo_select"><strong>LOCAL:</strong> <img src="../../../images/controlpanel.png" width="16" height="16" /> <?php echo $nombre_local ?></span></div>
            </td>
            <td width="20%">
                <div align="right"><span class="text_combo_select"><strong>USUARIO :</strong> <img src="../../../images/user.gif" width="15" height="16" /> <?php echo $user ?></span></div>
            </td>
        </tr>
    </table>
    <form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">
        <table border="0" class="tabla2">
            <tr>
                <td>

                    <div align="center">
                        <img src="../../../images/line2.png" width="100%" height="4" />
                        <?php
                        if ($val <> "") {
                            if ($val == 1) {
                                 if($ckM ==1){
                                    $sql = "SELECT codpro,desprod,pcostouni,costre,margene,prevta,preuni,factor,codmar,stopro,$tabla,costpr,blister,preblister FROM producto where  eliminado='0'";
                                }else{
                                if (is_numeric($search)) {
                                    $sql = "SELECT codpro,desprod,pcostouni,costre,margene,prevta,preuni,factor,codmar,stopro,$tabla,costpr,blister,preblister,opPrevta2,opPrevta3,opPrevta4,opPrevta5,opPreuni2,opPreuni3,opPreuni4,opPreuni5,utlcos FROM producto where  eliminado='0' and codbar = '$search' or codpro = '$search' ";
                                } else {
                                    // echo 'letra';
                                    $sql = "SELECT codpro,desprod,pcostouni,costre,margene,prevta,preuni,factor,codmar,stopro,$tabla,costpr,blister,preblister,opPrevta2,opPrevta3,opPrevta4,opPrevta5,opPreuni2,opPreuni3,opPreuni4,opPreuni5,utlcos FROM producto where desprod like '%$search%' and eliminado='0' ";
                                }
                                }
                            }
                            if ($tipocosto == 1) { //costo promedio
                                $sql = "SELECT codpro,desprod,costpr/factor as pcostouni,costpr as costre,margene,prevta,preuni,factor,codmar,stopro,$tabla,costpr,blister,preblister,opPrevta2,opPrevta3,opPrevta4,opPrevta5,opPreuni2,opPreuni3,opPreuni4,opPreuni5,utlcos  FROM producto where desprod like '$search%' and eliminado='0'";
                            }

                            if ($val == 2) {
                                
                                if($search =='all'){
                                    $sql = "SELECT codpro,desprod,pcostouni,costre,margene,prevta,preuni,factor,codmar,stopro,$tabla,costpr,blister,preblister,opPrevta2,opPrevta3,opPrevta4,opPrevta5,opPreuni2,opPreuni3,opPreuni4,opPreuni5,utlcos FROM producto where eliminado='0'";
                                }else{
                                $sql = "SELECT codpro,desprod,pcostouni,costre,margene,prevta,preuni,factor,codmar,stopro,$tabla,costpr,blister,preblister,opPrevta2,opPrevta3,opPrevta4,opPrevta5,opPreuni2,opPreuni3,opPreuni4,opPreuni5,utlcos FROM producto where codmar = '$search' and eliminado='0'";
                                }
                                if ($tipocosto == 1) { //costo promedio
                                    $sql = "SELECT codpro,desprod,costpr/factor as pcostouni,costpr as costre,margene,prevta,preuni,factor,codmar,stopro,$tabla,costpr,blister,preblister,opPrevta2,opPrevta3,opPrevta4,opPrevta5,opPreuni2,opPreuni3,opPreuni4,opPreuni5,utlcos FROM producto where codmar = '$search' and eliminado='0'";
                                }
                            }
                            if ($val == 3) {
                                $sql = "SELECT codpro,desprod,pcostouni,costre,margene,prevta,preuni,factor,codmar,stopro,$tabla,costpr,opPrevta2,opPrevta3,opPrevta4,opPrevta5,opPreuni2,opPreuni3,opPreuni4,opPreuni5,utlcos FROM producto where $tabla > 0 and eliminado='0'";
                                if ($tipocosto == 1) { //costo promedio
                                    $sql = "SELECT codpro,desprod,costre/factor as pcostouni ,costpr as costre,margene,prevta,preuni,factor,codmar,stopro,$tabla,costpr,blister,preblister,opPrevta2,opPrevta3,opPrevta4,opPrevta5,opPreuni2,opPreuni3,opPreuni4,opPreuni5,utlcos FROM producto where $tabla > 0 and eliminado='0'";
                                }
                            }
                            $result = mysqli_query($conexion, $sql);
                            if (mysqli_num_rows($result)) {
                        ?>
                                <table width="100%" border="0" align="center" id="customers" cellpadding="0" cellspacing="0">
                                    <thead id="Topicos_Cabecera_Datos">
                                    <tr>
                                        <th width="3%"><strong>CODIGO</strong></th>
                                        <th width="20%"><strong>PRODUCTO</strong></th>
                                        <th width="10%">
                                            <div align="left"><strong>MARCA</strong></div>
                                        </th>
                                        <th>
                                            <div align="center"><strong>FACTOR</strong></div>
                                        </th>
                                        <th width="8%">
                                            <div align="left"><strong>STOCK <?php echo $nombre_local ?></strong></div>
                                        </th>
                                        <th width="8%">
                                            <div align="center"><strong><?php echo $quecosto ?></strong></div>
                                        </th>
                                        <th width="8%">
                                            <div align="center"><strong>PRECIO VENTA X CAJA</strong></div>
                                        </th>
                                        <th width="8%">
                                            <div align="center"><strong>PRECIO VENTA X UNIT </strong></div>
                                        </th>
                                        <th width="8%">
                                            <div align="center"><strong>% X CAJA </strong></div>
                                        </th>
                                        <th width="8%">
                                            <div align="center"><strong>% X UNI </strong></div>
                                        </th>
                                        <th width="5%">
                                            <div align="center"><strong>UNDS. X BLISTER </strong></div>
                                        </th>
                                        <th width="5%">
                                            <div align="center"><strong>PRE. UNI X BLIS. </strong></div>
                                        </th>

                                        <?php if (($masPrecioVenta == '1') && ($precios_por_local == '0')) { ?>
                                            <th width="8%">
                                                <div align="center"><strong>PRECIO VENTA X CAJA OP 2</strong></div>
                                            </th>
                                            <th width="8%">
                                                <div align="center"><strong>PRECIO VENTA X UNIT OP 2</strong></div>
                                            </th>


                                            <th width="8%">
                                                <div align="center"><strong>PRECIO VENTA X CAJA OP 3</strong></div>
                                            </th>

                                            <th width="8%">
                                                <div align="center"><strong>PRECIO VENTA X UNIT OP 3</strong></div>
                                            </th>


                                            <th width="8%">
                                                <div align="center"><strong>PRECIO VENTA X CAJA OP 4</strong></div>
                                            </th>
                                            <th width="8%">
                                                <div align="center"><strong>PRECIO VENTA X UNIT OP 4</strong></div>
                                            </th>
                                            <th width="8%">
                                                <div align="center"><strong>PRECIO VENTA X CAJA OP 5</strong></div>
                                            </th>

                                            <th width="8%">
                                                <div align="center"><strong>PRECIO VENTA X UNIT OP 5</strong></div>
                                            </th>
                                        <?php } ?>
                                        <th width="12%" colspan=" <?php echo $colspan; ?>">
                                            <div align="center"><strong><?php echo $accion; ?></strong></div>
                                        </th>
                                    </tr>
                                     </thead>
                        <tbody id="gtnp_Listado_Datos">
                                    <?php
                                    $cr = 1;
                                    $cont = 1;
                                    while ($row = mysqli_fetch_array($result)) {
                                        $codpro = $row['codpro'];
                                        $desprod = $row['desprod'];
                                        if (($zzcodloc == 1) && ($precios_por_local == 1)) {
                                            $pcostouni = $row['pcostouni'];
                                            $costre = $row['costre'];
                                            $margene = $row['margene'];
                                            $prevta = $row['prevta'];
                                            $preuni = $row['preuni'];
                                            $costpr = $row['costpr'];
                                            $utlcos = $row['utlcos'];
                                            $blister = $row['blister'];
                                            $preblister = $row['preblister'];
                                        } elseif ($precios_por_local == 0) {
                                            $pcostouni = $row['pcostouni'];
                                            $costre = $row['costre'];
                                            $margene = $row['margene'];
                                            $prevta = $row['prevta'];
                                            $preuni = $row['preuni'];
                                            $costpr = $row['costpr'];
                                            $utlcos = $row['utlcos'];
                                            $blister = $row['blister'];
                                            $preblister = $row['preblister'];
                                        }
                                        $factor = $row['factor'];
                                        $codmar = $row['codmar'];
                                        $stopro = $row['stopro'];
                                        $opPrevta2 = $row['opPrevta2'];
                                        $opPrevta3 = $row['opPrevta3'];
                                        $opPrevta4 = $row['opPrevta4'];
                                        $opPrevta5 = $row['opPrevta5'];
                                        $opPreuni2 = $row['opPreuni2'];
                                        $opPreuni3 = $row['opPreuni3'];
                                        $opPreuni4 = $row['opPreuni4'];
                                        $opPreuni5 = $row['opPreuni5'];
                                        $stoproLoc = $row[10];

                                        if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                                            $sql_precio = "SELECT $costre_p,$margene_p,$prevta_p,$preuni_p,$costpr_p,$blister_p,$preblister_p,$utlcos_p FROM precios_por_local where codpro = '$codpro'";
                                            $result_precio = mysqli_query($conexion, $sql_precio);
                                            if (mysqli_num_rows($result_precio)) {
                                                while ($row_precio = mysqli_fetch_array($result_precio)) {
                                                    $costre = $row_precio[0];
                                                    $margene = $row_precio[1];
                                                    $prevta = $row_precio[2];
                                                    $preuni = $row_precio[3];
                                                    $costpr = $row_precio[4];
                                                    $blister = $row_precio[5];
                                                    $preblister = $row_precio[6];
                                                    $utlcos = $row_precio[7];
                                                }
                                            }
                                        }
                                        $sql1 = "SELECT destab FROM titultabladet where tiptab = 'M' and codtab = '$codmar'";
                                        $result1 = mysqli_query($conexion, $sql1);
                                        if (mysqli_num_rows($result1)) {
                                            while ($row1 = mysqli_fetch_array($result1)) {
                                                $destab = $row1['destab'];
                                            }
                                        }
                                        if ($ct == 1) {
                                            $color = "#99CCFF";
                                        } else {
                                            $color = "#FFFFFF";
                                        }
                                        $t = $cont % 2;
                                        if ($t == 1) {
                                            $color = "#D2E0EC";
                                        } else {
                                            $color = "#ffffff";
                                        }
                                        $cont++;

                                        if ($pcostouni == 0) {
                                            $pcostouni = 1;
                                        }
                                        if ($factor == 0) {
                                            $factor = 1;
                                        }
                                        if ($costre <> 0) {
                                            $pC = (($prevta - $costre) / $prevta) * 100;
                                            $pC = number_format($pC, 2, '.', ' ');
                                        } else {

                                            $pC = 0;
                                        }
                                        ////PORCENTAJE DE RENTABILIDAD POR UNIDAD

                                        if ($costre <> 0) {
                                            $pU = (($preuni - ($costre / $factor)) / $preuni) * 100;
                                            $pU = number_format($pU, 2, '.', ' ');
                                        } else {
                                            $pU = 0;
                                        }
                                    ?>
                                    
                                      <?php
                                   
                                    if(($ckM ==1)){  
                                    if(($costre > $prevta)&&($costre <> 0)){
                                    ?>
                                        <tr style="background-color: #fd7c7c;" >
                                            <td><?php echo $codpro ?></td>
                                            <td title="Este producto contiene factor <?php echo $factor; ?> UND(ES)"><a id="l<?php echo $cr; ?>" href="precios2.php?val=<?php echo $val ?>&search=<?php echo $search ?>&valform=1&codpros=<?php echo $codpro ?>"><?php echo $desprod ?></a></td>
                                            <td>
                                                <div align="left"><?php echo $destab ?></div>
                                            </td>
                                            <td>
                                                <div align="center"><?php echo  $factor;  ?></div>
                                            </td>
                                            <td>
                                                <div align="left"><?php echo stockcaja($stoproLoc, $factor); ?></div>
                                            </td>
                                            <td>
                                                <div align="center">
                                                    <?php if (($valform == 1) and ($codpros == $codpro)) { ?>
                                                        <input name="p1" type="text" id="p1" size="8" value="<?php echo $costre ?>" onkeypress="return decimal(event);" />
                                                    <?php
                                                    } else {
                                                        echo $costre;
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div align="center">
                                                    <?php
                                                    //PRECIO DE VENTA POR CAJA
                                                    if (($valform == 1) and ($codpros == $codpro)) {
                                                    ?>
                                                        <input name="p2" type="text" id="p2" size="8" value="<?php echo $prevta ?>" onkeyup="precio_caja()" onblur="filtra();" onkeypress="return decimal(event);" />
                                                    <?php
                                                    } else {
                                                        echo $prevta;
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div align="center">
                                                    <?php
                                                    //PRECIO DE VENTA POR UNIDAD
                                                    if (($valform == 1) and ($codpros == $codpro)) {
                                                    ?>
                                                        <!--                            maxlength="3"-->
                                                        <input name="p3" type="text" id="p3" size="8" value="<?php echo $preuni ?>" onkeyup="precio_unidad();" <?php if ($factor == 1) { ?>readonly<?php } ?> onkeypress="return decimal(event);" />

                                                    <?php
                                                    } else {
                                                        echo $preuni;
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div align="center">
                                                    <?php
                                                    ////PORCENTAJE DE RENTABILIDAD POR CAJA
                                                    if (($valform == 1) and ($codpros == $codpro)) {
                                                    ?>
                                                        <!--<input name="pCaja" type="text" id="pCaja" size="8" value="<?php echo $pC ?>" readonly/>-->
                                                        <input name="pCaja" type="text" id="pCaja" size="8" value="<?php echo $pC ?>" onkeyup="precio_porcentaje_caja();" onblur="filtra();" onkeypress="return decimal(event);" />
                                                        <input name="factorc" type="hidden" id="factorc" value="<?php echo $factor ?>" />
                                                    <?php
                                                    } else {
                                                        echo $pC;
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div align="center">
                                                    <?php
                                                    //echo $factor;
                                                    if (($valform == 1) and ($codpros == $codpro)) {
                                                    ?>
                                                        <!--<input name="pUNI" type="text" id="pUNI" size="8" value="<?php echo $pU ?>" readonly/>-->
                                                        <input name="pUNI" type="text" id="pUNI" size="8" value="<?php echo $pU ?>" onkeyup="precio_porcentaje_unidad();" <?php if ($factor == 1) { ?>readonly<?php } ?> onkeypress="return decimal(event);" />
                                                    <?php
                                                    } else {
                                                        echo $pU;
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div align="center">
                                                    <?php

                                                    if (($valform == 1) and ($codpros == $codpro)) {
                                                    ?>
                                                        <input name="blister" type="text" id="blister" size="8" value="<?php echo $blister ?>" <?php if ($factor == 1) { ?>readonly<?php } ?> onkeypress="return acceptNum(event);" onfocus="mensaje(1)" />
                                                    <?php
                                                    } else {
                                                        echo $blister;
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div align="center">
                                                    <?php

                                                    if (($valform == 1) and ($codpros == $codpro)) {
                                                    ?>
                                                        <input name="preblister" type="text" id="preblister" size="8" value="<?php echo $preblister ?>" <?php if ($factor == 1) { ?>readonly<?php } ?> onkeypress="return decimal(event)" onfocus="mensaje(2)" />
                                                    <?php
                                                    } else {
                                                        echo $preblister;
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                            <?php if (($masPrecioVenta == '1') && ($precios_por_local == '0')) { ?>
                                                <td bgcolor="#f3a47e">
                                                    <div align="center">
                                                        <?php
                                                        //PRECIO DE VENTA POR CAJA
                                                        if (($valform == 1) and ($codpros == $codpro)) {
                                                        ?>
                                                            <input name="opPrevta2" type="text" id="opPrevta2" size="8" value="<?php echo $opPrevta2 ?>" onblur="filtraOpcionesCaja();" onkeyup="precio_caja_opcional()" onkeypress="return decimal(event);" />
                                                        <?php
                                                        } else {
                                                            echo $opPrevta2;
                                                        }
                                                        ?>
                                                    </div>
                                                </td>
                                                <td bgcolor="#f3a47e">
                                                    <div align="center">
                                                        <?php
                                                        //PRECIO DE VENTA POR CAJA
                                                        if (($valform == 1) and ($codpros == $codpro)) {
                                                        ?>
                                                            <input name="opPreuni2" type="text" id="opPreuni2" size="8" value="<?php echo $opPreuni2 ?>" onblur="filtraOpcionesUnidad();" onkeypress="return decimal(event);" />
                                                        <?php
                                                        } else {
                                                            echo $opPreuni2;
                                                        }
                                                        ?>
                                                    </div>
                                                </td>


                                                <td bgcolor="#f3c67e">
                                                    <div align="center">
                                                        <?php
                                                        //PRECIO DE VENTA POR CAJA
                                                        if (($valform == 1) and ($codpros == $codpro)) {
                                                        ?>
                                                            <input name="opPrevta3" type="text" id="opPrevta3" size="8" value="<?php echo $opPrevta3 ?>" onblur="filtraOpcionesCaja();" onkeyup="precio_caja_opcional()" onkeypress="return decimal(event);" />
                                                        <?php
                                                        } else {
                                                            echo $opPrevta3;
                                                        }
                                                        ?>
                                                    </div>
                                                </td>
                                                <td bgcolor="#f3c67e">
                                                    <div align="center">
                                                        <?php
                                                        //PRECIO DE VENTA POR CAJA
                                                        if (($valform == 1) and ($codpros == $codpro)) {
                                                        ?>
                                                            <input name="opPreuni3" type="text" id="opPreuni3" size="8" value="<?php echo $opPreuni3 ?>" onblur="filtraOpcionesUnidad();" onkeypress="return decimal(event);" />
                                                        <?php
                                                        } else {
                                                            echo $opPreuni3;
                                                        }
                                                        ?>
                                                    </div>
                                                </td>
                                                <td bgcolor="#7ab3c3">
                                                    <div align="center">
                                                        <?php
                                                        //PRECIO DE VENTA POR CAJA
                                                        if (($valform == 1) and ($codpros == $codpro)) {
                                                        ?>
                                                            <input name="opPrevta4" type="text" id="opPrevta4" size="8" value="<?php echo $opPrevta4 ?>" onblur="filtraOpcionesCaja();" onkeyup="precio_caja_opcional()" onkeypress="return decimal(event);" />
                                                        <?php
                                                        } else {
                                                            echo $opPrevta4;
                                                        }
                                                        ?>
                                                    </div>
                                                </td>
                                                <td bgcolor="#7ab3c3">
                                                    <div align="center">
                                                        <?php
                                                        //PRECIO DE VENTA POR CAJA
                                                        if (($valform == 1) and ($codpros == $codpro)) {
                                                        ?>
                                                            <input name="opPreuni4" type="text" id="opPreuni4" size="8" value="<?php echo $opPreuni4 ?>" onblur="filtraOpcionesUnidad();" onkeypress="return decimal(event);" />
                                                        <?php
                                                        } else {
                                                            echo $opPreuni4;
                                                        }
                                                        ?>
                                                    </div>
                                                </td>
                                                <td bgcolor="#83ddab">
                                                    <div align="center">
                                                        <?php
                                                        //PRECIO DE VENTA POR CAJA
                                                        if (($valform == 1) and ($codpros == $codpro)) {
                                                        ?>
                                                            <input name="opPrevta5" type="text" id="opPrevta5" size="8" value="<?php echo $opPrevta5 ?>" onblur="filtraOpcionesCaja();" onkeyup="precio_caja_opcional()" onkeypress="return decimal(event);" />
                                                        <?php
                                                        } else {
                                                            echo $opPrevta5;
                                                        }
                                                        ?>
                                                    </div>
                                                </td>



                                                <td bgcolor="#83ddab">
                                                    <div align="center">
                                                        <?php
                                                        //PRECIO DE VENTA POR CAJA
                                                        if (($valform == 1) and ($codpros == $codpro)) {
                                                        ?>
                                                            <input name="opPreuni5" type="text" id="opPreuni5" size="8" value="<?php echo $opPreuni5 ?>" onblur="filtraOpcionesUnidad();" onkeypress="return decimal(event);" />
                                                        <?php
                                                        } else {
                                                            echo $opPreuni5;
                                                        }
                                                        ?>
                                                    </div>
                                                </td>
                                            <?php } ?>


                                            <?php if (($valform == 1) and ($codpros == $codpro)) { ?>
                                                <td>
                                                    <div align="center">

                                                        <input name="factor" type="hidden" id="factor" value="<?php echo $factor ?>" />
                                                        <input name="val" type="hidden" id="val" value="<?php echo $val ?>" />
                                                        <input name="margene1" type="hidden" id="margene1" value="" />
                                                        <input name="pcostouni" type="hidden" id="pcostouni" value="<?php echo $pcostouni ?>" />
                                                        <input name="search" type="hidden" id="search" value="<?php echo $search ?>" />
                                                        <input name="codpro" type="hidden" id="codpro" value="<?php echo $codpro ?>" />
                                                        <input name="costpr" type="hidden" id="costpr" value="<?php echo $costpr ?>" />
                                                        <input name="utlcos" type="hidden" id="utlcos" value="<?php echo $utlcos ?>" />
                                                        <input name="button" type="button" id="boton" onclick="validar_prod()" alt="GUARDAR" />
                                                        <!--   <input name="button2" type="button" id="boton1" onclick="validar_grid()" alt="ACEPTAR"/>-->

                                                    </div>
                                                </td>
                                                <td>
                                                    <div align="center">
                                                        <input name="button2" type="button" id="boton1" onclick="validar_grid()" alt="ACEPTAR" />
                                                    </div>
                                                </td>
                                            <?php
                                            } else {
                                            ?>
                                                <td colspan=" <?php echo $colspan; ?>">
                                                    <div align="center">
                                                        <a href="precios2.php?val=<?php echo $val ?>&search=<?php echo $search ?>&valform=1&codpros=<?php echo $codpro ?>">
                                                            <img src="../../../images/add1.gif" width="14" height="15" border="0" />
                                                        </a>
                                                    </div>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                        
                                    <?php }}else{ ?>
                                    
                                    <tr <?php if (($pC < 0) || ($pU < 0)) { ?> id="rojo" bgcolor="#fd7c7c" <?php } ?>>
                                            <td><?php echo $codpro ?></td>
                                            <td title="Este producto contiene factor <?php echo $factor; ?> UND(ES)"><a id="l<?php echo $cr; ?>" href="precios2.php?val=<?php echo $val ?>&search=<?php echo $search ?>&valform=1&codpros=<?php echo $codpro ?>"><?php echo $desprod ?></a></td>
                                            <td>
                                                <div align="left"><?php echo $destab ?></div>
                                            </td>
                                            <td>
                                                <div align="center"><?php echo  $factor;  ?></div>
                                            </td>
                                            <td>
                                                <div align="left"><?php echo stockcaja($stoproLoc, $factor); ?></div>
                                            </td>
                                            <td>
                                                <div align="center">
                                                    <?php if (($valform == 1) and ($codpros == $codpro)) { ?>
                                                        <input name="p1" type="text" id="p1" size="8" value="<?php echo $costre ?>" onkeypress="return decimal(event);" />
                                                    <?php
                                                    } else {
                                                        echo $costre;
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div align="center">
                                                    <?php
                                                    //PRECIO DE VENTA POR CAJA
                                                    if (($valform == 1) and ($codpros == $codpro)) {
                                                    ?>
                                                        <input name="p2" type="text" id="p2" size="8" value="<?php echo $prevta ?>" onkeyup="precio_caja()" onblur="filtra();" onkeypress="return decimal(event);" />
                                                    <?php
                                                    } else {
                                                        echo $prevta;
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div align="center">
                                                    <?php
                                                    //PRECIO DE VENTA POR UNIDAD
                                                    if (($valform == 1) and ($codpros == $codpro)) {
                                                    ?>
                                                        <!--                            maxlength="3"-->
                                                        <input name="p3" type="text" id="p3" size="8" value="<?php echo $preuni ?>" onkeyup="precio_unidad();" <?php if ($factor == 1) { ?>readonly<?php } ?> onkeypress="return decimal(event);" />

                                                    <?php
                                                    } else {
                                                        echo $preuni;
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div align="center">
                                                    <?php
                                                    ////PORCENTAJE DE RENTABILIDAD POR CAJA
                                                    if (($valform == 1) and ($codpros == $codpro)) {
                                                    ?>
                                                        <!--<input name="pCaja" type="text" id="pCaja" size="8" value="<?php echo $pC ?>" readonly/>-->
                                                        <input name="pCaja" type="text" id="pCaja" size="8" value="<?php echo $pC ?>" onkeyup="precio_porcentaje_caja();" onblur="filtra();" onkeypress="return decimal(event);" />
                                                        <input name="factorc" type="hidden" id="factorc" value="<?php echo $factor ?>" />
                                                    <?php
                                                    } else {
                                                        echo $pC;
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div align="center">
                                                    <?php
                                                    //echo $factor;
                                                    if (($valform == 1) and ($codpros == $codpro)) {
                                                    ?>
                                                        <!--<input name="pUNI" type="text" id="pUNI" size="8" value="<?php echo $pU ?>" readonly/>-->
                                                        <input name="pUNI" type="text" id="pUNI" size="8" value="<?php echo $pU ?>" onkeyup="precio_porcentaje_unidad();" <?php if ($factor == 1) { ?>readonly<?php } ?> onkeypress="return decimal(event);" />
                                                    <?php
                                                    } else {
                                                        echo $pU;
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div align="center">
                                                    <?php

                                                    if (($valform == 1) and ($codpros == $codpro)) {
                                                    ?>
                                                        <input name="blister" type="text" id="blister" size="8" value="<?php echo $blister ?>" <?php if ($factor == 1) { ?>readonly<?php } ?> onkeypress="return acceptNum(event);" onfocus="mensaje(1)" />
                                                    <?php
                                                    } else {
                                                        echo $blister;
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div align="center">
                                                    <?php

                                                    if (($valform == 1) and ($codpros == $codpro)) {
                                                    ?>
                                                        <input name="preblister" type="text" id="preblister" size="8" value="<?php echo $preblister ?>" <?php if ($factor == 1) { ?>readonly<?php } ?> onkeypress="return decimal(event)" onfocus="mensaje(2)" />
                                                    <?php
                                                    } else {
                                                        echo $preblister;
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                            <?php if (($masPrecioVenta == '1') && ($precios_por_local == '0')) { ?>
                                                <td bgcolor="#f3a47e">
                                                    <div align="center">
                                                        <?php
                                                        //PRECIO DE VENTA POR CAJA
                                                        if (($valform == 1) and ($codpros == $codpro)) {
                                                        ?>
                                                            <input name="opPrevta2" type="text" id="opPrevta2" size="8" value="<?php echo $opPrevta2 ?>" onblur="filtraOpcionesCaja();" onkeyup="precio_caja_opcional()" onkeypress="return decimal(event);" />
                                                        <?php
                                                        } else {
                                                            echo $opPrevta2;
                                                        }
                                                        ?>
                                                    </div>
                                                </td>
                                                <td bgcolor="#f3a47e">
                                                    <div align="center">
                                                        <?php
                                                        //PRECIO DE VENTA POR CAJA
                                                        if (($valform == 1) and ($codpros == $codpro)) {
                                                        ?>
                                                            <input name="opPreuni2" type="text" id="opPreuni2" size="8" value="<?php echo $opPreuni2 ?>" onblur="filtraOpcionesUnidad();" onkeypress="return decimal(event);" />
                                                        <?php
                                                        } else {
                                                            echo $opPreuni2;
                                                        }
                                                        ?>
                                                    </div>
                                                </td>


                                                <td bgcolor="#f3c67e">
                                                    <div align="center">
                                                        <?php
                                                        //PRECIO DE VENTA POR CAJA
                                                        if (($valform == 1) and ($codpros == $codpro)) {
                                                        ?>
                                                            <input name="opPrevta3" type="text" id="opPrevta3" size="8" value="<?php echo $opPrevta3 ?>" onblur="filtraOpcionesCaja();" onkeyup="precio_caja_opcional()" onkeypress="return decimal(event);" />
                                                        <?php
                                                        } else {
                                                            echo $opPrevta3;
                                                        }
                                                        ?>
                                                    </div>
                                                </td>
                                                <td bgcolor="#f3c67e">
                                                    <div align="center">
                                                        <?php
                                                        //PRECIO DE VENTA POR CAJA
                                                        if (($valform == 1) and ($codpros == $codpro)) {
                                                        ?>
                                                            <input name="opPreuni3" type="text" id="opPreuni3" size="8" value="<?php echo $opPreuni3 ?>" onblur="filtraOpcionesUnidad();" onkeypress="return decimal(event);" />
                                                        <?php
                                                        } else {
                                                            echo $opPreuni3;
                                                        }
                                                        ?>
                                                    </div>
                                                </td>
                                                <td bgcolor="#7ab3c3">
                                                    <div align="center">
                                                        <?php
                                                        //PRECIO DE VENTA POR CAJA
                                                        if (($valform == 1) and ($codpros == $codpro)) {
                                                        ?>
                                                            <input name="opPrevta4" type="text" id="opPrevta4" size="8" value="<?php echo $opPrevta4 ?>" onblur="filtraOpcionesCaja();" onkeyup="precio_caja_opcional()" onkeypress="return decimal(event);" />
                                                        <?php
                                                        } else {
                                                            echo $opPrevta4;
                                                        }
                                                        ?>
                                                    </div>
                                                </td>
                                                <td bgcolor="#7ab3c3">
                                                    <div align="center">
                                                        <?php
                                                        //PRECIO DE VENTA POR CAJA
                                                        if (($valform == 1) and ($codpros == $codpro)) {
                                                        ?>
                                                            <input name="opPreuni4" type="text" id="opPreuni4" size="8" value="<?php echo $opPreuni4 ?>" onblur="filtraOpcionesUnidad();" onkeypress="return decimal(event);" />
                                                        <?php
                                                        } else {
                                                            echo $opPreuni4;
                                                        }
                                                        ?>
                                                    </div>
                                                </td>
                                                <td bgcolor="#83ddab">
                                                    <div align="center">
                                                        <?php
                                                        //PRECIO DE VENTA POR CAJA
                                                        if (($valform == 1) and ($codpros == $codpro)) {
                                                        ?>
                                                            <input name="opPrevta5" type="text" id="opPrevta5" size="8" value="<?php echo $opPrevta5 ?>" onblur="filtraOpcionesCaja();" onkeyup="precio_caja_opcional()" onkeypress="return decimal(event);" />
                                                        <?php
                                                        } else {
                                                            echo $opPrevta5;
                                                        }
                                                        ?>
                                                    </div>
                                                </td>



                                                <td bgcolor="#83ddab">
                                                    <div align="center">
                                                        <?php
                                                        //PRECIO DE VENTA POR CAJA
                                                        if (($valform == 1) and ($codpros == $codpro)) {
                                                        ?>
                                                            <input name="opPreuni5" type="text" id="opPreuni5" size="8" value="<?php echo $opPreuni5 ?>" onblur="filtraOpcionesUnidad();" onkeypress="return decimal(event);" />
                                                        <?php
                                                        } else {
                                                            echo $opPreuni5;
                                                        }
                                                        ?>
                                                    </div>
                                                </td>
                                            <?php } ?>


                                            <?php if (($valform == 1) and ($codpros == $codpro)) { ?>
                                                <td>
                                                    <div align="center">

                                                        <input name="factor" type="hidden" id="factor" value="<?php echo $factor ?>" />
                                                        <input name="val" type="hidden" id="val" value="<?php echo $val ?>" />
                                                        <input name="margene1" type="hidden" id="margene1" value="" />
                                                        <input name="pcostouni" type="hidden" id="pcostouni" value="<?php echo $pcostouni ?>" />
                                                        <input name="search" type="hidden" id="search" value="<?php echo $search ?>" />
                                                        <input name="codpro" type="hidden" id="codpro" value="<?php echo $codpro ?>" />
                                                        <input name="costpr" type="hidden" id="costpr" value="<?php echo $costpr ?>" />
                                                        <input name="button" type="button" id="boton" onclick="validar_prod()" alt="GUARDAR" />
                                                        <!--   <input name="button2" type="button" id="boton1" onclick="validar_grid()" alt="ACEPTAR"/>-->

                                                    </div>
                                                </td>
                                                <td>
                                                    <div align="center">
                                                        <input name="button2" type="button" id="boton1" onclick="validar_grid()" alt="ACEPTAR" />
                                                    </div>
                                                </td>
                                            <?php
                                            } else {
                                            ?>
                                                <td colspan=" <?php echo $colspan; ?>">
                                                    <div align="center">
                                                        <a href="precios2.php?val=<?php echo $val ?>&search=<?php echo $search ?>&valform=1&codpros=<?php echo $codpro ?>">
                                                            <img src="../../../images/add1.gif" width="14" height="15" border="0" />
                                                        </a>
                                                    </div>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                        
                                    <?php } ?>
                                    
                                    <?php }
                                    ?>
                                     </tbody>
                                </table>
                            <?php
                                $cr++;
                            }
                        } else {
                            ?>
                            <div class='Estilo2fin' style="width:100%;">
                                <center>
                                    <h3>
                                        NO SE LOGRO ENCONTRAR NINGUN PRODUCTO CON LA DESCRIPCION INGRESADA REALIZA UNA NUEVA BUSQUEDA
                                    </h3>
                                </center>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </td>
            </tr>
        </table>
    </form>
</body>

</html>

<script>
    $(document).ready(function() {
            $('#customers').DataTable({
                 "pageLength": 100,
                     paging: true,
    lengthChange: false,
    searching: false,
    ordering: true,
    info: true,
    autoWidth: false,
    responsive: true,
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "NingÃºn dato disponible en esta tabla =(",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Ãltimo",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                    "buttons": {
                        "copy": "Copiar",
                        "colvis": "Visibilidad"
                    }
                }
            });
        }

    );
</script>