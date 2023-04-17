<?php 
include('../../session_user.php');
require_once('../../../conexion.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<?php 
$invnum = $_REQUEST['invnum'];
$sql1="SELECT invnum,tipdoc FROM venta where invnum = '$invnum'";	////CODIGO DEL LOCAL DEL USUARIO
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
	$invnum    = $row1['invnum'];
	$tipdoc    = $row1['tipdoc'];
}
}
?>
<script>
function cerrar()
{
var f = document.form1;
var invnum = f.invnum.value;
var rd = f.rd.value;
f.method = "post";
f.target = "self";
self.close();
parent.opener.location='print.php?rd='+rd+'&invnum='+invnum+'&val=1';
}
</script>
</head>
<body onload="cerrar();">
<form name="form1" id="form1">
<input name="rd" id="rd" type="hidden" value="<?php echo $tipdoc;?>" />
<input name="invnum" id="invnum" type="hidden" value="<?php echo $invnum;?>" />
</form>
</body>
</html>
