<?php
	// Dev
	if ($_SERVER['HTTP_HOST']=='localhost') {

		// Límite de tiempo de ejecución en segundos. Si lo pongo en 0, no tiene límite de tiempo.
		set_time_limit(0);
		
		// Errores
		error_reporting(E_ERROR | E_WARNING | E_PARSE);
		
		// Directorio de instalación.
		define('INSTALLPATH','/summa/framework/');

		// Base de datos
		define('DB_HOSTNAME',"localhost");
		define('DB_USERNAME',"root");
		define('DB_PASSWORD',"");
		define('DB_NAME',"summa");

	// Prod
	} else {

		// Límite de tiempo de ejecución.
		set_time_limit(30);

		// Errores
		ini_set('error_reporting', '0');
		ini_set('display_errors', '0');
		error_reporting(0); // Desactivar toda notificación de error.

		// Directorio de instalación.
		define('INSTALLPATH','/summa/framework/');

		// Base de datos
		define('DB_HOSTNAME',"mysql5019.site4now.net");
		define('DB_USERNAME',"9de8bd_mib8911");
		define('DB_PASSWORD',"afEh3226");
		define('DB_NAME',"db_9de8bd_mib8911");
	}
?>