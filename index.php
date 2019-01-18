<?php

	/**
	*  Controlador frontal
	*  Matías / 2016
	*/

	// Modifica la zona horaria del servidor.
	date_default_timezone_set('America/Argentina/Buenos_Aires');

	session_start();

	include_once('./constants/main.php');

	$_SESSION['lang'] = !$_SESSION['lang'] ? 'es/' : $_SESSION['lang'];

	function __autoload($class_name) {
		require_once './class/'.$class_name.'.php';
	}

	//---------------------------------------------------------------------------------
	//Prevención de ataques XSS.
	if ( is_array($_POST) ) {
		foreach ($_POST as $key => $value) {
			if ($value && !is_array($value)) {
				$_POST[$key] = htmlentities($value);
				//---------------------------------------------------------------------
				// Prevención del reenvío de formularios: 
				$RequestSignature = md5($_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING'] . print_r($_POST, true));
				if ($_SESSION['LastRequest'] == $RequestSignature) {
					die(header('location:'.INSTALLPATH.'empresa/dashboard'));
				}
				//---------------------------------------------------------------------
			} elseif (is_array($value)) {
				foreach ($value as $key1 => $value1) {
					if (!is_array($value1)) {
						$_POST[$key][$key1] = htmlentities($value1);
					}
				}
			}
		}	
	}
	
	if ( is_array($_GET) ) {
		foreach ($_GET as $key => $value) {
			if ($value && !is_array($value)) {
				$_GET[$key] = htmlentities($value);
			}
		}
	}
	@$_SESSION['LastRequest'] = $RequestSignature;
	//---------------------------------------------------------------------------------

    $url = explode('/', $_SERVER['REQUEST_URI']);
    $newurl = null;

    // Defino las rutas. Si no defino rutas, el default es tal como estaba la url.
    switch (end($url)) {
        case 'product-distribution':
            $newurl = '/corp/products';
            break;
        case 'value-added-services':
            $newurl = '/corp/services';
            break;
        default:
            $newurl = $_SERVER['REQUEST_URI'];
            break;
    }

    $url = explode('/', $newurl);

    $installDir = explode('/', INSTALLPATH);

	$controller = null;
	$method     = null;
	$params     = null;
	$a          = 0;
	$b          = 0;
	$obj        = null;

	foreach ($url as $value) {
		if (!in_array($value, $installDir)) { 
			$a++;
			if ($a == 1) {
				$controller = $value;
			}
			if ($a == 2) {
				$method = $value;
			}
			if ($a > 2) {
				$params[$b] = $value;
				$b++;
			}
		}
	}

	if (file_exists('./class/'.$controller.'.php') && class_exists($controller,true)) {
		$obj = new $controller;
		if (is_object($obj)) {
			if (method_exists($obj, $method)) {
				$obj->$method($_GET,$_POST,$params);
			} else {
				$main = new main();
				$main->notFound();
			}
		} else {
			$main = new main();
			$main->notFound();
		}
	} else {
		header('location:'.INSTALLPATH.'empresa/dashboard');
	}

?>
