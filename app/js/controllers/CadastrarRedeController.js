myCineMania.controller('CadastrarRedeCtrl', function ($scope, rede, SweetAlert) {
	$scope.rede = rede;

	$scope.opcoes = {politica_privacidade: false, regulamento: false}

	$scope.senhasIguais = function () {
		return $scope.rede.Senha === $scope.rede.RepetirSenha;
	}

	$scope.emailsIguais = function () {
		return $scope.rede.Email === $scope.rede.RepetirEmail;
	}

	$scope.salvar = function () {

		if ($scope.cadastroRede.$invalid) {
			if($scope.cadastroRede.nome.$error.required) {
				SweetAlert.swal("Ocorreu um erro ao salvar!", "Campo obrigatório não preenchido: \"Nome\"", "error");
			}
			else if($scope.cadastroRede.sobrenome.$error.required) {
				SweetAlert.swal("Ocorreu um erro ao salvar!", "Campo obrigatório não preenchido: \"Sobrenome\"", "error");
			}
			else if($scope.cadastroRede.usuario.$error.required) {
				SweetAlert.swal("Ocorreu um erro ao salvar!", "Campo obrigatório não preenchido: \"Usuário\"", "error");
			}
			else if($scope.cadastroRede.senha.$error.required) {
				SweetAlert.swal("Ocorreu um erro ao salvar!", "Campo obrigatório não preenchido: \"Senha\"", "error");
			}
			else if($scope.cadastroRede.repetirSenha.$error.required) {
				SweetAlert.swal("Ocorreu um erro ao salvar!", "Campo obrigatório não preenchido: \"Repetir senha\"", "error");
			}
			else if($scope.cadastroRede.email.$error.required) {
				SweetAlert.swal("Ocorreu um erro ao salvar!", "Campo obrigatório não preenchido: \"E-mail\"", "error");
			}  
			else if($scope.cadastroRede.email.$invalid) {
				SweetAlert.swal("Ocorreu um erro ao salvar!", "\"E-mail\": valor inválido", "error");
			}
			else if($scope.cadastroRede.repetirEmail.$error.required) {
				SweetAlert.swal("Ocorreu um erro ao salvar!", "Campo obrigatório não preenchido: \"Repetir E-Mail\"", "error");
			}  
			else if($scope.cadastroRede.repetirEmail.$invalid) {
				SweetAlert.swal("Ocorreu um erro ao salvar!", "\"Repetir e-mail\": valor inválido", "error");
			}
			else if($scope.cadastroRede.razaoSocial.$error.required) {
				SweetAlert.swal("Ocorreu um erro ao salvar!", "Campo obrigatório não preenchido: \"Razão Social\"", "error");
			}  
			else if($scope.cadastroRede.nomeFantasia.$error.required) {
				SweetAlert.swal("Ocorreu um erro ao salvar!", "Campo obrigatório não preenchido: \"Nome Fantasia\"", "error");
			}  
			else if($scope.cadastroRede.cnpj.$error.required) {
				SweetAlert.swal("Ocorreu um erro ao salvar!", "Campo obrigatório não preenchido: \"CNPJ\"", "error");
			}
			else if ($scope.cadastroRede.cnpj.$error.invalid)
				SweetAlert.swal("Ocorreu um erro ao salvar!", "\"CNPJ\": valor inválido", "error");
			else if($scope.cadastroRede.endereco.$error.required) {
				SweetAlert.swal("Ocorreu um erro ao salvar!", "Campo obrigatório não preenchido: \"Endereço\"", "error");
			}

			return;
		}

		if(!$scope.senhasIguais()) {
			SweetAlert.swal("Ocorreu um erro ao salvar!", "Senhas digitadas não são iguais.", "error");
		}  
		else if(!$scope.emailsIguais()) {
			SweetAlert.swal("Ocorreu um erro ao salvar!", "E-mails digitados não são iguais.", "error");
		}

		if (!$scope.opcoes.regulamento){
			SweetAlert.swal("Ocorreu um erro ao salvar!", "Você precisa concordar com o regulamento do programa", "error");
			return;
		}

		if (!$scope.opcoes.politica_privacidade) {
			SweetAlert.swal("Ocorreu um erro ao salvar!", "Você precisa concordar com a política de privacidade do programa.", "error");
			return;
		}

		$scope.rede.$save().then(
			function (data) {
				SweetAlert.swal("Cadastro realizado!", "A rede de cinema foi cadastrada. Aguarde sua aprovação.", "success");
			}, function (err) {
				SweetAlert.swal("Ocorreu um erro ao salvar!", err.data.erros[0], "error");
			}
		);
	};
});