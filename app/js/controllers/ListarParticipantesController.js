myCineMania.controller('ListarParticipantesCtrl', function ($scope, participantes, SweetAlert) {
	$scope.participantes = participantes;
	$scope.aprovar = function (participante) {
		participante.Liberado = true;
		participante.$update().then(
			function (data) {
				SweetAlert.swal("O participante foi aprovado!", null, "success");
			},
			function (err) {
				SweetAlert.swal("Ocorreu um erro ao aprovar o participante", null, "error");
			}
		);		
	}
});