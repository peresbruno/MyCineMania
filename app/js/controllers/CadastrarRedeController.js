myCineMania.controller('CadastrarRedeCtrl', function ($scope, rede, SweetAlert, $state) {

	var validarCNPJ = function (cnpj) {
	 
	    cnpj = cnpj.replace(/[^\d]+/g,'');
	 
	    if(cnpj == '') return false;
	     
	    if (cnpj.length != 14)
	        return false;
	 
	    // Elimina CNPJs invalidos conhecidos
	    if (cnpj == "00000000000000" || 
	        cnpj == "11111111111111" || 
	        cnpj == "22222222222222" || 
	        cnpj == "33333333333333" || 
	        cnpj == "44444444444444" || 
	        cnpj == "55555555555555" || 
	        cnpj == "66666666666666" || 
	        cnpj == "77777777777777" || 
	        cnpj == "88888888888888" || 
	        cnpj == "99999999999999")
	        return false;
	         
	    // Valida DVs
	    tamanho = cnpj.length - 2
	    numeros = cnpj.substring(0,tamanho);
	    digitos = cnpj.substring(tamanho);
	    soma = 0;
	    pos = tamanho - 7;
	    for (i = tamanho; i >= 1; i--) {
	      soma += numeros.charAt(tamanho - i) * pos--;
	      if (pos < 2)
	            pos = 9;
	    }
	    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
	    if (resultado != digitos.charAt(0))
	        return false;
	         
	    tamanho = tamanho + 1;
	    numeros = cnpj.substring(0,tamanho);
	    soma = 0;
	    pos = tamanho - 7;
	    for (i = tamanho; i >= 1; i--) {
	      soma += numeros.charAt(tamanho - i) * pos--;
	      if (pos < 2)
	            pos = 9;
	    }
	    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
	    if (resultado != digitos.charAt(1))
	          return false;
	           
	    return true;
	    
	}

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

		if (!validarCNPJ(rede.Cnpj)) {
			SweetAlert.swal("Ocorreu um erro ao salvar!", "CNPJ digitado é inválido.", "error");
			return;
		}

		if(!$scope.senhasIguais()) {
			SweetAlert.swal("Ocorreu um erro ao salvar!", "Senhas digitadas não são iguais.", "error");
			return;
		}  
		else if(!$scope.emailsIguais()) {
			SweetAlert.swal("Ocorreu um erro ao salvar!", "E-mails digitados não são iguais.", "error");
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

		$scope.rede.$save().then(
			function (data) {
				SweetAlert.swal("Cadastro realizado!", "A rede de cinema foi cadastrada. Aguarde sua aprovação.", "success");
				$state.go('login');
			}, function (err) {
				SweetAlert.swal("Ocorreu um erro ao salvar!", err.data.erros[0], "error");
			}
		);
	};
});