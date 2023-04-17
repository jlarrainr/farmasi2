
<script language="JavaScript">

function precio(){
	
    var v1 = parseFloat(document.form1.text1.value);		//CANTIDAD
    var factor = parseFloat(document.form1.factor.value);		//CANTIDAD
    var costre = parseFloat(document.form1.costre.value);		//CANTIDAD
    var v3 = parseFloat(document.form1.stock.value);		//CANTIDAD
	var valor = isNaN(v1);
	if (valor == true)
	{
	    var txt = document.form1.text1.value.substring(1);
		var porcion = costre/factor;
		
		
		total   = porcion;
		subtotal=total*txt;
		document.form1.number.value=1;		////avisa que no es numero
		
		if (txt > v3)
            {
                                alert("La cantidad Ingresada excede al Stock Actual del Producto");
                                f.text1.focus();
                                return;
                            }
		
		
	}
	else
	{
	    
	    
		total  = costre;
		subtotal=total*v1;
		document.form1.number.value=0;		////avisa que es numero
		
		
		var txt	= parseFloat(v1*factor);
                            if (txt > v3)
                            {
                                alert("La cantidad Ingresada excede al Stock Actual del Producto");
                                f.text1.focus();
                                return;
                            }
		
		
	}
	
	//alert(v1);
        
	//total = Math.round(total*Math.pow(10,2)); 
	total = Math.round(total*Math.pow(10,2))/Math.pow(10,2); 
	subtotal = Math.round(subtotal*Math.pow(10,2))/Math.pow(10,2); 
	
	if(document.form1.text1.value!='' ){

		document.form1.text2.value=total;
		document.form1.subtotal.value=subtotal;
	}
	else
	{
		document.form1.text2.value='';
	    document.form1.subtotal.value='';
	}

}

</script>