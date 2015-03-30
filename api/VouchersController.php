<?php
	class VouchersController
	 {

		public static function getVoucher($id) {
			$perfil = PerfilController::getUsuario();


			$voucher = VoucherQuery::create()
			->select(array(
					'id' => 'Id',
					'beneficio_id' => 'BeneficioId',
					'status' => 'Status',
					'codigo' => 'Codigo',
					'data_emissao' => 'DataEmissao',
					'hora_emissao' => 'HoraEmissao'
			))
			->filterByCodigo($id);

			if ($perfil['Tipo'] == '1' && $voucher) {
				$beneficio = BeneficioQuery::create()->findPK($voucher['beneficio_id']);
				if ($beneficio->getRedeCinema()->getId() != $perfil['Id'])
					return false;
			}

			return $voucher;
		}

		
		public static function get($id) {

			$voucher = VouchersController::getVoucher($id);
			
			if ($voucher) {
					$voucher['Beneficio'] = BeneficiosController::getBeneficio($voucher['BeneficioId']);
					$data = strtotime($voucher['DataEmissao']);
					$now = time();
					$voucher['Expirado'] = $data > $now;
					header( $_SERVER["SERVER_PROTOCOL"] . ' 200 OK');
					die(json_encode($voucher));				
			}
			else {
				header( $_SERVER["SERVER_PROTOCOL"] . ' 204 No Content');
				exit;
			}
		}

		public static function update () {
			$postData = file_get_contents("php://input");
			$postData = json_decode($postData, true);			

			$voucher = VoucherQuery::create()
			->findPK($postData['Id']);
			
			$voucher->fromArray($postData);

			try {
				$voucher->save();
				VouchersController::get($voucher->getCodigo());
			} catch (Exception $e) {
				header( $_SERVER["SERVER_PROTOCOL"] . ' 500 Internal Server Error');
				exit;
			}
		}

		public static function post() {
			$usuario = PerfilController::getUsuario();

			if($usuario['Tipo'] !== 0) {
				header( $_SERVER["SERVER_PROTOCOL"] . ' 401 Unauthorized');
				exit;				
			}

			$postData = file_get_contents("php://input");
			$postData = json_decode($postData, true);
			
			$voucher = new Voucher();

			$voucher->setDataEmissao('now');
			$voucher->setHoraEmissao('now');
			$codigo = time() . "";
			$codigo = substr($codigo, 0, 9) . $usuario['Id'];
			
			$voucher->setCodigo($codigo);
			$voucher->setBeneficioId($postData['BeneficioId']);
			$voucher->setStatus('emitido');
			$voucher->setParticipanteId($usuario['Id']);

			try {
				$voucher->save();
				header( $_SERVER["SERVER_PROTOCOL"] . ' 201 Created');
				$beneficio = BeneficiosController::getBeneficio($postData['BeneficioId']);
				$beneficio['VoucherCodigo'] = $voucher->getCodigo();

				die(json_encode($beneficio));
			} catch (Exception $e) {
				var_dump($e);
				header( $_SERVER["SERVER_PROTOCOL"] . ' 500 Internal Server Error');
				exit;
			}
		}
	}

?>