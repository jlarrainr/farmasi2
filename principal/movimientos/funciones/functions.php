<script language="Javascript">
//////////DESHABILITO TECLAS FUNCIONALES DEL TECLADO//////////
//117->f6
//116->f5
//122->f11 
document.onkeydown = function(e)
{
	if(e)
	document.onkeypress = function()
	{
	return true;
	}
	var evt = e?e:event;
	/////////////////////////F5 Y F11/////////////////////////////
	if(evt.keyCode==116 || evt.keyCode==117 || evt.keyCode==122)
	{
		if(e)
		document.onkeypress = function()
		{
		return false;
		}
		else
		{
		evt.keyCode = 0;
		evt.returnValue = false;
		}
	}
	/////////////////////////BACKSPACE/////////////////////////////
	if(evt && (evt.keyCode==8))
	{
		e=e.srcElement?e.srcElement:e.target;
		var msg = e.nodeName;
			  if (msg=='INPUT' || msg=='TEXTAREA')
			  {
			  return true;
			  }
			  else
			  {
			  return false;
			  }
	}
	
} 
/////////DESHABILITO LICK DERECHO DEL MOUSE/////////////
document.oncontextmenu = function() {
  return false
}
</script>
<!-- Begin
<script language="Javascript">
function disableselect(e){
return false
}
function reEnable(){
return true
}
document.onselectstart=new Function ("return false")
if (window.sidebar){
document.onmousedown=disableselect
document.onclick=reEnable
}
</script>
// End -->
<script>
document.onselectstart=function(){return false};
//Firefox cambia
if (window.sidebar){
document.onmousedown=function(e){
var obj=e.target;
if ((obj.tagName=="INPUT")||(obj.tagName=="TEXTAREA")){
return true;
}else if (obj.tagName=="BUTTON"){
return true;
}
return false;
}
}
</script>