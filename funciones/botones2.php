<?php 
$i = 0;
$sql="SELECT * FROM color_modulo";
      $result = mysqli_query($conexion,$sql);
      if (mysqli_num_rows($result) ){
	  while ($row = mysqli_fetch_array($result)){
	  		 $i++;
             $primero                 = $row["primero"];
			 $anterior                = $row["anterior"];
			 $siguiente               = $row["siguiente"];
			 $ultimo	              = $row["ultimo"];
			 $ver                	  = $row["ver"];
			 $nuevo                   = $row["nuevo"];
			 $modificar               = $row["modificar"];
			 $eliminar	              = $row["eliminar"];
			 $grabar                  = $row["grabar"];
			 $buscar                  = $row["buscar"];
			 $cancelar                = $row["cancelar"];
			 $preliminar              = $row["preliminar"];
			 $imprimir	              = $row["imprimir"];
			 $consulta                = $row["consulta"];
			 $salir                   = $row["salir"];
			 $prodstock               = $row["prodstock"];
			 $prodincent	          = $row["prodincent"];
			 $prodnormal	          = $row["prodnormal"];
			 $regresar	       		  = $row["regresar"];
			 $limpiar	              = $row["limpiar"];
			 $prodstock	              = $row["prodstock"];
			 $prodincent              = $row["prodincent"];
			 $prodnormal              = $row["prodnormal"];
		}
		}
