myCineMania.controller('CadastrarParticipanteCtrl', function ($scope, participante, preferencias, SweetAlert, $state, ngDialog) {
	$scope.participante = participante;
	$scope.participante.preferencias = [];
	$scope.preferencias = preferencias;

	$scope.abrirPolitica = function () {
		ngDialog.open(
			{
				template: '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla convallis ut nisi a accumsan. Morbi sit amet dolor ut arcu cursus tristique sit amet in ex. Praesent in felis vel ante commodo faucibus. Ut ligula velit, ultrices id dictum et, commodo nec lectus. In at ultrices enim. Quisque iaculis magna at mauris blandit, eget lobortis risus maximus. Sed efficitur molestie augue, elementum lacinia turpis venenatis ut. Sed dignissim nibh orci, nec luctus augue eleifend a. Etiam facilisis, sapien vel interdum convallis, arcu ex tempus est, quis aliquet tortor ipsum non velit.</p> <p>Duis sit amet justo massa. Maecenas aliquet tortor at tortor tristique, et vestibulum felis cursus. Nam faucibus eros non sem tristique, vehicula facilisis est mollis. Praesent condimentum quam ac mollis consequat. Ut eu nisi nunc. Aliquam dignissim venenatis sem in pharetra. Ut non eros non augue blandit pretium eget vitae ante. Ut vel sollicitudin nisl. Vestibulum finibus risus vel consectetur congue. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. In in ex vel metus convallis ullamcorper a sit amet mauris. In vel nulla vitae mauris accumsan fringilla a in est.<p>',
				plain: true
			}
		);
	}

	var validarCPF = function (cpf) {  
	    cpf = cpf.replace(/[^\d]+/g,'');    
	    if(cpf == '') return false; 
	    // Elimina CPFs invalidos conhecidos    
	    if (cpf.length != 11 || 
	        cpf == "00000000000" || 
	        cpf == "11111111111" || 
	        cpf == "22222222222" || 
	        cpf == "33333333333" || 
	        cpf == "44444444444" || 
	        cpf == "55555555555" || 
	        cpf == "66666666666" || 
	        cpf == "77777777777" || 
	        cpf == "88888888888" || 
	        cpf == "99999999999")
	            return false;       
	    // Valida 1o digito 
	    add = 0;    
	    for (i=0; i < 9; i ++)       
	        add += parseInt(cpf.charAt(i)) * (10 - i);  
	        rev = 11 - (add % 11);  
	        if (rev == 10 || rev == 11)     
	            rev = 0;    
	        if (rev != parseInt(cpf.charAt(9)))     
	            return false;       
	    // Valida 2o digito 
	    add = 0;    
	    for (i = 0; i < 10; i ++)        
	        add += parseInt(cpf.charAt(i)) * (11 - i);  
	    rev = 11 - (add % 11);  
	    if (rev == 10 || rev == 11) 
	        rev = 0;    
	    if (rev != parseInt(cpf.charAt(10)))
	        return false;       
	    return true;   
	}

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

		if (!validarCPF($scope.participante.Cpf)){
			SweetAlert.swal("Ocorreu um erro ao salvar!", "O CPF digitado inválido", "error");
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