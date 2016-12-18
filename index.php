<?php

// Este código ha de ir antes que cualquier llamada a gettext()

// Definimos el idioma del usuario
// $user_locale = 'en_US';
$user_locale = 'es_MX';

// Establece variables de entorno en el idioma del usuario
putenv("LANGUAGE=$user_locale");
putenv("LANG=$user_locale");  // Por si LANGUAGE falla
// No es recomendable establecer LC_ALL
// http://www.php.net/manual/es/ref.gettext.php#68853
//putenv("LC_ALL=$user_locale");

// En el caso que utilicemos Apache bajo Windows (con XAMPP por
//  ejemplo), la constante no está definido por defecto
if (!defined('LC_MESSAGES')) define('LC_MESSAGES', 5);
// Establece la información de la configuración regional
setlocale(LC_MESSAGES, $user_locale);

// Especifica la ruta a los catálogos de traducción y el "dominio"
// al que pertenecen: el nombre de nuestros archivos MO
bindtextdomain("translate", "./locale");
textdomain("translate");

//	error_reporting(E_ALL);
//	ini_set("display_errors", 1);
// 	var_dump($_POST);

	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root.'/'.'backends/general.php';

	if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();
	
	require_once($root.'/Framework/Mysqli_Tool.php');
	require_once($root.'/Framework/sessionControl.php');
	require_once($root.'/Framework/Connection_Data.php');
	
	$db =  new Mysqli_Tool(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	
	$typesPages = array(1=>"dashboard/", 2=>"dashboard/");
	
	$control = new sessionControl($db,
			'users',
			'user',
			'password',
			'type',
			$typesPages,
			'index.php',
			0);

	require_once $root.'/'.'views/Layout_View.php';
	
	$data 					= $backend->loadBackend('mainSection');
	$data['title'] 			= 'Log In';
	$data['section'] 		= 'log-in';
	$data['template-class'] = 'login-page';
	
	$view 		= new Layout_View($data);
	
	echo $view->printHTMLPage();