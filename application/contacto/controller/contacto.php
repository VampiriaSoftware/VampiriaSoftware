<?php
/**
* contacto.php
* Controlador para la vista de contacto
* @copyright Copyright (c) 2014 Vampiria Software
* @author José Francisco Montaño Andriano
* @version 1.0
* @link http://www.vampiriasoftware.tk
*/


if (isset($_POST['enviar'])){
	$destinatario = 'info@vampiriasoftware.tk';
	$asunto = $_POST['asunto'];
	$mensaje = $_POST['mensaje'];
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html: charset=iso8859-1\r\n";
	$headers .= "From: " . $_POST['nombre'] . " <" . $_POST['email'] . ">\r\n";
	if (mail($destinatario,$asunto,$mensaje,$headers)){
		header('location: ' . BASEURL . 'contacto/contacto/ok/');
	}
	else{
		header('location: ' . BASEURL . 'contacto/contacto/error/');
	}
}

if (isset($_GET['opcion']))
{
	switch ($_GET['opcion'])
	{
		case 'ok':
			$msj = '<div class="alert alert-success"><span class="fa fa-check"></span> ' . EMAIL_ENVIADO . '</div>';
			break;
		case 'error':
			$msj = '<div class="alert alert-danger"><span class="fa fa-exclamation-triangle"></span> ' . EMAIL_NO_ENVIADO . '</div>';
			break;
	}
}
else{
	$msj = '';
}

require_once BASEPATH . 'application/contacto/view/contacto.phtml';