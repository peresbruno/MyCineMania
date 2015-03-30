<?php
	class RedesCinemaController {
		
		public static function getRedeCinema($id) {
			$rede = RedeCinemaQuery::create()->select(array(
				'id' => 'Id',
				'cnpj' => 'Cnpj',
				'nome_fantasia' => 'NomeFantasia',
				'razao_social' => 'RazaoSocial',
				'endereco' => 'Endereco'
			))
			->join('Usuario')
			->withColumn('Usuario.data_inscricao', 'DataInscricao')
			->withColumn('Usuario.email', 'Email')
			->withColumn('Usuario.liberado', 'Liberado')
			->withColumn('Usuario.nome_usuario', 'NomeUsuario')
			->filterById($id)
			->findOne();

			return $rede;
		}

		public static function post() {

			$postData = file_get_contents("php://input");
			$postData = json_decode($postData, true);

			$redeCinema = new RedeCinema();
			$redeCinema->fromArray($postData);

			$usuario = new Usuario();
			$usuario->setDataInscricao('now');
			$usuario->setTipo('rede_cinema');
			$usuario->fromArray($postData);

			$usuario->setSenha(md5($postData['Senha']));

			$redeCinema->setUsuario($usuario);
			
			try {
				if (!$usuario->validate() || !$redeCinema->validate()) {
					$failures = array();
					$erros = array();
					$failures = $usuario->getValidationFailures();
					
				  foreach ($failures as $failure) {

				  	$campo = $failure->getPropertyPath();
				  	if ($campo == 'email')
				  		$campo = 'E-mail';
				  	else if ($campo == 'nome_usuario')
				  		$campo = 'Nome de usuário';

				  	array_push($erros, $campo . ' já cadastrado.');
	        }

					$failures = $redeCinema->getValidationFailures();
					

				  foreach ($failures as $failure) {
				  	$campo = $failure->getPropertyPath();
				  	if ($campo == 'cnpj')
				  		$campo = 'CNPJ';

				  	array_push($erros, $campo . ' já cadastrado.');
	        }

	        $erros = array('erros' => $erros);

					header( $_SERVER["SERVER_PROTOCOL"] . ' 400 Bad Request');
					die(json_encode($erros));
				}

				$redeCinema->save();
				$redeCinema = RedesCinemaController::getRedeCinema($redeCinema->getId());
				header( $_SERVER["SERVER_PROTOCOL"] . ' 201 Created');
				die(json_encode($redeCinema));
			} catch (Exception $e) {
				var_dump($e);
				header( $_SERVER["SERVER_PROTOCOL"] . ' 500 Internal Server Error');
				exit;
			}

		}

		public static function update() {
			$postData = file_get_contents("php://input");
			$postData = json_decode($postData, true);


			$rede = RedeCinemaQuery::create()->filterById($postData['Id'])->findOne();	
		
			unset($postData['Id']);

			$rede->fromArray($postData);
			$rede->getUsuario()->fromArray($postData);

			try {
				$rede->save();	
				$redeCinema = RedesCinemaController::getRedeCinema($rede->getId());
				header( $_SERVER["SERVER_PROTOCOL"] . ' 200 OK');
				die(json_encode($redeCinema));
			} catch (Exception $e) {
				var_dump($e);
				header( $_SERVER["SERVER_PROTOCOL"] . ' 500 Internal Server Error');
				exit;
			}
		}

		public static function get($id) {

			$redeCinema = RedesCinemaController::getRedeCinema($id);

			if ($redeCinema) {
				header( $_SERVER["SERVER_PROTOCOL"] . ' 200 OK');
				die(json_encode($redeCinema));				
			}
			else {
				header( $_SERVER["SERVER_PROTOCOL"] . ' 204 No Content');
				exit;
			}
		}

		public static function getAll() {
			$redes = RedeCinemaQuery::create()
			->select(
				array(
					'id' => 'Id',
					'cnpj' => 'Cnpj',
					'usuario_id' => 'UsuarioId',
					'nome_fantasia' => 'NomeFantasia',
					'razao_social' => 'RazaoSocial',
					'endereco' => 'Endereco'
				)
			)
			->join('Usuario')
		  ->withColumn('Usuario.data_inscricao', 'DataInscricao')
		  ->withColumn('Usuario.email', 'Email')
		  ->withColumn('Usuario.liberado', 'Liberado')
		  ->withColumn('Usuario.nome_usuario', 'NomeUsuario')
		  ->find()->toArray();

		  if ($redes) {
				header( $_SERVER["SERVER_PROTOCOL"] . ' 200 OK');
				die(json_encode($redes));
		  }
		  else {
				header( $_SERVER["SERVER_PROTOCOL"] . ' 204 No Content');
				exit;	  	
		  }
		}
	}

?>