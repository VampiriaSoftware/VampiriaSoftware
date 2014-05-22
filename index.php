<?php
/**
 * index.php
 * Ruteador principal del sistema
 * @copyright Copyright (c) 2014 Vampiria Software
 * @author José Francisco Montaño Andriano
 * @version 1.0
 * @link http://www.vampiriasoftware.tk
*/

session_start();

require_once 'config.inc.php';

//obtener idioma
if (isset($_SESSION['language']) && !empty($_SESSION['language']))
{
	$language = $_SESSION['language'];
}
else{
	$language = 'es';
}

require_once BASEPATH . 'language/' . $language . '.php';

if (isset($_GET['modulo']) && !empty($_GET['modulo']))
{
	$module = $_GET['modulo'];
	if (isset($_GET['accion']) && !empty($_GET['accion']))
	{
		$action = $_GET['accion'];
	}
	else
	{
		$action = $module;
	}
}
else{
	$module = $action = 'inicio';
}

if (is_file(BASEPATH . 'application/' . $module . '/controller/' . $action . '.php'))
{
	require_once BASEPATH . 'application/' . $module . '/controller/' . $action . '.php';
}
else{
	require_once BASEPATH . 'application/inicio/controller/error404.php';
}