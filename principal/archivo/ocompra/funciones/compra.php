<script>
<!--
function sf(){
document.form1.country.focus();
}
function ttext(){
	var f   = document.form1;
	//var key = nav4 ? evt.which : evt.keyCode;
	document.form1.price.focus();
	//alert("hola");
    /*if (key == 118)
	{
	document.form1.pp.value=1;
    document.form1.method = "post";
    document.form1.submit();
	}
	if (key == 119)
	{
	document.form1.pp.value=2;
    document.form1.method = "post";
    document.form1.submit();
	}
	if (key == 120)
	{
	document.form1.pp.value=3;
    document.form1.method = "post";
    document.form1.submit();
	}
	*/
}
function barra(){
document.form1.country.focus();
}
function news(){
  var f = document.form1;
  f.method = "post";
  f.target = "_top";
  f.action ="reg_compra.php";
  f.submit();
}
function salir()
{
	 var f = document.form1;
	 f.method = "POST";
	 f.target = "_top";
	 f.action ="../../index.php";
	 f.submit();
}
function salir1()
{
	 var f = document.form1;
	 f.method = "POST";
	 f.target = "_top";
	 f.action ="borrar_compra.php";
	 f.submit();
}
function precio(){
	var f = document.form1;
	var dcto_tot;
	if (document.form1.price.value == "")
	{
	document.form1.price.value = 0;
	}
	if (document.form1.dcto1.value == "")
	{
	document.form1.dcto1.value = 0;
	}
	if (document.form1.dcto2.value == "")
	{
	document.form1.dcto2.value = 0;
	}
	if (document.form1.dcto3.value == "")
	{
	document.form1.dcto3.value = 0;
	}
	if (document.form1.pedido.value == "")
	{
	document.form1.pedido.value = 0;
	}
	var p  = parseFloat(document.form1.price.value);		//DESCUENTO1
	var d1 = parseFloat(document.form1.dcto1.value);		//DESCUENTO1
	var d2 = parseFloat(document.form1.dcto2.value);		//DESCUENTO2
	var d3 = parseFloat(document.form1.dcto3.value);		//DESCUENTO3
	var pd = parseFloat(document.form1.pedido.value);		//PEDIDO
	var porcentaje   = parseFloat(document.form1.porcentaje.value);	//PORCENTAJE
	a = parseFloat(1 - (d1/100));
	b = parseFloat(1 - (d2/100));
	c = parseFloat(1 - (d3/100));
	var dcto_tot1 = parseFloat(p * (a * b * c));
	if (document.form1.porcentaje.value =="")
	{
	porcent = 1;
	dcto_tot = parseFloat(p * (a * b * c) * porcent);
	}
	else
	{
	porcent  = parseFloat(1 + (porcentaje/100));
	dcto_tot = parseFloat(p * (a * b * c) * porcent);
	}
	dcto_tot = Math.round(dcto_tot*Math.pow(10,2))/Math.pow(10,2); 
	document.form1.tot_dcto.value = dcto_tot1;		////CAJA VISUAL - DESCUENTO SIN IGV
	document.form1.tots_dcto.value = dcto_tot;		////INVISIBLE - INCLUIDO IGV
	var mtotal = pd * dcto_tot;
	document.form1.monto.value = mtotal;
	document.form1.montos.value = mtotal;
}
function validar_prod(){
  var f = document.form1;
  var v1= document.form1.bonif.value;		//CANTIDAD
  if (f.price.value == "")
  { alert("Ingrese el Precio del Producto"); f.price.focus(); return; }
  if (f.pedido.value == "")
  { alert("Ingrese el numero de Pedidos"); f.pedido.focus(); return; }
  if ((f.bonif.disabled == false)&& (f.bonif.value == ""))
  { 
	alert("Ingrese una bonificacion"); f.bonif.focus(); return; 
  }
	var valor   = isNaN(v1);
	if (valor == true)									////NO ES NUMERO
	{
	document.form1.numero.value=1;		////avisa que no es numero
	}
	else
	{
	document.form1.numero.value=0;		////avisa que es numero
	}
	f.method = "post";
    f.target = "compra_index1"
    f.action ="productos1_reg.php";
    f.submit();
}
</script>