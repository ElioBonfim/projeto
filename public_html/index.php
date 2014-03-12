<?php

		// ERROR é definido no .htaccess e define se deve ou não mostrar erros

		if(getenv('ERROR')){ error_reporting(E_ALL | E_STRICT); ini_set('display_errors', getenv('ERROR'));}



		// Incluindo e Iniciando o Bootstrapping.......

			include('../app/bootstrapping.php');

			$bootstrap = new Bootstrap(getenv('LOCAL'));

			$bootstrap ->runApp();