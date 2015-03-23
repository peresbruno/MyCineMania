myCineMania.controller('CadastrarBeneficioCtrl', function ($scope, SweetAlert, beneficio) {

	$scope.beneficio = beneficio;

	$scope.salvar = function () {
		$scope.beneficio.$save().then(
			function (data) {
				SweetAlert.swal("Benefício cadastrado!", null, "success");
			}, function (err) {
				SweetAlert.swal("Erro ao cadastrar benefício.", null, "error");
			}
		);
		
	}

	

});