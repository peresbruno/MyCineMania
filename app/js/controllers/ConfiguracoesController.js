myCineMania.controller('ConfiguracoesCtrl', function ($scope, SweetAlert, configuracoes, preferencias, PreferenciasResource) {

	$scope.preferencia = {value : ""};

	configuracoes.$promise.then(function (data) {
		data.ValorInscricao = parseFloat(data.ValorInscricao);
		$scope.configuracoes = data;
	}, function () {
	
	});

	$scope.preferencias = preferencias;

	$scope.salvarValorInscricao = function () {
		$scope.configuracoes.$update().then(
			function ( data ) {
				data.ValorInscricao = parseFloat(data.ValorInscricao);
				$scope.configuracoes = data;
				SweetAlert.swal("Valor atualizado!", null, "success");
			}, function ( err ) {
				SweetAlert.swal("Erro ao atualizar valor da inscrição", null, "success");
			}
		);
	};

	$scope.salvarPreferencia = function () {
		if (!$scope.preferencia.value) {
			SweetAlert.swal("Ocorreu um erro ao salvar!", "Descrição não pode ser vazia.", "error");
			return;
		}

		var preferencia = new PreferenciasResource;
		preferencia.Descricao = $scope.preferencia.value;

		preferencia.$save().then(
			function ( data ) {
				PreferenciasResource.query().$promise.then(function ( data ) {
					$scope.preferencias = data;
				});
				
			}, function ( err ) {
				SweetAlert.swal("Ocorreu um erro ao salvar!", err.data.erros[0], "error");
			}
		);

	}
	
});