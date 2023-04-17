<script language="JavaScript">
function grabar1()
{
	var f = document.form1;
	if (f.date1.value == "")
		{ alert("Ingrese la Fecha del Documento"); f.date1.focus(); return; }
	if (f.n1.value == "")
		{ alert("Ingrese el Nro del Documento"); f.n1.focus(); return; }
	if (f.n2.value == "")
		{ alert("Ingrese el Nro del Documento"); f.n2.focus(); return; }
	if (f.fpago.value == "")
		{ alert("Ingrese el tipo de Pago"); f.fpago.focus(); return; }
	if (f.plazo.value == "")
		{ alert("Ingrese el plazo"); f.plazo.focus(); return; }
	if (f.date2.value == "")
		{ alert("Ingrese la Fecha de Vencimiento"); f.date2.focus(); return; }
	if ((f.mont5.value == "") || (f.mont5.value == "0.00"))
		{ alert("El sistema arroja un TOTAL = a 0. Revise por Favor!"); f.mont5.focus(); return; }
	ventana=confirm("Desea Grabar estos datos");
	if (ventana) {
		f.method = "POST";
		f.target = "_top";
		f.action ="compras1_reg.php";
		f.submit();
	}
}
function cancelar()
{
	 var f = document.form1;
	 f.method = "POST";
	 f.target = "_top";
	 f.action ="compras1_del.php";
	 f.submit();
}
function validar_prod(){
	var f = document.form1;
	var v1 = parseFloat(document.form1.text1.value);		//CANTIDAD
	var valor = isNaN(v1);
	if (valor == true)
	{
		document.form1.number.value=1;		////avisa que no es numero
	}
	else
	{
		document.form1.number.value=0;		////avisa que es numero
	}
	if ((f.text1.value == "") || (f.text1.value == "0"))
	{ alert("Ingrese una Cantidad"); f.text1.focus(); return; }
	if ((f.text2.value == "") || (f.text2.value == "0.00"))
	{ alert("Ingrese el Precio"); f.text2.focus(); return; }
	//VENTANA QUE CONFIRMA SI GRABO O NO?
	f.method = "POST";
	f.target = "comp_principal";
	f.action ="compras4.php";
	f.submit();
}
function validar_grid(){
	var f = document.form1;
	f.method = "POST";
	f.action ="compras3.php";
	f.submit();
}
function buscar(){
	var f = document.form1;
	if (f.textos.value == "")
		{ alert("Ingrese un Numero de Documento"); f.textos.focus(); return; }
	f.method = "POST";
	f.target = "_top";
	f.action ="compras1_session.php";
	f.submit();
}

function precio()
{
    if (document.form1.text3.value == "")
    {
        document.form1.text3.value = 0;
    }
    if (document.form1.text4.value == "")
    {
        document.form1.text4.value = 0;
    }
    if (document.form1.text5.value == "")
    {
        document.form1.text5.value = 0;
    }
    var v1      = parseFloat(document.form1.text1.value);	//CANTIDAD
    var v2      = parseFloat(document.form1.text2.value);	//PRECIO
    var v3      = parseFloat(document.form1.text3.value);	//DESCUENTO1
    var v4      = parseFloat(document.form1.text4.value);	//DESCUENTO2
    var v5      = parseFloat(document.form1.text5.value);	//DESCUENTO3
    var factor  = parseFloat(document.form1.factor.value);	//FACTOR
    var stock   = parseFloat(document.form1.stockpro.value);	//STOCK ACTUAL
    var p       = parseFloat(document.form1.porcentaje.value);	//PORCENTAJE
    var IGVT    = document.form1.ckigv.value;
    var a;
    var b;
    var c;
    var pventa;
    var total;
    var porcent;
    var promedio;
    
    a = parseFloat(1 - (v3/100));
    b = parseFloat(1 - (v4/100));
    c = parseFloat(1 - (v5/100));
    
    if (IGVT === 1)
    {
        porcent = 1;
        pventa = parseFloat(v2 * (a * b * c) * porcent);
    }
    else
    {
        if (document.form1.porcentaje.value !== "")
        {   
            porcent = parseFloat(1 + (p/100));
            pventa = parseFloat(v2 * (a * b * c) * porcent);
        }
        else
        {
            porcent = 1;
            pventa = parseFloat(v2 * (a * b * c) * porcent);
        }
    }
    
    pventa = Math.round(pventa*Math.pow(10,2))/Math.pow(10,2); 
    
    var valor = isNaN(v1);
    if (valor == true)
    {
        var porcion = document.form1.text1.value.substring(1);
        var fact    = parseFloat(porcion/factor);
        total       = parseFloat(fact * pventa);
        document.form1.number.value=1;		////avisa que no es numero
    }
    else
    {
        total  = parseFloat(v1 * pventa);
        document.form1.number.value=0;		////avisa que es numero
    }
    
    total = Math.round(total*Math.pow(10,2))/Math.pow(10,2); 
    if(document.form1.text1.value!='' && document.form1.text2.value!='')
    {
        document.form1.text6.value=pventa;
        document.form1.text7.value=total;
    }
    else
    {
        document.form1.text6.value='';
        document.form1.text7.value='';
    }
}

