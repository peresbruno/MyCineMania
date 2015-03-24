myCineMania.controller('LoginCtrl', function ($scope, $state, PerfilResource, SweetAlert) {

	$scope.credencial = {};

	$scope.login = function () {
		PerfilResource.login($scope.credencial.usuario, $scope.credencial.senha).then(
			function (data) {
				
				if (data.Tipo === 0)
					$state.go('beneficios');
				else if (data.Tipo === 1)
					$state.go('cadastrar_beneficio');
				else if (data.Tipo === 2)
					$state.go('');

			}, function (err) {
				if ( err.data && err.data.erros )
					SweetAlert.swal(err.data.erros[0], null, "error");	
				else
					SweetAlert.swal("Usuário e senha inválidos.", null, "error");
			}
		);
	};

});