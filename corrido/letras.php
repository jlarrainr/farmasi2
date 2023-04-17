<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<?php $c = "4343";
$t = $c/1;
echo $t;
?>
<script>
function hola()
{
 var v1 = <?php echo "123";?>;
 var valor = isNaN(v1);
 if (valor == true)			////NO ES NUMERO
 {
 alert("no es numero");
 }
 else
 {
 alert("es numero");
 }
}
</script>
</head>

<body>
</body>
</html>
