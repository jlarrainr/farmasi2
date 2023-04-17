<?php 
require_once('../../../session_user.php');
$venta   = $_SESSION['venta'];
require_once('../../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once('../../../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $desemp?></title>
<link href="../../../../css/style.css" rel="stylesheet" type="text/css" />
<link href="css/autocomplete.css" rel="stylesheet" type="text/css" />
<link href="../../../archivo/css/select_cli.css" rel="stylesheet" type="text/css">
<?php 
require_once('../../../../funciones/funct_principal.php');
require_once('../../../../funciones/highlight.php');	//ILUMINA CAJAS DE TEXTOS
require_once('../../../../funciones/botones.php');	//COLORES DE LOS BOTONES
require_once("funciones/call_combo.php");	//LLAMA A generaSelect
$close      = isset($_REQUEST['close'])? $_REQUEST['close'] : "";
$CVendedor  = isset($_REQUEST['CodClaveVendedor'])? $_REQUEST['CodClaveVendedor'] : "";
?>
<!--<script language="javascript" src="../funciones/jquery.js"></script>
<script type="text/javascript" src="funciones/ajax.js"></script>
<script type="text/javascript" src="funciones/ajax-dynamic-list.js"></script>-->
<link rel="stylesheet" href="jquery-ui/jquery.ui.core.css"  type="text/css" media="screen"/>
<link rel="stylesheet" href="jquery-ui/jquery.ui.theme.css" type="text/css" media="screen"/>
<link rel="stylesheet" href="jquery-ui/jquery.ui.tabs.css" type="text/css" media="screen"/>
<link rel="stylesheet" href="jquery-ui/jquery.ui.deshab.css" type="text/css" media="screen"/>
<link rel="stylesheet" href="jquery-ui/jquery-ui.css" type="text/css" media="screen"/>
<link rel="stylesheet" href="jquery-ui/jquery.ui.autocomplete.css" type="text/css" media="screen"/>

<script language="JavaScript" type="text/javascript" src="jquery.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery-ui/jquery-ui.min.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery-ui/jquery.ui.core.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery-ui/jquery.ui.widget.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery-ui/jquery.ui.position.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery-ui/jquery.ui.autocomplete.js"></script>

<script type="text/javascript">
function fc()
{
    document.form1.country.focus();
}

function cerrar_popup()
{
    window.close();
}

function escapes(e) 
{
    tecla=e.keyCode
    if (tecla == 27)
    {
          window.close();
    }
}

function GeneraVenta_popup()
{
    //window.opener.location.href="../preimprimir.php";
    var f = document.form1;
    f.action = "../sendpremail.php";
    f.method = "post";
    f.submit();
}
$(function () 
{
    $("#cliente").autocomplete({
        source: "ajax-list-countries.php",
        minLength: 2,
        select: function(event, ui) {
            $('#cliente_ID').val(ui.item.id);
            $('#correo').val(ui.item.Mail);
            $('#ruc').val(ui.item.Ruc);
        }
    });
});
</script>
<style type="text/css">
<!--
body {
	background-color: #FFFFCC;
}
-->
</style>
</head>
<?php 
/*$val = $_REQUEST['val'];
if ($val == 1)
{
    $codcli = $_REQUEST['country_ID'];
    $sql="SELECT codcli,descli,dnicli FROM cliente where codcli = '$codcli'";
    $result = mysqli_query($conexion,$sql);
    if (mysqli_num_rows($result))
    {
        while ($row = mysqli_fetch_array($result))
        {
            $codcli         = $row["codcli"];
            $descli         = $row["descli"];
            $dnicli         = $row["dnicli"];
            mysqli_query($conexion, "UPDATE venta set cuscod = '$codcli' where invnum = '$venta'");
            mysqli_query($conexion, "UPDATE temp_venta set cuscod = '$codcli' where invnum = '$venta'");
        }
    }
}*/
$sql="SELECT invnum,nrovent,invfec,cuscod,usecod,codven,forpag,fecven,correlativo FROM venta where invnum = '$venta'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result))
{
    while ($row = mysqli_fetch_array($result))
    {
        $invnum       = $row['invnum'];		//codgio
        $nrovent      = $row['nrovent'];
        $invfec       = $row['invfec'];
        $cuscod       = $row['cuscod'];
        $usecod       = $row['usecod'];
        $codven       = $row['codven'];
        $forpag       = $row['forpag'];
        $fecven       = $row['fecven'];
        $correlativo  = $row['correlativo'];
    }
}
$sql="SELECT codcli,descli,email,ruccli FROM cliente where codcli = '$cuscod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result))
{
    while ($row = mysqli_fetch_array($result))
    {
        $codcli         = $row["codcli"];
        $descli         = $row["descli"];
        $email          = $row["email"];
        $ruccli         = $row["ruccli"];
    }
}

function formato($c) 
{
    printf("%08d",  $c);
} 
?>
</head>
<body onload="<?php if ($close == 1){?>cerrar_popup()<?php }else{ if ($close == 2){?> cerrar_popup1()<?php } else{?>fc()<?php }}?>" onkeyup="escapes(event)">
<form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">
<input type="hidden" name="CVendedor" value="<?php echo $CVendedor;?>"/>
<div align="center"><img src="../../../../images/line2.png" width="580" height="4" /></div>
<div align="center">
    <table width="565" border="0">
        <tr>
          <td width="74" valign="top">NRO DE VENTA </td>
          <td width="481" valign="top">
              <input type="text" name="textfield" disabled="disabled" value="<?php echo formato($correlativo)?>"/>      </td>
        </tr>
        <tr>
            <td valign="top">BUSCAR</td>
            <td valign="top">
            
                <input value="<?php echo $descli;?>" type="text" style="width: 80%" name="cliente" id="cliente" autofocus/>
                <input name="cliente_ID" id="cliente_ID" value="<?php echo $codcli;?>" type="hidden"/>
                
                <input name="val" type="hidden" id="val" value="1" />
            </td>
        </tr>
        <tr>
            <td valign="top">RUC</td>
            <td>
                <input name="ruc" id="ruc" style="width: 80%" type="text" <?php echo $ruccli;?>/>
            </td>
        </tr>
        <tr>
            <td valign="top">MAIL</td>
            <td>
                <input name="correo" id="correo" style="width: 80%" type="text" value="<?php echo $email;?>"/>
            </td>
        </tr>
        <tr>
            <td valign="top"></td>
            <td>
                <input type="button" name="Submit2" value="GENERAR VENTA" onclick="GeneraVenta_popup()"/>
                <input type="button" name="Submit2" value="CERRAR" onclick="cerrar_popup()"/>
            </td>
        </tr>
    </table>
    <img src="../../../../images/line2.png" width="570" height="4" />
</div>
</form>
</body>
</html>
