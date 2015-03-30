<?php
	class ConfiguracoesController {
		public static function get() {
			$config = SettingsQuery::create()
			->select (
				array(
					'id' => 'Id',
					'valor_inscricao' => 'ValorInscricao'
				)
			)
			->findOne();

			if ($config) {
				header( $_SERVER["SERVER_PROTOCOL"] . ' 200 OK');
				die(json_encode($config));
			}
			else {
			header( $_SERVER["SERVER_PROTOCOL"] . ' 204 No Content');
			exit;	  	
			}
		}

		public static function update() {
			$postData = file_get_contents("php://input");
			$postData = json_decode($postData, true);

			SettingsQuery::create()
			->filterById('1')
			->update(array('ValorInscricao' => $postData['ValorInscricao']));

			ConfiguracoesController::get();
		}
	}
?>