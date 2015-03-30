myCineMania.factory('PerfilResource', function($http, $resource, $q, localStorageService) {
	var resource = $resource('/perfil');

	resource.login = function (usuario, senha) {
    var deferred = $q.defer();

    var auth = btoa(unescape(encodeURIComponent(usuario + ":" + senha)));
    $http.defaults.headers.common.Authorization = 'Basic ' + auth;

    resource.get().$promise.then(
            function (data) {
                localStorageService.set('auth', auth);
                localStorageService.set('usuario', usuario);
                localStorageService.set('perfil', data);
                localStorageService.set('logado', true);
                deferred.resolve(data);
            },
            function (data) {
                localStorageService.remove('auth');
                localStorageService.remove('usuario');
                localStorageService.remove('perfil');
                localStorageService.set('logado', false);
                delete $http.defaults.headers.common.Authorization;
                deferred.reject(data);
            }
    );

    return deferred.promise;
	};

	return resource;
});