function consult_validar()
{
	  var f = document.form1;
	  if (f.numero.value == "")
		  { alert("Ingrese el Nro del Documento"); f.numero.focus(); return; }
	  f.method = "POST";
	  f.action ="consult_compras1.php";
	  f.submit();
}
function cancelar_consult()
{
	 var f = document.form1;
	 ventana=confirm("Desea cancelar y salir de esta Aplicacion");
	 if (ventana) {
		f.method = "POST";
		f.target = "_top";
		f.action ="../ing_salid.php";
		f.submit();
	 }
}
function fc(){
	document.form1.text1.focus();
}
function ValidarIGV()
{
    var f = document.form1;
    f.method = "post";
    f.action = "compras_updIGV.php";
    f.submit();
}
function searchs(){
	var f = document.form1;
	if (f.alfa1.value == "")
		{ alert("Seleccione un Proveedor"); f.alfa1.focus(); return; }
	if (f.alfa1.value == 0)
		{ alert("Seleccione un Proveedor"); f.alfa1.focus(); return; }
	if (f.nrocompra.value == "")
		{ alert("Ingrese el Numero de la Orden de Compra"); f.nrocompra.focus(); return; }
	f.method = "post";
	f.action = "compras_busca.php";
	f.submit();
}
function searchs2(){
	var f = document.form1;
	if (f.alfa1.value == "")
		{ alert("Seleccione un Proveedor"); f.alfa1.focus(); return; }
	if (f.alfa1.value == 0)
		{ alert("Seleccione un Proveedor"); f.alfa1.focus(); return; }
	var prov = f.alfa1.value;
	f.DatosProveedor.value = prov;
	f.method = "post";
	f.action = "compras1.php";
	f.submit();
}
function carga(){
	document.form1.date1.disabled = false;
	document.form1.date2.disabled = false;
	document.form1.moneda.disabled = false;
	document.form1.n1.disabled = false;
	document.form1.n2.disabled = false;
	document.form1.textfield3.disabled = false;
	document.form1.plazo.disabled = false;
	document.form1.fpago.disabled = false;
	document.form1.ckigv.disabled = false;
}
function carga1(){
	document.form1.nrocompra.focus();
	document.form1.date1.disabled = true;
	document.form1.date2.disabled = true;
	document.form1.moneda.disabled = true;
	document.form1.n1.disabled = true;
	document.form1.n2.disabled = true;
	document.form1.textfield3.disabled = true;
	document.form1.plazo.disabled = true;
	document.form1.fpago.disabled = true;
	document.form1.ckigv.disabled = true;
}
function sf(){
	document.form1.first.disabled = true;
	document.form1.next.disabled = true;
	document.form1.prev.disabled = true;
	document.form1.fin.disabled = true;
	document.form1.nuevo.disabled = true;
	document.form1.modif.disabled = true;
}
function sssf(){
	document.form1.country.focus();
}
function ss(){
	document.form1.first.disabled = true;
	document.form1.next.disabled = true;
	document.form1.prev.disabled = true;
	document.form1.fin.disabled = true;
	document.form1.nuevo.disabled = true;
	document.form1.modif.disabled = true;
	alert("Falta ingresar lotes en la compra seleccionada");
}
function links(){
	document.getElementById('l1').focus()
}
</script>