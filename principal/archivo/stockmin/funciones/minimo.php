<script>
<!--
function sf(){
document.form1.country.focus();
}
function t(){
document.form1.blister.focus();
}
function salir()
{
	 var f = document.form1;
	 f.method = "POST";
	 f.target = "_top";
	 f.action ="../../index.php";
	 f.submit();
}
function numeros(evt){
	// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
	var key = nav4 ? evt.which : evt.keyCode;
	if (key == 13)
	{
	var f = document.form1;
	if (f.blister.value == "")
	{
	 alert("INGRESE UN VALOR"); f.blister.focus(); return;
	}
	f.target = "mark";
	f.action = "actualiza_blister.php";
	f.method = "post";
	f.submit();
	}
}
function buscar()
{
  var f = document.form1;
  if (f.country.value == "")
  { alert("Ingrese la Marca del Producto para iniciar la Busqueda"); f.country.focus(); return; }
  f.submit();
}
function validar_grid(){
  var f = document.form1;
  f.method = "post";
  f.action ="stockmin3.php";
  f.submit();
}
function validar_prod(){
  var f = document.form1;
  f.target = "mark";
  f.method = "post";
  f.action ="stockmin3_reg.php";
  f.submit();
}
function getfocus(){
document.getElementById('l1').focus()
}
</script>
