<?php
	class BeneficiosController {

		public static function post() {
			$usuario = PerfilController::getUsuario();

			if($usuario['Tipo'] !== 1) {
				header( $_SERVER["SERVER_PROTOCOL"] . ' 401 Unauthorized');
				exit;				
			}

			$postData = file_get_contents("php://input");
			$postData = json_decode($postData, true);

			var_dump($postData);
			die();

			
			$voucher = new Voucher();

			$voucher->setDataEmissao('now');
			$voucher->setHoraEmissao('now');
			$codigo = time() . "";
			$codigo = substr($codigo, 0, 9) . $usuario['Id'];
			
			$voucher->setRedeCinemaId($usuario['Id']);
			$voucher->setCodigo($codigo);
			$voucher->setBeneficioId($postData['Id']);


			try {
				$beneficio->save();
				$beneficio = BeneficiosController::getBeneficio($beneficio->getId());
				header( $_SERVER["SERVER_PROTOCOL"] . ' 201 Created');
				die(json_encode($beneficio));
			} catch (Exception $e) {
				var_dump($e);
				header( $_SERVER["SERVER_PROTOCOL"] . ' 500 Internal Server Error');
				exit;
			}
		}
	}

?>