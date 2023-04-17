<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

require_once('signature.php'); // permite firmar xml

class ApiFacturacion {
    /*
      |--------------------------------------------------------------------------
      | DECLARACION A SUNAT POR DOCUMENTO
      |--------------------------------------------------------------------------
      | USUARIO: ROMMEL MERCADO
      | FECHA:18-12-2021.
      |
     */

    public function EnviarComprobanteElectronico(
            $emisor,
            $nombre,
            $rutacertificado,
            $ruta_archivo_xml,
            $ruta_archivo_cdr
    ) {

        try {
            $objfirma = new Signature();

            $flg_firma = 0; //Posicion del XML: 0 para firma

            $ruta = $ruta_archivo_xml . $nombre . '.XML';

            $ruta_firma = $rutacertificado . $emisor['ruc'] . '/' . $emisor['ruc'] . '.pfx'; //ruta del archivo del certicado para firmar
            $pass_firma = $emisor['pass_firma'];

            //==================================================================
            //firma
            $resp = $objfirma->signature_xml(
                    $flg_firma,
                    $ruta,
                    $ruta_firma,
                    $pass_firma
            );

            $zip = new ZipArchive();

            $nombrezip = $nombre . ".ZIP";

            $rutazip = $ruta_archivo_xml . $nombre . ".ZIP";

            if ($zip->open($rutazip, ZipArchive::CREATE) === TRUE) {
                $zip->addFile($ruta, $nombre . '.XML');
                $zip->close();
            }


            //==================================================================
            //ROMMEL MERCADO
            //19-12-2021
            //SE OBTIENE EL WSDL DESDE LA BD PARA LA DECLARACION A SUNAT
            $ws = $emisor['sunat_invoice'];
            //==================================================================

            $ruta_archivo = $rutazip;
            $nombre_archivo = $nombrezip;

            //==================================================================
            $contenido_del_zip = base64_encode(file_get_contents($ruta_archivo)); //codificar y convertir en texto el .zip
            // echo '</br> ' . $contenido_del_zip . "<br>";
            //==================================================================
            $xml_envio = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.sunat.gob.pe" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
                        <soapenv:Header>
                        <wsse:Security>
                            <wsse:UsernameToken>
                                <wsse:Username>' . $emisor['ruc'] . $emisor['usuario_sol'] . '</wsse:Username>
                                <wsse:Password>' . $emisor['clave_sol'] . '</wsse:Password>
                            </wsse:UsernameToken>
                        </wsse:Security>
                        </soapenv:Header>
                        <soapenv:Body>
                        <ser:sendBill>
                            <fileName>' . $nombre_archivo . '</fileName>
                            <contentFile>' . $contenido_del_zip . '</contentFile>
                        </ser:sendBill>
                        </soapenv:Body>
                    </soapenv:Envelope>';
            //==================================================================
            $header = array(
                "Content-type: text/xml; charset=\"utf-8\"",
                "Accept: text/xml",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                "SOAPAction: ",
                "Content-lenght: " . strlen($xml_envio)
            );
            //==================================================================

            $ch = curl_init(); //iniciar la llamada
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1); //
            curl_setopt($ch, CURLOPT_URL, $ws);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_envio);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

            //para ejecutar los procesos de forma local en windows
            //enlace de descarga del cacert.pem https://curl.haxx.se/docs/caextract.html
            // curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . "/" . $emisor['ruc'] . '/' .  $emisor['ruc'] . ".pem"); //solo en local, si estas en el servidor web con ssl comentar esta línea

            $response = curl_exec($ch); // ejecucion del llamado y respuesta del WS SUNAT.

            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // objten el codigo de respuesta de la peticion al WS SUNAT
            $estadofe = "0"; //inicializo estado de operación interno

