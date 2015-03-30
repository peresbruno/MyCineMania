myCineMania.controller('LoginCtrl', function ($scope, $state, PerfilResource, SweetAlert, localStorageService) {

	$scope.credencial = {};

	$scope.login = function () {
		PerfilResource.login($scope.credencial.usuario, $scope.credencial.senha).then(
			function (data) {
				
				if (data.Tipo === 0) {
					$state.go('beneficios');
					localStorageService.set('tipo', 'participante');					
				}
				else if (data.Tipo === 1) {
					$state.go('cadastrar_beneficio');
					localStorageService.set('tipo', 'rede');					
				}
				else if (data.Tipo === 2) {
					$state.go('admin');
					localStorageService.set('tipo', 'admin');					
				}

			}, function (err) {
				if ( err.data && err.data.erros )
					SweetAlert.swal(err.data.erros[0], null, "error");	
				else
					SweetAlert.swal("Usuário e senha inválidos.", null, "error");
			}
		);
	};

});