<?php
require_once('../../conexion.php');
mysqli_query($conexion, "truncate producto ");
 
$sql= "SELECT `codigoProducto`, `descripcionProducto`, `factor`, `precioProducto`, `precioCaja`, `precioUnidad`, `digemid`, `registroSanitario`, `blister`, `precioBlister`, `stockUnidades`, `codigo_marca`, `codigo_principioActivo`, `codigo_accionTerapeutica`, `codigo_presentacion` FROM producto_Excel  ";
$result = mysqli_query($conexion,$sql);	
if (mysqli_num_rows($result))
{
    while ($row = mysqli_fetch_array($result)){
        $codigoProducto             = $row['codigoProducto'];
        $descripcionProducto        = $row['descripcionProducto'];
        $factor                     = $row['factor'];
        $Precio_caja                = $row['precioProducto'];
        $prevta                     = $row['precioCaja'];
        $preuni                     = $row['precioUnidad'];
        $digemid                    = $row['digemid'];
        $registrosanitario          = $row['registroSanitario'];
        $blister                    = $row['blister'];
        $preblister                 = $row['precioBlister'];
        $stockUnidades              = $row['stockUnidades'];
        
        $codigo_marca               = $row['codigo_marca'];  //codmar
        $codigo_principioActivo     = $row['codigo_principioActivo'];  //codfam
        $codigo_accionTerapeutica   = $row['codigo_accionTerapeutica'];//coduso
        $codigo_presentacion        = $row['codigo_presentacion'];  //codpres
        
        
        
        
  
       
       
   


      $descripcionProducto= htmlspecialchars($descripcionProducto);
       
      if($codigoProducto<>''){
            mysqli_query($conexion, "INSERT INTO producto (codpro,desprod,prevta,costpr,utlcos,costre,preuni,digemid,registrosanitario,factor,codmar,codfam,coduso,codpres,s000,stopro,igv,activo,activo1,lotec,blister,preblister,cantventaparabonificar,codprobonif,cantbonificable) values ('$codigoProducto','$descripcionProducto','$prevta','$Precio_caja','$Precio_caja','$Precio_caja','$preuni','$digemid','$registrosanitario','$factor','$codigo_marca','$codigo_principioActivo','$codigo_accionTerapeutica','$codigo_presentacion','$stockUnidades','$stockUnidades','1','1','1','1','$blister','$preblister','0','0','0')");
      }else{
            mysqli_query($conexion, "INSERT INTO producto (desprod,prevta,costpr,utlcos,costre,preuni,digemid,registrosanitario,factor,codmar,codfam,coduso,codpres,s000,stopro,igv,activo,activo1,lotec,blister,preblister,cantventaparabonificar,codprobonif,cantbonificable) values ('$descripcionProducto','$prevta','$Precio_caja','$Precio_caja','$Precio_caja','$preuni','$digemid','$registrosanitario','$factor','$codigo_marca','$codigo_principioActivo','$codigo_accionTerapeutica','$codigo_presentacion','$stockUnidades','$stockUnidades','1','1','1','1','$blister','$preblister','0','0','0')"); 
      }
        
    }
}