            if ($httpcode == 200) { //200: La comunicacion fue satisfactoria
                $doc = new DOMDocument(); //clase que nos permite crear documentos XML
                $doc->loadXML($response); //cargar y crear el XML por medio de text-xml response

                if (isset($doc->getElementsByTagName('applicationResponse')->item(0)->nodeValue)) { // si en la etique de rpta hay valor entra
                    $cdr = $doc->getElementsByTagName('applicationResponse')->item(0)->nodeValue; //guadarmos la respuesta(text-xml) en la variable 
                    $cdr = base64_decode($cdr); //decodificando el xml
                    file_put_contents($ruta_archivo_cdr . 'R-' . $nombrezip, $cdr); //guardo el CDR zip en la carpeta cdr
                    $zip = new ZipArchive();
                    if ($zip->open($ruta_archivo_cdr . 'R-' . $nombrezip) === true) { //rpta es identica existe el archivo
                        $zip->extractTo($ruta_archivo_cdr, 'R-' . $nombre . '.XML');
                        $zip->close();
                    }

                    //VERIFICAR RESPUEST DEL CDR
                    $xml_cdr = simplexml_load_file($ruta_archivo_cdr . 'R-' . $nombre . '.XML');
                    $xml_cdr->registerXPathNamespace('c', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

                    $DocumentResponse = array();

                    $ReferenceID = $xml_cdr->xpath('//c:ReferenceID');
                    $ResponseCode = $xml_cdr->xpath('//c:ResponseCode');
                    $Description = $xml_cdr->xpath('//c:Description');
                    $Notes = $xml_cdr->xpath('//c:Note');

                    $DocumentResponse['ReferenceID'] = (string) $ReferenceID[0];
                    $DocumentResponse['ResponseCode'] = (string) $ResponseCode[0];
                    $DocumentResponse['Description'] = (string) $Description[0];

                    if (count($Notes) > 0) {
                        foreach ($Notes as $note) {
                            $DocumentResponse['Notes'][] = (string) $note[0];
                        }
                    }
                    //FIN DE VERIFICACION DE RESPUESTA DEL CDR
                    if ($DocumentResponse['ResponseCode'] == 0) {
                        $estado = 1;
                    } else {
                        $estado = 0;
                    }

                    $response_array['data'] = $DocumentResponse;
                    $response_array['data']['hash'] = $resp['hash_cpe'];
                    $response_array['data']['status'] = $estado;
                    curl_close($ch);
                    return $response_array['data'];
                } else {

                    $estadofe = '2';
                    $codigo = $doc->getElementsByTagName('faultcode')->item(0)->nodeValue;
                    $mensaje = $doc->getElementsByTagName('faultstring')->item(0)->nodeValue;

                    $cadena_de_texto = $mensaje;
                    $cadena_buscada = 'registrado';
                    $posicion_coincidencia = strpos($cadena_de_texto, $cadena_buscada);

                    if ($posicion_coincidencia) {
                        $status = 1;
                        $ResponseCode = '0';
                    } else {
                        $status = '0';
                        $ResponseCode = '-1';
                    }

                    $DocumentResponse = array();
                    $DocumentResponse['Description'] = $mensaje;
                    $DocumentResponse['ResponseCode'] = $ResponseCode;
                    $DocumentResponse['status'] = $status;
                    $DocumentResponse['hash'] = '';
                    $response_array['data'] = $DocumentResponse;
                    curl_close($ch);
                    return $response_array['data'];
                }
            } else {
                $estadofe = "3";
                //echo '$ch = ' . curl_error($ch) . "<br>";
                //echo 'Hubo existe un problema de conexión';

                $DocumentResponse = array();
                $DocumentResponse['Description'] = curl_error($ch);
                $DocumentResponse['ResponseCode'] = "-2";
                $DocumentResponse['status'] = 0;
                $response_array['data'] = $DocumentResponse;
                return $response_array['data'];
            }
            curl_close($ch);
        } catch (Error $e) {
            $DocumentResponse = array();
            $DocumentResponse['Description'] = 'ERROR: ' . $e;
            $DocumentResponse['ResponseCode'] = "-3";
            $DocumentResponse['status'] = 0;
            $response_array['data'] = $DocumentResponse;
            return $response_array['data'];
        }
    }

    /*
      |--------------------------------------------------------------------------
      | DECLARACION A SUNAT POR ENVIO DE RESUMENES
      |--------------------------------------------------------------------------
      | USUARIO: ROMMEL MERCADO
      | FECHA:18-12-2021.
      |
     */

    public function EnviarResumenComprobantes(
            $emisor,
            $nombre,
            $rutacertificado = "",
            $ruta_archivo_xml
    ) {
        try {

            //firma del documento
            $objSignature = new Signature();

            $flg_firma = "0";

            $ruta = $ruta_archivo_xml . $nombre . '.XML';

            $ruta_firma = $rutacertificado . $emisor['ruc'] . '/' . $emisor['ruc'] . '.pfx'; //ruta del archivo del certicado para firmar
            $pass_firma = $emisor['pass_firma'];

            $resp = $objSignature->signature_xml(
                    $flg_firma,
                    $ruta,
                    $ruta_firma,
                    $pass_firma
            );

            //print_r($resp);

            $zip = new ZipArchive();

            $nombrezip = $nombre . ".ZIP";
            $rutazip = $ruta_archivo_xml . $nombre . ".ZIP";

            if ($zip->open($rutazip, ZIPARCHIVE::CREATE) === true) {
                $zip->addFile($ruta, $nombre . '.XML');
                $zip->close();
            }


            //==================================================================
            //ROMMEL MERCADO
            //19-12-2021
            //SE OBTIENE EL WSDL DESDE LA BD PARA LA DECLARACION A SUNAT
            $ws = $emisor['sunat_invoice'];
            //==================================================================

            $ruta_archivo = $ruta_archivo_xml . $nombrezip;
            $nombre_archivo = $nombrezip;
            $ruta_archivo_cdr = "cdr/";

            $contenido_del_zip = base64_encode(file_get_contents($ruta_archivo));

            $xml_envio = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.sunat.gob.pe" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
				 <soapenv:Header>
				 	<wsse:Security>
				 		<wsse:UsernameToken>
				 			<wsse:Username>' . $emisor['ruc'] . $emisor['usuario_sol'] . '</wsse:Username>
				 			<wsse:Password>' . $emisor['clave_sol'] . '</wsse:Password>
				 		</wsse:UsernameToken>
				 	</wsse:Security>
				 </soapenv:Header>
				 <soapenv:Body>
				 	<ser:sendSummary>
				 		<fileName>' . $nombre_archivo . '</fileName>
				 		<contentFile>' . $contenido_del_zip . '</contentFile>
				 	</ser:sendSummary>
				 </soapenv:Body>
				</soapenv:Envelope>';

            $header = array(
                "Content-type: text/xml; charset=\"utf-8\"",
                "Accept: text/xml",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                "SOAPAction: ",
                "Content-lenght: " . strlen($xml_envio)
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_URL, $ws);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_envio);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            //para ejecutar los procesos de forma local en windows
            //enlace de descarga del cacert.pem https://curl.haxx.se/docs/caextract.html
            //curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . "/" . $emisor['ruc'] . '/' .  $emisor['ruc'] . ".pem"); //solo en local, si estas en el servidor web con ssl comentar esta línea


            $response = curl_exec($ch);

            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $estadofe = "0";
            $ticket = "";
            //var_dump($response);
            if ($httpcode == 200) {
                $doc = new DOMDocument();
                $doc->loadXML($response);

                if (isset($doc->getElementsByTagName('ticket')->item(0)->nodeValue)) {
                    $ticket = $doc->getElementsByTagName('ticket')->item(0)->nodeValue;
                    //echo "TODO OK NRO TK: " . $ticket;
                } else {

                    $codigo = $doc->getElementsByTagName("faultcode")->item(0)->nodeValue;
                    $mensaje = $doc->getElementsByTagName("faultstring")->item(0)->nodeValue;
                    //echo "error 1 =" . $codigo . ": " . $mensaje;
                }
            } else {
                //echo curl_error($ch);
                //echo "Problema de conexion";

                $DocumentResponse = array();
                $DocumentResponse['Description'] = curl_error($ch);
                $DocumentResponse['status'] = 0;
                $response_array['data'] = $DocumentResponse;
                //return $response_array['data'];
                return $ticket;
            }

            curl_close($ch);
            return $ticket;
        } catch (Error $e) {
            $DocumentResponse = array();
            $DocumentResponse['Description'] = 'ERROR: ' . $e;
            $DocumentResponse['status'] = 0;
            $response_array['data'] = $DocumentResponse;
            //return $response_array['data'];
            return $ticket;
        }
    }

    public function ConsultarTicket(
            $emisor,
            $cabecera,
            $ticket,
            $ruta_archivo_cdr
    ) {

        try {

            //==================================================================
            //ROMMEL MERCADO
            //19-12-2021
            //SE OBTIENE EL WSDL DESDE LA BD PARA LA DECLARACION A SUNAT
            $ws = $emisor['sunat_invoice'];
            //==================================================================

            $nombre = $emisor["ruc"] . "-" . $cabecera["tipodoc"] . "-" . $cabecera["serie"] . "-" . $cabecera["correlativo"];
            $nombre_xml = $nombre . ".XML";

            //===============================================================//
            //FIRMADO DEL cpe CON CERTIFICADO DIGITAL
            $objSignature = new Signature();
            $flg_firma = "0";
            $ruta = $nombre_xml;

            $ruta_firma = $emisor['ruc'] . '/' . $emisor['ruc'] . '.pfx';
            $pass_firma = $emisor['pass_firma'];

            //===============================================================//
            //ALMACENAR EL ARCHIVO EN UN ZIP
            $zip = new ZipArchive();

            $nombrezip = $nombre . ".ZIP";

            if ($zip->open($nombrezip, ZIPARCHIVE::CREATE) === true) {
                $zip->addFile($ruta, $nombre_xml);
                $zip->close();
            }

            //===============================================================//
            //ENVIAR ZIP A SUNAT
            $ruta_archivo = $nombre;
            $nombre_archivo = $nombre;

            //===============================================================//
            $xml_envio = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.sunat.gob.pe" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
            <soapenv:Header>
                <wsse:Security>
                    <wsse:UsernameToken>
                    <wsse:Username>' . $emisor['ruc'] . $emisor['usuario_sol'] . '</wsse:Username>
                    <wsse:Password>' . $emisor['clave_sol'] . '</wsse:Password>
                    </wsse:UsernameToken>
                </wsse:Security>
            </soapenv:Header>
            <soapenv:Body>
                <ser:getStatus>
                    <ticket>' . $ticket . '</ticket>
                </ser:getStatus>
            </soapenv:Body>
        </soapenv:Envelope>';

            $header = array(
                "Content-type: text/xml; charset=\"utf-8\"",
                "Accept: text/xml",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                "SOAPAction: ",
                "Content-lenght: " . strlen($xml_envio)
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_URL, $ws);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 120);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_envio);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            //para ejecutar los procesos de forma local en windows
            //enlace de descarga del cacert.pem https://curl.haxx.se/docs/caextract.html
            // curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . "/" . $emisor['ruc'] . '/' .  $emisor['ruc'] . ".pem"); //solo en local, si estas en el servidor web con ssl comentar esta línea

            $response = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            //var_dump($response);

            if ($httpcode == 200) {
                $doc = new DOMDocument();
                $doc->loadXML($response);

                if (isset($doc->getElementsByTagName('content')->item(0)->nodeValue)) {
                    $cdr = $doc->getElementsByTagName('content')->item(0)->nodeValue;
                    $cdr = base64_decode($cdr);

                    file_put_contents($ruta_archivo_cdr . "R-" . $nombre_archivo . ".ZIP", $cdr);
                    $zip = new ZipArchive;
                    if ($zip->open($ruta_archivo_cdr . "R-" . $nombre_archivo . ".ZIP") === true) {
                        $zip->extractTo($ruta_archivo_cdr, 'R-' . $nombre_archivo . '.XML');
                        $zip->close();
                    }

                    //VERIFICAR RESPUEST DEL CDR
                    $xml_cdr = simplexml_load_file($ruta_archivo_cdr . 'R-' . $nombre_archivo . '.XML');
                    $xml_cdr->registerXPathNamespace('c', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

                    $DocumentResponse = array();

                    $ReferenceID = $xml_cdr->xpath('//c:ReferenceID');
                    $ResponseCode = $xml_cdr->xpath('//c:ResponseCode');
                    $Description = $xml_cdr->xpath('//c:Description');
                    $Notes = $xml_cdr->xpath('//c:Note');

                    $DocumentResponse['ReferenceID'] = (string) $ReferenceID[0];
                    $DocumentResponse['ResponseCode'] = (string) $ResponseCode[0];
                    $DocumentResponse['Description'] = (string) $Description[0];

                    if (count($Notes) > 0) {
                        foreach ($Notes as $note) {
                            $DocumentResponse['Notes'][] = (string) $note[0];
                        }
                    }
                    //FIN DE VERIFICACION DE RESPUESTA DEL CDR
                    if ($DocumentResponse['ResponseCode'] == 0) {
                        $estado = 1;
                    } else {
                        $estado = 0;
                    }

                    $response_array['data'] = $DocumentResponse;
                    $response_array['data']['status'] = $estado;
                    return $response_array['data'];
                    curl_close($ch);
                } else {
                    $codigo = $doc->getElementsByTagName("faultcode")->item(0)->nodeValue;
                    $mensaje = $doc->getElementsByTagName("faultstring")->item(0)->nodeValue;
                    echo "error 2: " . $codigo . ": " . $mensaje;
                    $DocumentResponse = array();
                    $DocumentResponse['Description'] = $mensaje;
                    $DocumentResponse['ResponseCode'] = '';
                    $DocumentResponse['status'] = '0';
                    $DocumentResponse['hash'] = '';
                    $response_array['data'] = $DocumentResponse;
                    return $response_array['data'];
                }
            } else {
                //echo curl_error($ch);
                //echo "Problema de conexión";

                $DocumentResponse = array();
                $DocumentResponse['Description'] = curl_error($ch);
                $DocumentResponse['status'] = 0;
                $response_array['data'] = $DocumentResponse;
                return $response_array['data'];
            }

            curl_close($ch);
        } catch (Error $e) {
            $DocumentResponse = array();
            $DocumentResponse['Description'] = 'ERROR: ' . $e;
            $DocumentResponse['status'] = 0;
            $response_array['data'] = $DocumentResponse;
            return $response_array['data'];
        }
    }

    function consultarComprobante($emisor, $comprobante) {
        try {
            $ws = "https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService";
            $soapUser = "";
            $soapPassword = "";

            $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" 
				xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.sunat.gob.pe" 
				xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
					<soapenv:Header>
						<wsse:Security>
							<wsse:UsernameToken>
								<wsse:Username>' . $emisor['ruc'] . $emisor['usuariosol'] . '</wsse:Username>
								<wsse:Password>' . $emisor['clavesol'] . '</wsse:Password>
							</wsse:UsernameToken>
						</wsse:Security>
					</soapenv:Header>
					<soapenv:Body>
						<ser:getStatus>
							<rucComprobante>' . $emisor['ruc'] . '</rucComprobante>
							<tipoComprobante>' . $comprobante['tipodoc'] . '</tipoComprobante>
							<serieComprobante>' . $comprobante['serie'] . '</serieComprobante>
							<numeroComprobante>' . $comprobante['correlativo'] . '</numeroComprobante>
						</ser:getStatus>
					</soapenv:Body>
				</soapenv:Envelope>';

            $headers = array(
                "Content-type: text/xml;charset=\"utf-8\"",
                "Accept: text/xml",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                "SOAPAction: ",
                "Content-length: " . strlen($xml_post_string),
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_URL, $ws);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            //para ejecutar los procesos de forma local en windows
            //enlace de descarga del cacert.pem https://curl.haxx.se/docs/caextract.html
            //curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . "/cacert.pem");

            $response = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            //echo var_dump($response);
        } catch (Exception $e) {
            //echo "SUNAT ESTA FUERA SERVICIO: " . $e->getMessage();
        }
    }


    /**
     * 
     * @param type $emisor
     * @param type $nombre
     * @param type $rutacertificado
     * @param type $ruta_archivo_xml
     * @param type $ruta_archivo_cdr
     * @return string|int
     */
    public function EnviarGuiaElectronica(
        $emisor,
        $nombre,
        $rutacertificado,
        $ruta_archivo_xml,
        $ruta_archivo_cdr
) {

    try {
        $objfirma = new Signature();

        $flg_firma = 0; //Posicion del XML: 0 para firma

        $ruta = $ruta_archivo_xml . $nombre . '.XML';

        $ruta_firma = $rutacertificado . $emisor['ruc'] . '/' . $emisor['ruc'] . '.pfx'; //ruta del archivo del certicado para firmar
        $pass_firma = $emisor['pass_firma'];

        //==================================================================
        //firma
        $resp = $objfirma->signature_xml(
                $flg_firma,
                $ruta,
                $ruta_firma,
                $pass_firma
        );

        $zip = new ZipArchive();

        $nombrezip = $nombre . ".zip";

        $rutazip = $ruta_archivo_xml . $nombre . ".zip";

        if ($zip->open($rutazip, ZipArchive::CREATE) === TRUE) {
            $zip->addFile($ruta, $nombre . '.XML');
            $zip->close();
        }


        //==================================================================
        //ROMMEL MERCADO
        //19-12-2021
        //SE OBTIENE EL WSDL DESDE LA BD PARA LA DECLARACION A SUNAT
        $ws = $emisor['sunat_despatch'];
        //var_dump($ws);
        //==================================================================

        $ruta_archivo = $rutazip;
        $nombre_archivo = $nombrezip;

        //==================================================================
        $contenido_del_zip = base64_encode(file_get_contents($ruta_archivo)); //codificar y convertir en texto el .zip
        // echo '</br> ' . $contenido_del_zip . "<br>";
        //==================================================================
        $xml_envio = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.sunat.gob.pe" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
                    <soapenv:Header>
                    <wsse:Security>
                        <wsse:UsernameToken>
                            <wsse:Username>' . $emisor['ruc'] . $emisor['usuario_sol'] . '</wsse:Username>
                            <wsse:Password>' . $emisor['clave_sol'] . '</wsse:Password>
                        </wsse:UsernameToken>
                    </wsse:Security>
                    </soapenv:Header>
                    <soapenv:Body>
                    <ser:sendBill>
                        <fileName>' . $nombre_archivo . '</fileName>
                        <contentFile>' . $contenido_del_zip . '</contentFile>
                    </ser:sendBill>
                    </soapenv:Body>
                </soapenv:Envelope>';
        //var_dump($xml_envio);
        //==================================================================
        $header = array(
            "Content-type: text/xml; charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: ",
            "Content-lenght: " . strlen($xml_envio)
        );
        //var_dump($header);
        //==================================================================

        $ch = curl_init(); //iniciar la llamada
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1); //
        curl_setopt($ch, CURLOPT_URL, $ws);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_envio);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        //para ejecutar los procesos de forma local en windows
        //enlace de descarga del cacert.pem https://curl.haxx.se/docs/caextract.html
        // curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . "/" . $emisor['ruc'] . '/' .  $emisor['ruc'] . ".pem"); //solo en local, si estas en el servidor web con ssl comentar esta lÃ­nea

        $response = curl_exec($ch); // ejecucion del llamado y respuesta del WS SUNAT.
        //var_dump($response);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // objten el codigo de respuesta de la peticion al WS SUNAT
        $estadofe = "0"; //inicializo estado de operaciÃ³n interno
        
        if ($httpcode == 200) { //200: La comunicacion fue satisfactoria
            $doc = new DOMDocument(); //clase que nos permite crear documentos XML
            $doc->loadXML($response); //cargar y crear el XML por medio de text-xml response

            if (isset($doc->getElementsByTagName('applicationResponse')->item(0)->nodeValue)) { // si en la etique de rpta hay valor entra
                $cdr = $doc->getElementsByTagName('applicationResponse')->item(0)->nodeValue; //guadarmos la respuesta(text-xml) en la variable 
                $cdr = base64_decode($cdr); //decodificando el xml
                file_put_contents($ruta_archivo_cdr . 'R-' . $nombrezip, $cdr); //guardo el CDR zip en la carpeta cdr
                $zip = new ZipArchive();
                if ($zip->open($ruta_archivo_cdr . 'R-' . $nombrezip) === true) { //rpta es identica existe el archivo
                    $zip->extractTo($ruta_archivo_cdr, 'R-' . $nombre . '.XML');
                    $zip->close();
                }

                //VERIFICAR RESPUEST DEL CDR
                $xml_cdr = simplexml_load_file($ruta_archivo_cdr . 'R-' . $nombre . '.XML');
                $xml_cdr->registerXPathNamespace('c', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

                $DocumentResponse = array();

                $ReferenceID = $xml_cdr->xpath('//c:ReferenceID');
                $ResponseCode = $xml_cdr->xpath('//c:ResponseCode');
                $Description = $xml_cdr->xpath('//c:Description');
                $Notes = $xml_cdr->xpath('//c:Note');

                $DocumentResponse['ReferenceID'] = (string) $ReferenceID[0];
                $DocumentResponse['ResponseCode'] = (string) $ResponseCode[0];
                $DocumentResponse['Description'] = (string) $Description[0];

                if (count($Notes) > 0) {
                    foreach ($Notes as $note) {
                        $DocumentResponse['Notes'][] = (string) $note[0];
                    }
                }
                //FIN DE VERIFICACION DE RESPUESTA DEL CDR
                if ($DocumentResponse['ResponseCode'] == 0) {
                    $estado = 1;
                } else {
                    $estado = 0;
                }

                $response_array['data'] = $DocumentResponse;
                $response_array['data']['hash'] = $resp['hash_cpe'];
                $response_array['data']['status'] = $estado;
                curl_close($ch);
                return $response_array['data'];
            } else {

                $estadofe = '2';
                //var_dump($doc);
                $codigo = $doc->getElementsByTagName('faultcode')->item(0)->nodeValue;
                //$mensaje = $doc->getElementsByTagName('faultstring')->item(0)->nodeValue;
                $mensaje = $doc->textContent;

                $cadena_de_texto = $mensaje;
                $cadena_buscada = 'registrado';
                $posicion_coincidencia = strpos($cadena_de_texto, $cadena_buscada);

                if ($posicion_coincidencia) {
                    $status = 1;
                    $ResponseCode = '0';
                } else {
                    $status = '0';
                    $ResponseCode = '-1';
                }

                $DocumentResponse = array();
                $DocumentResponse['Description'] = $mensaje;
                $DocumentResponse['ResponseCode'] = $ResponseCode;
                $DocumentResponse['status'] = $status;
                $DocumentResponse['hash'] = '';
                $response_array['data'] = $DocumentResponse;
                curl_close($ch);
                return $response_array['data'];
            }
        } else {
            $estadofe = "3";
            //echo '$ch = ' . curl_error($ch) . "<br>";
            //echo 'Hubo existe un problema de conexiÃ³n';

            $DocumentResponse = array();
            $DocumentResponse['Description'] = curl_error($ch);
            $DocumentResponse['ResponseCode'] = "-2";
            $DocumentResponse['status'] = 0;
            $response_array['data'] = $DocumentResponse;
            return $response_array['data'];
        }
        curl_close($ch);
    } catch (Error $e) {
        $DocumentResponse = array();
        $DocumentResponse['Description'] = 'ERROR: ' . $e;
        $DocumentResponse['ResponseCode'] = "-3";
        $DocumentResponse['status'] = 0;
        $response_array['data'] = $DocumentResponse;
        return $response_array['data'];
    }
}


 /**
     * 
     * @param type $emisor
     * @param type $nombre
     * @param type $rutacertificado
     * @param type $ruta_archivo_xml
     * @param type $ruta_archivo_cdr
     * @return string|int
     */
    public function EnviarGuiaElectronicaApi(
        $emisor,
        $nombre,
        $rutacertificado,
        $ruta_archivo_xml,
        $ruta_archivo_cdr
) {

    try {
        $objfirma = new Signature();
        $flg_firma = 0;
        $ruta = $ruta_archivo_xml . $nombre . '.xml';
        $ruta_firma = $rutacertificado . $emisor['ruc'] . '/' . $emisor['ruc'] . '.pfx';
        $pass_firma = $emisor['pass_firma'];
        //==================================================================
        //firma
        $resp = $objfirma->signature_xml(
                $flg_firma,
                $ruta,
                $ruta_firma,
                $pass_firma
        );

        $zip = new ZipArchive();
        $nombrezip = $nombre . ".zip";
        $rutazip = $ruta_archivo_xml . $nombre . ".zip";

        if ($zip->open($rutazip, ZipArchive::CREATE) === TRUE) {
            $zip->addFile($ruta, $nombre . '.xml');
            $zip->close();
        }

        $ruta_archivo = $rutazip;
        $nombre_archivo = $nombrezip;

        //==================================================================
        $arcGreZip = base64_encode(file_get_contents($ruta_archivo)); //codificar y convertir en texto el .zip
        $hashZip = hash_file('sha256', $ruta_archivo);
        //==================================================================
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'api-sunat.sap-ti.com/despatch/sendonline',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'ruc' => $emisor['ruc'],
                'despatchKey' => $nombre,
                'nomArchivo' => $nombrezip,
                'arcGreZip' => $arcGreZip,
                'hashZip' => $hashZip,
                'consult' => 'true'),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($response);
        $estadofe = "0";
        var_dump($result);
        //==================================================================
        if ($result->data->codRespuesta == '0') {
            
            $cdr = base64_decode($result->data->arcCdr);

            //var_dump($result->data->arcCdr);
            file_put_contents($ruta_archivo_cdr . 'R-' . $nombrezip, $cdr);
            $zip = new ZipArchive();
            if ($zip->open($ruta_archivo_cdr . 'R-' . $nombrezip) === true) {
                $zip->extractTo($ruta_archivo_cdr, 'R-' . $nombre . '.xml');
                $zip->close();
            }
            /*
            //VERIFICAR RESPUEST DEL CDR
            $xml_cdr = simplexml_load_file($ruta_archivo_cdr . 'R-' . $nombre . '.xml');
            $xml_cdr->registerXPathNamespace('c', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

            $DocumentResponse = array();
            $ReferenceID = $xml_cdr->xpath('//c:ReferenceID');
            $ResponseCode = $xml_cdr->xpath('//c:ResponseCode');
            $Description = $xml_cdr->xpath('//c:Description');
            $Notes = $xml_cdr->xpath('//c:Note');          

            if (count($Notes) > 0) {
                foreach ($Notes as $note) {
                    $DocumentResponse['Notes'][] = (string) $note[0];
                }
            }
            //FIN DE VERIFICACION DE RESPUESTA DEL CDR
           */
            
            $DocumentResponse = array();
            $DocumentResponse['ReferenceID'] = (string) $result->data->codRespuesta;
            $DocumentResponse['ResponseCode'] = (string) "0";
            $DocumentResponse['Description'] = (string) "El Comprobante numero " . substr($nombre,15,15) ." ha sido aceptado";
            $response_array['data'] = $DocumentResponse;
            $response_array['data']['hash'] = "";
            $response_array['data']['status'] = 1;
            return $response_array['data'];
        } else {
            $DocumentResponse = array();
            $DocumentResponse['ReferenceID'] = (string) $result->data->codRespuesta;
            $DocumentResponse['ResponseCode'] = (string) $result->data->numError;
            $DocumentResponse['Description'] = (string) "ERROR CPE: ".$result->data->error->desError;
            $response_array['data'] = $DocumentResponse;
            $response_array['data']['hash'] = "";
            $response_array['data']['status'] = 1;
            return $response_array['data'];
        }
    } catch (Error $e) {
        $DocumentResponse = array();
        $DocumentResponse['Description'] = 'ERROR SEND: ' . $e;
        $DocumentResponse['ResponseCode'] = "-3";
        $DocumentResponse['status'] = 0;
        $response_array['data'] = $DocumentResponse;
        return $response_array['data'];
    }
}

}