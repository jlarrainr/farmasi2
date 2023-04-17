<?php
/*
UPDATE producto SET codbar = LTRIM(codbar), desprod = LTRIM(desprod) ;
UPDATE titultabla SET ltdgen = LTRIM(ltdgen), dsgen = LTRIM(dsgen) ;
UPDATE titultabladet SET tiptab = LTRIM(tiptab), destab = LTRIM(destab) , abrev = LTRIM(abrev) ;
UPDATE cliente SET descli = LTRIM(descli), dnicli = LTRIM(dnicli) , ruccli = LTRIM(ruccli), dircli = LTRIM(dircli) ;

CREATE INDEX indice_acceso ON acceso(idacceso,item);

CREATE INDEX indice_cliente ON cliente(codcli,descli,discli,procli,dptcli,dnicli,ruccli,email,puntos);


CREATE INDEX indice_datagen ON datagen(numerocopias,numpagpreped,formadeimpresion,nlicencia,nopaga,puntosdiv,vencipro,venf8);

CREATE INDEX indice_detalle_nota ON detalle_nota(invnum,invfec,cuscod,usecod,codpro,idlote);

CREATE INDEX indice_detalle_prepedido ON detalle_prepedido(iddetalle,idprepedido,idprod,numpagina);


CREATE INDEX indice_detalle_venta ON detalle_venta(invnum,invfec,cuscod,usecod,codpro);


CREATE INDEX indice_kardex ON kardex(codkard,nrodoc,codpro,fecha,tipmov,tipdoc,numlote,invnum,usecod,sactual,sucursal,eliminado);


CREATE INDEX indice_movmae ON movmae(invnum,invnumrecib,nro_compra,invfec,usecod,cuscod,numdoc,sucursal,sucursal1,estado,val_habil,cargaprepedido);

CREATE INDEX indice_movmov ON movmov(invnum,invfec,codpro,numlote);


CREATE INDEX indice_producto ON producto(codpro,codbar,desprod);



CREATE INDEX indice_usuario ON usuario(usecod,estado,codloc,codgrup,export);


CREATE INDEX indice_venta ON venta(invnum,nrovent,invfec,cuscod,usecod,estado,val_habil,sucursal,correlativo,nrofactura,delivery);


CREATE INDEX indice_xcompa ON xcompa(codloc,nomloc,habil,for_continuo);



*/

?>

