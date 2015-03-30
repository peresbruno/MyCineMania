<?php
	class ParticipantesController {

		private static function sendMailAprovacao($email, $nome){
			//Create a new PHPMailer instance
			$mail = new PHPMailer;

			//Tell PHPMailer to use SMTP
			$mail->isSMTP();

			//Enable SMTP debugging
			// 0 = off (for production use)
			// 1 = client messages
			// 2 = client and server messages
			$mail->SMTPDebug = 0;

			//Ask for HTML-friendly debug output
			$mail->Debugoutput = 'html';

			//Set the hostname of the mail server
			$mail->Host = 'smtp.gmail.com';

			//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
			$mail->Port = 587;

			//Set the encryption system to use - ssl (deprecated) or tls
			$mail->SMTPSecure = 'tls';

			//Whether to use SMTP authentication
			$mail->SMTPAuth = true;

			//Username to use for SMTP authentication - use full email address for gmail
			$mail->Username = "mycinemania@gmail.com";

			//Password to use for SMTP authentication
			$mail->Password = "mycine123";

			//Set who the message is to be sent from
			$mail->setFrom('mycinemania@gmail.com', 'MyCineMania');

			//Set who the message is to be sent to
			$mail->addAddress($email, $nome);

			//Set the subject line
			$mail->Subject = 'Programa MyCineMania';

			//Read an HTML message body from an external file, convert referenced images to embedded,
			//convert HTML into a basic plain-text alternative body
			$mail->msgHTML('Olá. Sua inscrição no programa MyCine Mania, foi aprovada. Ela é válida até ' . date('d/m/Y', strtotime('+1 years')) . '. Att.');

			//Replace the plain text body with one created manually
			$mail->AltBody = 'This is a plain-text message body';


			//send the message, check for errors
			return $mail->send();

			
		}

		private static function sendMail($email, $nome){
			//Create a new PHPMailer instance
			$mail = new PHPMailer;

			//Tell PHPMailer to use SMTP
			$mail->isSMTP();

			//Enable SMTP debugging
			// 0 = off (for production use)
			// 1 = client messages
			// 2 = client and server messages
			$mail->SMTPDebug = 2;

			//Ask for HTML-friendly debug output
			$mail->Debugoutput = 'html';

			//Set the hostname of the mail server
			$mail->Host = 'smtp.gmail.com';

			//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
			$mail->Port = 587;

			//Set the encryption system to use - ssl (deprecated) or tls
			$mail->SMTPSecure = 'tls';

			//Whether to use SMTP authentication
			$mail->SMTPAuth = true;

			//Username to use for SMTP authentication - use full email address for gmail
			$mail->Username = "mycinemania@gmail.com";

			//Password to use for SMTP authentication
			$mail->Password = "mycine123";

			//Set who the message is to be sent from
			$mail->setFrom('mycinemania@gmail.com', 'MyCineMania');

			//Set who the message is to be sent to
			$mail->addAddress($email, $nome);

			//Set the subject line
			$mail->Subject = 'Programa MyCineMania';

			//Read an HTML message body from an external file, convert referenced images to embedded,
			//convert HTML into a basic plain-text alternative body
			$mail->msgHTML('Olá, segue em anexo o boleto bancário referente ao pagamento da sua inscrição no programa MyCineMania. Att.');

			//Replace the plain text body with one created manually
			$mail->AltBody = 'This is a plain-text message body';
			
			$conf = SettingsQuery::create()->findPK('1');

			$filename = time() . "boleto.html";

			copy(dirname(__FILE__) . "/boleto.html", dirname(__FILE__) . "/" . $filename);

			$content = file_get_contents(dirname(__FILE__) . "/" . $filename);

			$content = str_replace('#VALOR#', $conf->getValorInscricao(), $content);

			$content = str_replace('#VENCIMENTO#', date('d/m/Y', strtotime('+1 days')), $content);

			file_put_contents(dirname(__FILE__) . "/" . $filename, $content);

			$content = dirname(__FILE__) . "/" . $filename;

			$mail->addAttachment($content);


			//send the message, check for errors
			return $mail->send();

			
		}

		private static function getParticipante	($id) {
			$participante = ParticipanteQuery::create()->select(array(
				'id' => 'Id',
				'cpf' => 'Cpf',
				'fim_validade' => 'FimValidade',
				'nome' => 'Nome',
				'sobrenome' => 'Sobrenome'
			))
			->join('Usuario')
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
			
			$preferencias = $postData['preferencias'];

			$participante = new Participante();
			$participante->fromArray($postData);

			$usuario = new Usuario();
			$usuario->setDataInscricao('now');
			$usuario->setTipo('participante');
			$usuario->fromArray($postData);

			$usuario->setSenha(md5($postData['Senha']));

			$participante->setUsuario($usuario);
			
			try {

				if (!$usuario->validate() || !$participante->validate()) {

					$failures = array();
					$erros = array();
					$failures = $usuario->getValidationFailures();
					
				  foreach ($failures as $failure) {
				  	$campo = $failure->getPropertyPath();
				  	if ($campo == 'email')
				  		$campo = 'E-mail';
				  	else if ($campo == 'cpf')
				  		$campo = 'CPF';
				  	else if ($campo == 'nome_usuario')
				  		$campo = 'Nome de usuário';
				  		
				  	array_push($erros, $campo . ' já cadastrado.');
	        }

					$failures = $participante->getValidationFailures();
					
				  foreach ($failures as $failure) {
				  	$campo = $failure->getPropertyPath();
				  	if ($campo == 'email')
				  		$campo = 'E-mail';
				  	else if ($campo == 'cpf')
				  		$campo = 'CPF';
				  	else if ($campo == 'nome_usuario')
				  		$campo = 'Nome de usuário';

				  	array_push($erros, $campo . ' já cadastrado.');
	        }

	        $erros = array('erros' => $erros);

					header( $_SERVER["SERVER_PROTOCOL"] . ' 400 Bad Request');
					die(json_encode($erros));
				}
				else {
					$participante->save();	
					foreach ($preferencias as $preferenciaId) {
						$participantePreferencia = new ParticipantesPreferencias();
						$participantePreferencia->setParticipanteId($participante->getId());
						$participantePreferencia->setPreferenciaId($preferenciaId);
						$participantePreferencia->save();	
					}
				}

				$participante = ParticipantesController::getParticipante($participante->getId());
				ParticipantesController::sendMail($participante['Email'], $participante['Nome'] . ' ' . $participante['Sobrenome']);
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


			$participante = ParticipanteQuery::create()->filterById($postData['Id'])->findOne();
		
			unset($postData['Id']);

			$participante->fromArray($postData);
			$participante->getUsuario()->fromArray($postData);
			$participante->setFimValidade(date('Y-m-d', strtotime('+1 years')));

			try {
				$participante->save();	
				$participante = ParticipantesController::getParticipante($participante->getId());
				ParticipantesController::sendMailAprovacao($participante['Email'], $participante['Nome'] . ' ' . $participante['Sobrenome']);
				header( $_SERVER["SERVER_PROTOCOL"] . ' 200 OK');
				die(json_encode($participante));
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