myCineMania.controller('LoginCtrl', function ($scope, $state, PerfilResource, SweetAlert) {

	$scope.credencial = {};

	$scope.login = function () {
		PerfilResource.login($scope.credencial.usuario, $scope.credencial.senha).then(
			function (data) {
				
				if (data.Tipo === 0)
					$state.go('');
				else if (data.Tipo === 1)
					$state.go('cadastrar_beneficio');
				else if (data.Tipo === 2)
					$state.go('');

			}, function () {
				SweetAlert.swal("Usuário e senha inválidos.", null, "error");
			}
		);
	};

});