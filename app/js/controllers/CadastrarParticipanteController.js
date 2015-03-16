myCineMania.controller('CadastrarParticipanteCtrl', function ($scope, participante) {
	$scope.participante = participante;

	$scope.opcoes = {policita_privacidade: false, regulamento: false}

	$scope.senhasIguais = function () {
		return $scope.participante.Senha === $scope.participante.RepetirSenha;
	}

	$scope.emailsIguais = function () {
		return $scope.participante.Email === $scope.participante.RepetirEmail;
	}

	$scope.salvar = function () {
		if ($scope.cadastroParticipante.$invalid || !$scope.senhasIguais() || !$scope.emailsIguais()) {
			$scope.cadastroParticipante.submetido = true;	
		}
			else
				$scope.participante.$save();
	};
});