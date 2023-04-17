<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>
<script type="text/javascript">
// Copyright (C) 2008 www.cryer.co.uk
// Script is free to use provided this copyright header is included.
/*function CursorKeyDown(e,topName,leftName,bottomName,rightName)
{
  if (!e) e=window.event;
  var selectName;
  switch(e.keyCode)
  {
  //case 37:
    // Key left.
    //selectName = leftName;
    //break;
  case 38:
    // Key up.
    document.getElementById('l1').focus()
  //case 39:
    // Key right.
    //selectName = rightName;
    //break;
  case 40:
    // Key down.
    document.getElementById('l2').focus()
  }
  if (!selectName) return;
  var controls = document.getElementsByName(selectName);
  if (!controls) return;
  if (controls.length != 1) return;
  controls[0].focus();
}
function getfocus(){
document.getElementById('l1').focus()
}
*/
//var fila = null;
function pulsar(e) {
  tecla=e.keyCode;
  alert(tecla);
  /*obj.style.background = '#FFFF99';
  if (fila != null && fila != obj)
    fila.style.background = 'white';
  fila = obj;
  */
}
function abrir_index2(e) 
{
	tecla=e.keyCode
	var msg = document.form1.hd.value;
	if(tecla==38)
  	{
	document.getElementById('l1').focus();
	alert(msg);
  	}
	if(tecla==40)
  	{
	document.getElementById('l2').focus();
	alert(msg);
  	}
}
</script>
<body onkeydown='pulsar(event)'>
<form name="form1" method="get">
<table border="1" cellpadding="0" cellspacing="0">
<?php $i = 1;
while ($i <= 10)
{
?>
<tr>
  <td><a id="l<?php echo $i?>" href=""><?php echo $i?></a></td>
  <td>HOLA</td>
</tr>
<?php $i++;
}
?>
</table>
</form>
</body>
</html>
