<?php
include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

            <title><?php echo $desemp ?></title>
            <link href="../../archivo/css/css/style1.css" rel="stylesheet" type="text/css" />
            <link href="../../archivo/css/css/tablas.css" rel="stylesheet" type="text/css" />
            <link href="puntos.css" rel="stylesheet" type="text/css" />
            
<link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
 <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  
            <style>
                #boton { background:url('../../../images/save_16.png') no-repeat; border:none; width:16px; height:16px; }
                #boton1 { background:url('../../../images/icon-16-checkin.png') no-repeat; border:none; width:16px; height:16px; }
                #habilitado { background:url('habilitado.png') no-repeat; border:none; width:30px; height:25px; }
                #deshabilitado { background:url('deshabilitado.png') no-repeat; border:none; width:30px; height:25px; }
            </style>
            <style type="text/css">


            </style>
            <script>
                function validar_grid()
                {
                    document.form1.method = "post";
                    document.form1.submit();
                }


                function validar_prod()
                {
                    var f = document.form1;

                    var v3 = parseFloat(document.form1.puntos.value);
                    var v1 = parseFloat(document.form1.p1.value);


                    if ((f.p1.value == "") || (f.p1.value == "0"))
                    {
                        alert("Ingrese una Cantidadww" + v1);
                        f.p1.focus();
                        return;
                    }
                    if (f.p3.value == "")
                    {
                        alert("Ingrese una descripcion");
                        f.p3.focus();
                        return;
                    }
                    if (v3 < v1)
                    {
                        alert("La cantidad ingresada excede a los puntos acomulados");
                        f.p1.focus();
                        return;
                    }

                    f.method = "post";
                    f.action = "grabar_datos1.php";
                    f.submit();
                }
                function validar_prod2() {
                    var f = document.form1;
                    var mensaje = confirm("DESEA GRABAR ESTA INFORMACION");
                    if (mensaje) {
                        f.method = "post";
                        f.action = "grabar_datos.php";
                        window.open('pre_imprimir.php', 'PopupName', 'toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=60,left=120,width=885,height=630');
                        f.submit();

                    } else {
                        f.method = "post";
                        f.action = "grabar_datos2.php";
                        f.submit();
                    }
                }



                function sf()
                {
                    document.form1.p1.focus();
                }
                function eliminar(valor) {
                    //    PARA HABILITAR
                    var f = document.form1;
                    ventana = confirm("Desea Habilitar este Registro de Puntos");
                    if (ventana) {
                        f.method = "post";
                        f.target = "_top";
                        f.action = "hab_salidas_puntos.php?codpumnt=" + valor;
                        f.submit();
                    }
                }
                function eliminar1(valor) {
                    //    PARA DESHABILITAR
                    var f = document.form1;
                    ventana = confirm("Desea Deshabilitar este Registro de Puntos");
                    if (ventana) {
                        f.method = "post";
                        f.target = "_top";
                        f.action = "des_salidas_puntos.php?codpumnt=" + valor;
                        f.submit();
                    }
                }
                function imprimirre(valor) {
                    //    PARA DESHABILITAR
                    var f = document.form1;
                    ventana = confirm("Desea reimprimir este registro de PUNTOS");
                    if (ventana) {
                        f.method = "post";
                        f.target = "_top";
                        f.action = "reimprimir.php?codpumnt=" + valor;
                        f.submit();
                    }
                }
            </script>
    </head>



    <?php
    $date = date('Y-m-d');


    $sql1 = "SELECT codloc FROM usuario where usecod = '$usuario'"; ////CODIGO DEL LOCAL DEL USUARIO
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $codloc = $row1['codloc'];
        }
    }
    $sql = "SELECT nomloc FROM xcompa where codloc = '$codloc'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $nomloc = $row['nomloc'];
        }
    }
    require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS
    require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUME
    require_once("../../../funciones/highlight.php"); //ILUMINA CAJAS DE TEXTOS
    require_once("tabla_local.php"); //LOCAL DEL USUARIO
    require_once("../../local.php"); //LOCAL DEL USUARIO

    $search = isset($_REQUEST['search']) ? ($_REQUEST['search']) : "";
    $val = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";
    $codclire = isset($_REQUEST['codclire']) ? ($_REQUEST['codclire']) : "";


    $sql = "SELECT * FROM usuario where usecod = '$usuario'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $user = $row['nomusu'];
        }
    }

    if ($codclire == "") {
        $sql = "SELECT codcli,descli,dnicli,puntos,dircli,ruccli FROM cliente where codcli = '$search'  ";
    } else {
        $sql = "SELECT codcli,descli,dnicli,puntos,dircli,ruccli FROM cliente where codcli = '$codclire'  ";
    }
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $codcli = $row['codcli'];
            $descli = $row['descli'];
            $puntos = $row['puntos'];
            $dnicli = $row['dnicli'];
            $dircli = $row['dircli'];
            $ruccli = $row['ruccli'];
        }
    }


    $sql1 = "SELECT COUNT(codtempun) as count  from temp_puntos WHERE usecod ='$usuario'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $count = $row1['count'];
        }
    }


    if ($codclire == "") {
        $sql1 = "SELECT COUNT(codpun) as countpun from puntos where codclic = '$search'  ";
    } else {
        $sql1 = "SELECT COUNT(codpun) as countpun from puntos where codclic = '$codclire'  ";
    }
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $countpun = $row1['countpun'];
        }
    }

    function formato($c) {
        printf("%08d", $c);
    }

    $codclis = isset($_REQUEST['codclis']) ? ($_REQUEST['codclis']) : "";
    $valform = isset($_REQUEST['valform']) ? ($_REQUEST['valform']) : "";
    ?>
    <body <?php if ($valform == 1) { ?>onload="sf();"<?php } ?>>
        <form id="form1" name="form1"  onKeyUp="highlight(event)" onClick="highlight(event)">
            <table width="100%" border="0" class="tabla2">
                <tr>
                    <td width="951"><table width="99%" border="0" align="center">
                            <tr>
                                <td width="9"></td>
                                <td width="116">&nbsp;</td>
                                <td width="10">	  </td>
                                <td width="191">&nbsp;</td>
                                <td width="300"><div align="right"><span class="text_combo_select"><strong>LOCAL :</strong> <img src="../../../images/controlpanel.png" width="16" height="16" /> <?php echo $nombre_local ?></span></div></td>
                                <td width="263"><div align="right"><span class="text_combo_select"><strong>USUARIO :</strong> <img src="../../../images/user.gif" width="15" height="16" /> <?php echo $user ?></span></div></td>
                            </tr>
                        </table>
                        <img src="../../../images/line2.png" width="100%" height="4" />
                        <br></br>
                        <?php if (($val == 1) && ($codclire == "")) { ?>
                            
                                <?php
                                if (($val == 1) && ($codclire == "")) {
//	  $sql="SELECT codcli,desprod,pcostouni,costre,margene,prevta,preuni,factor,codmar,blister,preblister FROM producto where codcli = '$search'";
                                    $sql = "SELECT codcli,descli,dnicli,puntos FROM cliente where codcli = '$search' or codcli='$codclii' ";
                                    $result = mysqli_query($conexion, $sql);
                                    if (mysqli_num_rows($result)) {
                                        ?>
                                        <table width="100%" border="0" align="center">
                                            
                                            <tr bgcolor="#4394be" height="30" > 
                                                <th width="180" style="color:#ffffff;font-size:17px;"><strong>CLIENTE</strong></th>
                                    <th  align="center" style="color:#ffffff;font-size:17px;"><strong>DNI</strong></th>
                            <!--        <th width="89"><div align="right"><strong>P. COSTO</strong></div></th>
                                    <th width="71"><div align="right"><strong>MARGEN % </strong></div></th>
                                    <th width="77"><div align="right"><strong>P. VENTA </strong></div></th>
                                    <th width="90"><div align="right"><strong>P. VENTA UNIT </strong></div></th>-->
                                    <th><div align="center" style="color:#ffffff;font-size:17px;"><strong>P. ACOMULADOS. </strong></div></th>
                                    <th ><div align="center" style="color:#ffffff;font-size:17px;"><strong>P. A DESCONTAR. </strong></div></th>
                                    <th ><div align="center" style="color:#ffffff;font-size:17px;"><strong>DESCRIPCION</strong></div></th>
                                    <?php if ($count == 0) { ?>
                                        <th ><div align="center" style="color:#ffffff;font-size:17px;"><strong> DESCONTAR</strong></div></th>
                                    <?php } else { ?>
                                        <th ><div align="center" style="color:#ffffff;font-size:17px;"><strong> GRABAR</strong></div></th>
                                    <?php } ?>
                                </tr>
                                            <?php
                                            while ($row = mysqli_fetch_array($result)) {
                                                $codcli = $row['codcli'];
                                                $descli = $row['descli'];
                                                $puntos = $row['puntos'];
                                                $dnicli = $row['dnicli'];



//                                $sql1="SELECT despunto FROM puntos where codclic ='$search' ";
//				$result1 = mysqli_query($conexion,$sql1);
//				if (mysqli_num_rows($result1)){
//				while ($row1 = mysqli_fetch_array($result1)){
//					$despunto    = $row1['despunto'];
//				}
//				}

                                                $sql1 = "SELECT pdescuento,despunto FROM temp_puntos where codclic ='$search' ";
                                                $result1 = mysqli_query($conexion, $sql1);
                                                if (mysqli_num_rows($result1)) {
                                                    while ($row1 = mysqli_fetch_array($result1)) {
                                                        $despunto = $row1['despunto'];
                                                        $pdescuento = $row1['pdescuento'];
                                                    }
                                                }
                                                $sql1 = "SELECT COUNT(codtempun) as count  from temp_puntos";
                                                $result1 = mysqli_query($conexion, $sql1);
                                                if (mysqli_num_rows($result1)) {
                                                    while ($row1 = mysqli_fetch_array($result1)) {
                                                        $count = $row1['count'];
                                                    }
                                                }
                                                ?>
                                                <tr onmouseover="this.style.backgroundColor = '#FFFF99';
                                                                        this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '#ffffff';">
                                                    <td width="250"><?php echo "<p class='Estilo2'>$descli</p>"; ?></td>
                                                    <td width="90"><?php echo "<p class='Estilo2'>$dnicli</p>"; ?></td>


                                                    <td width="20" align="center">
                                                        <?php
                                                        IF ($puntos <= 0) {
                                                            echo "<p class='Estilo1'>$puntos</p>";
                                                        } else {
                                                            echo "<H2> $puntos </H2>";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td width="40">
                                                        <div align="center">
                                                            <?php if (($valform == 1) and ( $codclis == $codcli)) { ?>
                                                                <input name="p1" type="text" id="p1" size="8" value=""   onkeypress="return acceptNum(event)" <?php
                                                                if ($puntos > 0) {
                                                                    
                                                                } else {
                                                                    ?>disabled="disabled"<?php } ?> />
                                                                <input name="puntos3" type="hidden" id="puntos4" value="<?php echo $pdescuento ?>" />
                                                                <input name="puntos" type="hidden" id="puntos" value="<?php echo $puntos ?>" />
                                                                <?php
                                                            } else {
                                                                echo $pdescuento;
                                                            }
                                                            ?>
                                                        </div>
                                                    </td>
                                                    <td width="80">
                                                        <div style="width: 75px; height: 75px;" align="center">
                                                            <?php if (($valform == 1) and ( $codclis == $codcli)) { ?>
                                                                            <!--<input name="p3" type="text" id="p3" size="20" value=""/>-->
                                                                <textarea name="p3" id="p3" cols="20" rows="4" class="Estilodany" <?php echo $despunto ?>  <?php
                                                                if ($puntos > 0) {
                                                                    
                                                                } else {
                                                                    ?>disabled="disabled"<?php } ?>></textarea>
                                                                          <?php
                                                                      } else {
                                                                          echo $despunto;
                                                                      }
                                                                      ?>
                                                        </div>			
                                                    </td>
                                                    <td width="15">
                                                        <div align="center">
                                                            <?php if (($valform == 1) and ( $codclis == $codcli)) { ?>
                                                                <input name="val" type="hidden" id="val" value="<?php echo $val ?>" />
                                                                <input name="date" type="hidden" id="date" value="<?php echo $date ?>" />
                                                                <input name="search" type="hidden" id="search" value="<?php echo $search ?>" />
                                                                <input name="codcli" type="hidden" id="codcli" value="<?php echo $codcli ?>" />
                                                                <!--<input name="button" type="button" id="boton" onclick="validar_prod()" alt="ACEPTAR"/>-->
                                                                <!--<input name="button" type="button" id="boton" onclick="validar_prod()" alt="GUARDAR"/>-->
                                                                <input name="button2" type="button" id="boton1"  title="ACEPTAR" onclick="validar_prod()" alt="ACEPTAR"/>
                                                                <?php
                                                            } else {
                                                                if ($count == 0) {
                                                                    ?>
                                                                    <a href="puntos2.php?val=<?php echo $val ?>&&search=<?php echo $search ?>&&valform=1&&codclis=<?php echo $codcli ?>">
                                                                        <img src="../../../images/add1.gif" width="14" height="15"  border="0"   />			  

                                                                    </a>
                                                                <?php } else { ?>
                                                                    
                                                                                                <!--<input name="button2" type="button" id="boton2" onclick="validar_prod2()" value="GUARDAR"/>-->
                                                                    <input name="button" type="button" id="boton" title="GUARDAR" onclick="validar_prod2()" alt="GUARDAR"/>
                                                                    <input name="codcli" type="hidden" id="codcli" value="<?php echo $codcli ?>" />
                                                                    <input name="val" type="hidden" id="val" value="<?php echo $val ?>" />
                                                                    <input name="search" type="hidden" id="search" value="<?php echo $search ?>" />
                                                                    <input name="u" type="hidden" id="u" value="<?php echo $usuario; ?>"/>
                                                                    <input name="c" type="hidden" id="c" value="<?php echo $codloc; ?>"/>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php }
                                            ?>
                                        </table>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        <?php } elseif (($val == 2) && ($countpun > 0)) { ?>
                            <div  style="border: 1px solid #dcc8a1;" width="920"  >
                                <table width="100%" border="0" bgcolor="#eceeef">
                                    <tr bgcolor="#cce0f4" style=" border-radius: 10px; " >
                                        <td colspan="8" style="padding: 0 0 0px 0;" align="center" bgcolor="#91cdfa"  style=" border-radius: 20px; " ><h2> INFORMACION DEL CLIENTE</h2></td>
                                    </tr>
                                    <tr >
                                        <td width="50" bgcolor="#91cdfa"  style=" border-radius:12px 0 0 12px;" ><strong>CLIENTE:</strong></td>
                                        <td width="300" bgcolor="#cce0f4" style=" border-radius:0 12px 12px 0;" ><pre ><?php ECHO $descli ?></pre></td>
                                        <?php if (($dnicli == "") && ($ruccli <> "")) { ?>
                                            <td width="10" bgcolor="#91cdfa"style=" border-radius:12px 0 0 12px;"  ><strong>RUC:</strong></td>
                                            <td bgcolor="#cce0f4" width="90" style=" border-radius:0 12px 12px 0;"  ><pre><?php ECHO $ruccli ?></pre></td>
                                        <?php } else { ?>
                                                    <td width="10" bgcolor="#91cdfa"style=" border-radius:12px 0 0 12px;"  ><strong>DNI:</strong></td>
                                                    <td bgcolor="#cce0f4" width="90" style=" border-radius:0 12px 12px 0;"  ><pre><?php ECHO $dnicli ?></pre></td>
                                        <?php } ?>
                                     <td width="10" bgcolor="#91cdfa" style=" border-radius:12px 0 0 12px;" ><strong>DIRECCION:</strong></td>
                                     <td width="300" bgcolor="#cce0f4" style=" border-radius:0 12px 12px 0;"  ><pre><?php ECHO $dircli ?></pre></td>
                                     <td width="100" bgcolor="#91cdfa" style=" border-radius:12px 0 0 12px;" ><strong>P. ACTUALES:</strong></td>
                                     <td width="50" bgcolor="#cce0f4" style=" border-radius:0 12px 12px 0; margin-left: 100px;"  ><pre><?php ECHO $puntos ?></pre></td>
                                </tr>
                            </table>
                        </div>
                        <br></br>
                        <img src="../../../images/line2.png" width="100%" height="4" />
                        <br></br>
                        <div class="scroll-div-tablas" id="TablaContenedor" style="height: auto;">
                            
                            <table bgcolor="#FFFFFF" width="100%"  align="center" cellspacing="0"     id="GridView11" style="border-collapse:collapse">
                       <thead id="Topicos_Cabecera_Datos">
                               <tr  style="font-size:12pt" class="GridviewScrollHeader">
                               <th style=" border-radius:12px 0 0 12px;" id="th" align="center" style="width: 5px;">N&ordm;</th>
                               <th id="th" align="center" style="width: 500px;">DESCRIPCION</th>
                               <th id="th" align="center" style="width: 10px;">DESCUENTO</th>
                               <th id="th" align="center" style="width: 80px;">FECHA</th>
                               <th id="th" align="center" style="width: 70px;">ESTADO</th>
                               <th id="th" align="center" style="width: 5px;">REIMPRIMIR</th>
                               <th id="th" align="right" style="width: 5px;border-radius:0 12px 12px 0;">DES/HAB</th>
                           </tr>
                           </thead>
                               <tbody id="gtnp_Listado_Datos">
                                        <?php
                                        $i = 1;
                                        if ($codclire == "") {
                                            $sql = "SELECT codpun,fecha,usecod,codclic,despunto,pdescuento,estado from puntos as P  WHERE  P.codclic ='$search' ";
                                        } else {
                                            $sql = "SELECT codpun,fecha,usecod,codclic,despunto,pdescuento,estado from puntos as P  WHERE  P.codclic ='$codclire' ";
                                        }
//                   if ($codclire == ""){
//                       echo $sql ."letra";
//                        }else{
//                   echo $sql."codig";
//                   }
                                        $result = mysqli_query($conexion, $sql);
                                        if (mysqli_num_rows($result)) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                $codpun = $row['codpun'];
                                                $fecha = $row['fecha'];
                                                $usecod = $row['usecod'];
                                                $codclic = $row['codclic'];
                                                $despunto = $row['despunto'];
                                                $pdescuento = $row['pdescuento'];
                                                $estado = $row['estado'];
                                                ?>
                                                                  <tr class="GridviewScrollItem"     bgcolor="#eaeff3"   onmouseover="this.style.backgroundColor = '#daecf3';
                                                                          this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '#eaeff3';">
                                                                      <td align="center" style='font-size: 12px;'><?php ECHO $i ?></td>
                                                                       
                                                                     
                                                    <?php if ($estado == 1) { ?>
                                                                                      <td title="<?php echo $despunto; ?>" ><div ><a style='font-size: 13px;' ><?php echo substr($despunto, 0, 55) ?></a></div></td>
                                                    <?php } else { ?>
                                                                                            <td title="<?php echo $despunto; ?>"><s style='font-size: 13px;color: #050505'><?php echo substr($despunto, 0, 55) ?></s></td>
                                                    <?php } ?>
                                                                            
                                                    <?php if ($estado == 1) { ?>
                                                                                            <td align="center" height="5px" style='font-size: 12px;'><?php ECHO $pdescuento . " " . "PUNTOS" ?></td>
                                                    <?php } else { ?>
                                                                                            <td align="center" height="5px"><s style='font-size: 12px;color: #050505'><?php ECHO $pdescuento . " " . "PUNTOS" ?></s></td>
                                                    <?php } ?>
                                                                            
                                                                      
                                                    <?php if ($estado == 1) { ?>
                                                                                            <td align="center" style='font-size: 12px;'><?php ECHO $fecha ?></td>
                                                    <?php } else { ?>
                                                                                            <td align="center" style='font-size: 12px;color: #050505'><s><?php ECHO $fecha ?></s></td>
                                                    <?php } ?>
                                                                            
                                                                      
                                                                                             
                                                                   
                                                                            <td align="center"> <?php if ($estado == 0) { ?><span  style='font-size: 13px;color: #fc714c'><b><s>ANULADO</s></b></span><?php } else { ?><span style='color:#4fa3e5;font-size: 13px;'><b>ACTIVADO</b></span><?php } ?></td>         
                                                                      
                                                                      
                                                                      <td align="center">
                                                        <?php if ($estado == 0) { ?>
                                                                                          <a title="SE ENCUENTRA DESHABILITADO NO SE PUEDE IMPRIMIR" ><img   src="printer2des.png" ></s></img></a>
                                                        <?php } else { ?>
                                                                                           <a title="HABILITADO" href="#" onclick="imprimirre(<?php echo $codpun ?>)"><img   src="printer2.png" ></img></a>
                                                        <?php } ?>
                                                                      </td>
                                                                            
                                                                       <td align="center"> <?php if ($estado == 0) { ?>
                                                                                           
                                                                                           <!--<span class="login" style='font-size: 10px;'><b>ANULADO</b></span>-->
                                                                                           <input name="deshabilitado" type="button" id="deshabilitado" title="CLIC HABILITAR" onclick="eliminar(<?php echo $codpun ?>)" />
                                                                                            <input name="codcli" type="hidden" id="codcli" value="<?php echo $codcli ?>" />
                                                                                            <input name="val" type="hidden" id="val" value="<?php echo $val ?>" />
                                                                                            <input name="codpum" type="hidden" id="codpum" value="<?php echo $codpun; ?>"/>
                                                                                            
                                                        <?php } else { ?>
                                                                                            <div>
                                                                                            <input name="habilitado" type="button" id="habilitado" title="CLIC DESHABILITAR" onclick="eliminar1(<?php echo $codpun ?>);" />
                                                                                            <input name="codclii" type="hidden" id="codclii" value="<?php echo $codcli ?>" />
                                                                                            <input name="val" type="hidden" id="val" value="<?php echo $val ?>" />
                                                                                            <input name="codpumn" type="hidden" id="codpumn" value="<?php echo $codpun; ?>"/>
                                                                                            </div>
                                                        <?php } ?>
                                                                       </td>         
                                                                  </tr>
                                                                  
                                                                   
                                                <?php
                                                $i++;
                                            }
                                        }
                                        ?>
                              </tbody>
                            </table>
                        </div>
                        
                        <?php } else { ?>
                            <?php IF ($val == 2) { ?>
                                        <div align="center" style='font-size: 15px;color: red;align:center'>EL CLIENTE <?php echo $descli; ?>  NO  PRESENTA NINGUN HISTORIAL DE PUNTOS </div>
                            <?php } ?> 
                        <?php } ?>
    </td>
  </tr>
</table>
</form>
</body>
</html>

<script>
    $(document).ready(function() {
    $('#GridView11').DataTable({
        language:{
    "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla =(",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
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

<!--<script type="text/javascript">
        $(document).ready(function () {
            gridviewScroll();
        });

        function gridviewScroll() {
            gridView1 = $('#GridView11').gridviewScroll({                               
                width: "100%",
                height: 700,
                freezesize: 0,
                 headerrowcount: 1
              });
    }

</script> -->