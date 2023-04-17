<?php

require_once 'conexion.php';
require_once 'convertfecha.php';


$PRODUCTO = "EDUARDO RAMIREZ BENAVIDES";

echo  trim(remplazar_string("áàäâªÁÀÂÄdoéèëêÉÈÊËreíìïîÍÌÏÎmióòöôÓÒÖÔfaúùüûÚÙÛÜsolñÑçÇlasi\\¨º-~#@|!\,·$%&/()?¡¿[^`]+}{¨´>< ;,:.            ")) . "<br>";
