<SCRIPT LANGUAGE="JavaScript">
<!--
function imprimir() {
  if (window.print)
    window.print()
  else
    alert("Disculpe, su navegador no soporta esta opci�n.");
}
var nav4 = window.Event ? true : false;
function forma_pago(evt){
// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
var key = nav4 ? evt.which : evt.keyCode;
	/////T/////
	if (key == 116)
	{
		var popUpWin=0;
		var left  = 120;
		var top   = 120;
		var width = 480;
		var height= 30;
		if(popUpWin)
		{
		if(!popUpWin.closed) popUpWin.close();
		}
		popUpWin = open('credit_card.php', 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
	}
	if (key == 99)
	{
	var f = document.form1;
	f.ndias.disabled = false;
	}
	else
	{
	var f = document.form1;
	f.ndias.disabled = true;
	f.ndias.value = "";
	}
return (key == 99 || key == 101 || key == 116 || key == 67 || key == 69 || key == 84 || key == 8);

}
//-->
<!--
var nav4 = window.Event ? true : false;
function acceptNum(evt){
// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
var key = nav4 ? evt.which : evt.keyCode;
return (key <= 13 || (key >= 48 && key <= 57));

}
//-->
</script>