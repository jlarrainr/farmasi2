<script language="JavaScript">





function precio(){

	var v1 = parseFloat(document.form1.text1.value);		//CANTIDAD
	var v2 = parseFloat(document.form1.text2.value);		//PRECIO
	var factor = parseFloat(document.form1.factor2.value);	//FACTOR
	var costre = parseFloat(document.form1.costre.value);	//FACTOR
 



	var valor = isNaN(v1);
	if (valor == true)
	{
		//var porcion = v1.substring(1); // porcion = "ndo"
		var v1 = document.form1.text1.value.substring(1);
		var v11	= parseFloat(v1);
		
		
		Ncostre= (costre/factor);
                total   = parseFloat(v11*(Ncostre));
		document.form1.number.value=1;		////avisa que no es numero
			
	}
	else
	{
		
                Ncostre= (costre);
                total  = parseFloat(v1 * Ncostre);
		document.form1.number.value=0;		////avisa que es numero
	}
	
	total = Math.round(total*Math.pow(10,2))/Math.pow(10,2); 
	Ncostre = Math.round(Ncostre*Math.pow(10,2))/Math.pow(10,2); 
	
	if(document.form1.text1.value!='' && document.form1.text2.value!=''){
	
		document.form1.text3.value=total;
		document.form1.text2.value=Ncostre;
		document.form1.text2P.value=Ncostre;
		document.form1.text3P.value=total;
	
	}
	else
	{
	
		document.form1.text3.value='';
		document.form1.text2.value='0.00';
      
	}

}
function sf(){
document.form1.country.focus();
}
function getfocus(){
document.getElementById('l1').focus()
}


</script>