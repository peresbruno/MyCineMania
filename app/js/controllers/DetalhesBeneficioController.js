myCineMania.controller('DetalhesBeneficioCtrl', function ($scope, beneficio, VouchersResource, SweetAlert, $state, localStorageService) {
	$scope.beneficio = beneficio;

	$scope.logado = function () {
		return localStorageService.get('logado');    	
	}

	$scope.tipo = function  () {
		return localStorageService.get('tipo');    
	}

	$scope.emitir = function () {
		var voucher = new VouchersResource;
		voucher.RedeCinemaId = $scope.beneficio.RedeCinema.Id;
		voucher.BeneficioId = beneficio.Id;
		voucher.$save().then(function (data) {
			$state.go('voucher', {codigo : data.VoucherCodigo});
			$scope.beneficio = data;
		}, function (err) {
			SweetAlert.swal("Erro ao emitir voucher!", null, "error");
		});
	}
});