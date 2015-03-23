myCineMania.controller('CadastrarRedeCtrl', function ($scope, rede) {
	$scope.rede = rede;

	$scope.senhasIguais = function () {
		return $scope.rede.Senha === $scope.rede.RepetirSenha;
	}

	$scope.emailsIguais = function () {
		return $scope.rede.Email === $scope.rede.RepetirEmail;
	}

	$scope.salvar = function () {

		if ($scope.cadastroRede.$invalid || !$scope.emailsIguais() || !$scope.senhasIguais()) {
			$scope.cadastroRede.submetido = true;
		}
		else {
			$scope.rede.$save();	
		}

	}
});