myCineMania.controller('CadastrarParticipanteCtrl', function ($scope, participante, preferencias, SweetAlert, $state) {
	$scope.participante = participante;
	$scope.participante.preferencias = [];
	$scope.preferencias = preferencias;

	$scope.opcoes = {politica_privacidade: false, regulamento: false}

	$scope.senhasIguais = function () {
		return $scope.participante.Senha === $scope.participante.RepetirSenha;
	}

	$scope.emailsIguais = function () {
		return $scope.participante.Email === $scope.participante.RepetirEmail;
	}

	$scope.salvar = function () {

		if ($scope.cadastroParticipante.$invalid) {
			if ($scope.cadastroParticipante.nome.$error.required)
				SweetAlert.swal("Ocorreu um erro ao salvar!", "Campo obrigatório não preenchido: \"Nome\"", "error");
			else if ($scope.cadastroParticipante.sobrenome.$error.required)
				SweetAlert.swal("Ocorreu um erro ao salvar!", "Campo obrigatório não preenchido: \"Sobrenome\"", "error");
			else if ($scope.cadastroParticipante.usuario.$error.required)
				SweetAlert.swal("Ocorreu um erro ao salvar!", "Campo obrigatório não preenchido: \"Usuário\"", "error");
			else if ($scope.cadastroParticipante.senha.$error.required)
				SweetAlert.swal("Ocorreu um erro ao salvar!", "Campo obrigatório não preenchido: \"Senha\"", "error");
			else if ($scope.cadastroParticipante.repetirSenha.$error.required)
				SweetAlert.swal("Ocorreu um erro ao salvar!", "Campo obrigatório não preenchido: \"Repetir Senha\"", "error");
			else if ($scope.cadastroParticipante.email.$error.required)
				SweetAlert.swal("Ocorreu um erro ao salvar!", "Campo obrigatório não preenchido: \"E-mail\"", "error");
			else if ($scope.cadastroParticipante.email.$invalid)
				SweetAlert.swal("Ocorreu um erro ao salvar!", "\"E-mail\": valor inválido", "error");
			else if ($scope.cadastroParticipante.repetirEmail.$error.required)
				SweetAlert.swal("Ocorreu um erro ao salvar!", "Campo obrigatório não preenchido: \"Repetir e-mail\"", "error");
			else if ($scope.cadastroParticipante.repetirEmail.$invalid)
				SweetAlert.swal("Ocorreu um erro ao salvar!", "\"Repetir e-mail\": valor inválido", "error");
			else if ($scope.cadastroParticipante.cpf.$error.required)
				SweetAlert.swal("Ocorreu um erro ao salvar!", "Campo obrigatório não preenchido: \"CPF\"", "error");
			else if ($scope.cadastroParticipante.cpf.$error.invalid)
				SweetAlert.swal("Ocorreu um erro ao salvar!", "\"CPF\": valor inválido", "error");
			return;
		}

		if (!$scope.senhasIguais()) {
			SweetAlert.swal("Ocorreu um erro ao salvar!", "As senhas digitadas não são iguais", "error");
			return;
		}
		if (!$scope.emailsIguais()) {
			SweetAlert.swal("Ocorreu um erro ao salvar!", "Os e-mails digitados não são iguais", "error");
			return;
		}

		if (!$scope.opcoes.regulamento){
			SweetAlert.swal("Ocorreu um erro ao salvar!", "Você precisa concordar com o regulamento do programa", "error");
			return;
		}

		if (!$scope.opcoes.politica_privacidade) {
			SweetAlert.swal("Ocorreu um erro ao salvar!", "Você precisa concordar com a política de privacidade do programa.", "error");
			return;
		}
			
		$scope.participante.$save().then(
			function (data) {
				SweetAlert.swal("Cadastro realizado!", "Um boleto será gerado e enviado ao seu e-mail.", "success");
				$state.go('login');
			}, function (err) {
				SweetAlert.swal("Ocorreu um erro ao salvar!", err.data.erros[0], "error");
			}
		);
	};
});