myCineMania.controller('DetalhesBeneficioCtrl', function ($scope, beneficio) {
	$scope.beneficio = beneficio;

	$scope.emitir = function () {
		var voucher = new VouchersResource;
		voucher.beneficio = beneficio.Id;
		
	}
});