?>
<style type="text/css">
input.primero
{
   color: <?php echo $primero?>;
    /*font-size:9px;
   font-weight:bold;
   font-family:Verdana,Helvetica;
   height:20px; 
   width:65px;*/
  display: inline-block;
  padding: 1px 4px;
  font-size: 9px;
  font-weight:bold;
  font-family:Verdana,Helvetica;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  outline: none;
  background-color: #e4e5e7;
  border: none;
  border-radius: 15px;
  box-shadow: 0 4px #999;
}
input.primero:hover {background-color: #f2ef88}
input.primero:active {background-color: #416780;box-shadow: 0 5px #4f767c;transform: translateY(4px);}

input.siguiente
{
   color: <?php echo $siguiente?>;
    /*font-size:9px;
   font-weight:bold;
   font-family:Verdana,Helvetica;
   height:20px; 
   width:65px;*/
  display: inline-block;
  padding: 1px 4px;
  font-size: 9px;
  font-weight:bold;
  font-family:Verdana,Helvetica;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  outline: none;
  background-color: #e4e5e7;
  border: none;
  border-radius: 15px;
  box-shadow: 0 4px #999;
}
input.siguiente:hover {background-color: #f2ef88}
input.siguiente:active {background-color: #416780;box-shadow: 0 5px #4f767c;transform: translateY(4px);}

input.anterior
{
   color: <?php echo $anterior?>;
   /*font-size:9px;
   font-weight:bold;
   font-family:Verdana,Helvetica;
   height:20px; 
   width:65px;*/
  display: inline-block;
  padding: 1px 4px;
  font-size: 9px;
  font-weight:bold;
  font-family:Verdana,Helvetica;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  outline: none;
  background-color: #e4e5e7;
  border: none;
  border-radius: 15px;
  box-shadow: 0 4px #999;
}
input.anterior:hover {background-color: #f2ef88}
input.anterior:active {background-color: #416780;box-shadow: 0 5px #4f767c;transform: translateY(4px);}
input.ultimo
{
   color: <?php echo $ultimo?>;
   /*font-size:9px;
   font-weight:bold;
   font-family:Verdana,Helvetica;
   height:20px; 
   width:65px;*/
  display: inline-block;
  padding: 1px 4px;
  font-size: 9px;
  font-weight:bold;
  font-family:Verdana,Helvetica;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  outline: none;
  background-color: #e4e5e7;
  border: none;
  border-radius: 15px;
  box-shadow: 0 4px #999;
}
input.ultimo:hover {background-color: #f2ef88}
input.ultimo:active {background-color: #416780;box-shadow: 0 5px #4f767c;transform: translateY(4px);}
input.ver
{
   color: <?php echo $ver?>;
   /*font-size:9px;
   font-weight:bold;
   font-family:Verdana,Helvetica;
   height:20px; 
   width:65px;*/
  display: inline-block;
  padding: 1px 4px;
  font-size: 10px;
  font-weight:bold;
  font-family:Verdana,Helvetica;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  outline: none;
  background-color: #e4e5e7;
  border: none;
  border-radius: 15px;
  box-shadow: 0 4px #999;
}
input.ver:hover {background-color: #f2ef88}
input.ver:active {background-color: #416780;box-shadow: 0 5px #4f767c;transform: translateY(4px);}

input.nuevo
{
   color: <?php echo $nuevo?>;
   /*font-size:9px;
   font-weight:bold;
   font-family:Verdana,Helvetica;
   height:20px; 
   width:65px;*/
   
  display: inline-block;
  padding: 1px 4px;
  font-size: 10px;
  font-weight:bold;
  font-family:Verdana,Helvetica;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  outline: none;
  background-color: #e4e5e7;
  border: none;
  border-radius: 15px;
  box-shadow: 0 4px #999;
}
input.nuevo:hover {background-color: #f2ef88}
input.nuevo:active {background-color: #416780;box-shadow: 0 5px #4f767c;transform: translateY(4px);}

input.modificar
{
   color: <?php echo $modificar?>;
   /*font-size:9px;
   font-weight:bold;
   font-family:Verdana,Helvetica;
   height:20px; 
   width:65px;*/
   display: inline-block;
  padding: 1px 4px;
  font-size: 10px;
  font-weight:bold;
  font-family:Verdana,Helvetica;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  outline: none;
  background-color: #e4e5e7;
  border: none;
  border-radius: 15px;
  box-shadow: 0 4px #999;
}
input.modificar:hover {background-color: #f2ef88}
input.modificar:active {background-color: #416780;box-shadow: 0 5px #4f767c;transform: translateY(4px);}

input.eliminar
{
   color: <?php echo $eliminar?>;
   /*font-size:9px;
   font-weight:bold;
   font-family:Verdana,Helvetica;
   height:20px; 
   width:65px;*/ 
   display: inline-block;
  padding: 1px 4px;
  font-size: 10px;
  font-weight:bold;
  font-family:Verdana,Helvetica;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  outline: none;
  background-color: #e4e5e7;
  border: none;
  border-radius: 15px;
  box-shadow: 0 4px #999;
}
input.eliminar:hover {background-color: #f2ef88}
input.eliminar:active {background-color: #416780;box-shadow: 0 5px #4f767c;transform: translateY(4px);}

input.grabar
{
   color: <?php echo $grabar?>;
  /* font-size:9px;
   font-weight:bold;
   font-family:Verdana,Helvetica;
   height:20px; 
   width:65px;*/
   display: inline-block;
  padding: 1px 4px;
  font-size: 10px;
  font-weight:bold;
  font-family:Verdana,Helvetica;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  outline: none;
  background-color: #e4e5e7;
  border: none;
  border-radius: 15px;
  box-shadow: 0 4px #999;
}
input.grabar:hover {background-color: #f2ef88}
input.grabar:active {background-color: #416780;box-shadow: 0 5px #4f767c;transform: translateY(4px);}

input.buscar
{
   color: <?php echo $buscar?>;
   /*font-size:9px;
   font-weight:bold;
   font-family:Verdana,Helvetica;
   height:20px; 
   width:65px;*/

  display: inline-block;
  padding: 1px 4px;
  font-size: 10px;
  font-weight:bold;
  font-family:Verdana,Helvetica;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  outline: none;
  background-color: #e4e5e7;
  border: none;
  border-radius: 15px;
  box-shadow: 0 4px #999;
}
input.buscar:hover {background-color: #f2ef88}
input.buscar:active {background-color: #416780;box-shadow: 0 5px #4f767c;transform: translateY(4px);}



input.preliminar
{
   color: <?php echo $preliminar?>;
   /*font-size:9px;
   font-weight:bold;
   font-family:Verdana,Helvetica;
   height:20px; 
   width:65px;*/
   
   display: inline-block;
  padding: 1px 4px;
  font-size: 10px;
  font-weight:bold;
  font-family:Verdana,Helvetica;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  outline: none;
  background-color: #e4e5e7;
  border: none;
  border-radius: 15px;
  box-shadow: 0 4px #999;
}
input.preliminar:hover {background-color: #e0de7e}
input.preliminar:active {background-color: #416780;box-shadow: 0 5px #4f767c;transform: translateY(4px);}

input.cancelar
{
   color: <?php echo $cancelar?>;
   /*font-size:9px;
   font-weight:bold;
   font-family:Verdana,Helvetica;
   height:20px; 
   width:65px;*/
   display: inline-block;
  padding: 1px 4px;
  font-size: 10px;
  font-weight:bold;
  font-family:Verdana,Helvetica;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  outline: none;
  background-color: #e4e5e7;
  border: none;
  border-radius: 15px;
  box-shadow: 0 4px #999;
}
input.cancelar:hover {background-color: #f2ef88}
input.cancelar:active {background-color: #416780;box-shadow: 0 5px #4f767c;transform: translateY(4px);}

input.imprimir
{
   color: <?php echo $imprimir?>;
/*   font-size:9px;
   font-weight:bold;
   font-family:Verdana,Helvetica;
   height:20px; 
width:65px;*/
   display: inline-block;
  padding: 1px 4px;
  font-size: 10px;
  font-weight:bold;
  font-family:Verdana,Helvetica;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  outline: none;
  background-color: #e4e5e7;
  border: none;
  border-radius: 15px;
  box-shadow: 0 4px #999;
}
input.imprimir:hover {background-color: #f2ef88}
input.imprimir:active {background-color: #416780;box-shadow: 0 5px #4f767c;transform: translateY(4px);}

input.consultar
{
   color: <?php echo $consulta?>;
   /*font-size:9px;
   font-weight:bold;
   font-family:Verdana,Helvetica;
   height:20px; 
   width:65px;*/
   display: inline-block;
  padding: 1px 4px;
  font-size: 10px;
  font-weight:bold;
  font-family:Verdana,Helvetica;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  outline: none;
  background-color: #e4e5e7;
  border: none;
  border-radius: 15px;
  box-shadow: 0 4px #999;
}
input.consultar:hover {background-color: #f2ef88}
input.consultar:active {background-color: #416780;box-shadow: 0 5px #4f767c;transform: translateY(4px);}

input.regresar
{
   color: <?php echo $regresar?>;
   /*font-size:9px;
   font-weight:bold;
   font-family:Verdana,Helvetica;
   height:20px; 
   width:65px;*/
   display: inline-block;
  padding: 1px 4px;
  font-size: 10px;
  font-weight:bold;
  font-family:Verdana,Helvetica;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  outline: none;
  background-color: #e4e5e7;
  border: none;
  border-radius: 15px;
  box-shadow: 0 4px #999;
}
input.regresar:hover {background-color: #f2ef88}
input.regresar:active {background-color: #416780;box-shadow: 0 5px #4f767c;transform: translateY(4px);}

input.limpiar
{
   color: <?php echo $limpiar?>;
   /*font-size:9px;
   font-weight:bold;
   font-family:Verdana,Helvetica;
   height:20px; 
   width:65px;*/
   display: inline-block;
  padding: 1px 4px;
  font-size: 10px;
  font-weight:bold;
  font-family:Verdana,Helvetica;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  outline: none;
  background-color: #e4e5e7;
  border: none;
  border-radius: 15px;
  box-shadow: 0 4px #999;
}
input.limpiar:hover {background-color: #f2ef88}
input.limpiar:active {background-color: #416780;box-shadow: 0 5px #4f767c;transform: translateY(4px);}

input.salir
{
   color: <?php echo $salir?>;
   /*font-size:9px;
   font-weight:bold;
   font-family:Verdana,Helvetica;
   height:20px; 
   :65px;*/
   
   display: inline-block;
  padding: 1px 4px;
  font-size: 10px;
  font-weight:bold;
  font-family:Verdana,Helvetica;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  outline: none;
  background-color: #e4e5e7;
  border: none;
  border-radius: 15px;
  box-shadow: 0 4px #999;
}
input.salir:hover {background-color: #f2ef88}
input.salir:active {background-color: #416780;box-shadow: 0 5px #4f767c;transform: translateY(4px);}

input.prodstock
{
   background: <?php echo $prodstock?>;
   width:20px;
}

input.prodincent
{
   background: <?php echo $prodincent?>;
   width:20px;
 }input.prodnormal
{
   background: <?php echo $prodnormal?>;
   width:20px;
}
.prodstock:link {
	color: <?php echo $prodstock?>;
}
.prodstock:visited {
	color: <?php echo $prodstock?>;
}
.prodstock:hover {
	color: <?php echo $prodstock?>;
}
.prodstock:active {
	color: <?php echo $prodstock?>;
}
.prodincent:link {
	color: <?php echo $prodincent?>;
}
.prodincent:visited {
	color: <?php echo $prodincent?>;
}
.prodincent:hover {
	color: <?php echo $prodincent?>;
}
.prodincent:active {
	color: <?php echo $prodincent?>;
}
.prodnormal:link {
	color: <?php echo $prodnormal?>;
}
.prodnormal:visited {
	color: <?php echo $prodnormal?>;
}
.prodnormal:hover {
	color: <?php echo $prodnormal?>;
}
.prodnormal:active {
	color: <?php echo $prodnormal?>;
}
.text_prodstock
{
		font-family:Trebuchet MS;
		font-size:17px;
		line-height:normal;
		color:<?php echo $prodstock?>;
}
.text_prodincent
{
		font-family:Trebuchet MS;
		font-size:17px;
		line-height:normal;
		color:<?php echo $prodincent?>;
}
.text_prodnormal
{
		font-family:Trebuchet MS;
		font-size:17px;
		line-height:normal;
		color:<?php echo $prodnormal?>;
}
</style>