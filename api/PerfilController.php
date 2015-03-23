<?php
	class PerfilController {
		public static function getUsuario() {
			if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
				$usuario = UsuarioQuery::create()
				->select(array
					(
						'id' => 'Id',
						'data_inscricao' => 'DataInscricao',
						'email' => 'Email',
						'liberado' => 'Liberado',
						'nome_usuario' => 'NomeUsuario',
						'tipo' => 'Tipo'
					)
				)
				->filterByNomeUsuario($_SERVER['PHP_AUTH_USER']) 	
				->filterBySenha(md5($_SERVER['PHP_AUTH_PW']))
				->findOne();

				if ($usuario) {
					if ($usuario['Tipo'] == 0) {
						$usuario = ParticipanteQuery::create()->select(array(
							'cpf' => 'Cpf',
							'fim_validade' => 'FimValidade',
							'nome' => 'Nome',
							'sobrenome' => 'Sobrenome',
						))
						->join('Usuario')
						->withColumn('Usuario.data_inscricao', 'DataInscricao')
						->withColumn('Usuario.email', 'Email')
						->withColumn('Usuario.liberado', 'Liberado')
						->withColumn('Usuario.nome_usuario', 'NomeUsuario')
						->withColumn('Usuario.tipo', 'Tipo')
						->filterByUsuarioId($usuario['Id'])
						->findOne();						
					}
					else if ($usuario['Tipo'] == 1) {
						$usuario = RedeCinemaQuery::create()->select(array(
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
						->withColumn('Usuario.tipo', 'Tipo')
						->filterByUsuarioId($usuario['Id'])
						->findOne();
					}
				}

				return ($usuario ? $usuario : false);
			}
			return false;
		}

		public static function get() {
			$usuario = PerfilController::getUsuario();
			if (!$usuario) {
				header( $_SERVER["SERVER_PROTOCOL"] . ' 401 Unauthorized');
				exit;
			}
			else {
				header( $_SERVER["SERVER_PROTOCOL"] . ' 200 OK');
				die(json_encode($usuario));
			}
		}
	}

?>