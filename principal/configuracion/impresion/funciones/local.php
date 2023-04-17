<script>
function validar()
{
  var f = document.form1;
  if (f.ip.value == "")
  { alert("Ingrese el numero IP del Cliente"); f.ip.focus(); return; }
  f.method = "POST";
  f.action ="graba_ip.php";
  f.submit();
}
function sf()
{
  document.form1.ip.focus();
}
function salir()
{
	 var f = document.form1;
	 f.target ="_top";
	 f.action ="../../index.php";
	 f.submit();
}
function validar_grid(){
  var f = document.form1;
  f.method = "post";
  f.action ="ip2.php";
  f.submit();
}
function validar_ip()
{
  var f = document.form1;
  if (f.ip.value == "")
  { alert("Ingrese el numero IP del Cliente"); f.ip.focus(); return; }
  f.method = "post";
  f.action ="modif_ip.php";
  f.submit();
}
</script>