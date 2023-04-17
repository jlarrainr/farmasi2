<?php
include('../session_user.php');
require_once('../../conexion.php'); //CONEXION A BASE DE DATOS
require_once('../../titulo_sist.php');
require_once('../../convertfecha.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="gb18030">

    <title><?php echo $desemp ?></title>
    <link rel="icon" type="image/x-icon" href="../../iconoNew.ico" />
    <link href="css/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../css/body.css" rel="stylesheet" type="text/css" />
    <link href="../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/select_cli.css" rel="stylesheet" type="text/css" />
    <link href="../../funciones/alertify/alertify.min.css" rel="stylesheet" />
    <script src="../../funciones/alertify/alertify.min.js"></script>
    <link href="../select2/css/select2.min.css" rel="stylesheet" />
    <script src="../select2/jquery-3.4.1.js"></script>
    <script src="../select2/js/select2.min.js"></script>

    <script type="text/javascript" src="js/jquery.min.js"></script>

    <?php
    require_once("funciones/mov_cliente.php"); //FUNCIONES DE ESTA PANTALLA
    require_once("../../funciones/highlight.php"); //ILUMINA CAJAS DE TEXTOS
    require_once("../../funciones/functions.php"); //DESHABILITA TECLAS
    require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    require_once("../local.php"); //LOCAL DEL USUARIO

    $error = isset($_REQUEST['error']) ? $_REQUEST['error'] : "";


    

    function comprobar_email($email)
    {
        $mail_correcto = 0;
        //compruebo unas cosas primeras
        if ((strlen($email) >= 6) && (substr_count($email, "@") == 1) && (substr($email, 0, 1) != "@") && (substr($email, strlen($email) - 1, 1) != "@")) {
            if ((!strstr($email, "'")) && (!strstr($email, "\"")) && (!strstr($email, "\\")) && (!strstr($email, "\$")) && (!strstr($email, " "))) {
                //miro si tiene caracter .
                if (substr_count($email, ".") >= 1) {
                    //obtengo la terminacion del dominio
                    $term_dom = substr(strrchr($email, '.'), 1);
                    //compruebo que la terminación del dominio sea correcta
                    if (strlen($term_dom) > 1 && strlen($term_dom) < 5 && (!strstr($term_dom, "@"))) {
                        //compruebo que lo de antes del dominio sea correcto
                        $antes_dom = substr($email, 0, strlen($email) - strlen($term_dom) - 1);
                        $caracter_ult = substr($antes_dom, strlen($antes_dom) - 1, 1);
                        if ($caracter_ult != "@" && $caracter_ult != ".") {
                            $mail_correcto = 1;
                        }
                    }
                }
            }
        }
        if ($mail_correcto)
            return 1;
        else
            return 0;
    }

    $sql = "SELECT nomusu FROM usuario where usecod = '$usuario'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $user = $row['nomusu'];
        }
    }
    $pag = $_REQUEST['pageno'];
    if (isset($_REQUEST['pageno'])) {
        $pageno = $_REQUEST['pageno'];
    } else {
        $pageno = 1;
    }
    $sql = "SELECT count(codcli) FROM cliente";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $numrows = $row[0];
        }
    }
    $busqueda = $_REQUEST['country_ID'];
    $search = $_REQUEST['search'];  ////1 ACTIVO
    $word = $_REQUEST['word'];   ////PALABRA BUSCADA
    if ($search == "") {
        $search = 0;
        $busqueda = "";
    }
    /////SELECCIONO EL ULTIMO CODIGO
    $sql = "SELECT codcli FROM cliente order by codcli desc limit 1";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $fincod = $row[0];
        }
    } else {
        $fincod = 0;
    }

    $sql_token = "SELECT token FROM datagen  ";
    $result_token = mysqli_query($conexion, $sql_token);
    if (mysqli_num_rows($result_token)) {
        while ($row_token = mysqli_fetch_array($result_token)) {
            $token = $row_token["token"];
        }
    }


    /////////////////////////////////
    $rows_per_page = 1;
    $lastpage = ceil($numrows / $rows_per_page);
    $pageno = (int) $pageno;
    if ($pageno > $lastpage) {
        $pageno = $lastpage;
    } // if
    if ($pageno < 1) {
        $pageno = 1;
    } // if
    $limit = 'LIMIT ' . ($pageno - 1) * $rows_per_page . ',' . $rows_per_page;
    //echo '$limit = '.$limit;
    if ($search == 1) {
        $sql = "SELECT codcli,descli,dircli,discli,dptcli,procli,telcli,telcli1,email,contact,ruccli,dnicli,limite,usado,estatus,ultfec,ulvta,tracli,vencli,cobcli,tipcli, sucursal,delivery,limiteCredito FROM cliente where codcli= '$busqueda'";
    } else {
        $sql = "SELECT codcli,descli,dircli,discli,dptcli,procli,telcli,telcli1,email,contact,ruccli,dnicli,limite,usado,estatus,ultfec,ulvta,tracli,vencli,cobcli,tipcli , sucursal,delivery,limiteCredito FROM cliente $limit";
    }
    //echo $sql;
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $codcli = $row["codcli"];  //codgio
            $descli = $row["descli"];  //nombre
            $dircli = $row["dircli"];  //direccion
            $discli = $row["discli"];  //distrito
            $dptcli = $row["dptcli"];  //departamento
            $procli = $row["procli"];  //provincia
            $telcli = $row["telcli"];  //telefono
            $telcli1 = $row["telcli1"];  //telefono  
            $email = $row["email"];  //email 
            $contact = $row["contact"];  //propietario
            $ruccli = $row["ruccli"];  //ruc
            $dnicli = $row["dnicli"];  //ruc
            $limite = $row["limite"];  //credito limite
            $usado = $row["usado"];  //credito usado
            $estatus = $row["estatus"];  //Atender preferentemente, 2=Atender normalmente
            $ultfec = fecha($row["ultfec"]);  //ULTIMA FECHA VENTA
            $ulvta = $row["ulvta"];  //ULTIMO MONTO
            $tracli = $row["tracli"];  //TRANSPORTISTA
            $vencli = $row["vencli"];  //VENDEDOR
            $cobcli = $row["cobcli"];  //COBRADOR
            $tipcli = $row["tipcli"];  //COBRADOR
            $sucursal = $row["sucursal"];  //COBRADOR
            $delivery = $row["delivery"];  //COBRADOR
            $limiteCredito = $row["limiteCredito"];  //COBRADOR
            $sql1 = "SELECT nombre,nomloc FROM xcompa where codloc = '$sucursal'";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $local1 = $row1["nombre"];  //COBRADOR
                    $local2 = $row1["nomloc"];  //COBRADOR
                }
            }
            if ($local1 == '') {
                $sucursal = $local2;
            } else {
                $sucursal = $local1;
            }

            if ($email <> "") {

                $emailres = comprobar_email($email);
            }
        }
    } else {
        $codcli = 1;
    }
    ?>
    <?php
    require_once("funciones/call_combo.php"); //LLAMA A generaSelect
    require_once("../../funciones/botones.php"); //COLORES DE LOS BOTONES
    ?>
    <script src="../../funciones/control.js"></script>
    <!-- <script type="text/javascript" language="JavaScript1.2" src="../menu_block/stmenu.js"></script> -->
    <script type="text/javascript" src="funciones/select_3_niveles.js"></script>


    <style>
        .boton_personalizado_RUC {
            text-decoration: none;
            padding: 2px;
            font-weight: 600;
            font-size: 11px;
            color: #bf0909;
            background-color: #f8f8f8;
            border-radius: 6px;
            border: 1px solid #bf0909;
        }

        .boton_personalizado_RUC:hover {
            color: #ffffff;
            background-color: #bf0909;
        }

        .boton_personalizado_DNI {
            text-decoration: none;
            padding: 2px;
            font-weight: 600;
            font-size: 11px;
            color: #074897;
            background-color: #f8f8f8;
            border-radius: 6px;
            border: 1px solid #074897;
        }

        .boton_personalizado_DNI:hover {
            color: #ffffff;
            background-color: #074897;
        }
    </style>

    <style>
        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers th {
            border: 1px solid #ddd;
            padding: 1px;

        }

        #customers td {
            border: 1px solid #ddd;
            padding: 5px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #e9e8eb;
        }

        #customers th {
            padding: 2px;
            text-align: left;
            background-color: #2e91d2;
            color: white;
            font-size: 15px;
        }
    </style>
