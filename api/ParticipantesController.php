<?php
	class ParticipantesController {
		
		public static function post() {

			$postData = file_get_contents("php://input");
			$postData = json_decode($postData, true);
			$participante = new Participante();
			$participante->fromArray($postData);

			$usuario = new Usuario();
			$usuario->setDataInscricao('now');
			$usuario->fromArray($postData);

			$participante->setUsuario($usuario);
			
			try {
				$participante->save();
				header( $_SERVER["SERVER_PROTOCOL"] . ' 201 Created');
				die($participante->toJSON());
			} catch (Exception $e) {
				var_dump($e);
				header( $_SERVER["SERVER_PROTOCOL"] . ' 204 No Content');
				exit;
			}

		}

		public static function get($id) {
			$participante = UsuarioQuery::create()->select(array(
				'id'
			))
			->join('Participante')
			->withColumn('data_inscricao', 'DataInscricao')
			->withColumn('email', 'Email')
			->withColumn('liberado', 'Liberado')
			->withColumn('nome_usuario', 'NomeUsuario')
			->withColumn('Participante.cpf', 'Cpf')
			->withColumn('Participante.fim_validade', 'FimValidade')
			->withColumn('Participante.nome', 'Nome')
			->withColumn('Participante.sobrenome', 'Sobrenome')
			->filterById($id)
			->findOne();
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
			header( $_SERVER["SERVER_PROTOCOL"] . ' 200 OK');
			$json = ParticipanteQuery::create()->find()->toJSON();
			die($json);

		}
	}

?>