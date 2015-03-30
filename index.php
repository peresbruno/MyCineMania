<?php
	require_once 'vendor/autoload.php';
	require_once 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
	require_once 'vendor/html2pdf/html2pdf.class.php';
	require_once 'generated-conf/config.php';
	require_once 'api/ParticipantesController.php';
	require_once 'api/PreferenciasController.php';
	require_once 'api/RedesCinemaController.php';
	require_once 'api/PerfilController.php';
	require_once 'api/BeneficiosController.php';
	require_once 'api/VouchersController.php';
	require_once 'api/ConfiguracoesController.php';


	$router = new AltoRouter();

	$router->map('GET', '/perfil', "PerfilController::get");

	$router->map('POST','/preferencias', "PreferenciasController::post");
	$router->map('GET','/preferencias/[i:id]', "PreferenciasController::get");
	$router->map('GET','/preferencias', "PreferenciasController::getAll");

	$router->map('POST','/participantes', "ParticipantesController::post");
	$router->map('GET','/participantes/[i:id]', "ParticipantesController::get");
	$router->map('GET','/participantes', "ParticipantesController::getAll");
	$router->map('PUT','/participantes', "ParticipantesController::update");

	$router->map('POST','/redes_cinema', "RedesCinemaController::post");
	$router->map('GET','/redes_cinema/[i:id]', "RedesCinemaController::get");
	$router->map('GET','/redes_cinema', "RedesCinemaController::getAll");
	$router->map('PUT','/redes_cinema', "RedesCinemaController::update");

	$router->map('GET', '/beneficios', "BeneficiosController::getAll");
	$router->map('GET', '/beneficios/[i:id]', "BeneficiosController::get");
	$router->map('POST', '/beneficios', "BeneficiosController::post");

	$router->map('POST', '/vouchers', "VouchersController::post");	
	$router->map('GET', '/vouchers/[i:id]', "VouchersController::get");	
	$router->map('PUT', '/vouchers', "VouchersController::update");	

	$router->map('GET', '/configuracoes', "ConfiguracoesController::get");	
	$router->map('PUT', '/configuracoes', "ConfiguracoesController::update");	

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