</head>

<body onLoad="sf();">
    <?php

    function formato($c)
    {
        printf("%08d", $c);
    }

    function formato1($c)
    {
        printf("%06d", $c);
    }
    ?>
    <div class="tabla1">
        <script type="text/javascript" language="JavaScript1.2" src="../menu_block/men.js"></script>
        <div class="title">



            <table width="100%" border="0">
                <tr>

                    <td align="left"><span class="titulos">
                            Mantenimiento de Clientes
                            <b>
                                <?php
                                $up = $_REQUEST['up'];
                                $del = $_REQUEST['del'];
                                $error = $_REQUEST['error'];
                                $ok = $_REQUEST['ok'];
                                $publico = $_REQUEST['publico_general'];
                                if ($error == 2 || $error == 1)  {
                                ?>
                                    <!--<font color="#FF0000" size="-2">ERROR!</font><font color="#FFFF66" size="-2"> - NO SE PUDO GRABAR!. LOS DATOS INGRESADOS YA SE ENCUENTRAN REGISTRADOS.</font>-->
                                    <script>
                                        alertify.set('notifier', 'position', 'top-right');
                                        alertify.error("<h3 style='color:White;font-size:12px;font-weight: bold;'>ERROR! - NO SE PUDO GRABAR!. LOS DATOS INGRESADOS YA SE ENCUENTRAN REGISTRADOS..</h3>", alertify.get('notifier', 'position'));
                                    </script>
                                <?php
                                }
                                if ($ok == 1) {
                                ?>
                                    <!--<font color="#FFFF66" size="-2">- SE LOGRO GRABAR EXITOSAMENTE LOS DATOS</font>-->

                                    <script>
                                        alertify.set('notifier', 'position', 'top-right');
                                        alertify.success("<h3 style='color:White;font-size:12px;font-weight: bold;'>SE LOGRO GRABAR EXITOSAMENTE LOS DATOS.</h3>", alertify.get('notifier', 'position'));
                                    </script>
                                <?php
                                }
                                if ($up == 1) {
                                ?>
                                    <!--<font color="#FFFF66" size="-2">- SE LOGRO ACTUALIZAR EL CLIENTE SELECCIONADO</font>-->
                                    <script>
                                        alertify.set('notifier', 'position', 'top-right');
                                        alertify.success("<h3 style='color:White;font-size:12px;font-weight: bold;'>SE LOGRO ACTUALIZAR EL CLIENTE SELECCIONADO.</h3>", alertify.get('notifier', 'position'));
                                    </script>
                                <?php
                                }
                                if ($del == 1) {
                                ?>
                                    <!--<font color="#FFFF66" size="-2">- SE LOGRO ELIMINAR EL CLIENTE INDICADO</font>-->

                                    <script>
                                        alertify.set('notifier', 'position', 'top-right');
                                        alertify.success("<h3 style='color:White;font-size:12px;font-weight: bold;'>SE LOGRO ELIMINAR EL CLIENTE INDICADO.</h3>", alertify.get('notifier', 'position'));
                                    </script>
                                <?php }
                                ?>
                                <?php
                                if ($publico == 1) {
                                ?>

                                    <script>
                                        alertify.set('notifier', 'position', 'top-right');
                                        alertify.error("<h3 style='color:White;font-size:12px;font-weight: bold;'>NO SE PUDE ELIMINAR NI MODIFICAR AL CLIENTE 'PUBLICO EN GENERAL' DATO PREDETERMINADO DEL SISTEMA.</h3>", alertify.get('notifier', 'position'));
                                    </script>
                                <?php
                                }
                                ?>
                            </b>
                        </span></td>
                    <td align="right"><a href="http://www.farmasis.site/" target="_blank"><img src="http://www.farmasis.site/wp-content/BANNER/FARMASIS.png" width="210" height="30" /> </a></td>
                    <td align="left"><span class="titulos" style="color: <?php echo $coloruniversal; ?>;font-weight: 900;font-size: <?php echo $letrauniversal; ?>px;"><?php echo $nmensajeuniversal; ?></span></td>

                    <!--<td align="right"><a href="http://www.farmasis.site/" target="_blank"><img src="../../css/FARMASIS.png" width="210" height="32"  /> </a></td>-->

                </tr>
            </table>
        </div>


        <div class="mask1" style="height: auto;margin-bottom: 12px;">
            <div class="mask2" style="height: auto;margin-bottom: 12px;">
                <div class="mask3" style="height: auto;margin-bottom: 12px;">
                    <?php require('mov_cliente1.php'); ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script>
    $('#tipo').select2();
    $('#vendedor').select2();
    $('#cobrador').select2();
    $('#transport').select2();
</script>