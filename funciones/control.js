var isCtrl = false;
document.onkeyup=function(e){
if(e.which == 17) isCtrl=false;
}
document.onkeydown=function(e){
if(e.which == 17) isCtrl=true;
if(e.which == 121 && isCtrl == true) {
	//self.close();
	self.parent.location.href="/comercial/principal/ejecucion.php";
// acción para CTRL+S y evitar que ejecute la acción propia del navegador
//return false;

}
}