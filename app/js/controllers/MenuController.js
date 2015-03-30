myCineMania.controller('menuController', function ($state, $scope, localStorageService) {
	$scope.tipo = function  () {
		return localStorageService.get('tipo');    
	}

	$scope.logado = function () {
		return localStorageService.get('logado');    	
	}

	$scope.logout = function () {
		localStorage.clear();
		$state.go('login');
	}
});