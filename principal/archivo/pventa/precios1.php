<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

            <title>Documento sin t&iacute;tulo</title>
            <link href="../css/css/style.css" rel="stylesheet" type="text/css" />
            <link href="../css2/css/tablas.css" rel="stylesheet" type="text/css" />
            <link href="../../../css/style.css" rel="stylesheet" type="text/css" />

            <link href="../../select2/css/select2.min.css" rel="stylesheet" />
            <script src="../../select2/jquery-3.4.1.js"></script>
            <script src="../../select2/js/select2.min.js"></script>
            <?php require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS?>
            <?php //require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS?>
            <?php require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES?>
            <?php require_once("../../../funciones/botones.php"); //COLORES DE LOS BOTONES?>
            <?php
            require_once("../../local.php"); //LOCAL DEL USUARIO
            $sql = "SELECT nomusu FROM usuario where usecod = '$usuario'";
            $result = mysqli_query($conexion, $sql);
            if (mysqli_num_rows($result)) {
                while ($row = mysqli_fetch_array($result)) {
                    $user = $row['nomusu'];
                }
            }
            $sql = "SELECT nlicencia FROM datagen ";
            $result = mysqli_query($conexion, $sql);
            if (mysqli_num_rows($result)) {
                while ($row = mysqli_fetch_array($result)) {
                    $nlicencia = $row['nlicencia'];
                }
            }
            $val1 = isset($_REQUEST['val1']) ? ($_REQUEST['val1']) : "";
            $val2 = isset($_REQUEST['val2']) ? ($_REQUEST['val2']) : "";
            $val3 = isset($_REQUEST['val3']) ? ($_REQUEST['val3']) : "";
            $produc = isset($_REQUEST['country']) ? ($_REQUEST['country']) : "";
            $local = isset($_REQUEST['local']) ? ($_REQUEST['local']) : "";
            $marca = isset($_REQUEST['marca']) ? ($_REQUEST['marca']) : "";
            if ($val1 == 1) {
                $sql = "SELECT desprod FROM producto where desprod like '$produc%'";
                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) {
                    while ($row = mysqli_fetch_array($result)) {
                        $desprod = $row['desprod'];
                    }
                }
                $val = $val1;
                $search = $produc;
            }
            if ($val1 == 2) {

                $val = 4;
            }
            if ($val2 == 2) {
                $sql = "SELECT destab FROM titultabladet where codtab = '$marca1'";
                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) {
                    while ($row = mysqli_fetch_array($result)) {
                        $destab = $row['destab'];
                    }
                }
                $val = $val2;
                $search = $marca;
            }
            if ($val3 == 3) {
                $sql = "SELECT nomloc FROM xcompa where habil = '1' and codloc = '$local1'";
                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) {
                    while ($row = mysqli_fetch_array($result)) {
                        $nomloc = $row['nomloc'];
                    }
                }
                $val = $val3;
                $search = $local;
            }
            ?>
            <script type="text/javascript" language="JavaScript1.2" src="/comercial/funciones/control.js"></script>
            <script>
                function salir()
                {
                    var f = document.form1;
                    f.method = "POST";
                    f.target = "_top";
                    f.action = "../../index.php";
                    f.submit();
                }
                function buscar()
                {
                    var f = document.form1;
                    if (f.country.value == "")
                    {
                        alert("Ingrese el Producto para iniciar la Busqueda");
                        f.country.focus();
                        return;
                    }
                    f.val3.value = 0;
                    f.val2.value = 0;
                    f.submit();
                }
                function lp1()
                {
                    var f = document.form1;
                    f.val1.value = 0;
                    f.val3.value = 0;
                    f.submit();
                }
                function lp2()
                {
                    var f = document.form1;
                    f.val1.value = 0;
                    f.val2.value = 0;
                    f.submit();
                }
                function sf()
                {
                    document.form1.country.focus();
                }
                var nav4 = window.Event ? true : false;
                function ent(evt)
                {
                    var key = nav4 ? evt.which : evt.keyCode;
                    if (key == 13)
                    {
                        var f = document.form1;
                        if (f.country.value == "")
                        {
                            alert("Ingrese el Producto para iniciar la Busqueda");
                            f.country.focus();
                            return;
                        }
                        f.val3.value = 0;
                        f.val2.value = 0;
                        f.submit();
                    }
                }
                function pDiferentes()
                {
                    var f = document.form1;
                    f.val1.value = 2;
                    f.val3.value = 0;
                    f.val2.value = 0;
                    f.submit();
                }
            </script>
            <style>
                .table {
                    border: 1px solid black;
                    border-collapse: collapse;
                }

                .LETRA{
                    font-family:Tahoma;
                    font-size:11px;
                    line-height:normal;
                    color:'#5f5e5e';
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
                .LETRA2{
                    background:#d7d7d7
                }


                #customers {
                    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                    border-collapse: collapse;
                    width: 100%;

                }

                #customers td, #customers th {
                    border: 1px solid #ddd;
                    padding: 3px;

                }
                #customers td a{
                    color: #4d9ff7;
                    font-weight: bold;
                    font-size:15px;
                    text-decoration: none;

                }

                #customers #total {

                    text-align: center;
                    background-color: #9ebcc1;
                    color: white;
                    font-size:14px;
                    font-weight: 900;
                }

                #customers tr:nth-child(even){background-color: #f0ecec;}

                #customers tr:hover {background-color: #ddd;}

                #customers th {

                    text-align: center;
                    background-color: #50ADEA;
                    color: white;
                    font-size:12px;
                    font-weight: 900;
                }
              .tablarepor {
             
    border: 1px solid black;
                        border-collapse: collapse;
                       
                        
}
.tablarepor tr{
    
    background: #ececec;
}
            </style>
    </head>
    <body <?php ?>onload="sf();"<?php ?>>
        <table width="100%" border="0">
            <tr>
                <td >
                    <form id="form1" name="form1">
                        <table width="100%" border="0" class="tablarepor">
                            
                            <tr>
                                <td colspan='3' ><b><u>PRECIOS DE PRODUCTOS POR SUCURSAL: </u></b>: El precio de venta se modificara solo para este establecimiento . </td>

                            </tr>
                            <tr>
                                <td colspan='3' > Elija solo una de las opciones a buscar: </td>

                            </tr>
                            <tr>
                                <td class="LETRA">Nombre del producto</td>
                                <td >
                                    <input name="country" type="text" id="country" size="100" value="<?php echo $produc ?>" onkeypress="return ent(event);" onKeyUp="this.value = this.value.toUpperCase();"/>
                                </td>
                                <td >
                                    <div align="right">
                                        <input name="val1" type="hidden" id="val1" value="1"/>
                                        <input type="hidden" id="country_hidden" name="country_ID" value="<?php echo $codpro ?>"/>
                                        <input name="search" type="button" id="search" value="Buscar" onclick="buscar()" class="buscar"/>
                                        <input name="exit" type="button" id="exit" value="Salir"  onclick="salir()" class="salir"/>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td  class="LETRA">Todos los productos de Laboratorio/marca: </td>
                                <td >
                                    <select name="marca" id="marca">
                                        <?php
                                        $sql = "SELECT codtab,destab FROM titultabladet where tiptab = 'M'";
                                        $result = mysqli_query($conexion, $sql);
                                        while ($row = mysqli_fetch_array($result)) {
                                            ?>
                                            <option value="<?php echo $row["codtab"] ?>" <?php if ($marca == $row["codtab"]) { ?>selected="selected"<?php } ?>><?php echo $row["destab"] ?></option>
                                        <?php } ?>
                                    </select>		  
                                </td>
                                <td >
                                    <div align="right">
                                        <input name="val2" type="hidden" id="val2" value="2"/>
                                        <input name="search222" type="submit" id="search222" value="Buscar" class="buscar" onclick="lp1()"/>
                                        <input name="exit222" type="button" id="exit222" value="Salir"  onclick="salir()" class="salir"/>
                                    </div></td>
                            </tr>
                            <tr>
                                <td  class="LETRA">Solo mostrar los productos con stock de:</td>
                                <td >
                                    <select name="local" id="local">
                                        <?php
                                        $sqlx = "SELECT codloc,nomloc,nombre FROM xcompa where habil = '1'  ORDER BY codloc ASC LIMIT $nlicencia ";
                                        $resultx = mysqli_query($conexion, $sqlx);
                                        while ($row = mysqli_fetch_array($resultx)) {
                                            $loc = $row["codloc"];
                                            $nloc = $row["nomloc"];
                                            $nombre = $row["nombre"];
                                            if ($nombre == '') {
                                                $locals = $nloc;
                                            } else {
                                                $locals = $nombre;
                                            }
                                            ?>
                                            <option value="<?php echo $row["codloc"] ?>" <?php if ($local == $row["codloc"]) { ?>selected="selected"<?php } ?>><?php echo $locals; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td >
                                    <div align="right">
                                        <input name="val3" type="hidden" id="val3" value="3"/>
                                        <input name="search22" type="submit" id="search22" value="Buscar" class="buscar"  onclick="lp2()"/>
                                        <input name="exit22" type="button" id="exit22" value="Salir"  onclick="salir()" class="salir"/>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td ></td>
                                <td  colspan="2" style="text-align: right;">
                                    <input name="search22" type="submit" id="searchDiferente" value="Precios Diferentes" class="buscar"  onclick="pDiferentes()"/>
                                </td>
                            </tr>
                        </table>

                    </form>
                    
                    <div align="center"><img src="../../../images/line2.png" width="100%" height="4" /></div></td>
            </tr>
        </table>
        <iframe src="precios2.php?search=<?php echo $search ?>&val=<?php echo $val ?>" name="marco" id="marco" width="100%" height="420" scrolling="Automatic" frameborder="0" allowtransparency="0">
        </iframe>
    </body>
</html>
<script>

    $('#marca').select2();
    $('#local').select2();
</script>