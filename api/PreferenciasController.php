<?php
	class PreferenciasController {

		public static function getPreferencia($id) {
			$rede = PreferenciaQuery::create()->select(array(
				'id' => 'Id',
				'descricao' => 'Descricao'
			))
			->join('Usuario')
			->filterById($id)
			->findOne();

			return $rede;
		}
		
		public static function post() {

			$postData = file_get_contents("php://input");
			$postData = json_decode($postData, true);

			$preferencia = new Preferencia();
			$preferencia->fromArray($postData);
			try {
				if (!$preferencia->validate()) {

					$failures = array();
					$erros = array();
					$failures = $preferencia->getValidationFailures();
					
				  foreach ($failures as $failure) {

				  	$campo = $failure->getPropertyPath();
				  	
				  	if ($campo == 'descricao')
				  		$campo = 'Descrição';

				  	array_push($erros, $campo . ' já cadastrada.');
	        }

	        $erros = array('erros' => $erros);

					header( $_SERVER["SERVER_PROTOCOL"] . ' 400 Bad Request');
					die(json_encode($erros));
				}
				$preferencia->save();
				header( $_SERVER["SERVER_PROTOCOL"] . ' 201 Created');
				die($preferencia->toJSON());
			} catch (Exception $e) {
				header( $_SERVER["SERVER_PROTOCOL"] . ' 204 No Content');
				exit;
			}

		}

		public static function get($id) {
			$preferencia = PreferenciasController::getPreferencia($id);
			if ($preferencia) {
				header( $_SERVER["SERVER_PROTOCOL"] . ' 200 OK');
				die( json_encode( $preferencia ) );
			}
			else {
				header( $_SERVER["SERVER_PROTOCOL"] . ' 204 No Content');
				exit;
			}
		}

		public static function getAll() {
			$preferencias = PreferenciaQuery::create()
			->select(
				array(
					'id' => 'Id',
					'descricao' => 'Descricao'
				)
			)
		  ->find()->toArray();

		  if ($preferencias) {
				header( $_SERVER["SERVER_PROTOCOL"] . ' 200 OK');
				die(json_encode($preferencias));
		  }
		  else {
				header( $_SERVER["SERVER_PROTOCOL"] . ' 204 No Content');
				exit;	  	
		  }
		}
	}

?>