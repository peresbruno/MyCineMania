myCineMania.controller('CadastrarBeneficioCtrl', function ($scope, SweetAlert, beneficio, preferencias, $state) {

	$scope.preferencias = preferencias;
	$scope.beneficio = beneficio;
	$scope.beneficio.preferencias = preferencias;

	$scope.opcoes = { regulamento : false };

	$scope.salvar = function () {

		if ($scope.cadastroBeneficio.$invalid) {
			if ($scope.cadastroBeneficio.titulo.$error.required) {
				SweetAlert.swal("Ocorreu um erro ao salvar!", "Campo obrigatório não preenchido: \"Título\"", "error");
			}
			else if ($scope.cadastroBeneficio.inicioValidade.$error.required) {
				SweetAlert.swal("Ocorreu um erro ao salvar!", "Campo obrigatório não preenchido: \"Início validade\"", "error");
			}
			else if ($scope.cadastroBeneficio.fimValidade.$error.required) {
				SweetAlert.swal("Ocorreu um erro ao salvar!", "Campo obrigatório não preenchido: \"Fim validade\"", "error");
			}
			else if ($scope.cadastroBeneficio.inicioValidade.$invalid) {
				SweetAlert.swal("Ocorreu um erro ao salvar!", "\"Início validade\": Data digitada inválida", "error");
			}
			else if ($scope.cadastroBeneficio.fimValidade.$invalid) {
				SweetAlert.swal("Ocorreu um erro ao salvar!", "\"Fim validade\": Data digitada inválida", "error");
			}
			else if ($scope.cadastroBeneficio.descricao.$error.required) {
				SweetAlert.swal("Ocorreu um erro ao salvar!", "Campo obrigatório não preenchido: \"Descrição\"", "error");
			}
			else if ($scope.cadastroBeneficio.condicoes.$error.required) {
				SweetAlert.swal("Ocorreu um erro ao salvar!", "Campo obrigatório não preenchido: \"Condições\"", "error");
			}
			return;
		}

		if (!$scope.opcoes.regulamento) {
			SweetAlert.swal("Ocorreu um erro ao salvar!", "Você precisa concordar com o regulamento do programa.", "error");
		}

		$scope.beneficio.$save().then(
			function (data) {
				SweetAlert.swal("Benefício cadastrado!", null, "success");
				$state.go('beneficios');
			}, function (err) {
				SweetAlert.swal("Erro ao cadastrar benefício.", null, "error");
			}
		);
		
	}

	

});