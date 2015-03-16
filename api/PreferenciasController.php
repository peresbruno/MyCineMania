<?php
	class PreferenciasController {
		
		public static function post() {
			$preferencia = new Preferencia();
			$preferencia->fromArray($_POST);
			try {
				$preferencia->save();
				header( $_SERVER["SERVER_PROTOCOL"] . ' 201 Created');
				die($preferencia->toJSON());
			} catch (Exception $e) {
				header( $_SERVER["SERVER_PROTOCOL"] . ' 204 No Content');
				exit;
			}

		}

		public static function get($id) {
			$preferencia = PreferenciaQuery::create()->findPk($id);
			if ($preferencia) {
				header( $_SERVER["SERVER_PROTOCOL"] . ' 200 OK');
				die($preferencia->toJSON());				
			}
			else {
				header( $_SERVER["SERVER_PROTOCOL"] . ' 204 No Content');
				exit;
			}
		}

		public static function getAll() {
			header( $_SERVER["SERVER_PROTOCOL"] . ' 200 OK');
			$json = PreferenciaQuery::create()->find()->toJSON();
			die($json);

		}
	}

?>