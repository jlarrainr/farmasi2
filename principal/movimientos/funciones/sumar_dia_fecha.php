<script type="text/javascript"> 
<!-- 
function aumenta() { 
  var num=document.form1.plazo.value; 
  f  =document.form1.date1.value; 
  // pasaremos la fecha a formato mm/dd/yyyy 
  f=f.split('-'); 
  f=f[0]+'/'+f[1]+'/'+f[2];
  // 
  var hoy=new Date(f); 
  hoy.setTime(hoy.getTime()+num*24*60*60*1000); 
  var mes=hoy.getMonth()+1; 
  if(mes<9) mes='0'+mes; 
  fecha=hoy.getFullYear()+'-'+mes+'-'+hoy.getDate(); 
  document.form1.date2.value =fecha;   
} 
--> 
</script> 