<?php
include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
require_once('../../../convertfecha.php');
$ct = 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title><?php echo $desemp ?></title>
  <link href="../css/css/style1.css" rel="stylesheet" type="text/css" />
  <link href="../css/css/tablas.css" rel="stylesheet" type="text/css" />

  <link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
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
  </style>
  <?php $cr = isset($_REQUEST['cr']) ? ($_REQUEST['cr']) : "";
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
      f.method = "post";
      f.action = "grabar_datos.php";
      f.submit();
    }

    function sf() {
      document.form1.p2.focus();
    }
    var nav4 = window.Event ? true : false;

    function ent(evt) {
      var key = nav4 ? evt.which : evt.keyCode;
      if (key == 13) {
        var f = document.form1;
        f.method = "post";
        f.action = "grabar_datos.php";
        f.submit();
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
                function filtra()
                {
                    var v1 = parseFloat(document.form1.p1.value); //costo promedio
                    var v2 = parseFloat(document.form1.p2.value); //PRECIO VENTA caja
                    var v3 = parseFloat(document.form1.p3.value); //PRECIO VENTA UNITARIO
                    var factor = parseFloat(document.form1.factor.value); //FACTOR
                    var f_unitario= v1/factor;
                    if (v2 < v1) {
                        document.getElementById("seguridad").innerHTML = 'Cuidado el precio de venta caja es menor al costo, tendra perdidas.  ';
                        document.getElementById("seguridad").style.color = "red";
                    }else if(v3 < f_unitario){ 
                        document.getElementById("seguridad").innerHTML = 'Cuidado el precio de venta unitario es menor al costo, tendra perdidas.  ';
                        document.getElementById("seguridad").style.color = "#fdab4f";
                    }else {
                        document.getElementById("seguridad").innerHTML = '';
                        document.getElementById("seguridad").style.color = "#ffffff";
                    }
                }
                
                function precio_caja()
                {
                    var f = document.form1;
                    //var v1 		= parseFloat(document.form1.p1.value);			//PRECIO COSTO
                    var v1 = parseFloat(document.form1.p2.value); //PRECIO VENTA
                    var factor = parseFloat(document.form1.factor.value); //FACTOR
                    //var pcu         = parseFloat(document.form1.pcostouni.value);           //PCOSTO
                    var pcu = parseFloat(document.form1.p1.value); //PCOSTO
                    if (factor === 0)
                    {
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
                function precio_unidad()
                {
                    var f = document.form1;
                    var v1 = parseFloat(document.form1.p3.value); //PRECIO VENTA UNITARIO
                    var factor = parseFloat(document.form1.factor.value); //FACTOR
                    //var pcu         = parseFloat(document.form1.pcostouni.value);           //PCOSTO
                    var pcu = parseFloat(document.form1.p1.value); //PCOSTO
                    if (factor === 0)
                    {
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
            var pCaja = parseFloat(document.form1.pCaja.value);
            var pUNI = parseFloat(document.form1.pUNI.value);
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
            var pCaja = parseFloat(document.form1.pCaja.value);
            var pUNI = parseFloat(document.form1.pUNI.value);
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
  </script>
  <style>
    .table {
      border: 1px solid black;
      border-collapse: collapse;
    }

    .LETRA {
      font-family: Tahoma;
      font-size: 11px;
      line-height: normal;
      color: '#5f5e5e';
      font-weight: bold;
    }

    input {
      box-sizing: border-box;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 12px;
      background-color: white;
      background-position: 3px 3px;
      background-repeat: no-repeat;
      padding: 2px 1px 2px 5px;

    }

    .LETRA2 {
      background: #d7d7d7
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
      background-color: #f0ecec;
    }

    #customers tr:hover {
      background-color: #ddd;
    }

    #customers thead th {

      text-align: center;
      background-color: #50ADEA;
      color: white;
      font-size: 12px;
      font-weight: 900;
    }

    #example thead th {

      text-align: center;
      background-color: #50ADEA;
      color: white;
      font-size: 12px;
      font-weight: 900;
    }
  </style>
</head>
<?php
require_once("../../../funciones/functions.php");  //DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");  //IMPRIMIR-NUME
require_once("../../../funciones/highlight.php");  //ILUMINA CAJAS DE TEXTOS
require_once("tabla_local.php");  //LOCAL DEL USUARIO
require_once("../../local.php");  //LOCAL DEL USUARIO
$search = isset($_REQUEST['search']) ? ($_REQUEST['search']) : "";
$val    = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";

$sql = "SELECT nomusu,codloc FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
  while ($row = mysqli_fetch_array($result)) {
    $user    = $row['nomusu'];
    $sucursal    = $row['codloc'];
  }
}

//**CONFIGPRECIOS_PRODUCTO**//
$nomlocalG = "";
$sqlLocal = "SELECT nomloc FROM xcompa where habil = '1' and codloc = '$sucursal'";
$resultLocal = mysqli_query($conexion, $sqlLocal);
if (mysqli_num_rows($resultLocal)) {
  while ($rowLocal = mysqli_fetch_array($resultLocal)) {
    $nomlocalG = $rowLocal['nomloc'];
  }
}

$numero_xcompa = substr($nomlocalG, 5, 2);
$tabla = "s" . str_pad($numero_xcompa, 3, "0", STR_PAD_LEFT);

if ($tabla == 's001') {

  $campo_prevta = "prevta1";
  $campo_preuni = "preuni1";
} elseif ($tabla == 's002') {

  $campo_prevta = "prevta2";
  $campo_preuni = "preuni2";
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
  <form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">
    <table width="100%" border="0" class="tabla2">
      <tr>
        <td>
          <table  border="0" align="center">
            <tr>

                <td width="70%">	 <div id="seguridad" style="font-size:20px;"><strong></strong></div> </td>

                <td width="10%"><div align="right"><span class="text_combo_select"><strong>LOCAL:</strong> <img src="../../../images/controlpanel.png" width="16" height="16" /> <?php echo $nombre_local ?></span></div></td>
                <td width="20%"><div align="right"><span class="text_combo_select"><strong>USUARIO :</strong> <img src="../../../images/user.gif" width="15" height="16" /> <?php echo $user ?></span></div></td>
            </tr>
        </table>

          <div align="center"><img src="../../../images/line2.png" width="100%" height="4" />
            <?php
            if ($val <> "") {
              if ($val == 1) {
                  
                  if(is_numeric($search)) {
                      //echo 'numero';
                      $sql = "SELECT codpro,desprod,pcostouni,costpr,margene,factor,codmar,stopro,$tabla,$campo_prevta,$campo_preuni FROM producto where codbar = '$search' or codpro = '$search'";
                  }else{
                     // echo 'letra';
                      $sql = "SELECT codpro,desprod,pcostouni,costpr,margene,factor,codmar,stopro,$tabla,$campo_prevta,$campo_preuni FROM producto where desprod like '%$search%' ";
                  }
              }
              if ($val == 2) {
                $sql = "SELECT codpro,desprod,pcostouni,costpr,margene,factor,codmar,stopro,$tabla,$campo_prevta,$campo_preuni FROM producto where codmar = '$search'";
              }
              if ($val == 3) {
                $sql = "SELECT codpro,desprod,pcostouni,costpr,margene,factor,codmar,stopro,$tabla,$campo_prevta,$campo_preuni FROM producto where $tabla > 0";
              }
              if ($val == 4) {
                $sql = "SELECT codpro,desprod,pcostouni,costpr,margene,factor,codmar,stopro,$tabla,$campo_prevta,$campo_preuni FROM producto where prevta <> $campo_prevta or preuni <> $campo_preuni ";
              }
              $result = mysqli_query($conexion, $sql);
              if (mysqli_num_rows($result)) {
            ?>
                <table id="customers" class="display" style="width:100%">
                  <thead>
                    <tr>
                      <th><strong>CODIGO</strong></th>
                      <th><strong>PRODUCTO</strong></th>
                      <th>
                        <div align="left"><strong>MARCA/LABORATORIO</strong></div>
                      </th>
                      <th>
                        <div align="center"><strong>FACTOR</strong></div>
                      </th>
                      <th>
                        <div align="left"><strong>STOCK ACTUAL</strong></div>
                      </th>
                      <th>
                        <div align="right"><strong>COSTO PROMEDIO</strong></div>
                      </th>
                      <th>
                        <div align="right"><strong>P. VENTA x CAJA</strong></div>
                      </th>
                      <th>
                        <div align="right"><strong>P. VENTA x UNIT </strong></div>
                      </th>
                      <th>
                        <div align="right"><strong>% UT X CAJA </strong></div>
                      </th>
                      <th>
                        <div align="right"><strong>% UT X UNI </strong></div>
                      </th>
                      <th colspan=" <?php echo $colspan; ?>">
                        <div align="center"><strong><?php echo $accion; ?></strong></div>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $cr = 1;
                    $cont = 1;
                    while ($row = mysqli_fetch_array($result)) {

                      $codpro         = $row['codpro'];
                      $desprod        = $row['desprod'];
                      $pcostouni      = $row['pcostouni'];
                      $costpr         = $row['costpr'];
                      $margene        = $row['margene'];
                      $factor         = $row['factor'];
                      $codmar         = $row['codmar'];
                      $stopro         = $row['stopro'];
                      $stoproLoc      = $row[8];
                      $prevta         = $row[9];
                      $preuni         = $row[10];

                      $pcostouni = $costpr / $factor;
                      $sql1 = "SELECT destab FROM titultabladet where tiptab = 'M' and codtab = '$codmar'";
                      $result1 = mysqli_query($conexion, $sql1);
                      if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                          $destab    = $row1['destab'];
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
                                        if ($costpr <> 0) {


                                            $pC = (($prevta - $costpr) / $costpr) * 100;
                                            $pC = number_format($pC, 2, '.', ' ');
                                        } else {

                                            $pC = 0;
                                        }
                                        ////PORCENTAJE DE RENTABILIDAD POR UNIDAD

                                        if ($costpr <> 0) {
                                            $pU = (($preuni - ($costpr / $factor)) / ($costpr / $factor)) * 100;
                                            $pU = number_format($pU, 2, '.', ' ');
                                        } else {
                                            $pU = 0;
                                        }
                    ?>
                      <tr bgcolor="<?php echo $color; ?>" onmouseover=this.style.backgroundColor='#FFFF99' ;this.style.cursor='hand' ; onmouseout=this.style.backgroundColor="<?php echo $color; ?>" ;>
                       <td ><div align="center"><?php echo $codpro; ?></div></td>
                        <td><a id="l<?php echo $cr; ?>" href="precios2.php?val=<?php echo $val ?>&search=<?php echo $search ?>&valform=1&codpros=<?php echo $codpro ?>"><?php echo $desprod ?></a></td>
                        <td>
                          <div align="left"><?php echo $destab ?></div>
                        </td>
                        <td>
                          <div align="center"><?php echo  $factor;  ?></div>
                        </td>
                        <td>
                          <div align="left"><?php echo stockcaja($stopro, $factor);  ?></div>
                        </td>
                        <td>
                          <div align="right">
                            <?php if (($valform == 1) and ($codpros == $codpro)) {/*?>
			                    <input name="p1" type="text" id="p1" size="8" value="<?php echo $pcostouni?>" onkeypress="return decimal(event);" disabled="disabled"/>*/ ?>
                                <input name="p1" type="text" id="p1" size="8" value="<?php echo $costpr ?>" onkeypress="return decimal(event);"  />
                            <?php } else {
                              echo $costpr;
                            }
                            ?>
                          </div>
                        </td>
                        <td>
                          <div align="right">
                            <?php
                            //PRECIO DE VENTA POR CAJA
                            if (($valform == 1) and ($codpros == $codpro)) { ?>
                              <input name="p2" type="text" id="p2" size="8" value="<?php echo $prevta ?>" onkeypress="return ent(event);" onkeyup="precio_caja()" onblur="filtra();" />
                            <?php } else {
                              echo $prevta;
                            }
                            ?>
                          </div>
                        </td>
                        <td>
                          <div align="right">
                            <?php
                            //PRECIO DE VENTA POR UNIDAD
                            if (($valform == 1) and ($codpros == $codpro)) {
                            ?>
                              <input name="p3" type="text" id="p3" size="8" value="<?php echo $preuni ?>" onkeypress="return ent(event);" onkeyup="precio_unidad();" <?php if ($factor == 1) { ?>readonly<?php } ?> />
                            <?php
                            } else {
                              echo $preuni;
                            }
                            ?>
                          </div>
                        </td>
                        <td>
                          <div align="right">
                            <?php
                            
                            ////PORCENTAJE DE RENTABILIDAD POR CAJA
                            if (($valform == 1) and ($codpros == $codpro)) {

                            ?>
                              <input name="pCaja" type="text" id="pCaja" size="8" value="<?php echo $pC ?>" onkeyup="precio_porcentaje_caja();" onkeypress="return ent(event);" onblur="filtra();"/>
                            <input name="factorc" type="hidden" id="factorc" value="<?php echo $factor ?>" />
                            <?php
                            } else {
                              echo $pC;
                            }
                            ?>
                          </div>
                        </td>
                        <td>
                          <div align="right">
                            <?php
                            
                            //echo $factor;
                            if (($valform == 1) and ($codpros == $codpro)) {
                            ?>
                              <input name="pUNI" type="text" id="pUNI" size="8" value="<?php echo $pU ?>" onkeyup="precio_porcentaje_unidad();" onkeypress="return ent(event);" <?php if ($factor == 1) { ?>readonly<?php } ?>/>
                            <?php
                            } else {
                              echo $pU;
                            }
                            ?>
                          </div>
                        </td>
                          <?php if (($valform == 1) and ($codpros == $codpro)) { ?>
                        <td>
                          <div align="center">
                          
                              <input name="factor" type="hidden" id="factor" value="<?php echo $factor ?>" />
                              <input name="val" type="hidden" id="val" value="<?php echo $val ?>" />
                              <input name="margene1" type="hidden" id="margene1" value="" />
                              <input name="pcostouni" type="hidden" id="pcostouni" value="<?php echo $pcostouni ?>" />
                              <input name="search" type="hidden" id="search" value="<?php echo $search ?>" />
                              <input name="codpro" type="hidden" id="codpro" value="<?php echo $codpro ?>" />
                              <input name="TablaD" type="hidden" id="TablaD" value="<?php echo $tabla; ?>" />
                              <input name="button" type="button" id="boton" onclick="validar_prod()" alt="GUARDAR" />
                            <!--  <input name="button2" type="button" id="boton1" onclick="validar_grid()" alt="ACEPTAR" />-->
                            
                          </div>
                        </td>
                        <td>
                            <div align="center">
                            <input name="button2" type="button" id="boton1" onclick="validar_grid()" alt="ACEPTAR" />
                            </div>
                        </td>
                        <?php } else {
                            ?>
                            <td colspan=" <?php echo $colspan; ?>">
                                <div align="center">
                                <a href="precios2.php?val=<?php echo $val ?>&search=<?php echo $search ?>&valform=1&codpros=<?php echo $codpro ?>">
                                    <img src="../../../images/add1.gif" width="14" height="15" border="0" /> 
                                </a>
                             </div>
                            </td>
                            <?php }
                            ?>
                      </tr>
                    <?php }
                    ?>
                  </tbody>
                </table>
            <?php $cr++;
              }
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
      $('#example').DataTable({
        language: {
          "sProcessing": "Procesando...",
          "sLengthMenu": "Mostrar _MENU_ registros",
          "sZeroRecords": "No se encontraron resultados",
          "sEmptyTable": "Ningún dato disponible en esta tabla =(",
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
            "sLast": "Último",
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