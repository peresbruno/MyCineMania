myCineMania.controller('ListarRedesCtrl', function ($scope, redes, SweetAlert) {
	$scope.redes = redes;

	$scope.filtroLiberado = function (actual, expected) {
		return expected == undefined || expected == "" || actual == Boolean("true");
	};

	$scope.aprovar = function(rede) {
		rede.Liberado = true;
		rede.$update().then(
			function (data) {
				SweetAlert.swal("Rede de cinema aprovada!", null, "success");
			},
			function (err) {
				SweetAlert.swal("Ocorreu um erro ao aprovar a rede de cinema", null, "error");
			}
		);
	};

});