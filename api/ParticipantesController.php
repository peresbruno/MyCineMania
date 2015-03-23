<?php
	class ParticipantesController {

		private static function getParticipante	($id) {
			$participante = ParticipanteQuery::create()->select(array(
				'cpf' => 'Cpf',
				'fim_validade' => 'FimValidade',
				'nome' => 'Nome',
				'sobrenome' => 'Sobrenome'
			))
			->join('Usuario')
			->withColumn('Usuario.id', 'Id')
			->withColumn('Usuario.data_inscricao', 'DataInscricao')
			->withColumn('Usuario.email', 'Email')
			->withColumn('Usuario.liberado', 'Liberado')
			->withColumn('Usuario.nome_usuario', 'NomeUsuario')
			->filterById($id)
			->findOne();

			return $participante;
		}
		
		public static function post() {

			$postData = file_get_contents("php://input");
			$postData = json_decode($postData, true);
			$participante = new Participante();
			$participante->fromArray($postData);

			$usuario = new Usuario();
			$usuario->setDataInscricao('now');
			$usuario->setTipo('participante');
			$usuario->fromArray($postData);

			$usuario->setSenha(md5($postData['Senha']));

			$participante->setUsuario($usuario);
			
			try {
				$participante->save();
				$participante = ParticipantesController::getParticipante($participante->getId());
				header( $_SERVER["SERVER_PROTOCOL"] . ' 201 Created');
				die(json_encode($participante));				
			} catch (Exception $e) {
				var_dump($e);
				header( $_SERVER["SERVER_PROTOCOL"] . ' 500 Internal Server Error');
				exit;
			}

		}

		public static function update() {
			$postData = file_get_contents("php://input");
			$postData = json_decode($postData, true);


			$rede = UsuarioQuery::create()->filterById($postData['Id'])->findOne();
			$rede->fromArray($postData);
			$rede->getUsuario()->fromArray($postData);
			$rede->save();
			
			try {
				$redeCinema->update();
				$redeCinema = RedesCinemaController::getRedeCinema($redeCinema->getId());
				header( $_SERVER["SERVER_PROTOCOL"] . ' 200 OK');
				die(json_encode($redeCinema));
			} catch (Exception $e) {
				var_dump($e);
				header( $_SERVER["SERVER_PROTOCOL"] . ' 500 Internal Server Error');
				exit;
			}
		}

		public static function get($id) {
			$participante = ParticipantesController::getParticipante($id);

			if ($participante) {
				header( $_SERVER["SERVER_PROTOCOL"] . ' 200 OK');
				die(json_encode($participante));				
			}
			else {
				header( $_SERVER["SERVER_PROTOCOL"] . ' 204 No Content');
				exit;
			}
		}

		public static function getAll() {

			$participantes = ParticipanteQuery::create()
			->select(
				array(
					'id' => 'Id',
					'cpf' => 'Cpf',
					'fim_validade' => 'FimValidade',
					'nome' => 'Nome',
					'sobrenome' => 'Sobrenome'
				)
			)
			->join('Usuario')
		  ->withColumn('Usuario.data_inscricao', 'DataInscricao')
		  ->withColumn('Usuario.email', 'Email')
		  ->withColumn('Usuario.liberado', 'Liberado')
		  ->withColumn('Usuario.nome_usuario', 'NomeUsuario')
		  ->find()->toArray();

		  if ($participantes) {
				header( $_SERVER["SERVER_PROTOCOL"] . ' 200 OK');
				die(json_encode($participantes));
		  }
		  else {
				header( $_SERVER["SERVER_PROTOCOL"] . ' 204 No Content');
				exit;	  	
		  }
		}
	}

?>