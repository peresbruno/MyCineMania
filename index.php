<?php
	require_once 'vendor/autoload.php';
	require_once 'generated-conf/config.php';
	require_once 'api/BaseController.php';
	require_once 'api/ParticipantesController.php';
	require_once 'api/PreferenciasController.php';

	$router = new AltoRouter();


	$router->map('POST','/preferencias', "PreferenciasController::post");
	$router->map('GET','/preferencias/[i:id]', "PreferenciasController::get");
	$router->map('GET','/preferencias', "PreferenciasController::getAll");

	$router->map('POST','/participantes', "ParticipantesController::post");
	$router->map('GET','/participantes/[i:id]', "ParticipantesController::get");

	$match = $router->match();

	if( $match ) {
		if (is_callable( $match['target'] )) {
			if ($match['params'])
				call_user_func_array( $match['target'], $match['params'] ); 
			else
				call_user_func( $match['target'] );
		}
	} else {
		header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
		include_once("404.html");
		exit;
	}

?>
