<?php
	class BeneficiosController {

		public static function getBeneficio($id) {
			$beneficio = BeneficioQuery::create()
			->select(array(
				'id' => 'Id',
				'titulo' => 'Titulo',
				'inicio_validade' => 'InicioValidade',
				'fim_validade' => 'FimValidade',
				'descricao' => 'Descricao',
				'condicoes' => 'Condicoes',
				'rede_cinema_id' => 'rede_cinema_id'
			))
			->filterById($id)
			->findOne();

			if ($beneficio) {
				$beneficio['RedeCinema'] = RedesCinemaController::getRedeCinema($beneficio['rede_cinema_id']);
				unset($beneficio['rede_cinema_id']);
			}

			return $beneficio;
		}

		public static function post() {
			$usuario = PerfilController::getUsuario();

			if($usuario['Tipo'] !== 1) {
				header( $_SERVER["SERVER_PROTOCOL"] . ' 401 Unauthorized');
				exit;				
			}

			$postData = file_get_contents("php://input");
			$postData = json_decode($postData, true);
			
			$beneficio = new Beneficio();
			$beneficio->fromArray($postData);
			$beneficio->setRedeCinemaId($usuario['Id']);

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

		public static function get ($id) {
			$beneficio = BeneficiosController::getBeneficio($id);

			if ($beneficio) {

				$usuario = PerfilController::getUsuario();
				if ($usuario && $usuario['Tipo'] == 0) {

					$voucher = VoucherQuery::create()
					->filterByParticipanteId($usuario['Id'])
					->filterByBeneficioId($beneficio['Id'])
					->findOne()
					->toArray();

					$beneficio['Emitido'] = !empty($voucher);

				}

				header( $_SERVER["SERVER_PROTOCOL"] . ' 200 OK');
				die(json_encode($beneficio));				
			}
			else {
				header( $_SERVER["SERVER_PROTOCOL"] . ' 204 No Content');
				exit;
			}
		}

		public static function getAll() {
			$beneficios = BeneficioQuery::create()
			->select(array(
				'id' => 'Id',
				'titulo' => 'Titulo',
				'inicio_validade' => 'InicioValidade',
				'fim_validade' => 'FimValidade',
				'descricao' => 'Descricao',
				'condicoes' => 'Condicoes'
			))
			->find()
			->toArray();

		  if ($beneficios) {
				header( $_SERVER["SERVER_PROTOCOL"] . ' 200 OK');
				die(json_encode($beneficios));
		  }
		  else {
				header( $_SERVER["SERVER_PROTOCOL"] . ' 204 No Content');
				exit;	  	
		  }
		}

	}

?>