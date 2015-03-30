myCineMania.controller('ValidarVoucherCtrl', function ($scope, VouchersResource, SweetAlert) {

	$scope.codigo = {valor : ''};

	$scope.voucher = {};

	$scope.registrarUso = function () {
		$scope.voucher.Status = 'utilizado';
		$scope.voucher.$update().then(
			function ( data ) {
				SweetAlert.swal("Uso do voucher registrado", null, "success");
			}, function ( err ) {
				SweetAlert.swal("Erro ao registrar utilização do voucher", null, "error");
			}
		);
	}

	$scope.buscar = function () {
		if (!$scope.codigo.valor) {
			SweetAlert.swal("Digite o código do voucher", null, "error");
			return;
		}
			
		VouchersResource.get( { codigo : $scope.codigo.valor } ).$promise.then(
			function ( data ) {
				if (!data.Id) {
					SweetAlert.swal("Voucher não localizado", null, "error");
					$scope.voucher = {};
				}
				else
					$scope.voucher = data;				
			}, function ( err ) {
				SweetAlert.swal("Ocorreu um erro ao buscar pelo voucher", null, "error");
			}
		);
	}
});