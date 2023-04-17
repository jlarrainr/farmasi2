<script language="JavaScript">
function validar()
{
  var f = document.form1;
  if (f.user.value == "")
  { alert("Ingrese su Usuario"); f.user.focus(); return; }
  
  if (f.user.value == "Login o clave no validos")
  { alert("Ingrese su Usuario"); f.user.value = "";f.user.focus(); return; }
  if (f.text.value == "")
  { alert("Ingrese una clave de Usuario"); f.text.focus(); return; }
  f.submit();
}

var nav4 = window.Event ? true : false;
function ent1(evt){
var key = nav4 ? evt.which : evt.keyCode;
	if (key == 13)
	{
        var f = document.form1;
  if (f.user.value == "")
  { alert("Ingrese su Usuario"); f.user.focus(); return; }
  if (f.text.value == "")
  { alert("Ingrese una Contraseña"); f.text.focus(); return; }
    f.method = "post";
	f.action = "verifica.php";
	f.submit();
	}
//return (key <= 13 || key == 46 || (key >= 48 && key <= 57));
}
function ent(evt)
{
    
	var key = nav4 ? evt.which : evt.keyCode;
	if (key == 13)
	{
        var f = document.form1;
  if (f.user.value == "")
  { alert("Ingrese su Usuario"); f.user.focus(); return; }
  if (f.text.value == "")
  { alert("Ingrese una Contraseña"); f.text.focus(); return; }
    f.method = "post";
	f.action = "verifica.php";
	f.submit();
	}
}

function buton1()
{
	 var f = document.form1;
	 if (f.text.value == "")
	 {
	 f.text.value=1;
	 }
	 else
	 {
	 var v;
	 var v1 = parseInt(f.text.value);
	 v	= v1+'1';
	 f.text.value=v;
	 }
}
function buton2()
{
	 var f = document.form1;
	 if (f.text.value == "")
	 {
	 f.text.value=2;
	 }
	 else
	 {
	 var v;
	 var v1 = parseInt(f.text.value);
	 v	= v1+'2';
	 f.text.value=v;
	 }
}
function buton3()
{
	  var f = document.form1;
	 if (f.text.value == "")
	 {
	 f.text.value=3;
	 }
	 else
	 {
	 var v;
	 var v1 = parseInt(f.text.value);
	 v	= v1+'3';
	 f.text.value=v;
	 }
}
function buton4()
{
	  var f = document.form1;
	 if (f.text.value == "")
	 {
	 f.text.value=4;
	 }
	 else
	 {
	 var v;
	 var v1 = parseInt(f.text.value);
	 v	= v1+'4';
	 f.text.value=v;
	 }
}
function buton5()
{
	  var f = document.form1;
	 if (f.text.value == "")
	 {
	 f.text.value=5;
	 }
	 else
	 {
	 var v;
	 var v1 = parseInt(f.text.value);
	 v	= v1+'5';
	 f.text.value=v;
	 }
}
function buton6()
{
	  var f = document.form1;
	 if (f.text.value == "")
	 {
	 f.text.value=6;
	 }
	 else
	 {
	 var v;
	 var v1 = parseInt(f.text.value);
	 v	= v1+'6';
	 f.text.value=v;
	 }
}
function buton7()
{
	  var f = document.form1;
	 if (f.text.value == "")
	 {
	 f.text.value=7;
	 }
	 else
	 {
	 var v;
	 var v1 = parseInt(f.text.value);
	 v	= v1+'7';
	 f.text.value=v;
	 }
}
function buton8()
{
	  var f = document.form1;
	 if (f.text.value == "")
	 {
	 f.text.value=8;
	 }
	 else
	 {
	 var v;
	 var v1 = parseInt(f.text.value);
	 v	= v1+'8';
	 f.text.value=v;
	 }
}
function buton9()
{
	  var f = document.form1;
	 if (f.text.value == "")
	 {
	 f.text.value=9;
	 }
	 else
	 {
	 var v;
	 var v1 = parseInt(f.text.value);
	 v	= v1+'9';
	 f.text.value=v;
	 }
}
function buton0()
{
	  var f = document.form1;
	 if (f.text.value == "")
	 {
	 f.text.value=0;
	 }
	 else
	 {
	 var v;
	 var v1 = parseInt(f.text.value);
	 v	= v1+'0';
	 f.text.value=v;
	 }
}
function clean()
{
	 var f = document.form1;
	 f.text.value="";
}
function sf(){document.form1.user.focus();}
</script>